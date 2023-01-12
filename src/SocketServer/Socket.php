<?php

namespace Musakov\WebSocketServer\SocketServer;

use Musakov\WebSocketServer\SocketServer\Helpers\Unseal;
use Musakov\WebSocketServer\SocketServer\Interfaces\SocketInterface;

class Socket implements SocketInterface
{
    protected $socket;
    
    /**
     * @var string
     */
    private $receivedData;

    public function __construct($socket)
    {
        $this->socket = $socket;
    }

    public static function create(int $domain = AF_INET, int $type = SOCK_STREAM, int $protocol = SOL_TCP): SocketInterface
    {
        return new static(socket_create($domain, $type, $protocol));
    }

    public function setOption(int $level, int $option, $value): bool
    {
        return socket_set_option($this->socket, $level, $option, $value);
    }

    public function listen()
    {
        socket_listen($this->socket);
    }

    public function select(SocketArray $socketArray): SocketArray
    {
        $newSocketArray = $socketArray->map(function(SocketInterface $socket) {
            return $socket->socket();
        });

        socket_select($newSocketArray, $null, $null, 0, 10);
        
        return new SocketArray(array_map(function($socket) {
            return new Socket($socket);
        }, $newSocketArray));
    }

    public function accept(): SocketInterface
    {
        return new Socket(socket_accept($this->socket));
    }

    public function bind(ServerAddress $serverAddress)
    {
        socket_bind($this->socket, $serverAddress->host(), $serverAddress->port());
    }

    public function read(int $length, int $mode = PHP_BINARY_READ): ?string
    {
        $result = socket_read($this->socket, $length);

        return $result === false ? null : $result;
    }

    public function getPeerName(): string
    {
        socket_getpeername($this->socket, $ip);

        return $ip;
    }

    public function recv(int $length, int $flags = 0): ?int
    {
        $result = socket_recv($this->socket, $data, $length, $flags);
        
        $this->receivedData = $data;

        return $result ?: null;
    }

    public function write(string $message)
    {
        socket_write($this->socket, $message, strlen($message));
    }

    public function close(): void
    {
        socket_close($this->socket);
    }

    /**
     * @return string
     */
    public function getReceivedData(): ?string
    {
        return new Unseal($this->receivedData);
    }

    public function socket()
    {
        return $this->socket;
    }
}

<?php

namespace Musakov\WebSocketServer\SocketServer\Helpers;

use Musakov\WebSocketServer\SocketServer\Interfaces\SocketInterface;
use Musakov\WebSocketServer\SocketServer\ServerAddress;

class Handshake
{
    /**
     * @var ServerAddress
     */
    private $serverAddress;

    public function __construct(ServerAddress $serverAddress)
    {
        $this->serverAddress = $serverAddress;
    }

    public function do(?string $header, SocketInterface $newSocket)
    {
        $headers = [];
        $lines = preg_split("/\r\n/", $header ?: '');
        foreach ($lines as $line) {
            $line = chop($line);
            if (preg_match('/\A(\S+): (.*)\z/', $line, $matches)) {
                $headers[$matches[1]] = $matches[2];
            }
        }

        $secKey = $headers['Sec-WebSocket-Key'];
        $secAccept = base64_encode(pack('H*', sha1($secKey . '258EAFA5-E914-47DA-95CA-C5AB0DC85B11')));
        $buffer = "HTTP/1.1 101 Web Socket Protocol Handshake\r\n" .
            "Upgrade: websocket\r\n" .
            "Connection: Upgrade\r\n" .
            "WebSocket-Origin: {$this->serverAddress->host()}\r\n" .
            "WebSocket-Location: ws://{$this->serverAddress->host()}:{$this->serverAddress->port()}\r\n" .
            "Sec-WebSocket-Accept:$secAccept\r\n\r\n";
        
        $newSocket->write($buffer);
    }
}

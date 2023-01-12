<?php

namespace Musakov\WebSocketServer\SocketServer;

class ServerAddress
{
    /**
     * @var string
     */
    private $host;
    /**
     * @var int 
     */
    private $port;

    public function __construct(string $host, int $port)
    {

        $this->host = $host;
        $this->port = $port;
    }

    /**
     * @return string
     */
    public function host(): string
    {
        return $this->host;
    }

    /**
     * @return int
     */
    public function port(): int
    {
        return $this->port;
    }
}

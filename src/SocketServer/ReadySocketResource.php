<?php

namespace Musakov\WebSocketServer\SocketServer;

use Musakov\WebSocketServer\SocketServer\Interfaces\SocketInterface;

class ReadySocketResource extends Socket implements SocketInterface
{
    public function __construct(SocketInterface $socket, ServerAddress $serverAddress)
    {
        parent::__construct($socket->socket());
        
        $this->setOption( SOL_SOCKET, SO_REUSEADDR, 1);
        $this->bind($serverAddress);
        $this->listen();
    }
}

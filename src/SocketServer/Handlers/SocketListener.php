<?php

namespace Musakov\WebSocketServer\SocketServer\Handlers;

use Musakov\WebSocketServer\SocketServer\Interfaces\SocketInterface;
use Musakov\WebSocketServer\SocketServer\Interfaces\SocketMessageHandlerInterface;
use Musakov\WebSocketServer\SocketServer\SocketArray;
use Musakov\OopStarterPack\Interfaces\RunInterface;

class SocketListener implements RunInterface
{
    /**
     * @var SocketInterface
     */
    private $socket;
    /**
     * @var SocketArray
     */
    private $socketArray;
    /**
     * @var SocketMessageHandlerInterface
     */
    private $newConnectionHandler;
    /**
     * @var SocketMessageHandlerInterface
     */
    private $existingConnectionHandler;
    
    public function __construct(
        SocketInterface               $socket,
        SocketArray                   $socketArray,
        SocketMessageHandlerInterface $newConnectionHandler,
        SocketMessageHandlerInterface $existingConnectionHandler
    )
    {
        $this->socket = $socket;
        $this->socketArray = $socketArray;
        $this->newConnectionHandler = $newConnectionHandler;
        $this->existingConnectionHandler = $existingConnectionHandler;
    }

    public function run()
    {
        $this->socketArray->add($this->socket);
        
        $newSocketArray = $this->socket->select($this->socketArray);

        if ($this->socketArray->contains($this->socket)) {
            $this->newConnectionHandler->handle($newSocketArray);
        }
        
        $this->existingConnectionHandler->handle($newSocketArray);
    }
}

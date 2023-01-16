<?php

namespace Musakov\WebSocketServer\SocketServer\Handlers;

use Musakov\WebSocketServer\SocketServer\Interfaces\HandshakeInterface;
use Musakov\WebSocketServer\SocketServer\Interfaces\PublishInterface;
use Musakov\WebSocketServer\SocketServer\Interfaces\SocketInterface;
use Musakov\WebSocketServer\SocketServer\Interfaces\SocketMessageHandlerInterface;
use Musakov\WebSocketServer\SocketServer\SocketArray;

class NewConnectionsHandler implements SocketMessageHandlerInterface
{
    /**
     * @var SocketInterface
     */
    private $socket;
    /**
     * @var HandshakeInterface 
     */
    private $handshake;
    /**
     * @var PublishInterface
     */
    private $newConnectionPublisher;
    /**
     * @var SocketArray
     */
    private $socketArray;

    public function __construct(
        SocketInterface $socket,
        HandshakeInterface $handshake,
        PublishInterface $newConnectionPublisher,
        SocketArray $socketArray
    )
    {
        $this->socket = $socket;
        $this->handshake = $handshake;
        $this->newConnectionPublisher = $newConnectionPublisher;
        $this->socketArray = $socketArray;
    }

    public function handle(SocketArray $newSocketArray)
    {
        $newSocket = $this->socket->accept();
        $this->socketArray->add($newSocket);
        
        $this->handshake->do($newSocket);
        
        $this->newConnectionPublisher->publish($newSocket);

        $newSocketArray->remove($this->socket);
    }
}

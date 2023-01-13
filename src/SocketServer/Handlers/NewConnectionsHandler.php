<?php

namespace Musakov\WebSocketServer\SocketServer\Handlers;

use Musakov\WebSocketServer\SocketServer\Helpers\Handshake;
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
     * @var Handshake
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
        Handshake $handshake,
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

        $header = $newSocket->read(1024);
        $this->handshake->do($header, $newSocket);
        
        $this->newConnectionPublisher->publish($newSocket);

        $newSocketArray->remove($this->socket);
    }
}

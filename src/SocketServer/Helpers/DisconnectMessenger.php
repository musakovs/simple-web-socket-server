<?php

namespace Musakov\WebSocketServer\SocketServer\Helpers;

use Musakov\WebSocketServer\SocketServer\Interfaces\BroadcastInterface;
use Musakov\WebSocketServer\SocketServer\Interfaces\PublishInterface;
use Musakov\WebSocketServer\SocketServer\Interfaces\SocketInterface;

class DisconnectMessenger implements PublishInterface
{
    /**
     * @var BroadcastInterface
     */
    private $broadcast;

    public function __construct(BroadcastInterface $broadcast)
    {
        $this->broadcast = $broadcast;
    }

    public function publish(SocketInterface $socket)
    {
        $this->broadcast->publish(new Seal([
            'message' => $socket->getPeerName() . ' disconnected'
        ]));
    }
}

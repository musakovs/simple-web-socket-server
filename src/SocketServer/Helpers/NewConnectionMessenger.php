<?php

namespace Musakov\WebSocketServer\SocketServer\Helpers;

use Musakov\WebSocketServer\SocketServer\Interfaces\BroadcastInterface;
use Musakov\WebSocketServer\SocketServer\Interfaces\PublishInterface;
use Musakov\WebSocketServer\SocketServer\Interfaces\SocketInterface;

class NewConnectionMessenger implements PublishInterface
{
    /**
     * @var Broadcast
     */
    private $broadcast;

    public function __construct(
        BroadcastInterface $broadcast
    )
    {
        $this->broadcast = $broadcast;
    }

    public function publish(SocketInterface $socket)
    {
        $this->broadcast->publish(
            new Seal([
                'message' => 'New client ' . $socket->getPeerName() . ' joined',
            ])
        );
    }
}

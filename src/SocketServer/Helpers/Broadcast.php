<?php

namespace Musakov\WebSocketServer\SocketServer\Helpers;

use Musakov\WebSocketServer\SocketServer\Interfaces\BroadcastInterface;
use Musakov\WebSocketServer\SocketServer\Interfaces\SealInterface;
use Musakov\WebSocketServer\SocketServer\Interfaces\SocketInterface;
use Musakov\WebSocketServer\SocketServer\SocketArray;

class Broadcast implements BroadcastInterface
{
    /**
     * @var SocketArray
     */
    private $socketArray;

    public function __construct(SocketArray $socketArray)
    {
        $this->socketArray = $socketArray;
    }
    
    public function publish(SealInterface $message)
    {
        $this->socketArray->map(function(SocketInterface $socket) use ($message) {
            $socket->write($message);
        });
    }
}

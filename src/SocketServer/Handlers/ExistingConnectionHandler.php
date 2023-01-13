<?php

namespace Musakov\WebSocketServer\SocketServer\Handlers;

use Musakov\WebSocketServer\SocketServer\Interfaces\PublishInterface;
use Musakov\WebSocketServer\SocketServer\Interfaces\SocketInterface;
use Musakov\WebSocketServer\SocketServer\SocketArray;
use Musakov\OopStarterPack\Interfaces\Handler;

class ExistingConnectionHandler implements Handler
{
    /**
     * @var PublishInterface
     */
    private $messagePublisher;
    /**
     * @var PublishInterface
     */
    private $disconnectPublisher;
    /**
     * @var SocketArray
     */
    private $socketArray;

    /**
     * @var true
     */
    private $shouldStop = false;

    public function __construct(
        SocketArray      $socketArray,
        PublishInterface $messagePublisher,
        PublishInterface $disconnectPublisher
    )
    {
        $this->messagePublisher = $messagePublisher;
        $this->disconnectPublisher = $disconnectPublisher;
        $this->socketArray = $socketArray;
    }

    /**
     * @param $socket SocketInterface
     * @return void
     */
    public function handle($socket)
    {
        if ($this->shouldStop) {
            return;
        }
        
        if ($socket->recv(1024) >= 1) {
            l('message');
            $this->messagePublisher->publish($socket);

            $this->shouldStop = true;
        } else {
            l('disconnect');
            $socketData = $socket->read(1024, PHP_NORMAL_READ);
            if (is_null($socketData)) {
                $this->disconnectPublisher->publish($socket);
                $this->socketArray->remove($socket);
            }
        }
    }
}

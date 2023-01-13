<?php

namespace Musakov\WebSocketServer\SocketServer\Handlers;

use Musakov\WebSocketServer\SocketServer\Interfaces\PublishInterface;
use Musakov\WebSocketServer\SocketServer\Interfaces\SocketMessageHandlerInterface;
use Musakov\WebSocketServer\SocketServer\SocketArray;
use Musakov\OopStarterPack\Interfaces\Handler;
use Musakov\OopStarterPack\Operators\ForOp\_For;

class ExistingConnectionsHandler implements SocketMessageHandlerInterface
{
    /**
     * @var Handler
     */
    private $newConnectionHandler;

    public function __construct(Handler $newConnectionHandler)
    {
        $this->newConnectionHandler = $newConnectionHandler;
    }
    
    public function handle(SocketArray $newSocketArray)
    {
        (new _For(
            $newSocketArray,
            $this->newConnectionHandler
        ))->run();
    }
}

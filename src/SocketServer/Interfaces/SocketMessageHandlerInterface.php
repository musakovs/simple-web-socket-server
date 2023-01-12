<?php

namespace Musakov\WebSocketServer\SocketServer\Interfaces;

use Musakov\WebSocketServer\SocketServer\SocketArray;

interface SocketMessageHandlerInterface
{
    public function handle(SocketArray $newSocketArray);
}

<?php

namespace Musakov\WebSocketServer\SocketServer\Interfaces;

interface PublishInterface
{
    public function publish(SocketInterface $socket);
}

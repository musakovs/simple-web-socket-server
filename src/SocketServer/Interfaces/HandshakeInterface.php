<?php

namespace Musakov\WebSocketServer\SocketServer\Interfaces;

interface HandshakeInterface
{
    public function do(SocketInterface $socket);
}

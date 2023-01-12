<?php

namespace Musakov\WebSocketServer\SocketServer\Interfaces;

interface BroadcastInterface
{
    public function publish(SealInterface $message);
}

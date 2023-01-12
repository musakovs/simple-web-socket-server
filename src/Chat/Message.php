<?php

namespace Musakov\WebSocketServer\Chat;

class Message
{
    /**
     * @var string
     */
    private $message;
    /**
     * @var User
     */
    private $user;

    public function __construct(string $message, User $user)
    {
        $this->message = $message;
        $this->user = $user;
    }
}

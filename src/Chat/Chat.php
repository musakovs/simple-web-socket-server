<?php

namespace Musakov\WebSocketServer\Chat;

class Chat
{
    private $messages = [];
    
    public function add(Message $message)
    {
        $this->messages[] = $message; 
    }
}

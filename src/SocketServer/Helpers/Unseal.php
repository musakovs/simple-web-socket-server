<?php

namespace Musakov\WebSocketServer\SocketServer\Helpers;

use Musakov\WebSocketServer\SocketServer\Interfaces\SealInterface;

class Unseal implements SealInterface
{
    /**
     * @var string
     */
    private $socketData;

    public function __construct(string $socketData)
    {
        $this->socketData = $socketData;
    }

    public function __toString(): string
    {
        $length = ord($this->socketData[1]) & 127;
        if ($length == 126) {
            $masks = substr($this->socketData, 4, 4);
            $data = substr($this->socketData, 8);
        } elseif ($length == 127) {
            $masks = substr($this->socketData, 10, 4);
            $data = substr($this->socketData, 14);
        } else {
            $masks = substr($this->socketData, 2, 4);
            $data = substr($this->socketData, 6);
        }
        $socketData = '';
        for ($i = 0; $i < strlen($data); ++$i) {
            $socketData .= $data[$i] ^ $masks[$i % 4];
        }
        return $socketData;
    }
}

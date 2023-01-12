<?php

namespace Musakov\WebSocketServer\SocketServer\Helpers;

use Musakov\WebSocketServer\SocketServer\Interfaces\SealInterface;

class Seal implements SealInterface
{
    /**
     * @var array
     */
    private $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function __toString(): string
    {
        $data = $this->data;
        
        array_walk_recursive($data, function (&$value) {
            if ($value instanceof SealInterface) {
                $value = (string)$value;
            }
        });
        
        $socketData = json_encode($data);

        $b1 = 0x80 | (0x1 & 0x0f);
        $length = strlen($socketData);

        if ($length <= 125)
            $header = pack('CC', $b1, $length);
        elseif ($length < 65536)
            $header = pack('CCn', $b1, 126, $length);
        else
            $header = pack('CCNN', $b1, 127, $length);
        
        return $header . $socketData;
    }
}

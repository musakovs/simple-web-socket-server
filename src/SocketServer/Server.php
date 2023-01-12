<?php

namespace Musakov\WebSocketServer\SocketServer;

use Musakov\OopStarterPack\Interfaces\RunInterface;
use Musakov\OopStarterPack\Operators\ForOp\_While;
use Musakov\OopStarterPack\Operators\IfOp\Predicates\Equal;

class Server
{
    /**
     * @var RunInterface
     */
    private $socketListener;

    public function __construct(RunInterface $socketListener)
    {
        $this->socketListener = $socketListener;
    }

    public function run()
    {
        (new _While(
            new Equal(1, 1),
            $this->socketListener
        ))->run();
    }
}

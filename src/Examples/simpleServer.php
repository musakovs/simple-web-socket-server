<?php

use Musakov\WebSocketServer\SocketServer\Handlers\ExistingConnectionsHandler;
use Musakov\WebSocketServer\SocketServer\Handlers\ExistingConnectionHandler;
use Musakov\WebSocketServer\SocketServer\Handlers\NewConnectionsHandler;
use Musakov\WebSocketServer\SocketServer\Handlers\SocketListener;
use Musakov\WebSocketServer\SocketServer\Helpers\Broadcast;
use Musakov\WebSocketServer\SocketServer\Helpers\DisconnectMessenger;
use Musakov\WebSocketServer\SocketServer\Helpers\Handshake;
use Musakov\WebSocketServer\SocketServer\Helpers\Messenger;
use Musakov\WebSocketServer\SocketServer\Helpers\NewConnectionMessenger;
use Musakov\WebSocketServer\SocketServer\ReadySocketResource;
use Musakov\WebSocketServer\SocketServer\Server;
use Musakov\WebSocketServer\SocketServer\ServerAddress;
use Musakov\WebSocketServer\SocketServer\Socket;
use Musakov\WebSocketServer\SocketServer\SocketArray;

require_once 'vendor/autoload.php';

$address = new ServerAddress('127.0.0.1', '10000');
$socket = new ReadySocketResource(Socket::create(), $address);
$array = new SocketArray([]);
$broadcast = new Broadcast($array);

$server = new Server(
    new SocketListener(
        $socket,
        $array,
        new NewConnectionsHandler(
            $socket,
            new Handshake($address),
            new NewConnectionMessenger($broadcast),
            $array
        ),
        new ExistingConnectionsHandler(
            new ExistingConnectionHandler(
                $array,
                new Messenger($broadcast),
                new DisconnectMessenger($broadcast)
            )
        )
    )
);

$server->run();

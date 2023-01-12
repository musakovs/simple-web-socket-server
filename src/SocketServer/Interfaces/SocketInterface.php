<?php

namespace Musakov\WebSocketServer\SocketServer\Interfaces;

use Musakov\WebSocketServer\SocketServer\ServerAddress;
use Musakov\WebSocketServer\SocketServer\SocketArray;

interface SocketInterface
{
    public function socket();
    
    public static function create(int $domain, int $type, int $protocol): SocketInterface;
    
    public function setOption(int $level, int $option, $value): bool;
    
    public function listen();
    
    public function select(SocketArray $socketArray): SocketArray;

    public function accept(): SocketInterface;
    
    public function bind(ServerAddress $serverAddress);

    public function read(int $length, int $mode = PHP_BINARY_READ): ?string;
    
    public function getPeerName(): string;
    
    public function recv(int $length, int $flags = 0): ?int;
    
    public function getReceivedData(): ?string;
    
    public function write(string $message);
    
    public function close(): void;
}

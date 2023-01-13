<?php

namespace Musakov\WebSocketServer\SocketServer;

use Musakov\WebSocketServer\SocketServer\Interfaces\SocketInterface;

class SocketArray implements \Iterator, \Countable
{
    /**
     * @var SocketInterface[]
     */
    private $sockets;
    
    private $current = 0;

    public function __construct(array $sockets)
    {
        $this->sockets = $sockets;
    }
    
    public function count(): int
    {
        return count($this->sockets);
    }
    
    public function replace(array $sockets)
    {
        $existing = array_map(function(SocketInterface $socket) {
            return $socket->socket();
        }, $this->sockets);
        
        $new = [];$i = [];
        
        foreach ($existing as $socket) {
            if (in_array($socket, $sockets)) {
                $i[] = array_search($socket, $sockets);
                $new[] = $this->sockets[array_search($socket, $sockets)];
            }
        }
        
        $this->sockets = $new;
        
        foreach ($sockets as $k => $socket) {
            if (!in_array($k, $i)) {
                $this->add(new Socket($socket));
            }
        }
    }
    
    public function asArray(): array
    {
        return $this->sockets;
    }

    public function contains(SocketInterface $socket): bool
    {
        return in_array($socket, $this->sockets, true);
    }

    public function add(SocketInterface $newSocket)
    {
        if (!in_array($newSocket, $this->sockets, true)) {
            $this->sockets[] = $newSocket;
        }
    }

    public function remove(SocketInterface $socket)
    {
        unset($this->sockets[array_search($socket, $this->sockets)]);
        $this->sockets = array_values($this->sockets);
    }

    public function map(\Closure $callback): array
    {
        return array_map($callback, $this->sockets);
    }

    public function current()
    {
        return $this->sockets[$this->current];
    }

    public function next()
    {
        $this->current++;
    }

    public function key(): int
    {
        return $this->current;
    }

    public function valid(): bool
    {
        return isset($this->sockets[$this->current]);
    }

    public function rewind()
    {
        $this->current = 0;
    }
}

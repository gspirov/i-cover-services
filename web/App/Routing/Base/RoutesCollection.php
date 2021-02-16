<?php

namespace App\Routing\Base;

use App\Routing\Route;
use ArrayAccess;
use Countable;
use JetBrains\PhpStorm\Pure;

class RoutesCollection implements ArrayAccess, Countable
{
    /**
     * @var Route[] $routes
     */
    private array $routes;

    /**
     * @param mixed $offset
     * @return bool
     */
    public function offsetExists(mixed $offset): bool
    {
        return !empty($this->routes[$offset]);
    }

    /**
     * @param mixed $offset
     * @return Route|null
     */
    public function offsetGet(mixed $offset): ?Route
    {
        if (!$this->offsetExists($offset)) {
            return null;
        }

        return $this->routes[$offset];
    }

    /**
     * @param mixed $offset
     * @param mixed $value
     */
    public function offsetSet(mixed $offset, mixed $value)
    {
        $this->routes[$offset] = $value;
    }

    /**
     * @param mixed $offset
     * @return bool
     */
    public function offsetUnset(mixed $offset): bool
    {
        if (!$this->offsetExists($offset)) {
            return false;
        }

        unset($this->routes[$offset]);
        return true;
    }

    /**
     * @return int
     */
    #[Pure]
    public function count(): int
    {
        return count($this->routes);
    }
}
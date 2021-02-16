<?php

namespace App\Http;

use ArrayAccess;
use Exception;

class HeaderBag implements ArrayAccess
{
    /**
     * @var Header[] $headers
     */
    private array $headers = [];

    /**
     * @var bool $readOnly
     */
    private bool $readOnly = false;

    /**
     * @param mixed $offset
     * @return bool
     */
    public function offsetExists(mixed $offset): bool
    {
        return !empty($this->headers[$offset]);
    }

    /**
     * @param mixed $offset
     * @return Header|null
     */
    public function offsetGet(mixed $offset): ?Header
    {
        if (!$this->offsetExists($offset)) {
            return null;
        }

        return $this->headers[$offset];
    }

    /**
     * @param mixed $offset
     * @param mixed $value
     * @throws Exception
     */
    public function offsetSet(mixed $offset, mixed $value)
    {
        if ($this->readOnly) {
            throw new Exception('Headers are read only.');
        }

        if (!$value instanceof Header) {
            throw new Exception('Header should instance of ' . Header::class);
        }

        $this->headers[$offset] = $value;
    }

    /**
     * @param mixed $offset
     * @return bool
     * @throws Exception
     */
    public function offsetUnset(mixed $offset): bool
    {
        if ($this->readOnly) {
            throw new Exception('Headers are read only.');
        }

        if (!$this->offsetExists($offset)) {
            return false;
        }

        unset($this->headers[$offset]);
        return true;
    }

    /**
     * @return Header[]
     */
    public function getAll(): array
    {
        return $this->headers;
    }

    /**
     * @return bool
     */
    public function isReadOnly(): bool
    {
        return $this->readOnly;
    }

    /**
     * @param bool $readOnly
     * @return HeaderBag
     */
    public function setReadOnly(bool $readOnly): self
    {
        $this->readOnly = $readOnly;

        return $this;
    }
}
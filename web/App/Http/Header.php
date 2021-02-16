<?php

namespace App\Http;

use JetBrains\PhpStorm\Pure;

class Header
{
    /**
     * Header constructor.
     * @param string $name
     * @param string $value
     */
    public function __construct(
        private string $name,
        private string $value
    ) {}

    /**
     * @return string
     */
    #[Pure]
    public function __toString(): string
    {
        return sprintf(
            '%s: %s',
            $this->name,
            $this->value
        );
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getValue(): string
    {
        return $this->value;
    }
}
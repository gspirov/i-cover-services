<?php

namespace App\Routing;

class Route
{
    /**
     * Route constructor.
     * @param string $controller
     * @param string $action
     */
    public function __construct(
        private string $controller,
        private string $action
    ) {}

    /**
     * @return string
     */
    public function getController(): string
    {
        return $this->controller;
    }

    /**
     * @return string
     */
    public function getAction(): string
    {
        return $this->action;
    }
}
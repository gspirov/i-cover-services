<?php

namespace App\Base;

abstract class Request
{
    abstract public function handle();

    /**
     * @return string
     */
    abstract public function getRequestPath(): string;
}
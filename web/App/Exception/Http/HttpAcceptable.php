<?php

namespace App\Exception\Http;

interface HttpAcceptable
{
    /**
     * @return int
     */
    public function getStatusCode(): int;
}
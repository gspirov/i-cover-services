<?php

namespace App\Http\Handler;

use Throwable;

interface HandlerInterface
{
    /**
     * @param Throwable $exception
     */
    public function handle(Throwable $exception);
}
<?php

namespace App\Exception\Base;

use App\Exception\Http\HttpAcceptable;
use App\Http\Response;
use Exception;
use JetBrains\PhpStorm\Pure;
use Throwable;

abstract class EntityNotFoundException extends Exception implements HttpAcceptable
{
    #[Pure]
    public function __construct($message = "", Throwable $previous = null)
    {
        parent::__construct($message, Response::NOT_FOUND, $previous);
    }

    /**
     * @return int
     */
    public function getStatusCode(): int
    {
        return Response::NOT_FOUND;
    }
}
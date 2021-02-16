<?php

namespace App\Exception\Http;

use App\Http\Response;
use Exception;
use JetBrains\PhpStorm\Pure;
use Throwable;

class BadRequestException extends Exception implements HttpAcceptable
{
    /**
     * BadRequestException constructor.
     * @param string $message
     * @param Throwable|null $previous
     */
    #[Pure]
    public function __construct($message = "", Throwable $previous = null)
    {
        parent::__construct($message, $this->getStatusCode(), $previous);
    }

    /**
     * @return int
     */
    public function getStatusCode(): int
    {
        return Response::BAD_REQUEST;
    }
}
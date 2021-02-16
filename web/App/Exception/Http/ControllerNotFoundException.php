<?php

namespace App\Exception\Http;

use App\Http\Response;
use Exception;
use JetBrains\PhpStorm\Pure;
use Throwable;

class ControllerNotFoundException extends Exception implements HttpAcceptable
{
    /**
     * ControllerNotFoundException constructor.
     * @param string $message
     * @param int $code
     * @param Throwable|null $previous
     */
    #[Pure]
    public function __construct(
        $message = "",
        $code = 0,
        Throwable $previous = null
    ) {
        parent::__construct(
            'Page not found.',
            $this->getStatusCode(),
            $previous
        );
    }

    /**
     * @return int
     */
    public function getStatusCode(): int
    {
        return Response::NOT_FOUND;
    }
}
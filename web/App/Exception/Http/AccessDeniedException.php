<?php

namespace App\Exception\Http;

use App\Http\Response;
use Exception;
use JetBrains\PhpStorm\Pure;
use Throwable;

class AccessDeniedException extends Exception implements HttpAcceptable
{
    /**
     * AccessDeniedException constructor.
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
            'You are not authorised to access this page.',
            $this->getStatusCode(),
            $previous
        );
    }

    /**
     * @return int
     */
    public function getStatusCode(): int
    {
        return Response::FORBIDDEN;
    }
}
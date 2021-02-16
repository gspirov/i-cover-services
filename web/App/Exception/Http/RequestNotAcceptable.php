<?php

namespace App\Exception\Http;

use App\Http\Response;
use Exception;
use JetBrains\PhpStorm\Pure;
use Throwable;

class RequestNotAcceptable extends Exception implements HttpAcceptable
{
    /**
     * RequestNotAcceptable constructor.
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
            'Request is not acceptable. Possible "Accept" header is: text/html.',
            $this->getStatusCode(),
            $previous
        );
    }

    /**
     * @return int
     */
    public function getStatusCode(): int
    {
        return Response::NOT_ACCEPTABLE;
    }
}

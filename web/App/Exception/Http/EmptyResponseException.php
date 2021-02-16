<?php

namespace App\Exception\Http;

use App\Http\Response;
use Exception;

class EmptyResponseException extends Exception implements HttpAcceptable
{
    /**
     * @return int
     */
    public function getStatusCode(): int
    {
        return Response::NOT_FOUND;
    }
}
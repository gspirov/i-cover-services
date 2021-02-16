<?php

namespace App\Http;

use JetBrains\PhpStorm\Pure;
use App\Base\Response as BaseResponse;

class Response extends BaseResponse
{
    const BAD_REQUEST = 400;
    const FORBIDDEN = 403;
    const NOT_FOUND = 404;
    const NOT_ACCEPTABLE = 406;
    const INTERNAL_SERVER_ERROR = 500;

    /**
     * @var SessionBag $sessionBag
     */
    private SessionBag $sessionBag;

    /**
     * @var HeaderBag $headerBag
     */
    private HeaderBag $headerBag;

    /**
     * @var int $statusCode
     */
    private int $statusCode = 200;

    /**
     * Response constructor.
     */
    #[Pure]
    public function __construct()
    {
        $this->sessionBag = new SessionBag;
        $this->headerBag = new HeaderBag;
    }

    /**
     * @return string
     */
    public function send(): string
    {
        $this->sendHeaders();
        return $this->content;
    }

    public function sendHeaders()
    {
        foreach ($this->headerBag->getAll() as $header) {
            header($header, true);
        }

        http_response_code($this->statusCode);
    }

    /**
     * @return SessionBag
     */
    public function getSessionBag(): SessionBag
    {
        return $this->sessionBag;
    }

    /**
     * @return HeaderBag
     */
    public function getHeaderBag(): HeaderBag
    {
        return $this->headerBag;
    }

    /**
     * @return int
     */
    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    /**
     * @param int $statusCode
     * @return Response
     */
    public function setStatusCode(int $statusCode): Response
    {
        $this->statusCode = $statusCode;
        return $this;
    }
}
<?php

namespace App\Http\Handler;

class EntryPoint
{
    /**
     * EntryPoint constructor.
     * @param HandlerInterface $exceptionHandler
     * @param ErrorHandler $errorHandler
     */
    public function __construct(
        private HandlerInterface $exceptionHandler,
        private ErrorHandler $errorHandler
    ) {}

    public function register()
    {
        set_exception_handler([$this->exceptionHandler, 'handle']);
        set_error_handler([$this->errorHandler, 'handle']);
    }
}
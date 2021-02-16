<?php

namespace App\Exception\Entity;

use Exception;
use JetBrains\PhpStorm\Pure;
use Throwable;

abstract class ValidationException extends Exception
{
    /**
     * ValidationException constructor.
     * @param array $errors
     * @param string $message
     * @param int $code
     * @param Throwable|null $previous
     */
    #[Pure]
    public function __construct(
        protected array $errors,
        string $message,
        $code = 0,
        Throwable $previous = null
    ) {
        parent::__construct($message, $code, $previous);
    }

    /**
     * @return array
     */
    public function getErrors(): array
    {
        return $this->errors;
    }
}
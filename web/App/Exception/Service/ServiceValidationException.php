<?php

namespace App\Exception\Service;

use App\Exception\Entity\ValidationException;
use JetBrains\PhpStorm\Pure;
use Throwable;

class ServiceValidationException extends ValidationException
{
    /**
     * ServiceValidationException constructor.
     * @param array $errors
     * @param string $message
     * @param int $code
     * @param Throwable|null $previous
     */
    #[Pure]
    public function __construct(
        array $errors,
        string $message = 'Validation of service failed.',
        $code = 0,
        Throwable $previous = null
    ) {
        parent::__construct($errors, $message, $code, $previous);
    }
}
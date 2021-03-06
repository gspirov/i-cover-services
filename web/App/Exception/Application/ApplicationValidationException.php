<?php

namespace App\Exception\Application;

use App\Exception\Entity\ValidationException;
use JetBrains\PhpStorm\Pure;
use Throwable;

class ApplicationValidationException extends ValidationException
{
    /**
     * ApplicationValidationCreationException constructor.
     * @param array $errors
     * @param string $message
     * @param int $code
     * @param Throwable|null $previous
     */
    #[Pure]
    public function __construct(
        array $errors,
        string $message = 'Validation of application failed.',
        $code = 0,
        Throwable $previous = null
    ) {
        parent::__construct($errors, $message, $code, $previous);
    }
}
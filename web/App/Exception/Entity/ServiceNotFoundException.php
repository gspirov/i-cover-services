<?php

namespace App\Exception\Entity;

use App\Exception\Base\EntityNotFoundException;
use JetBrains\PhpStorm\Pure;
use Throwable;

class ServiceNotFoundException extends EntityNotFoundException
{
    /**
     * ServiceNotFoundException constructor.
     * @param string $message
     * @param Throwable|null $previous
     */
    #[Pure]
    public function __construct(
        $message = 'Service cannot be found.',
        Throwable $previous = null
    ) {
        parent::__construct($message, $previous);
    }
}
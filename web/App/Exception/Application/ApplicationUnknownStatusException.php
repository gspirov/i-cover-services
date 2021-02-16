<?php

namespace App\Exception\Application;

use App\Model\DTO\Applications;
use Exception;
use JetBrains\PhpStorm\Pure;
use Throwable;

class ApplicationUnknownStatusException extends Exception
{
    /**
     * ApplicationUnknownStatusException constructor.
     * @param string $unknownStatus
     * @param int $code
     * @param Throwable|null $previous
     */
    #[Pure]
    public function __construct(
        string $unknownStatus,
        $code = 0,
        Throwable $previous = null
    ) {
        parent::__construct(
            sprintf(
                'Unknown status: %s, possible ones are: %s',
                $unknownStatus,
                implode(', ', [
                    Applications::STATUS_OPEN,
                    Applications::STATUS_CLOSED,
                    Applications::STATUS_CANCELLED
                ])
            ),
            $code,
            $previous
        );
    }
}
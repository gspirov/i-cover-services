<?php

namespace App\Service;

use JetBrains\PhpStorm\Pure;

class ServicesCountryService
{
    /**
     * ServicesCountryService constructor.
     * @param array $countryIds
     * @param array $alreadyLinkedCountryIdsToService
     */
    public function __construct(
        private array $countryIds,
        private array $alreadyLinkedCountryIdsToService
    ) {}

    #[Pure]
    public function forInsert(): array
    {
        return array_diff(
            $this->countryIds,
            $this->alreadyLinkedCountryIdsToService
        );
    }

    #[Pure]
    public function forDelete(): array
    {
        return array_diff(
            $this->alreadyLinkedCountryIdsToService,
            $this->countryIds
        );
    }
}
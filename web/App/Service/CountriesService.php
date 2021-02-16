<?php

namespace App\Service;

use App\Exception\Countries\CountryValidationException;
use App\Model\DTO\Countries;
use JetBrains\PhpStorm\Pure;

class CountriesService
{
    /**
     * CountriesService constructor.
     * @param string $name
     * @param string $iso2
     * @throws CountryValidationException
     */
    public function __construct(
        private string $name,
        private string $iso2
    ) {
        if (!empty($validationErrors = $this->validate())) {
            throw new CountryValidationException($validationErrors);
        }
    }

    #[Pure]
    public function validate(): array
    {
        $errors = [];

        if (strlen($this->name) < 2) {
            $errors['name'] = 'Name should be at least 2 characters long.';
        }

        // ... any other custom validation here...

        return $errors;
    }

    /**
     * @return Countries
     */
    public function create(): Countries
    {
        $country = new Countries;

        $country->setName($this->name)
                ->setIso2($this->iso2);

        return $country;
    }
}
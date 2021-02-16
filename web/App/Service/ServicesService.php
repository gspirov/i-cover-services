<?php

namespace App\Service;

use App\Exception\Service\ServiceValidationException;
use App\Model\DTO\Services;
use JetBrains\PhpStorm\Pure;

class ServicesService
{
    /**
     * ServicesService constructor.
     * @param string $name
     * @param string $description
     * @param bool $isAvailable
     * @throws ServiceValidationException
     */
    public function __construct(
        private string $name,
        private string $description,
        private bool $isAvailable
    ) {
        if (!empty($validationErrors = $this->validate())) {
            throw new ServiceValidationException($validationErrors);
        }
    }

    /**
     * @return array
     */
    #[Pure]
    public function validate(): array
    {
        $errors = [];

        if (strlen($this->name) < 5) {
            $errors['name'] = 'Name should be at least 5 characters.';
        }

        return $errors;
    }

    /**
     * @return Services
     */
    public function create(): Services
    {
        $service = new Services;
        $service->setName($this->name)
                ->setDescription(!empty($this->description) ? $this->description : null)
                ->setAvailable($this->isAvailable);

        return $service;
    }
}
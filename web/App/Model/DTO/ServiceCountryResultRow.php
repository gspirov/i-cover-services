<?php

namespace App\Model\DTO;

class ServiceCountryResultRow
{
    /**
     * @var int $serviceCountryId
     */
    private int $serviceCountryId;

    /**
     * @var string $service
     */
    private string $service;

    /**
     * ServiceCountryResultRow constructor.
     */
    public function __construct() {}

    /**
     * @return int
     */
    public function getServiceCountryId(): int
    {
        return $this->serviceCountryId;
    }

    /**
     * @return string
     */
    public function getService(): string
    {
        return $this->service;
    }
}
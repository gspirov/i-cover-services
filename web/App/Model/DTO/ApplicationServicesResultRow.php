<?php

namespace App\Model\DTO;

class ApplicationServicesResultRow
{
    /**
     * @var string $applicant
     */
    private string $applicant;

    /**
     * @var string $service
     */
    private string $service;

    /**
     * @var string $country
     */
    private string $country;

    /**
     * @var string $requestedUser
     */
    private string $requestedUser;

    /**
     * ApplicationServicesResultRow constructor.
     */
    public function __construct() {}

    /**
     * @return string
     */
    public function getApplicant(): string
    {
        return $this->applicant;
    }

    /**
     * @return string
     */
    public function getService(): string
    {
        return $this->service;
    }

    /**
     * @return string
     */
    public function getCountry(): string
    {
        return $this->country;
    }

    /**
     * @return string
     */
    public function getRequestedUser(): string
    {
        return $this->requestedUser;
    }
}
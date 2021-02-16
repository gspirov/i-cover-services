<?php

namespace App\Model\DTO;

class ApplicationServices
{
    /**
     * @var int $id
     */
    private int $id;

    /**
     * @var ?int $application_id
     */
    private ?int $application_id;

    /**
     * @var int $country_service_id
     */
    private int $country_service_id;

    /**
     * @var int $requested_by
     */
    private int $requested_by;

    /**
     * ApplicationServices constructor.
     */
    public function __construct() {}

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return int
     */
    public function getApplicationId(): int
    {
        return $this->application_id;
    }

    /**
     * @param Applications $application
     * @return ApplicationServices
     */
    public function setApplication(Applications $application): self
    {
        $this->application_id = $application->getId();
        return $this;
    }

    /**
     * @return int
     */
    public function getCountryServiceId(): int
    {
        return $this->country_service_id;
    }

    /**
     * @param ServiceCountries $serviceCountry
     * @return ApplicationServices
     */
    public function setCountryService(ServiceCountries $serviceCountry): self
    {
        $this->country_service_id = $serviceCountry->getId();
        return $this;
    }

    /**
     * @return int
     */
    public function getRequestedBy(): int
    {
        return $this->requested_by;
    }

    /**
     * @param Users $requestedBy
     * @return ApplicationServices
     */
    public function setRequestedBy(Users $requestedBy): self
    {
        $this->requested_by = $requestedBy->getId();
        return $this;
    }
}
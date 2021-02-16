<?php

namespace App\Model\DTO;

class ServiceCountries
{
    /**
     * @var int $id
     */
    private int $id;

    /**
     * @var int $country_id
     */
    private int $country_id;

    /**
     * @var int $service_id
     */
    private int $service_id;

    public function __construct()
    {
    }

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
    public function getCountryId(): int
    {
        return $this->country_id;
    }

    /**
     * @param Countries $country
     * @return ServiceCountries
     */
    public function setCountryId(Countries $country): self
    {
        $this->country_id = $country->getId();
        return $this;
    }

    /**
     * @return int
     */
    public function getServiceId(): int
    {
        return $this->service_id;
    }

    /**
     * @param Services $service
     * @return $this
     */
    public function setServiceId(Services $service): self
    {
        $this->service_id = $service->getId();
        return $this;
    }
}
<?php

namespace App\Model\DTO;

class Countries
{
    /**
     * @var int $id
     */
    private int $id;

    /**
     * @var string $iso2
     */
    private string $iso2;

    /**
     * @var string $name
     */
    private string $name;

    /**
     * Countries constructor.
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
     * @return string
     */
    public function getIso2(): string
    {
        return $this->iso2;
    }

    /**
     * @param string $iso2
     * @return Countries
     */
    public function setIso2(string $iso2): self
    {
        $this->iso2 = $iso2;
        return $this;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return Countries
     */
    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }
}
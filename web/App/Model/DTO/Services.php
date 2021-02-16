<?php

namespace App\Model\DTO;

use App\Model\DTO\Traits\Timestampable;
use DateTime;
use DateTimeInterface;

class Services
{
    use Timestampable;

    /**
     * @var int $id
     */
    private int $id;

    /**
     * @var string $name
     */
    private string $name;

    /**
     * @var string|null $description
     */
    private ?string $description;

    /**
     * @var int $available
     */
    private int $available;

    /**
     * @var bool $isAvailable
     */
    private bool $isAvailable;

    /**
     * Fetched property from the database, instead of use getUpdatedAt().
     * @var string|null $updated_at
     */
    private ?string $updated_at;

    /**
     * @var DateTimeInterface|null $updatedAt
     */
    private ?DateTimeInterface $updatedAt = null;

    /**
     * Services constructor.
     */
    public function __construct()
    {
        $this->initCreatedAt();

        if (!empty($this->updated_at)) {
            $this->updatedAt = DateTime::createFromFormat('Y-m-d H:i:s', $this->updated_at);
        }

        $this->isAvailable = !empty($this->available);
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return Services
     */
    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @param string|null $description
     * @return Services
     */
    public function setDescription(?string $description): self
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @param bool $availability
     * @return $this
     */
    public function setAvailable(bool $availability): self
    {
        $this->isAvailable = $availability;
        return $this;
    }

    /**
     * @return bool
     */
    public function isAvailable(): bool
    {
        return $this->isAvailable;
    }

    /**
     * @return DateTimeInterface|null
     */
    public function getUpdatedAt(): ?DateTimeInterface
    {
        return $this->updatedAt;
    }
}
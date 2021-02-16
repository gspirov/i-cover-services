<?php

namespace App\Model\DTO\Traits;

use DateTime;
use DateTimeInterface;

trait Timestampable
{
    /**
     * Fetched property from the database, instead of use getCreatedAt().
     * @var string $created_at
     */
    protected string $created_at;

    /**
     * @var DateTimeInterface $createdAt
     */
    protected DateTimeInterface $createdAt;

    protected function initCreatedAt()
    {
        if (!empty($this->created_at)) {
            $this->createdAt = DateTime::createFromFormat('Y-m-d H:i:s', $this->created_at);
        }
    }

    /**
     * @return DateTimeInterface|null
     */
    public function getCreatedAt(): ?DateTimeInterface
    {
        return $this->createdAt;
    }
}
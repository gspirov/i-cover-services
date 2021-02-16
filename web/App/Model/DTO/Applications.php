<?php

namespace App\Model\DTO;

use App\Model\DTO\Traits\Timestampable;
use DateTime;
use DateTimeInterface;

class Applications
{
    use Timestampable;

    const STATUS_OPEN = 'open';
    const STATUS_CANCELLED = 'cancelled';
    const STATUS_CLOSED = 'closed';

    /**
     * @var int $id
     */
    private int $id;

    /**
     * @var string $first_name
     */
    private string $first_name;

    /**
     * @var string
     */
    private string $last_name;

    /**
     * @var string $gender
     */
    private string $gender;

    /**
     * @var string $title
     */
    private string $title;

    /**
     * @var string $status
     */
    private string $status;

    /**
     * Fetched property from the database, instead of use getDateOfBirth()
     * @var string $dob
     */
    private string $dob;

    /**
     * @var DateTimeInterface $dateOfBirth
     */
    private DateTimeInterface $dateOfBirth;

    /**
     * Applications constructor.
     */
    public function __construct()
    {
        if (!empty($this->dob)) {
            $this->dateOfBirth = DateTime::createFromFormat('Y-m-d', $this->dob);
        }

        $this->initCreatedAt();
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return string|null
     */
    public function getFirstName(): ?string
    {
        return $this->first_name;
    }

    /**
     * @param string $firstName
     * @return Applications
     */
    public function setFirstName(string $firstName): self
    {
        $this->first_name = $firstName;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getLastName(): ?string
    {
        return $this->last_name;
    }

    /**
     * @param string $lastName
     * @return Applications
     */
    public function setLastName(string $lastName): self
    {
        $this->last_name = $lastName;
        return $this;
    }

    /**
     * @return string
     */
    public function getGender(): string
    {
        return $this->gender;
    }

    /**
     * @param string $gender
     * @return Applications
     */
    public function setGender(string $gender): self
    {
        $this->gender = $gender;
        return $this;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     * @return Applications
     */
    public function setTitle(string $title): self
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @return string
     */
    public function getStatus(): string
    {
        return $this->status;
    }

    /**
     * @param string $status
     * @return Applications
     */
    public function setStatus(string $status): self
    {
        $this->status = $status;
        return $this;
    }

    /**
     * @return DateTimeInterface|null
     */
    public function getDateOfBirth(): ?DateTimeInterface
    {
        return $this->dateOfBirth;
    }

    /**
     * @param DateTimeInterface $dateOfBirth
     * @return Applications
     */
    public function setDateOfBirth(DateTimeInterface $dateOfBirth): self
    {
        $this->dateOfBirth = $dateOfBirth;
        return $this;
    }
}
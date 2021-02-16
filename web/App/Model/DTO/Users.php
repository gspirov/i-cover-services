<?php

namespace App\Model\DTO;

use App\Model\DTO\Traits\Timestampable;

class Users
{
    use Timestampable;

    /**
     * @var int $id
     */
    private int $id;

    /**
     * @var string $email
     */
    private string $email;

    /**
     * @var string $password
     */
    private string $password;

    /**
     * @var string $first_name
     */
    private string $first_name;

    /**
     * @var string $last_name
     */
    private string $last_name;

    /**
     * Users constructor.
     */
    public function __construct()
    {
        $this->initCreatedAt();
    }

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
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param string $email
     * @return Users
     */
    public function setEmail(string $email): self
    {
        $this->email = $email;
        return $this;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @param string $password
     * @return Users
     */
    public function setPassword(string $password): self
    {
        $this->password = $password;
        return $this;
    }

    /**
     * @return string
     */
    public function getFirstName(): string
    {
        return $this->first_name;
    }

    /**
     * @param string $firstName
     * @return Users
     */
    public function setFirstName(string $firstName): self
    {
        $this->first_name = $firstName;
        return $this;
    }

    /**
     * @return string
     */
    public function getLastName(): string
    {
        return $this->last_name;
    }

    /**
     * @param string $lastName
     * @return Users
     */
    public function setLastName(string $lastName): self
    {
        $this->last_name = $lastName;
        return $this;
    }
}
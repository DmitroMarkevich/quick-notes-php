<?php

namespace app\model\dto;

use DateTime;

class UserResponseDto
{
    private string $email;
    private string $fullName;
    private string $phone;
    private DateTime $createdAt;
    private DateTime $updatedAt;
    private bool $emailConfirmed;
    private bool $isDeleted;

    /**
     * @param string $email
     * @param string $fullName
     * @param string $phone
     * @param DateTime $createdAt
     * @param DateTime $updatedAt
     * @param bool $emailConfirmed
     * @param bool $isDeleted
     */
    public function __construct(
        string $email,
        string $fullName,
        string $phone,
        DateTime $createdAt,
        DateTime $updatedAt,
        bool $emailConfirmed,
        bool $isDeleted
    ) {
        $this->email = $email;
        $this->fullName = $fullName;
        $this->phone = $phone;
        $this->createdAt = $createdAt;
        $this->updatedAt = $updatedAt;
        $this->emailConfirmed = $emailConfirmed;
        $this->isDeleted = $isDeleted;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getFullName(): string
    {
        return $this->fullName;
    }

    public function getPhone(): string
    {
        return $this->phone;
    }

    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): DateTime
    {
        return $this->updatedAt;
    }

    public function isEmailConfirmed(): bool
    {
        return $this->emailConfirmed;
    }

    public function isDeleted(): bool
    {
        return $this->isDeleted;
    }
}
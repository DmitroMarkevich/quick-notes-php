<?php

namespace app\model;

use core\base\Model;
use DateTime;

class User extends Model
{
    protected const TABLE_NAME = 'users';

    private string $email;
    private string $password;
    private string $fullName;
    private string $phone;
    private DateTime $createdAt;
    private DateTime $updatedAt;
    private bool $emailConfirmed;
    private bool $isDeleted;

    public function __construct(
        string $email,
        string $password,
        string $fullName,
        string $phone
    ) {
        parent::__construct();

        $this->email = $email;
        $this->phone = $phone;
        $this->password = $password;
        $this->fullName = $fullName;
        $this->isDeleted = false;
        $this->emailConfirmed = false;
        $this->createdAt = new DateTime();
        $this->updatedAt = new DateTime();
    }

    /**
     * Returns the name of the table in the database.
     *
     * @return string The name of the table associated with this model.
     */
    public static function getTableName(): string
    {
        return self::TABLE_NAME;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function isEmailConfirmed(): bool
    {
        return $this->emailConfirmed;
    }

    public function getFullName(): string
    {
        return $this->fullName;
    }

    public function getPhone(): string
    {
        return $this->phone;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): DateTime
    {
        return $this->updatedAt;
    }

    public function isDeleted(): bool
    {
        return $this->isDeleted;
    }

    public function setIsDeleted(bool $isDeleted): void
    {
        $this->isDeleted = $isDeleted;
    }
}
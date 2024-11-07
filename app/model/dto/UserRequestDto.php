<?php

namespace app\model\dto;

class UserRequestDto
{
    private string $email;
    private string $password;
    private string $fullName;
    private string $phone;

    /**
     * @param string $email
     * @param string $password
     * @param string $fullName
     * @param string $phone
     */
    public function __construct(string $email, string $password, string $fullName, string $phone)
    {
        $this->email = $email;
        $this->password = $password;
        $this->fullName = $fullName;
        $this->phone = $phone;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    public function getFullName(): string
    {
        return $this->fullName;
    }

    public function getPhone(): string
    {
        return $this->phone;
    }
}
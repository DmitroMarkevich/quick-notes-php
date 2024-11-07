<?php

namespace core\auth;

class Credential
{
    private string $email;
    private string $password;
    private array $roles;

    public function __construct(string $email, string $password, ?array $roles = [])
    {
        $this->email = $email;
        $this->password = $password;
        $this->roles = $roles;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function getRoles(): array
    {
        return $this->roles;
    }
}
<?php

namespace core\auth\implementations;

use core\auth\contracts\AuthProvider;
use core\auth\Credential;

class InMemoryAuthProvider implements AuthProvider
{
    private array $credentials;

    public function __construct(array $credentials)
    {
        $this->credentials = $credentials;
    }

    /**
     * Retrieves the credentials for a user based on the provided login.
     *
     * @param string $login The user's login identifier (e.g., email).
     * @return Credential|null The user's credentials, or null if not found.
     */
    public function getCredentials(string $login): ?Credential
    {
        foreach ($this->credentials as $credential) {
            if ($credential->getEmail() === $login) {
                return $credential;
            }
        }

        return null;
    }

    /**
     * Adds new credentials if they do not already exist in the provider.
     *
     * @param Credential $credential The credentials to be added.
     */
    public function addCredentials(Credential $credential): void
    {
        foreach ($this->credentials as $existingCredential) {
            if ($existingCredential->getEmail() === $credential->getEmail()) {
                return;
            }
        }

        $this->credentials[] = $credential;
    }
}
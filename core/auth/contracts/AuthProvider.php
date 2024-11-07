<?php

namespace core\auth\contracts;

use core\auth\Credential;

interface AuthProvider
{
    /**
     * Retrieves the credentials for a user based on the provided login.
     *
     * @param string $login The user's login identifier (e.g., email).
     * @return Credential|null The user's credentials, or null if not found.
     */
    function getCredentials(string $login): ?Credential;

    /**
     * Adds a new user's credentials to the authentication provider.
     *
     * @param Credential $credential The credentials to be added.
     */
    function addCredentials(Credential $credential): void;
}
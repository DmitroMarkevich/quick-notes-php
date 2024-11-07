<?php

namespace core\auth\implementations;

use core\auth\contracts\PasswordEncoder;

class BcryptPasswordEncoder implements PasswordEncoder
{
    private const DEFAULT_COST = 12;

    /**
     * Encodes a raw password using bcrypt.
     *
     * @param string $rawPassword The raw password to be encoded.
     * @return string The encoded password.
     */
    function encode(string $rawPassword): string
    {
        return password_hash($rawPassword, PASSWORD_BCRYPT, ['cost' => self::DEFAULT_COST]);
    }

    /**
     * Verifies a raw password against an encoded password.
     *
     * @param string $rawPassword The raw password to verify.
     * @param string $encodedPassword The encoded password to compare against.
     * @return bool True if the passwords match, false otherwise.
     */
    function matches(string $rawPassword, string $encodedPassword): bool
    {
        return password_verify($rawPassword, $encodedPassword);
    }
}
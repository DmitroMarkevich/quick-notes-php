<?php

namespace core\auth\contracts;

interface PasswordEncoder
{
    /**
     * Encodes a raw password for secure storage.
     *
     * @param string $rawPassword The plain text password to encode.
     * @return string The encoded password.
     */
    function encode(string $rawPassword): string;

    /**
     * Checks if a raw password matches an encoded password.
     *
     * @param string $rawPassword The plain text password to verify.
     * @param string $encodedPassword The previously encoded password to compare against.
     * @return bool True if the passwords match, false otherwise.
     */
    function matches(string $rawPassword, string $encodedPassword): bool;
}
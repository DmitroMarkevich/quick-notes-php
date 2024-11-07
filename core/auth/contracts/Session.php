<?php

namespace core\auth\contracts;

interface Session
{
    /**
     * Sets a session variable.
     *
     * @param string $key The session variable key.
     * @param string $value The session variable value.
     */
    function set(string $key, string $value): void;

    /**
     * Retrieves a session variable.
     *
     * @param string $key The session variable key.
     * @return string|null The session variable value, or null if not set.
     */
    function get(string $key): ?string;

    /**
     * Deletes a session variable.
     *
     * @param string $key The session variable key.
     * @return bool True if the variable was deleted, false if it was not set.
     */
    function delete(string $key): bool;

    /**
     * Destroys the current session.
     */
    function destroy(): void;

    /**
     * Checks if the session is currently active.
     *
     * @return bool True if the session is active, false otherwise.
     */
    function isStarted(): bool;

    /**
     * Checks if a session variable is set.
     *
     * @param string $key The session variable key.
     * @return bool True if the variable is set, false otherwise.
     */
    function has(string $key): bool;
}
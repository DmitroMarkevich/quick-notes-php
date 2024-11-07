<?php

namespace core\auth\implementations;

use core\auth\contracts\Session;

class SessionManager implements Session
{
    private static ?SessionManager $instance = null;

    private function __construct()
    {
        session_start();
    }

    /**
     * Sets a session variable.
     *
     * @param string $key The session variable key.
     * @param string $value The session variable value.
     */
    function set(string $key, string $value): void
    {
        $_SESSION[$key] = $value;
    }

    /**
     * Retrieves a session variable.
     *
     * @param string $key The session variable key.
     * @return string|null The session variable value, or null if not set.
     */
    function get(string $key): ?string
    {
        return $_SESSION[$key] ?? null;
    }

    /**
     * Deletes a session variable.
     *
     * @param string $key The session variable key.
     * @return bool True if the variable was deleted, false if it was not set.
     */
    function delete(string $key): bool
    {
        if (isset($_SESSION[$key])) {
            unset($_SESSION[$key]);
            return true;
        }
        return false;
    }

    /**
     * Destroys the current session.
     */
    function destroy(): void
    {
        session_destroy();
    }

    /**
     * Checks if the session is currently active.
     *
     * @return bool True if the session is active, false otherwise.
     */
    function isStarted(): bool
    {
        return session_status() === PHP_SESSION_ACTIVE;
    }

    /**
     * Checks if a session variable is set.
     *
     * @param string $key The session variable key.
     * @return bool True if the variable is set, false otherwise.
     */
    function has(string $key): bool
    {
        return isset($_SESSION[$key]);
    }

    public static function getInstance(): SessionManager
    {
        if (self::$instance === null) {
            return new self();
        }

        return self::$instance;
    }
}
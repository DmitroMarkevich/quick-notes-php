<?php

namespace core\auth;

use app\mapper\UserMapper;
use app\model\dto\UserRequestDto;
use app\repository\UserRepository;
use core\auth\contracts\AuthProvider;
use core\auth\contracts\PasswordEncoder;
use core\auth\contracts\Session;
use core\auth\implementations\DatabaseAuthProvider;
use core\auth\implementations\BcryptPasswordEncoder;
use core\auth\implementations\SessionManager;
use core\db\DBQueryBuilder;
use Exception;

class Authentication
{
    private const LOGIN_SESSION_KEY = "login";

    private static ?Authentication $instance = null;

    private Session $session;
    private AuthProvider $authProvider;
    private PasswordEncoder $passwordEncoder;

    private function __construct()
    {
        $this->session = SessionManager::getInstance();
        $this->passwordEncoder = new BcryptPasswordEncoder();
        $this->authProvider = new DatabaseAuthProvider(
            new UserRepository(new DBQueryBuilder()),
            new UserMapper()
        );
    }

    public static function getInstance(): Authentication
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * Attempts to log in a user with the provided credentials.
     *
     * @param Credential $credential The user's login credentials.
     * @return bool True if login is successful, false otherwise.
     */
    public function login(Credential $credential): bool
    {
        if ($this->authProvider === null) {
            return false;
        }

        $storedCredential = $this->authProvider->getCredentials($credential->getEmail());

        if (!$storedCredential || !$this->passwordEncoder->matches(
                $credential->getPassword(),
                $storedCredential->getPassword()
            )) {
            return false;
        }

        $this->createSession($credential);
        return true;
    }

    /**
     * Registers a new user with the provided user request data.
     *
     * @param UserRequestDto $userRequestDto The user data for registration.
     * @return bool True if registration is successful, false otherwise.
     * @throws Exception If no authenticated user is found.
     */
    public function register(UserRequestDto $userRequestDto): bool
    {
        if ($this->authProvider === null) {
            return false;
        }

        $credential = new Credential($userRequestDto->getEmail(), $userRequestDto->getPassword());

        if ($this->authProvider->getCredentials($credential->getEmail()) !== null) {
            return false; // User already exists
        }

        $this->authProvider->addCredentials(
            new Credential($credential->getEmail(), $this->passwordEncoder->encode($credential->getPassword()))
        );

        return true;
    }

    /**
     * Retrieves the credentials of the currently authenticated user.
     *
     * @return Credential|null The user's credentials or null if not authenticated.
     * @throws Exception If no authenticated user is found.
     */
    public function getCredentials(): ?Credential
    {
        if (!$this->isAuthenticated()) {
            throw new Exception("No authenticated user found.");
        }

        $login = $this->session->get(self::LOGIN_SESSION_KEY);
        return $this->authProvider->getCredentials($login);
    }

    /**
     * Checks if the currently authenticated user has a specific role.
     *
     * @param string $role The role to check for.
     * @return bool True if the user has the role, false otherwise.
     * @throws Exception If no authenticated user is found.
     */
    public function hasRole(string $role): bool
    {
        $credentials = $this->getCredentials();
        return $credentials !== null && in_array($role, $credentials->getRoles(), true);
    }

    /**
     * Checks if a user is currently authenticated.
     *
     * @return bool True if the user is authenticated, false otherwise.
     */
    public function isAuthenticated(): bool
    {
        return $this->session->isStarted() && $this->session->has(self::LOGIN_SESSION_KEY);
    }

    /**
     * Logs out the currently authenticated user.
     */
    public function logout(): void
    {
        $this->session->delete(self::LOGIN_SESSION_KEY);
    }

    /**
     * Creates a session for the authenticated user.
     *
     * @param Credential $credential The user's credentials.
     */
    private function createSession(Credential $credential): void
    {
        $this->session->set(self::LOGIN_SESSION_KEY, $credential->getEmail());
    }
}
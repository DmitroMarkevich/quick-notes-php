<?php

namespace app\service;

use app\repository\NoteRepository;
use core\auth\Authentication;
use core\db\DBQueryBuilder;
use Exception;
use app\mapper\UserMapper;
use app\model\dto\UserResponseDto;
use app\repository\UserRepository;
use ReflectionException;

class UserService
{
    private UserMapper $userMapper;
    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepository, UserMapper $userMapper)
    {
        $this->userMapper = $userMapper;
        $this->userRepository = $userRepository;
    }

    /**
     * Get the authenticated user.
     *
     * @return UserResponseDto The user response data transfer object.
     * @throws Exception If the user is not found.
     */
    public function getAuthenticatedUser(): UserResponseDto
    {
        $email = $this->getAuthenticatedUserEmail();
        $user = $this->userRepository->findByEmail($email);

        if ($user === null) {
            throw new Exception("User not found for email: $email");
        }

        return $this->userMapper->mapEntityToResponseDto($user);
    }

    /**
     * Get the user ID by email.
     *
     * @param string $email The email address to search for.
     * @return string The ID of the user.
     * @throws Exception If the user is not found.
     */
    public function getUserIdByEmail(string $email): string
    {
        $user = $this->userRepository->findByEmail($email);

        if ($user === null) {
            throw new Exception("User not found for email: $email");
        }

        return $user->getId();
    }

    /**
     * Retrieves a paginated list of notes for the authenticated user.
     *
     * @param int $page The current page number (default is 1).
     * @param int $limit The number of notes to retrieve per page (default is 10).
     * @return array An array of notes for the authenticated user, limited by pagination settings.
     * @throws Exception if there is an error retrieving the authenticated user email.
     */
    public function getPaginatedUserNotes(int $page = 1, int $limit = 10): array
    {
        $offset = ($page - 1) * $limit;

        $email = $this->getAuthenticatedUserEmail();
        $userId = $this->getUserIdByEmail($email);

        $noteRepository = new NoteRepository(new DBQueryBuilder());
        return $noteRepository->findByUserIdWithPagination($userId, $limit, $offset);
    }

    /**
     * Check if a user exists by email.
     *
     * @param string $email The email address to check.
     * @return bool True if the user exists, false otherwise.
     *
     * @throws ReflectionException If the model class or constructor cannot be accessed.
     */
    public function existsByEmail(string $email): bool
    {
        return $this->userRepository->existsByEmail($email);
    }

    /**
     * Retrieves the email of the currently authenticated user.
     *
     * @return string The authenticated user's email address.
     * @throws Exception if the authentication instance or credentials are not properly set,
     *                   or if there is no authenticated user.
     */
    public function getAuthenticatedUserEmail(): string
    {
        return Authentication::getInstance()->getCredentials()->getEmail();
    }
}
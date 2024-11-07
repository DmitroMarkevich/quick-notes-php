<?php

namespace core\auth\implementations;

use Exception;
use app\mapper\UserMapper;
use app\model\dto\UserRequestDto;
use app\repository\UserRepository;
use core\auth\contracts\AuthProvider;
use core\auth\Credential;

class DatabaseAuthProvider implements AuthProvider
{
    private UserMapper $userMapper;
    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepository, UserMapper $userMapper)
    {
        $this->userMapper = $userMapper;
        $this->userRepository = $userRepository;
    }

    /**
     * Retrieves the credentials for a user based on the provided login.
     *
     * @param string $login The user's login identifier (e.g., email).
     * @return Credential|null The user's credentials, or null if not found.
     * @throws Exception If there is an error while retrieving the user data from the repository.
     */
    function getCredentials(string $login): ?Credential
    {
        $data = $this->userRepository->findByEmail($login);

        if ($data === null) {
            return null;
        }

        return new Credential($data->getEmail(), $data->getPassword());
    }

    /**
     * Adds a new user's credentials to the database.
     *
     * @param Credential $credential The credentials to be added.
     * @throws Exception If there is an error during the user save process.
     */
    function addCredentials(Credential $credential): void
    {
        $email = $credential->getEmail();

        $userRequestDto = new UserRequestDto(
            $email,
            $credential->getPassword(),
            'Markevych Dmytro',
            '+380986245727'
        );

        $user = $this->userMapper->mapRequestDtoToEntity($userRequestDto);

        $this->userRepository->save($user);
    }
}
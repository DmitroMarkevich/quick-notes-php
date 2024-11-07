<?php

namespace app\repository;

use app\model\User;
use core\base\Model;
use core\base\Repository;
use core\db\DBQueryBuilder;
use ReflectionException;

class UserRepository
{
    use Repository;

    public function __construct(DBQueryBuilder $dbQueryBuilder)
    {
        $this->setDBQueryBuilder($dbQueryBuilder);
    }

    /**
     * Finds a model by the given email address.
     *
     * @param string $email The email address to search for.
     * @return Model|null The found model or null if no model exists with the given email.
     *
     * @throws ReflectionException If the model class or constructor cannot be accessed.
     */
    public function findByEmail(string $email): ?User
    {
        return $this->findByField('email', $email);
    }

    /**
     * Checks if a model exists with the given email address.
     *
     * @param string $email The email address to check for existence.
     * @return bool True if a model exists with the given email, false otherwise.
     *
     * @throws ReflectionException If the model class or constructor cannot be accessed.
     */
    public function existsByEmail(string $email): bool
    {
        return !empty($this->findByField('email', $email));
    }

    protected function getModelClass(): string
    {
        return User::class;
    }
}
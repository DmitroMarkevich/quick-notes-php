<?php

namespace app\mapper;

use app\model\dto\UserRequestDto;
use app\model\dto\UserResponseDto;
use app\model\User;
use core\base\Mapper;
use InvalidArgumentException;

class UserMapper implements Mapper
{
    public function mapRequestDtoToEntity(object $dto): User
    {
        if (!($dto instanceof UserRequestDto)) {
            throw new InvalidArgumentException('Expected instance of UserRequestDto');
        }

        $email = $dto->getEmail();
        $phone = $dto->getPhone();
        $password = $dto->getPassword();
        $fullName = $dto->getFullName();

        return new User($email, $password, $fullName, $phone);
    }

    public function mapEntityToResponseDto(object $entity): UserResponseDto
    {
        if (!($entity instanceof User)) {
            throw new InvalidArgumentException('Expected instance of UserRequestDto');
        }

        $email = $entity->getEmail();
        $phone = $entity->getPhone();
        $fullName = $entity->getFullName();
        $createdAt = $entity->getCreatedAt();
        $updatedAt = $entity->getUpdatedAt();
        $isDeleted = $entity->isDeleted();
        $emailConfirmed = $entity->isEmailConfirmed();

        return new UserResponseDto(
            $email, $fullName, $phone,
            $createdAt, $updatedAt,
            $emailConfirmed, $isDeleted
        );
    }
}
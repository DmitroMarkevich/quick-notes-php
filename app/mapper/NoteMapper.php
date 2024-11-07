<?php

namespace app\mapper;

use app\model\dto\NoteRequestDto;
use app\model\dto\NoteResponseDto;
use app\model\Note;
use core\base\Mapper;
use InvalidArgumentException;

class NoteMapper implements Mapper
{
    public function mapRequestDtoToEntity(object $dto): Note
    {
        if (!($dto instanceof NoteRequestDto)) {
            throw new InvalidArgumentException('Expected instance of NoteRequestDto');
        }

        $title = $dto->getTitle();
        $content = $dto->getContent();
        $accessType = $dto->getAccessType();

        return new Note($title, $content, $accessType, null);
    }

    public function mapEntityToResponseDto(object $entity): NoteResponseDto
    {
        if (!($entity instanceof Note)) {
            throw new InvalidArgumentException('Expected instance of Note');
        }

        $title = $entity->getTitle();
        $content = $entity->getContent();
        $accessType = $entity->getAccessType();
        $createdAt = $entity->getCreatedAt();
        $updatedAt = $entity->getUpdatedAt();

        return new NoteResponseDto(
            $title, $content,
            $accessType, $createdAt,
            $updatedAt
        );
    }
}
<?php

namespace core\base;

interface Mapper
{
    /**
     * Maps a request DTO to an entity object.
     *
     * @param object $dto The data transfer object (DTO) that contains request data.
     * @return object The mapped entity object.
     */
    public function mapRequestDtoToEntity(object $dto): object;

    /**
     * Maps an entity object to a response DTO.
     *
     * @param object $entity The entity object that contains domain data.
     * @return object The mapped response DTO object.
     */
    public function mapEntityToResponseDto(object $entity): object;
}
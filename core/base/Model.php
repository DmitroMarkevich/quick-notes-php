<?php

namespace core\base;

use ReflectionClass;

abstract class Model
{
    protected string $id;

    /**
     * Model constructor.
     * Initializes the model by generating a unique identifier.
     */
    public function __construct()
    {
        $this->id = $this->generateUuid();
    }

    /**
     * Generates a unique ID (UUID).
     *
     * @return string The generated UUID.
     */
    protected function generateUuid(): string
    {
        return sprintf(
            '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
            mt_rand(0, 0xffff),
            mt_rand(0, 0xffff),
            mt_rand(0, 0xffff),
            mt_rand(0, 0x0fff) | 0x4000,
            mt_rand(0, 0x3fff) | 0x8000,
            mt_rand(0, 0xffff),
            mt_rand(0, 0xffff),
            mt_rand(0, 0xffff)
        );
    }

    /**
     * Gets the properties of the current object as an associative array.
     *
     * This method uses reflection to retrieve all non-static properties
     * and their values from the object. It sets the properties to be
     * accessible, allowing private and protected properties to be included.
     *
     * @return array An associative array of the object's properties and their values.
     */
    public function getProperties(): array
    {
        $properties = [];
        $reflection = new ReflectionClass($this);

        foreach ($reflection->getProperties() as $property) {
            if ($property->isStatic()) {
                continue;
            }

            $property->setAccessible(true);
            $properties[$property->getName()] = $property->getValue($this);
        }

        return $properties;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function setId(string $id): void
    {
        $this->id = $id;
    }

    /**
     * Gets the name of the database table associated with the model.
     *
     * @return string The table name.
     */
    public static function getTableName(): string
    {
        return static::TABLE_NAME;
    }
}
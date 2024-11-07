<?php

namespace core\base;

use DateTime;
use Exception;
use InvalidArgumentException;
use core\db\DBQueryBuilder;
use core\utils\Formatter;
use ReflectionClass;
use ReflectionException;

trait Repository
{
    private DBQueryBuilder $dbQueryBuilder;

    public function setDBQueryBuilder(DBQueryBuilder $dbQueryBuilder): void
    {
        $this->dbQueryBuilder = $dbQueryBuilder;
    }

    /**
     * Saves the given entity to the database.
     *
     * @param Model $entity The entity to save.
     * @return bool True on success, false on failure.
     *
     * @throws Exception If an error occurs during the save operation.
     */
    public function save(Model $entity): bool
    {
        $this->validateEntity($entity);

        $tableName = $entity::getTableName();
        $this->dbQueryBuilder->setTableName($tableName);

        $data = $this->extractEntityData($entity);

        return $this->dbQueryBuilder->insert($data);
    }

    /**
     * Extracts the data from the given entity and converts it to an associative array.
     *
     * @param Model $entity The entity from which to extract data.
     * @return array An associative array containing the entity's data.
     *
     * @throws Exception If the timezone is invalid.
     */
    protected function extractEntityData(Model $entity): array
    {
        $data = [];
        $data['id'] = $entity->getId();
        $properties = $entity->getProperties();

        foreach ($properties as $property => $value) {
            $fieldName = Formatter::toSnakeCase($property);

            if ($fieldName !== 'id') {
                $data[$fieldName] = $value instanceof DateTime
                    ? Formatter::formatDateTime($value)
                    : $value;
            }
        }

        return $data;
    }

    /**
     * Finds a model by its identifier.
     *
     * @param string $id The identifier of the model to find.
     * @return Model|null The found model or null if not found.
     *
     * @throws ReflectionException If the model class or constructor cannot be accessed.
     */
    protected function findById(string $id): ?Model
    {
        return $this->findByField('id', $id);
    }

    /**
     * Finds a model or models by a specific field and value.
     *
     * @param string $field The field to search by.
     * @param mixed $value The value to match.
     * @param bool $all Whether to return all matching models or just one. Defaults to false (return one).
     * @return Model[]|Model|null An array of found models if $all is true, a single model if $all is false, or null if not found.
     *
     * @throws ReflectionException If the model class or constructor cannot be accessed.
     */
    protected function findByField(string $field, $value, bool $all = false)
    {
        [$modelClass, $tableName] = $this->getModelClassAndTableName();

        $result = $this->dbQueryBuilder->select()
            ->where($field, '=', $value)
            ->from($tableName)
            ->{$all ? 'all' : 'one'}();

        if ($result) {
            if ($all) {
                return array_map(function ($item) use ($modelClass) {
                    return $this->mapToModel($modelClass, [$item]);
                }, $result);
            } else {
                return $this->mapToModel($modelClass, $result);
            }
        }

        return null;
    }

    /**
     * Finds all models in the associated table.
     *
     * @return array An array of all found models.
     *
     * @throws ReflectionException If the model class or constructor cannot be accessed.
     */
    protected function findAll(): array
    {
        [$modelClass, $tableName] = $this->getModelClassAndTableName();

        $results = $this->dbQueryBuilder->select()
            ->all();

        return array_map(fn($result) => $this->mapToModel($modelClass, $result), $results);
    }

    /**
     * Validates that the provided entity is of the expected type.
     *
     * @param Model $entity The entity to validate.
     * @throws InvalidArgumentException If the entity is not of the expected type.
     */
    protected function validateEntity(Model $entity): void
    {
        $getModelClass = $this->getModelClass();

        if (!$entity instanceof $getModelClass) {
            throw new InvalidArgumentException("Invalid entity type. Expected instance of $getModelClass.");
        }
    }

    /**
     * Maps data to a model instance, initializing it with constructor parameters and setting the ID.
     * Requires the data array to include keys matching the constructor parameters and an 'id'.
     *
     * @param string $modelClass The model class name.
     * @param array $data Associative array of data for the model.
     * @return Model The populated model instance.
     * @throws InvalidArgumentException If a required parameter is missing.
     * @throws ReflectionException If the model class or constructor cannot be accessed.
     */
    private function mapToModel(string $modelClass, array $data): Model
    {
        $reflectionClass = new ReflectionClass($modelClass);
        $constructor = $reflectionClass->getConstructor();

        if (!$constructor) {
            throw new InvalidArgumentException("No constructor found for class '$modelClass'.");
        }

        $params = $constructor->getParameters();
        $constructorArgs = [];

        foreach ($params as $param) {
            $paramName = $param->getName();
            $snakeCaseName = Formatter::toSnakeCase($paramName);

            if (array_key_exists($snakeCaseName, $data)) {
                $constructorArgs[] = $data[$snakeCaseName];
            } else {
                if (!$param->isOptional()) {
                    throw new InvalidArgumentException("Missing required parameter '$paramName' in data array. Available keys: " . implode(', ', array_keys($data)));
                }
                $constructorArgs[] = $param->isDefaultValueAvailable() ? $param->getDefaultValue() : null;
            }
        }

        $modelInstance = $reflectionClass->newInstanceArgs($constructorArgs);

        if (array_key_exists('id', $data)) {
            $modelInstance->setId($data['id']);
        }

        return $modelInstance;
    }

    /**
     * Gets the model class and table name.
     *
     * @return array An array containing the model class and table name.
     */
    private function getModelClassAndTableName(): array
    {
        $modelClass = $this->getModelClass();
        $tableName = $modelClass::getTableName();
        return [$this->getModelClass(), $tableName];
    }

    /**
     * Gets the model class.
     *
     * @return string The name of the model class.
     */
    abstract protected function getModelClass(): string;
}
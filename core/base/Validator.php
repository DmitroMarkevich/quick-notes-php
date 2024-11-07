<?php

namespace core\base;

abstract class Validator
{
    protected array $errors = [];

    /**
     * Validates the given data. Should be implemented by subclasses.
     *
     * @param mixed $data
     * @return void
     */
    abstract public function validate($data): bool;

    /**
     * Adds an error to the list.
     *
     * @param string $error
     * @return void
     */
    protected function addError(string $error): void
    {
        $this->errors[] = $error;
    }

    public function getErrors(): array
    {
        return $this->errors;
    }

    public function hasErrors(): bool
    {
        return !empty($this->errors);
    }

    public function clearErrors(): void
    {
        $this->errors = [];
    }
}
<?php

namespace app\validator;

use core\base\Validator;

class NoteValidator extends Validator
{
    private const TITLE_EMPTY_ERROR = "Title cannot be empty!";
    private const TITLE_LENGTH_ERROR = "Title length must be between 5 and 50 characters!";

    private const CONTENT_EMPTY_ERROR = "Content cannot be empty!";
    private const CONTENT_LENGTH_ERROR = "Content length must be between 5 and 500 characters!";

    /**
     * Validates the note input data.
     *
     * @param object $data Note data object containing title and content.
     * @return bool True if the note data is valid, otherwise false.
     */
    public function validate($data): bool
    {
        $this->clearErrors();

        $this->checkTitle($data->getTitle());
        $this->checkContent($data->getContent());

        return !$this->hasErrors();
    }

    /**
     * Validates the note title.
     *
     * @param string $title Note title.
     */
    private function checkTitle(string $title): void
    {
        $this->checkNotEmpty($title, self::TITLE_EMPTY_ERROR);
        $this->checkLength($title, 5, 50, self::TITLE_LENGTH_ERROR);
    }

    /**
     * Validates the note content.
     *
     * @param string $content Note content.
     */
    private function checkContent(string $content): void
    {
        $this->checkNotEmpty($content, self::CONTENT_EMPTY_ERROR);
        $this->checkLength($content, 5, 500, self::CONTENT_LENGTH_ERROR);
    }

    /**
     * Checks if the value is not empty.
     *
     * @param string $value The value to check.
     * @param string $errorMessage The error message to add if the value is empty.
     */
    private function checkNotEmpty(string $value, string $errorMessage): void
    {
        if (empty($value)) {
            $this->addError($errorMessage);
        }
    }

    /**
     * Checks the length of a value.
     *
     * @param string $value The value to check.
     * @param int $minLength The minimum allowed length.
     * @param int $maxLength The maximum allowed length.
     * @param string $errorMessage The error message to add if the length is outside the range.
     */
    private function checkLength(string $value, int $minLength, int $maxLength, string $errorMessage): void
    {
        if (strlen($value) < $minLength || strlen($value) > $maxLength) {
            $this->addError($errorMessage);
        }
    }
}
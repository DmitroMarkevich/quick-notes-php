<?php

namespace app\validator;

use core\base\Validator;

class AuthValidator extends Validator
{
    private const EMAIL_EMPTY_ERROR = "Email cannot be empty!";
    private const EMAIL_INVALID_ERROR = "Invalid email format!";
    private const EMAIL_LENGTH_ERROR = "Email length cannot exceed 100 characters!";

    private const PASSWORD_EMPTY_ERROR = "Password cannot be empty!";
    private const PASSWORD_LENGTH_ERROR = "Password length must be between 8 and 100 characters!";
    private const PASSWORD_INVALID_ERROR = "Invalid password! Must be at least 8 characters, contain letters and digits, and include one uppercase letter.";
    private const PASSWORD_REGEX_PATTERN = '/(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}/';

    private const PHONE_EMPTY_ERROR = "Phone number cannot be empty!";
    private const PHONE_INVALID_ERROR = "Invalid phone number format! Must be in international format.";
    private const PHONE_REGEX_PATTERN = '/^\+\d{1,3}\s?\d{1,14}(?:x.+)?$/';

    /**
     * Validates user input data.
     *
     * @param object $data User data object containing email, password, and phone number
     * @return bool True if the user data is valid, otherwise false.
     */
    public function validate($data): bool
    {
        $this->clearErrors();

        $this->checkEmail($data->getEmail());
        $this->checkPassword($data->getPassword());
        $this->checkPhone($data->getPhone());

        return !$this->hasErrors();
    }

    /**
     * Validates the user's email.
     *
     * @param string $email User email
     */
    private function checkEmail(string $email): void
    {
        $this->checkNotEmpty($email, self::EMAIL_EMPTY_ERROR);
        $this->checkLength($email, 5, 100, self::EMAIL_LENGTH_ERROR);
        $this->checkValidEmail($email);
    }

    /**
     * Validates the user's password.
     *
     * @param string $password User password
     */
    private function checkPassword(string $password): void
    {
        $this->checkNotEmpty($password, self::PASSWORD_EMPTY_ERROR);
        $this->checkLength($password, 8, 100, self::PASSWORD_LENGTH_ERROR);

        if (!preg_match(self::PASSWORD_REGEX_PATTERN, $password)) {
            $this->addError(self::PASSWORD_INVALID_ERROR);
        }
    }

    /**
     * Validates the user's phone number.
     *
     * @param string $phone User phone number
     */
    private function checkPhone(string $phone): void
    {
        $this->checkNotEmpty($phone, self::PHONE_EMPTY_ERROR);

        if (!preg_match(self::PHONE_REGEX_PATTERN, $phone)) {
            $this->addError(self::PHONE_INVALID_ERROR);
        }
    }

    /**
     * Checks if the value is not empty.
     *
     * @param string $value The value to check
     * @param string $errorMessage The error message to add if the value is empty
     */
    private function checkNotEmpty(string $value, string $errorMessage): void
    {
        if (empty($value)) {
            $this->addError($errorMessage);
        }
    }

    /**
     * Checks if the email is valid.
     *
     * @param string $email The email to validate
     */
    private function checkValidEmail(string $email): void
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->addError(self::EMAIL_INVALID_ERROR);
        }
    }

    /**
     * Checks the length of a value.
     *
     * @param string $value The value to check
     * @param int $minLength The minimum allowed length
     * @param int $maxLength The maximum allowed length
     * @param string $errorMessage The error message to add if the length is exceeded
     */
    private function checkLength(string $value, int $minLength, int $maxLength, string $errorMessage): void
    {
        if (strlen($value) < $minLength || strlen($value) > $maxLength) {
            $this->addError($errorMessage);
        }
    }
}
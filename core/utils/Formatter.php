<?php

namespace core\utils;

use Exception;
use DateTime;
use DateTimeZone;

class Formatter
{
    /**
     * Converts a string to snake_case format.
     *
     * @param string $input The string to convert.
     * @return string The converted string in snake_case format.
     */
    public static function toSnakeCase(string $input): string
    {
        return strtolower(preg_replace('/([a-z])([A-Z])/', '$1_$2', $input));
    }

    /**
     * Converts a string to camelCase format.
     *
     * @param string $input The string to convert.
     * @return string The converted string in camelCase format.
     */
    public static function toCamelCase(string $input): string
    {
        return lcfirst(str_replace('_', '', ucwords($input, '_')));
    }

    /**
     * Formats a DateTime object to a string in the format 'Y-m-d H:i:s' considering the timezone.
     *
     * @param DateTime $dateTime The DateTime object to format.
     * @param string $timezone The timezone to consider for formatting (default is 'UTC').
     * @return string The formatted date and time string.
     * @throws Exception If the timezone is invalid.
     */
    public static function formatDateTime(DateTime $dateTime, string $timezone = 'UTC'): string
    {
        $dateTime->setTimezone(new DateTimeZone($timezone));

        return $dateTime->format('Y-m-d H:i:s');
    }
}
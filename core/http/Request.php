<?php

namespace core\http;

/**
 * Class Request
 * Handles HTTP requests (POST, GET, file uploads, and headers)
 */
class Request
{
    private string $method;
    private array $postParams;
    private array $queryParams;
    private array $files;

    public function __construct()
    {
        $this->postParams = $_POST;
        $this->queryParams = $_GET;
        $this->files = $_FILES;
        $this->method = $_SERVER['REQUEST_METHOD'];
    }

    /**
     * Retrieves a POST parameter by key.
     *
     * @param string $key The key of the POST parameter.
     * @param mixed|null $default The default value to return if the key is not found.
     * @return mixed|null The value of the POST parameter, or the default value if not found.
     */
    public function getPostParam(string $key, $default = null)
    {
        if (isset($this->postParams[$key])) {
            return trim($this->postParams[$key]);
        }

        return $default;
    }

    /**
     * Retrieves a GET (query) parameter by key.
     *
     * @param string $key The key of the GET parameter.
     * @param mixed|null $default The default value to return if the key is not found.
     * @return mixed|null The value of the GET parameter, or the default value if not found.
     */
    public function getQueryParam(string $key, $default = null)
    {
        return $this->queryParams[$key] ?? $default;
    }

    public function getFile(string $key)
    {
        return $this->files[$key] ?? null;
    }

    /**
     * Checks if the HTTP request method is GET.
     *
     * @return bool True if the request method is GET, false otherwise.
     */
    public function isGet(): bool
    {
        return $this->method === 'GET';
    }

    /**
     * Checks if the HTTP request method is POST.
     *
     * @return bool True if the request method is POST, false otherwise.
     */
    public function isPost(): bool
    {
        return $this->method === 'POST';
    }

    /**
     * Checks if the HTTP request method is PUT.
     *
     * @return bool True if the request method is PUT, false otherwise.
     */
    public function isPut(): bool
    {
        return $this->method === 'PUT';
    }

    /**
     * Checks if the HTTP request method is PATCH.
     *
     * @return bool True if the request method is PATCH, false otherwise.
     */
    public function isPatch(): bool
    {
        return $this->method === 'PATCH';
    }

    /**
     * Checks if a file has been uploaded without errors.
     *
     * @param string $key The key of the uploaded file.
     * @return bool True if the file is uploaded and there are no errors, false otherwise.
     */
    public function isFileUploaded(string $key): bool
    {
        return isset($this->files[$key]) && $this->files[$key]['error'] === UPLOAD_ERR_OK;
    }

    /**
     * Retrieves the value of a specific HTTP header.
     *
     * @param string $header The name of the HTTP header.
     * @return string|null The value of the HTTP header, or null if not found.
     */
    public function getHeader(string $header): ?string
    {
        $header = str_replace('-', '_', strtoupper($header));
        return $_SERVER["HTTP_$header"] ?? null;
    }

    /**
     * Retrieves the raw body content of the request, typically used for JSON payloads.
     *
     * @return array The decoded JSON request body as an associative array.
     */
    public function getBody(): array
    {
        return json_decode(file_get_contents('php://input'), true) ?? [];
    }
}
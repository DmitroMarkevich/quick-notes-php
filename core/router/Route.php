<?php

namespace core\router;

class Route
{
    const PARAM_REGEX = '/\{\??([a-z]?[a-z0-9]*)}/i';
    const OPTIONAL_PARAM_REGEX = '/\{\?([a-z]?[a-z0-9]*)}/i';

    private array $params;
    private array $urlSegments;

    public function __construct(string $url, array $params = [])
    {
        $this->params = $params;
        $this->urlSegments = explode('/', trim($url, '/'));
    }

    /**
     * Matches the current request URI with the expected route URL.
     *
     * @return bool True if the request URI matches the route, false otherwise.
     */
    public function match(): bool
    {
        $uri = $this->getRequestUriWithoutQuery();
        $requestSegments = explode('/', $uri);

        if (count($requestSegments) > count($this->urlSegments)) {
            return false;
        }

        foreach ($this->urlSegments as $index => $segment) {
            $requestSegment = $requestSegments[$index] ?? null;

            if ($requestSegment === $segment) {
                continue;
            }

            if (empty($requestSegment)) {
                return $this->isOptionalParam($segment);
            }

            if (!$this->isParam($segment, $requestSegment)) {
                return false;
            }
        }

        return true;
    }

    /**
     * Extracts and returns the request URI without the query string.
     *
     * @return string
     */
    private function getRequestUriWithoutQuery(): string
    {
        $uri = $_SERVER['REQUEST_URI'];
        return trim(strtok($uri, '?'), '/');
    }

    /**
     * Checks if a segment matches a parameter.
     *
     * @param string $name
     * @param string $value
     * @return bool
     */
    private function isParam(string $name, string $value): bool
    {
        if (!preg_match(self::PARAM_REGEX, $name, $matches)) {
            return false;
        }

        $paramName = $matches[1];
        $this->params[$paramName] = strtolower($value);
        return true;
    }

    /**
     * Checks if a segment is an optional parameter.
     *
     * @param string $name
     * @return bool
     */
    private function isOptionalParam(string $name): bool
    {
        return (bool)preg_match(self::OPTIONAL_PARAM_REGEX, $name);
    }

    /**
     * Retrieves a parameter by name, with an optional default value.
     *
     * @param string $name
     * @param mixed $default
     * @return mixed
     */
    public function getParam(string $name, $default = null)
    {
        return $this->params[$name] ?? $default;
    }

    /**
     * Returns the controller name from the route parameters.
     *
     * @return string|null
     */
    public function getControllerName(): ?string
    {
        return $this->params['controller'] ?? null;
    }

    /**
     * Returns the action name from the route parameters.
     *
     * @return string|null
     */
    public function getActionName(): ?string
    {
        return $this->params['action'] ?? null;
    }
}
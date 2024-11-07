<?php

namespace core\base;

class View
{
    /**
     * @var string The path to the view file.
     */
    protected string $path;

    /**
     * @var array Data to be passed to the view (content).
     */
    protected array $data = [];

    /**
     * View constructor.
     *
     * @param string $name The name of the view file (without extension).
     */
    public function __construct(string $name)
    {
        $this->path = APP_DIR . "views/" . $name . EXT;
    }

    /**
     * Renders the view with the provided data.
     *
     * @param array $data An associative array of data to be passed to the view.
     * @return string The rendered view as a string.
     */
    protected function render(array $data = []): string
    {
        $data = array_merge($this->data, $data);
        extract($data);

        ob_start();

        include $this->path;

        return ob_get_clean();
    }

    public function __set(string $name, $value)
    {
        $this->data[$name] = $value;
    }

    public function __toString(): string
    {
        return $this->render();
    }
}
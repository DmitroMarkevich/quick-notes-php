<?php

namespace core\base;

namespace core\base;

class TemplateView extends View
{
    private View $view;

    public function __construct(string $name, string $template)
    {
        $this->view = new View($name);
        parent::__construct($template);
    }

    /**
     * Renders the template with the content view included.
     *
     * @param array $data An associative array of data to be passed to the template.
     * @return string The rendered template as a string.
     */
    public function render(array $data = []): string
    {
        $contentData = array_merge($this->data, $data);
        $data['content'] = $this->view->render($contentData);
        $data['errors'] = $this->getErrors();

        return parent::render($data);
    }

    /**
     * Adds an error message to the view.
     *
     * @param string $errorMessage The error message to add.
     */
    public function addError(string $errorMessage): void
    {
        $this->data['errors'][] = $errorMessage;
    }

    /**
     * Retrieves all error messages.
     *
     * @return array An array of error messages.
     */
    public function getErrors(): array
    {
        return $this->data['errors'] ?? [];
    }
}
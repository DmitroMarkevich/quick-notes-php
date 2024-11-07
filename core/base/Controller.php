<?php

namespace core\base;

use core\http\Request;

abstract class Controller
{
    protected Request $request;

    /**
     * Executes the action and processes any special instructions.
     *
     * @param string $action The action method to execute.
     * @return mixed The result of the action, or a meaningful response in case of a redirect.
     */
    public function executeAction(string $action)
    {
        $data = $this->$action();

        if ($this->workInstruction($data)) {
            return null;
        }

        return $data;
    }

    const REDIRECT_INSTRUCTION = 'redirect:';

    /**
     * Processes special instructions, like redirecting the user to another URL.
     *
     * @param mixed $data The data returned from the action method.
     * @return bool True if a redirect instruction was processed, otherwise false.
     */
    private function workInstruction($data): bool
    {
        if (!is_string($data)) {
            return false;
        }

        if (strpos($data, self::REDIRECT_INSTRUCTION) === 0) {
            $url = substr($data, strlen(self::REDIRECT_INSTRUCTION));

            $redirectUrl = ($url === 'back') ? $_SERVER['HTTP_REFERER'] : $url;

            header("Location: " . $redirectUrl, true, 303);
            exit();
        }

        return false;
    }

    protected function redirect(string $url = "/"): string
    {
        return "redirect:$url";
    }

    protected function handleValidationErrors(
        Validator $validator,
        string $view,
        string $template = 'templates/default'
    ): TemplateView {
        $templateView = new TemplateView($view, $template);

        foreach ($validator->getErrors() as $error) {
            $templateView->addError($error);
        }

        return $templateView;
    }

    public function setRequest(Request $request): void
    {
        $this->request = $request;
    }
}
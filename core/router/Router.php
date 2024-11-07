<?php

namespace core\router;

use core\http\Request;

class Router
{
    private array $routes;

    public function __construct(array $routes)
    {
        $this->routes = $routes;
    }

    /**
     * Routes the current request to the appropriate controller action.
     *
     * @throws RouterException if no matching route is found.
     */
    public function route(): void
    {
        foreach ($this->routes as $route) {
            if ($route->match()) {
                $this->navigate($route);
                return;
            }
        }

        throw new RouterException('No matching route found.');
    }

    /**
     * Navigates to the controller action defined by the route.
     *
     * @param Route $route The matched route to navigate.
     * @throws RouterException if the controller file or class is not found,
     *                         or if the action method does not exist in the controller.
     */
    private function navigate(Route $route): void
    {
        $controllerName = ucfirst($route->getControllerName());
        $action = "action" . ucfirst($route->getActionName());
        $controllerClassPath = APP_DIR . "controller/$controllerName" . EXT;

        if (!file_exists($controllerClassPath)) {
            throw new RouterException("Controller file not found: $controllerClassPath");
        }

        include $controllerClassPath;

        $controllerClass = "app\\controller\\$controllerName";
        if (!class_exists($controllerClass)) {
            throw new RouterException("Controller class not found: $controllerClass");
        }

        $ctrl = new $controllerClass();
        $ctrl->setRequest(new Request());

        if (!method_exists($ctrl, $action)) {
            throw new RouterException("Action '$action' not found in controller '$controllerName'.");
        }

        echo $ctrl->executeAction($action);
    }
}
<?php

namespace core;

use core\router\Router;
use core\router\RouterException;

class Application
{
    /**
     * Runs the application by initiating the router and processing the incoming request.
     */
    public function run(): void
    {
        $routerConfig = new Configurator('router');
        $router = new Router($routerConfig->get('routes'));

        try {
            $router->route();
        } catch (RouterException $e) {
            http_response_code(404);
        }
    }
}
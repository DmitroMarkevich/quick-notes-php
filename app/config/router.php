<?php

use core\router\Route;

$mainControllerRoutes = [
    new Route("", ["controller" => "mainController", "action" => "index"])
];

$userControllerRoutes = [
    new Route("/user/settings", ["controller" => "userController", "action" => "settings"])
];

$authControllerRoutes = [
    new Route("/login", ["controller" => "authController", "action" => "login"]),
    new Route("/register", ["controller" => "authController", "action" => "register"]),
    new Route("/logout", ["controller" => "authController", "action" => "logout"])
];

$noteControllerRoutes = [
    new Route("/note/list", ["controller" => "noteController", "action" => "list"]),
    new Route("/note/create", ["controller" => "noteController", "action" => "create"])
];

return [
    "routes" => array_merge(
        $mainControllerRoutes,
        $authControllerRoutes,
        $noteControllerRoutes,
        $userControllerRoutes
    )
];
<?php

use core\Application;

const ROOT_DIR = __DIR__ . "/../";
const CORE_DIR = ROOT_DIR . "core/";
const APP_DIR = ROOT_DIR . "app/";
const EXT = ".php";

/**
 * Autoloader function for automatically including classes.
 *
 * This function registers an autoloader using `spl_autoload_register`, which
 * automatically includes the necessary PHP class files when a class is instantiated.
 * It converts the namespace to a file path by replacing backslashes with slashes
 * and appends the default file extension.
 *
 * Example:
 * If a class `core\Application` is instantiated, it will look for the file at
 * `ROOT_DIR . "/core/Application.php"`.
 *
 * @param string $className The fully-qualified class name (with namespace).
 */
spl_autoload_register(function (string $className) {
    $path = ROOT_DIR . str_replace("\\", "/", $className) . EXT;

    if (file_exists($path)) {
        include $path;
    }
});

$application = new Application();
$application->run();
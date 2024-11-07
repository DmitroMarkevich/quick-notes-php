<?php

namespace core;

use Exception;

class Configurator
{
    /**
     * @var array|null Configuration data loaded from file.
     */
    private $data = null;

    /**
     * Path to the core configuration directory.
     */
    const CONFIG_CORE_PATH = CORE_DIR . "config/";

    /**
     * Path to the application-specific configuration directory.
     */
    const CONFIG_APP_PATH = APP_DIR . "config/";

    /**
     * Configurator constructor.
     *
     * Loads configuration data from either the application-specific config file
     * or the core config file, if available.
     *
     * @param string $configName The name of the configuration file (without extension).
     * @throws Exception If neither the app nor core config file exists.
     */
    public function __construct(string $configName)
    {
        $configAppFilePath = self::CONFIG_APP_PATH . $configName . EXT;
        $configCoreFilePath = self::CONFIG_CORE_PATH . $configName . EXT;

        if (file_exists($configAppFilePath)) {
            $this->data = include $configAppFilePath;
        } elseif (file_exists($configCoreFilePath)) {
            $this->data = include $configCoreFilePath;
        }
    }

    /**
     * Magic method to get a configuration value.
     *
     * @param string $name The key name of the configuration setting.
     * @return mixed The value of the configuration setting.
     */
    public function get(string $name)
    {
        return $this->data[$name];
    }
}
<?php

namespace Hpd\Validatify;
class Configuration {
    private $config;
    private static $instance = null;

    private function __construct($filePath) {
        if (!file_exists($filePath)) {
            throw new \Exception("Configuration file not found: {$filePath}");
        }

        $this->config = parse_ini_file($filePath, true);

        if ($this->config === false) {
            throw new \Exception("Failed to parse configuration file: {$filePath}");
        }
    }

    public static function getInstance($filePath =__DIR__ .'../../config/config.ini') {
        if (self::$instance == null) {
            self::$instance = new Configuration($filePath);
        }
        return self::$instance;
    }

    public function get($key, $default = null) {
        return $this->config[$key] ?? $default;
    }

    public function getAll() {
        return $this->config;
    }
}
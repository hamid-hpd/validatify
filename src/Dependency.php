<?php
namespace Hpd\Validatify;

class Dependency
{
    private static $dependencies = [];

    public static function set(string $key, array $dependencies): void
    {
        self::$dependencies[$key] = $dependencies;
        
    }

    public static function get(string $key): ?array
    {
        return self::$dependencies[$key] ?? null;
    }
}

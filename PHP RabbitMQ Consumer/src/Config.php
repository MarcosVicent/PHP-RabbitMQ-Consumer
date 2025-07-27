<?php

namespace App;

use Dotenv\Dotenv;

class Config
{
    private static bool $loaded = false;

    public static function load(): void
    {
        if (!self::$loaded) {
            $dotenv = Dotenv::createImmutable(__DIR__ . '/../');
            $dotenv->load();
            self::$loaded = true;
        }
    }

    /**
     * @param string
     * @param mixed
     * @return mixed 
     */
    public static function get(string $key, mixed $default = null): mixed
    {
        self::load();
        return $_ENV[$key] ?? $default;
    }
}
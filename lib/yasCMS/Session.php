<?php

namespace yasCMS;

class Session
{

    private static $container;

    public static function start()
    {
        session_start();
        self::$container = &$_SESSION;
    }

    public static function get($key, $default = null)
    {
        return array_key_exists($key, self::$container) ? self::$container[$key] : $default;
    }

    public static function set($key, $val)
    {
        self::$container[$key] = $val;
    }

}
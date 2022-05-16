<?php

namespace Framework\Application;

class Singletone
{
    public static $instance;
    public static Application $app;

    private function __construct($app)
    {
        self::$app = $app;
    }

    private function __clone()
    {

    }

    public static function install(Application $app): void
    {
        if (self::$instance === null) {
            self::$instance = new self($app);
        }
    }

}
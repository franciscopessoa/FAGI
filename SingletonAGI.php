<?php

namespace AGI;

class SingletonAGI
{
    private static $agi;

    private function __construct()
    {
    }
    private function __wakeup()
    {
    }
    private function __clone()
    {
    }

    public static function getInstanceAGI()
    {
        if (self::$agi === null) {
            self::$agi = new Commands();
        }
        return self::$agi;
    }
}

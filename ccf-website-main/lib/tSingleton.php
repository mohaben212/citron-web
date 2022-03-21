<?php
namespace lib;

trait tSingleton {
    protected static $singleton = null;
    public static function getInstance(): self {
        if(null === static::$singleton) {
            $cls = get_called_class();
            static::$singleton = new $cls();
        }
        return static::$singleton;
    }
}

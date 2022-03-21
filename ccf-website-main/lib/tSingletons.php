<?php
namespace lib;

/**
 *
 */
trait tSingletons {
    protected static $singletons = [];
    public static function getInstance(string $key): self {
        if(!array_key_exists($key, static::$singletons)) {
            $cls = get_called_class();
            static::$singletons[$key] = new $cls($key);
        }
        return static::$singletons[$key];
    }
}

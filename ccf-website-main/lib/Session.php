<?php

namespace lib;

/**
 * Description of Session
 *
 */
class Session {
    use tSingleton;
    
    const KEY = '_ccf';
    
    protected function __construct() {
        @session_start();
        if(!array_key_exists(static::KEY, $_SESSION)) {
            $_SESSION[static::KEY] = [
                'user' => null,
                'data' => [],
            ];
        }
    }
    
    public function login(string $login): self {
        $_SESSION[static::KEY]['user'] = $login;
        return $this;
    }
    
    public function logoff(): self {
        $_SESSION[static::KEY]['user'] = null;
        return $this;
    }
    
    public function isLogged(): bool {
        return !empty($_SESSION[static::KEY]['user']);
    }
    
    public function getLogin(): ?string {
        return $_SESSION[static::KEY]['user'];
    }
    
    public function hasData(string $key): bool {
        return array_key_exists($key, $_SESSION[static::KEY]['data']);
    }
    
    public function getData(string $key, $def = null) {
        return $this->hasData($key)? $_SESSION[static::KEY]['data'][$key]:$def;
    }
    
    public function setData(string $key, $value): self {
        $_SESSION[static::KEY]['data'][$key] = $value;
        return $this;
    }
}

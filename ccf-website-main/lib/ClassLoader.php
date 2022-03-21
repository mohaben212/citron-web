<?php
namespace lib;

// this trait isn't loaded yet
require_once __DIR__.'/tSingletons.php';

/**
 * Description of ClassLoader
 *
 */
class ClassLoader {
    use tSingletons;
    
    public static function autoload(string $cls) {
        static::getInstance($cls)->load();
    }
    
    protected ?string $cls = null;
    protected ?string $fn = null;
    protected function __construct(string $cls) {
        $this->cls = preg_replace('`[^a-z0-9A-Z_\\\\]`', '', $cls); // sanitize
        if(empty($this->cls)) {
            throw new exceptions\InvalidClassnameException($cls);
        }
        $this->fn = ROOTDIR.'/'.str_replace('\\', '/', $cls).'.php';
    }
    
    public function load(): self {
        if(file_exists($this->fn)) {
            require_once $this->fn;
        } else {
            throw new exceptions\ClassNotFoundException($this->cls.' (tried '.$this->fn.')');
        }
        return $this;
    }
}

<?php
namespace lib;

/**
 * Description of ApiHandler
 *
 */
class ApiHandler {
    use tSingleton;
    
    const METHOD_GET = 'GET';
    const METHOD_POST = 'POST';
    const METHOD_PUT = 'PUT';
    const METHOD_DELETE = 'DELETE';
    const METHOD_HEAD = 'HEAD';
    const METHOD_OPTIONS = 'OPTIONS';
    
    protected static ?array $paths = null;
    public static function getPaths(): array {
        if(null === static::$paths) {
            static::$paths = [];
            foreach(Config::getInstance('api')->all() as $k => $v) {
                static::$paths[$v['path']] = $v['handler'];
            }
        }
        return static::$paths;
    }
    
    protected static function getHandler(string $path): ?string {
        $handler = null;
        $tr = preg_replace('`[^a-z0-9A-Z.]`', '', $path);
        foreach(static::getPaths() as $p => $h) {
            if(preg_match('`'.$p.'`', $tr)) {
                $handler = '\\lib\\api\\'.$h;
            }
        }
        return $handler;
    }
    
    protected ?string $method = null;
    protected array $data = [];
    
    public function __construct() {
        $this->method = 'GET';
    }
    
    public function getMethod(): ?string {
        return $this->method;
    }

    public function getAllData(): array {
        return $this->data;
    }

    public function setMethod(string $method): self {
        $this->method = $method;
        return $this;
    }

    public function setAllData(array $data) {
        $this->data = $data;
        return $this;
    }

    public function hasData(string $key): bool {
        return array_key_exists($key, $this->data);
    }
    
    public function getData(string $key, $def = null) {
        return $this->hasData($key)? $this->data[$key]:$def;
    }
    
    public function hasHandledPath(): bool {
        return $this->hasData('c')
                && !empty(static::getHandler($this->getData('c')));
    }
    
    public function handle(): array {
        $handler = null;
        if($this->hasHandledPath()) {
            $cls = static::getHandler($this->getData('c'));
            $handler = new $cls($this->data);
        } else {
            $handler = new api\NotFound();
        }
        return $handler->handle();
    }
}

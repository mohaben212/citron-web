<?php
namespace lib;

/**
 * Description of Config
 *
 */
class Config {
    use tSingletons;
    
    protected $content = null;
    protected function __construct(string $cfg) {
        // load for that JSON file
        $cfg = preg_replace('`[^a-z0-9A-Z_-]`', '', $cfg); // sanitize
        $fn = ROOTDIR.'/config/'.$cfg.'.json';
        if(file_exists($fn)) {
            $this->content = json_decode(file_get_contents($fn), true);
            if(null === $this->content) {
                throw new exceptions\InvalidConfigException($cfg, 0, new exceptions\GenericException(json_last_error_msg()));
            }
        } else {
            throw new exceptions\ConfigNotFoundException($cfg);
        }
    }
    
    public function has(string $key): bool {
        return array_key_exists($key, $this->content);
    }
    
    public function get(string $key, $def = null) {
        return $this->has($key)? $this->content[$key]:$def;
    }
    
    public function all(): array {
        return $this->content;
    }
}

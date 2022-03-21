<?php

namespace lib;

/**
 * Description of Lang
 *
 */
class Lang {
    use tSingletons;
    
    protected string $lang;
    protected bool $exists = false;
    protected array $translations = [];
    protected array $intl = [];
    public function __construct(string $lang) {
        $this->lang = str_replace('_', '-', preg_replace('`[^a-z0-9A-Z_-]`', '', $lang));
        $fn = ROOTDIR.'/langs/'.$this->lang.'.xml';
        $xml = @simplexml_load_file($fn);
        if(!empty($xml) && strval($xml->lang) === $lang) {
            foreach($xml->messages->message as $msg) {
                $k = strval($msg->key);
                $v = strval($msg->val);
                $this->translations[$k] = $v;
                $this->intl[$k] = new \MessageFormatter($this->lang, $v);
            }
            $this->exists = true;
        }
    }
    
    public function exists(): bool {
        return $this->exists;
    }
    
    public function hasMessage(string $key) {
        return array_key_exists($key, $this->translations);
    }
    
    public function getMessage(string $key, string $def = ''): string {
        return $this->hasMessage($key)? $this->translations[$key]:$def;
    }
    
    public function translate(string $msg, array $args = []): string {
        return $this->hasMessage($msg)? $this->intl[$msg]->format($args):'';
    }
}

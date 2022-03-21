<?php
namespace lib;

/**
 * Description of GenericApi
 *
 */
abstract class GenericApi {
    private array $data = [];
    private array $errors = [];
    private int $code = 200;
    final public function __construct(array $data = []) {
        $this->data = $data;
    }
    
    final protected function hasData(string $k): bool {
        return array_key_exists($k, $this->data);
    }
    
    final protected function getData(string $k, $def = null) {
        return $this->hasData($k)? $this->data[$k]:$def;
    }
    
    final protected function error(string $error): self {
        $this->errors[] = $error;
        return $this;
    }
    
    final protected function setCode(int $code): self {
        $this->code = $code;
        return $this;
    }
    
    abstract protected function internal(): array;
    
    final public function handle(): array {
        $r = $this->internal();
        return [
            'errors' => $this->errors,
            'code' => $this->code,
            'result' => $r,
        ];
    }
}

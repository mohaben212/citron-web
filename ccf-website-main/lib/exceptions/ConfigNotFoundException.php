<?php
namespace lib\exceptions;

/**
 * Description of ConfigNotFoundException
 *
 */
class ConfigNotFoundException extends \Exception {
    public function __construct(string $message = "", int $code = 0, \Throwable $previous = null) {
        return parent::__construct('Config '.$message.' file was not found', $code, $previous);
    }
}

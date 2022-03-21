<?php

namespace lib\exceptions;

/**
 * Description of InvalidConfigException
 *
 */
class InvalidConfigException extends \Exception {
    public function __construct(string $message = "", int $code = 0, \Throwable $previous = null) {
        return parent::__construct('Config file '.$message.' is invalid', $code, $previous);
    }
}

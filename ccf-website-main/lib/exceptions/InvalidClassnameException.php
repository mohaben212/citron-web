<?php
namespace lib\exceptions;

/**
 * Description of InvalidClassException
 *
 */
class InvalidClassnameException extends \Exception {
    public function __construct(string $message = "", int $code = 0, \Throwable $previous = null) {
        return parent::__construct('Classname '.$message.' is invalid', $code, $previous);
    }
}

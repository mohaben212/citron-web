<?php
namespace lib\exceptions;

/**
 * Description of ClassNotFoundException
 *
 */
class ClassNotFoundException extends \Exception {
    public function __construct(string $message = "", int $code = 0, \Throwable $previous = null) {
        return parent::__construct('Class '.$message.' not found', $code, $previous);
    }
}

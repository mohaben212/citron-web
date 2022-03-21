<?php
namespace lib\api;

/**
 * Description of NotFound
 *
 */
class NotFound extends \lib\GenericApi {
    protected function internal(): array {
        $this->setCode(404);
        $this->error('Not found');
        return [];
    }
}

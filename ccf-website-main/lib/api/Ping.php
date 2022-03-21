<?php

namespace lib\api;

/**
 * Description of Ping
 *
 */
class Ping extends \lib\GenericApi {
    protected function internal(): array {
        $r = microtime(true);
        if($this->hasData('slow')) {
            $r += 1000000;
        }
        return ['pong' => $r,];
    }
}

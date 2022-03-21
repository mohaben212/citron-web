<?php
namespace lib;

/**
 * Description of Encode
 *
 */
class Encode {
    use tSingleton;
    
    public function x(string $src): string {
        return hash('sha512', Config::getInstance('general')->get('salt').$src);
    }
}

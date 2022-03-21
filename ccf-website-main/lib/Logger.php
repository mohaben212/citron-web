<?php
namespace lib;

/**
 * Description of Logger
 *
 */
class Logger {
    use tSingletons;
    
    protected string $type;
    protected function __construct(string $type) {
        if(empty($type)) { $type = 'generic'; }
        $this->type = preg_replace('`[^a-z]`', '', $type);
        if(!file_exists(ROOTDIR.'/logs')) {
            @mkdir(ROOTDIR.'/logs');
        }
    }
    
    public function log(string $str): self {
        $path = ROOTDIR.'/logs/'.$this->type.'.log';
        $fh = @fopen($path, 'a+');
        if(false !== $fh) {
            fwrite($fh, $str.PHP_EOL);
            fclose($fh);
        } else {
            error_log('Unable to write in log file located at "'.$path.'"');
        }
        return $this;
    }
    
}

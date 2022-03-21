<?php
namespace lib;

/**
 * Description of Page
 *
 */
class Page {
    use tSingleton;
    const CTRL_VAR = '_c';
    const DEFAULT_CTRL = 'index';
    
    public static function getInstance(): self {
        return static::current();
    }
    
    public static function current(): self {
        if(null === static::$singleton) {
            static::$singleton = new Page(empty($_REQUEST[static::CTRL_VAR])? static::DEFAULT_CTRL:$_REQUEST[static::CTRL_VAR]);
        }
        return static::$singleton;
    }
    
    public static function reroute(Page $page): self {
        static::$singleton = $page;
        return static::$singleton;
    }
    
    public static function link(string $target): string {
        return htmlspecialchars('index.php?'.static::CTRL_VAR.'='.$target);
    }
    
    protected bool $lock = false;
    protected ?string $ctrl = null;
    protected ?string $title = null;
    protected array $headers = [];
    protected array $scripts = [];
    protected array $styles = [];
    protected ?string $result = null;
    
    public function __construct(string $ctrl) {
        $this->ctrl = str_replace('.', '/', preg_replace('`[^a-z0-9A-Z_.-]`', '', $ctrl)); // sanitize
    }
    
    public function getFilename(): ?string {
        return 'pages/'.$this->ctrl.'.php';
    }
    
    public function exists(): bool {
        return file_exists($this->getFilename());
    }
    
    public function getCtrl(): string {
        return str_replace('/', '.', $this->ctrl);
    }
    
    public function setTitle(string $title): self {
        $this->title = $title;
        return $this;
    }
    
    public function addHeader(string $header, $value): self {
        $this->headers[$header] = $value;
        return $this;
    }
    
    public function addStyleContent(string $css): self {
        $this->styles[] = <<<EOT
<style type="text/css">
{$css}
</style>
EOT;
        return $this;
    }
    
    public function addScriptContent(string $js): self {
        $this->scripts[] = <<<EOT
<script type="text/javascript">
{$js}
</style>
EOT;
        return $this;
    }
    
    public function addStyleFile(string $file): self {
        $this->styles[] = '<link rel="stylesheet" type="text/css" href="res/css/'.$file.'.css" />';
        return $this;
    }
    
    public function addScriptFile(string $file): self {
        $this->scripts[] = '<script type="text/javascript" src="res/js/'.$file.'.js"></script>';
        return $this;
    }
    
    public function addStyleUri(string $uri): self {
        $this->styles[] = '<link rel="stylesheet" type="text/css" href="'.$uri.'" />';
        return $this;
    }
    
    public function addScriptUri(string $uri): self {
        $this->scripts[] = '<script type="text/javascript" src="'.$uri.'"></script>';
        return $this;
    }
    
    public function hasTitle(): bool {
        return !empty($this->title);
    }
    
    public function getTitle(string $def = null): ?string {
        return $this->hasTitle()? $this->title:$def;
    }
    
    public function getHeaders(): array {
        return $this->headers;
    }
    
    public function getStyles(): array {
        return $this->styles;
    }
    
    public function getScripts(): array {
        return $this->scripts;
    }
    
    public function getResult() {
        return $this->result;
    }
    
    public function execute(): bool {
        $returns = false;
        if(!$this->lock) { // avoid recursive on the same page, as long as it's the same object
            $this->lock = true;
            try {
                ob_start(); // should be sandboxed instead
                require_once $this->getFilename();
                $this->result = ob_get_contents();
                $returns = true;
            } catch(\Exception $e) {
                @ob_clean();
                http_response_code(500);
                echo 'A fatal error occured while trying to handle page execution : ';
                echo $e->getMessage();
                echo PHP_EOL;
                echo $e->getTraceAsString();
                exit;
            }
            @ob_end_clean();
            $this->lock = false;
        }
        return $returns;
    }
}

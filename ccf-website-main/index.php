<?php
require_once './_autoload.php';

// special for tests
if(empty($_REQUEST[lib\Page::CTRL_VAR])
        && ('cli' === PHP_SAPI)
        && !empty($argv)
        && (2 === $argc)) {
    $_REQUEST[lib\Page::CTRL_VAR] = $argv[1];
}

$_page = lib\Page::current();

// include base
$_page->addStyleFile('base');
$_page->addScriptFile('base');

if($_page->exists()) {
    $_page->execute(); // run page
} else { // re-route
    $_page = lib\Page::reroute(new lib\Page('errors.notfound'));
    $_page->execute();
}

?><!doctype html>
<html>
    <head>
        <title><?php echo $_page->getTitle('Sans titre'); ?></title>
        <meta charset="utf-8" />
        <?php echo implode(PHP_EOL, $_page->getStyles()); ?>
    </head>
    <body>
        <?php echo $_page->getResult(); ?>
        <footer id="mainFooter">
            Copyright
            🍋
            Internal IT
            ||
            Ping status :
            <span id="pinged" class="info">Waiting...</span>
        </footer>
        <?php echo implode(PHP_EOL, $_page->getScripts()); ?>
    </body>
</html>
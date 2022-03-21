<?php
if(empty($argv) || (1 > $argc)) {
    // tried to access outside of CLI : it is a nope.
    http_response_code(404); // let's trick into a not found
    exit;
}

require_once './_autoload.php';

if((2 !== $argc) || ('--help' === strtolower(trim($argv[1])))) {
    echo 'Usage : `php createuser.php <user>`';
    echo PHP_EOL;
    echo 'Creates a new user <user>. A password will be prompted.';
    echo PHP_EOL;
    exit;
}

$usr = preg_replace('`[^a-z0-9-]`', '', strtolower(trim($argv[1])));
$existing = lib\Database::getInstance()->qo('select count(`login`) as nb from `users` where `login`=:l', ['l' => $usr,]);
if(!empty($existing) && (0 < $existing['nb'])) {
    echo 'That user "'.$usr.'" already exists.';
    echo PHP_EOL;
    exit;
}

echo 'Password for user "'.$usr.'" ? ';
$pwd = readline();
$pwd = trim($pwd);
if(!empty($pwd)) {
    $epwd = \lib\Encode::getInstance()->x($pwd);
    lib\Database::getInstance()->qi("insert ignore into `users` (`login`, `pwd`) values(:u, :p)", ['u' => $usr, 'p' => $epwd,]);
} else {
    echo 'That password is empty';
    echo PHP_EOL;
    exit;
}

echo 'User created with success';
echo PHP_EOL;
exit;

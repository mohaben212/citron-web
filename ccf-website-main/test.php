<?php
if(empty($argv) || (1 > $argc)) {
    // tried to access outside of CLI : it is a nope.
    http_response_code(404); // let's trick into a not found
    exit;
}

require_once './_autoload.php';

echo PHP_EOL;
echo 'Testing PHP version : ';

echo '.';
assert(
        !!version_compare(PHP_VERSION, "7.4"),
        'PHP Version has to be at least 7.4'
);

echo ' Done.';
echo PHP_EOL;

echo PHP_EOL;
echo 'Testing ClassLoader : ';

echo '.';
$t = function() {
    try { ClassLoader::getInstance("lib\\ClassLoader"); return true; }
    catch(Exception $e) { return false; }
};
assert(
        $t,
        'ClassLoader should be found'
);

echo '.';
$t = function(){
    try { new UnexistingClass(); return false; }
    catch(Exception $e) { return true; }
};
assert(
        $t,
        'UnexistingClass should not be found'
);

echo ' Done.';
echo PHP_EOL;


echo PHP_EOL;
echo 'Testing Basic Config : ';

echo '.';
try {
    lib\Config::getInstance('general');
} catch(Exception $e) {
    echo 'general config should be here';
}

echo ' Done.';
echo PHP_EOL;


echo PHP_EOL;
echo 'Testing Database : ';

try {
    echo '.';
    lib\Database::getInstance()->useDatabase(\lib\Config::getInstance('sql')->get('db').'_test');
    echo '.';
    lib\Database::getInstance()->q("delete from `vacations`");
    echo '.';
    lib\Database::getInstance()->q("delete from `contracts`");
    echo '.';
    lib\Database::getInstance()->q("delete from `persons`");
    echo '.';
    $person = new dal\Person();
    $person->setGender('m');
    $person->setFirstname('John');
    $person->setLastname('Doe');
    $person->insert();
    assert($person->getId(), 'Person should be inserted finely (got "'.$person->getId().'")');
    echo ' Done.';
} catch(Exception $e) {
    echo 'Something went wrong : '.$e->getMessage();
}
echo PHP_EOL;

echo PHP_EOL;
echo 'Testing integrity : ';

echo '.';
assert(
        lib\Config::getInstance('general')->get('test.crc') === md5(file_get_contents(__FILE__)),
        'Test file was altered'
);

echo ' Done.';
echo PHP_EOL;

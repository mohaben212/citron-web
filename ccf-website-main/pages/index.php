<?php
    if(\lib\Session::getInstance()->isLogged()) {
        include __DIR__.'/authed.php';
    } else {
        include __DIR__.'/unauth.php';
    }
    
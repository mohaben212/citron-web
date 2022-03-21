<?php
\lib\Session::getInstance()->logoff();
header('Location:index.php');
exit;

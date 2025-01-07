<?php
use Xmf\Request;
use XoopsModules\Tad_login\Tools;
require_once 'header.php';
header('HTTP/1.1 200 OK');

$op = Request::getString('op');
$pass = Request::getString('value');
$uname = Request::getString('pk');

switch ($op) {
    case "change_pass":
        echo Tools::change_pass($pass, $uname, false);
        break;
}

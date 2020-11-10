<?php
use Xmf\Request;
require_once 'header.php';
require_once "../function.php";

$op = Request::getString('op');
$pass = Request::getString('value');
$uname = Request::getString('pk');

switch ($op) {
    case "change_pass":
        echo change_pass($pass, $uname, false);
        break;
}

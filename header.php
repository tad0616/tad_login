<?php
require_once dirname(dirname(__DIR__)) . '/mainfile.php';
require_once __DIR__ . '/function.php';

//判斷是否對該模組有管理權限
if (!isset($_SESSION['tad_login']['isAdmin'])) {
    $_SESSION['tad_login']['isAdmin'] = ($xoopsUser) ? $xoopsUser->isAdmin() : false;
}

$interface_menu[_TAD_TO_MOD] = 'index.php';
if ($_SESSION['tad_login']['isAdmin']) {
    $interface_menu[_TAD_TO_ADMIN] = 'admin/main.php';
}

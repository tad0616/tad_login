<?php
//判斷是否對該模組有管理權限
if (!isset($_SESSION['tad_login_adm'])) {
    $_SESSION['tad_login_adm'] = isset($xoopsUser) && \is_object($xoopsUser) ? $xoopsUser->isAdmin() : false;
}

$interface_menu[_MD_TADLOGIN_LOGIN_LIST] = 'index.php';
$interface_icon[_MD_TADLOGIN_LOGIN_LIST] = "fa-sign-in";

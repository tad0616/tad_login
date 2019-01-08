<?php
include_once __DIR__ . "/../../../../mainfile.php";
if (!isset($xoopsModuleConfig)) {
    $modhandler        = xoops_getHandler('module');
    $tad_loginModule   = $modhandler->getByDirname("tad_login");
    $config_handler    = xoops_getHandler('config');
    $xoopsModuleConfig = $config_handler->getConfigsByCat(0, $tad_loginModule->mid());
}

// require 'fun.php';
$provideruri             = 'https://tyc.sso.edu.tw';
$_SESSION['auth_method'] = 'ty_edu';
$responsetype            = array('code');
$scope                   = array('openid', 'openid2', 'email', 'profile', 'eduinfo');
$clientid                = $xoopsModuleConfig['ty_edu_clientid'];
$clientsecret            = $xoopsModuleConfig['ty_edu_clientsecret'];
$redirecturi             = XOOPS_URL . '/modules/tad_login/edu_callback.php';

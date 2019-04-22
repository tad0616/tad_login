<?php
include_once __DIR__ . '/../../../../mainfile.php';
if (!isset($xoopsModuleConfig)) {
    $modhandler = xoops_getHandler('module');
    $tad_loginModule = $modhandler->getByDirname('tad_login');
    $config_handler = xoops_getHandler('config');
    $xoopsModuleConfig = $config_handler->getConfigsByCat(0, $tad_loginModule->mid());
}

// require 'fun.php';
$provideruri = 'https://tc.sso.edu.tw';
$_SESSION['auth_method'] = 'tc_edu';
$responsetype = ['code'];
$scope = ["educloudroles", "openid", "profile", "eduinfo", "openid2", "email"];
$clientid = $xoopsModuleConfig['tc_edu_clientid'];
$clientsecret = $xoopsModuleConfig['tc_edu_clientsecret'];
$redirecturi = XOOPS_URL . '/modules/tad_login/edu_callback.php';

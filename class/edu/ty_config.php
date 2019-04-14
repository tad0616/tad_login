<?php
require_once  dirname(dirname(dirname(dirname(__DIR__)))) . '/mainfile.php';
if (!isset($xoopsModuleConfig)) {
    $moduleHandler = xoops_getHandler('module');
    $tad_loginModule = $moduleHandler->getByDirname('tad_login');
    $configHandler = xoops_getHandler('config');
    $xoopsModuleConfig = $configHandler->getConfigsByCat(0, $tad_loginModule->mid());
}

// require __DIR__ . '/fun.php';
$provideruri = 'https://tyc.sso.edu.tw';
$_SESSION['auth_method'] = 'ty_edu';
$responsetype = ['code'];
$scope = ['openid', 'openid2', 'email', 'profile', 'eduinfo'];
$clientid = $xoopsModuleConfig['ty_edu_clientid'];
$clientsecret = $xoopsModuleConfig['ty_edu_clientsecret'];
$redirecturi = XOOPS_URL . '/modules/tad_login/edu_callback.php';

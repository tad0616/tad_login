<?php
require_once  dirname(dirname(dirname(dirname(__DIR__)))) . '/mainfile.php';
if (!isset($xoopsModuleConfig)) {
    $moduleHandler = xoops_getHandler('module');
    $tad_loginModule = $moduleHandler->getByDirname('tad_login');
    $configHandler = xoops_getHandler('config');
    $xoopsModuleConfig = $configHandler->getConfigsByCat(0, $tad_loginModule->mid());
}

// require __DIR__ . '/fun.php';
$provideruri = 'https://oidc.tanet.edu.tw';
$_SESSION['auth_method'] = 'edu';
$responsetype = ['code'];
$scope = ['openid', 'email', 'profile', 'openid2'];
$clientid = $xoopsModuleConfig['edu_clientid'];
$clientsecret = $xoopsModuleConfig['edu_clientsecret'];
$redirecturi = XOOPS_URL . '/modules/tad_login/edu_callback.php';

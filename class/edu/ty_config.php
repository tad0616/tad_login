<?php
include_once __DIR__ . "/../../../../mainfile.php";
$modhandler      = xoops_getHandler('module');
$tad_loginModule = $modhandler->getByDirname("tad_login");
$config_handler  = xoops_getHandler('config');
$tad_loginConfig = $config_handler->getConfigsByCat(0, $tad_loginModule->mid());

require 'fun.php';
$provideruri             = 'https://tyc.sso.edu.tw';
$_SESSION['auth_method'] = 'ty_edu';

//only support code flow
$responsetype = array('code');
//allowed scops
$scope = array('openid', 'email', 'profile', 'eduinfo', 'openid2');
//clientid
$clientid = $tad_loginConfig['ty_edu_clientid'];
//clientsecret
$clientsecret = $tad_loginConfig['ty_edu_clientsecret'];

//nonce
// $nonce = generateRandomString();
// //state
// $state = generateRandomString(10);
//redirect_uri
$redirecturi = XOOPS_URL . '/modules/tad_login/edu_callback.php';
//eduinfo endpoint
$eduinfoep = 'https://tyc.sso.edu.tw/oidc/v1/userinfo';
// $eduinfoep = 'https://tyc.sso.edu.tw/cncresource/api/v1/oidc/eduinfo';

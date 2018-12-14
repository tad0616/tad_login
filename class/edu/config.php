<?php

include_once __DIR__ . "/../../../../mainfile.php";
$modhandler      = xoops_getHandler('module');
$tad_loginModule = $modhandler->getByDirname("tad_login");
$config_handler  = xoops_getHandler('config');
$tad_loginConfig = $config_handler->getConfigsByCat(0, $tad_loginModule->getVar('mid'));

require 'fun.php';
$provideruri = 'https://oidc.tanet.edu.tw';
//only support code flow
$responsetype = array('code');
//allowed scops
$scope = array('openid', 'email', 'profile', 'openid2');
//clientid
$clientid = $tad_loginConfig['edu_clientid'];
//clientsecret
$clientsecret = $tad_loginConfig['edu_clientsecret'];

//nonce
$nonce = generateRandomString();
//state
$state = generateRandomString(10);
//redirect_uri
$redirecturi = XOOPS_URL . '/modules/tad_login/edu_callback.php';
// $redirecturi = 'http://dream.k12cc.tw/modules/tad_login/edu_callback.php';
//eduinfo endpoint
$eduinfoep = 'https://oidc.tanet.edu.tw/moeresource/api/v1/oidc/eduinfo';

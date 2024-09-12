<?php
use Jumbojett\OpenIDConnectClient;
use Xmf\Request;
use XoopsModules\Tadtools\Utility;

require_once __DIR__ . '/vendor/autoload.php';
include_once __DIR__ . '/../../../../mainfile.php';
include_once __DIR__ . '/../../function.php';

$auth_method = Request::getString('auth_method');

if (!isset($xoopsModuleConfig)) {
    $modhandler = xoops_getHandler('module');
    $tad_loginModule = $modhandler->getByDirname('tad_login');
    $config_handler = xoops_getHandler('config');
    $xoopsModuleConfig = $config_handler->getConfigsByCat(0, $tad_loginModule->mid());
}
$oidc_setup = json_decode($xoopsModuleConfig['oidc_setup'], true);
$auth_method = $_SESSION['auth_method'] ? $_SESSION['auth_method'] : $auth_method;

$oidc_arr = $all_oidc[$auth_method];
$responsetype = ['code'];

$oidc = new OpenIDConnectClient($oidc_arr['provideruri'], $oidc_setup[$auth_method]['clientid'], $oidc_setup[$auth_method]['clientsecret']);

$oidc->setResponseTypes($responsetype);
$oidc->setRedirectURL(XOOPS_URL . '/modules/tad_login/edu_callback.php');
$oidc->setAllowImplicitFlow(true);
$oidc->addScope($oidc_arr['scope']);
if (isset($oidc_arr['providerparams']) && is_array($oidc_arr['providerparams'])) {
    $oidc->providerConfigParam($oidc_arr['providerparams']);
}
$oidc->authenticate();

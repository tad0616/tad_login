<?php
include_once "../../mainfile.php";
include_once "function.php";

if (!isset($_GET['code']) && !isset($_SESSION['token'])) {
    global $xoopsModuleConfig;
    $state = generateRandomString();
    $nonce = generateRandomString();
    header("location:https://tyc.sso.edu.tw/oidc/v1/azp?response_type=code&client_id={$xoopsModuleConfig['ty_edu_clientid']}&redirect_uri=" . XOOPS_URL . "/modules/tad_login/edu_callback.php&scope=openid+email+profile+eduinfo+openid2&state={$state}&nonce={$nonce}");
    exit;
} elseif (!isset($_SESSION['token'])) {
    $_SESSION['state'] = $_GET['state'];

    $param = [
        'grant_type'    => 'authorization_code',
        'client_id'     => $xoopsModuleConfig['ty_edu_clientid'],
        'client_secret' => $xoopsModuleConfig['ty_edu_clientsecret'],
        'redirect_uri'  => XOOPS_URL . '/modules/tad_login/tp_callback.php',
        'code'          => $_GET['code'],
    ];
    $response = do_post('https://tyc.sso.edu.tw/oidc/v1/token', $param);
    $token    = json_decode($response);
    ini_set("session.gc_maxlifetime", $token->expires_in);
    $_SESSION['token']   = $token->access_token;
    $_SESSION['refresh'] = $token->refresh_token;
    $_SESSION['expire']  = time() + $token->expires_in;
} elseif (time() > $_SESSION['expire']) {
    $param = [
        'grant_type'    => 'refresh_token',
        'refresh_token' => $_SESSION['refresh'],
        'client_id'     => $xoopsModuleConfig['ty_edu_clientid'],
        'client_secret' => $xoopsModuleConfig['ty_edu_clientsecret'],
        'scope'         => 'openid email profile eduinfo openid2',
    ];
    $response = do_post('https://ldap.tp.edu.tw/oauth/token', $param);
    $token    = json_decode($response);
    ini_set("session.gc_maxlifetime", $token->expires_in);
    $_SESSION['token']   = $token->access_token;
    $_SESSION['refresh'] = $token->refresh_token;
    $_SESSION['expire']  = time() + $token->expires_in;
}

$user    = requestProtectedApi('https://tyc.sso.edu.tw/oidc/v1/userinfo', $_SESSION['token']);
$eduinfo = requestProtectedApi('https://tyc.sso.edu.tw/cncresource/api/v1/oidc/eduinfo', $_SESSION['token']);

var_export($user);
var_export($eduinfo);
exit;
// $user
// array (
//     'sub' => 'yinghsang',
//     'name' => '林俊興',
//     'given_name' => '俊興',
//     'family_name' => '林',
//     'email' => 'yinghsang@ms.tyc.edu.tw',
//   )

if ($user['email']) {
    $myts       = MyTextsanitizer::getInstance();
    $uname      = $user['sub'] . "_ty";
    $name       = $myts->addSlashes($user['name']);
    $email      = $user['email'];
    $SchoolCode = $myts->addSlashes($school['tpUniformNumbers']);
    // $JobName    = $user['role'] == '教師' ? "teacher" : "student";
    $JobName = "teacher";
    $bio     = '';
    $url     = $school['wWWHomePage'];
    $from    = '';
    $sig     = '';
    $occ     = $school['description'];

    login_xoops($uname, $name, $email, $SchoolCode, $JobName, $url, $from, $sig, $occ, $bio);
}

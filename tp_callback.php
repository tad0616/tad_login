<?php
use XoopsModules\Tad_login\Tools;
require_once dirname(dirname(__DIR__)) . '/mainfile.php';

$oidc_setup = json_decode($xoopsModuleConfig['oidc_setup'], true);

if (!isset($_GET['code']) && !isset($_SESSION['token'])) {
    header("location:https://ldap.tp.edu.tw/oauth/authorize?client_id={$oidc_setup['tp_ldap']['clientid']}&redirect_uri=" . XOOPS_URL . '/modules/tad_login/tp_callback.php&response_type=code&scope=user profile');
    exit;
} elseif (!isset($_SESSION['token'])) {
    $param = [
        'grant_type' => 'authorization_code',
        'client_id' => $oidc_setup['tp_ldap']['clientid'],
        'client_secret' => $oidc_setup['tp_ldap']['clientsecret'],
        'redirect_uri' => XOOPS_URL . '/modules/tad_login/tp_callback.php',
        'code' => $_GET['code'],
    ];
    $response = Tools::do_post('https://ldap.tp.edu.tw/oauth/token', $param);
    $token = json_decode($response);
    ini_set('session.gc_maxlifetime', $token->expires_in);
    $_SESSION['token'] = $token->access_token;
    $_SESSION['refresh'] = $token->refresh_token;
    $_SESSION['expire'] = time() + $token->expires_in;
} elseif (time() > $_SESSION['expire']) {
    $param = [
        'grant_type' => 'refresh_token',
        'refresh_token' => $_SESSION['refresh'],
        'client_id' => $oidc_setup['tp_ldap']['clientid'],
        'client_secret' => $oidc_setup['tp_ldap']['clientsecret'],
        'scope' => 'user profile',
    ];
    $response = Tools::do_post('https://ldap.tp.edu.tw/oauth/token', $param);
    $token = json_decode($response);
    ini_set('session.gc_maxlifetime', $token->expires_in);
    $_SESSION['token'] = $token->access_token;
    $_SESSION['refresh'] = $token->refresh_token;
    $_SESSION['expire'] = time() + $token->expires_in;
}

$user = Tools::requestProtectedApi('https://ldap.tp.edu.tw/api/user', $_SESSION['token']);
$profile = Tools::requestProtectedApi('https://ldap.tp.edu.tw/api/profile', $_SESSION['token']);
// $school = requestProtectedApi('https://ldap.tp.edu.tw/api/school/' . $profile['o'], $_SESSION['token']);

// var_export($profile);
// array (
//     'role' => '校長',
//     'o' => 'zhps',
//     'gender' => '1',
//     'birthDate' => '19700101',
//     'organization' => '臺北市大同區日新國民小學',
//   )
// var_export($user);
// array (
//     'role' => '校長',
//     'uuid' => '6d9d75ba-c47c-1038-9a53-a5ea9162bdf0',
//     'name' => '林大同',
//     'email' => 'digimagic1997@gmail.com',
//     'email_login' => false,
//     'mobile' => NULL,
//     'mobile_login' => false,
//   )
// exit;
if ($user['email']) {
    $myts = \MyTextSanitizer::getInstance();
    list($id, $domain) = explode('@', $user['email']);
    $uname = $id . '_tp';
    $name = $myts->addSlashes($user['name']);
    $email = $user['email'];
    $SchoolCode = $myts->addSlashes($school['tpUniformNumbers']);
    $JobName = '教師' === $user['role'] ? 'teacher' : 'student';
    // $JobName = "teacher";
    $bio = '';
    $url = '';
    $from = '臺北市';
    $sig = '';
    $occ = $profile['organization'];

    Tools::login_xoops($uname, $name, $email, $SchoolCode, $JobName, $url, $from, $sig, $occ, $bio);
}

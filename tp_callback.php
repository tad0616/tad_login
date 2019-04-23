<?php
include_once '../../mainfile.php';
include_once 'function.php';

if (!isset($_GET['code']) && !isset($_SESSION['token'])) {
    header("location:https://ldap.tp.edu.tw/oauth/authorize?client_id={$xoopsModuleConfig['tp_ldap_clientid']}&redirect_uri=" . XOOPS_URL . '/modules/tad_login/tp_callback.php&response_type=code&scope=user profile');
    exit;
} elseif (!isset($_SESSION['token'])) {
    $param = [
        'grant_type' => 'authorization_code',
        'client_id' => $xoopsModuleConfig['tp_ldap_clientid'],
        'client_secret' => $xoopsModuleConfig['tp_ldap_clientsecret'],
        'redirect_uri' => XOOPS_URL . '/modules/tad_login/tp_callback.php',
        'code' => $_GET['code'],
    ];
    $response = do_post('https://ldap.tp.edu.tw/oauth/token', $param);
    $token = json_decode($response);
    ini_set('session.gc_maxlifetime', $token->expires_in);
    $_SESSION['token'] = $token->access_token;
    $_SESSION['refresh'] = $token->refresh_token;
    $_SESSION['expire'] = time() + $token->expires_in;
} elseif (time() > $_SESSION['expire']) {
    $param = [
        'grant_type' => 'refresh_token',
        'refresh_token' => $_SESSION['refresh'],
        'client_id' => $xoopsModuleConfig['tp_ldap_clientid'],
        'client_secret' => $xoopsModuleConfig['tp_ldap_clientsecret'],
        'scope' => 'user profile',
    ];
    $response = do_post('https://ldap.tp.edu.tw/oauth/token', $param);
    $token = json_decode($response);
    ini_set('session.gc_maxlifetime', $token->expires_in);
    $_SESSION['token'] = $token->access_token;
    $_SESSION['refresh'] = $token->refresh_token;
    $_SESSION['expire'] = time() + $token->expires_in;
}

$user = requestProtectedApi('https://ldap.tp.edu.tw/api/user', $_SESSION['token']);
$profile = requestProtectedApi('https://ldap.tp.edu.tw/api/profile', $_SESSION['token']);
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
    $myts = MyTextSanitizer::getInstance();
    list($id, $domain) = explode('@', $user['email']);
    $uname = $id . '_tp';
    $name = $myts->addSlashes($user['name']);
    $email = $user['email'];
    $SchoolCode = $myts->addSlashes($school['tpUniformNumbers']);
    $JobName = '教師' === $user['role'] ? 'teacher' : 'student';
    // $JobName = "teacher";
    $bio = '';
    $url = '';
    $from = '';
    $sig = '';
    $occ = $profile['organization'];

    login_xoops($uname, $name, $email, $SchoolCode, $JobName, $url, $from, $sig, $occ, $bio);
}

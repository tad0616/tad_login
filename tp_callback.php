<?php
include_once '../../mainfile.php';
include_once 'function.php';

if (!isset($_GET['code']) && !isset($_SESSION['token'])) {
    header("location:https://ldap.tp.edu.tw/oauth/authorize?client_id={$xoopsModuleConfig['tp_edu_clientid']}&redirect_uri=" . XOOPS_URL . '/modules/tad_login/tp_callback.php&response_type=code&scope=user,profile,school');
    exit;
} elseif (!isset($_SESSION['token'])) {
    $param = [
        'grant_type' => 'authorization_code',
        'client_id' => $xoopsModuleConfig['tp_edu_clientid'],
        'client_secret' => $xoopsModuleConfig['tp_edu_clientsecret'],
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
        'client_id' => $xoopsModuleConfig['tp_edu_clientid'],
        'client_secret' => $xoopsModuleConfig['tp_edu_clientsecret'],
        'scope' => 'user,profile,school',
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
$school = requestProtectedApi('https://ldap.tp.edu.tw/api/school/' . $profile['o'], $_SESSION['token']);

// var_export($school);
// exit;
// array (
//     'role' => '教師',
//     'uuid' => '0c04373a-06e0-1038-8694-e52b910af178',
//     'name' => 'OOO',
//     'email' => 'aaa@bbb.tp.edu.tw',
//     'email_login' => true,
//     'mobile' => '0912345678',
//     'mobile_login' => false,
//   )
// array (
//     'role' => '教師',
//     'gender' => '1',
//     'o' => 'bbb',
//     'organization' => '臺北市立bb國民中學',
//   )
// array (
//     'o' => 'bbb',
//     'businessCategory' => '國民中學',
//     'st' => 'bb區',
//     'description' => '臺北市立bb國民中學',
//     'facsimileTelephoneNumber' => '(02)2000000',
//     'telephoneNumber' => '(02)27000000',
//     'postalCode' => '114',
//     'street' => '臺北市bb區xx街一號',
//     'postOfficeBox' => '212',
//     'wWWHomePage' => 'http://www.bbb.tp.edu.tw/',
//     'tpUniformNumbers' => '403501',
//     'tpIpv4' => '163.00.00.0/24',
//     'tpIpv6' => '2001:000:0000::/48',
//   )

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
    $url = $school['wWWHomePage'];
    $from = '';
    $sig = '';
    $occ = $school['description'];

    login_xoops($uname, $name, $email, $SchoolCode, $JobName, $url, $from, $sig, $occ, $bio);
}

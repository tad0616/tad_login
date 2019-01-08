<?php
include_once "../../mainfile.php";
if ($_SESSION['auth_method'] == 'ty_edu') {
    require_once 'class/edu/ty_auth.php';
} else {
    require_once 'class/edu/auth.php';
}

//verified idtoken
$claims = $oidc->getVerifiedClaims();

//userinfo
$userinfo = $oidc->requestUserInfo();
//accesstoken
$accesstoken = $oidc->getAccessToken();

//get eduinfo
if ($_SESSION['auth_method'] == 'ty_edu') {
    $eduinfo = requestProtectedApi($eduinfoep, $accesstoken, false, true);
} else {
    $eduinfo = requestProtectedApi($eduinfoep, $accesstoken, false, true);
}

$claims       = json_decode(json_encode($claims), true);
$userinfo     = json_decode(json_encode($userinfo), true);
$eduinfo_json = json_encode($eduinfo);
$eduinfo      = json_decode($eduinfo_json, true);
// $claims
// array (
//     'sub' => 'yinghsang',
//     'aud' => '2831ce20cecf97f8a8dd595a9a5ea6c7',
//     'iss' => 'https://tyc.sso.edu.tw',
//     'preferred_username' => 'yinghsang',
//     'exp' => 1546870065,
//     'iat' => 1546866465,
//     'nonce' => '195ed52b471031ac6e088bf45f2ecc89',
//     'open2_id' => 'https://openid.tyc.edu.tw/index.php/idpage?user=yinghsang',
//   )
// $userinfo
// array (
//     'sub' => 'yinghsang',
//     'name' => '林俊興',
//     'given_name' => '俊興',
//     'family_name' => '林',
//     'email' => 'yinghsang@ms.tyc.edu.tw',
//   )
// $eduinfo
// array (
//     'sub' => 'yinghsang',
//     'name' => '林俊興',
//     'given_name' => '俊興',
//     'family_name' => '林',
//     'email' => 'yinghsang@ms.tyc.edu.tw',
//   )

var_export($claims);
var_export($userinfo);
var_export($eduinfo);

exit;

if ($userinfo['email']) {

    $myts       = MyTextsanitizer::getInstance();
    $uname      = $userinfo['sub'] . "_ty";
    $name       = $myts->addSlashes($userinfo['name']);
    $email      = $userinfo['email'];
    $SchoolCode = $myts->addSlashes($eduinfo['schoolid']);
    // $JobName    = strpos($eduinfo_json, '教師') !== false ? "teacher" : "student";
    $JobName = "teacher";
    $bio     = '';
    $url     = '';
    $from    = '';
    $sig     = '';
    $occ     = '';

    login_xoops($uname, $name, $email, $SchoolCode, $JobName, $url, $from, $sig, $occ, $bio);
}

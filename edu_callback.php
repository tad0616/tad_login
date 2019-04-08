<?php
include_once "../../mainfile.php";
include_once "function.php";

if ($_SESSION['auth_method'] == 'ty_edu') {
    require_once 'class/edu/ty_auth.php';
} else {
    require_once 'class/edu/auth.php';
}

//verified idtoken
$claims = $oidc->getVerifiedClaims();
$claims = json_decode(json_encode($claims), true);
// var_dump($claims);

//userinfo
$userinfo = $oidc->requestUserInfo();
$userinfo = json_decode(json_encode($userinfo), true);
// var_dump($userinfo);

//accesstoken
$accesstoken = $oidc->getAccessToken();
// var_dump($accesstoken);

//get eduinfo
if ($_SESSION['auth_method'] == 'ty_edu') {
    $eduinfoep = 'https://tyc.sso.edu.tw/cncresource/api/v1/eduinfo';
    // echo $eduinfoep;
    $eduinfo = requestProtectedApi($eduinfoep, $accesstoken, true, false);
} else {
    $eduinfoep = 'https://oidc.tanet.edu.tw/moeresource/api/v1/oidc/eduinfo';
    // echo $eduinfoep;
    $eduinfo = requestProtectedApi($eduinfoep, $accesstoken, true, true);
}
// var_export($claims);
// var_export($userinfo);
// var_export($eduinfo);

// exit;

if ($userinfo['email'] and $_SESSION['auth_method'] == 'ty_edu') {

    $myts         = MyTextsanitizer::getInstance();
    $uname        = $userinfo['sub'] . "_ty";
    $name         = $myts->addSlashes($userinfo['name']);
    $email        = $userinfo['email'];
    $SchoolCode   = $myts->addSlashes($eduinfo['schoolid']);
    $eduinfo_json = json_encode($eduinfo, 256);
    $JobName      = strpos($eduinfo_json, '教師') !== false ? "teacher" : "student";
    // $JobName      = "teacher";
    $bio  = '';
    $url  = '';
    $from = '';
    $sig  = '';
    $occ  = '';

    login_xoops($uname, $name, $email, $SchoolCode, $JobName, $url, $from, $sig, $occ, $bio);
} else {

    $myts       = MyTextsanitizer::getInstance();
    $uname      = $claims['preferred_username'] . "_edu";
    $name       = $myts->addSlashes($userinfo['name']);
    $email      = $claims['email'];
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

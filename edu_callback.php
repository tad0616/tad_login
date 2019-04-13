<?php
include_once '../../mainfile.php';
include_once 'function.php';

if ('ty_edu' == $_SESSION['auth_method']) {
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
if ('ty_edu' == $_SESSION['auth_method']) {
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

if ($userinfo['email'] and 'ty_edu' == $_SESSION['auth_method']) {
    $myts = MyTextSanitizer::getInstance();
    $uname = $userinfo['sub'] . '_ty';
    $name = $myts->addSlashes($userinfo['name']);
    $email = $userinfo['email'];
    $SchoolCode = $myts->addSlashes($eduinfo['schoolid']);
    $eduinfo_json = json_encode($eduinfo, 256);
    $JobName = false !== mb_strpos($eduinfo_json, '教師') ? 'teacher' : 'student';
    // $JobName      = "teacher";
    $bio = '';
    $url = '';
    $from = '';
    $sig = '';
    $occ = '';

    login_xoops($uname, $name, $email, $SchoolCode, $JobName, $url, $from, $sig, $occ, $bio);
} else {
    $myts = MyTextSanitizer::getInstance();
    $uname = $claims['preferred_username'] . '_edu';
    $name = $myts->addSlashes($userinfo['name']);
    $email = $claims['email'];
    $SchoolCode = $myts->addSlashes($eduinfo['schoolid']);
    // $JobName    = strpos($eduinfo_json, '教師') !== false ? "teacher" : "student";
    $JobName = 'teacher';
    $bio = '';
    $url = '';
    $from = '';
    $sig = '';
    $occ = '';

    login_xoops($uname, $name, $email, $SchoolCode, $JobName, $url, $from, $sig, $occ, $bio);
}

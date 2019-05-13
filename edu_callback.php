<?php
require_once '../../mainfile.php';
require_once 'function.php';
require_once 'class/edu/auth.php';

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

$eduinfo = requestProtectedApi($oidc_arr['eduinfoep'], $accesstoken, true, $oidc_arr['gzipenable']);

// var_export($claims);
// var_export($userinfo);
// var_export($eduinfo);

// exit;

if ($userinfo['email']) {
    $myts = \MyTextSanitizer::getInstance();
    $uname = $userinfo['sub'] . '_' . $oidc_arr['tail'];

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
    $myts = \MyTextSanitizer::getInstance();
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

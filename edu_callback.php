<?php

require_once 'class/edu/auth.php';

//verified idtoken
$claims = $oidc->getVerifiedClaims();
//userinfo
$userinfo = $oidc->requestUserInfo();
//accesstoken
$accesstoken = $oidc->getAccessToken();

//get eduinfo
$eduinfo = requestProtectedApi($eduinfoep, $accesstoken, false, true);

$claims       = json_decode(json_encode($claims), true);
$userinfo     = json_decode(json_encode($userinfo), true);
$eduinfo_json = json_encode($eduinfo);
$eduinfo      = json_decode($eduinfo_json, true);
// $claims
// array (
//   'sub' => 'e35e0ee5-34da-4887-96ca-089466c44c43',
//   'aud' => 'c705a3ecf3eaa66620beb044e2b55fd9',
//   'iss' => 'https://oidc.tanet.edu.tw',
//   'preferred_username' => 'tad0616',
//   'exp' => 1536832491,
//   'iat' => 1536828891,
//   'nonce' => 'de230852d21a91cdfd022f274a003157',
//   'email' => 'tad0616@mail.edu.tw',
//   'openid2_id' =>
//   array (
//     0 => 'https://openid.tn.edu.tw/op/user.aspx/Tad',
//   ),
// )
// $userinfo
// array (
//   'sub' => 'e35e0ee5-34da-4887-96ca-089466c44c43',
//   'email_verified' => true,
//   'name' => '吳弘凱',
//   'preferred_username' => 'tad0616',
//   'given_name' => '弘凱',
//   'family_name' => '吳',
//   'email' => 'tad0616@mail.edu.tw',
// )
// $eduinfo
// array (
//   'schoolid' => '114620',
//   'sub' => 'e35e0ee5-34da-4887-96ca-089466c44c43',
//   'titles' =>
//   array (
//     0 =>
//     array (
//       'schoolid' => '114620',
//       'titles' =>
//       array (
//         0 => '教師',
//       ),
//     ),
//   ),
// )

if ($claims['email']) {
    include_once "header.php";

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

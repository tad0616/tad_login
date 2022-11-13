<?php
require_once '../../mainfile.php';
require_once 'function.php';
require_once 'class/edu/auth.php';

//verified idtoken
$claims = $oidc->getVerifiedClaims();
$claims = json_decode(json_encode($claims), true);
// var_dump($claims);

//userinfo
$userinfo = [];
if(!isset($oidc_arr['ignore_userinfo']) || $oidc_arr['ignore_userinfo'] !== true){
    $userinfo = $oidc->requestUserInfo();
    $userinfo = json_decode(json_encode($userinfo), true);
}
// var_dump($userinfo);

//accesstoken
$accesstoken = $oidc->getAccessToken();
// var_dump($accesstoken);

//get eduinfo
$eduinfo = [];
if(isset($oidc_arr['eduinfoep']) && !empty($oidc_arr['eduinfoep']) && in_array('eduinfo', $oidc_arr['scope'])){
    $eduinfo = requestProtectedApi($oidc_arr['eduinfoep'], $accesstoken, true, $oidc_arr['gzipenable']);
}

// var_export($claims);
// var_export($userinfo);
// var_export($eduinfo);

// exit;

//sanitizer object
$myts = \MyTextSanitizer::getInstance();

//default values
$url = '';
$from = '';
$sig = '';
$occ = '';
$bio = "";

if($auth_method === "kh_oidc"){//高雄市例外處理
    $uname = $claims['sub'] . '_' . $oidc_arr['tail']; //視有無申請真實帳號，沒有的話為hash值(即sub使用pairwaise)
    $name = $myts->addSlashes($claims['name']); //視有無申請真實完整姓名，沒有的話為<姓+老師/學生>
    $email = $claims['email']; //每個人不一定有mail，沒有為空白字串
    $SchoolCode = $myts->addSlashes($claims['kh_profile']['schoolid']);//教育部6位學校代碼
    $JobName = (isset($claims['gender']))?'student':'teacher';
    $from = $oidc_arr['from'];
}else if ($userinfo['email']) {
    $uname = $userinfo['sub'] . '_' . $oidc_arr['tail'];
    $name = $myts->addSlashes($userinfo['name']);
    $email = $userinfo['email'];
    $SchoolCode = $myts->addSlashes($eduinfo['schoolid']);
    $eduinfo_json = json_encode($eduinfo, 256);
    $JobName = false !== mb_strpos($eduinfo_json, '教師') ? 'teacher' : 'student';
    // $JobName      = "teacher";
    $bio = $eduinfo_json;
    $from = $oidc_arr['from'];
} else {
    $uname = $claims['preferred_username'] . '_edu';
    $name = $myts->addSlashes($userinfo['name']);
    $email = $claims['email'];
    $SchoolCode = $myts->addSlashes($eduinfo['schoolid']);
    $eduinfo_json = json_encode($eduinfo, 256);
    $JobName = strpos($eduinfo_json, '教師') !== false ? "teacher" : "student";
    // $JobName = 'teacher';
    $bio = $eduinfo_json;
}

login_xoops($uname, $name, $email, $SchoolCode, $JobName, $url, $from, $sig, $occ, $bio);

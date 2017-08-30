<?php
session_start();

//驗證 access token
if( !isset($_SESSION['access_token'])){
  die ("無存取用權杖，無法取回使用者資料！");
}

//取回access token
include "config.php";
include "library.class.php";
$obj= new openid();

$token_ep=USERINFO_ENDPOINT;
if(DYNAMICAL_ENDPOINT){
   $token_ep=$ep->getEndPoint()->userinfo_endpoint;
}

$userinfo = $obj->getUserinfo($token_ep ,$_SESSION['access_token'], true);
if( !$userinfo) {
  die ("無法取得 USER INFO");
}
// 把access token記到session中
print_r($userinfo);


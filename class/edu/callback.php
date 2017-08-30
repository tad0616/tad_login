<?php
session_start();
$code= $_GET['code'];
$state= $_GET['state'];

//驗證 $state
if( !isset($_GET['code']) ||  !isset($_GET['state'])){
  die ("認證伺服器回傳結果失敗！");
}

if( strcmp($state, $_SESSION['azp_state'])){
  die ("錯誤的認證狀態，請重新嘗試！");
}

//取回access token
include "config.php";
include "library.class.php";

$obj= new openid();

$token_ep=TOKEN_ENDPOINT;
if(DYNAMICAL_ENDPOINT){
   $token_ep=$ep->getEndPoint()->token_endpoint;
}

$acctoken= $obj->getAccessToken($token_ep ,$code, REDIR_URI0);
if( !$acctoken || !isset($acctoken->access_token) ) {
  die ("無法取得ACCESS TOKEN");
}
// 把access token, id_token記到session中
// 未來需要取得其他scope再用此access token 來做
print $_SESSION['access_token']= $acctoken->access_token;
print "<br>";
// id_token也可以在此驗證，不記入session
print $_SESSION['id_token']= $acctoken->id_token;


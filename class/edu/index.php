<?php
session_start();
include "config.php";
include "library.class.php";

$obj= new openid();

$_SESSION['azp_state']=rand(0,9999999); //隨機產生state值
$_SESSION['nonce']=isset($_SESSION['nonce'])? $_SESSION['nonce']:base64_encode($_SESSION['azp_state']);

$auth_ep=AUTH_ENDPOINT;
if(DYNAMICAL_ENDPOINT){
   $auth_ep=$ep->getEndPoint()->authorization_endpoint;
}
$link = $auth_ep . "?response_type=code&client_id=". CLIENT_ID .
"&redirect_uri=".urlencode(REDIR_URI0) ."&scope=openid+email+profile&state=".$_SESSION['azp_state'].
"&nonce=".$_SESSION['nonce'];

?>
<!doctype html>
<html lang="zh-TW">
<head>
<meta charset="utf-8" />
</head>
<body>
<a href="<?php echo $link ?>">使用教育部OPENID認證</a>
</body>
</html>


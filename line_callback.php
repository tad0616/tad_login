<?php
use XoopsModules\Tadtools\Utility;
use XoopsModules\Tad_login\Tools;

require_once dirname(dirname(__DIR__)) . '/mainfile.php';
require_once 'class/line/ConfigManager.php'; //Line 設定檔 管理器
require_once 'class/line/LineAuthorization.php'; //產生登入網址
require_once 'class/line/LineProfiles.php'; //取得用戶端 Profile
require_once 'class/line/LineController.php'; //LINE控制

define("CLIENT_ID", $xoopsModuleConfig['line_id']);
define("CLIENT_SECRET", $xoopsModuleConfig['line_secret']);
define("REDIRECT_URI", XOOPS_URL . '/modules/tad_login/line_callback.php'); //登入後返回位置
define("SCOPE", 'openid%20profile%20email'); //授權範圍以%20分隔 可以有3項openid，profile，email

// if (!session_id()) {
//     session_start();
// }
$code = $_GET['code'];
$state = $_GET['state'];
// $session_state = $_SESSION['_line_state'];

// unset($_SESSION['_line_state']);
// if ($session_state !== $state) {
//     echo "存取錯誤({$session_state}!={$state})";
//     exit;
// }

$Line = new LineController();

list($access_token, $id_token) = $Line->getAccessToken($code); //取得使用者資料
setcookie("access_token", $access_token, time() + 3600 * 24 * 20, null, null, true); //把他記憶20天
// $user = $Line->getLineProfile_access_token($access_token); //取得使用者資料
$user_profile = $Line->VerifyIDtoken($id_token); //取得使用者資料

// {
//     "iss": "https:\/\/access.line.me",
//     "sub": "U9dd5eec1cfa708d76859cbe41d41b072",
//     "aud": "1655255408",
//     "exp": 1726033844,
//     "iat": 1726030244,
//     "amr": [
//         "linesso"
//     ],
//     "name": "tad ",
//     "picture": "https:\/\/profile.line-scdn.net\/0hkwwzd7w1NFhKAyKcTnRLD3ZGOjU9LTIQMmwsO2hUPjwwZHRZfzF-O2oGY25iM3peJmF4ajtTb21i",
//     "email": "tad0616@gmail.com"
// }
if ($user_profile['email']) {
    list($id, $domain) = explode('@', $user_profile['email']);

    $myts = \MyTextSanitizer::getInstance();
    $uname = $id . '_line';
    $name = $myts->addSlashes($user_profile['name']);
    $email = $user_profile['email'];
    $bio = $url = $from = $sig = $occ = $msnm = $user_avatar = $aim = $yim = '';
    // $user_avatar = copy_user_avatar($user_profile['picture'], $id);
    Tools::login_xoops($uname, $name, $email, '', '', $url, $from, $sig, $occ, $bio, $aim, $yim, $msnm, $user_avatar);
}

function copy_user_avatar($url, $id)
{
    if (function_exists('curl_init')) {
        $ch = curl_init();
        $timeout = 5;

        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
        $contentx = curl_exec($ch);
        curl_close($ch);

    } elseif (function_exists('file_get_contents')) {
        $contentx = file_get_contents($url);
    } else {
        $handle = fopen($url, 'rb');
        $contentx = stream_get_contents($handle);
        fclose($handle);
    }

    $openedfile = fopen(XOOPS_ROOT_PATH . "/uploads/avatars/{$id}.jpg", 'wb');
    fwrite($openedfile, $contentx);
    fclose($openedfile);
    Utility::generateThumbnail(XOOPS_ROOT_PATH . "/uploads/avatars/{$id}.jpg", XOOPS_ROOT_PATH . "/uploads/avatars/{$id}.jpg", 400);
    return "avatars/{$id}.jpg";
}

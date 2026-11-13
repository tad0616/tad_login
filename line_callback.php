<?php
use Xmf\Request;
use XoopsModules\Tadtools\Utility;
use XoopsModules\Tad_login\Tools;

require_once dirname(dirname(__DIR__)) . '/mainfile.php';
if (!class_exists('XoopsModules\Tad_login\Tools')) {
    require XOOPS_ROOT_PATH . '/modules/tad_login/preloads/autoloader.php';
}
if (!class_exists('XoopsModules\Tadtools\Utility')) {
    require XOOPS_ROOT_PATH . '/modules/tadtools/preloads/autoloader.php';
}
require_once __DIR__ . '/class/line/ConfigManager.php'; //Line 設定檔 管理器
require_once __DIR__ . '/class/line/LineAuthorization.php'; //產生登入網址
require_once __DIR__ . '/class/line/LineProfiles.php'; //取得用戶端 Profile
require_once __DIR__ . '/class/line/LineController.php'; //LINE控制

xoops_loadLanguage('main', 'tad_login');

// 模組設定：部分 XOOPS 版本在獨立入口頁不會自動載入 $xoopsModuleConfig
$TadLoginModuleConfig = (isset($xoopsModuleConfig) && is_array($xoopsModuleConfig) && isset($xoopsModuleConfig['line_id'])) ? $xoopsModuleConfig : Utility::getXoopsModuleConfig('tad_login');

defined('CLIENT_ID') || define('CLIENT_ID', (string) ($TadLoginModuleConfig['line_id'] ?? ''));
defined('CLIENT_SECRET') || define('CLIENT_SECRET', (string) ($TadLoginModuleConfig['line_secret'] ?? ''));
defined('REDIRECT_URI') || define('REDIRECT_URI', XOOPS_URL . '/modules/tad_login/line_callback.php'); //登入後返回位置
defined('SCOPE') || define('SCOPE', 'openid%20profile%20email'); //授權範圍以%20分隔 可以有3項openid，profile，email

$login_page = XOOPS_URL . '/modules/tad_login/index.php';

// 清除舊版留下的 access_token cookie（不再保存 LINE 的 access_token）
if (isset($_COOKIE['access_token'])) {
    $cookie_path = (string) parse_url(XOOPS_URL . '/modules/tad_login', PHP_URL_PATH);
    setcookie('access_token', '', [
        'expires'  => time() - 3600,
        'path'     => $cookie_path,
        'secure'   => true,
        'httponly' => true,
        'samesite' => 'Lax',
    ]);
}

$code = Request::getString('code', '', 'GET');
$state = Request::getString('state', '', 'GET');
$session_state = isset($_SESSION['tad_login_line_state']) && is_string($_SESSION['tad_login_line_state']) ? $_SESSION['tad_login_line_state'] : '';
unset($_SESSION['tad_login_line_state']);

// 檢查 state，防止登入 CSRF
if ('' === $code || '' === $session_state || '' === $state || !hash_equals($session_state, $state)) {
    redirect_header($login_page, 5, _MD_TADLOGIN_LINE_STATE_FAIL);
    exit;
}

$Line = new LineController();

list($access_token, $id_token) = $Line->getAccessToken($code); //以 code 換取 token
if ('' === $id_token) {
    redirect_header($login_page, 5, _MD_TADLOGIN_LINE_LOGIN_FAIL);
    exit;
}

$user_profile = $Line->VerifyIDtoken($id_token); //向 LINE 驗證 ID Token 並取得使用者資料

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

// ID Token 必須由 LINE 簽發且對象是本站的 Channel
if (empty($user_profile['sub'])
    || !isset($user_profile['iss'], $user_profile['aud'])
    || 'https://access.line.me' !== $user_profile['iss']
    || (string) $user_profile['aud'] !== CLIENT_ID) {
    redirect_header($login_page, 5, _MD_TADLOGIN_LINE_LOGIN_FAIL);
    exit;
}

$email = isset($user_profile['email']) && is_string($user_profile['email']) ? trim($user_profile['email']) : '';
if ('' === $email || false === strpos($email, '@')) {
    redirect_header($login_page, 5, _MD_TADLOGIN_LINE_NO_EMAIL);
    exit;
}

list($id, $domain) = explode('@', $email, 2);

$myts = \MyTextSanitizer::getInstance();
$uname = $id . '_line';
$name = $myts->addSlashes(isset($user_profile['name']) && is_string($user_profile['name']) ? $user_profile['name'] : '');
$bio = $url = $from = $sig = $occ = $msnm = $user_avatar = $aim = $yim = '';
Tools::login_xoops($uname, $name, $email, '', '', $url, $from, $sig, $occ, $bio, $aim, $yim, $msnm, $user_avatar);

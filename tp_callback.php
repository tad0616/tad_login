<?php
use XoopsModules\Tad_login\Tools;
require_once dirname(dirname(__DIR__)) . '/mainfile.php';

if (!class_exists('XoopsModules\Tad_login\Tools')) {
    require XOOPS_ROOT_PATH . '/modules/tad_login/preloads/autoloader.php';
}

$oidc_setup = json_decode($xoopsModuleConfig['oidc_setup'], true);

if (empty($oidc_setup['tp_ldap']['clientid'])) {
    redirect_header(XOOPS_URL, 3, '系統無法取得臺北市單一簽入 client id 值');
    exit;
}

// ── 第一步：沒有 code → 導向臺北市授權頁 ──────────────────────────────
if (!isset($_GET['code'])) {
    $authorize_url = 'https://ldap.tp.edu.tw/oauth/authorize?' . http_build_query([
        'client_id'     => $oidc_setup['tp_ldap']['clientid'],
        'redirect_uri'  => XOOPS_URL . '/modules/tad_login/tp_callback.php',
        'response_type' => 'code',
        'scope'         => 'user profile',
    ], '', '&', PHP_QUERY_RFC3986);
    header('location:' . $authorize_url);
    exit;
}

// ── 第二步：有 code → 換取 access_token ───────────────────────────────
$clientId     = $oidc_setup['tp_ldap']['clientid'];
$clientSecret = $oidc_setup['tp_ldap']['clientsecret'];

$postBody = http_build_query([
    'grant_type'    => 'authorization_code',
    'client_id'     => $clientId,
    'client_secret' => $clientSecret,
    'redirect_uri'  => XOOPS_URL . '/modules/tad_login/tp_callback.php',
    'code'          => $_GET['code'],
], '', '&', PHP_QUERY_RFC3986);

$ch = curl_init('https://ldap.tp.edu.tw/oauth/token');
curl_setopt_array($ch, [
    CURLOPT_POST           => true,
    CURLOPT_POSTFIELDS     => $postBody,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_HTTPHEADER     => [
        'Content-Type: application/x-www-form-urlencoded',
    ],
]);
$response = curl_exec($ch);
// PHP 8.0 起 curl_close() 已無作用，PHP 8.5 起棄用，交由 PHP 自動釋放

$token       = json_decode($response);
$accessToken = $token->access_token ?? '';

if (empty($accessToken)) {
    // 重新走授權流程，讓臺北市重新發一個新的 code
    $authorize_url = 'https://ldap.tp.edu.tw/oauth/authorize?' . http_build_query([
        'client_id'     => $clientId,
        'redirect_uri'  => XOOPS_URL . '/modules/tad_login/tp_callback.php',
        'response_type' => 'code',
        'scope'         => 'user profile',
    ], '', '&', PHP_QUERY_RFC3986);
    header('location:' . $authorize_url);
    exit;
}

// ── 第三步：用 access_token 取得使用者資料 ────────────────────────────
$user    = Tools::requestProtectedApi('https://ldap.tp.edu.tw/api/user', $accessToken);
$profile = Tools::requestProtectedApi('https://ldap.tp.edu.tw/api/profile', $accessToken);

if (empty($user) || empty($user['email'])) {
    redirect_header(XOOPS_URL . '/modules/tad_login/index.php', 5,
        '臺北市單一簽入：無法取得使用者資料，請重新登入。');
    exit;
}

// ── 第四步：整理資料並登入 XOOPS ─────────────────────────────────────
$myts = \MyTextSanitizer::getInstance();

[$id]       = explode('@', $user['email']);
$uname      = $id . '_tp';
$name       = $myts->addSlashes($user['name'] ?? '');
$email      = $user['email'];
$SchoolCode = $myts->addSlashes($profile['o'] ?? '');
$occ        = $myts->addSlashes($profile['organization'] ?? '');
$JobName    = ('學生' === ($user['role'] ?? '')) ? 'student' : 'teacher';
$from       = '臺北市';

Tools::login_xoops($uname, $name, $email, $SchoolCode, $JobName, '', $from, '', $occ, '');

<?php
xoops_loadLanguage('modinfo_common', 'tadtools');
require_once __DIR__ . '/county.php';

define('_MI_TADLOGIN_NAME', '快速登入');
define('_MI_TADLOGIN_AUTHOR', '快速登入');
define('_MI_TADLOGIN_CREDITS', '王嘉田主任(adm@mail.cyc.edu.tw)');
define('_MI_TADLOGIN_ADMENU1', 'FaceBook認證設定說明');
define('_MI_TADLOGIN_ADMENU2', '自動群組設定');
define('_MI_TADLOGIN_ADMENU3', 'Google認證設定說明');
define('_MI_TADLOGIN_ADMENU4', '教育雲認證設定');
define('_MI_TADLOGIN_ADMENU5', '綁定密碼管理');
define('_MI_TADLOGIN_ADMENU6', 'Line認證設定說明');
define('_MI_TADLOGIN_ADMENU7', 'OIDC沿用OpenID帳號');

define('_MI_TADLOGIN_DESC', '加入快速登入的機制');
define('_MI_TADLOGIN_BNAME1', '快速登入');
define('_MI_TADLOGIN_BDESC1', '快速登入(tad_login)');
define('_MI_TADLOGIN_AUTH_METHOD', '欲使用的認證方式');
define('_MI_TADLOGIN_AUTH_METHOD_DESC', '請選可要開放給使用者用的認證方式（<a href="https://www.tad0616.net/modules/tadnews/index.php?nsn=286" target="_blank">OpenID被停用該怎麼辦？ </a>）');
define('_MI_TADLOGIN_REAL_JOBNAME', '套用OpenID職稱');
define('_MI_TADLOGIN_REAL_JOBNAME_DESC', '選「是」會嘗試抓取OpenID傳回的職稱（如果有的話），選「否」僅會判斷是否為學生或老師。');

define('_MI_TADLOGIN_GOOGLE_APPID', 'Google 的「Client ID」');
define('_MI_TADLOGIN_GOOGLE_APPID_DESC', '請至 https://console.developers.google.com 建立一個 Project，並取得其「Client ID」。');
define('_MI_TADLOGIN_GOOGLE_SECRET', 'Google 的「Client secret」');
define('_MI_TADLOGIN_GOOGLE_SECRET_DESC', '請至 https://console.developers.google.com 建立一個 Project，並取得其「Client secret」。');

define('_MI_TADLOGIN_GOOGLE_REDIRECT_URL', 'Google 的「Redirect URIs」');
define('_MI_TADLOGIN_GOOGLE_REDIRECT_URL_DESC', '請至 https://console.developers.google.com 建立一個 Project，並取得其「Redirect URIs」。');
define('_MI_TADLOGIN_GOOGLE_API_KEY', 'Google 的「API key」');
define('_MI_TADLOGIN_GOOGLE_API_KEY_DESC', '請至 https://console.developers.google.com 建立一個 Project，並取得其「API key」。');

define('_MI_TADLOGIN_REDIRECT_URL', '登入後轉向設定');
define('_MI_TADLOGIN_REDIRECT_URL_DESC', '可設定登入後要導向到哪個位址');

define('_TADLOGIN_OIDC_SETUP', 'OIDC 教育雲帳號設定');
define('_TADLOGIN_OIDC_SETUP_DESC', '勿動，請從<a href="' . XOOPS_URL . '/modules/tad_login/admin/oidc.php">' . XOOPS_URL . '/modules/tad_login/admin/oidc.php</a> 設定之');

define('_MI_TADLOGIN_LINE_ID', 'Line 的 Channel ID');
define('_MI_TADLOGIN_LINE_ID_DESC', '至 https://developers.line.biz/console/channel/new?type=line-login 建立一個  channel，並取得其「Channel ID」');
define('_MI_TADLOGIN_LINE_SECRET', 'Line 的 Channel Secret');
define('_MI_TADLOGIN_LINE_SECRET_DESC', '至 https://developers.line.biz/console/channel/new?type=line-login 建立一個  channel，並取得其「Channel Secret」');

define('_MI_TADLOGIN_BIND_OPENID', '登入後是否導向到綁定畫面');
define('_MI_TADLOGIN_BIND_OPENID_DESC', '一般可以設「否」，但若是未來 OpenID 不再提供服務的縣市建議選「是」');

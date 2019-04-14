<?php
require_once XOOPS_ROOT_PATH . "/modules/tadtools/language/{$xoopsConfig['language']}/modinfo_common.php";
require_once __DIR__ . '/county.php';

define('_MI_TADLOGIN_NAME', '快速登入');
define('_MI_TADLOGIN_AUTHOR', '快速登入');
define('_MI_TADLOGIN_CREDITS', '王嘉田主任(adm@mail.cyc.edu.tw)');
define('_MI_TADLOGIN_ADMENU1', 'FaceBook認證設定說明');
define('_MI_TADLOGIN_ADMENU2', '自動群組設定');
define('_MI_TADLOGIN_ADMENU3', 'Google認證設定說明');

define('_MI_TADLOGIN_DESC', '加入FB等快速登入的機制');
define('_MI_TADLOGIN_BNAME1', '快速登入');
define('_MI_TADLOGIN_BDESC1', '快速登入(tad_login)');
define('_MI_TADLOGIN_APPID', 'FaceBook 的「應用程式 ID」');
define('_MI_TADLOGIN_APPID_DESC', '請至 https://developers.facebook.com/apps 建立一個應用程式，並取得其「應用程式 ID」，預設值對您的網站來說是無效的（僅供參考而已）。');
define('_MI_TADLOGIN_SECRET', 'FaceBook 的「應用程式密鑰」');
define('_MI_TADLOGIN_SECRET_DESC', '請至 https://developers.facebook.com/apps 建立一個應用程式，並取得其「應用程式密鑰」，預設值對您的網站來說是無效的（僅供參考而已）。');
define('_MI_TADLOGIN_AUTH_METHOD', '欲使用的認證方式');
define('_MI_TADLOGIN_AUTH_METHOD_DESC', '請選可要開放給使用者用的認證方式');
define('_MI_TADLOGIN_LOGIN', '使用%s登入');
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

define('_MI_TADLOGIN_TITLE2', '導覽列的登入選項');
define('_MI_TADLOGIN_DESC2', '請選擇預設導覽列中登入選項的呈現方式');
define('_MI_TADLOGIN_TITLE2_OPT0', '僅顯示XOOPS的登入界面');
define('_MI_TADLOGIN_TITLE2_OPT1', '同時顯示XOOPS的登入界面和OpenID的按鈕');
define('_MI_TADLOGIN_TITLE2_OPT2', '僅顯示OpenID的按鈕');
define('_MI_TADLOGIN_TITLE2_OPT3', '不顯示登入選項');

define('_MI_TADLOGIN_TITLE3', '登入選單中的快速登入圖示一排幾個');
define('_MI_TADLOGIN_DESC3', '若「是否崁入快速登入到登入選單中」為「是」時，選一個會出現圖示及文字，選兩個以上就只剩圖示。');

define('_MI_TADLOGIN_REDIRECT_URL', '登入後轉向設定');
define('_MI_TADLOGIN_REDIRECT_URL_DESC', '可設定登入後要導向到哪個位址，一般無須設定。');

define('_MI_TADLOGIN_EDU_CLIENTID', '教育部教育雲端帳號的 client id');
define('_MI_TADLOGIN_EDU_CLIENTID_DESC', '申請詳情請至 https://oidc.tanet.edu.tw/ 查看');
define('_MI_TADLOGIN_EDU_CLIENTSECRET', '教育部教育雲端帳號的 clientsecret');
define('_MI_TADLOGIN_EDU_CLIENTSECRET_DESC', '申請詳情請至 https://oidc.tanet.edu.tw/ 查看');

define('_MI_TADLOGIN_TY_EDU_CLIENTID', '桃園市教育雲端帳號的 client id');
define('_MI_TADLOGIN_TY_EDU_CLIENTID_DESC', '申請詳情請至 https://tyc.sso.edu.tw 查看，申請時請提供 redirect uri 為 ' . XOOPS_URL . '/modules/tad_login/edu_callback.php');
define('_MI_TADLOGIN_TY_EDU_CLIENTSECRET', '桃園市教育雲端帳號的 client secret');
define('_MI_TADLOGIN_TY_EDU_CLIENTSECRET_DESC', '申請詳情請至 https://tyc.sso.edu.tw 查看');

define('_MI_TADLOGIN_TP_EDU_CLIENTID', '臺北市單一身分驗證的 clientid');
define('_MI_TADLOGIN_TP_EDU_CLIENTID_DESC', '申請詳情請至 https://ldap.tp.edu.tw 查看，申請時請提供 redirect uri 為 ' . XOOPS_URL . '/modules/tad_login/tp_callback.php');
define('_MI_TADLOGIN_TP_EDU_CLIENTSECRET', '臺北市單一身分驗證的 client secret');
define('_MI_TADLOGIN_TP_EDU_CLIENTSECRET_DESC', '申請詳情請至 https://ldap.tp.edu.tw 查看');

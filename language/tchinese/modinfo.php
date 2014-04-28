<?php
include_once XOOPS_ROOT_PATH."/modules/tadtools/language/{$xoopsConfig['language']}/modinfo_common.php";
include_once "county.php";

define("_MI_TADLOGIN_NAME","快速登入");
define("_MI_TADLOGIN_AUTHOR","快速登入");
define("_MI_TADLOGIN_CREDITS","王嘉田主任(adm@mail.cyc.edu.tw)");
define("_MI_TAD_LOGIN_ADMENU1","FaceBook認證說明");
define("_MI_TAD_LOGIN_ADMENU2","自動群組設定");

define("_MI_TADLOGIN_DESC","加入FB等快速登入的機制");
define("_MI_TADLOGIN_BNAME1","快速登入");
define("_MI_TADLOGIN_BDESC1","快速登入(tad_login)");
define("_MI_TADLOGIN_APPID","FaceBook 的「應用程式 ID」");
define("_MI_TADLOGIN_APPID_DESC","請至 https://developers.facebook.com/apps 建立一個應用程式，並取得其「應用程式 ID」，預設值對您的網站來說是無效的（僅供參考而已）。");
define("_MI_TADLOGIN_SECRET","FaceBook 的「應用程式密鑰」");
define("_MI_TADLOGIN_SECRET_DESC","請至 https://developers.facebook.com/apps 建立一個應用程式，並取得其「應用程式密鑰」，預設值對您的網站來說是無效的（僅供參考而已）。");
define("_MI_TADLOGIN_AUTH_METHOD","欲使用的認證方式");
define("_MI_TADLOGIN_AUTH_METHOD_DESC","請選可要開放給使用者用的認證方式");
define("_MI_TADLOGIN_LOGIN","使用%s登入");
define("_MI_TADLOGIN_REAL_JOBNAME","套用OpenID職稱");
define("_MI_TADLOGIN_REAL_JOBNAME_DESC","選「是」會嘗試抓取OpenID傳回的職稱（如果有的話），選「否」僅會判斷是否為學生或老師。");
?>
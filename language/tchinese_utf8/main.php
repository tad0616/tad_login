<?php
xoops_loadLanguage('main', 'tadtools');
require_once __DIR__ . '/county.php';
//需加入模組語系
define('_MD_TADLOGIN_CNRNU', '建立XOOPS使用者失敗！');
define('_MD_TADLOGIN_USE', '使用');
define('_MD_TADLOGIN_LOGIN', '登入');
define('_MD_TADLOGIN_TEACHER', '教師');
define('_MD_TADLOGIN_STUDENT', '學生');
define('_MD_TADLOGIN_UNAME_TOO_LONG', '帳號 %s 超過 %s 個字，無法建立之');
define('_MD_TADLOGIN_CHANGE_COMPLETED', '已完成綁定密碼修改！');
define('_MD_TADLOGIN_CHANGE_PASSEOWD', '設定或變更綁定密碼');
define('_MD_TADLOGIN_EDIT_PASSEOWD_DESC1', '會看到此頁，是因為您是用 OpenID 登入，而您的 OpenID 帳號還未跟 XOOPS 帳號綁定的緣故');
define('_MD_TADLOGIN_EDIT_PASSEOWD_DESC2', '建議您設定一組密碼，以將現有 OpenID 帳號跟 XOOPS 帳號進行綁定。');
define('_MD_TADLOGIN_EDIT_PASSEOWD', '設定密碼');
define('_MD_TADLOGIN_COMPLETE_BINDING', '按此完成綁定');
define('_MD_TADLOGIN_AFTER_BINDING', '完成綁定後：');
define('_MD_TADLOGIN_EDIT_PASSEOWD_DESC3', '一樣可以繼續用 OpenID 登入（用原OpenID的帳號及密碼）');
define('_MD_TADLOGIN_EDIT_PASSEOWD_DESC4', '還可以用 <b style="color:rgb(0, 86, 199);">%s</b> 帳號，及上方設定的密碼來登入（如右圖，無須透過 OpenID）');
define('_MD_TADLOGIN_EDIT_PASSEOWD_DESC5', '將不再自動導向此頁。若要再次變更綁定密碼，可連至：');
define('_MD_TADLOGIN_EDIT_PASSEOWD_DESC6', '若未綁定，一樣可以用 OpenID 登入，但就無法用輸入帳密的方式登入。');
define('_MD_TADLOGIN_EDIT_PASSEOWD_DESC7', '修改綁定密碼。非必要，上次設定時間為：');
define('_MD_TADLOGIN_MODIFY_PASSEOWD', '修改綁定密碼');
define('_MD_TADLOGIN_COMPLETE_MODIFY', '按此完成綁定密碼修改');
define('_MD_TADLOGIN_EDIT_PASSEOWD_DESC8', '完成設定後即可用此帳號（<b style="color:rgb(0, 86, 199);">%s</b>），及修改後的綁定密碼來登入。');
define('_MD_TADLOGIN_SET_PASSWORD', '設定 %s 的登入密碼');
define('_MD_TADLOGIN_LOGIN_ICON', '登入示意圖');
define('_MD_TNOPENID_INCORRECTLOGIN', '無法登入');

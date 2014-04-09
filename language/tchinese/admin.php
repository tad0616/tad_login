<?php
include_once "../../tadtools/language/{$xoopsConfig['language']}/admin_common.php";
define("_TAD_NEED_TADTOOLS"," 需要 tadtools 模組，可至<a href='http://www.tad0616.net/modules/tad_uploader/index.php?of_cat_sn=50' target='_blank'>Tad教材網</a>下載。");


define("_MA_TAD_LOGIN_STEP1","<h1>【步驟 1】若還不是FB開發者</h1><p>請連至 <a href='https://developers.facebook.com/apps' target='_blank'>https://developers.facebook.com/apps</a>，若是沒有「製作新應用程式」的按鈕，那您得先按下「Register Now」成為FB開發者才行。</p>");
define("_MA_TAD_LOGIN_STEP2","<h1>【步驟 2】輸入FB密碼</h1><p></p>");
define("_MA_TAD_LOGIN_STEP3","<h1>【步驟 3】註冊成為FB開發者</h1><p>記得點選開關，使之變成「是」</p>");
define("_MA_TAD_LOGIN_STEP4","<h1>【步驟 4】手機驗證</h1><p>請輸入手機號碼，按下「Send as Text」，此時，FB會寄出簡訊，收取之，並在下方輸入簡訊上的確認碼。</p>");
define("_MA_TAD_LOGIN_STEP5","<h1>【步驟 5】恭喜完成第一步</h1><p>現在您已經是FB開發者了，日後就無須再重複此步驟了！</p>");



define("_MA_TAD_LOGIN_STEP6","<h1>【步驟 1】建立應用程式</h1><p>請連至 <a href='https://developers.facebook.com/apps' target='_blank'>https://developers.facebook.com/apps</a>，若您已經是開發者，那麼應該可以看到「製作新應用程式」按鈕，請點選「製作新應用程式」以開始設定。</p>");
define("_MA_TAD_LOGIN_STEP7","<h1>【步驟 2】建立新的應用程式</h1><p><ol><li>「Display Name」即「顯示名稱」就填一個您看得懂的中文即可，例如「快速登入」</li><li>「Namespace」應用程式名稱空間填入一個英文代號（僅能小寫英文字母和底線或-符號，數字或中文不行），例如：xxx_login</li><li>「類別」就隨便選一個吧！</li></ol></p>");
define("_MA_TAD_LOGIN_STEP8","<h1>【步驟 3】驗證</h1><p>請努力通過煩人的驗證碼，若有換行處記得要空一格。</p>");
define("_MA_TAD_LOGIN_STEP9","<h1>【步驟 4】最重要的資訊</h1><p>上面的「應用程式 ID」和 「應用程式密鑰」 就是等一下要填到XOOPS快速登入偏好設定的兩個值。</p>");
define("_MA_TAD_LOGIN_STEP10","<h1>【步驟 5】新增平台</h1><p>接著點選「設定」，填好電子郵件，按下「新增平台」</p>");
define("_MA_TAD_LOGIN_STEP11","<h1>【步驟 6】新增「網站」</h1><p>請選擇「網站」。</p>");
define("_MA_TAD_LOGIN_STEP12","<h1>【步驟 7】設定網址</h1><p>接著輸入您想用FB登入的網站之網址。</p>");
define("_MA_TAD_LOGIN_STEP13","<h1>【步驟 8】啟用登入功能</h1><p>接著點選「進階」，找到下方的「Emberedded browser OAuth Login」，並啟動之，這樣就大公告成了</p>");
define("_MA_TAD_LOGIN_STEP14","<h1>【步驟 9】確定有開放功能</h1><p>若是發現綠色圈圈為空心的，表示功能尚未開放給其他人使用，請點選「Status&Review」將開關切換成「是」即可。</p>");
define("_MA_TAD_LOGIN_STEP15","<h1>【步驟 10】偏好設定</h1><p>請連到本模組的偏好設定，將「應用程式 ID」和 「應用程式密鑰」依序填入，並記得選取「Facebook」認證方式，最後儲存即可。</p>");

define("_MA_TADLOGIN_ITEM","學校代碼或Email");
define("_MA_TADLOGIN_GROUP_ID","群組");

define("_MA_TADLOGIN_EMAIL","Email");
define("_MA_TADLOGIN_SCHOOLCODE","學校代碼");
define("_MA_TADLOGIN_TEACHER","教師");
define("_MA_TADLOGIN_STUDENT","學生");
define("_MA_TADLOGIN_JOB","身份為");
?>
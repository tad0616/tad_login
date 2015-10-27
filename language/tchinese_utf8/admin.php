<?php
include_once '../../tadtools/language/' . $xoopsConfig['language'] . '/admin_common.php';
define('_TAD_NEED_TADTOOLS', '需要 tadtools 模組，可至<a href="http://campus-xoops.tn.edu.tw/modules/tad_modules/index.php?module_sn=1" target="_blank">XOOPS輕鬆架</a>下載。');

define('_MA_TADLOGIN_STEP1', "<h1>【步驟 1】若還不是FB開發者</h1><p>請連至 <a href='https://developers.facebook.com/apps' target='_blank'>https://developers.facebook.com/apps</a>，若是沒有「製作新應用程式」的按鈕，那您得先按下「Register Now」成為FB開發者才行。</p>");
define('_MA_TADLOGIN_STEP2', "<h1>【步驟 2】輸入FB密碼</h1><p></p>");
define('_MA_TADLOGIN_STEP3', "<h1>【步驟 3】註冊成為FB開發者</h1><p>記得點選開關，使之變成「是」</p>");
define('_MA_TADLOGIN_STEP4', "<h1>【步驟 4】手機驗證</h1><p>請輸入手機號碼，按下「Send as Text」，此時，FB會寄出簡訊，收取之，並在下方輸入簡訊上的確認碼。</p>");
define('_MA_TADLOGIN_STEP5', "<h1>【步驟 5】恭喜完成第一步</h1><p>現在您已經是FB開發者了，日後就無須再重複此步驟了！</p>");

define('_MA_TADLOGIN_STEP6', "<h1>【步驟 1】建立應用程式</h1><p>請連至 <a href='https://developers.facebook.com/apps' target='_blank'>https://developers.facebook.com/apps</a>，若您已經是開發者，那麼應該可以看到「製作新應用程式」按鈕，請點選「製作新應用程式」以開始設定。</p>");
define('_MA_TADLOGIN_STEP7', "<h1>【步驟 2】建立新的應用程式</h1><p><ol><li>「Display Name」即「顯示名稱」就填一個您看得懂的中文即可，例如「快速登入」</li><li>「Namespace」應用程式名稱空間填入一個英文代號（僅能小寫英文字母和底線或-符號，數字或中文不行），例如：xxx_login</li><li>「類別」就隨便選一個吧！</li></ol></p>");
define('_MA_TADLOGIN_STEP8', "<h1>【步驟 3】驗證</h1><p>請努力通過煩人的驗證碼，若有換行處記得要空一格。</p>");
define('_MA_TADLOGIN_STEP9', "<h1>【步驟 4】最重要的資訊</h1><p>上面的「應用程式 ID」和 「應用程式密鑰」 就是等一下要填到XOOPS快速登入偏好設定的兩個值。</p>");
define('_MA_TADLOGIN_STEP10', "<h1>【步驟 5】新增平台</h1><p>接著點選「設定」，填好電子郵件，按下「新增平台」</p>");
define('_MA_TADLOGIN_STEP11', "<h1>【步驟 6】新增「網站」</h1><p>請選擇「網站」。</p>");
define('_MA_TADLOGIN_STEP12', "<h1>【步驟 7】設定網址</h1><p>接著輸入您想用FB登入的網站之網址。</p>");
define('_MA_TADLOGIN_STEP13', "<h1>【步驟 8】啟用登入功能</h1><p>接著點選「進階」，找到下方的「Emberedded browser OAuth Login」，並啟動之，這樣就大公告成了</p>");
define('_MA_TADLOGIN_STEP14', "<h1>【步驟 9】確定有開放功能</h1><p>若是發現綠色圈圈為空心的，表示功能尚未開放給其他人使用，請點選「Status&Review」將開關切換成「是」即可。</p>");
define('_MA_TADLOGIN_STEP15', "<h1>【步驟 10】偏好設定</h1><p>請連到本模組的偏好設定，將「應用程式 ID」和 「應用程式密鑰」依序填入，並記得選取「Facebook」認證方式，最後儲存即可。</p>");

define('_MA_TADLOGIN_GOO_STEP1', "<h1>【步驟 1】建立Google專案</h1><p>請連至<a href='https://console.developers.google.com/project' target='_blank'>https://console.developers.google.com/project</a>建立一個新專案</p>");
define('_MA_TADLOGIN_GOO_STEP2', "<h1>【步驟 2】啟動API</h1><p>專案建立後，至該專案的 OverView 去啟動API，按下即可。</p>");
define('_MA_TADLOGIN_GOO_STEP3', "<h1>【步驟 3】建立證書</h1><p>至「Credentials」，點選「Create new Client ID」</p>");
define('_MA_TADLOGIN_GOO_STEP4', "<h1>【步驟 4】建立Client ID</h1><p>選擇「Web application」，「Authorized JavaScript origins」輸入網站網址：「Authorized redirect URI」則輸入「" . XOOPS_URL . "/modules/tad_login/index.php」</p>");
define('_MA_TADLOGIN_GOO_STEP5', "<h1>【步驟 5】取得 Client ID</h1><p>紅框處就是到時候要填入偏好設定中的項目值。</p>");
define('_MA_TADLOGIN_GOO_STEP6', "<h1>【步驟 6】建立API Key</h1><p>點選「Create new Key」以建立 API Key</p>");
define('_MA_TADLOGIN_GOO_STEP7', "<h1>【步驟 7】建立新的金鑰</h1><p>選擇「Browser Key」</p>");
define('_MA_TADLOGIN_GOO_STEP8', "<h1>【步驟 8】設定允許來源</h1><p>輸入貴站網域名稱即可。</p>");
define('_MA_TADLOGIN_GOO_STEP9', "<h1>【步驟 9】取得 API Key</h1><p>紅框處的 API Key 就是到時候要填入偏好設定中的項目值。</p>");
define('_MA_TADLOGIN_GOO_STEP10', "<h1>【步驟 10】登入畫面設定</h1><p>設定好您的Email，以及專案名稱，就大公告成了！</p>");
define('_MA_TADLOGIN_GOO_STEP11', "<h1>【步驟 11】進行偏好設定</h1><p>接下來請至偏好設定，將四個欄位依序填入即可。</p>");

define('_MA_TADLOGIN_ITEM', "學校代碼或Email");
define('_MA_TADLOGIN_GROUP_ID', "群組");

define('_MA_TADLOGIN_EMAIL', "Email");
define('_MA_TADLOGIN_SCHOOLCODE', "學校代碼");
define('_MA_TADLOGIN_TEACHER', "教師");
define('_MA_TADLOGIN_STUDENT', "學生");
define('_MA_TADLOGIN_JOB', "身份為");

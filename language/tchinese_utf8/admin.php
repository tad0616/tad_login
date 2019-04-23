<?php
include_once '../../tadtools/language/' . $xoopsConfig['language'] . '/admin_common.php';
define('_TAD_NEED_TADTOOLS', '需要 tadtools 模組，可至<a href="http://campus-xoops.tn.edu.tw/modules/tad_modules/index.php?module_sn=1" target="_blank">XOOPS輕鬆架</a>下載。');

define('_MA_TADLOGIN_DEV_STEP1', "<h1>【步驟 1】若還不是FB開發者</h1><p>請連至 <a href='https://developers.facebook.com/apps' target='_blank'>https://developers.facebook.com/apps</a>，若是沒有「製作新應用程式」的按鈕，那您得先按下「Register Now」成為FB開發者才行。</p>");
define('_MA_TADLOGIN_DEV_STEP2', '<h1>【步驟 2】輸入FB密碼</h1><p></p>');
define('_MA_TADLOGIN_DEV_STEP3', '<h1>【步驟 3】註冊成為FB開發者</h1><p>記得點選開關，使之變成「是」</p>');
define('_MA_TADLOGIN_DEV_STEP4', '<h1>【步驟 4】手機驗證</h1><p>請輸入手機號碼，按下「Send as Text」，此時，FB會寄出簡訊，收取之，並在下方輸入簡訊上的確認碼。</p>');
define('_MA_TADLOGIN_DEV_STEP5', '<h1>【步驟 5】恭喜完成第一步</h1><p>現在您已經是FB開發者了，日後就無須再重複此步驟了！</p>');

define('_MA_TADLOGIN_STEP1', "<h1>【步驟 1】建立應用程式</h1><p>請連至 <a href='https://developers.facebook.com/apps' target='_blank'>https://developers.facebook.com/apps</a>，若您已經是開發者，那麼應該可以看到「新增應用程式」按鈕，請點選「新增應用程式」以開始設定。</p>");
define('_MA_TADLOGIN_STEP2', '<p>【步驟 2】接著請選擇「basic setup」</p>');
define('_MA_TADLOGIN_STEP3', '<h1>【步驟 3】建立新的應用程式</h1><p><ol><li>「顯示名稱」就填一個您看得懂的中文即可，例如「快速登入」</li><li>「類別」就隨便選一個吧！</li></ol></p>');
define('_MA_TADLOGIN_STEP4', '<h1>【步驟 4】驗證</h1><p>請努力通過煩人的驗證碼。</p>');
define('_MA_TADLOGIN_STEP5', '<h1>【步驟 5】使用Facebook 登入</h1><p>找到「Facebook 登入」並點擊「開始使用」</p>');
define('_MA_TADLOGIN_STEP6', "<h1>【步驟 6】OAuth 設定</h1><p>「有效的 OAuth 重新導向 URI」請填入「<span class='text-danger'>" . XOOPS_URL . '/modules/tad_login/fb-callback.php</span>」，並記得按右下角的「儲存變更」</p>');
define('_MA_TADLOGIN_STEP7', '<h1>【步驟 7】主控板設定</h1><p>點擊左上角的「主控板」</p>');
define('_MA_TADLOGIN_STEP8', '<h1>【步驟 8】最重要的資訊</h1><p>接著輸入您想用FB登入的網站之網址。上面的「應用程式編號」及「應用程式密鑰」 就是等一下要填到XOOPS快速登入偏好設定的兩個值。</p>');
define('_MA_TADLOGIN_STEP9', '<h1>【步驟 9】偏好設定</h1><p>請連到本模組的偏好設定，將「應用程式編號」和 「應用程式密鑰」依序填入，並記得選取「Facebook」認證方式，最後儲存即可。</p>');
define('_MA_TADLOGIN_STEP10', '<h1>【步驟 10】基本設定</h1><p>點選左上選單的「設定→基本設定」</p>');
define('_MA_TADLOGIN_STEP11', '<h1>【步驟 11】新增平台</h1><p>接著按下「新增平台」</p>');
define('_MA_TADLOGIN_STEP12', '<h1>【步驟 12】新增「網站」</h1><p>請選擇「網站」。</p>');
define('_MA_TADLOGIN_STEP13', '<h1>【步驟 13】網址設定</h1><p>
  <ol>
  <li>先在最下面輸入您想用FB登入的網站之網址。</li>
  <li>然後設定「應用程式網域」</li>
  <li>並在「命名空間」填入一個英文代號（僅能小寫英文字母和底線或-符號，數字或中文不行），例如：xxx_login，至少七個字以上。</li>
  <li>最後記得按右下角的「儲存變更」即可。</li>
  </ol>
  </p>');
define('_MA_TADLOGIN_STEP14', '<h1>【步驟 14】應用審查設定</h1><p>點選左上角「應用程式審查」</p>');
define('_MA_TADLOGIN_STEP15', '<h1>【步驟 15】發布應用程式</h1><p>點擊開關，使之呈現「是」就完工了！</p>');

define('_MA_TADLOGIN_GOO_STEP1', "<h1>【步驟 1】建立Google專案</h1><p>請連至<a href='https://console.developers.google.com/project' target='_blank'>https://console.developers.google.com/project</a>建立一個新專案</p>");
define('_MA_TADLOGIN_GOO_STEP2', '<h1>【步驟 2】建立憑證</h1><p>至「憑證」，點選「建立憑證」中的「OAuth用戶端ID」</p>');
define('_MA_TADLOGIN_GOO_STEP3', '<h1>【步驟 3】設定同意畫面</h1><p>點選「設定同意畫面」後，設定好產品名稱及隱私權政策的網址，就大公告成了！</p>');
define('_MA_TADLOGIN_GOO_STEP4', "<h1>【步驟 4】建立OAuth用戶端ID</h1><p>選擇「網路應用程式」，在「已授權的 JavaScript 來源」輸入網站網址；「已授權的重新導向」則輸入「<span style='color:blue;'>" . XOOPS_URL . '/modules/tad_login/index.php</span>」即可</p>');
define('_MA_TADLOGIN_GOO_STEP5', '<h1>【步驟 5】取得用戶端 ID</h1><p>底下就是到時候要填入偏好設定中的項目值（貼上時，務必刪除前後的空白）。</p>');
define('_MA_TADLOGIN_GOO_STEP6', '<h1>【步驟 6】建立 API 金鑰</h1><p>點選「API 金鑰」以建立 API 金鑰</p>');
define('_MA_TADLOGIN_GOO_STEP7', '<h1>【步驟 7】取得 API 金鑰</h1><p>底下的 API 金鑰就是到時候要填入偏好設定中的項目值。</p>');
define('_MA_TADLOGIN_GOO_STEP8', '<h1>【步驟 8】設定限制金鑰允許來源</h1><p>選擇「HTTP 參照網址 (網站) 」輸入貴站網域名稱即可，後面可以加上「*」代表所有頁面。</p>');
define('_MA_TADLOGIN_GOO_STEP9', '<h1>【步驟 9】完成偏好設定</h1><p>接下來請至偏好設定，將三個欄位依序填完即可，貼入時，務必刪除前後的空白。認證方式也記得要選取「使用Google登入」</p>');
define('_MA_TADLOGIN_ITEM', '學校代碼或Email');
define('_MA_TADLOGIN_GROUP_ID', '群組');

define('_MA_TADLOGIN_EMAIL', 'Email');
define('_MA_TADLOGIN_EMAIL_DESC', '可用任何符號隔開 Email，亦可用 *@tn.edu.tw 萬用字元');
define('_MA_TADLOGIN_SCHOOLCODE', '學校代碼');
define('_MA_TADLOGIN_TEACHER', '教師');
define('_MA_TADLOGIN_STUDENT', '學生');
define('_MA_TADLOGIN_JOB', '身份為');

define('_MA_TADLOGIN_CLIENTID', 'client id');
define('_MA_TADLOGIN_CLIENTSECRET', 'client secret');

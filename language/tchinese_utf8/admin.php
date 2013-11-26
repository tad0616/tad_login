<?php
include_once "../../tadtools/language/{$xoopsConfig['language']}/admin_common.php";
define("_TAD_NEED_TADTOOLS"," 需要 tadtools 模組，可至<a href='http://www.tad0616.net/modules/tad_uploader/index.php?of_cat_sn=50' target='_blank'>Tad教材網</a>下載。");


define("_MA_TAD_LOGIN_STEP1","<h1>【步驟 1】建立應用程式</h1><p>請連至 <a href='https://developers.facebook.com/apps' target='_blank'>https://developers.facebook.com/apps</a>，點選「Apps」→「建立新的應用程式」。</p>");
define("_MA_TAD_LOGIN_STEP2","<h1>【步驟 2】建立新的應用程式</h1><p>第三格不用填，因為用不到。其他兩格只要設定到 FaceBook 設可以（都變成綠色）就沒問題。</p>");
define("_MA_TAD_LOGIN_STEP3","<h1>【步驟 3】驗證</h1><p>請努力通過煩人的驗證碼，中間（換行處）記得要空一格。</p>");
define("_MA_TAD_LOGIN_STEP4","<h1>【步驟 4】最重要的步驟</h1><p>將「以FaceBook登入網站」打勾，並輸入網址（萬一日後登入時一直顯示網址錯誤，有可能是這裡設錯）。上面的 App ID 和 App Secret 就是等一下要填到偏好設定的兩個值。</p>");
define("_MA_TAD_LOGIN_STEP5","<h1>【步驟 5】偏好設定</h1><p>請連到本模組的偏好設定，將  App ID 和 App Secret 依序填入，最後儲存即可。</p>");
define("_MA_TAD_LOGIN_STEP6","<h1>【步驟 6】前台進行登入</h1><p>一般使用者從前台登入。</p>");
define("_MA_TAD_LOGIN_STEP7","<h1>【步驟 7】FB驗證</h1><p>順利的話，會看到FB登入畫面，或者要求授權的畫面（僅需要Email，因為 XOOPS 需要使用者的 Email）。</p>");
define("_MA_TAD_LOGIN_STEP8","<h1>【步驟 8】建立帳號</h1><p>第一次登入，會建立一個新帳號（用FB上的帳號後面再加一個 _fb），其餘資料皆會從 FB 擷取而來。資料建立後，日後只要按下 FB登入按鈕，即可直接登入（不會要求授權，亦不會再建立帳號）。</p>");


define("_MA_TAD_LOGIN_STEP9","<h1>【常見問題】</h1><p>若是遇到這種情形，那表示您在 FaceBook 那裡的設定不正確，修改一下即可。</p>");
define("_MA_TAD_LOGIN_STEP10","<h1>【解決方法步驟 1】</h1><p>這時候，請看一下網址 redirect_uri 參數的值，看看和您的設定有什麼不同。「%3A」就是「:」；「%2F」就是「/」，換言之，程式會去找「http://ck2tw.net」這個網址，但我在 FaceBook 的網站位址設定卻是「http://www.ck2tw.net」，兜不起來。</p>");
define("_MA_TAD_LOGIN_STEP11","<h1>【解決方法步驟 2】</h1><p>所以，我們只要去 FaceBook 將網站位址設定改為和redirect_uri參數一致即可，如：「http://ck2tw.net」，這樣即可順利使用。</p>");
?>
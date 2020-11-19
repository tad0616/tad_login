<?php
xoops_loadLanguage('admin_common', 'tadtools');
$http = $_SERVER['HTTPS'] ? 'https://' : 'http://';
$mid = $xoopsModule->mid();
define('_MA_TADLOGIN_DEV_STEP1', "<h1>【步驟 1】若還不是FB開發者</h1><p>請連至 <a href='https://developers.facebook.com/apps' target='_blank'>https://developers.facebook.com/apps</a>，若是沒有「製作新應用程式」的按鈕，那您得先按下「立即註冊」成為FB開發者才行。</p>");
define('_MA_TADLOGIN_DEV_STEP2', '<h1>【步驟 2】輸入FB密碼</h1><p></p>');
define('_MA_TADLOGIN_DEV_STEP3', '<h1>【步驟 3】設為開發人員</h1>');
define('_MA_TADLOGIN_DEV_STEP4', '<h1>【步驟 4】手機驗證</h1><p>若式尚未完成手機驗證，可能會有跳出視窗，要求輸入手機號碼，送出後FB會寄出簡訊，收取之，並輸入簡訊上的確認碼完成身份認證，日後就無須再重複此步驟了！。接著，就可以建立第一個應用程式了！</p>');

define('_MA_TADLOGIN_STEP1', "<h1>【步驟 1】建立應用程式</h1><p>請連至 <a href='https://developers.facebook.com/apps' target='_blank'>https://developers.facebook.com/apps</a>，若您已經是開發者，那麼應該可以看到「建立應用程式」按鈕，請點選「建立應用程式」以開始設定。</p>");
define('_MA_TADLOGIN_STEP2', '<h1>【步驟 2】接著「建立應用程式編號」</h1><p>設好顯示名稱及信箱即可</p>');
define('_MA_TADLOGIN_STEP3', '<h1>【步驟 3】驗證</h1><p>打勾即可</p>');
define('_MA_TADLOGIN_STEP4', '<h1>【步驟 4】使用Facebook 登入</h1><p>找到「Facebook 登入」並點擊「設定」</p>');
define('_MA_TADLOGIN_STEP5', '<h1>【步驟 5】自行設定</h1><p>我們不用快速設定，而是直接點擊左邊「Facebook 登入」下的「設定」</p>');
define('_MA_TADLOGIN_STEP6', '<h1>【步驟 6】OAuth 設定</h1><p>「有效的 OAuth 重新導向 URI」請填入「<span style="color:blue;">' . XOOPS_URL . '/modules/tad_login/fb-callback.php</span>」，並記得按右下角的「儲存變更」</p>');
define('_MA_TADLOGIN_STEP7', '<h1>【步驟 7】基本資料設定</h1><p>點擊左上角的「設定」→「基本資料」</p>');
define('_MA_TADLOGIN_STEP8', '<h1>【步驟 8】最重要的資訊</h1><p><ol style="list-style: decimal inside;">
<li style="line-height:2em;">上面的「應用程式編號」及「應用程式密鑰」 就是等一下要填到XOOPS快速登入<a href="' . XOOPS_URL . '/modules/system/admin.php?fct=preferences&op=showmod&mod=' . $mid . '" target="_blank">偏好設定</a>的兩個值。</li>
<li style="line-height:2em;">設定「顯示名稱」，請隨意輸入</li>
<li style="line-height:2em;">設定「命名空間」，填入一個英文代號（僅能小寫英文字母和底線或-符號，數字或中文不行），例如：xxx_login，至少七個字以上。</li>
<li style="line-height:2em;">接著設定「應用程式網域」，如：<span style="color:blue;">' . $_SERVER['HTTP_HOST'] . '</span></li>
<li style="line-height:2em;">其他如「隱私政策」、「服務條款」等，都輸入網址即可，如：<span style="color:blue;">' . XOOPS_URL . '</span></li>
</ol>
</p>');
define('_MA_TADLOGIN_STEP9', '<h1>【步驟 9】偏好設定</h1><p>請連到本模組的<a href="' . XOOPS_URL . '/modules/system/admin.php?fct=preferences&op=showmod&mod=' . $mid . '" target="_blank">偏好設定</a>，將「應用程式編號」和 「應用程式密鑰」依序填入，並記得選取「Facebook」認證方式，最後儲存即可。</p>');
define('_MA_TADLOGIN_STEP10', '<h1>【步驟 10】回到基本設定</h1><p>在最下方按下「新增平台」</p>');
define('_MA_TADLOGIN_STEP11', '<h1>【步驟 11】新增平台</h1><p>請選擇「網站」</p>');
define('_MA_TADLOGIN_STEP12', '<h1>【步驟 12】網址設定</h1><p>如：<span style="color:blue;">' . XOOPS_URL . '</span>，最後記得按「儲存變更」才有效。</p>');
define('_MA_TADLOGIN_STEP13', '<h1>【步驟 13】調整網站</h1><p>點一下上方的「調整中」</p>');
define('_MA_TADLOGIN_STEP14', '<h1>【步驟 14】切換模式</h1><p>點「切換模式」後，就可以去試試看了。</p>');

define('_MA_TADLOGIN_GOO_STEP1', "<h1>【步驟 1】建立Google專案</h1><p>請連至<a href='https://console.developers.google.com/project' target='_blank'>https://console.developers.google.com/project</a>建立一個新專案</p>");
define('_MA_TADLOGIN_GOO_STEP2', '<h1>【步驟 2】設定專案名稱</h1>');
define('_MA_TADLOGIN_GOO_STEP3', '<h1>【步驟 3】設定憑證</h1><p>先從左上選單→「API和服務」→「憑證」</p>');
define('_MA_TADLOGIN_GOO_STEP4', '<h1>【步驟 4】建立憑證</h1><p>點選「建立憑證」中的「OAuth用戶端ID」</p>');
define('_MA_TADLOGIN_GOO_STEP5', "<h1>【步驟 5】設定同意畫面</h1>");
define('_MA_TADLOGIN_GOO_STEP6', '<h1>【步驟 6】設定OAuth同意畫面</h1><p>若非使用 G suite者，請使用「外部」</p>');
define('_MA_TADLOGIN_GOO_STEP7', '<p>設定應用程式名稱</p>');
define('_MA_TADLOGIN_GOO_STEP8', '<p>設定「已授權網域」，請用頂級網域，務必記得按Enter加入，其他欄位可填入網址「<span style="color:blue;">' . XOOPS_URL . '</span>」即可</p>');
define('_MA_TADLOGIN_GOO_STEP9', '<h1>【步驟 7】設定限制金鑰允許來源</h1><p>
<ol style="list-style: decimal inside;">
<li style="line-height:2em;">請再回到步驟四，即點選「建立憑證」中的「OAuth用戶端ID」。</li>
<li style="line-height:2em;">選擇「網路應用程式」，在「已授權的 JavaScript 來源」一般輸入主機的主要網址「<span style="color:blue;">' . $http . $_SERVER['HTTP_HOST'] . '</span>」；</li>
<li style="line-height:2em;">「已授權的重新導向」則輸入「<span style="color:blue;">' . XOOPS_URL . '/modules/tad_login/index.php</span>」即可</li>
</ol></p>');
define('_MA_TADLOGIN_GOO_STEP10', '<h1>【步驟 8】完成偏好設定</h1><p>底下就是到時候要填入偏好設定中的項目值，請到<a href="' . XOOPS_URL . '/modules/system/admin.php?fct=preferences&op=showmod&mod=' . $mid . '" target="_blank">偏好設定</a>依序貼上（務必刪除前後的空白）。</p>');
define('_MA_TADLOGIN_GOO_STEP11', '<h1>【步驟 9】設定API 金鑰</h1><p>點選「建立憑證」中的「API 金鑰」以建立 API 金鑰</p>');
define('_MA_TADLOGIN_GOO_STEP12', '<h1>【步驟 10】貼上API 金鑰</h1><p>底下的 API 金鑰就是到時候要填入<a href="' . XOOPS_URL . '/modules/system/admin.php?fct=preferences&op=showmod&mod=' . $mid . '" target="_blank">偏好設定</a>中的項目值，填好後請按「限制金鑰」。</p>');
define('_MA_TADLOGIN_GOO_STEP13', '<h1>【步驟 11】限制金鑰</h1><p>請選擇「無」，避免出現403錯誤訊息，「API限制」則設為「不限制金鑰」。儲存後，即可試試是否能登入。</p>');

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

define('_MA_TADLOGIN_NAME', '姓名');
define('_MA_TADLOGIN_UNAME', '登入帳號');
define('_MA_TADLOGIN_LAST_LOGIN', '最後登入時間');
define('_MA_TADLOGIN_HASHED_DATE', '最後更改密碼時間');
define('_MA_TADLOGIN_MANAGE_PASSWORD', '管理綁定密碼');
define('_MA_TADLOGIN_MODIFY_PASSWORD', '修改綁定密碼');
define('_MA_TADLOGIN_CHANGE_BINDING_PASSWORD', '設定綁定密碼');
define('_MA_TADLOGIN_BIND_ID', '點我進行綁定');
define('_MA_TADLOGIN_SET_PASSWORD', '設定一組登入密碼');
define('_MA_TADLOGIN_BIND_ALL_ID', '替尚未綁定的OpenID帳號設定登入密碼（共 %s 個）');
define('_MA_TADLOGIN_BIND_DESC1', '設定綁定密碼後，使用者可以同時使用OpenID登入（用原OpenID密碼）和帳號密碼登入（用綁定密碼），並使用同一個身份（uid 相同）。');
define('_MA_TADLOGIN_BIND_DESC2', '若 OpenID 無法登入，就可以使用帳號密碼登入。');
define('_MA_TADLOGIN_BIND_DESC3', '若 OpenID 不會有停止使用的問題，管理員無需替所有使用者綁定密碼。');
define('_MA_TADLOGIN_BIND_DESC4', '綁定密碼就是登入密碼，修改綁定密碼，不會影響到 OpenID 密碼');
define('_MA_TADLOGIN_BIND_DESC5', '使用者可以自己修改密碼，建議將<a href="' . XOOPS_URL . '/modules/system/admin.php?fct=blocksadmin&op=list&filter=1&selgen=%s&selmod=-2&selgrp=-1&selvis=-1">快速登入區塊</a>打開，並設為顯示於「全部頁面」');
define('_MA_TADLOGIN_NON_ADMINISTRATIVE', '非管理員，無執行權限');

define('_MA_TADLOGIN_LINE_STEP1', "<h1>【步驟 1】建立 Line Channel</h1><p>請連至<a href='https://developers.line.biz/console/channel/new?type=line-login' target='_blank'>https://developers.line.biz/console/channel/new?type=line-login</a>
<ol>
<li>建立一個新 Channel，[Channel type] 請選「LINE Login」</li>
<li>[Provider]可以選擇「Create a new provider」來建立一個新的</li>
<li>[Region] 選「Taiwan」（注意！目前只支援四個地區，若主機不在這四個地區之中，設好也無法使用）</li>
<li>[Channel icon]可以上傳個圖片，或不上傳也無妨。</li>
</ol></p>");
define('_MA_TADLOGIN_LINE_STEP2', '<h1>【步驟 2】基本設定1</h1><p>
<ol>
<li>填好[Channel name]及[Channel description]</li>
<li>[App types]選「Web App」</li>
<li>[Email address]必填</li>
</ol></p>');
define('_MA_TADLOGIN_LINE_STEP3', '<h1>【步驟 3】基本設定2</h1><p>
<ol>
<li>[Privacy policy URL]隱私政策網址及[Terms of use URL]使用條款，若有可以填入網址（不填無妨）。</li>
<li>下方同意方框請打勾</li>
<li>最後按「Create」來建立 Channel即可</li>
</ol></p>');
define('_MA_TADLOGIN_LINE_STEP4', '<h1>【步驟 4】複製 Channel ID</h1>');
define('_MA_TADLOGIN_LINE_STEP5', '<h1>【步驟 5】到<a href="' . XOOPS_URL . '/modules/system/admin.php?fct=preferences&op=showmod&mod=' . $mid . '" target="_blank">偏好設定</a>貼上 Channel ID，並將「欲使用的認證方式」加上 Line</h1>');
define('_MA_TADLOGIN_LINE_STEP6', '<h1>【步驟 6】複製 Channel secret </h1>');
define('_MA_TADLOGIN_LINE_STEP7', '<h1>【步驟 7】到<a href="' . XOOPS_URL . '/modules/system/admin.php?fct=preferences&op=showmod&mod=' . $mid . '" target="_blank">偏好設定</a>貼上 Channel secret，並儲存設定</h1>');
define('_MA_TADLOGIN_LINE_STEP8', '<h1>【步驟 8】設定欲取得Email資訊</h1><p>到最下方的[Email address permission]按「Apply」，該打勾的打勾，圖片必須上傳，最後按「Submit」即可</p>');
define('_MA_TADLOGIN_LINE_STEP9', '<h1>【步驟 9】設定 Callback URL</h1><p>切換到「LINE Login」頁籤，點擊[Callback URL]的「Edit」按鈕，並填入「<span style="color:blue;">' . XOOPS_URL . '/modules/tad_login/line_callback.php</span>」</p>');

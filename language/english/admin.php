<?php
xoops_loadLanguage('admin_common', 'tadtools');
if (!defined('_TAD_NEED_TADTOOLS')) {
    define('_TAD_NEED_TADTOOLS', 'This module needs TadTools module. You can download TadTools from <a href="https://campus-xoops.tn.edu.tw/modules/tad_modules/index.php?module_sn=1" target="_blank">XOOPS EasyGO</a>.');
}

define('_MA_TADLOGIN_DEV_STEP1', '<h1> [Step 1] if not the FB developer </h1> <p> Please connect to <a href = \'https: //developers.facebook.com/apps\' target =\' _blank \'> https://developers.facebook.com/apps </a>, if not "create a new Application" button, then you must first click on the "Register Now" has become the FB developer job. </p > ');
define('_MA_TADLOGIN_DEV_STEP2', '<h1> [Step 2] Input FB password </h1> <p> </p>');
define('_MA_TADLOGIN_DEV_STEP3', '<h1> [Step 3] to register as FB developer </h1> <p> Remember tap switch, make it into a" yes "</p>');
define('_MA_TADLOGIN_DEV_STEP4', '<h1> [Step 4] phone verification </h1> <p> Please enter the phone number, press the" Send as Text "In this case, FB will send newsletters, charged by and . Enter confirmation code on the bottom of the newsletter </p> ');
define('_MA_TADLOGIN_DEV_STEP5', '"<h1> [Step 5] Congratulations on the completion of the first step </h1> <p> Now that you have a FB developer, the future would be no need to repeat this step up! </p>');

define('_MA_TADLOGIN_STEP1', "<h1>[Step 1] Create application</h1><p>Please connect to <a href='https://developers.facebook.com/apps' target='_blank'>https://developers.facebook.com/apps</a>, if you are already a developer, you should see 'Create New Application' button, click 'Create New Application' to start setting. </p>");
define('_MA_TADLOGIN_STEP2', '<p>[Step 2] Click "basic setup"</p>');
define('_MA_TADLOGIN_STEP3', '<h1>[Step 3] Create a new app</h1><p><ol><li>"Display name" to fill in a you can understand the Chinese can be, such as "quick login" </li> <li> "category" just pick one!</li></ol></p>');
define('_MA_TADLOGIN_STEP4', '<h1>[Step 4] Verify</h1><p>Please try to pass the annoying verification code.</p>');
define('_MA_TADLOGIN_STEP5', '<h1>[Step 5] Sign in with Facebook</h1><p>Locate "Facebook Login" and click on "Get started"</p>');
define('_MA_TADLOGIN_STEP6', "<h1>[Step 6] OAuth settings</h1><p>
\"OAuth redirect URI\" Please fill in <span class = 'text-danger'>" . XOOPS_URL . '/modules/</span> and press the "Save changes"</p>');
define('_MA_TADLOGIN_STEP7', '<h1>[Step 7] Dashboard settings</h1><p>Click Dashboard in the upper left menu</p>');
define('_MA_TADLOGIN_STEP8', '<h1>[Step 8] The most important information</h1><p>Then enter the URL of the site you want to log in to with FB. The "App ID" and "App Secret" above are just two values to fill in the XOOPS quick sign-in preferences.</p>');
define('_MA_TADLOGIN_STEP9', '<h1>[Step 9] XOOPS Preferences</h1><p>Please link to the preferences of this module, fill in "App ID" and "App Secret", and select "Facebook" authentication mode, then save.</p>');
define('_MA_TADLOGIN_STEP10', '<h1>[Step 10] Basic settings</h1><p>Click "Settings -> Basic" in the upper left menu.</p>');
define('_MA_TADLOGIN_STEP11', '<h1>[Step 11] Add platform</h1><p>Then click "Add platform"</p>');
define('_MA_TADLOGIN_STEP12', '<h1>[Step 12] Add Site</h1><p>Please select "Website".</p>');
define('_MA_TADLOGIN_STEP13', '<h1>[Step 13] URL settings</h1><p>
  <ol>
    <li> First, enter the URL of the website you want to log in with FB. </li>
    <li> Set up your app domain </li>
    <li> Fill in the namespace with an English letter (only lowercase letters and underscores or - symbols, numbers, or Chinese not possible), for example: xxx_login, at least seven characters. </li>
    <li> Finally, click "Save Changes" in the bottom right corner. </li>
  </ol>
  </p>');
define('_MA_TADLOGIN_STEP14', '<h1>[Step 14] App review settings</h1><p>In the upper left menu, click "App review"</p>');
define('_MA_TADLOGIN_STEP15', '<h1>[Step 15] Publish the app</h1><p>Click on the switch to make it "Yes" to finish!</p>');

define('_MA_TADLOGIN_GOO_STEP1', "<h1> [Step 1] Create a Google Project </h1> <p> Please connect to <a href = 'https: //console.developers.google.com/project' target = '_blank'> https://console.developers.google.com/project </a> Create a new project </p> ");
define('_MA_TADLOGIN_GOO_STEP2', '<h1> [Step 2] Set project name </h1>');
define('_MA_TADLOGIN_GOO_STEP3', '<h1> [Step 3] Set credentials </h1> <p> From the top left menu → "APIs and services" → "Credentials" </p>');
define('_MA_TADLOGIN_GOO_STEP4', '<h1> [Step 4] Create a certificate </h1> <p> Click "OAuth client ID" in "Create a certificate"</p>');
define('_MA_TADLOGIN_GOO_STEP5', "<h1> [Step 5] Set the consent screen </h1>");
define('_MA_TADLOGIN_GOO_STEP6', '<h1> [Step 6] Set OAuth consent screen </h1> <p> If you are not using G suite, please use "External" </p>');
define('_MA_TADLOGIN_GOO_STEP7', '<p> Set application name </p>');
define('_MA_TADLOGIN_GOO_STEP8', '<p> Set the "authorized domain", please use the top-level domain, remember to press Enter to join, other fields can fill in the URL <span style =" color: blue; ">' . XOOPS_URL . '</span></p> ');
$http = $_SERVER['HTTPS'] ? 'https: //' : 'http: //';
define('_MA_TADLOGIN_GOO_STEP9', '<h1> [Step 7] Set the allowed source of the restricted key </h1> <p>
<ol style = "list-style: decimal inside;">
<li style = "line-height: 2em;"> Please go back to step 4 and click "OAuth Client ID" in "Create Certificate". </li>
<li style = "line-height: 2em;"> Select "Web Application" and enter the main URL of the host "<span style =" color: blue; "> in " Authorized JavaScript Source" ' . $http . $_SERVER['HTTP_HOST'] . '</span> "; </li>
<li style = "line-height: 2em;"> For "authorized redirects" enter <span style =" color: blue; "> ' . XOOPS_URL . ' /modules/tad_login/index.php</span></li>
</ol></p>');
$mid = $xoopsModule->mid();
define('_MA_TADLOGIN_GOO_STEP10', '<h1> [Step 8] Complete the preference settings </h1> <p> The bottom is to fill in the values ​​of the items in the preferences at that time, please go to <a href = "' . XOOPS_URL . ' /modules/system/admin.php?fct=preferences&op=showmod&mod= ' . $mid . ' "target =" _blank "> Preferences </a> Paste in sequence (be sure to remove the white space before and after). </p> ');
define('_MA_TADLOGIN_GOO_STEP11', '<h1> [Step 9] Set API Key </h1> <p> Click "API Key" in "Creating Certificate" to create API Key </p>');
define('_MA_TADLOGIN_GOO_STEP12', '<h1> [Step 10] Paste the API key </h1> <p> The API key underneath is to fill in <a href = "' . XOOPS_URL . '/modules/system/admin.php?fct=preferences&op=showmod&mod=' . $mid . ' "target ="_blank "> Preferences </a>, please click" Restriction Key "after filling in. </p > ');
define('_MA_TADLOGIN_GOO_STEP13', '<h1> [Step 11] Restrict Keys </h1> <p> Please select "None" to avoid 403 error message, and "API Restrictions" is set to "Unrestricted Keys". After saving, you can try to log in. </P> ');

define('_MA_TADLOGIN_ITEM', 'School Code or Email');
define('_MA_TADLOGIN_GROUP_ID', 'Group');

define('_MA_TADLOGIN_EMAIL', 'Email');
define('_MA_TADLOGIN_EMAIL_DESC', 'You can use any symbol to separate emails, or use *.tn.edu.tw universal characters');
define('_MA_TADLOGIN_SCHOOLCODE', 'School Code');
define('_MA_TADLOGIN_TEACHER', 'Teacher');
define('_MA_TADLOGIN_STUDENT', 'Student');
define('_MA_TADLOGIN_JOB', 'Job');

define('_MA_TADLOGIN_CLIENTID', 'client id');
define('_MA_TADLOGIN_CLIENTSECRET', 'client secret');

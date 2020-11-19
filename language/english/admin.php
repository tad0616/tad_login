<?php
xoops_loadLanguage('admin_common', 'tadtools');
$http = $_SERVER['HTTPS'] ? 'https://' : 'http://';
$mid = $xoopsModule->mid();

define('_MA_TADLOGIN_STEP1', "<h1> [Step 1] Create an application </h1> <p> Please connect to <a href='https://developers.facebook.com/apps' target='_blank'>https://developers.facebook.com/apps</a>, if you are already a developer, you should see the \"Create Application\" button, please click \"Create Application\" to get started. </p > ");
define('_MA_TADLOGIN_STEP2', '<h1> [Step 2] Then "Create Application Number" </h1> <p> You can set the display name and mailbox </p>');
define('_MA_TADLOGIN_STEP3', '<h1> [Step 3] Verify </h1> <p> Tick it </p>');
define('_MA_TADLOGIN_STEP4', '<h1> [Step 4] Login with Facebook </h1> <p> Find "Facebook Login" and click "Settings </p>');
define('_MA_TADLOGIN_STEP5', '<h1> [Step 5] Set it yourself </h1> <p> We do n’t need to set it quickly, but just click “Settings” under “Facebook Login” on the left </p>');
define('_MA_TADLOGIN_STEP6', '<h1> [Step 6] OAuth settings </h1> <p> "Valid OAuth redirection URI", please fill in "<span style =" color: blue; ">' . XOOPS_URL . '/modules/tad_login/fb-callback.php </span> "and remember to click" Save Changes "in the bottom right corner </p>');
define('_MA_TADLOGIN_STEP7', '<h1> [Step 7] Basic data settings </h1> <p> Click "Settings" in the upper left corner → "Basic data" </p>');
define('_MA_TADLOGIN_STEP8', '<h1> [Step 8] The most important information </h1> <p> <ol style = "list-style: decimal inside;">
<li style = "line-height: 2em;"> The "application ID" and "application key" above are just to fill in XOOPS and quickly log in to <a href = "' . XOOPS_URL . ' / modules / system /admin.php?fct=preferences&op=showmod&mod= ' . $mid . ' "target ="_blank"> Preferences </a>. </li>
<li style = "line-height: 2em;"> Set the "display name", please feel free to enter it </li>
<li style = "line-height: 2em;"> Set the "namespace" and fill in an English code (only lowercase English letters and underscores or-symbols, numbers or Chinese will not work), for example: xxx_login, at least seven characters the above. </li>
<li style = "line-height: 2em;"> Then set the "application domain", such as: <span style = "color: blue;"> ' . $_SERVER['HTTP_HOST'] . ' </span> </li>
<li style = "line-height: 2em;"> Others, such as "Privacy Policy", "Terms of Service", etc., just enter the URL, such as: <span style = "color: blue;"> ' . XOOPS_URL . ' </span> </li>
</ol>
</p>');
define('_MA_TADLOGIN_STEP9', '<h1> [Step 9] Preferences </h1> <p> Please connect to this module\'s <a href = "' . XOOPS_URL . '/modules/system/admin.php?fct = preferences & op = showmod & mod = ' . $mid . ' "target ="_blank"> Preferences </a>, fill in the" application ID "and" application key "in order, and remember to select" Facebook "certification Way, and finally save it. </P> ');
define('_MA_TADLOGIN_STEP10', '<h1> [Step 10] Return to the basic settings </h1> <p> Click "Add Platform" at the bottom </p>');
define('_MA_TADLOGIN_STEP11', '<h1> [Step 11] Add platform </h1> <p> Please select "Site" </p>');
define('_MA_TADLOGIN_STEP12', '<h1> [Step 12] URL settings </h1> <p> For example: <span style = "color: blue;">' . XOOPS_URL . '</span>, remember to press " Save Changes "is valid. </P> ');
define('_MA_TADLOGIN_STEP13', '<h1> [Step 13] Adjust the website </h1> <p> Click the "adjusting" </p>');
define('_MA_TADLOGIN_STEP14', '<h1> [Step 14] Switch mode </h1> <p> Click "Switch mode", you can try it out. </p>');

define('_MA_TADLOGIN_GOO_STEP1', "<h1> [Step 1] Create a Google Project </h1> <p> Please connect to <a href = 'https: //console.developers.google.com/project' target = '_blank'> https://console.developers.google.com/project </a> Create a new project </p> ");
define('_MA_TADLOGIN_GOO_STEP2', '<h1> [Step 2] Set project name </h1>');
define('_MA_TADLOGIN_GOO_STEP3', '<h1> [Step 3] Set credentials </h1> <p> From the top left menu → "APIs and services" → "Credentials" </p>');
define('_MA_TADLOGIN_GOO_STEP4', '<h1> [Step 4] Create a certificate </h1> <p> Click "OAuth client ID" in "Create a certificate"</p>');
define('_MA_TADLOGIN_GOO_STEP5', "<h1> [Step 5] Set the consent screen </h1>");
define('_MA_TADLOGIN_GOO_STEP6', '<h1> [Step 6] Set OAuth consent screen </h1> <p> If you are not using G suite, please use "External" </p>');
define('_MA_TADLOGIN_GOO_STEP7', '<p> Set application name </p>');
define('_MA_TADLOGIN_GOO_STEP8', '<p> Set the "authorized domain", please use the top-level domain, remember to press Enter to join, other fields can fill in the URL <span style =" color: blue; ">' . XOOPS_URL . '</span></p> ');
define('_MA_TADLOGIN_GOO_STEP9', '<h1> [Step 7] Set the allowed source of the restricted key </h1> <p>
<ol style = "list-style: decimal inside;">
<li style = "line-height: 2em;"> Please go back to step 4 and click "OAuth Client ID" in "Create Certificate". </li>
<li style = "line-height: 2em;"> Select "Web Application" and enter the main URL of the host "<span style =" color: blue; "> in " Authorized JavaScript Source" ' . $http . $_SERVER['HTTP_HOST'] . '</span> "; </li>
<li style = "line-height: 2em;"> For "authorized redirects" enter <span style =" color: blue; "> ' . XOOPS_URL . ' /modules/tad_login/index.php</span></li>
</ol></p>');
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

define('_MA_TADLOGIN_NAME', 'Name');
define('_MA_TADLOGIN_UNAME', 'ID');
define('_MA_TADLOGIN_LAST_LOGIN', 'Last Login Time');
define('_MA_TADLOGIN_HASHED_DATE', 'Change Password Time');
define('_MA_TADLOGIN_MANAGE_PASSWORD', 'Manage Password');
define('_MA_TADLOGIN_MODIFY_PASSWORD', 'Change Password');
define('_MA_TADLOGIN_CHANGE_BINDING_PASSWORD', 'Change Binding Password');
define('_MA_TADLOGIN_BIND_ID', 'Bind me.');
define('_MA_TADLOGIN_SET_PASSWORD', 'Set a login password');
define('_MA_TADLOGIN_BIND_ALL_ID', 'Set login passwords for unbonded OpenID accounts (%s total).');
define('_MA_TADLOGIN_BIND_DESC1', 'After setting a binding password, users can use both OpenID login (with the original OpenID password) and account password login (with the binding password), and use the same identity.');
define('_MA_TADLOGIN_BIND_DESC2', 'If you can\'t login with OpenID, you can login with your account and password.');
define('_MA_TADLOGIN_BIND_DESC3', 'If OpenID does not have the problem of deactivation, the administrator does not need to bind passwords for all users.');
define('_MA_TADLOGIN_BIND_DESC4', 'The binding password is the login password, changing the binding password will not affect the OpenID password.');
define('_MA_TADLOGIN_BIND_DESC5', 'Users can change their own passwords, it is recommended to open the <a href="' . XOOPS_URL . '/modules/system/admin.php?fct=blocksadmin&op=list&filter=1&selgen=%s&selmod=-2&selgrp=-1&selvis=-1">tad_login block</a> and set it to appear on All Pages');

define('_MA_TADLOGIN_NON_ADMINISTRATIVE', 'Non-administrative, no executive authority');

define('_MA_TADLOGIN_LINE_STEP1', "<h1>【Step 1】Build Line Channel</h1><p>Please link to <a href='https://developers.line.biz/console/channel/new? type=line-login' target='_blank'>https://developers.line.biz/console/channel/new?type=line-login</a>
<ol>
<li>To create a new channel, [Channel type] please select \"LINE Login\"</li>.
<li>[Provider] can select \"Create a new provider\" to create a new </li>.
<li>[Region] Select \"Taiwan\". (Currently only four regions are supported, if the host is not in one of these four regions, it will not work even if it is set up) </li>.
<li>[Channel icon] can upload a picture, or not. </li>
</ol></p>");
define('_MA_TADLOGIN_LINE_STEP2', '<h1>Step 2】 Basic Setup 1</h1><p>
<ol>
<li>Fill [Channel name] and [Channel description]</li>
<li>[App types]:「Web App」</li>
<li>[Email address]Required fields</li>
</ol></p>');
define('_MA_TADLOGIN_LINE_STEP3', '<h1>【Step 3】basic setting 2</h1><p>
<ol>
<li>[Privacy policy URL] Privacy policy URL and [Terms of use URL] Terms of use, if any, can be filled in (no harm in not filling in the URL). </li> The [Privacy policy URL] and [Terms of use URL] terms of use.
<li>Please check the agreement box below</li>.
<li>Finally click on "Create" to create the channel</li>.
</ol></p>');
define('_MA_TADLOGIN_LINE_STEP4', '<h1>【Step 4】Copy Channel ID</h1>');
define('_MA_TADLOGIN_LINE_STEP5', '<h1>[Step 5] to <a href="' . XOOPS_URL . '/modules/system/admin.php?fct=preferences&op=showmod&mod=' . $mid . '" target="_blank">Preferences</a> Paste the Channel ID and add Line</h1> to the "Authentication method to use"');
define('_MA_TADLOGIN_LINE_STEP6', '<h1>[Step 6] copy Channel secret </h1>');
define('_MA_TADLOGIN_LINE_STEP7', '<h1>[Step 7] to <a href="' . XOOPS_URL . '/modules/system/admin.php?fct=preferences&op=showmod&mod=' . $mid . '" target="_blank">Preferences</a> Paste Channel secret, and save settings</h1>');
define('_MA_TADLOGIN_LINE_STEP8', '<h1>【Step 8】Setup to get email information</h1><p>Go to [Email address permission] at the bottom and click "Apply", check all the boxes, the image must be uploaded, and then click "Submit". This can be done</p>');
define('_MA_TADLOGIN_LINE_STEP9', '<h1>【Step 9】Set the Callback URL</h1><p>Switch to the "LINE Login" tab, click the "Edit" button of [Callback URL], and fill in the "<span style=" color:blue;">' . XOOPS_URL . '/modules/tad_login/line_callback.php</span>"</p>');

<?php
xoops_loadLanguage('admin_common', 'tadtools');
$http = isset($_SERVER['HTTPS']) ? 'https://' : 'http://';
$mid = $xoopsModule->mid();
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

define('_MA_TADLOGIN_NAME', 'Real Name');
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

define('_MA_TADLOGIN_KEYWORD', 'Keyword');
define('_MA_TADLOGIN_KEYWORD_DESC', 'Please enter your real name, account number, email... and other information');
define('_MA_TADLOGIN_REAL_NAME_SEARCH', 'Real Name Search');
define('_MA_TADLOGIN_KEYWORD_REAL_NAME', 'Please enter your real name');
define('_MA_TADLOGIN_PICK_TWO_UESER', 'Please check the account that you want to exchange uid (to check two)');
define('_MA_TADLOGIN_ABOUT_CHANGE_UID', 'About the "OpenID Account" scenario');
define('_MA_TADLOGIN_ABOUT_CHANGE_UID_DESC', '<ol><li>As more and more counties and cities stop using OpenID and switch to OIDC login, the same person may have two different accounts. </li><li>If you want the new OIDC account to continue all the posting records or settings of the previous OpenID account, you can do so by swapping uid numbers. </li><li>"Swapping uid numbers" means applying the uid of the original OpenID account to the new OIDC account for a painless transfer. </li><li>The uid of the deactivated OpenID account will be replaced with the original OIDC uid number, but since the OpenID account will not be used again, it will not be affected. </li></ol>');
define('_MA_TADLOGIN_ABOUT_CHANGE_UID_TODO', '<ol><li>We suggest searching with your real name first</li><li>then check the two accounts to send</li><li>This will swap the uid of the two accounts</li><li>Only the accounts with OpenID or OIDC will be listed at the bottom</li></ol>.');

define('_MA_TADLOGIN_CHANGE_OK', 'Successfully executed uid swap! (%s = %s, %s = %s)');

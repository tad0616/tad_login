<?php
include_once '../../tadtools/language/' . $xoopsConfig['language'] . '/admin_common.php';
define('_TAD_NEED_TADTOOLS', 'This module needs TadTools module. You can download TadTools from <a href="http://campus-xoops.tn.edu.tw/modules/tad_modules/index.php?module_sn=1" target="_blank">XOOPS EasyGO</a>.');

define('_MA_TADLOGIN_DEV_STEP1', '<h1> [Step 1] if not the FB developer </h1> <p> Please connect to <a href = \'https: //developers.facebook.com/apps\' target =\' _blank \'> https://developers.facebook.com/apps </a>, if not "create a new Application" button, then you must first click on the "Register Now" has become the FB developer job. </p > ');
define('_MA_TADLOGIN_DEV_STEP2', "<h1> [Step 2] Input FB password </h1> <p> </p>");
define('_MA_TADLOGIN_DEV_STEP3', '<h1> [Step 3] to register as FB developer </h1> <p> Remember tap switch, make it into a" yes "</p>');
define('_MA_TADLOGIN_DEV_STEP4', '<h1> [Step 4] phone verification </h1> <p> Please enter the phone number, press the" Send as Text "In this case, FB will send newsletters, charged by and . Enter confirmation code on the bottom of the newsletter </p> ');
define('_MA_TADLOGIN_DEV_STEP5', '"<h1> [Step 5] Congratulations on the completion of the first step </h1> <p> Now that you have a FB developer, the future would be no need to repeat this step up! </p>');

define('_MA_TADLOGIN_STEP1', "<h1>[Step 1] Create application</h1><p>Please connect to <a href='https://developers.facebook.com/apps' target='_blank'>https://developers.facebook.com/apps</a>, if you are already a developer, you should see 'Create New Application' button, click 'Create New Application' to start setting. </p>");
define('_MA_TADLOGIN_STEP2', "<p>[Step 2] Click \"basic setup\"</p>");
define('_MA_TADLOGIN_STEP3', "<h1>[Step 3] Create a new app</h1><p><ol><li>\"Display name\" to fill in a you can understand the Chinese can be, such as \"quick login\" </ li> <li> \"category\" just pick one!</li></ol></p>");
define('_MA_TADLOGIN_STEP4', "<h1>[Step 4] Verify</h1><p>Please try to pass the annoying verification code.</p>");
define('_MA_TADLOGIN_STEP5', "<h1>[Step 5] Sign in with Facebook</h1><p>Locate \"Facebook Login\" and click on \"Get started\"</p>");
define('_MA_TADLOGIN_STEP6', "<h1>[Step 6] OAuth settings</h1><p>
\"OAuth redirect URI\" Please fill in <span class = 'text-danger'>" . XOOPS_URL . "/modules/</span> and press the \"Save changes\"</p>");
define('_MA_TADLOGIN_STEP7', "<h1>[Step 7] Dashboard settings</h1><p>Click Dashboard in the upper left menu</p>");
define('_MA_TADLOGIN_STEP8', "<h1>[Step 8] The most important information</h1><p>Then enter the URL of the site you want to log in to with FB. The \"App ID\" and \"App Secret\" above are just two values to fill in the XOOPS quick sign-in preferences.</p>");
define('_MA_TADLOGIN_STEP9', "<h1>[Step 9] XOOPS Preferences</h1><p>Please link to the preferences of this module, fill in \"App ID\" and \"App Secret\", and select \"Facebook\" authentication mode, then save.</p>");
define('_MA_TADLOGIN_STEP10', "<h1>[Step 10] Basic settings</h1><p>Click \"Settings -> Basic\" in the upper left menu.</p>");
define('_MA_TADLOGIN_STEP11', "<h1>[Step 11] Add platform</h1><p>Then click \"Add platform\"</p>");
define('_MA_TADLOGIN_STEP12', "<h1>[Step 12] Add Site</h1><p>Please select \"Website\".</p>");
define('_MA_TADLOGIN_STEP13', "<h1>[Step 13] URL settings</h1><p>
  <ol>
    <li> First, enter the URL of the website you want to log in with FB. </li>
    <li> Set up your app domain </li>
    <li> Fill in the namespace with an English letter (only lowercase letters and underscores or - symbols, numbers, or Chinese not possible), for example: xxx_login, at least seven characters. </li>
    <li> Finally, click \"Save Changes\" in the bottom right corner. </li>
  </ol>
  </p>");
define('_MA_TADLOGIN_STEP14', "<h1>[Step 14] App review settings</h1><p>In the upper left menu, click \"App review\"</p>");
define('_MA_TADLOGIN_STEP15', "<h1>[Step 15] Publish the app</h1><p>Click on the switch to make it \"Yes\" to finish!</p>");

define('_MA_TADLOGIN_GOO_STEP1', "<h1> [Step 1] set up Google ad hoc </h1> <p> Please connect to <a href = 'https: //console.developers.google.com/project' target = '_ blank '> https://console.developers.google.com/project </a> establish a new project </p> ");
define('_MA_TADLOGIN_GOO_STEP2', "<h1> [Step 2] Start API </h1> <p> After the project is established, to OverView The project is to initiate the API, you can press the </p>.");
define('_MA_TADLOGIN_GOO_STEP3', '<h1> [Step 3] establish certificate </h1> <p> to" Credentials ", click" Create new Client ID "</p>');
define('_MA_TADLOGIN_GOO_STEP4', '<h1> [Step 4] establish Client ID </h1> <p> select "Web application","Authorized JavaScript origins, "the website address: \'Authorized redirect URI "enter \"" .XOOPS_URL . "/modules/tad_login/index.php" </p> ');
define('_MA_TADLOGIN_GOO_STEP5', '<h1> [Step 5] to obtain Client ID </h1> <p> red box office is the time to fill in the project value preferences of </p>.');
define('_MA_TADLOGIN_GOO_STEP6', '<h1> [Step 6] establish API Key </h1> <p> Click on" Create new Key "to establish API Key </p>');
define('_MA_TADLOGIN_GOO_STEP7', '<h1> [Step 7] to establish new keys </h1> <p> Select" Browser Key "</p>');
define('_MA_TADLOGIN_GOO_STEP8', '<h1> [Step 8] set to allow source </h1> <p> Enter the Guizhan domain name to </p>.');
define('_MA_TADLOGIN_GOO_STEP9', '<h1> [Step 9] get API Key </h1> <p> red box at the API Key is the time to fill in the project value preferences of </p>.');
define('_MA_TADLOGIN_GOO_STEP10', '<h1> [Step 10] login screen set </h1> <p> Setting up your Email, as well as project name, became a big announcement </p>!');
define('_MA_TADLOGIN_GOO_STEP11', '<h1> [Step 11] to Preferences </h1> <p> Next, go to Preferences, four field sequence can fill </p>.');

define('_MA_TADLOGIN_GOO_STEP1', "<h1> [Step 1] Create a Google project </ h1> <p> Go to <a href='https://console.developers.google.com/project' target='_blank'> https://console.developers.google.com/project </a> Create a new project </p>");
define('_MA_TADLOGIN_GOO_STEP2', "<h1> [Step 2] Create a certificate</h1><p>To the \"Credentials\", click \"New credentials\" in the \"OAuth client ID\"</p>");
define('_MA_TADLOGIN_GOO_STEP3', "<h1> [Step 3] Set the \"OAuth consent screen\"</h1><p>Choose an Email Address, specify a Product Name, and press Save. </p>");
define('_MA_TADLOGIN_GOO_STEP4', "<h1> [Step 4] Create \"OAuth client ID\"</h1><p>Under Application type, select Web application. In the Authorized JavaScript origins field, enter the origin for your app. You can enter multiple origins to allow for your app to run on different protocols, domains, or subdomains. You cannot use wildcards. In the example below, the second URL could be a production URL. The Authorized redirect URI field, enter \"<span style = 'color: blue;'>" . XOOPS_URL . "/modules/tad_login/index.php</span>\"</p>");
define('_MA_TADLOGIN_GOO_STEP5', "<h1> [Step 5] Get client ID</h1><p>Under the time is to fill in the preferences of the project value (paste, be sure to remove the blank before and after).</p>");
define('_MA_TADLOGIN_GOO_STEP6', "<h1> [Step 6] Create an API key</h1><p>Click API Key to create the API key</p>");
define('_MA_TADLOGIN_GOO_STEP7', "<h1> [Step 7] Get the API key</h1><p>The API key is the value of the item to fill in the preferences.</p>");
define('_MA_TADLOGIN_GOO_STEP8', "<h1> [Step 8] Sets the allowed key source</h1><p>Select \"HTTP Referrer (Website)\" to enter your domain name, followed by " * " for all pages.</p>");
define('_MA_TADLOGIN_GOO_STEP9', "<h1> [Step 9] Complete your preferences</h1><p>Finally, please go to the preferences, the three fields can be filled in order, paste, be sure to remove the blank before and after. Also remember to select \"Sign in using Google\"</p>");

define('_MA_TADLOGIN_ITEM', "School Code or Email");
define('_MA_TADLOGIN_GROUP_ID', "Group");

define('_MA_TADLOGIN_EMAIL', "Email");
define('_MA_TADLOGIN_SCHOOLCODE', "School Code");
define('_MA_TADLOGIN_TEACHER', "Teacher");
define('_MA_TADLOGIN_STUDENT', "Student");
define('_MA_TADLOGIN_JOB', "Job");

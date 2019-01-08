<?php
include_once XOOPS_ROOT_PATH . "/modules/tadtools/language/{$xoopsConfig['language']}/modinfo_common.php";
include_once 'county.php';

define('_MI_TADLOGIN_NAME', 'Tad Login');
define('_MI_TADLOGIN_AUTHOR', 'Tad');
define('_MI_TADLOGIN_CREDITS', 'Wang Jiatian director (adm@mail.cyc.edu.tw)');
define('_MI_TADLOGIN_ADMENU1', 'Facebook certificate');
define('_MI_TADLOGIN_ADMENU1_DESC', 'Facebook certification statement');
define('_MI_TADLOGIN_ADMENU2', 'Auto Group Set');
define('_MI_TADLOGIN_ADMENU3', 'Google Certificate');
define('_MI_TADLOGIN_ADMENU3_DESC', 'Google Certified Set Description');

define('_MI_TADLOGIN_DESC', 'Join FB and other fast login mechanism');
define('_MI_TADLOGIN_BNAME1', 'Tad Login');
define('_MI_TADLOGIN_BDESC1', 'Tad Login (tad_login)');
define('_MI_TADLOGIN_APPID', 'FaceBook "Application ID"');
define('_MI_TADLOGIN_APPID_DESC', 'Please go to https://developers.facebook.com/apps and obtain the"Application ID", the default value of your site is invalid (for reference only. only)');
define('_MI_TADLOGIN_SECRET', 'FaceBook "Application Key"');
define('_MI_TADLOGIN_SECRET_DESC', 'Please go to https://developers.facebook.com/apps build an application and obtain the "Application key", the default value of your site is invalid (for reference only');
define('_MI_TADLOGIN_AUTH_METHOD', 'Select authentication method');
define('_MI_TADLOGIN_AUTH_METHOD_DESC', 'Please multi-select authentication that you let your users to use to login');
define('_MI_TADLOGIN_LOGIN', 'Use %s login');
define('_MI_TADLOGIN_REAL_JOBNAME', 'Apply OpenID title');
define('_MI_TADLOGIN_REAL_JOBNAME_DESC', 'Selecting "Yes" will try to get the OpenID title and return it (if any), selecting "No" will only determine whether it is a student or a teacher.');

define('_MI_TADLOGIN_GOOGLE_APPID', 'Google\'s "Client ID"');
define('_MI_TADLOGIN_GOOGLE_APPID_DESC', 'Please go to https://console.developers.google.com, create a Project, and get a "Client ID", or the default value of your site is invalid (for reference only).');
define('_MI_TADLOGIN_GOOGLE_SECRET', 'Google\'s "Client secret"');
define('_MI_TADLOGIN_GOOGLE_SECRET_DESC', 'Please go to https://console.developers.google.com, create a Project, and has made its "Client secret", or the default value of your site is invalid (for reference only).');

define('_MI_TADLOGIN_TWITTER_APPID', 'Twitter\'s "API key" ');
define('_MI_TADLOGIN_TWITTER_APPID_DESC', 'Please go to http://hayageek.com/login-with-twitter, create an Application, and made its "API key", or the default value of your site is invalid (for reference only)');
define('_MI_TADLOGIN_TWITTER_SECRET', 'Twitter\'s "API secret"');
define('_MI_TADLOGIN_TWITTER_SECRET_DESC', 'Please go to http://hayageek.com/login-with-twitter, create an Application, and made its "API secret key", or the default value of your site is invalid (for reference only)');

define('_MI_TADLOGIN_GOOGLE_REDIRECT_URL', 'Google\'s "Redirect URIs');
define('_MI_TADLOGIN_GOOGLE_REDIRECT_URL_DESC', 'Please go to https://console.developers.google.com, create a Project, and to obtain their "Redirect URIs."');
define('_MI_TADLOGIN_GOOGLE_API_KEY', 'Google\'s "API key');
define('_MI_TADLOGIN_GOOGLE_API_KEY_DESC', 'Please go to https://console.developers.google.com, create a Project, and obtain their "API key".');

define('_MI_TADLOGIN_TITLE2', 'Navigation bar Login Options');
define('_MI_TADLOGIN_DESC2', 'Please select the default navigation bar login presentation options');
define('_MI_TADLOGIN_TITLE2_OPT0', 'Display only XOOPS login interface');
define('_MI_TADLOGIN_TITLE2_OPT1', 'While displaying the XOOPS login screen, the OpenID buttons are off');
define('_MI_TADLOGIN_TITLE2_OPT2', 'Display only OpenID button');
define('_MI_TADLOGIN_TITLE2_OPT3', 'Does not show login option');

define('_MI_TADLOGIN_TITLE3', 'Quick Login menu icons in a row');
define('_MI_TADLOGIN_DESC3', 'Select how many Quick Login menu icons should we visible in one row, choose two or more.');

define('_MI_TADLOGIN_DIRNAME', basename(dirname(dirname(__DIR__))));
define('_MI_TADLOGIN_HELP_HEADER', __DIR__ . '/help/helpheader.html');
define('_MI_TADLOGIN_BACK_2_ADMIN', 'Back to Administration of ');

//help
define('_MI_TADLOGIN_HELP_OVERVIEW', 'Overview');

define('_MI_TADLOGIN_REDIRECT_URL', "Sign-in URL redirects to settings");
define('_MI_TADLOGIN_REDIRECT_URL_DESC', "You can set which URL to redirect to after login.");

define('_MI_TADLOGIN_EDU_CLIENTID', "Ministry of Education cloud openid connect clientid");
define('_MI_TADLOGIN_EDU_CLIENTID_DESC', "For application details, please visit https://oidc.tanet.edu.tw/");
define('_MI_TADLOGIN_EDU_CLIENTSECRET', "Ministry of Education cloud openid connect clientsecret");
define('_MI_TADLOGIN_EDU_CLIENTSECRET_DESC', "For application details, please visit https://oidc.tanet.edu.tw/");

define('_MI_TADLOGIN_TY_EDU_CLIENTID', "Ministry of Education cloud for Taoyuan City openid connect clientid");
define('_MI_TADLOGIN_TY_EDU_CLIENTID_DESC', "For application details, please visit https://tyc.sso.edu.tw");
define('_MI_TADLOGIN_TY_EDU_CLIENTSECRET', "Ministry of Education cloud for Taoyuan City openid connect clientsecret");
define('_MI_TADLOGIN_TY_EDU_CLIENTSECRET_DESC', "For application details, please visit https://tyc.sso.edu.tw");

define('_MI_TADLOGIN_TP_EDU_CLIENTID', "Ministry of Education cloud for Taipei City openid connect clientid");
define('_MI_TADLOGIN_TP_EDU_CLIENTID_DESC', "For application details, please visit https://ldap.tp.edu.tw");
define('_MI_TADLOGIN_TP_EDU_CLIENTSECRET', "Ministry of Education cloud for Taipei City openid connect clientsecret");
define('_MI_TADLOGIN_TP_EDU_CLIENTSECRET_DESC', "For application details, please visit https://ldap.tp.edu.tw");

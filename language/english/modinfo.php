<?php
xoops_loadLanguage('modinfo_common', 'tadtools');
require_once __DIR__ . '/county.php';

define('_MI_TADLOGIN_NAME', 'Tad Login');
define('_MI_TADLOGIN_AUTHOR', 'Tad');
define('_MI_TADLOGIN_CREDITS', 'Wang Jiatian director (adm@mail.cyc.edu.tw)');
define('_MI_TADLOGIN_ADMENU1', 'Facebook certificate');
define('_MI_TADLOGIN_ADMENU2', 'Auto Group Set');
define('_MI_TADLOGIN_ADMENU3', 'Google Certificate');
define('_MI_TADLOGIN_ADMENU4', 'Education cloud authentication settings');
define('_MI_TADLOGIN_ADMENU5', 'Password management');
define('_MI_TADLOGIN_ADMENU6', 'Line Authentication Setting Description');
define('_MI_TADLOGIN_ADMENU7', 'OIDC follows the OpenID account number');

define('_MI_TADLOGIN_DESC', 'Join FB and other fast login mechanism');
define('_MI_TADLOGIN_BNAME1', 'Tad Login');
define('_MI_TADLOGIN_BDESC1', 'Tad Login (tad_login)');
define('_MI_TADLOGIN_AUTH_METHOD', 'Select authentication method');
define('_MI_TADLOGIN_AUTH_METHOD_DESC', 'Please multi-select authentication that you let your users to use to login');
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

define('_MI_TADLOGIN_DIRNAME', basename(dirname(dirname(__DIR__))));
define('_MI_TADLOGIN_HELP_HEADER', __DIR__ . '/help/helpheader.tpl');
define('_MI_TADLOGIN_BACK_2_ADMIN', 'Back to Administration of ');

//help
define('_MI_TADLOGIN_HELP_OVERVIEW', 'Overview');

define('_MI_TADLOGIN_REDIRECT_URL', 'Sign-in URL redirects to settings');
define('_MI_TADLOGIN_REDIRECT_URL_DESC', 'You can set the address to which you want to be directed after login.');

define('_TADLOGIN_OIDC_SETUP', 'OIDC Education Cloud Account Settings');
define('_TADLOGIN_OIDC_SETUP_DESC', 'Do not move, please setup from <a href="' . XOOPS_URL . '/modules/tad_login/admin/oidc.php">' . XOOPS_URL . '/modules/tad_login/admin/oidc.php</a>');
define('_MI_TADLOGIN_LINE_ID', 'Channel ID of Line');
define('_MI_TADLOGIN_LINE_ID_DESC', 'Create a channel to https://developers.line.biz/console/channel/new?type=line-login and get its "Channel ID"');
define('_MI_TADLOGIN_LINE_SECRET', 'Channel Secret of Line');
define('_MI_TADLOGIN_LINE_SECRET_DESC', 'Create a channel to https://developers.line.biz/console/channel/new?type=line-login and get its "Channel Secret"');

define('_MI_TADLOGIN_BIND_OPENID', 'Do you navigate to the binding screen after login');
define('_MI_TADLOGIN_BIND_OPENID_DESC', 'Generally it can be set to \'No\', but we recommend to select \'Yes\' if OpenID is no longer available in the future');

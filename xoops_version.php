<?php
$modversion = array();

//---模組基本資訊---//
$modversion['name'] = _MI_TADLOGIN_NAME;
$modversion['version'] = 3.01;
$modversion['description'] = _MI_TADLOGIN_DESC;
$modversion['author'] = _MI_TADLOGIN_AUTHOR;
$modversion['credits'] = _MI_TADLOGIN_CREDITS;
$modversion['help'] = 'page=help';
$modversion['license'] = 'GNU GPL 2.0';
$modversion['license_url'] = 'www.gnu.org/licenses/gpl-2.0.html/';
$modversion['image'] = "images/logo_{$xoopsConfig['language']}.png";
$modversion['dirname'] = basename(dirname(__FILE__));

//---模組狀態資訊---//
$modversion['release_date'] = '2014/05/22';
$modversion['module_website_url'] = 'http://tad0616.net/';
$modversion['module_website_name'] = _MI_TAD_WEB;
$modversion['module_status'] = 'release';
$modversion['author_website_url'] = 'http://tad0616.net/';
$modversion['author_website_name'] = _MI_TAD_WEB;
$modversion['min_php']=5.2;
$modversion['min_xoops']='2.5';
$modversion['min_tadtools']='2.08';

//---paypal資訊---//
$modversion ['paypal'] = array();
$modversion ['paypal']['business'] = 'tad0616@gmail.com';
$modversion ['paypal']['item_name'] = 'Donation : ' . _MI_TAD_WEB;
$modversion ['paypal']['amount'] = 0;
$modversion ['paypal']['currency_code'] = 'USD';


//---安裝設定---//
$modversion['onInstall'] = "include/onInstall.php";
$modversion['onUpdate'] = "include/onUpdate.php";
$modversion['onUninstall'] = "include/onUninstall.php";


//---啟動後台管理界面選單---//
$modversion['system_menu'] = 1;//---資料表架構---//
$modversion['sqlfile']['mysql'] = "sql/mysql.sql";
$modversion['tables'][1] = "tad_login_random_pass";
$modversion['tables'][2] = "tad_login_config";

//---管理介面設定---//
$modversion['hasAdmin'] = 1;
$modversion['adminindex'] = "admin/index.php";
$modversion['adminmenu'] = "admin/menu.php";

//---使用者主選單設定---//
$modversion['hasMain'] = 1;


//---樣板設定---//
$modversion['templates'] = array();
$i=1;
$modversion['templates'][$i]['file'] = 'tad_login_index_tpl.html';
$modversion['templates'][$i]['description'] = 'tad_login_index_tpl.html';

$i++;
$modversion['templates'][$i]['file'] = 'tad_login_adm_main.html';
$modversion['templates'][$i]['description'] = 'tad_login_adm_main.html';

$i++;
$modversion['templates'][$i]['file'] = 'tad_login_adm_fb.html';
$modversion['templates'][$i]['description'] = 'tad_login_adm_fb.html';


//---區塊設定---//
$modversion['blocks'][1]['file'] = "tad_login.php";
$modversion['blocks'][1]['name'] = _MI_TADLOGIN_BNAME1;
$modversion['blocks'][1]['description'] = _MI_TADLOGIN_BDESC1;
$modversion['blocks'][1]['show_func'] = "tad_login";
$modversion['blocks'][1]['template'] = "tad_login.html";
$modversion['blocks'][1]['edit_func'] = "tad_login_edit";
$modversion['blocks'][1]['options'] = "0|0";

$modversion['config'][0]['name']	= 'appId';
$modversion['config'][0]['title']	= '_MI_TADLOGIN_APPID';
$modversion['config'][0]['description']	= '_MI_TADLOGIN_APPID_DESC';
$modversion['config'][0]['formtype']	= 'textbox';
$modversion['config'][0]['valuetype']	= 'text';
$modversion['config'][0]['default']	= '';

$modversion['config'][1]['name']	= 'secret';
$modversion['config'][1]['title']	= '_MI_TADLOGIN_SECRET';
$modversion['config'][1]['description']	= '_MI_TADLOGIN_SECRET_DESC';
$modversion['config'][1]['formtype']	= 'textbox';
$modversion['config'][1]['valuetype']	= 'text';
$modversion['config'][1]['default']	= '';

$modversion['config'][4]['name']  = 'google_appId';
$modversion['config'][4]['title'] = '_MI_TADLOGIN_GOOGLE_APPID';
$modversion['config'][4]['description'] = '_MI_TADLOGIN_GOOGLE_APPID_DESC';
$modversion['config'][4]['formtype']  = 'textbox';
$modversion['config'][4]['valuetype'] = 'text';
$modversion['config'][4]['default'] = '';

$modversion['config'][5]['name']  = 'google_secret';
$modversion['config'][5]['title'] = '_MI_TADLOGIN_GOOGLE_SECRET';
$modversion['config'][5]['description'] = '_MI_TADLOGIN_GOOGLE_SECRET_DESC';
$modversion['config'][5]['formtype']  = 'textbox';
$modversion['config'][5]['valuetype'] = 'text';
$modversion['config'][5]['default'] = '';

$modversion['config'][6]['name']  = 'twitter_appId';
$modversion['config'][6]['title'] = '_MI_TADLOGIN_TWITTER_APPID';
$modversion['config'][6]['description'] = '_MI_TADLOGIN_TWITTER_APPID_DESC';
$modversion['config'][6]['formtype']  = 'textbox';
$modversion['config'][6]['valuetype'] = 'text';
$modversion['config'][6]['default'] = '';

$modversion['config'][7]['name']  = 'twitter_secret';
$modversion['config'][7]['title'] = '_MI_TADLOGIN_TWITTER_SECRET';
$modversion['config'][7]['description'] = '_MI_TADLOGIN_TWITTER_SECRET_DESC';
$modversion['config'][7]['formtype']  = 'textbox';
$modversion['config'][7]['valuetype'] = 'text';
$modversion['config'][7]['default'] = '';

$modversion['config'][2]['name']  = 'auth_method';
$modversion['config'][2]['title'] = '_MI_TADLOGIN_AUTH_METHOD';
$modversion['config'][2]['description'] = '_MI_TADLOGIN_AUTH_METHOD_DESC';
$modversion['config'][2]['formtype']  = 'select_multi';
$modversion['config'][2]['valuetype'] = 'array';
$modversion['config'][2]['default'] = array('google','yahoo','myid');
$modversion['config'][2]['options'] = array(
  sprintf(_MI_TADLOGIN_LOGIN,_FACEBOOK) => 'facebook',
  sprintf(_MI_TADLOGIN_LOGIN,_GOOGLE) => 'google',
  sprintf(_MI_TADLOGIN_LOGIN,_GOOGLE_V2) => 'google_v2',
  sprintf(_MI_TADLOGIN_LOGIN,_TWITTER) => 'Twitter',
  sprintf(_MI_TADLOGIN_LOGIN,_YAHOO) => 'yahoo',
  sprintf(_MI_TADLOGIN_LOGIN,_MYID) => 'myid',
  sprintf(_MI_TADLOGIN_LOGIN,_KL) => 'kl',
  sprintf(_MI_TADLOGIN_LOGIN,_NTPC) => 'ntpc',
  sprintf(_MI_TADLOGIN_LOGIN,_HCC) => 'hcc',
  sprintf(_MI_TADLOGIN_LOGIN,_HC) => 'hc',
  sprintf(_MI_TADLOGIN_LOGIN,_MLC) => 'mlc',
  sprintf(_MI_TADLOGIN_LOGIN,_TC) => 'tc',
  sprintf(_MI_TADLOGIN_LOGIN,_CHC) => 'chc',
  sprintf(_MI_TADLOGIN_LOGIN,_NTCT) => 'ntct',
  sprintf(_MI_TADLOGIN_LOGIN,_YLC) => 'ylc',
  sprintf(_MI_TADLOGIN_LOGIN,_CYC) => 'cyc',
  sprintf(_MI_TADLOGIN_LOGIN,_CY) => 'cy',
  sprintf(_MI_TADLOGIN_LOGIN,_TN) => 'tn',
  sprintf(_MI_TADLOGIN_LOGIN,_PTC) => 'ptc',
  sprintf(_MI_TADLOGIN_LOGIN,_HLC) => 'hlc',
  sprintf(_MI_TADLOGIN_LOGIN,_PHC) => 'phc');
//,_MI_TADLOGIN_CONF3_OPT18 => 'ilc'

$modversion['config'][3]['name']  = 'real_jobname';
$modversion['config'][3]['title'] = '_MI_TADLOGIN_REAL_JOBNAME';
$modversion['config'][3]['description'] = '_MI_TADLOGIN_REAL_JOBNAME_DESC';
$modversion['config'][3]['formtype']  = 'yesno';
$modversion['config'][3]['valuetype'] = 'int';
$modversion['config'][3]['default'] = '0';

?>
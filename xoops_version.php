<?php
$modversion = array();

//---模組基本資訊---//
$modversion['name'] = _MI_TADLOGIN_NAME;
$modversion['version'] = 3.3;
$modversion['description'] = _MI_TADLOGIN_DESC;
$modversion['author'] = _MI_TADLOGIN_AUTHOR;
$modversion['credits'] = _MI_TADLOGIN_CREDITS;
$modversion['help'] = 'page=help';
$modversion['license'] = 'GNU GPL 2.0';
$modversion['license_url'] = 'www.gnu.org/licenses/gpl-2.0.html/';
$modversion['image'] = "images/logo_{$xoopsConfig['language']}.png";
$modversion['dirname'] = basename(dirname(__FILE__));

//---模組狀態資訊---//
$modversion['release_date'] = '2015/03/31';
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
$modversion['templates'][$i]['file'] = 'tad_login_index_tpl_b3.html';
$modversion['templates'][$i]['description'] = 'tad_login_index_tpl_b3.html';

$i++;
$modversion['templates'][$i]['file'] = 'tad_login_adm_main.html';
$modversion['templates'][$i]['description'] = 'tad_login_adm_main.html';

$i++;
$modversion['templates'][$i]['file'] = 'tad_login_adm_main_b3.html';
$modversion['templates'][$i]['description'] = 'tad_login_adm_main_b3.html';


$i++;
$modversion['templates'][$i]['file'] = 'tad_login_adm_fb.html';
$modversion['templates'][$i]['description'] = 'tad_login_adm_fb.html';

$i++;
$modversion['templates'][$i]['file'] = 'tad_login_adm_google.html';
$modversion['templates'][$i]['description'] = 'tad_login_adm_google.html';



//---區塊設定---//
$modversion['blocks'][1]['file'] = "tad_login.php";
$modversion['blocks'][1]['name'] = _MI_TADLOGIN_BNAME1;
$modversion['blocks'][1]['description'] = _MI_TADLOGIN_BDESC1;
$modversion['blocks'][1]['show_func'] = "tad_login";
$modversion['blocks'][1]['template'] = "tad_login.html";
$modversion['blocks'][1]['edit_func'] = "tad_login_edit";
$modversion['blocks'][1]['options'] = "0|0";

$i=1;
$modversion['config'][$i]['name']	= 'appId';
$modversion['config'][$i]['title']	= '_MI_TADLOGIN_APPID';
$modversion['config'][$i]['description']	= '_MI_TADLOGIN_APPID_DESC';
$modversion['config'][$i]['formtype']	= 'textbox';
$modversion['config'][$i]['valuetype']	= 'text';
$modversion['config'][$i]['default']	= '';

$i++;
$modversion['config'][$i]['name']	= 'secret';
$modversion['config'][$i]['title']	= '_MI_TADLOGIN_SECRET';
$modversion['config'][$i]['description']	= '_MI_TADLOGIN_SECRET_DESC';
$modversion['config'][$i]['formtype']	= 'textbox';
$modversion['config'][$i]['valuetype']	= 'text';
$modversion['config'][$i]['default']	= '';

$i++;
$modversion['config'][$i]['name']  = 'google_appId';
$modversion['config'][$i]['title'] = '_MI_TADLOGIN_GOOGLE_APPID';
$modversion['config'][$i]['description'] = '_MI_TADLOGIN_GOOGLE_APPID_DESC';
$modversion['config'][$i]['formtype']  = 'textbox';
$modversion['config'][$i]['valuetype'] = 'text';
$modversion['config'][$i]['default'] = '';

$i++;
$modversion['config'][$i]['name']  = 'google_secret';
$modversion['config'][$i]['title'] = '_MI_TADLOGIN_GOOGLE_SECRET';
$modversion['config'][$i]['description'] = '_MI_TADLOGIN_GOOGLE_SECRET_DESC';
$modversion['config'][$i]['formtype']  = 'textbox';
$modversion['config'][$i]['valuetype'] = 'text';
$modversion['config'][$i]['default'] = '';

$i++;
$modversion['config'][$i]['name']  = 'google_redirect_uri';
$modversion['config'][$i]['title'] = '_MI_TADLOGIN_GOOGLE_REDIRECT_URL';
$modversion['config'][$i]['description'] = '_MI_TADLOGIN_GOOGLE_REDIRECT_URL_DESC';
$modversion['config'][$i]['formtype']  = 'textbox';
$modversion['config'][$i]['valuetype'] = 'text';
$modversion['config'][$i]['default'] = '';

$i++;
$modversion['config'][$i]['name']  = 'google_api_key';
$modversion['config'][$i]['title'] = '_MI_TADLOGIN_GOOGLE_API_KEY';
$modversion['config'][$i]['description'] = '_MI_TADLOGIN_GOOGLE_API_KEY_DESC';
$modversion['config'][$i]['formtype']  = 'textbox';
$modversion['config'][$i]['valuetype'] = 'text';
$modversion['config'][$i]['default'] = '';

$i++;
$modversion['config'][$i]['name']  = 'auth_method';
$modversion['config'][$i]['title'] = '_MI_TADLOGIN_AUTH_METHOD';
$modversion['config'][$i]['description'] = '_MI_TADLOGIN_AUTH_METHOD_DESC';
$modversion['config'][$i]['formtype']  = 'select_multi';
$modversion['config'][$i]['valuetype'] = 'array';
$modversion['config'][$i]['default'] = array('google','yahoo','myid');
$modversion['config'][$i]['options'] = array(
  sprintf(_MI_TADLOGIN_LOGIN,_FACEBOOK) => 'facebook',
  sprintf(_MI_TADLOGIN_LOGIN,_GOOGLE) => 'google',
  sprintf(_MI_TADLOGIN_LOGIN,_YAHOO) => 'yahoo',
  sprintf(_MI_TADLOGIN_LOGIN,_MYID) => 'myid',
  sprintf(_MI_TADLOGIN_LOGIN,_KL) => 'kl',
  sprintf(_MI_TADLOGIN_LOGIN,_NTPC) => 'ntpc',
  sprintf(_MI_TADLOGIN_LOGIN,_TYC) => 'tyc',
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
  sprintf(_MI_TADLOGIN_LOGIN,_KH) => 'kh',
  sprintf(_MI_TADLOGIN_LOGIN,_PTC) => 'ptc',
  //sprintf(_MI_TADLOGIN_LOGIN,_ILC) => 'ilc',
  sprintf(_MI_TADLOGIN_LOGIN,_HLC) => 'hlc',
  sprintf(_MI_TADLOGIN_LOGIN,_KM) => 'km',
  sprintf(_MI_TADLOGIN_LOGIN,_PHC) => 'phc');

$i++;
$modversion['config'][$i]['name']  = 'real_jobname';
$modversion['config'][$i]['title'] = '_MI_TADLOGIN_REAL_JOBNAME';
$modversion['config'][$i]['description'] = '_MI_TADLOGIN_REAL_JOBNAME_DESC';
$modversion['config'][$i]['formtype']  = 'yesno';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = '0';


$i++;
$modversion['config'][$i]['name'] = 'openid_login';
$modversion['config'][$i]['title'] = '_MI_TADLOGIN_TITLE2';
$modversion['config'][$i]['description'] = '_MI_TADLOGIN_DESC2';
$modversion['config'][$i]['formtype'] = 'select';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = '1';
$modversion['config'][$i]['options'] = array(_MI_TADLOGIN_TITLE2_OPT0=>'0' , _MI_TADLOGIN_TITLE2_OPT1=>'1' , _MI_TADLOGIN_TITLE2_OPT2=>'2' , _MI_TADLOGIN_TITLE2_OPT3=>'3');

$i++;
$modversion['config'][$i]['name'] = 'openid_logo';
$modversion['config'][$i]['title'] = '_MI_TADLOGIN_TITLE3';
$modversion['config'][$i]['description'] = '_MI_TADLOGIN_DESC3';
$modversion['config'][$i]['formtype'] = 'select';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = '4';
$modversion['config'][$i]['options'] = array(1=>'1' , 2=>'2' , 3=>'3' , 4=>'4' , 5=>'5' , 6=>'6');
?>
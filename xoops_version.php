<?php
$modversion = array();

//---模組基本資訊---//
$modversion['name'] = _MI_TADLOGIN_NAME;
$modversion['version'] = 2.00;
$modversion['description'] = _MI_TADLOGIN_DESC;
$modversion['author'] = _MI_TADLOGIN_AUTHOR;
$modversion['credits'] = _MI_TADLOGIN_CREDITS;
$modversion['help'] = 'page=help';
$modversion['license'] = 'GNU GPL 2.0';
$modversion['license_url'] = 'www.gnu.org/licenses/gpl-2.0.html/';
$modversion['image'] = "images/logo_{$xoopsConfig['language']}.png";
$modversion['dirname'] = basename(dirname(__FILE__));

//---模組狀態資訊---//
$modversion['release_date'] = '2013/11/26';
$modversion['module_website_url'] = 'http://tad0616.net/';
$modversion['module_website_name'] = _MI_TAD_WEB;
$modversion['module_status'] = 'release';
$modversion['author_website_url'] = 'http://tad0616.net/';
$modversion['author_website_name'] = _MI_TAD_WEB;
$modversion['min_php']=5.2;
$modversion['min_xoops']='2.5';
$modversion['min_tadtools']='1.20';

//---paypal資訊---//
$modversion ['paypal'] = array();
$modversion ['paypal']['business'] = 'tad0616@gmail.com';
$modversion ['paypal']['item_name'] = 'Donation : ' . _MI_TAD_WEB;
$modversion ['paypal']['amount'] = 0;
$modversion ['paypal']['currency_code'] = 'USD';




//---啟動後台管理界面選單---//
$modversion['system_menu'] = 1;//---資料表架構---//
$modversion['sqlfile']['mysql'] = "sql/mysql.sql";

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


//---區塊設定---//
$modversion['blocks'][1]['file'] = "tad_login.php";
$modversion['blocks'][1]['name'] = _MI_TADLOGIN_BNAME1;
$modversion['blocks'][1]['description'] = _MI_TADLOGIN_BDESC1;
$modversion['blocks'][1]['show_func'] = "tad_login";
$modversion['blocks'][1]['template'] = "tad_login.html";

$modversion['config'][0]['name']	= 'appId';
$modversion['config'][0]['title']	= '_MI_TADLOGIN_APPID';
$modversion['config'][0]['description']	= '_MI_TADLOGIN_APPID_DESC';
$modversion['config'][0]['formtype']	= 'textbox';
$modversion['config'][0]['valuetype']	= 'text';
$modversion['config'][0]['default']	= '189441632170';

$modversion['config'][1]['name']	= 'secret';
$modversion['config'][1]['title']	= '_MI_TADLOGIN_SECRET';
$modversion['config'][1]['description']	= '_MI_TADLOGIN_SECRET_DESC';
$modversion['config'][1]['formtype']	= 'textbox';
$modversion['config'][1]['valuetype']	= 'text';
$modversion['config'][1]['default']	= '7d7288d91aa7dfe90cc66a50f27289ba';

$modversion['config'][2]['name']  = 'auth_method';
$modversion['config'][2]['title'] = '_MI_TADLOGIN_AUTH_METHOD';
$modversion['config'][2]['description'] = '_MI_TADLOGIN_AUTH_METHOD_DESC';
$modversion['config'][2]['formtype']  = 'select_multi';
$modversion['config'][2]['valuetype'] = 'array';
$modversion['config'][2]['default'] = array('google','yahoo');
$modversion['config'][2]['options'] = array(_MI_TADLOGIN_CONF3_OPT1 => 'facebook',_MI_TADLOGIN_CONF3_OPT2 => 'google',_MI_TADLOGIN_CONF3_OPT3 => 'yahoo',_MI_TADLOGIN_CONF3_OPT4 => 'tn_openid');

?>
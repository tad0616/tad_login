<?php
require XOOPS_ROOT_PATH . '/modules/tad_login/oidc.php';

global $xoopsConfig;

$modversion = [];

//---模組基本資訊---//
$modversion['name'] = _MI_TADLOGIN_NAME;
$modversion['version'] = 4.8;
$modversion['description'] = _MI_TADLOGIN_DESC;
$modversion['author'] = _MI_TADLOGIN_AUTHOR;
$modversion['credits'] = _MI_TADLOGIN_CREDITS;
$modversion['help'] = 'page=help';
$modversion['license'] = 'GNU GPL 2.0';
$modversion['license_url'] = 'www.gnu.org/licenses/gpl-2.0.html/';
$modversion['image'] = "images/logo_{$xoopsConfig['language']}.png";
$modversion['dirname'] = basename(__DIR__);

//---模組狀態資訊---//
$modversion['release_date'] = '2020/11/10';
$modversion['module_website_url'] = 'https://tad0616.net/';
$modversion['module_website_name'] = _MI_TAD_WEB;
$modversion['module_status'] = 'release';
$modversion['author_website_url'] = 'https://tad0616.net/';
$modversion['author_website_name'] = _MI_TAD_WEB;
$modversion['min_php'] = 5.4;
$modversion['min_xoops'] = '2.5';
$modversion['min_tadtools'] = '2.08';

//---paypal資訊---//
$modversion['paypal'] = [];
$modversion['paypal']['business'] = 'tad0616@gmail.com';
$modversion['paypal']['item_name'] = 'Donation : ' . _MI_TAD_WEB;
$modversion['paypal']['amount'] = 0;
$modversion['paypal']['currency_code'] = 'USD';

//---安裝設定---//
$modversion['onInstall'] = 'include/onInstall.php';
$modversion['onUpdate'] = 'include/onUpdate.php';
$modversion['onUninstall'] = 'include/onUninstall.php';

//---啟動後台管理界面選單---//
$modversion['system_menu'] = 1; //---資料表架構---//
$modversion['sqlfile']['mysql'] = 'sql/mysql.sql';
$modversion['tables'][1] = 'tad_login_random_pass';
$modversion['tables'][2] = 'tad_login_config';

//---管理介面設定---//
$modversion['hasAdmin'] = 1;
$modversion['adminindex'] = 'admin/index.php';
$modversion['adminmenu'] = 'admin/menu.php';

//---使用者主選單設定---//
$modversion['hasMain'] = 1;

//---樣板設定---//
$modversion['templates'] = [];
$i = 1;
$modversion['templates'][$i]['file'] = 'tad_login_index.tpl';
$modversion['templates'][$i]['description'] = 'tad_login_index.tpl';

$i++;
$modversion['templates'][$i]['file'] = 'tad_login_admin.tpl';
$modversion['templates'][$i]['description'] = 'tad_login_admin.tpl';

//---區塊設定---//
$modversion['blocks'][1]['file'] = 'tad_login.php';
$modversion['blocks'][1]['name'] = _MI_TADLOGIN_BNAME1;
$modversion['blocks'][1]['description'] = _MI_TADLOGIN_BDESC1;
$modversion['blocks'][1]['show_func'] = 'tad_login';
$modversion['blocks'][1]['template'] = 'tad_login.tpl';
$modversion['blocks'][1]['edit_func'] = 'tad_login_edit';
$modversion['blocks'][1]['options'] = '1|1|0';

$i = 1;
$modversion['config'][$i]['name'] = 'appId';
$modversion['config'][$i]['title'] = '_MI_TADLOGIN_APPID';
$modversion['config'][$i]['description'] = '_MI_TADLOGIN_APPID_DESC';
$modversion['config'][$i]['formtype'] = 'textbox';
$modversion['config'][$i]['valuetype'] = 'text';
$modversion['config'][$i]['default'] = '';

$i++;
$modversion['config'][$i]['name'] = 'secret';
$modversion['config'][$i]['title'] = '_MI_TADLOGIN_SECRET';
$modversion['config'][$i]['description'] = '_MI_TADLOGIN_SECRET_DESC';
$modversion['config'][$i]['formtype'] = 'textbox';
$modversion['config'][$i]['valuetype'] = 'text';
$modversion['config'][$i]['default'] = '';

$i++;
$modversion['config'][$i]['name'] = 'google_appId';
$modversion['config'][$i]['title'] = '_MI_TADLOGIN_GOOGLE_APPID';
$modversion['config'][$i]['description'] = '_MI_TADLOGIN_GOOGLE_APPID_DESC';
$modversion['config'][$i]['formtype'] = 'textbox';
$modversion['config'][$i]['valuetype'] = 'text';
$modversion['config'][$i]['default'] = '';

$i++;
$modversion['config'][$i]['name'] = 'google_secret';
$modversion['config'][$i]['title'] = '_MI_TADLOGIN_GOOGLE_SECRET';
$modversion['config'][$i]['description'] = '_MI_TADLOGIN_GOOGLE_SECRET_DESC';
$modversion['config'][$i]['formtype'] = 'textbox';
$modversion['config'][$i]['valuetype'] = 'text';
$modversion['config'][$i]['default'] = '';

$i++;
$modversion['config'][$i]['name'] = 'google_api_key';
$modversion['config'][$i]['title'] = '_MI_TADLOGIN_GOOGLE_API_KEY';
$modversion['config'][$i]['description'] = '_MI_TADLOGIN_GOOGLE_API_KEY_DESC';
$modversion['config'][$i]['formtype'] = 'textbox';
$modversion['config'][$i]['valuetype'] = 'text';
$modversion['config'][$i]['default'] = '';

$i++;
$modversion['config'][$i]['name'] = 'auth_method';
$modversion['config'][$i]['title'] = '_MI_TADLOGIN_AUTH_METHOD';
$modversion['config'][$i]['description'] = '_MI_TADLOGIN_AUTH_METHOD_DESC';
$modversion['config'][$i]['formtype'] = 'select_multi';
$modversion['config'][$i]['valuetype'] = 'array';
$modversion['config'][$i]['default'] = ['tn'];
$modversion['config'][$i]['options'] = [
    sprintf(_TADLOGIN_LOGIN, _FACEBOOK) => 'facebook',
    sprintf(_TADLOGIN_LOGIN, _GOOGLE) => 'google',
    sprintf(_TADLOGIN_LOGIN, _YAHOO) => 'yahoo',
    sprintf(_TADLOGIN_LOGIN, _KL . 'OpenID') => 'kl',
    sprintf(_TADLOGIN_LOGIN, _TP . 'OpenID') => 'tp',
    sprintf(_TADLOGIN_LOGIN, _NTPC . 'OpenID') => 'ntpc',
    sprintf(_TADLOGIN_LOGIN, _TY . 'OpenID') => 'ty',
    // sprintf(_TADLOGIN_LOGIN, _HCC . 'OpenID') => 'hcc',
    sprintf(_TADLOGIN_LOGIN, _HC . 'OpenID') => 'hc',
    sprintf(_TADLOGIN_LOGIN, _MLC . 'OpenID') => 'mlc',
    sprintf(_TADLOGIN_LOGIN, _TC . 'OpenID') => 'tc',
    sprintf(_TADLOGIN_LOGIN, _CHC . 'OpenID') => 'chc',
    sprintf(_TADLOGIN_LOGIN, _NTCT . 'OpenID') => 'ntct',
    sprintf(_TADLOGIN_LOGIN, _YLC . 'OpenID') => 'ylc',
    sprintf(_TADLOGIN_LOGIN, _CYC . 'OpenID') => 'cyc',
    sprintf(_TADLOGIN_LOGIN, _CY . 'OpenID') => 'cy',
    sprintf(_TADLOGIN_LOGIN, _TN . 'OpenID') => 'tn',
    sprintf(_TADLOGIN_LOGIN, _KH . 'OpenID') => 'kh',
    sprintf(_TADLOGIN_LOGIN, _PTC . 'OpenID') => 'ptc',
    sprintf(_TADLOGIN_LOGIN, _ILC . 'OpenID') => 'ilc',
    sprintf(_TADLOGIN_LOGIN, _HLC . 'OpenID') => 'hlc',
    sprintf(_TADLOGIN_LOGIN, _TTCT . 'OpenID') => 'ttct',
    sprintf(_TADLOGIN_LOGIN, _PHC . 'OpenID') => 'phc',
    sprintf(_TADLOGIN_LOGIN, _KM . 'OpenID') => 'km',
    sprintf(_TADLOGIN_LOGIN, _MT . 'OpenID') => 'mt',
];
if (isset($all_oidc)) {
    foreach ($all_oidc as $oidc_unit => $oarr) {
        $const = constant('_' . strtoupper($oarr['tail']));
        $oidc_unit_const = sprintf(_TADLOGIN_LOGIN, $const . _TADLOGIN_OIDC);
        $modversion['config'][$i]['options'][$oidc_unit_const] = $oidc_unit;
    }
}
if (isset($all_oidc2)) {
    foreach ($all_oidc2 as $oidc_unit => $oarr) {
        $const = constant('_' . strtoupper($oarr['tail']));
        $oidc_unit_const = sprintf(_TADLOGIN_LOGIN, $const . _TADLOGIN_LDAP);
        $modversion['config'][$i]['options'][$oidc_unit_const] = $oidc_unit;
    }
}

$i++;
$modversion['config'][$i]['name'] = 'redirect_url';
$modversion['config'][$i]['title'] = '_MI_TADLOGIN_REDIRECT_URL';
$modversion['config'][$i]['description'] = '_MI_TADLOGIN_REDIRECT_URL_DESC';
$modversion['config'][$i]['formtype'] = 'textbox';
$modversion['config'][$i]['valuetype'] = 'text';
$modversion['config'][$i]['default'] = '';

$i++;
$modversion['config'][$i]['name'] = 'oidc_setup';
$modversion['config'][$i]['title'] = '_TADLOGIN_OIDC_SETUP';
$modversion['config'][$i]['description'] = '_TADLOGIN_OIDC_SETUP_DESC';
$modversion['config'][$i]['formtype'] = 'textarea';
$modversion['config'][$i]['valuetype'] = 'text';
$modversion['config'][$i]['default'] = '';

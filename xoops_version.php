<?php

use XoopsModules\Tad_login\Tools;

if (!class_exists('XoopsModules\Tad_login\Tools')) {
    require XOOPS_ROOT_PATH . '/modules/tad_login/preloads/autoloader.php';
}

$modversion = [];
global $xoopsConfig;

//---模組基本資訊---//
$modversion['name'] = _MI_TADLOGIN_NAME;
// $modversion['version'] = 5.8;
$modversion['version'] = $_SESSION['xoops_version'] >= 20511 ? '6.1.0-Stable' : '6.1';
$modversion['description'] = _MI_TADLOGIN_DESC;
$modversion['author'] = _MI_TADLOGIN_AUTHOR;
$modversion['credits'] = _MI_TADLOGIN_CREDITS;
$modversion['help'] = 'page=help';
$modversion['license'] = 'GNU GPL 2.0';
$modversion['license_url'] = 'www.gnu.org/licenses/gpl-2.0.html/';
$modversion['image'] = "images/logo_{$xoopsConfig['language']}.png";
$modversion['dirname'] = basename(__DIR__);

//---模組狀態資訊---//
$modversion['release_date'] = '2025-10-30';
$modversion['module_website_url'] = 'https://tad0616.net/';
$modversion['module_website_name'] = _MI_TAD_WEB;
$modversion['module_status'] = 'release';
$modversion['author_website_url'] = 'https://tad0616.net/';
$modversion['author_website_name'] = _MI_TAD_WEB;
$modversion['min_php'] = 7.3;
$modversion['min_xoops'] = '2.5.10';

//---paypal資訊---//
$modversion['paypal'] = [
    'business' => 'tad0616@gmail.com',
    'item_name' => 'Donation : ' . _MI_TAD_WEB,
    'amount' => 0,
    'currency_code' => 'USD',
];

//---安裝設定---//
$modversion['onInstall'] = 'include/onInstall.php';
$modversion['onUpdate'] = 'include/onUpdate.php';
$modversion['onUninstall'] = 'include/onUninstall.php';

//---啟動後台管理界面選單---//
$modversion['system_menu'] = 1; //---資料表架構---//
$modversion['sqlfile']['mysql'] = 'sql/mysql.sql';
$modversion['tables'] = ['tad_login_random_pass', 'tad_login_config'];

//---管理介面設定---//
$modversion['hasAdmin'] = 1;
$modversion['adminindex'] = 'admin/index.php';
$modversion['adminmenu'] = 'admin/menu.php';

//---使用者主選單設定---//
$modversion['hasMain'] = 1;

$modversion['templates'] = [
    ['file' => 'tad_login_index.tpl', 'description' => 'tad_login_index.tpl'],
    ['file' => 'tad_login_admin.tpl', 'description' => 'tad_login_admin.tpl'],
];

//---區塊設定 (索引為固定值，若欲刪除區塊記得補上索引，避免區塊重複)---//
$modversion['blocks'] = [
    1 => [
        'file' => 'tad_login.php',
        'name' => _MI_TADLOGIN_BNAME1,
        'description' => _MI_TADLOGIN_BDESC1,
        'show_func' => 'tad_login',
        'template' => 'tad_login.tpl',
        'edit_func' => 'tad_login_edit',
        'options' => '1|1|0',
    ],
];

$modversion['config'] = [
    [
        'name' => 'google_appId',
        'title' => '_MI_TADLOGIN_GOOGLE_APPID',
        'description' => '_MI_TADLOGIN_GOOGLE_APPID_DESC',
        'formtype' => 'textbox',
        'valuetype' => 'text',
        'default' => '',
    ],
    [
        'name' => 'google_secret',
        'title' => '_MI_TADLOGIN_GOOGLE_SECRET',
        'description' => '_MI_TADLOGIN_GOOGLE_SECRET_DESC',
        'formtype' => 'textbox',
        'valuetype' => 'text',
        'default' => '',
    ],
    [
        'name' => 'google_api_key',
        'title' => '_MI_TADLOGIN_GOOGLE_API_KEY',
        'description' => '_MI_TADLOGIN_GOOGLE_API_KEY_DESC',
        'formtype' => 'textbox',
        'valuetype' => 'text',
        'default' => '',
    ],
    [
        'name' => 'line_id',
        'title' => '_MI_TADLOGIN_LINE_ID',
        'description' => '_MI_TADLOGIN_LINE_SECRET_DESC',
        'formtype' => 'textbox',
        'valuetype' => 'text',
        'default' => '',
    ],
    [
        'name' => 'line_secret',
        'title' => '_MI_TADLOGIN_LINE_SECRET',
        'description' => '_MI_TADLOGIN_LINE_SECRET_DESC',
        'formtype' => 'textbox',
        'valuetype' => 'text',
        'default' => '',
    ],
    [
        'name' => 'auth_method',
        'title' => '_MI_TADLOGIN_AUTH_METHOD',
        'description' => '_MI_TADLOGIN_AUTH_METHOD_DESC',
        'formtype' => 'select_multi',
        'valuetype' => 'array',
        'default' => ['tn'],
        'options' => [
            sprintf(_TADLOGIN_LOGIN, _GOOGLE) => 'google',
            sprintf(_TADLOGIN_LOGIN, _LINE) => 'line',
            sprintf(_TADLOGIN_LOGIN, _KL . 'OpenID') => 'kl',
            sprintf(_TADLOGIN_LOGIN, _TP . 'OpenID') => 'tp',
            sprintf(_TADLOGIN_LOGIN, _NTPC . 'OpenID') => 'ntpc',
            sprintf(_TADLOGIN_LOGIN, _HC . 'OpenID') => 'hc',
            sprintf(_TADLOGIN_LOGIN, _MLC . 'OpenID') => 'mlc',
            sprintf(_TADLOGIN_LOGIN, _YLC . 'OpenID') => 'ylc',
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
        ],
    ],
    [
        'name' => 'bind_openid',
        'title' => '_MI_TADLOGIN_BIND_OPENID',
        'description' => '_MI_TADLOGIN_BIND_OPENID_DESC',
        'formtype' => 'yesno',
        'valuetype' => 'int',
        'default' => 0,
    ],
    [
        'name' => 'redirect_url',
        'title' => '_MI_TADLOGIN_REDIRECT_URL',
        'description' => '_MI_TADLOGIN_REDIRECT_URL_DESC',
        'formtype' => 'textbox',
        'valuetype' => 'text',
        'default' => '',
    ],
    [
        'name' => 'oidc_setup',
        'title' => '_TADLOGIN_OIDC_SETUP',
        'description' => '_TADLOGIN_OIDC_SETUP_DESC',
        'formtype' => 'textarea',
        'valuetype' => 'text',
        'default' => '',
    ],
];

if (isset(Tools::$all_oidc)) {
    foreach (Tools::$all_oidc as $oidc_unit => $oarr) {
        $const = constant('_' . strtoupper($oarr['tail']));
        $oidc_unit_const = sprintf(_TADLOGIN_LOGIN, $const . _TADLOGIN_OIDC);
        $modversion['config'][5]['options'][$oidc_unit_const] = $oidc_unit;
    }
}
if (isset(Tools::$all_oidc2)) {
    foreach (Tools::$all_oidc2 as $oidc_unit => $oarr) {
        $const = constant('_' . strtoupper($oarr['tail']));
        $oidc_unit_const = sprintf(_TADLOGIN_LOGIN, $const . _TADLOGIN_LDAP);
        $modversion['config'][5]['options'][$oidc_unit_const] = $oidc_unit;
    }
}

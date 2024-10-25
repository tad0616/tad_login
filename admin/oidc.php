<?php
use Xmf\Request;
use XoopsModules\Tadtools\FormValidator;
use XoopsModules\Tadtools\Utility;
use XoopsModules\Tad_login\Tools;
/*-----------引入檔案區--------------*/
$xoopsOption['template_main'] = 'tad_login_admin.tpl';
include_once 'header.php';
/*-----------執行動作判斷區----------*/
$op = Request::getString('op');
$config_id = Request::getInt('config_id');

switch ($op) {

    //替換資料
    case 'save_tad_login_edu_config':
        save_tad_login_edu_config();
        header("location: {$_SERVER['PHP_SELF']}");
        exit;

    //預設動作
    default:
        edu_login_config_form();
        $op = 'edu_login_config_form';
        break;
}

/*-----------秀出結果區--------------*/
$xoopsTpl->assign('now_op', $op);
require_once __DIR__ . '/footer.php';

/*-----------function區--------------*/

//tad_login_config編輯表單
function edu_login_config_form($config_id = '')
{
    global $xoopsModuleConfig, $xoopsTpl;

    $FormValidator = new FormValidator('#myForm', true);
    $FormValidator->render();

    $oidc_setup = json_decode($xoopsModuleConfig['oidc_setup'], true);
    $xoopsTpl->assign('oidc_setup', $oidc_setup);
    $all_oidc = $all_oidc2 = [];
    foreach (Tools::$all_oidc as $oidc_unit => $oarr) {
        $oidc_unit_const = constant('_' . strtoupper($oarr['tail'])) . _TADLOGIN_OIDC;
        $all_oidc[$oidc_unit] = $oarr;
        $all_oidc[$oidc_unit]['title'] = $oidc_unit_const;
    }

    foreach (Tools::$all_oidc2 as $oidc_unit => $oarr) {
        $oidc_unit_const = constant('_' . strtoupper($oarr['tail'])) . _TADLOGIN_LDAP;
        $all_oidc2[$oidc_unit] = $oarr;
        $all_oidc2[$oidc_unit]['title'] = $oidc_unit_const;
    }

    $xoopsTpl->assign('all_oidc', $all_oidc);
    $xoopsTpl->assign('all_oidc2', $all_oidc2);

}

//更新 oidc 偏好設定
function save_tad_login_edu_config()
{
    global $xoopsDB;

    $oidc = json_encode($_POST['oidc'], 256);

    $sql = 'UPDATE `' . $xoopsDB->prefix('config') . '`
    SET `conf_value` = ?
    WHERE `conf_name` = ? AND `conf_title` = ?';
    $params = [$oidc, 'oidc_setup', '_TADLOGIN_OIDC_SETUP'];

    Utility::query($sql, 'sss', $params) or Utility::web_error($sql, __FILE__, __LINE__);

}

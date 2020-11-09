<?php
use XoopsModules\Tadtools\FormValidator;
use XoopsModules\Tadtools\Utility;
/*-----------引入檔案區--------------*/
$xoopsOption['template_main'] = 'tad_login_admin.tpl';
include_once 'header.php';
include_once '../function.php';

/*-----------function區--------------*/

//tad_login_config編輯表單
function edu_login_config_form($config_id = '')
{
    global $xoopsModuleConfig, $xoopsTpl, $all_oidc, $all_oidc2;

    $FormValidator = new FormValidator('#myForm', true);
    $FormValidator->render();

    $oidc_setup = json_decode($xoopsModuleConfig['oidc_setup'], true);
    $xoopsTpl->assign('oidc_setup', $oidc_setup);

    require '../oidc.php';
    foreach ($all_oidc as $oidc_unit => $oarr) {
        $oidc_unit_const = constant('_' . strtoupper($oarr['tail'])) . _TADLOGIN_OIDC;
        $all_oidc[$oidc_unit]['title'] = $oidc_unit_const;
    }
    foreach ($all_oidc2 as $oidc_unit => $oarr) {
        $oidc_unit_const = constant('_' . strtoupper($oarr['tail'])) . _TADLOGIN_LDAP;
        $all_oidc2[$oidc_unit]['title'] = $oidc_unit_const;
    }

    $xoopsTpl->assign('all_oidc', $all_oidc);
    $xoopsTpl->assign('all_oidc2', $all_oidc2);
    $xoopsTpl->assign('next_op', $op);

}

//更新 oidc 偏好設定
function save_tad_login_edu_config()
{
    global $xoopsDB, $xoopsUser;

    $myts = \MyTextSanitizer::getInstance();
    $oidc = json_encode($_POST['oidc'], 256);
    $oidc = $myts->addSlashes($oidc);

    $sql = 'update `' . $xoopsDB->prefix('config') . "`
    set `conf_value`='{$oidc}'
    where `conf_name`='oidc_setup' and `conf_title`='_TADLOGIN_OIDC_SETUP'";
    $xoopsDB->query($sql) or Utility::web_error($sql, __FILE__, __LINE__);

}

/*-----------執行動作判斷區----------*/
include_once $GLOBALS['xoops']->path('/modules/system/include/functions.php');
$op = system_CleanVars($_REQUEST, 'op', '', 'string');
$config_id = system_CleanVars($_REQUEST, 'config_id', 0, 'int');

switch ($op) {
    /*---判斷動作請貼在下方---*/

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
include_once 'footer.php';

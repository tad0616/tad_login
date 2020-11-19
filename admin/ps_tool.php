<?php
use Xmf\Request;
use XoopsModules\Tadtools\Bootstrap3Editable;
use XoopsModules\Tadtools\Utility;
/*-----------引入檔案區--------------*/
$GLOBALS['xoopsOption']['template_main'] = 'tad_login_admin.tpl';
require_once __DIR__ . '/header.php';
require_once dirname(__DIR__) . '/function.php';
/*-----------function區--------------*/
function passwd_list()
{
    global $xoopsTpl, $xoopsDB, $xoopsModule;
    $xoopsTpl->assign('mid', $xoopsModule->mid());

    $sql = "SELECT count(*) FROM `" . $xoopsDB->prefix('tad_login_random_pass') . "` where hashed_date='0000-00-00 00:00:00' group by hashed_date";
    $result = $xoopsDB->query($sql) or Utility::web_error($sql, __FILE__, __LINE__);
    list($count) = $xoopsDB->fetchRow($result);
    $xoopsTpl->assign('count', $count);

    $sql = "select a.*, b.* FROM `" . $xoopsDB->prefix('tad_login_random_pass') . "` as a
    left join `" . $xoopsDB->prefix('users') . "` as b on a.uname=b.uname";

    $PageBar = Utility::getPageBar($sql, 50, 10);
    $sql = $PageBar['sql'];
    $bar = $PageBar['bar'];
    $total = $PageBar['total'];

    $xoopsTpl->assign('bar', $bar);
    $xoopsTpl->assign('total ', $total);

    $result = $xoopsDB->query($sql) or Utility::web_error($sql, __FILE__, __LINE__);
    $data = [];
    while (false !== ($all = $xoopsDB->fetchArray($result))) {
        // foreach ($all as $k => $v) {
        //     $$k = $v;
        // }
        $data[] = $all;
    }
    $xoopsTpl->assign('data', $data);

    $BootstrapEditable = new Bootstrap3Editable();
    $BootstrapEditableCode = $BootstrapEditable->render('.editable', XOOPS_URL . '/modules/tad_login/admin/ajax.php');
    $xoopsTpl->assign('BootstrapEditableCode', $BootstrapEditableCode);
    return $data;

}

function change_all_pass($passwd)
{
    global $xoopsTpl, $xoopsDB;

    $sql = "SELECT uname FROM `" . $xoopsDB->prefix('tad_login_random_pass') . "` where hashed_date='0000-00-00 00:00:00'";
    $result = $xoopsDB->query($sql) or Utility::web_error($sql, __FILE__, __LINE__);
    while (list($uname) = $xoopsDB->fetchRow($result)) {
        change_pass($passwd, $uname, false);
    }
}
/*-----------執行動作判斷區----------*/
$op = Request::getString('op');
$passwd = Request::getString('passwd');

switch ($op) {
    case 'change_all_pass':
        change_all_pass($passwd);
        header('location: ps_tool.php');
        exit;

    //預設動作
    default:
        passwd_list();
        $op = 'passwd_list';
        break;
}

/*-----------秀出結果區--------------*/
$xoopsTpl->assign('now_op', $op);
$xoTheme->addStylesheet(XOOPS_URL . "/modules/tadtools/css/xoops_adm{$_SESSION['bootstrap']}.css");
require_once __DIR__ . '/footer.php';

<?php
use Xmf\Request;
use XoopsModules\Tadtools\Bootstrap3Editable;
use XoopsModules\Tadtools\FormValidator;
use XoopsModules\Tadtools\Utility;
use XoopsModules\Tad_login\Tools;
/*-----------引入檔案區--------------*/
$GLOBALS['xoopsOption']['template_main'] = 'tad_login_admin.tpl';
require_once __DIR__ . '/header.php';
/*-----------執行動作判斷區----------*/
$op = Request::getString('op');
$passwd = Request::getString('passwd');
$keyword = Request::getString('keyword');

switch ($op) {
    case 'change_all_pass':
        change_all_pass($passwd);
        header('location: ps_tool.php');
        exit;

    //預設動作
    default:
        passwd_list($keyword);
        $op = 'passwd_list';
        break;
}

/*-----------秀出結果區--------------*/
$xoopsTpl->assign('now_op', $op);
require_once __DIR__ . '/footer.php';

/*-----------function區--------------*/
function passwd_list($keyword = '')
{
    global $xoopsTpl, $xoopsDB, $xoopsModule;
    $xoopsTpl->assign('mid', $xoopsModule->mid());

    $keyword = $xoopsDB->escape($keyword);
    $and_keyword = empty($keyword) ? '' : "AND b.`name` LIKE '%$keyword%' OR b.`uname` LIKE '%$keyword%' OR b.`email` LIKE '%$keyword%'";

    $sql = "SELECT count(*) FROM `" . $xoopsDB->prefix('tad_login_random_pass') . "`  AS a
    JOIN `" . $xoopsDB->prefix('users') . "` AS b ON a.uname=b.uname WHERE a.hashed_date='0000-00-00 00:00:00' $and_keyword GROUP BY a.hashed_date";
    $result = $xoopsDB->query($sql) or Utility::web_error($sql, __FILE__, __LINE__);
    list($count) = $xoopsDB->fetchRow($result);
    $xoopsTpl->assign('count', $count);

    $sql = "SELECT a.*, b.* FROM `" . $xoopsDB->prefix('tad_login_random_pass') . "` AS a
    JOIN `" . $xoopsDB->prefix('users') . "` AS b ON a.uname=b.uname WHERE 1 $and_keyword";

    $PageBar = Utility::getPageBar($sql, 50, 10);
    $sql = $PageBar['sql'];
    $bar = $PageBar['bar'];
    $total = $PageBar['total'];

    $xoopsTpl->assign('bar', $bar);
    $xoopsTpl->assign('total ', $total);

    $result = $xoopsDB->query($sql) or Utility::web_error($sql, __FILE__, __LINE__);
    $data = [];
    while (false !== ($all = $xoopsDB->fetchArray($result))) {
        $data[] = $all;

    }
    $xoopsTpl->assign('data', $data);
    $xoopsTpl->assign('keyword', $keyword);

    $BootstrapEditable = new Bootstrap3Editable();
    $BootstrapEditableCode = $BootstrapEditable->render('.editable', XOOPS_URL . '/modules/tad_login/admin/ajax.php');
    $xoopsTpl->assign('BootstrapEditableCode', $BootstrapEditableCode);

    $FormValidator = new FormValidator('#myForm', true);
    $FormValidator->render();

    return $data;

}

function change_all_pass($passwd)
{
    global $xoopsDB;

    $sql = 'SELECT `uname` FROM `' . $xoopsDB->prefix('tad_login_random_pass') . '` WHERE `hashed_date`=?';
    $result = Utility::query($sql, 's', ['0000-00-00 00:00:00']) or Utility::web_error($sql, __FILE__, __LINE__);

    while (list($uname) = $xoopsDB->fetchRow($result)) {
        Tools::change_pass($passwd, $uname, false);
    }
}

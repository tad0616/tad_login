<?php
use Xmf\Request;
use XoopsModules\Tadtools\FormValidator;
use XoopsModules\Tadtools\Utility;
/*-----------引入檔案區--------------*/
$GLOBALS['xoopsOption']['template_main'] = 'tad_login_admin.tpl';
require_once __DIR__ . '/header.php';
require_once dirname(__DIR__) . '/function.php';
/*-----------function區--------------*/
function user_list($keyword = '')
{
    global $xoopsTpl, $xoopsDB, $xoopsModule;
    $xoopsTpl->assign('mid', $xoopsModule->mid());

    $and_keyword = empty($keyword) ? '' : "and b.`name` = '$keyword'";

    $sql = "select a.*, b.* FROM `" . $xoopsDB->prefix('tad_login_random_pass') . "` as a
    join `" . $xoopsDB->prefix('users') . "` as b on a.uname=b.uname where 1 $and_keyword order by b.name, b.email, b.uid desc";

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

    $FormValidator = new FormValidator('#myForm', true);
    $FormValidator->render();

    return $data;

}

function change_uid($change_uid = [])
{
    global $xoopsDB;
    // Utility::dd($change_uid);
    list($uid1, $uid2) = $change_uid;
    // die("$uid1, $uid2");
    $sql = "SELECT max(uid) FROM `" . $xoopsDB->prefix('users') . "`";
    $result = $xoopsDB->query($sql) or Utility::web_error($sql, __FILE__, __LINE__);
    list($max_uid) = $xoopsDB->fetchRow($result);
    $max_uid = $max_uid + 100;

    $sql = "update `" . $xoopsDB->prefix('users') . "` set `uid`='$max_uid' where `uid`='$uid1'";
    $xoopsDB->queryF($sql) or Utility::web_error($sql, __FILE__, __LINE__);

    $sql = "update `" . $xoopsDB->prefix('users') . "` set `uid`='$uid1' where `uid`='$uid2'";
    $xoopsDB->queryF($sql) or Utility::web_error($sql, __FILE__, __LINE__);

    $sql = "update `" . $xoopsDB->prefix('users') . "` set `uid`='$uid2' where `uid`='$max_uid'";
    $xoopsDB->queryF($sql) or Utility::web_error($sql, __FILE__, __LINE__);

    $sql = "SELECT `uid`, `uname` FROM `" . $xoopsDB->prefix('users') . "` where `uid`='$uid1'";
    $result = $xoopsDB->query($sql) or Utility::web_error($sql, __FILE__, __LINE__);
    list($uidA, $unameA) = $xoopsDB->fetchRow($result);
    $sql = "SELECT `uid`, `uname` FROM `" . $xoopsDB->prefix('users') . "` where `uid`='$uid2'";
    $result = $xoopsDB->query($sql) or Utility::web_error($sql, __FILE__, __LINE__);
    list($uidB, $unameB) = $xoopsDB->fetchRow($result);

    redirect_header($_SERVER['PHP_SELF'], 3, sprintf(_MA_TADLOGIN_CHANGE_OK, $unameA, $uidA, $unameB, $uidB));
}
/*-----------執行動作判斷區----------*/
$op = Request::getString('op');
$change_uid = Request::getArray('change_uid');
$keyword = Request::getString('keyword');

switch ($op) {
    case 'change_uid':
        change_uid($change_uid);
        // header('location: change_uid.php');
        break;

    //預設動作
    default:
        user_list($keyword);
        $op = 'change_uid_form';
        break;
}

/*-----------秀出結果區--------------*/
$xoopsTpl->assign('now_op', $op);
$xoTheme->addStylesheet(XOOPS_URL . "/modules/tadtools/css/xoops_adm{$_SESSION['bootstrap']}.css");
require_once __DIR__ . '/footer.php';

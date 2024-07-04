<?php
use Xmf\Request;
/*-----------引入檔案區--------------*/
$GLOBALS['xoopsOption']['template_main'] = 'tad_login_admin.tpl';
require_once __DIR__ . '/header.php';
require_once dirname(__DIR__) . '/function.php';
/*-----------function區--------------*/

/*-----------執行動作判斷區----------*/
$op = Request::getString('op');

switch ($op) {
    //預設動作
    default:
        $op = 'fb';
        break;
}

/*-----------秀出結果區--------------*/
$xoopsTpl->assign('now_op', $op);
require_once __DIR__ . '/footer.php';

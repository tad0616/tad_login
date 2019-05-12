<?php

use XoopsModules\Tadtools\Utility;

function xoops_module_uninstall_tad_login(&$module)
{
    global $xoopsDB;
    $date = date('Ymd');

    rename(XOOPS_ROOT_PATH . '/uploads/tad_login', XOOPS_ROOT_PATH . "/uploads/tad_login_bak_{$date}");

    return true;
}

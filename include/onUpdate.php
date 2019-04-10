<?php

use XoopsModules\Tad_login\Utility;

function xoops_module_update_tad_login(&$module, $old_version)
{
    global $xoopsDB;

    if (!Utility::chk_chk1()) {
        Utility::go_update1();
    }
    if (!Utility::chk_chk2()) {
        Utility::go_update2();
    }
    if (!Utility::chk_chk3()) {
        Utility::go_update3();
    }

    return true;
}

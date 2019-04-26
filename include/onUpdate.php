<?php

use XoopsModules\Tad_login\Update;

function xoops_module_update_tad_login()
{

    Update::fix_kh();
    Update::fix_ty();

    if (!Update::chk_chk1()) {
        Update::go_update1();
    }
    if (!Update::chk_chk2()) {
        Update::go_update2();
    }
    if (!Update::chk_chk3()) {
        Update::go_update3();
    }

    return true;
}

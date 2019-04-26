<?php
use XoopsModules\Tadtools\Utility;

include dirname(__DIR__) . '/preloads/autoloader.php';

function xoops_module_install_tad_login(&$module)
{

    Utility::mk_dir(XOOPS_ROOT_PATH . "/uploads/tad_login");

    return true;
}

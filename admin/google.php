<?php
/*-----------引入檔案區--------------*/
$xoopsOption['template_main'] = "tad_login_adm_google.tpl";
include_once "header.php";
include_once "../function.php";

/*-----------function區--------------*/

/*-----------執行動作判斷區----------*/
include_once $GLOBALS['xoops']->path('/modules/system/include/functions.php');
$op = system_CleanVars($_REQUEST, 'op', '', 'string');

switch ($op) {
    //預設動作
    default:
        break;
}

/*-----------秀出結果區--------------*/
include_once 'footer.php';

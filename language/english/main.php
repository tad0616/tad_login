<?php
xoops_loadLanguage('main', 'tadtools');
require_once __DIR__ . '/county.php';
// Need to add modules Languages
if (!defined('_TAD_NEED_TADTOOLS')) {
    define('_TAD_NEED_TADTOOLS', 'This module needs TadTools module. You can download TadTools from <a href="https://campus-xoops.tn.edu.tw/modules/tad_modules/index.php?module_sn=1" target="_blank">XOOPS EasyGO</a>.');
}
define('_MD_TADLOGIN_CNRNU', 'XOOPS users Build fail!');
define('_MD_TADLOGIN_USE', 'Use');
define('_MD_TADLOGIN_LOGIN', 'Login');
define('_MD_TADLOGIN_TEACHER', 'teacher');
define('_MD_TADLOGIN_STUDENT', 'student');
define('_MD_TADLOGIN_UNAME_TOO_LONG', 'Account  %s exceeds %s words and cannot be created');

<?php
$adminmenu = [];
$icon_dir = '2.6' === mb_substr(XOOPS_VERSION, 6, 3) ? '' : 'images/';

$i = 1;
$adminmenu[$i]['title'] = _MI_TAD_ADMIN_HOME;
$adminmenu[$i]['link'] = 'admin/index.php';
$adminmenu[$i]['desc'] = _MI_TAD_ADMIN_HOME_DESC;
$adminmenu[$i]['icon'] = 'images/admin/home.png';

$i++;
$adminmenu[$i]['title'] = _MI_TADLOGIN_ADMENU2;
$adminmenu[$i]['link'] = 'admin/main.php';
$adminmenu[$i]['desc'] = _MI_TADLOGIN_ADMENU2;
$adminmenu[$i]['icon'] = 'images/admin/main.png';

$i++;
$adminmenu[$i]['title'] = _MI_TADLOGIN_ADMENU4;
$adminmenu[$i]['link'] = 'admin/oidc.php';
$adminmenu[$i]['desc'] = _MI_TADLOGIN_ADMENU4;
$adminmenu[$i]['icon'] = 'images/admin/oidc.png';

$i++;
$adminmenu[$i]['title'] = _MI_TADLOGIN_ADMENU5;
$adminmenu[$i]['link'] = 'admin/ps_tool.php';
$adminmenu[$i]['desc'] = _MI_TADLOGIN_ADMENU5;
$adminmenu[$i]['icon'] = 'images/admin/ps_tool.png';

$i++;
$adminmenu[$i]['title'] = _MI_TADLOGIN_ADMENU7;
$adminmenu[$i]['link'] = 'admin/change_uid.php';
$adminmenu[$i]['desc'] = _MI_TADLOGIN_ADMENU7;
$adminmenu[$i]['icon'] = 'images/admin/change_uid.png';

$i++;
$adminmenu[$i]['title'] = _MI_TADLOGIN_ADMENU1;
$adminmenu[$i]['link'] = 'admin/fb.php';
$adminmenu[$i]['desc'] = _MI_TADLOGIN_ADMENU1;
$adminmenu[$i]['icon'] = 'images/facebook.png';

$i++;
$adminmenu[$i]['title'] = _MI_TADLOGIN_ADMENU3;
$adminmenu[$i]['link'] = 'admin/google.php';
$adminmenu[$i]['desc'] = _MI_TADLOGIN_ADMENU3;
$adminmenu[$i]['icon'] = 'images/google.png';

$i++;
$adminmenu[$i]['title'] = _MI_TADLOGIN_ADMENU6;
$adminmenu[$i]['link'] = 'admin/line.php';
$adminmenu[$i]['desc'] = _MI_TADLOGIN_ADMENU6;
$adminmenu[$i]['icon'] = 'images/line.png';

$i++;
$adminmenu[$i]['title'] = _MI_TAD_ADMIN_ABOUT;
$adminmenu[$i]['link'] = 'admin/about.php';
$adminmenu[$i]['desc'] = _MI_TAD_ADMIN_ABOUT_DESC;
$adminmenu[$i]['icon'] = 'images/admin/about.png';

<?php
use Xmf\Request;
use XoopsModules\Tadtools\FormValidator;
use XoopsModules\Tadtools\Utility;
use XoopsModules\Tad_login\Tools;
/*-----------引入檔案區--------------*/
require __DIR__ . '/header.php';
$GLOBALS['xoopsOption']['template_main'] = 'tad_login_index.tpl';
require_once XOOPS_ROOT_PATH . '/header.php';

if (!class_exists('XoopsModules\Tad_login\Tools')) {
    require XOOPS_ROOT_PATH . '/modules/tad_login/preloads/autoloader.php';
}
if (!class_exists('XoopsModules\Tadtools\Utility')) {
    require XOOPS_ROOT_PATH . '/modules/tadtools/preloads/autoloader.php';
}

/*-----------執行動作判斷區----------*/
$op      = Request::getString('op');
$link_to = Request::getString('link_to');
$newpass = Request::getString('newpass');

$oidc_array = array_keys(Tools::$all_oidc);

if (isset($link_to) and !empty($link_to)) {
    $_SESSION['login_from'] = $link_to;
} elseif (!isset($_SESSION['login_from'])) {
    $_SESSION['login_from'] = $_SERVER['HTTP_REFERER'];
}

switch ($op) {
    case 'change_pass':
        Tools::change_pass($newpass);
        break;

    case 'google':
        $_SESSION['auth_method'] = 'google';
        Tools::google_login();
        break;
    case 'line':
        $_SESSION['auth_method'] = 'line';
        Tools::line_login();
        break;

    case 'tn':
        $_SESSION['auth_method'] = 'tn';
        tainan_login();
        break;
    case 'ylc':
        $_SESSION['auth_method'] = 'ylc';
        tc_login('ylc', 'http://openid.ylc.edu.tw/');
        break;
    case 'hc':
        $_SESSION['auth_method'] = 'hc';
        hc_login();
        break;
    case 'mlc':
        $_SESSION['auth_method'] = 'mlc';
        tc_login('mlc', 'https://openid2.mlc.edu.tw');
        break;
    case 'cy':
        $_SESSION['auth_method'] = 'cy';
        tc_login('cy', 'https://openid.cy.edu.tw');
        break;
    case 'ptc':
        $_SESSION['auth_method'] = 'ptc';
        tc_login('ptc', 'http://openid.ptc.edu.tw');
        break;
    case 'hlc':
        $_SESSION['auth_method'] = 'hlc';
        tc_login('hlc', 'http://openid2.hlc.edu.tw');

        break;
    // case 'tp':
    //     $_SESSION['auth_method'] = 'tp';
    //     tp_login();
    //     break;
    case 'ttct':
        $_SESSION['auth_method'] = 'ttct';
        hlc_login('ttct', 'https://openid.boe.ttct.edu.tw');
        break;
    case 'ntpc':
        $_SESSION['auth_method'] = 'ntpc';
        hlc_login('ntpc', 'https://openid.ntpc.edu.tw');
        break;
    case 'phc':
        $_SESSION['auth_method'] = 'phc';
        tc_login('phc', 'https://openid.phc.edu.tw');
        break;
    case 'kl':
        $_SESSION['auth_method'] = 'kl';
        kl_login();
        break;
    case 'ilc':
        $_SESSION['auth_method'] = 'ilc';
        ilc_login();
        break;
    case 'kh':
        $_SESSION['auth_method'] = 'kh';
        kh_login();
        break;
    case 'km':
        $_SESSION['auth_method'] = 'km';
        km_login();
        break;
    case 'mt':
        $_SESSION['auth_method'] = 'mt';
        mt_login();
        break;
    case 'tp_ldap':
        $_SESSION['auth_method'] = 'tp_ldap';
        tp_ldap_login();
        break;
    // case 'cyc':
    //     $_SESSION['auth_method'] = 'cyc';
    //     tc_login('cyc', 'https://openid.cyccc.tw');
    //     break;
    // case 'hcc':
    //     $_SESSION['auth_method'] = 'hcc';
    //     tc_login('hcc', 'https://openid.hcc.edu.tw');
    //     break;
    // case 'chc':
    //     $_SESSION['auth_method'] = 'chc';
    //     tc_login('chc', 'https://openid.chc.edu.tw');
    //     break;
    // case 'ntct':
    //     $_SESSION['auth_method'] = 'ntct';
    //     tc_login('ntct', 'https://openid.ntct.edu.tw');
    //     break;
    // case 'tc':
    //     $_SESSION['auth_method'] = 'tc';
    //     tc_login('tc', 'https://openid.tc.edu.tw');
    //     break;
    // case 'ty':
    //     $_SESSION['auth_method'] = 'ty';
    //     ty_login();
    //     break;
    default:
        if ($xoopsUser) {
            change_pass_form();
            $op = 'change_pass_form';
        } else {

            if (in_array($op, $oidc_array)) {
                $_SESSION['auth_method'] = $op;
                Tools::edu_login($op);
            } else {
                list_login();
                $op = 'list_login';
            }
        }
        break;
}

$xoopsTpl->assign('toolbar', Utility::toolbar_bootstrap($interface_menu, false, $interface_icon));
$xoopsTpl->assign('now_op', $op);
require_once XOOPS_ROOT_PATH . '/footer.php';

/*-----------function區--------------*/

//台南 OpenID 登入
function tainan_login()
{
    global $xoopsTpl, $xoopsUser;

    if ($xoopsUser) {
        header('location:' . XOOPS_URL . '/user.php');
        exit;
    }

    require_once __DIR__ . '/class/openid12.php';

    try {
        # Change 'localhost' to your domain name.
        $openid = new LightOpenID(XOOPS_URL);
        if (!$openid->mode) {
            $openid->identity = 'https://openid.tn.edu.tw/op/';
            $openid->required = ['contact/email', 'namePerson'];
            $openid->optional = ['/axschema/school/id', '/axschema/school/titleStr', 'tw/person/titles'];
            header('Location: ' . $openid->authUrl());
        } else {
            $user_profile = $openid->getAttributes();
            // Utility::dd($user_profile);
            /*
            array (
            '/axschema/person/guid' => '14684bd6fd05480979e9991f498272c489238XXXb750dd6e79864d470',
            '/axschema/school/titleStr' => '[{"id":"114620","title":["教師"]}]',
            '/axschema/school/id' => '114620',
            'tw/person/guid' => '14684bd6fd05480979e9991f498272c48923880668fdXXX79864d470',
            'tw/person/titles' => '{"sid":"114620","titles":["教師"]}',
            'tw/school/id' => '114620',
            'contact/email' => 'tad@XX.edu.tw',
            'namePerson' => '吳XX',
            )

            array (
            'du.tw/school/classStr' => '[{sid:\'213303\',schoolType:\'\',DN:\'\',groupId:\'\',degree:\'\',subjectId:\'\',subject:\'\',gradeId:\'3\',classId:\'6\',classTitle:\'3年6班\',title:\'學生\'}]',
            '/axschema/person/guid' => '89e516466fc16d76ef5e133aceb8e25f27ead82937d0689a5ae4f99fbf48dc29',
            '/axschema/school/titleStr' => '[{"id":"st1020170","title":["學生"]}]',
            '/axschema/school/id' => '213303',
            'tw/person/guid' => '89e516466fc16d76ef5e133aceb8e25f27ead82937d0689a5ae4f99fbf48dc29',
            'tw/person/titles' => '{"sid":"st1020170","titles":["學生"]}',
            'tw/school/id' => '213303',
            'contact/email' => 'st1020170@cloud.tn.edu.tw',
            'namePerson' => '林xx',
            )
             */

            // Login or logout url will be needed depending on current user state.
            // die(var_dump($user_profile));

            if ($user_profile) {
                $myts = \MyTextSanitizer::getInstance();

                $user_profile['contact/email'] = trim($user_profile['contact/email']);
                $the_id                        = explode('@', $user_profile['contact/email']);

                //$uid = $user['id'];
                $uname      = $the_id[0] . '_tn';
                $name       = $myts->addSlashes($user_profile['namePerson']);
                $email      = mb_strtolower($user_profile['contact/email']);
                $SchoolCode = $myts->addSlashes($user_profile['tw/school/id']);
                $JobName    = false !== mb_strpos($user_profile['contact/email'], '@cloud.tn.edu.tw') ? 'student' : 'teacher';

                if ($JobName == 'student') {
                    if ($user_profile['du.tw/school/classStr']) {
                        $classStr    = mb_substr($user_profile['du.tw/school/classStr'], 2, -2);
                        $classStr    = str_replace('\\', '', $classStr);
                        $classStrArr = explode(',', $classStr);
                        $StuArr      = [];
                        foreach ($classStrArr as $Arr) {
                            list($k, $v) = explode(':', $Arr);
                            $StuArr[$k]  = str_replace('\'', '', $v);
                        }
                        $from = $myts->addSlashes($StuArr['gradeId']);
                        $sig  = $myts->addSlashes($StuArr['classId']);
                        $msnm = '';
                    } else {
                        $from = $myts->addSlashes($user_profile['.tw/axschema/grade']);
                        $sig  = $user_profile['.tw/axschema/class'];
                        $msnm = $myts->addSlashes($user_profile['.tw/axschema/seat']);
                    }
                } else {
                    $from = '臺南市';
                }

                Tools::login_xoops($uname, $name, $email, $SchoolCode, $JobName, $url, $from, $sig, $occ, $bio, $aim, $yim, $msnm);
            }
        }
    } catch (ErrorException $e) {
        $main = $e->getMessage();
    }

    $xoopsTpl->assign('openid', $main);
}

//台北 OpenID 登入
function tp_login()
{
    global $xoopsTpl, $xoopsUser;

    if ($xoopsUser) {
        header('location:' . XOOPS_URL . '/user.php');
        exit;
    }

    require_once __DIR__ . '/class/openid12.php';

    try {
        # Change 'localhost' to your domain name.
        $openid = new LightOpenID(XOOPS_URL);

        if (!$openid->mode) {
            //     $openid->identity = "https://ldap.tp.edu.tw/openid/op.action";
            $openid->identity = 'https://openid.tp.edu.tw/openid/op.action';
            $openid->required = ['contact/email', 'namePerson/friendly', 'namePerson'];
            $openid->optional = ['axschema/person/accountType', 'axschema/school/titleStr', 'axschema/school/id'];
            header('Location: ' . $openid->authUrl());
        } else {
            $user_profile = $openid->getAttributes();
            // die(var_export($user_profile));

            // Login or logout url will be needed depending on current user state.
            //die(var_dump($user_profile));
            if ($user_profile) {
                $myts = \MyTextSanitizer::getInstance();

                $user_profile['contact/email'] = trim($user_profile['contact/email']);
                $the_id                        = explode('@', $user_profile['contact/email']);

                //$uid = $user['id'];
                $uname      = $the_id[0] . '_tp';
                $name       = $myts->addSlashes($user_profile['namePerson']);
                $email      = mb_strtolower($user_profile['contact/email']);
                $SchoolCode = $myts->addSlashes($user_profile['.tw/axschema/EduSchoolID']);
                $JobName    = '學生' === $user_profile['.tw/axschema/JobName'] ? 'student' : 'teacher';

                //搜尋有無相同username資料
                Tools::login_xoops($uname, $name, $email, $SchoolCode, $JobName, '', '臺北市');
            }
        }
    } catch (ErrorException $e) {
        $main = $e->getMessage();
    }

    $xoopsTpl->assign('openid', $main);
}

//基隆市 OpenID 登入
function kl_login()
{
    global $xoopsModuleConfig, $xoopsConfig, $xoopsDB, $xoopsTpl, $xoopsUser;

    if ($xoopsUser) {
        header('location:' . XOOPS_URL . '/user.php');
        exit;
    }

    require_once __DIR__ . '/class/openid_kl.php';

    try {
        # Change 'localhost' to your domain name.
        $openid = new LightOpenID(XOOPS_URL);

        if (!$openid->mode) {
            $openid->identity = 'https://openid.kl.edu.tw';
            $openid->required = ['contact/email', 'namePerson/friendly', 'namePerson'];
            $openid->optional = ['axschema/person/guid', 'axschema/school/titleStr', 'axschema/school/id', 'tw/person/guid', 'tw/isas/roles'];
            header('Location: ' . $openid->authUrl());
        } else {
            $user_profile = $openid->getAttributes();
            //die(var_export($user_profile));
            // Login or logout url will be needed depending on current user state.
            /*
            array (
            'contact/email' => 'tad0616@gmail.com',
            'namePerson/friendly' => 'tad',
            'namePerson' => '吳弘凱',
            'axschema/school/titleStr' => '{sid:"173637",title:["教師"]}',
            'axschema/school/id' => '173637',
            )
             */
            if ($user_profile) {
                $myts = \MyTextSanitizer::getInstance();

                $user_profile['contact/email'] = trim($user_profile['contact/email']);
                $the_id                        = explode('@', $user_profile['contact/email']);

                //$uid = $user['id'];
                $uname      = $the_id[0] . '_kl';
                $name       = $myts->addSlashes($user_profile['namePerson']);
                $email      = mb_strtolower($user_profile['contact/email']);
                $SchoolCode = $myts->addSlashes($user_profile['axschema/school/id']);
                $JobName    = (false !== mb_strpos($user_profile['axschema/school/titleStr'], '學生')) ? 'student' : 'teacher';

                //搜尋有無相同username資料
                Tools::login_xoops($uname, $name, $email, $SchoolCode, $JobName, '', '基隆市');
            }
        }
    } catch (ErrorException $e) {
        $main = $e->getMessage();
    }

    $xoopsTpl->assign('openid', $main);
}

//宜蘭縣 OpenID 登入
function ilc_login()
{
    global $xoopsModuleConfig, $xoopsConfig, $xoopsDB, $xoopsTpl, $xoopsUser;

    if ($xoopsUser) {
        header('location:' . XOOPS_URL . '/user.php');
        exit;
    }

    require_once __DIR__ . '/class/openid.php';

    try {
        # Change 'localhost' to your domain name.
        $openid = new LightOpenID(XOOPS_URL);
        if (!$openid->mode) {
            $openid->identity = 'https://openid.ilc.edu.tw';
            $openid->required = ['contact/email', 'namePerson/friendly', 'namePerson'];
            //$openid->optional = array('contact/postalCode/home' , 'contact/country/home'  , 'pref/language','pref/timezone','axschema/person/guid' , 'axschema/school/titleStr'  , 'axschema/school/id','tw/person/guid' , 'tw/isas/roles'  );
            header('Location: ' . $openid->authUrl());
        } else {
            $user_profile = $openid->getAttributes();
            // die(var_export($user_profile));
            // Login or logout url will be needed depending on current user state.
            /*
            array (
            'contact/email' => 'tad0616@gmail.com',
            'namePerson/friendly' => 'tad',
            'namePerson' => '吳弘凱',
            'axschema/school/titleStr' => '{sid:"173637",title:["教師"]}',
            'axschema/school/id' => '173637',
            )
             */
            if ($user_profile) {
                $myts = \MyTextSanitizer::getInstance();

                $user_profile['contact/email'] = trim($user_profile['contact/email']);
                $the_id                        = explode('@', $user_profile['contact/email']);

                //$uid = $user['id'];
                $uname      = $the_id[0] . '_ilc';
                $name       = $myts->addSlashes($user_profile['namePerson']);
                $email      = mb_strtolower($user_profile['contact/email']);
                $SchoolCode = $myts->addSlashes($user_profile['axschema/school/id']);

                $JobName = (false !== mb_strpos($user_profile['axschema/school/titleStr'], '學生')) ? 'student' : 'teacher';

                //搜尋有無相同username資料
                Tools::login_xoops($uname, $name, $email, $SchoolCode, $JobName, '', '宜蘭縣');
            }
        }
    } catch (ErrorException $e) {
        $main = $e->getMessage();
    }

    $xoopsTpl->assign('openid', $main);
}

//新竹市 OpenID 登入
function hc_login()
{
    global $xoopsModuleConfig, $xoopsConfig, $xoopsDB, $xoopsTpl, $xoopsUser;

    if ($xoopsUser) {
        header('location:' . XOOPS_URL . '/user.php');
        exit;
    }

    require_once __DIR__ . '/class/openid.php';

    try {
        # Change 'localhost' to your domain name.
        $openid = new LightOpenID(XOOPS_URL);
        if (!$openid->mode) {
            $openid->identity = 'https://openid.hc.edu.tw';
            $openid->required = ['contact/email', 'namePerson/friendly', 'namePerson'];
            $openid->optional = ['contact/postalCode/home', 'contact/country/home', 'pref/language', 'pref/timezone'];
            header('Location: ' . $openid->authUrl());
        } else {
            $user_profile = $openid->getAttributes();
            // die(var_export($user_profile));
            // Login or logout url will be needed depending on current user state.
            /*
            array (
            'namePerson/friendly' => '楊--',
            'contact/email' => 's---@ms.hc.edu.tw',
            'namePerson' => '楊---',
            'birthDate' => '0001-01-01',
            'person/gender' => 'M',
            'contact/postalCode/home' => 'FA9A43A598D47034C15CDD7400B6D830F01904937C7A33BB68D909313DE48D4B',
            'contact/country/home' => '183---',
            'pref/language' => 'C980ED219C4EF2DE90474FF136D50C64',
            'pref/timezone' => '單位管理員',
            )
             */
            if ($user_profile) {
                $myts                          = \MyTextSanitizer::getInstance();
                $user_profile['contact/email'] = trim($user_profile['contact/email']);
                $the_id                        = explode('@', $user_profile['contact/email']);

                //$uid = $user['id'];
                $uname      = $the_id[0] . '_hc';
                $name       = $myts->addSlashes($user_profile['namePerson']);
                $email      = mb_strtolower($user_profile['contact/email']);
                $SchoolCode = $myts->addSlashes($user_profile['contact/country/home']);

                $JobName = (false !== mb_strpos($user_profile['pref/timezone'], '學生')) ? 'student' : 'teacher';

                //搜尋有無相同username資料
                Tools::login_xoops($uname, $name, $email, $SchoolCode, $JobName, '', '新竹市');
            }
        }
    } catch (ErrorException $e) {
        $main = $e->getMessage();
    }

    $xoopsTpl->assign('openid', $main);
}

//花蓮縣登入
function hlc_login($county = '', $openid_identity = '')
{
    global $xoopsTpl, $xoopsUser;

    if ($xoopsUser) {
        header('location:' . XOOPS_URL . '/user.php');
        exit;
    }
    require_once __DIR__ . '/class/openid.php';

    try {
        # Change 'localhost' to your domain name.
        $openid = new LightOpenID(XOOPS_URL);

        if (!$openid->mode) {
            if (isset($_GET['login'])) {
                $openid->identity = $openid_identity;
                $openid->required = ['contact/email', 'namePerson/friendly', 'namePerson'];
                $openid->optional = ['contact/country/home', 'pref/timezone'];
                header('Location: ' . $openid->authUrl());
            } else {
                die('查無 $openid->mode');
            }
        } else {
            /*
            array (
            'namePerson/friendly' => '謝xx',
            'contact/email' => 'xxx@hlc.edu.tw',
            'namePerson' => '謝xx',
            'birthDate' => '0001-01-01',
            'person/gender' => 'M',
            'contact/postalCode/home' => '05BD53048B408CED4C72A2BBA6596551AB5E9D57F6C59BA4901FC789127983C8',
            'contact/country/home' => '154621',
            'pref/language' => '000000',
            'pref/timezone' => '教師',
            )

            array (
            'namePerson/friendly' => '林xx',
            'contact/email' => 'xxx@ntpc.edu.tw',
            'namePerson' => '林xx',
            'birthDate' => '19xx-xx-14',
            'person/gender' => 'M',
            'contact/postalCode/home' => '5EE2EFC0E0722348C2B47AA5461F60FE69F811651068288F6F7F264BAF4620DA',
            'contact/country/home' => 'xx國中',
            'pref/language' => '000000',
            'pref/timezone' => '[{"id":"014569","name":"新北市立xx國民中學","role":"教師","title":"專任教師","groups":["科任教師"]}]',
            )

            //ty
            array (
            'contact/country/home' => '034521',
            'contact/email' => 'xxx@yahoo.com.tw',
            'namePerson' => '葉xx',
            'namePerson/friendly' => '葉xx',
            'pref/timezone' => '[{"id":"034521","title":["\\u5b78\\u6821\\u7ba1\\u7406\\u8005","\\u6559\\u5e2b","\\u8077\\u54e1"]}]',
            )

            //ttct
            array (
            'contact/country/home' => '1446xx',
            'contact/email' => 'popxx@dove.ttct.edu.tw',
            'namePerson' => '曾xx',
            'namePerson/friendly' => 'popxx',
            'pref/timezone' => '{"sid":"1446xx","title":["教師","學校管理者"]}',
            )
             */
            $user_profile = $openid->getAttributes();
            // Utility::dd($user_profile);
            // die(var_export($user_profile));
            if ($user_profile) {
                $myts = \MyTextSanitizer::getInstance();

                $user_profile['contact/email'] = trim($user_profile['contact/email']);
                $the_id                        = explode('@', $user_profile['contact/email']);

                //$uid = $user['id'];
                $uname = $the_id[0] . '_' . $county;
                $name  = $myts->addSlashes($user_profile['namePerson']);
                $email = mb_strtolower($user_profile['contact/email']);
                if ('ntpc' === $county) {
                    $arr = json_decode($user_profile['pref/timezone'], true);
                    //die(var_export($arr));
                    /*
                    array (
                    0 =>
                    array (
                    'id' => '014569',
                    'name' => '新北市立xx國民中學',
                    'role' => '教師',
                    'title' => '專任教師',
                    'groups' =>
                    array (
                    0 => '科任教師',
                    ),
                    ),
                    )
                     */
                    $SchoolCode = $arr[0]['id'];

                    $JobName = (false !== mb_strpos($arr[0]['role'], '學生')) ? 'student' : 'teacher';

                    // } elseif ($county == "ty") {
                    //     $SchoolCode = $myts->addSlashes($user_profile['contact/country/home']);
                    //     $arr        = json_decode($user_profile['pref/timezone'], true);
                    //die(var_export($arr));
                    // array (
                    //   0 =>
                    //   array (
                    //     'id' => '034521',
                    //     'title' =>
                    //     array (
                    //       0 => '學校管理者',
                    //       1 => '教師',
                    //       2 => '職員',
                    //     ),
                    //   ),
                    // )

                    // $JobName = (strpos($arr[0]['title'], "學生") !== false) ? "student" : "teacher";
                } else {
                    $SchoolCode = $myts->addSlashes($user_profile['contact/country/home']);

                    $JobName = (false !== mb_strpos($user_profile['pref/timezone'], '學生')) ? 'student' : 'teacher';
                }

                if ($county == 'ttct') {
                    $from = '臺東縣';
                } elseif ($county == 'ptc') {
                    $from = '屏東縣';
                } elseif ($county == 'ntpc') {
                    $from = '新北市';
                }

                Tools::login_xoops($uname, $name, $email, $SchoolCode, $JobName, '', $from);
            }
        }
    } catch (ErrorException $e) {
        $main = $e->getMessage();
    }

    $xoopsTpl->assign('openid', $main);
}

//桃園市登入
function ty_login()
{
    global $xoopsModuleConfig, $xoopsConfig, $xoopsDB, $xoopsTpl, $xoopsUser;

    if ($xoopsUser) {
        header('location:' . XOOPS_URL . '/user.php');
        exit;
    }

    require_once __DIR__ . '/class/openid_ty.php';

    try {
        # Change 'localhost' to your domain name.
        $openid = new LightOpenID(XOOPS_URL);
        if (!$openid->mode) {
            if (isset($_GET['login'])) {
                $openid->identity = 'https://openid.tyc.edu.tw';
                $openid->required = ['contact/email', 'namePerson/friendly', 'namePerson'];
                $openid->optional = ['contact/country/home', 'pref/timezone'];
                header('Location: ' . $openid->authUrl());
            }
        } else {
            $user_profile = $openid->getAttributes();
            // Utility::dd($user_profile);
            if ($user_profile) {
                $myts = \MyTextSanitizer::getInstance();

                $user_profile['contact/email'] = trim($user_profile['contact/email']);
                $the_id                        = explode('@', $user_profile['contact/email']);

                //$uid = $user['id'];
                $uname = $the_id[0] . '_ty';
                $name  = $myts->addSlashes($user_profile['namePerson']);
                $email = mb_strtolower($user_profile['contact/email']);

                $SchoolCode = $myts->addSlashes($user_profile['contact/country/home']);
                $arr        = json_decode($user_profile['pref/timezone'], true);
                $JobName    = (false !== mb_strpos($arr[0]['title'], '學生')) ? 'student' : 'teacher';

                //搜尋有無相同username資料
                Tools::login_xoops($uname, $name, $email, $SchoolCode, $JobName, '', '桃園市');
            }
        }
    } catch (ErrorException $e) {
        $main = $e->getMessage();
    }

    $xoopsTpl->assign('openid', $main);
}

//台中版 OpenID 登入
function tc_login($county = '', $openid_identity = '')
{
    global $xoopsTpl, $xoopsUser;

    if ($xoopsUser) {
        header('location:' . XOOPS_URL . '/user.php');
        exit;
    }

    require_once __DIR__ . '/class/openid_tc.php';

    try {
        # Change 'localhost' to your domain name.
        $openid = new LightOpenID(XOOPS_URL);
        if (!$openid->mode) {
            $openid->identity = $openid_identity;
            $openid->required = ['contact/email', 'namePerson/friendly', 'namePerson'];
            $openid->optional = ['axschema/person/guid', 'axschema/school/titleStr', 'axschema/school/id', 'tw/person/guid', 'tw/isas/roles'];
            header('Location: ' . $openid->authUrl());
        } else {
            $user_profile = $openid->getAttributes();
            // die(var_export($user_profile));
            /*
            array (
            'axschema/person/guid' => 'ab1a1b5769b6886f40e8e1b2c349e36b470f76b51d3ed8e9e784843fa0ca9355',
            'axschema/school/titleStr' => '[{"id":"A00015","title":["編制人員"]}]',
            'axschema/school/id' => 'A00015',
            'contact/email' => '5348221@ylc.edu.tw',
            'namePerson' => '測試帳號',
            )

            array (
            'axschema/person/guid' => 'ab1a1b5769b6886f40e8e1b2c349e36b470f76b51d3ed8e9e784843fa0ca9355',
            'axschema/school/titleStr' => '[{"id":"094659","title":["教師"]}]',
            'axschema/school/id' => '094659',
            'contact/email' => '5348221@ylc.edu.tw',
            'namePerson' => '測試帳號',
            )
            //南投
            array ( 'contact/email' => ' t03238@mail.edu.tw', 'namePerson' => '劉坤榮', )

            array (
            'axschema/person/guid' => '3ba3a257aec87686e0b52bb81c4ca338d04dd25205358e8730d5fa87cfdf2bff',
            'axschema/school/titleStr' => '[{\\"id\\":\\"084719a1\\",\\"title\\":[\\"教師\\"]},{\\"id\\":\\"084716a1\\",\\"title\\":[\\"教師\\"]}]',
            'axschema/school/id' => '084719a1',
            'contact/email' => 'kk@k.2.k',
            'namePerson' => '測試一',
            )

            //彰化
            array (
            'axschema/person/guid' => '4208f4152cb215d19edfa78d4e85ae2ccee65497ed68af69e5ca7641510d3af6',
            'axschema/school/titleStr' => '[{"id":"074628","title":["教師","學校管理者"]}]',
            'axschema/school/id' => '074628',
            'contact/email' => 'NA',
            'namePerson' => '測試',
            )

            //花蓮縣
            array (
            'axschema/person/guid' => '43f51043286df35cbe4d227ef429bdddc87f717d083892a2f71984c89b98e52c',
            'axschema/school/titleStr' => '[{"titles":["教師"],"sid":"154512"}]',
            'axschema/school/id' => '154512',
            'contact/email' => 'ooo@gmail.com',
            'namePerson' => '蕭老師',
            )
             */
            // Login or logout url will be needed depending on current user state.
            if ($user_profile) {
                $myts = \MyTextSanitizer::getInstance();

                $SchoolCode = $myts->addSlashes($user_profile['axschema/school/id']);

                if ('NA' === mb_strtoupper($user_profile['contact/email']) or empty($user_profile['contact/email'])) {
                    $uname = mb_substr($user_profile['axschema/person/guid'], 0, 6) . "_{$county}";
                    $email = "{$uname}@{$SchoolCode}.{$county}.edu.tw";
                } else {
                    $user_profile['contact/email'] = trim($user_profile['contact/email']);
                    $the_id                        = explode('@', $user_profile['contact/email']);
                    $uname                         = trim($the_id[0]) . '_' . $county;
                    $email                         = $user_profile['contact/email'];
                }
                //$uid = $user['id'];
                $name = $myts->addSlashes($user_profile['namePerson']);

                $JobName = (false !== mb_strpos($user_profile['axschema/school/titleStr'], '學生')) ? 'student' : 'teacher';

                if ($county == 'cyc') {
                    $from = '嘉義縣';
                } elseif ($county == 'ylc') {
                    $from = '雲林縣';
                } elseif ($county == 'mlc') {
                    $from = '苗栗縣';
                } elseif ($county == 'cy') {
                    $from = '嘉義縣';
                } elseif ($county == 'hlc') {
                    $from = '花蓮縣';
                } elseif ($county == 'ptc') {
                    $from = '屏東縣';
                } elseif ($county == 'phc') {
                    $from = '澎湖縣';
                } elseif ($county == 'hcc') {
                    $from = '新竹縣';
                } elseif ($county == 'chc') {
                    $from = '彰化縣';
                } elseif ($county == 'ntct') {
                    $from = '南投縣';
                } elseif ($county == 'tc') {
                    $from = '臺中市';
                }

                //搜尋有無相同username資料
                Tools::login_xoops($uname, $name, $email, $SchoolCode, $JobName, '', $from);
            }
        }
    } catch (ErrorException $e) {
        $main = $e->getMessage();
    }

    $xoopsTpl->assign('openid', $main);
}

//高雄市 OpenID 登入
function kh_login()
{
    global $xoopsModuleConfig, $xoopsConfig, $xoopsDB, $xoopsTpl, $xoopsUser;

    if ($xoopsUser) {
        header('location:' . XOOPS_URL . '/user.php');
        exit;
    }
    require_once __DIR__ . '/class/openid_kh.php';

    try {
        # Change 'localhost' to your domain name.
        $openid = new LightOpenID(XOOPS_URL);
        if (!$openid->mode) {
            header('Location: https://openid.kh.edu.tw/?openid.return_to=' . XOOPS_URL . '/modules/tad_login/index.php?op=kh&openid.realm=' . XOOPS_URL . '/&openid.identity=https://openid.kh.edu.tw/&openid.mode=checkid_setup&openid.ns=https://specs.openid.net/auth/2.0&openid.ns.ext1=https://openid.net/extensions/sreg/1.1&openid.ns.ext2=https://openid.net/srv/ax/1.0&openid.claimed_id=https://specs.openid.net/auth/2.0/identifier_select&openid.ext1.required=fullname,email&openid.ext2.type.guid=https://axschema.edu.tw/person/guid&openid.ext2.type.sid=https://axschema.edu.tw/school/id&openid.ext2.type.titles=https://axschema.edu.tw/person/titles&openid.ext2.type.classStr=https://axschema.kh.edu.tw/school/classStr&openid.ext2.required=guid,sid,titles,classStr&openid.ext2.mode=fetch_request');

            /*

        array (
        'op' => 'kh',
        'openid_ns' => 'https://specs.openid.net/auth/2.0',
        'openid_op_endpoint' => 'https://openid.kh.edu.tw/',
        'openid_claimed_id' => 'https://openid.kh.edu.tw/S0407225',
        'openid_response_nonce' => '2016-11-18T08:46:32Z0',
        'openid_mode' => 'id_res',
        'openid_identity' => 'https://openid.kh.edu.tw/S0407225',
        'openid_return_to' => 'https://est.tpps.kh.edu.tw/modules/tad_login/index.php?op=kh',
        'openid_assoc_handle' => '08a58751cb534ed5a011c218aa2cc89f-2995',
        'openid_signed' => 'op_endpoint,claimed_id,identity,return_to,response_nonce,assoc_handle,ns.ext1,ns.ext2,ext1.mode,ext1.type.guid,ext1.value.guid,ext1.type.sid,ext1.value.sid,ext1.type.titles,ext1.value.titles,ext1.type.classStr,ext1.value.classStr,ext2.fullname,ext2.email',
        'openid_sig' => 'F9o3ttinjAUySAU9Xxeg+Av1liyschcnsiV0d0YLUdo=',
        'openid_ns_ext1' => 'https://openid.net/srv/ax/1.0',
        'openid_ext1_mode' => 'fetch_response',
        'openid_ext1_type_guid' => 'https://axschema.edu.tw/person/guid',
        'openid_ext1_value_guid' => '4b9d1643ddf10225f49b4b1d6993b03f94b60f5c05f6788694d12def0add9a1f',
        'openid_ext1_type_sid' => 'https://axschema.edu.tw/school/id',
        'openid_ext1_value_sid' => '613605',
        'openid_ext1_type_titles' => 'https://axschema.edu.tw/person/titles',
        'openid_ext1_value_titles' => '{"sid":"613605","titles":["學生"]}',
        'openid_ext1_type_classStr' => 'https://axschema.kh.edu.tw/school/classStr',
        'openid_ext1_value_classStr' => '[{"sid":"613605","groupId":"","title":"學生","classTitle":"201","degree":"國小","DN":"D","gradeId":"2","classId":"01","subject":"普通班","subjectId":"0","schoolType":"P"}]',
        'openid_ns_ext2' => 'https://openid.net/extensions/sreg/1.1',
        'openid_ext2_fullname' => '曹宸澔',
        'openid_ext2_email' => '',
        )

        array (
        'op' => 'kh',
        'openid_ns' => 'https://specs.openid.net/auth/2.0',
        'openid_op_endpoint' => 'https://openid.kh.edu.tw/',
        'openid_claimed_id' => 'https://openid.kh.edu.tw/tyk',
        'openid_response_nonce' => '2016-11-18T08:55:41Z0',
        'openid_mode' => 'id_res',
        'openid_identity' => 'https://openid.kh.edu.tw/tyk',
        'openid_return_to' => 'https://est.tpps.kh.edu.tw/modules/tad_login/index.php?op=kh',
        'openid_assoc_handle' => '08a58751cb534ed5a011c218aa2cc89f-3007',
        'openid_signed' => 'op_endpoint,claimed_id,identity,return_to,response_nonce,assoc_handle,ns.ext1,ns.ext2,ext1.mode,ext1.type.guid,ext1.value.guid,ext1.type.sid,ext1.value.sid,ext1.type.titles,ext1.value.titles,ext1.type.classStr,ext1.value.classStr,ext2.fullname,ext2.email',
        'openid_sig' => '4QhRyqpGVjnStBa0pYuv1/G6lGfr5CprnFE6SQ0cfj4=',
        'openid_ns_ext1' => 'https://openid.net/srv/ax/1.0',
        'openid_ext1_mode' => 'fetch_response',
        'openid_ext1_type_guid' => 'https://axschema.edu.tw/person/guid',
        'openid_ext1_value_guid' => 'a0c55d6527c4795ee56777f54d32ee1ac9506b872112be6653930f83f0319d86',
        'openid_ext1_type_sid' => 'https://axschema.edu.tw/school/id',
        'openid_ext1_value_sid' => '123456',
        'openid_ext1_type_titles' => 'https://axschema.edu.tw/person/titles',
        'openid_ext1_value_titles' => '{"sid":"123456","titles":["教師","設備組長"]}',
        'openid_ext1_type_classStr' => 'https://axschema.kh.edu.tw/school/classStr',
        'openid_ext1_value_classStr' => '[]',
        'openid_ns_ext2' => 'https://openid.net/extensions/sreg/1.1',
        'openid_ext2_fullname' => '杜老師',
        'openid_ext2_email' => 't000@gmail.com',
        )
         */
        } else {
            $user_profile = $openid->getAttributes();
            // die(var_export($user_profile));
            // Login or logout url will be needed depending on current user state.

            if ($user_profile) {
                $myts = \MyTextSanitizer::getInstance();

                if ($user_profile['openid_ext2_email']) {
                    $the_id = explode('@', $user_profile['openid_ext2_email']);
                    $uname  = $the_id[0] . '_kh';
                    $email  = mb_strtolower($user_profile['openid_ext2_email']);
                } else {
                    $the_id = str_replace('https://openid.kh.edu.tw/', '', $user_profile['openid_claimed_id']);
                    $uname  = $the_id . '_kh';
                    $email  = "{$the_id}@mail.kh.edu.tw";
                }

                //$uid = $user['id'];
                $name       = $myts->addSlashes($user_profile['openid_ext2_fullname']);
                $SchoolCode = $myts->addSlashes($user_profile['openid_ext1_value_sid']);
                $classStr   = $myts->addSlashes($user_profile['openid_ext1_value_classStr']);

                $JobName = (false !== mb_strpos($user_profile['openid_ext1_value_titles'], '教師')) ? 'teacher' : 'student';

                //搜尋有無相同username資料
                // die("$uname, $name, $email, $SchoolCode, $JobName, null, $classStr");
                $classStr  = preg_replace('/.+?({.+}).+/', '$1', $classStr);
                $classStr  = str_replace('&#34;', '"', superentities($classStr));
                $user_data = json_decode($classStr, true);
                // [{"classTitle":"503","gradeId":"5","classId":"03","subject":"普通班"}]
                $newclassStr = ['classTitle' => $user_data['classTitle'], 'gradeId' => $user_data['gradeId'], 'classId' => $user_data['classId'], 'subject' => $user_data['subject']];
                $classStr    = is_array($user_data) ? '[' . json_encode($newclassStr) . ']' : '[]';

                $bio = $user_profile['openid_ext1_value_titles'];
                Tools::login_xoops($uname, $name, $email, $SchoolCode, $JobName, null, '高雄市', null, null, $bio);
            }
        }
    } catch (ErrorException $e) {
        $main = $e->getMessage();
        die($main);
    }

    $xoopsTpl->assign('openid', $main);
}

function superentities($str)
{
    // get rid of existing entities else double-escape
    $str2 = '';
    $str  = html_entity_decode(stripslashes($str), ENT_QUOTES, 'UTF-8');
    $ar   = preg_split('/(?<!^)(?!$)/u', $str); // return array of every multi-byte character
    foreach ($ar as $c) {
        $o = ord($c);
        if ((mb_strlen($c) > 1) || /* multi-byte [unicode] */
            ($o < 32 || $o > 126) || /* <- control / latin weirdos -> */
            ($o > 33 && $o < 40) || /* quotes + ambersand */
            ($o > 59 && $o < 63) /* html */
        ) {
            // convert to numeric entity
            $c = mb_encode_numericentity($c, [0x0, 0xffff, 0, 0xffff], 'UTF-8');
        }
        $str2 .= $c;
    }

    return $str2;
}
//金門 OpenID 登入
function km_login()
{
    global $xoopsModuleConfig, $xoopsConfig, $xoopsDB, $xoopsTpl, $xoopsUser;

    if ($xoopsUser) {
        header('location:' . XOOPS_URL . '/user.php');
        exit;
    }

    require_once __DIR__ . '/class/openid_kl.php';

    try {
        # Change 'localhost' to your domain name.
        $openid = new LightOpenID(XOOPS_URL);
        if (!$openid->mode) {
            $openid->identity = 'https://openid.cnc.km.edu.tw';
            $openid->required = ['contact/email', 'namePerson/friendly', 'namePerson'];
            $openid->optional = ['axschema/person/guid', 'axschema/school/titleStr', 'axschema/school/id', 'tw/person/guid', 'tw/isas/roles'];
            // $openid->required = array('contact/email', 'namePerson');
            // $openid->optional = array('axschema/person/guid', 'axschema/school/titleStr', 'axschema/school/id');
            header('Location: ' . $openid->authUrl());
        } else {
            $user_profile = $openid->getAttributes();
            // die(var_export($user_profile));
            /*
            array (
            'axschema/school/id' => '714501',
            'axschema/school/titleStr' => '{"sid":"714501","title":["教師"],"titles":["教師"]}',
            'contact/email' => 'test@gm.km.edu.tw',
            'namePerson' => '測試帳號',
            'namePerson/friendly' => 'Test',
            )
             */

            if ($user_profile) {
                $myts = \MyTextSanitizer::getInstance();

                $user_profile['contact/email'] = trim($user_profile['contact/email']);
                $the_id                        = explode('@', $user_profile['contact/email']);

                //$uid = $user['id'];
                $uname      = $the_id[0] . '_km';
                $name       = $myts->addSlashes($user_profile['namePerson']);
                $email      = mb_strtolower($user_profile['contact/email']);
                $SchoolCode = $myts->addSlashes($user_profile['axschema/school/id']);
                $JobName    = (false !== mb_strrpos($user_profile['axschema/school/titleStr'], '學生')) ? 'student' : 'teacher';

                //搜尋有無相同username資料
                Tools::login_xoops($uname, $name, $email, $SchoolCode, $JobName, '', '金門縣');
            }
        }
    } catch (ErrorException $e) {
        $main = $e->getMessage();
    }

    $xoopsTpl->assign('openid', $main);
}

//馬祖 OpenID 登入
function mt_login()
{
    global $xoopsModuleConfig, $xoopsConfig, $xoopsDB, $xoopsTpl, $xoopsUser;

    if ($xoopsUser) {
        header('location:' . XOOPS_URL . '/user.php');
        exit;
    }

    require_once __DIR__ . '/class/openid_kl.php';

    try {
        # Change 'localhost' to your domain name.
        $openid = new LightOpenID(XOOPS_URL);
        if (!$openid->mode) {
            $openid->identity = 'https://openid.matsu.edu.tw';

            $openid->required = ['contact/email', 'namePerson/friendly', 'namePerson'];
            $openid->optional = ['axschema/person/guid', 'axschema/school/titleStr', 'axschema/school/id', 'tw/person/guid', 'tw/isas/roles'];
            header('Location: ' . $openid->authUrl());
        } else {
            $user_profile = $openid->getAttributes();
            // die(var_export($user_profile));
            /*
            array (
            'axschema/school/id' => '724603',
            'axschema/school/titleStr' => '{"sid":"724603","titles":["學生"]}',
            'contact/email' => 'openid@gm.matsu.edu.tw',
            'namePerson' => '林大民',
            'namePerson/friendly' => 'Stu',
            )
             */

            if ($user_profile) {
                $myts = \MyTextSanitizer::getInstance();

                $user_profile['contact/email'] = trim($user_profile['contact/email']);
                $the_id                        = explode('@', $user_profile['contact/email']);

                //$uid = $user['id'];
                $uname      = $the_id[0] . '_mt';
                $name       = $myts->addSlashes($user_profile['namePerson']);
                $email      = mb_strtolower($user_profile['contact/email']);
                $SchoolCode = $myts->addSlashes($user_profile['axschema/school/id']);
                $JobName    = 'Stu' === $user_profile['namePerson/friendly'] ? 'student' : 'teacher';

                //搜尋有無相同username資料
                Tools::login_xoops($uname, $name, $email, $SchoolCode, $JobName, '', '連江縣');
            }
        }
    } catch (ErrorException $e) {
        $main = $e->getMessage();
    }

    $xoopsTpl->assign('openid', $main);
}

function list_login()
{
    global $xoopsTpl, $xoopsModuleConfig, $oidc_array;

    if (isset($_SESSION['auth_method'])) {
        if ('ylc' === $_SESSION['auth_method']) {
            tc_login('ylc', 'http://openid.ylc.edu.tw/');
        } elseif ('mlc' === $_SESSION['auth_method']) {
            tc_login('mlc', 'https://openid2.mlc.edu.tw');
        } elseif ('cy' === $_SESSION['auth_method']) {
            tc_login('cy', 'https://openid.cy.edu.tw');
        } elseif ('hlc' === $_SESSION['auth_method']) {
            tc_login('hlc', 'http://openid2.hlc.edu.tw');
        } elseif ('ptc' === $_SESSION['auth_method']) {
            tc_login('ptc', 'http://openid.ptc.edu.tw');
        } elseif ('phc' === $_SESSION['auth_method']) {
            tc_login('phc', 'https://openid.phc.edu.tw');
        } elseif ('ttct' === $_SESSION['auth_method']) {
            hlc_login('ttct', 'https://openid.boe.ttct.edu.tw');
        } elseif ('ntpc' === $_SESSION['auth_method']) {
            hlc_login('ntpc', 'https://openid.ntpc.edu.tw');
        } elseif ('tp_ldap' === $_SESSION['auth_method']) {
            tp_ldap_login();
            // } elseif ('cyc' === $_SESSION['auth_method']) {
            //     tc_login('cyc', 'https://openid.cyccc.tw');
            // } elseif ('hcc' === $_SESSION['auth_method']) {
            //     tc_login('hcc', 'https://openid.hcc.edu.tw');
            // } elseif ('chc' === $_SESSION['auth_method']) {
            //     tc_login('chc', 'https://openid.chc.edu.tw');
            // } elseif ('ntct' === $_SESSION['auth_method']) {
            //     tc_login('ntct', 'https://openid.ntct.edu.tw');
            // } elseif ('tc' === $_SESSION['auth_method']) {
            //     tc_login('tc', 'https://openid.tc.edu.tw');
            // } elseif ('ty' === $_SESSION['auth_method']) {
            //     ty_login();
        } elseif (isset($_SESSION['auth_method'])) {
            call_user_func("{$_SESSION['auth_method']}_login");
        }
    }

    $i = 0;
    foreach ($xoopsModuleConfig['auth_method'] as $openid) {
        if ('google' === $openid) {
            $url = Tools::google_login('return');
        } elseif ('line' === $openid) {
            $url = Tools::line_login('return');
        } else {
            $url = XOOPS_URL . "/modules/tad_login/index.php?login&op={$openid}";
        }
        $auth_method[$i]['title'] = $openid;
        $auth_method[$i]['url']   = $url;
        $auth_method[$i]['logo']  = in_array($openid, $oidc_array) ? XOOPS_URL . "/modules/tad_login/images/oidc/" . Tools::$all_oidc[$openid]['tail'] . ".png" : XOOPS_URL . "/modules/tad_login/images/{$openid}_l.png";
        if (in_array($openid, $oidc_array)) {
            $auth_method[$i]['text'] = constant('_' . mb_strtoupper(Tools::$all_oidc[$openid]['tail'])) . ' OIDC ' . _MD_TADLOGIN_LOGIN;
        } elseif (in_array($openid, array_keys(Tools::$all_oidc2))) {
            $auth_method[$i]['text'] = constant('_' . mb_strtoupper(Tools::$all_oidc[$openid]['tail'])) . _MD_TADLOGIN_LOGIN;
        } else {
            $auth_method[$i]['text'] = constant('_' . mb_strtoupper($openid)) . ' OpenID ' . _MD_TADLOGIN_LOGIN;
        }

        $i++;
    }
    $xoopsTpl->assign('auth_method', $auth_method);
}

function tp_ldap_login()
{
    global $xoopsModuleConfig;
    if (!isset($xoopsModuleConfig)) {
        $modhandler        = xoops_gethandler('module');
        $xoopsModule       = $modhandler->getByDirname("tad_login");
        $config_handler    = xoops_gethandler('config');
        $xoopsModuleConfig = $config_handler->getConfigsByCat(0, $xoopsModule->mid());
    }

    $oidc_setup = json_decode($xoopsModuleConfig['oidc_setup'], true);

    if (empty($oidc_setup['tp_ldap']['clientid'])) {
        redirect_header(XOOPS_URL, 3, "系統無法取得臺北市單一簽入 client id 值");
    }
    header("location:https://ldap.tp.edu.tw/oauth/authorize?client_id={$oidc_setup['tp_ldap']['clientid']}&redirect_uri=" . XOOPS_URL . '/modules/tad_login/tp_callback.php&response_type=code&scope=user profile');
    exit;
}

function change_pass_form()
{
    global $xoopsUser, $xoopsDB, $xoopsTpl;

    $uname = $xoopsUser->uname();

    $sql    = 'SELECT `hashed_date` FROM `' . $xoopsDB->prefix('tad_login_random_pass') . '` WHERE `uname` =' . $uname;
    $result = $xoopsDB->query($sql) or die($xoopsDB->error());

    list($hashed_date) = $xoopsDB->fetchRow($result);
    $xoopsTpl->assign('hashed_date', $hashed_date);
    $xoopsTpl->assign('uname', $uname);

    $FormValidator = new FormValidator('#myForm', true);
    $FormValidator->render();
}

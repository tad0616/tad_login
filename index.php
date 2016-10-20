<?php
/*-----------引入檔案區--------------*/
include "header.php";
$xoopsOption['template_main'] = set_bootstrap("tad_login_index_tpl.html");
include_once XOOPS_ROOT_PATH . "/header.php";

/*-----------function區--------------*/

//台南 OpenID 登入
function tn_login()
{
    global $xoopsModuleConfig, $xoopsConfig, $xoopsDB, $xoopsTpl, $xoopsUser;

    if ($xoopsUser) {
        header("location:" . XOOPS_URL . "/user.php");
        exit;
    }

    include_once 'class/openid12.php';
    try {
        # Change 'localhost' to your domain name.
        $openid = new LightOpenID(XOOPS_URL);
        if (!$openid->mode) {
            $openid->identity = "https://openid.tn.edu.tw/op/";
            $openid->required = array('contact/email', 'namePerson');
            $openid->optional = array('/axschema/school/id', '/axschema/school/titleStr', 'tw/person/titles');
            header('Location: ' . $openid->authUrl());

        } else {
            $user_profile = $openid->getAttributes();
            // die(var_export($user_profile));
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
                $myts = MyTextsanitizer::getInstance();

                $the_id = explode("@", $user_profile['contact/email']);

                //$uid = $user['id'];
                $uname      = $the_id[0] . "_tn";
                $name       = $myts->addSlashes($user_profile['namePerson']);
                $email      = strtolower($user_profile['contact/email']);
                $SchoolCode = $myts->addSlashes($user_profile['tw/school/id']);
                $JobName    = strpos($user_profile['tw/person/titles'], '"學生"') !== false ? "student" : "teacher";

                if ($user_profile['du.tw/school/classStr']) {
                    $classStr = substr($user_profile['du.tw/school/classStr'], 2, -2);
                    echo "<p>$classStr</p>";
                    $classStr = str_replace('\\', '', $classStr);
                    echo "<p>$classStr</p>";
                    $classStrArr = explode(',', $classStr);
                    $StuArr      = array();
                    foreach ($classStrArr as $Arr) {
                        list($k, $v) = explode(':', $Arr);
                        $StuArr[$k]  = str_replace('\'', '', $v);
                    }
                    $aim  = $myts->addSlashes($StuArr['gradeId']);
                    $yim  = $myts->addSlashes($StuArr['classId']);
                    $msnm = '';
                } else {
                    $aim  = $myts->addSlashes($user_profile['.tw/axschema/grade']);
                    $yim  = $user_profile['.tw/axschema/class'];
                    $msnm = $myts->addSlashes($user_profile['.tw/axschema/seat']);
                }
                //搜尋有無相同username資料
                login_xoops($uname, $name, $email, $SchoolCode, $JobName, $url, $from, $sig, $occ, $bio, $aim, $yim, $msnm);
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
    global $xoopsModuleConfig, $xoopsConfig, $xoopsDB, $xoopsTpl, $xoopsUser;

    if ($xoopsUser) {
        header("location:" . XOOPS_URL . "/user.php");
        exit;
    }

    include_once 'class/openid12.php';
    try {
        # Change 'localhost' to your domain name.
        $openid = new LightOpenID(XOOPS_URL);

        if (!$openid->mode) {
            $openid->identity = "https://openid.tp.edu.tw/openid/op.action";
            $openid->required = array('contact/email', 'namePerson/friendly', 'namePerson');
            $openid->optional = array('axschema/person/accountType', 'axschema/school/titleStr', 'axschema/school/id');
            header('Location: ' . $openid->authUrl());

        } else {
            $user_profile = $openid->getAttributes();
            // die(var_export($user_profile));

            // Login or logout url will be needed depending on current user state.
            //die(var_dump($user_profile));
            if ($user_profile) {
                $myts = MyTextsanitizer::getInstance();

                $the_id = explode("@", $user_profile['contact/email']);

                //$uid = $user['id'];
                $uname      = $the_id[0] . "_tp";
                $name       = $myts->addSlashes($user_profile['namePerson']);
                $email      = strtolower($user_profile['contact/email']);
                $SchoolCode = $myts->addSlashes($user_profile['.tw/axschema/EduSchoolID']);
                $JobName    = $user_profile['.tw/axschema/JobName'] == "學生" ? "student" : "teacher";

                //搜尋有無相同username資料
                login_xoops($uname, $name, $email, $SchoolCode, $JobName);
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
        header("location:" . XOOPS_URL . "/user.php");
        exit;
    }

    include_once 'class/openid_kl.php';
    try {
        # Change 'localhost' to your domain name.
        $openid = new LightOpenID(XOOPS_URL);

        if (!$openid->mode) {
            $openid->identity = "http://openid.kl.edu.tw";
            $openid->required = array('contact/email', 'namePerson/friendly', 'namePerson');
            $openid->optional = array('axschema/person/guid', 'axschema/school/titleStr', 'axschema/school/id', 'tw/person/guid', 'tw/isas/roles');
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
                $myts = MyTextsanitizer::getInstance();

                $the_id = explode("@", $user_profile['contact/email']);

                //$uid = $user['id'];
                $uname      = $the_id[0] . "_kl";
                $name       = $myts->addSlashes($user_profile['namePerson']);
                $email      = strtolower($user_profile['contact/email']);
                $SchoolCode = $myts->addSlashes($user_profile['axschema/school/id']);
                $JobName    = (strpos($user_profile['axschema/school/titleStr'], "學生") !== false) ? "student" : "teacher";

                //搜尋有無相同username資料
                login_xoops($uname, $name, $email, $SchoolCode, $JobName);
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
        header("location:" . XOOPS_URL . "/user.php");
        exit;
    }

    include_once 'class/openid.php';
    try {
        # Change 'localhost' to your domain name.
        $openid = new LightOpenID(XOOPS_URL);
        if (!$openid->mode) {
            $openid->identity = "http://openid.ilc.edu.tw";
            $openid->required = array('contact/email', 'namePerson/friendly', 'namePerson');
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
                $myts = MyTextsanitizer::getInstance();

                $the_id = explode("@", $user_profile['contact/email']);

                //$uid = $user['id'];
                $uname      = $the_id[0] . "_ilc";
                $name       = $myts->addSlashes($user_profile['namePerson']);
                $email      = strtolower($user_profile['contact/email']);
                $SchoolCode = $myts->addSlashes($user_profile['axschema/school/id']);

                $JobName = (strpos($user_profile['axschema/school/titleStr'], "學生") !== false) ? "student" : "teacher";

                //搜尋有無相同username資料
                login_xoops($uname, $name, $email, $SchoolCode, $JobName);
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
        header("location:" . XOOPS_URL . "/user.php");
        exit;
    }

    include_once 'class/openid.php';
    try {
        # Change 'localhost' to your domain name.
        $openid = new LightOpenID(XOOPS_URL);
        if (!$openid->mode) {
            $openid->identity = "http://openid.hc.edu.tw";
            $openid->required = array('contact/email', 'namePerson/friendly', 'namePerson');
            $openid->optional = array('contact/postalCode/home', 'contact/country/home', 'pref/language', 'pref/timezone');
            header('Location: ' . $openid->authUrl());

        } else {
            $user_profile = $openid->getAttributes();
            //die(var_export($user_profile));
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
                $myts = MyTextsanitizer::getInstance();

                $the_id = explode("@", $user_profile['contact/email']);

                //$uid = $user['id'];
                $uname      = $the_id[0] . "_hc";
                $name       = $myts->addSlashes($user_profile['namePerson']);
                $email      = strtolower($user_profile['contact/email']);
                $SchoolCode = $myts->addSlashes($user_profile['contact/country/home']);

                $JobName = (strpos($user_profile['pref/timezone'], "學生") !== false) ? "student" : "teacher";

                //搜尋有無相同username資料
                login_xoops($uname, $name, $email, $SchoolCode, $JobName);
            }
        }
    } catch (ErrorException $e) {
        $main = $e->getMessage();
    }

    $xoopsTpl->assign('openid', $main);
}

//花蓮縣登入
function hlc_login($conty = "", $openid_identity = "")
{
    global $xoopsModuleConfig, $xoopsConfig, $xoopsDB, $xoopsTpl, $xoopsUser;

    if ($xoopsUser) {
        header("location:" . XOOPS_URL . "/user.php");
        exit;
    }

    include_once 'class/openid.php';
    try {
        # Change 'localhost' to your domain name.
        $openid = new LightOpenID(XOOPS_URL);
        if (!$openid->mode) {
            if (isset($_GET['login'])) {
                // die($openid_identity);
                $openid->identity = $openid_identity;
                $openid->required = array('contact/email', 'namePerson/friendly', 'namePerson');
                $openid->optional = array('contact/country/home', 'pref/timezone');
                header('Location: ' . $openid->authUrl());

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

            //tyc
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
            // die(var_export($user_profile));
            if ($user_profile) {
                $myts = MyTextsanitizer::getInstance();

                $the_id = explode("@", $user_profile['contact/email']);

                //$uid = $user['id'];
                $uname = $the_id[0] . "_" . $conty;
                $name  = $myts->addSlashes($user_profile['namePerson']);
                $email = strtolower($user_profile['contact/email']);
                if ($conty == "ntpc") {
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

                    $JobName = (strpos($arr[0]['role'], "學生") !== false) ? "student" : "teacher";

                } elseif ($conty == "tyc") {
                    $SchoolCode = $myts->addSlashes($user_profile['contact/country/home']);
                    $arr        = json_decode($user_profile['pref/timezone'], true);
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

                    $JobName = (strpos($arr[0]['title'], "學生") !== false) ? "student" : "teacher";

                } else {
                    $SchoolCode = $myts->addSlashes($user_profile['contact/country/home']);

                    $JobName = (strpos($user_profile['pref/timezone'], "學生") !== false) ? "student" : "teacher";

                }
                //搜尋有無相同username資料
                login_xoops($uname, $name, $email, $SchoolCode, $JobName);
            }
        }
    } catch (ErrorException $e) {
        $main = $e->getMessage();
    }

    $xoopsTpl->assign('openid', $main);
}

//Yahoo 登入
function yahoo_login()
{
    global $xoopsModuleConfig, $xoopsConfig, $xoopsDB, $xoopsTpl, $xoopsUser;

    if ($xoopsUser) {
        header("location:" . XOOPS_URL . "/user.php");
        exit;
    }

    include_once 'class/openid.php';
    try {
        # Change 'localhost' to your domain name.
        $openid = new LightOpenID(XOOPS_URL);
        if (!$openid->mode) {
            if (isset($_GET['login'])) {
                $openid->identity = 'https://me.yahoo.com';
                $openid->required = array('contact/email', 'namePerson/friendly', 'namePerson');
                header('Location: ' . $openid->authUrl());
            }
        } else {

            $user_profile = $openid->getAttributes();
            //die(var_export($user_profile));
            if ($user_profile) {
                $myts = MyTextsanitizer::getInstance();

                $the_id = explode("@", $user_profile['contact/email']);

                $uname = empty($user_profile['namePerson/friendly']) ? $the_id[0] . "_ya" : $user_profile['namePerson/friendly'] . "_ya";
                $name  = $myts->addSlashes($user_profile['namePerson']);
                $email = $user_profile['contact/email'];
                login_xoops($uname, $name, $email);
            }
        }
    } catch (ErrorException $e) {
        $main = $e->getMessage();
    }

    $xoopsTpl->assign('yahoo', $main);
}

//MyID 登入
function myid_login()
{
    global $xoopsModuleConfig, $xoopsConfig, $xoopsDB, $xoopsTpl, $xoopsUser;

    if ($xoopsUser) {
        header("location:" . XOOPS_URL . "/user.php");
        exit;
    }

    include_once 'class/openid.php';
    try {
        # Change 'localhost' to your domain name.
        $openid = new LightOpenID(XOOPS_URL);
        if (!$openid->mode) {
            if (isset($_GET['login'])) {
                $openid->identity = 'https://myid.tw';
                $openid->required = array('contact/email', 'namePerson/friendly', 'namePerson');
                header('Location: ' . $openid->authUrl());

            }
        } else {

            $user_profile = $openid->getAttributes();
            //die(var_export($user_profile));
            if ($user_profile) {
                $myts = MyTextsanitizer::getInstance();

                $the_id = explode("@", $user_profile['contact/email']);

                //$uid = $user['id'];
                $uname = empty($user_profile['namePerson/friendly']) ? $the_id[0] . "_my" : $user_profile['namePerson/friendly'] . "_my";
                $name  = $myts->addSlashes($user_profile['namePerson']);
                $email = $user_profile['contact/email'];
                login_xoops($uname, $name, $email);
            }
        }
    } catch (ErrorException $e) {
        $main = $e->getMessage();
    }

    $xoopsTpl->assign('MyID', $main);
}

//台中版 OpenID 登入
function tc_login($conty = "", $openid_identity = "")
{
    global $xoopsModuleConfig, $xoopsConfig, $xoopsDB, $xoopsTpl, $xoopsUser;

    if ($xoopsUser) {
        header("location:" . XOOPS_URL . "/user.php");
        exit;
    }

    include_once 'class/openid_tc.php';
    try {
        # Change 'localhost' to your domain name.
        $openid = new LightOpenID(XOOPS_URL);
        if (!$openid->mode) {
            $openid->identity = $openid_identity;
            $openid->required = array('contact/email', 'namePerson/friendly', 'namePerson');
            $openid->optional = array('axschema/person/guid', 'axschema/school/titleStr', 'axschema/school/id', 'tw/person/guid', 'tw/isas/roles');
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
             */
            // Login or logout url will be needed depending on current user state.
            if ($user_profile) {
                $myts = MyTextsanitizer::getInstance();

                $SchoolCode = $myts->addSlashes($user_profile['axschema/school/id']);

                if (strtoupper($user_profile['contact/email']) == "NA" or empty($user_profile['contact/email'])) {
                    $uname = substr($user_profile['axschema/person/guid'], 0, 6) . "_{$conty}";
                    $email = "{$uname}@{$SchoolCode}.{$conty}.edu.tw";
                } else {
                    $the_id = explode("@", $user_profile['contact/email']);
                    $uname  = trim($the_id[0]) . "_" . $conty;
                    $email  = $user_profile['contact/email'];
                }
                //$uid = $user['id'];
                $name = $myts->addSlashes($user_profile['namePerson']);

                $JobName = (strpos($user_profile['axschema/school/titleStr'], "學生") !== false) ? "student" : "teacher";

                //搜尋有無相同username資料
                login_xoops($uname, $name, $email, $SchoolCode, $JobName);
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
        header("location:" . XOOPS_URL . "/user.php");
        exit;
    }
    include_once 'class/openid_kh.php';

    try {
        # Change 'localhost' to your domain name.
        $openid = new LightOpenID(XOOPS_URL);
        if (!$openid->mode) {
            //guid,sid,titleStr
            $openid->identity = "http://openid.kh.edu.tw";
            $openid->required = array('namePerson/friendly', 'contact/email', 'namePerson', 'contact/postalCode/home', 'contact/country/home');
            $openid->optional = array('axschema/person/guid', 'edu/person/guid');
            header('Location: ' . $openid->authUrl());

            /*
        array (
        'login' => '',
        'op' => 'kh',
        'openid_ns' => 'http://specs.openid.net/auth/2.0',
        'openid_op_endpoint' => 'http://openid.kh.edu.tw/',
        'openid_claimed_id' => 'http://openid.kh.edu.tw/tyk',
        'openid_response_nonce' => '2015-03-30T06:30:07Z3',
        'openid_mode' => 'id_res',
        'openid_identity' => 'http://openid.kh.edu.tw/tyk',
        'openid_return_to' => 'http://localhost/x25/modules/tad_login/index.php?login&op=kh',
        'openid_assoc_handle' => 'd352417443064c938303d631306cdadd-1453',
        'openid_signed' => 'op_endpoint,claimed_id,identity,return_to,response_nonce,assoc_handle,ns.ext1,ns.ext2,ext1.mode,ext2.email,ext2.nickname,ext2.fullname',
        'openid_sig' => '3Vz6Ah47JkC3xDXaASxCxsTqKSqYBKDKtMeRFf2axQA=',
        'openid_ns_ext1' => 'http://openid.net/srv/ax/1.0',
        'openid_ext1_mode' => 'fetch_response',
        'openid_ns_ext2' => 'http://openid.net/extensions/sreg/1.1',
        'openid_ext2_email' => 't@gmail.com',
        'openid_ext2_nickname' => '',
        'openid_ext2_fullname' => '杜老師',
        )
         */

        } else {
            $user_profile = $openid->getAttributes();
            //die(var_export($user_profile));
            // Login or logout url will be needed depending on current user state.

            if ($user_profile) {
                $myts = MyTextsanitizer::getInstance();

                if ($user_profile['openid_ext2_email']) {
                    $the_id = explode("@", $user_profile['openid_ext2_email']);
                    $uname  = $the_id[0] . "_hk";
                    $email  = strtolower($user_profile['openid_ext2_email']);
                } else {
                    $the_id = str_replace('http://openid.kh.edu.tw/', '', $user_profile['openid_claimed_id']);
                    $uname  = $the_id . "_hk";
                    $email  = "{$the_id}@mail.kh.edu.tw";
                }

                //$uid = $user['id'];
                $name       = $myts->addSlashes($user_profile['openid_ext2_fullname']);
                $SchoolCode = $myts->addSlashes($user_profile['contact/country/home']);

                $JobName = (strpos($user_profile['openid_claimed_id'], "http://openid.kh.edu.tw/S") !== false and is_numeric(substr($the_id, 1, 7))) ? "student" : "teacher";

                //搜尋有無相同username資料
                login_xoops($uname, $name, $email, $SchoolCode, $JobName);
            }
        }
    } catch (ErrorException $e) {
        $main = $e->getMessage();
        die($main);
    }

    $xoopsTpl->assign('openid', $main);
}

//金門 OpenID 登入
function km_login()
{
    global $xoopsModuleConfig, $xoopsConfig, $xoopsDB, $xoopsTpl, $xoopsUser;

    if ($xoopsUser) {
        header("location:" . XOOPS_URL . "/user.php");
        exit;
    }

    include_once 'class/openid_kl.php';
    try {
        # Change 'localhost' to your domain name.
        $openid = new LightOpenID(XOOPS_URL);
        if (!$openid->mode) {
            $openid->identity = "http://openid.cnc.km.edu.tw";
            $openid->required = array('contact/email', 'namePerson/friendly', 'namePerson');
            $openid->optional = array('axschema/person/guid', 'axschema/school/titleStr', 'axschema/school/id', 'tw/person/guid', 'tw/isas/roles');
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
                $myts = MyTextsanitizer::getInstance();

                $the_id = explode("@", $user_profile['contact/email']);

                //$uid = $user['id'];
                $uname      = $the_id[0] . "_km";
                $name       = $myts->addSlashes($user_profile['namePerson']);
                $email      = strtolower($user_profile['contact/email']);
                $SchoolCode = $myts->addSlashes($user_profile['axschema/school/id']);
                $JobName    = (strrpos($user_profile['axschema/school/titleStr'], "學生") !== false) ? "student" : "teacher";

                //搜尋有無相同username資料
                login_xoops($uname, $name, $email, $SchoolCode, $JobName);
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
        header("location:" . XOOPS_URL . "/user.php");
        exit;
    }

    include_once 'class/openid_kl.php';
    try {
        # Change 'localhost' to your domain name.
        $openid = new LightOpenID(XOOPS_URL);
        if (!$openid->mode) {
            $openid->identity = "http://openid.matsu.edu.tw";

            $openid->required = array('contact/email', 'namePerson/friendly', 'namePerson');
            $openid->optional = array('axschema/person/guid', 'axschema/school/titleStr', 'axschema/school/id', 'tw/person/guid', 'tw/isas/roles');
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
                $myts = MyTextsanitizer::getInstance();

                $the_id = explode("@", $user_profile['contact/email']);

                //$uid = $user['id'];
                $uname      = $the_id[0] . "_mt";
                $name       = $myts->addSlashes($user_profile['namePerson']);
                $email      = strtolower($user_profile['contact/email']);
                $SchoolCode = $myts->addSlashes($user_profile['axschema/school/id']);
                $JobName    = $user_profile['namePerson/friendly'] == "Stu" ? "student" : "teacher";

                //搜尋有無相同username資料
                login_xoops($uname, $name, $email, $SchoolCode, $JobName);
            }
        }
    } catch (ErrorException $e) {
        $main = $e->getMessage();
    }

    $xoopsTpl->assign('openid', $main);
}

/*-----------執行動作判斷區----------*/

include_once $GLOBALS['xoops']->path('/modules/system/include/functions.php');
$op = system_CleanVars($_REQUEST, 'op', '', 'string');

switch ($op) {
    case "facebook":
        $_SESSION['auth_method'] = "facebook";
        facebook_login();
        break;

    case "google":
        $_SESSION['auth_method'] = "google";
        google_login();
        break;

    case "twitter":
        $_SESSION['auth_method'] = "twitter";
        twitter_login();
        break;

    case "yahoo":
        $_SESSION['auth_method'] = "yahoo";
        yahoo_login();
        break;

    case "myid":
        $_SESSION['auth_method'] = "myid";
        myid_login();
        break;

    case "tn":
        $_SESSION['auth_method'] = "tn";
        tn_login();
        break;

    case "cyc":
        $_SESSION['auth_method'] = "cyc";
        tc_login("cyc", 'http://openid.cyccc.tw');
        break;

    case "ylc":
        $_SESSION['auth_method'] = "ylc";
        tc_login("ylc", "http://openid.ylc.edu.tw");
        break;

    case "hcc":
        $_SESSION['auth_method'] = "hcc";
        tc_login("hcc", "http://openid.hcc.edu.tw");
        break;

    case "hc":
        $_SESSION['auth_method'] = "hc";
        hc_login();
        break;

    case "mlc":
        $_SESSION['auth_method'] = "mlc";
        tc_login("mlc", "http://openid.mlc.edu.tw");
        break;

    case "chc":
        $_SESSION['auth_method'] = "chc";
        tc_login("chc", "http://openid.chc.edu.tw");
        break;

    case "ntct":
        $_SESSION['auth_method'] = "ntct";
        tc_login("ntct", "http://openid.ntct.edu.tw");
        break;

    case "cy":
        $_SESSION['auth_method'] = "cy";
        tc_login("cy", "http://openid.cy.edu.tw");
        break;

    case "tc":
        $_SESSION['auth_method'] = "tc";
        tc_login("tc", "http://openid.tc.edu.tw");
        break;

    case "ptc":
        $_SESSION['auth_method'] = "ptc";
        tc_login("ptc", "http://openid.ptc.edu.tw");
        break;

    case "hlc":
        $_SESSION['auth_method'] = "hlc";
        hlc_login('hlc', "http://openid.hlc.edu.tw");
        break;

    case "tp":
        $_SESSION['auth_method'] = "tp";
        tp_login();
        break;

    case "tyc":
        $_SESSION['auth_method'] = "tyc";
        hlc_login('tyc', "https://openid.tyc.edu.tw");
        break;

    case "ttct":
        $_SESSION['auth_method'] = "ttct";
        hlc_login('ttct', "http://openid.boe.ttct.edu.tw");
        break;

    case "ntpc":
        $_SESSION['auth_method'] = "ntpc";
        hlc_login('ntpc', "https://openid.ntpc.edu.tw");
        break;

    case "phc":
        $_SESSION['auth_method'] = "phc";
        tc_login("phc", "http://openid.phc.edu.tw");
        break;

    case "kl":
        $_SESSION['auth_method'] = "kl";
        kl_login();
        break;

    case "ilc":
        $_SESSION['auth_method'] = "ilc";
        ilc_login();
        break;

    case "kh":
        $_SESSION['auth_method'] = "kh";
        kh_login();
        break;

    case "km":
        $_SESSION['auth_method'] = "km";
        km_login();
        break;

    case "mt":
        $_SESSION['auth_method'] = "mt";
        mt_login();
        break;

    default:
        if ($_SESSION['auth_method'] == "facebook") {
            facebook_login();
        } elseif ($_SESSION['auth_method'] == "google") {
            google_login();
        } elseif ($_SESSION['auth_method'] == "google_v2") {
            google_v2_login();
        } elseif ($_SESSION['auth_method'] == "twitter") {
            twitter_login();
        } elseif ($_SESSION['auth_method'] == "yahoo") {
            yahoo_login();
        } elseif ($_SESSION['auth_method'] == "myid") {
            myid_login();
        } elseif ($_SESSION['auth_method'] == "tn") {
            tn_login();
        } elseif ($_SESSION['auth_method'] == "kl") {
            kl_login();
        } elseif ($_SESSION['auth_method'] == "ilc") {
            ilc_login();
        } elseif ($_SESSION['auth_method'] == "cyc") {
            tc_login("cyc", 'http://openid.cyccc.tw');
        } elseif ($_SESSION['auth_method'] == "ylc") {
            tc_login("ylc", "http://openid.ylc.edu.tw");
        } elseif ($_SESSION['auth_method'] == "hcc") {
            tc_login("hcc", "http://openid.hcc.edu.tw");
        } elseif ($_SESSION['auth_method'] == "hc") {
            hc_login();
        } elseif ($_SESSION['auth_method'] == "mlc") {
            tc_login("mlc", "http://openid.mlc.edu.tw");
        } elseif ($_SESSION['auth_method'] == "chc") {
            tc_login("chc", "http://openid.chc.edu.tw");
        } elseif ($_SESSION['auth_method'] == "tp") {
            tp_login();
        } elseif ($_SESSION['auth_method'] == "tyc") {
            hlc_login('tyc', "http://openid.tyc.edu.tw");
        } elseif ($_SESSION['auth_method'] == "ttct") {
            hlc_login('ttct', "http://openid.boe.ttct.edu.tw");
        } elseif ($_SESSION['auth_method'] == "ntct") {
            tc_login("ntct", "http://openid.ntct.edu.tw");
        } elseif ($_SESSION['auth_method'] == "cy") {
            tc_login("cy", "http://openid.cy.edu.tw");
        } elseif ($_SESSION['auth_method'] == "tc") {
            tc_login("tc", "http://openid.tc.edu.tw");
        } elseif ($_SESSION['auth_method'] == "ntpc") {
            hlc_login('ntpc', "http://openid.ntpc.edu.tw");
        } elseif ($_SESSION['auth_method'] == "hlc") {
            hlc_login('hlc', "http://openid.hlc.edu.tw");
        } elseif ($_SESSION['auth_method'] == "ptc") {
            tc_login("ptc", "http://openid.ptc.edu.tw");
        } elseif ($_SESSION['auth_method'] == "phc") {
            tc_login("phc", "http://openid.phc.edu.tw");
        } elseif ($_SESSION['auth_method'] == "kh") {
            kh_login();
        } elseif ($_SESSION['auth_method'] == "km") {
            km_login();
        } elseif ($_SESSION['auth_method'] == "mt") {
            mt_login();
        }

        //注意，不能刪
        if (in_array('facebook', $xoopsModuleConfig['auth_method'])) {
            facebook_login();
        }
        if (in_array('google', $xoopsModuleConfig['auth_method'])) {
            google_login();
        }

        $xoopsTpl->assign('auth_method', $xoopsModuleConfig['auth_method']);
        break;
}

$xoopsTpl->assign("toolbar", toolbar_bootstrap($interface_menu));
$xoopsTpl->assign("jquery", get_jquery(true));
$xoopsTpl->assign("isAdmin", $isAdmin);

$_SESSION['login_from'] = $_SERVER["HTTP_REFERER"];
include_once XOOPS_ROOT_PATH . '/footer.php';

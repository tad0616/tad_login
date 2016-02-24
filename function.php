<?php
//引入TadTools的函式庫
if (!file_exists(XOOPS_ROOT_PATH . "/modules/tadtools/tad_function.php")) {
    redirect_header("http://campus-xoops.tn.edu.tw/modules/tad_modules/index.php?module_sn=1", 3, _TAD_NEED_TADTOOLS);
}
include_once XOOPS_ROOT_PATH . "/modules/tadtools/tad_function.php";

/********************* 自訂函數 *********************/

//FB登入
if (!function_exists('facebook_login')) {
    function facebook_login($mode = "")
    {
        global $xoopsConfig, $xoopsDB, $xoopsTpl, $xoopsUser;
        require_once 'class/facebook.php';

        if ($xoopsUser) {
            header("location:" . XOOPS_URL . "/user.php");
            exit;
        }

        if (isset($_POST)) {
            foreach ($_POST as $k => $v) {
                ${$k} = $v;
            }
        }
        if (isset($_GET['op'])) {
            $op = trim($_GET['op']);
            if (isset($_GET['uid'])) {
                $uid = (int) ($_GET['uid']);
            }
        }

        $modhandler      = &xoops_gethandler('module');
        $tad_loginModule = &$modhandler->getByDirname("tad_login");
        $config_handler  = &xoops_gethandler('config');
        $tad_loginConfig = &$config_handler->getConfigsByCat(0, $tad_loginModule->getVar('mid'));

        $facebook = new Facebook(array(
            'appId'  => $tad_loginConfig['appId'],
            'secret' => $tad_loginConfig['secret'],
        ));

        $user = $facebook->getUser();

        if ($user) {
            try {
                // Proceed knowing you have a logged in user who's authenticated.
                $user_profile = $facebook->api('/me');
            } catch (FacebookApiException $e) {
                error_log($e);
                $user = null;
            }
        }
        //die(var_export($user_profile));

        // Login or logout url will be needed depending on current user state.
        if ($user) {
            $myts  = &MyTextsanitizer::getInstance();
            $uid   = $user_profile['id'];
            $uname = empty($user_profile['username']) ? $user_profile['id'] . "_fb" : $user_profile['username'] . "_fb";
            $name  = $myts->addSlashes($user_profile['name']);
            $email = $user_profile['email'];
            $bio   = $myts->addSlashes($user_profile['bio']);
            $url   = formatURL($user_profile['link']);
            $form  = $myts->addSlashes($user_profile['hometown']['name']);
            $sig   = $myts->addSlashes($user_profile['quotes']);
            $occ   = $myts->addSlashes($user_profile['work'][0]['employer']['name']);

            login_xoops($uname, $name, $email, "", "", $url, $form, $sig, $occ, $bio);
        } else {
            //$args = array('scope' => 'email');
            //$loginUrl = $facebook->getLoginUrl($args);
            $loginUrl = $facebook->getLoginUrl(array(
                'scope' => 'email',
                //,'redirect_uri' => XOOPS_URL
            ));
        }
        if ($mode == "return") {
            return $loginUrl;
        } else {
            $xoopsTpl->assign('facebook', $loginUrl);
        }
    }
}

//google登入
if (!function_exists('google_login')) {
    function google_login($mode = "")
    {
        global $xoopsConfig, $xoopsDB, $xoopsTpl, $xoopsUser;

        require_once XOOPS_ROOT_PATH . '/modules/tad_login/class/google/Google_Client.php';
        require_once XOOPS_ROOT_PATH . '/modules/tad_login/class/google/contrib/Google_Oauth2Service.php';

        if ($xoopsUser) {
            header("location:" . XOOPS_URL . "/user.php");
            exit;
        }

        if (isset($_POST)) {
            foreach ($_POST as $k => $v) {
                ${$k} = $v;
            }
        }
        if (isset($_GET['op'])) {
            $op = trim($_GET['op']);
            if (isset($_GET['uid'])) {
                $uid = (int) ($_GET['uid']);
            }
        }

        $client = new Google_Client();
        $client->setApplicationName("Google UserInfo PHP Starter Application");
        $oauth2 = new Google_Oauth2Service($client);

        if (isset($_GET['code'])) {
            $client->authenticate($_GET['code']);
            $_SESSION['token'] = $client->getAccessToken();
            $redirect          = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'];
            header('Location: ' . filter_var($redirect, FILTER_SANITIZE_URL));

            return;
        }

        if (isset($_SESSION['token'])) {
            $client->setAccessToken($_SESSION['token']);
        }

        if (isset($_REQUEST['logout'])) {
            unset($_SESSION['token']);
            $client->revokeToken();
        }

        if ($client->getAccessToken()) {
            $user = $oauth2->userinfo->get();
            //die(var_export($user));
            // These fields are currently filtered through the PHP sanitize filters.
            // See http://www.php.net/manual/en/filter.filters.sanitize.php
            $email = filter_var($user['email'], FILTER_SANITIZE_EMAIL);
            $img   = filter_var($user['picture'], FILTER_VALIDATE_URL);

            if ($user) {
                $myts                 = &MyTextsanitizer::getInstance();
                $uid                  = $user['id'];
                list($goog_uname, $m) = explode("@", $user['email']);
                $uname                = empty($goog_uname) ? $user['id'] . "_goo" : $goog_uname . "_goo";
                $name                 = $myts->addSlashes($user['name']);
                $email                = $user['email'];
                $bio                  = '';
                $url                  = formatURL($user['link']);
                $form                 = '';
                $sig                  = '';
                $occ                  = '';

                login_xoops($uname, $name, $email, "", "", $url, $form, $sig, $occ, $bio);
            }

            // The access token may have been updated lazily.
            $_SESSION['token'] = $client->getAccessToken();
        } else {
            $authUrl = $client->createAuthUrl();
            if ($mode == "return") {
                return $authUrl;
            } else {
                $xoopsTpl->assign('google', $authUrl);
            }
        }
    }
}

//搜尋有無相同username資料
if (!function_exists('login_xoops')) {
    function login_xoops($uname = "", $name = "", $email = "", $SchoolCode = "", $JobName = "", $url = "", $form = "", $sig = "", $occ = "", $bio = "")
    {
        global $xoopsModuleConfig, $xoopsConfig, $xoopsDB, $xoopsUser;

        $member_handler = &xoops_gethandler('member');

        if ($member_handler->getUserCount(new Criteria('uname', $uname)) > 0) {
            //若已有此帳號！
            $uname = trim($uname);
            $pass  = getPass($uname);

            if ($uname == '' || $pass == '') {
                redirect_header(XOOPS_URL . '/user.php', 1, _MD_TNOPENID_INCORRECTLOGIN);
                exit();
            }

            $member_handler = &xoops_gethandler('member');
            xoops_loadLanguage('auth');

            include_once $GLOBALS['xoops']->path('class/auth/authfactory.php');

            $xoopsAuth = &XoopsAuthFactory::getAuthConnection($uname);
            //自動登入
            $user = $xoopsAuth->authenticate($uname, $pass);

            //若登入成功
            if (false != $user) {

                add2group($user->getVar('uid'), $email, $SchoolCode, $JobName);

                if (0 == $user->getVar('level')) {
                    redirect_header(XOOPS_URL . '/index.php', 5, _MD_TNOPENID_NOACTTPADM);
                    exit();
                }
                //若網站關閉
                if ($xoopsConfig['closesite'] == 1) {
                    $allowed = false;
                    foreach ($user->getGroups() as $group) {
                        if (in_array($group, $xoopsConfig['closesite_okgrp']) || XOOPS_GROUP_ADMIN == $group) {
                            $allowed = true;
                            break;
                        }
                    }
                    if (!$allowed) {
                        redirect_header(XOOPS_URL . '/index.php', 1, _MD_TNOPENID_NOPERM);
                        exit();
                    }
                }
                //設定最後登入時間
                $user->setVar('last_login', time());
                $user->setVar("user_from", $from);
                // $user->setVar("url", formatURL($url));
                $user->setVar("user_sig", $sig);
                $user->setVar("user_icq", $JobName);
                $user->setVar("bio", $bio);
                $user->setVar("user_occ", $occ);
                $user->setVar("user_intrest", $SchoolCode);

                if (!$member_handler->insertUser($user)) {
                }
                // Regenrate a new session id and destroy old session
                $GLOBALS["sess_handler"]->regenerate_id(true);
                $_SESSION                    = array();
                $_SESSION['xoopsUserId']     = $user->getVar('uid');
                $_SESSION['xoopsUserGroups'] = $user->getGroups();
                $user_theme                  = $user->getVar('theme');
                if (in_array($user_theme, $xoopsConfig['theme_set_allowed'])) {
                    $_SESSION['xoopsUserTheme'] = $user_theme;
                }

                // Set cookie for rememberme
                if (!empty($xoopsConfig['usercookie'])) {
                    if (!empty($_POST["rememberme"])) {
                        setcookie($xoopsConfig['usercookie'], $_SESSION['xoopsUserId'] . '-' . md5($user->getVar('pass') . XOOPS_DB_NAME . XOOPS_DB_PASS . XOOPS_DB_PREFIX), time() + 31536000, '/', XOOPS_COOKIE_DOMAIN, 0);
                    } else {
                        setcookie($xoopsConfig['usercookie'], 0, -1, '/', XOOPS_COOKIE_DOMAIN, 0);
                    }
                }
                //若有要轉頁
                if (!empty($_POST['xoops_redirect']) && !strpos($_POST['xoops_redirect'], 'register')) {
                    $_POST['xoops_redirect'] = trim($_POST['xoops_redirect']);
                    $parsed                  = parse_url(XOOPS_URL);
                    $url                     = isset($parsed['scheme']) ? $parsed['scheme'] . '://' : 'http://';
                    if (isset($parsed['host'])) {
                        $url .= $parsed['host'];
                        if (isset($parsed['port'])) {
                            $url .= ':' . $parsed['port'];
                        }
                    } else {
                        $url .= $_SERVER['HTTP_HOST'];
                    }
                    if (@$parsed['path']) {
                        if (strncmp($parsed['path'], $_POST['xoops_redirect'], strlen($parsed['path']))) {
                            $url .= $parsed['path'];
                        }
                    }
                    $url .= $_POST['xoops_redirect'];
                } else {
                    $url = XOOPS_URL . '/index.php';
                }

                // RMV-NOTIFY
                // Perform some maintenance of notification records
                $notification_handler = &xoops_gethandler('notification');
                $notification_handler->doLoginMaintenance($user->getVar('uid'));

                redirect_header($url, 1, sprintf("", $user->getVar('uname')), false);
            } else {
                if (empty($_POST['xoops_redirect'])) {
                    //若登入失敗且無轉頁
                    redirect_header(XOOPS_URL . '/user.php', 5, $xoopsAuth->getHtmlErrors());
                } else {
                    //若登入失敗且有轉頁
                    redirect_header(XOOPS_URL . '/user.php?xoops_redirect=' . urlencode(trim($_POST['xoops_redirect'])), 5, $xoopsAuth->getHtmlErrors(), false);
                }
            }
        } else {

            $pass    = randStr(128);
            $newuser = &$member_handler->createUser();
            $newuser->setVar("user_viewemail", 1);
            $newuser->setVar("attachsig", 0);
            $newuser->setVar("name", $name);
            $newuser->setVar("uname", $uname);
            $newuser->setVar("email", $email);
            $newuser->setVar("url", formatURL($url));
            $newuser->setVar("user_avatar", 'avatars/blank.gif');
            $newuser->setVar('user_regdate', time());
            $newuser->setVar("user_icq", $JobName);
            $newuser->setVar("user_from", $from);
            $newuser->setVar("user_sig", $sig);
            $newuser->setVar("theme", $xoopsConfig['theme_set']);
            $newuser->setVar("user_yim", "");
            $newuser->setVar("user_msnm", "");
            $newuser->setVar("pass", md5($pass));
            $newuser->setVar("timezone_offset", $xoopsConfig['default_TZ']);
            $newuser->setVar("uorder", $xoopsConfig['com_order']);
            $newuser->setVar("umode", $xoopsConfig['com_mode']);
            // RMV-NOTIFY
            $newuser->setVar("notify_method", 1);
            $newuser->setVar("notify_mode", 1);
            $newuser->setVar("bio", $bio);
            $newuser->setVar("rank", 1);
            $newuser->setVar("level", 1);
            //$newuser->setVar("user_occ", $myts->addSlashes($user_profile['work'][0]['employer']['name']));
            $newuser->setVar("user_intrest", $SchoolCode);
            $newuser->setVar('user_mailok', true);
            if (!$member_handler->insertUser($newuser, 1)) {
                $main = _MD_TADLOGIN_CNRNU;
            }

            $sql = "INSERT INTO `" . $xoopsDB->prefix('groups_users_link') . "`  (groupid, uid) VALUES  (2, " . $newuser->getVar('uid') . ")";
            $xoopsDB->queryF($sql) or web_error($sql);

            $sql = "replace into `" . $xoopsDB->prefix('tad_login_random_pass') . "` (`uname` , `random_pass`) values  ('{$uname}','{$pass}')";
            $xoopsDB->queryF($sql) or web_error($sql);

            login_xoops($uname, $name, $email, $SchoolCode, $JobName, $url, $form, $sig, $occ, $bio);
        }
    }
}

if (!function_exists("getPass")) {
    function getPass($uname = "")
    {
        global $xoopsDB;
        if (empty($uname)) {
            return;
        }

        $sql               = "select `random_pass` from `" . $xoopsDB->prefix('tad_login_random_pass') . "` where `uname`='{$uname}'";
        $result            = $xoopsDB->queryF($sql) or web_error($sql);
        list($random_pass) = $xoopsDB->fetchRow($result);

        //舊OpenID使用者
        if (empty($random_pass)) {
            $random_pass = randStr(128);

            $sql = "replace into `" . $xoopsDB->prefix('tad_login_random_pass') . "` (`uname` , `random_pass`) values  ('{$uname}','{$random_pass}')";
            $xoopsDB->queryF($sql) or web_error($sql);

            $sql = "update `" . $xoopsDB->prefix('users') . "` set `pass`=md5('{$random_pass}') where `uname`='{$uname}'";
            $xoopsDB->queryF($sql) or web_error($sql);
        }

        $sql        = "select `pass` from `" . $xoopsDB->prefix('users') . "` where `uname`='{$uname}'";
        $result     = $xoopsDB->queryF($sql) or web_error($sql);
        list($pass) = $xoopsDB->fetchRow($result);
        if ($pass !== md5($random_pass)) {
            $sql = "update `" . $xoopsDB->prefix('users') . "` set `pass`=md5('{$random_pass}') where `uname`='{$uname}'";
            $xoopsDB->queryF($sql) or web_error($sql);
        }

        return $random_pass;
    }
}

if (!function_exists("add2group")) {
    function add2group($uid = "", $email = "", $SchoolCode = "", $JobName = "")
    {
        global $xoopsDB, $xoopsUser;

        // if ($JobName == _MD_TADLOGIN_TEACHER) {
        //     $JobName = "teacher";
        // } elseif ($JobName == _MD_TADLOGIN_STUDENT) {
        //     $JobName = "student";
        // } else {
        //     $JobName = "";
        // }

        $member_handler = &xoops_gethandler('member');
        $user           = &$member_handler->getUser($uid);
        if ($user) {
            $userGroups = $user->getGroups();
        } else {
            header('location:' . XOOPS_URL);
            exit;
        }

        $sql    = "select `item`,`kind`,`group_id` from `" . $xoopsDB->prefix('tad_login_config') . "`";
        $result = $xoopsDB->queryF($sql) or web_error($sql);
        while (list($item, $kind, $group_id) = $xoopsDB->fetchRow($result)) {
            if (!in_array($group_id, $userGroups)) {
                //echo "<h1>{$group_id}-{$item}-{$SchoolCode}-{$email}</h1>";
                if (!empty($SchoolCode) and strpos($item, $SchoolCode) !== false and $JobName == $kind) {
                    $sql = "insert into `" . $xoopsDB->prefix('groups_users_link') . "` (groupid,uid ) values($group_id,$uid)";
                    $xoopsDB->queryF($sql) or web_error($sql);
                    //echo "{$group_id}, {$uid}<br>";
                }

                if (!empty($email) and strpos($item, $email) !== false) {
                    $sql = "insert into `" . $xoopsDB->prefix('groups_users_link') . "` (groupid,uid ) values($group_id,$uid)";
                    $xoopsDB->queryF($sql) or web_error($sql);
                    //echo "{$group_id}, {$uid}<br>";
                }
            }
        }
    }
}

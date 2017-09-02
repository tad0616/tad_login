<?php
//引入TadTools的函式庫
if (!file_exists(XOOPS_ROOT_PATH . "/modules/tadtools/tad_function.php")) {
    redirect_header("http://campus-xoops.tn.edu.tw/modules/tad_modules/index.php?module_sn=1", 3, _TAD_NEED_TADTOOLS);
}
include_once XOOPS_ROOT_PATH . "/modules/tadtools/tad_function.php";

/********************* 自訂函數 *********************/
//教育部登入
if (!function_exists('edu_login')) {
    function edu_login($mode = "")
    {
        global $xoopsConfig, $xoopsDB, $xoopsTpl, $xoopsUser;

        require_once XOOPS_ROOT_PATH . '/modules/tad_login/class/edu/config.php';
        require_once XOOPS_ROOT_PATH . '/modules/tad_login/class/edu/library.class.php';

        define('REDIR_URI0', XOOPS_URL . '/modules/tad_login/index.php');
        //若已經登入
        if ($xoopsUser) {
            header("location:" . XOOPS_URL . "/user.php");
            exit;
        }

        $code  = $_GET['code'];
        $state = $_GET['state'];

        $obj = new openid();
        if (isset($_GET['code'])) {

            $token_ep = TOKEN_ENDPOINT;
            if (DYNAMICAL_ENDPOINT) {
                $token_ep = $ep->getEndPoint()->token_endpoint;
            }

            $acctoken = $obj->getAccessToken($token_ep, $code, REDIR_URI0);
            if (!$acctoken || !isset($acctoken->access_token)) {
                die("無法取得ACCESS TOKEN");
            }

            $_SESSION['access_token'] = $acctoken->access_token;
            $_SESSION['id_token']     = $acctoken->id_token;

            $redirect = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'];
            header('Location: ' . filter_var($redirect, FILTER_SANITIZE_URL));

            return;
        }

        if ($_SESSION['access_token']) {

            $token_ep = USERINFO_ENDPOINT;
            if (DYNAMICAL_ENDPOINT) {
                $token_ep = $ep->getEndPoint()->userinfo_endpoint;
            }

            $user = $obj->getUserinfo($token_ep, $_SESSION['access_token'], true);

            die(var_export($user));
            $email = filter_var($user['email'], FILTER_SANITIZE_EMAIL);
            $img   = filter_var($user['picture'], FILTER_VALIDATE_URL);

            if ($user) {
                $myts                 = MyTextsanitizer::getInstance();
                $uid                  = $user['id'];
                list($goog_uname, $m) = explode("@", $user['email']);
                $uname                = empty($goog_uname) ? $user['id'] . "_goo" : $goog_uname . "_goo";
                $name                 = $myts->addSlashes($user['name']);
                $email                = $user['email'];
                $bio                  = '';
                $url                  = formatURL($user['link']);
                $from                 = '';
                $sig                  = '';
                $occ                  = '';
                // die(var_export($user));
                login_xoops($uname, $name, $email, "", "", $url, $from, $sig, $occ, $bio);
            }

            $_SESSION['access_token'] = $obj->getAccessToken($token_ep, $code, REDIR_URI0);
        } else {
            $_SESSION['azp_state'] = rand(0, 9999999); //隨機產生state值
            $_SESSION['nonce']     = isset($_SESSION['nonce']) ? $_SESSION['nonce'] : base64_encode($_SESSION['azp_state']);

            $auth_ep = AUTH_ENDPOINT;
            if (DYNAMICAL_ENDPOINT) {
                $auth_ep = $ep->getEndPoint()->authorization_endpoint;
            }
            $link = $auth_ep . "?response_type=code&client_id=" . CLIENT_ID .
            "&redirect_uri=" . urlencode(REDIR_URI0) . "&scope=openid+email+profile&state=" . $_SESSION['azp_state'] .
                "&nonce=" . $_SESSION['nonce'];

            // die(REDIR_URI0);
            if ($mode == "return") {
                return $link;
            } else {
                $xoopsTpl->assign('edu', $link);
            }
        }

    }
}

//FB登入
if (!function_exists('facebook_login')) {
    function facebook_login($mode = "")
    {
        global $xoopsConfig, $xoopsDB, $xoopsTpl, $xoopsUser;
        if (PHP_VERSION_ID < 50400) {
            return false;
        }
        require_once XOOPS_ROOT_PATH . '/modules/tad_login/class/Facebook/autoload.php';

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

        $modhandler      = xoops_gethandler('module');
        $tad_loginModule = $modhandler->getByDirname("tad_login");
        $config_handler  = xoops_gethandler('config');
        $tad_loginConfig = $config_handler->getConfigsByCat(0, $tad_loginModule->getVar('mid'));

        $fb = new Facebook\Facebook(array(
            'app_id'                => $tad_loginConfig['appId'], // Replace {app-id} with your app id
            'app_secret'            => $tad_loginConfig['secret'],
            'default_graph_version' => 'v2.2',
        ));

        // $user_profile = '';
        // if ($_SESSION['fb_access_token']) {
        //     die('fb_access_token:' . $_SESSION['fb_access_token']);
        //     try {
        //         // Returns a `Facebook\FacebookResponse` object
        //         $response = $fb->get('/me?fields=id,name,email', $_SESSION['fb_access_token']);
        //     } catch (Facebook\Exceptions\FacebookResponseException $e) {
        //         echo 'Graph returned an error: ' . $e->getMessage();
        //         exit;
        //     } catch (Facebook\Exceptions\FacebookSDKException $e) {
        //         echo 'Facebook SDK returned an error: ' . $e->getMessage();
        //         exit;
        //     }

        //     $user_profile = $response->getGraphUser();
        // }
        /*
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
         */

        // Login or logout url will be needed depending on current user state.
        if ($user_profile) {
            // die(var_export($user_profile));
            // $myts  = MyTextsanitizer::getInstance();
            // $uid   = $user_profile['id'];
            // $uname = empty($user_profile['username']) ? $user_profile['id'] . "_fb" : $user_profile['username'] . "_fb";
            // $name  = $myts->addSlashes($user_profile['name']);
            // $email = $user_profile['email'];
            // $bio   = $myts->addSlashes($user_profile['bio']);
            // $url   = formatURL($user_profile['link']);
            // $from  = $myts->addSlashes($user_profile['hometown']['name']);
            // $sig   = $myts->addSlashes($user_profile['quotes']);
            // $occ   = $myts->addSlashes($user_profile['work'][0]['employer']['name']);

            // login_xoops($uname, $name, $email, "", "", $url, $from, $sig, $occ, $bio);
        } else {
            // $loginUrl = $facebook->getLoginUrl(array(
            //     'scope' => 'email',
            // ));

            $helper = $fb->getRedirectLoginHelper();
            // $_SESSION['FBRLH_state'] = $_GET['state'];
            // die($_GET['state']);
            $permissions = array('email'); // Optional permissions
            $loginUrl    = $helper->getLoginUrl(XOOPS_URL . '/modules/tad_login/fb-callback.php', $permissions);

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
        // die(var_export($_REQUEST['code']));
        if (isset($_GET['code'])) {
            // die("system testing...1");
            $client->authenticate($_GET['code']);
            $_SESSION['token'] = $client->getAccessToken();
            $redirect          = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'];
            header('Location: ' . filter_var($redirect, FILTER_SANITIZE_URL));

            return;
        }

        if (isset($_SESSION['token'])) {
            // die("system testing...2");
            $client->setAccessToken($_SESSION['token']);
        }

        if (isset($_REQUEST['logout'])) {
            // die("system testing...3");
            unset($_SESSION['token']);
            $client->revokeToken();
        }

        if ($client->getAccessToken()) {
            // die("system testing...4");
            $user = $oauth2->userinfo->get();
            // die(var_export($user));
            // These fields are currently filtered through the PHP sanitize filters.
            // See http://www.php.net/manual/en/filter.filters.sanitize.php
            $email = filter_var($user['email'], FILTER_SANITIZE_EMAIL);
            $img   = filter_var($user['picture'], FILTER_VALIDATE_URL);

            if ($user) {
                $myts                 = MyTextsanitizer::getInstance();
                $uid                  = $user['id'];
                list($goog_uname, $m) = explode("@", $user['email']);
                $uname                = empty($goog_uname) ? $user['id'] . "_goo" : $goog_uname . "_goo";
                $name                 = $myts->addSlashes($user['name']);
                $email                = $user['email'];
                $bio                  = '';
                $url                  = formatURL($user['link']);
                $from                 = '';
                $sig                  = '';
                $occ                  = '';
                // die(var_export($user));
                login_xoops($uname, $name, $email, "", "", $url, $from, $sig, $occ, $bio);
            }

            // The access token may have been updated lazily.
            $_SESSION['token'] = $client->getAccessToken();
        } else {
            $client->setApprovalPrompt("auto");
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
    function login_xoops($uname = "", $name = "", $email = "", $SchoolCode = "", $JobName = "", $url = "", $from = "", $sig = "", $occ = "", $bio = "", $aim = "", $yim = "", $msnm = "")
    {
        global $xoopsModuleConfig, $xoopsConfig, $xoopsDB, $xoopsUser;
        $member_handler = xoops_gethandler('member');

        if ($member_handler->getUserCount(new Criteria('uname', $uname)) > 0) {
            //若已有此帳號！
            $uname = trim($uname);
            // die($uname);
            $pass = getPass($uname);

            if ($uname == '' || $pass == '') {
                redirect_header(XOOPS_URL . '/user.php', 1, _MD_TNOPENID_INCORRECTLOGIN);
                exit();
            }

            $member_handler = xoops_gethandler('member');
            xoops_loadLanguage('auth');

            include_once $GLOBALS['xoops']->path('class/auth/authfactory.php');

            $xoopsAuth = XoopsAuthFactory::getAuthConnection($uname);
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
                $user->setVar("url", formatURL($url));
                $user->setVar("user_sig", $sig);
                $user->setVar("user_icq", $JobName);
                $user->setVar("bio", $bio);
                if ($SchoolCode) {
                    $user->setVar("user_occ", $occ);
                    $user->setVar("user_intrest", $SchoolCode);
                }

                if (!$member_handler->insertUser($user, true)) {
                }

                $login_from = $_SESSION['login_from'];

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
                    setcookie($xoopsConfig['usercookie'], 0, -1, '/', XOOPS_COOKIE_DOMAIN, 0);
                }
                //若有要轉頁
                if (!empty($xoopsModuleConfig['redirect_url'])) {
                    $redirect_url = $xoopsModuleConfig['redirect_url'];
                } else {
                    $redirect_url = empty($login_from) ? XOOPS_URL . '/index.php' : $login_from;
                }

                // RMV-NOTIFY
                // Perform some maintenance of notification records
                $notification_handler = xoops_gethandler('notification');
                $notification_handler->doLoginMaintenance($user->getVar('uid'));

                redirect_header($redirect_url, 1, sprintf("", $user->getVar('uname')), false);
            } else {
                redirect_header(XOOPS_URL . '/user.php', 5, $xoopsAuth->getHtmlErrors());
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
            // $newuser->setVar("user_yim", $yim);
            // $newuser->setVar("user_aim", $aim);
            // $newuser->setVar("user_msnm", $msnm);
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
                redirect_header(XOOPS_URL, 5, _MD_TADLOGIN_CNRNU);
            }

            $uid = $newuser->getVar('uid');

            if ($uid) {

                $sql = "INSERT INTO `" . $xoopsDB->prefix('groups_users_link') . "`  (groupid, uid) VALUES  (2, " . $uid . ")";
                $xoopsDB->queryF($sql) or web_error($sql);

                $sql = "replace into `" . $xoopsDB->prefix('tad_login_random_pass') . "` (`uname` , `random_pass`) values  ('{$uname}','{$pass}')";
                $xoopsDB->queryF($sql) or web_error($sql);

                login_xoops($uname, $name, $email, $SchoolCode, $JobName, $url, $from, $sig, $occ, $bio, $aim, $yim, $msnm);
            } else {
                redirect_header(XOOPS_URL, 5, _MD_TADLOGIN_CNRNU);
            }
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

        $member_handler = xoops_gethandler('member');
        $user           = &$member_handler->getUser($uid);
        if ($user) {
            $userGroups = $user->getGroups();
        } else {
            header('location:' . XOOPS_URL);
            exit;
        }

        $sql = "SELECT `item`,`kind`,`group_id` FROM `" . $xoopsDB->prefix('tad_login_config') . "`";
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

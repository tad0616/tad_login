<?php

namespace XoopsModules\Tad_login;

use XoopsModules\Tadtools\Utility;

class Tools
{
    public static $all_oidc = [
        'edu_oidc' => [
            'tail' => 'edu',
            'provideruri' => 'https://oidc.tanet.edu.tw',
            'eduinfoep' => 'https://oidc.tanet.edu.tw/moeresource/api/v1/oidc/eduinfo',
            'scope' => ['openid', 'email', 'profile', 'openid2'],
            'gzipenable' => true,
            'from' => '',
        ],
        'moe_oidc' => [
            'tail' => 'moe',
            'provideruri' => 'https://moe.sso.edu.tw',
            'eduinfoep' => 'https://moe.sso.edu.tw/cncresource/api/v1/eduinfo',
            'scope' => ['educloudroles', 'openid', 'profile', 'eduinfo', 'openid2', 'email'],
            'gzipenable' => false,
            'from' => '',
        ],
        'kl_oidc' => [
            'tail' => 'kl',
            'provideruri' => 'https://kl.sso.edu.tw',
            'eduinfoep' => 'https://kl.sso.edu.tw/cncresource/api/v1/eduinfo',
            'scope' => ['educloudroles', 'openid', 'profile', 'eduinfo', 'openid2', 'email'],
            'gzipenable' => false,
            'from' => '基隆市',
        ],
        // 'tp_oidc' => [
        //     'tail' => 'tp',
        //     'provideruri' => 'https://tp.sso.edu.tw',
        //     'eduinfoep' => 'https://tp.sso.edu.tw/cncresource/api/v1/eduinfo',
        //     'scope' => ['educloudroles', 'openid', 'profile', 'eduinfo', 'openid2', 'email'],
        //     'gzipenable' => false,
        //     'from' => '臺北市',
        // ],
        'ntpc_oidc' => [
            'tail' => 'ntpc',
            'provideruri' => 'https://ntpc.sso.edu.tw',
            'eduinfoep' => 'https://ntpc.sso.edu.tw/cncresource/api/v1/eduinfo',
            'scope' => ['educloudroles', 'openid', 'profile', 'eduinfo', 'openid2', 'email'],
            'gzipenable' => false,
            'from' => '新北市',
        ],
        'ty_oidc' => [
            'tail' => 'ty',
            'provideruri' => 'https://tyc.sso.edu.tw',
            'eduinfoep' => 'https://tyc.sso.edu.tw/cncresource/api/v1/eduinfo',
            'scope' => ['openid', 'openid2', 'email', 'profile', 'eduinfo'],
            'gzipenable' => false,
            'from' => '桃園市',
        ],
        'hc_oidc' => [
            'tail' => 'hc',
            'provideruri' => 'https://hc.sso.edu.tw',
            'eduinfoep' => 'https://hc.sso.edu.tw/cncresource/api/v1/eduinfo',
            'scope' => ['educloudroles', 'openid', 'profile', 'eduinfo', 'openid2', 'email'],
            'gzipenable' => false,
            'from' => '新竹市',
        ],
        'hcc_oidc' => [
            'tail' => 'hcc',
            'provideruri' => 'https://hcc.sso.edu.tw',
            'eduinfoep' => 'https://hcc.sso.edu.tw/cncresource/api/v1/eduinfo',
            'scope' => ['educloudroles', 'openid', 'profile', 'eduinfo', 'openid2', 'email'],
            'gzipenable' => false,
            'from' => '新竹縣',
        ],
        'mlc_oidc' => [
            'tail' => 'mlc',
            'provideruri' => 'https://mlc.sso.edu.tw',
            'eduinfoep' => 'https://mlc.sso.edu.tw/cncresource/api/v1/eduinfo',
            'scope' => ['educloudroles', 'openid', 'profile', 'eduinfo', 'openid2', 'email'],
            'gzipenable' => false,
            'from' => '苗栗縣',
        ],
        'tc_oidc' => [
            'tail' => 'tc',
            'provideruri' => 'https://tc.sso.edu.tw',
            'eduinfoep' => 'https://tc.sso.edu.tw/cncresource/api/v1/eduinfo',
            'scope' => ['educloudroles', 'openid', 'profile', 'eduinfo', 'openid2', 'email'],
            'gzipenable' => false,
            'from' => '臺中市',
        ],
        'chc_oidc' => [
            'tail' => 'chc',
            'provideruri' => 'https://chc.sso.edu.tw',
            'eduinfoep' => 'https://chc.sso.edu.tw/cncresource/api/v1/eduinfo',
            'scope' => ['educloudroles', 'openid', 'profile', 'eduinfo', 'openid2', 'email'],
            'gzipenable' => false,
            'from' => '彰化縣',
        ],
        'ntct_oidc' => [
            'tail' => 'ntct',
            'provideruri' => 'https://ntct.sso.edu.tw',
            'eduinfoep' => 'https://ntct.sso.edu.tw/cncresource/api/v1/eduinfo',
            'scope' => ['educloudroles', 'openid', 'profile', 'eduinfo', 'openid2', 'email'],
            'gzipenable' => false,
            'from' => '南投縣',
        ],
        'ylc_oidc' => [
            'tail' => 'ylc',
            'provideruri' => 'https://ylc.sso.edu.tw',
            'eduinfoep' => 'https://ylc.sso.edu.tw/cncresource/api/v1/eduinfo',
            'scope' => ['educloudroles', 'openid', 'profile', 'eduinfo', 'openid2', 'email'],
            'gzipenable' => false,
            'from' => '雲林縣',
        ],
        'cyc_oidc' => [
            'tail' => 'cyc',
            'provideruri' => 'https://cyc.sso.edu.tw',
            'eduinfoep' => 'https://cyc.sso.edu.tw/cncresource/api/v1/eduinfo',
            'scope' => ['educloudroles', 'openid', 'profile', 'eduinfo', 'openid2', 'email'],
            'gzipenable' => false,
            'from' => '嘉義縣',
        ],
        // 'cy_oidc' => [
        //     'tail' => 'cy',
        //     'provideruri' => 'https://cy.sso.edu.tw',
        //     'eduinfoep' => 'https://cy.sso.edu.tw/cncresource/api/v1/eduinfo',
        //     'scope' => ['educloudroles', 'openid', 'profile', 'eduinfo', 'openid2', 'email'],
        //     'gzipenable' => false,
        //     'from'=>'嘉義市',
        // ],
        'kh_oidc' => [
            'tail' => 'kh',
            'gzipenable' => false,
            'scope' => ['openid', 'profile', 'email', 'kh_profile', 'kh_titles'],
            'providerparams' => ['token_endpoint_auth_methods_supported' => ["client_secret_post"]],
            'ignore_userinfo' => true,
            'provideruri' => 'https://oidc.kh.edu.tw',
            'from' => '高雄市',
        ],
        'ptc_oidc' => [
            'tail' => 'ptc',
            'provideruri' => 'https://ptc.sso.edu.tw',
            'eduinfoep' => 'https://ptc.sso.edu.tw/cncresource/api/v1/eduinfo',
            'scope' => ['educloudroles', 'openid', 'profile', 'eduinfo', 'openid2', 'email'],
            'gzipenable' => false,
            'from' => '屏東縣',
        ],
        'ilc_oidc' => [
            'tail' => 'ilc',
            'provideruri' => 'https://ilc.sso.edu.tw',
            'eduinfoep' => 'https://ilc.sso.edu.tw/cncresource/api/v1/eduinfo',
            'scope' => ['educloudroles', 'openid', 'profile', 'eduinfo', 'openid2', 'email'],
            'gzipenable' => false,
            'from' => '宜蘭縣',
        ],
        'hlc_oidc' => [
            'tail' => 'hlc',
            'provideruri' => 'https://hlc.sso.edu.tw',
            'eduinfoep' => 'https://hlc.sso.edu.tw/cncresource/api/v1/eduinfo',
            'scope' => ['educloudroles', 'openid', 'profile', 'eduinfo', 'openid2', 'email'],
            'gzipenable' => false,
            'from' => '花蓮縣',
        ],
        'ttct_oidc' => [
            'tail' => 'ttct',
            'provideruri' => 'https://ttct.sso.edu.tw',
            'eduinfoep' => 'https://ttct.sso.edu.tw/cncresource/api/v1/eduinfo',
            'scope' => ['educloudroles', 'openid', 'profile', 'eduinfo', 'openid2', 'email'],
            'gzipenable' => false,
            'from' => '臺東縣',
        ],
        'phc_oidc' => [
            'tail' => 'phc',
            'provideruri' => 'https://phc.sso.edu.tw',
            'eduinfoep' => 'https://phc.sso.edu.tw/cncresource/api/v1/eduinfo',
            'scope' => ['educloudroles', 'openid', 'profile', 'eduinfo', 'openid2', 'email'],
            'gzipenable' => false,
            'from' => '澎湖縣',
        ],
        'mt_oidc' => [
            'tail' => 'mt',
            'provideruri' => 'https://matsu.sso.edu.tw',
            'eduinfoep' => 'https://matsu.sso.edu.tw/cncresource/api/v1/eduinfo',
            'scope' => ['educloudroles', 'openid', 'profile', 'eduinfo', 'openid2', 'email'],
            'gzipenable' => false,
            'from' => '連江縣',
        ],
    ];

    public static $all_oidc2 = [
        'tp_ldap' => [
            'tail' => 'tp',
        ],
    ];

    public static function change_pass($newpass, $uname = '', $redirect_header = true)
    {
        global $xoopsUser, $xoopsDB;
        if (!$uname) {
            $uname = $xoopsUser->uname();
        }
        if ($uname) {
            $pass = self::authcode($newpass, 'ENCODE', $uname, 0);

            $sql = 'UPDATE `' . $xoopsDB->prefix('users') . '` SET `pass` = md5(?) WHERE `uname` = ?';
            Utility::query($sql, 'ss', [$newpass, $uname]) or Utility::web_error($sql, __FILE__, __LINE__);

            $sql = 'UPDATE `' . $xoopsDB->prefix('tad_login_random_pass') . '` SET `random_pass` = ?, `hashed_date` = NOW() WHERE `uname` = ?';
            Utility::query($sql, 'ss', [$pass, $uname]) or Utility::web_error($sql, __FILE__, __LINE__);

            if ($redirect_header) {
                redirect_header($_SERVER['PHP_SELF'], 3, _MD_TADLOGIN_CHANGE_COMPLETED);
            }
        }
    }

    public static function requestProtectedApi($token_ep = '', $accesstoken = '', $rtn_array = true, $gzipenable = false)
    {
        $header = ["Authorization: Bearer $accesstoken"];
        $options = [
            'http' => [
                'header' => $header,
                'method' => 'GET',
                'content' => '',
            ],
        ];
        $context = stream_context_create($options);
        if ($gzipenable) {
            $result = gzdecode(file_get_contents($token_ep, false, $context));
        } else {
            $result = file_get_contents($token_ep, false, $context);
        }
        $u = json_decode($result, $rtn_array);

        return $u;
    }

    public static function do_post($url, $data)
    {
        $ch = curl_init($url);

        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($ch);
        curl_close($ch);

        return $response;
    }

    //oidc 登入
    public static function edu_login($auth_method = 'edu_oidc', $mode = '')
    {
        $link = XOOPS_URL . '/modules/tad_login/class/edu/auth.php?auth_method=' . $auth_method;
        if ('return' === $mode) {
            return $link;
        }

        header("location: $link");
        // $xoopsTpl->assign($openid, $link);
    }

    //Line登入
    public static function line_login($mode = '')
    {
        global $xoopsModuleConfig, $xoopsTpl, $xoopsUser;

        if ($xoopsUser) {
            header('location:' . XOOPS_URL . '/user.php');
            exit;
        }
        require_once XOOPS_ROOT_PATH . '/modules/tad_login/class/line/ConfigManager.php'; //Line 設定檔 管理器
        require_once XOOPS_ROOT_PATH . '/modules/tad_login/class/line/LineAuthorization.php'; //產生登入網址
        require_once XOOPS_ROOT_PATH . '/modules/tad_login/class/line/LineProfiles.php'; //取得用戶端 Profile
        require_once XOOPS_ROOT_PATH . '/modules/tad_login/class/line/LineController.php'; //LINE控制

        if (!isset($xoopsModuleConfig['line_id'])) {
            $moduleHandler = xoops_getHandler('module');
            $xoopsModule = $moduleHandler->getByDirname('tad_login');
            $configHandler = xoops_getHandler('config');
            $modConfig = $configHandler->getConfigsByCat(0, $xoopsModule->mid());

        } else {
            $modConfig = $xoopsModuleConfig;
        }

        // if (!session_id()) {
        //     session_start();
        // }
        $state = sha1(time());
        // $_SESSION['_line_state'] = $state;

        define("CLIENT_ID", $modConfig['line_id']);
        define("CLIENT_SECRET", $modConfig['line_secret']);
        define("REDIRECT_URI", XOOPS_URL . '/modules/tad_login/line_callback.php'); //登入後返回位置
        define("SCOPE", 'openid%20profile%20email'); //授權範圍以%20分隔 可以有3項openid，profile，email

        $Line = new \LineController();
        $loginUrl = $Line->lineLogin($state); //產生LINE登入連結

        if ('return' === $mode) {
            return $loginUrl;
        } else {
            header("location: $loginUrl");
            exit;
        }
        $xoopsTpl->assign('line', $loginUrl);
    }

    //FB登入
    public static function facebook_login($mode = '')
    {
        global $xoopsTpl, $xoopsUser;
        if (PHP_VERSION_ID < 50400) {
            return false;
        }
        require XOOPS_ROOT_PATH . '/modules/tad_login/class/Facebook/autoload.php';

        if ($xoopsUser) {
            header('location:' . XOOPS_URL . '/user.php');
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

        $moduleHandler = xoops_getHandler('module');
        $tad_loginModule = $moduleHandler->getByDirname('tad_login');
        $configHandler = xoops_getHandler('config');
        $tad_loginConfig = $configHandler->getConfigsByCat(0, $tad_loginModule->getVar('mid'));
        if (class_exists('Facebook\Facebook')) {
            $fb = new Facebook\Facebook([
                'app_id' => $tad_loginConfig['appId'], // Replace {app-id} with your app id
                'app_secret' => $tad_loginConfig['secret'],
                'default_graph_version' => 'v2.11',
            ]);
        }

        $helper = $fb->getRedirectLoginHelper();
        $permissions = ['email']; // Optional permissions
        $loginUrl = $helper->getLoginUrl(XOOPS_URL . '/modules/tad_login/fb-callback.php', $permissions);

        if ('return' === $mode) {
            return $loginUrl;
        }
        $xoopsTpl->assign('facebook', $loginUrl);
    }

    //google登入
    public static function google_login($mode = '')
    {
        global $xoopsTpl, $xoopsUser;

        require_once XOOPS_ROOT_PATH . '/modules/tad_login/class/google/Google_Client.php';
        require_once XOOPS_ROOT_PATH . '/modules/tad_login/class/google/contrib/Google_Oauth2Service.php';

        if ($xoopsUser) {
            header('location:' . XOOPS_URL . '/user.php');
            exit;
        }

        if (isset($_POST)) {
            foreach ($_POST as $k => $v) {
                ${$k} = $v;
            }
        }
        // if (isset($_GET['op'])) {
        //     $op = trim($_GET['op']);
        //     if (isset($_GET['uid'])) {
        //         $uid = (int) ($_GET['uid']);
        //     }
        // }
        $client = new \Google_Client();
        $client->setApplicationName('Google UserInfo PHP Starter Application');
        $oauth2 = new \Google_Oauth2Service($client);

        if (isset($_GET['code'])) {
            // die("system testing...1");
            $client->authenticate($_GET['code']);
            $_SESSION['token'] = $client->getAccessToken();
            $redirect = 'https://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'];
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
            $img = filter_var($user['picture'], FILTER_VALIDATE_URL);
            // Utility::dd($user);
            if ($user) {
                $myts = \MyTextSanitizer::getInstance();
                // $uid = $user['id'];
                list($goog_uname, $m) = explode('@', $user['email']);
                $uname = empty($goog_uname) ? $user['id'] . '_goo' : $goog_uname . '_goo';
                $name = $myts->addSlashes($user['name']);
                $email = $user['email'];
                $bio = '';
                $url = formatURL($user['link']);
                $from = '';
                $sig = '';
                $occ = '';
                // die(var_export($user));
                self::login_xoops($uname, $name, $email, '', '', $url, $from, $sig, $occ, $bio);
            }

            // The access token may have been updated lazily.
            $_SESSION['token'] = $client->getAccessToken();
        } else {
            $client->setApprovalPrompt('auto');
            $authUrl = $client->createAuthUrl();
            if ('return' === $mode) {
                return $authUrl;
            }
            $xoopsTpl->assign('google', $authUrl);
        }
    }

    //搜尋有無相同username資料
    public static function login_xoops($uname = '', $name = '', $email = '', $SchoolCode = '', $JobName = '', $url = '', $from = '', $sig = '', $occ = '', $bio = '', $aim = '', $yim = '', $msnm = '', $user_avatar = 'avatars/blank.gif')
    {
        global $xoopsModuleConfig, $xoopsConfig, $xoopsDB;

        $memberHandler = xoops_getHandler('member');

        if ($memberHandler->getUserCount(new \Criteria('uname', $uname)) > 0) {
            //若已有此帳號！
            $uname = trim($uname);
            $pass = self::getPass($uname);

            if ('' == $uname || '' == $pass) {
                redirect_header(XOOPS_URL . '/user.php', 1, _MD_TNOPENID_INCORRECTLOGIN);
                exit();
            }

            $memberHandler = xoops_getHandler('member');
            xoops_loadLanguage('auth');
            xoops_loadLanguage('user');

            require_once $GLOBALS['xoops']->path('class/auth/authfactory.php');

            $xoopsAuth = \XoopsAuthFactory::getAuthConnection($uname);
            //自動登入
            $user = $xoopsAuth->authenticate($uname, $pass);

            //若登入成功
            if (false !== $user) {
                self::add2group($user->getVar('uid'), $email, $SchoolCode, $JobName);

                if (0 == $user->getVar('level')) {
                    redirect_header(XOOPS_URL . '/index.php', 5, _MD_TNOPENID_NOACTTPADM);
                    exit();
                }
                //若網站關閉
                if (1 == $xoopsConfig['closesite']) {
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
                $user->setVar('user_from', $from);
                $user->setVar('url', formatURL($url));
                $user->setVar('user_sig', $sig);
                $user->setVar('user_icq', $JobName);
                $user->setVar('bio', $bio);
                $user->setVar('user_avatar', $user_avatar);
                if ($SchoolCode) {
                    $user->setVar('user_occ', $occ);
                    $user->setVar('user_intrest', $SchoolCode);
                }

                // Utility::dd($_SESSION);
                if (!$memberHandler->insertUser($user, true)) {
                }

                // Regenrate a new session id and destroy old session
                $GLOBALS['sess_handler']->regenerate_id(true);

                if ($_SESSION['login_from']) {
                    $redirect_url = $_SESSION['login_from'];
                    unset($_SESSION['login_from']);
                }

                $_SESSION = [];
                $_SESSION['xoopsUserId'] = $user->getVar('uid');
                $_SESSION['xoopsUserGroups'] = $user->getGroups();
                $user_theme = $user->getVar('theme');
                if (in_array($user_theme, $xoopsConfig['theme_set_allowed'])) {
                    $_SESSION['xoopsUserTheme'] = $user_theme;
                }

                // Set cookie for rememberme
                if (!empty($xoopsConfig['usercookie'])) {
                    setcookie($xoopsConfig['usercookie'], 0, -1, '/', XOOPS_COOKIE_DOMAIN, true);
                }

                //若有要轉頁
                if (empty($redirect_url)) {
                    if (!empty($xoopsModuleConfig['redirect_url'])) {
                        $redirect_url = $xoopsModuleConfig['redirect_url'];
                    } elseif ($xoopsModuleConfig['bind_openid'] == 1) {
                        $redirect_url = XOOPS_URL . '/modules/tad_login/index.php';
                    } else {
                        $redirect_url = XOOPS_URL . '/index.php';
                    }
                }
                redirect_header($redirect_url, 3, sprintf(_US_LOGGINGU, $user->getVar('name')), false);

            } else {
                redirect_header(XOOPS_URL . '/user.php', 5, $xoopsAuth->getHtmlErrors());
            }
        } else {
            $sql = 'SELECT `CHARACTER_MAXIMUM_LENGTH` FROM `information_schema`.`columns` WHERE `table_schema` = DATABASE() AND `table_name` = ? AND `COLUMN_NAME` = ?';
            $result = Utility::query($sql, 'ss', [$xoopsDB->prefix('users'), 'uname']) or Utility::web_error($sql, __FILE__, __LINE__);

            list($length) = $xoopsDB->fetchRow($result);

            if (mb_strlen($uname) > $length) {
                die(sprintf(_MD_TADLOGIN_UNAME_TOO_LONG, $uname, $length));
            }

            $pass = Utility::randStr(128);
            $newuser = $memberHandler->createUser();
            $newuser->setVar('user_viewemail', 1);
            $newuser->setVar('attachsig', 0);
            $newuser->setVar('name', $name);
            $newuser->setVar('uname', $uname);
            $newuser->setVar('email', $email);
            $newuser->setVar('url', formatURL($url));
            $newuser->setVar('user_avatar', $user_avatar);
            $newuser->setVar('user_regdate', time());
            $newuser->setVar('user_icq', $JobName);
            $newuser->setVar('user_from', $from);
            $newuser->setVar('user_sig', $sig);
            $newuser->setVar('theme', $xoopsConfig['theme_set']);
            // $newuser->setVar("user_yim", $yim);
            // $newuser->setVar("user_aim", $aim);
            // $newuser->setVar("user_msnm", $msnm);
            $newuser->setVar('pass', md5($pass));
            $newuser->setVar('timezone_offset', $xoopsConfig['default_TZ']);
            $newuser->setVar('uorder', $xoopsConfig['com_order']);
            $newuser->setVar('umode', $xoopsConfig['com_mode']);
            // RMV-NOTIFY
            $newuser->setVar('notify_method', 1);
            $newuser->setVar('notify_mode', 1);
            $newuser->setVar('bio', $bio);
            $newuser->setVar('rank', 1);
            $newuser->setVar('level', 1);
            //$newuser->setVar("user_occ", $myts->addSlashes($user_profile['work'][0]['employer']['name']));
            $newuser->setVar('user_intrest', $SchoolCode);
            $newuser->setVar('user_mailok', true);
            if (!$memberHandler->insertUser($newuser, 1)) {
                die(_MD_TADLOGIN_CNRNU);
            }

            $uid = $newuser->getVar('uid');

            if ($uid) {
                $sql = 'INSERT INTO `' . $xoopsDB->prefix('groups_users_link') . '` (`groupid`, `uid`) VALUES (2, ?)';
                Utility::query($sql, 'i', [$uid]) or Utility::web_error($sql, __FILE__, __LINE__);

                $pass = self::authcode($pass, 'ENCODE', $uname);
                $sql = 'REPLACE INTO `' . $xoopsDB->prefix('tad_login_random_pass') . '` (`uname`, `random_pass`) VALUES (?, ?)';
                Utility::query($sql, 'ss', [$uname, $pass]) or Utility::web_error($sql, __FILE__, __LINE__);

                self::login_xoops($uname, $name, $email, $SchoolCode, $JobName, $url, $from, $sig, $occ, $bio, $aim, $yim, $msnm);
            } else {
                redirect_header(XOOPS_URL, 5, _MD_TADLOGIN_CNRNU);
            }
        }
    }

    public static function getPass($uname = '')
    {
        global $xoopsDB;
        if (empty($uname)) {
            return;
        }

        // 取得XOOPS使用者密碼（加密過的）
        $sql = 'SELECT `pass` FROM `' . $xoopsDB->prefix('users') . '` WHERE `uname` = ?';
        $result = Utility::query($sql, 's', [$uname]) or Utility::web_error($sql, __FILE__, __LINE__);

        list($pass) = $xoopsDB->fetchRow($result);

        // 取得綁定密碼
        $sql = 'SELECT `random_pass` FROM `' . $xoopsDB->prefix('tad_login_random_pass') . '` WHERE `uname`=?';
        $result = Utility::query($sql, 's', [$uname]) or Utility::web_error($sql, __FILE__, __LINE__);

        list($random_pass) = $xoopsDB->fetchRow($result);

        //若無綁定密碼，或者綁定密碼為空白
        if (empty($random_pass) or $pass == 'd41d8cd98f00b204e9800998ecf8427e') {
            $random_pass = Utility::randStr(128);
            // 重新產生隨機的綁定密碼
            $pass = md5($random_pass);
            $random_pass = self::authcode($random_pass, 'ENCODE', $uname);

            $sql = 'REPLACE INTO `' . $xoopsDB->prefix('tad_login_random_pass') . '` (`uname`, `random_pass`, `hashed_date`) VALUES (?, ?, "0000-00-00 00:00:00")';
            Utility::query($sql, 'ss', [$uname, $random_pass]) or Utility::web_error($sql, __FILE__, __LINE__);

            $sql = 'UPDATE `' . $xoopsDB->prefix('users') . '` SET `pass`=? WHERE `uname`=?';
            Utility::query($sql, 'ss', [$pass, $uname]) or Utility::web_error($sql, __FILE__, __LINE__);

        }

        $random_pass = self::authcode($random_pass, 'DECODE', $uname);

        if ($pass !== md5($random_pass)) {
            $sql = 'UPDATE `' . $xoopsDB->prefix('users') . '` SET `pass`=MD5(?) WHERE `uname`=?';
            Utility::query($sql, 'ss', [$random_pass, $uname]) or Utility::web_error($sql, __FILE__, __LINE__);

        }

        return $random_pass;
    }

    //非常給力的authcode加密函式,Discuz!經典程式碼(帶詳解)
    //函式authcode($string, $operation, $key, $expiry)中的$string：字串，明文或密文；$operation：DECODE表示解密，其它表示加密；$key：密匙；$expiry：密文有效期。

    private static function authcode($string, $operation = 'DECODE', $key = '', $expiry = 0)
    {
        // 動態密匙長度，相同的明文會生成不同密文就是依靠動態密匙
        $ckey_length = 4;

        // 密匙
        $key = md5($key ? $key : $GLOBALS['discuz_auth_key']);

        // 密匙a會參與加解密
        $keya = md5(substr($key, 0, 16));
        // 密匙b會用來做資料完整性驗證
        $keyb = md5(substr($key, 16, 16));
        // 密匙c用於變化生成的密文
        $keyc = $ckey_length ? ($operation == 'DECODE' ? substr($string, 0, $ckey_length) : substr(md5(microtime()), -$ckey_length)) : '';
        // 參與運算的密匙
        $cryptkey = $keya . md5($keya . $keyc);
        $key_length = strlen($cryptkey);
        // 明文，前10位用來儲存時間戳，解密時驗證資料有效性，10到26位用來儲存$keyb(密匙b)，
        //解密時會通過這個密匙驗證資料完整性
        // 如果是解碼的話，會從第$ckey_length位開始，因為密文前$ckey_length位儲存 動態密匙，以保證解密正確
        $string = $operation == 'DECODE' ? base64_decode(substr($string, $ckey_length)) : sprintf('%010d', $expiry ? $expiry + time() : 0) . substr(md5($string . $keyb), 0, 16) . $string;
        $string_length = strlen($string);
        $result = '';
        $box = range(0, 255);
        $rndkey = array();
        // 產生密匙簿
        for ($i = 0; $i <= 255; $i++) {
            $rndkey[$i] = ord($cryptkey[$i % $key_length]);
        }
        // 用固定的演算法，打亂密匙簿，增加隨機性，好像很複雜，實際上對並不會增加密文的強度
        for ($j = $i = 0; $i < 256; $i++) {
            $j = ($j + $box[$i] + $rndkey[$i]) % 256;
            $tmp = $box[$i];
            $box[$i] = $box[$j];
            $box[$j] = $tmp;
        }
        // 核心加解密部分
        for ($a = $j = $i = 0; $i < $string_length; $i++) {
            $a = ($a + 1) % 256;
            $j = ($j + $box[$a]) % 256;
            $tmp = $box[$a];
            $box[$a] = $box[$j];
            $box[$j] = $tmp;
            // 從密匙簿得出密匙進行異或，再轉成字元
            $result .= chr(ord($string[$i]) ^ ($box[($box[$a] + $box[$j]) % 256]));
        }
        if ($operation == 'DECODE') {
            // 驗證資料有效性，請看未加密明文的格式
            if ((substr($result, 0, 10) == 0 || substr($result, 0, 10) - time() > 0) && substr($result, 10, 16) == substr(md5(substr($result, 26) . $keyb), 0, 16)) {
                return substr($result, 26);
            } else {
                return '';
            }
        } else {
            // 把動態密匙儲存在密文裡，這也是為什麼同樣的明文，生產不同密文後能解密的原因
            // 因為加密後的密文可能是一些特殊字元，複製過程可能會丟失，所以用base64編碼
            return $keyc . str_replace('=', '', base64_encode($result));
        }
    }

    private static function add2group($uid = '', $email = '', $SchoolCode = '', $JobName = '')
    {
        global $xoopsDB;

        $memberHandler = xoops_getHandler('member');
        $user = $memberHandler->getUser($uid);
        if ($user) {
            $userGroups = $user->getGroups();
        } else {
            header('location:' . XOOPS_URL);
            exit;
        }

        $sql = 'SELECT `item`, `kind`, `group_id` FROM `' . $xoopsDB->prefix('tad_login_config') . '`';
        $result = Utility::query($sql) or Utility::web_error($sql, __FILE__, __LINE__);

        while (list($item, $kind, $group_id) = $xoopsDB->fetchRow($result)) {
            if (!in_array($group_id, $userGroups)) {
                //echo "<h1>{$group_id}-{$item}-{$SchoolCode}-{$email}</h1>";
                if (!empty($SchoolCode) and false !== mb_strpos($item, $SchoolCode) and $JobName == $kind) {
                    $sql = 'INSERT INTO `' . $xoopsDB->prefix('groups_users_link') . '` (`groupid`, `uid`) VALUES (?, ?)';
                    Utility::query($sql, 'ii', [$group_id, $uid]) or Utility::web_error($sql, __FILE__, __LINE__);

                }

                if (empty($item) and $JobName == $kind) {
                    $sql = 'INSERT INTO `' . $xoopsDB->prefix('groups_users_link') . '` (`groupid`, `uid`) VALUES (?, ?)';
                    Utility::query($sql, 'ii', [$group_id, $uid]) or Utility::web_error($sql, __FILE__, __LINE__);

                }

                if (!empty($email) and false !== mb_strpos($item, '*')) {
                    $item = trim($item);
                    $new_item = str_replace('*', '', $item);
                    // die($new_item);
                    if (false !== mb_strpos($email, $new_item)) {
                        $sql = 'INSERT INTO `' . $xoopsDB->prefix('groups_users_link') . '` (`groupid`, `uid`) VALUES (?, ?)';
                        Utility::query($sql, 'ii', [$group_id, $uid]) or Utility::web_error($sql, __FILE__, __LINE__);

                    }
                }

                if (!empty($email) and false !== mb_strpos($item, $email)) {
                    $sql = 'INSERT INTO `' . $xoopsDB->prefix('groups_users_link') . '` (`groupid`, `uid`) VALUES (?, ?)';
                    Utility::query($sql, 'ii', [$group_id, $uid]) or Utility::web_error($sql, __FILE__, __LINE__);

                    //echo "{$group_id}, {$uid}<br>";
                }
            }
        }
    }

}

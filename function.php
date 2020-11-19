<?php
use XoopsModules\Tadtools\Utility;

xoops_loadLanguage('main', 'tadtools');

require XOOPS_ROOT_PATH . '/modules/tad_login/oidc.php';

/********************* 自訂函數 ********************
 * @param int $length
 * @return string
 */
if (!function_exists('change_pass')) {
    function change_pass($newpass, $uname = '', $redirect_header = true)
    {
        global $xoopsUser, $xoopsDB;
        if (!$uname) {
            $uname = $xoopsUser->uname();
        }
        if ($uname) {
            $pass = authcode($newpass, 'ENCODE', $uname, 0);

            $sql = 'update ' . $xoopsDB->prefix('users') . " set `pass` = md5('$newpass') where `uname`='$uname' ";
            $xoopsDB->queryF($sql) or web_error($sql, __FILE__, __LINE__);

            $sql = 'update ' . $xoopsDB->prefix('tad_login_random_pass') . " set `random_pass` = '$pass', `hashed_date`=now() where `uname`='$uname' ";
            $xoopsDB->queryF($sql) or web_error($sql, __FILE__, __LINE__);
            if ($redirect_header) {
                redirect_header($_SERVER['PHP_SELF'], 3, _MD_TADLOGIN_CHANGE_COMPLETED);
            }
        }
    }
}

if (!function_exists('generateRandomString')) {
    function generateRandomString($length = 20)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ_*';
        $charactersLength = mb_strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[mt_rand(0, $charactersLength - 1)];
        }

        return $randomString;
    }
}

if (!function_exists('requestProtectedApi')) {
    function requestProtectedApi($token_ep = '', $accesstoken = '', $rtn_array = true, $gzipenable = false)
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
}

if (!function_exists('do_post')) {
    function do_post($url, $data)
    {
        $ch = curl_init($url);

        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($ch);
        curl_close($ch);

        return $response;
    }
}

//oidc 登入
if (!function_exists('edu_login')) {
    function edu_login($openid = 'edu_oidc', $mode = '')
    {
        global $xoopsTpl;
        $link = XOOPS_URL . '/modules/tad_login/class/edu/auth.php';
        if ('return' === $mode) {
            return $link;
        }

        header("location: $link");
        // $xoopsTpl->assign($openid, $link);
    }
}

//Line登入
if (!function_exists('line_login')) {
    function line_login($mode = '')
    {
        global $xoopsModuleConfig, $xoopsConfig, $xoopsDB, $xoopsTpl, $xoopsUser;

        if ($xoopsUser) {
            header('location:' . XOOPS_URL . '/user.php');
            exit;
        }
        require_once 'class/line/ConfigManager.php'; //Line 設定檔 管理器
        require_once 'class/line/LineAuthorization.php'; //產生登入網址
        require_once 'class/line/LineProfiles.php'; //取得用戶端 Profile
        require_once 'class/line/LineController.php'; //LINE控制

        define("CLIENT_ID", $xoopsModuleConfig['line_id']);
        define("CLIENT_SECRET", $xoopsModuleConfig['line_secret']);
        define("REDIRECT_URI", XOOPS_URL . '/modules/tad_login/line_callback.php'); //登入後返回位置
        define("SCOPE", 'openid%20profile%20email'); //授權範圍以%20分隔 可以有3項openid，profile，email

        if (!session_id()) {
            session_start();
        }
        $state = sha1(time());
        $_SESSION['_line_state'] = $state;

        $Line = new LineController();
        $loginUrl = $Line->lineLogin($state); //產生LINE登入連結

        if ('return' === $mode) {
            return $loginUrl;
        } else {

            header("location: $loginUrl");
            exit;
        }
        $xoopsTpl->assign('line', $loginUrl);
    }
}

//FB登入
if (!function_exists('facebook_login')) {
    function facebook_login($mode = '')
    {
        global $xoopsConfig, $xoopsDB, $xoopsTpl, $xoopsUser;
        if (PHP_VERSION_ID < 50400) {
            return false;
        }
        require_once XOOPS_ROOT_PATH . '/modules/tad_login/class/Facebook/autoload.php';

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

        $fb = new Facebook\Facebook([
            'app_id' => $tad_loginConfig['appId'], // Replace {app-id} with your app id
            'app_secret' => $tad_loginConfig['secret'],
            'default_graph_version' => 'v2.11',
        ]);

        $helper = $fb->getRedirectLoginHelper();
        $permissions = ['email']; // Optional permissions
        $loginUrl = $helper->getLoginUrl(XOOPS_URL . '/modules/tad_login/fb-callback.php', $permissions);

        if ('return' === $mode) {
            return $loginUrl;
        }
        $xoopsTpl->assign('facebook', $loginUrl);
    }
}

//google登入
if (!function_exists('google_login')) {
    function google_login($mode = '')
    {
        global $xoopsConfig, $xoopsDB, $xoopsTpl, $xoopsUser;

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
        if (isset($_GET['op'])) {
            $op = trim($_GET['op']);
            if (isset($_GET['uid'])) {
                $uid = (int) ($_GET['uid']);
            }
        }
        $client = new Google_Client();
        $client->setApplicationName('Google UserInfo PHP Starter Application');
        $oauth2 = new Google_Oauth2Service($client);
        // die(var_export($_REQUEST['code']));
        if (isset($_GET['code'])) {
            // die("system testing...1");
            $client->authenticate($_GET['code']);
            $_SESSION['token'] = $client->getAccessToken();
            $redirect = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'];
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

            if ($user) {
                $myts = \MyTextSanitizer::getInstance();
                $uid = $user['id'];
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
                login_xoops($uname, $name, $email, '', '', $url, $from, $sig, $occ, $bio);
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
}

//搜尋有無相同username資料
if (!function_exists('login_xoops')) {
    function login_xoops($uname = '', $name = '', $email = '', $SchoolCode = '', $JobName = '', $url = '', $from = '', $sig = '', $occ = '', $bio = '', $aim = '', $yim = '', $msnm = '', $user_avatar = 'avatars/blank.gif')
    {
        global $xoopsModuleConfig, $xoopsConfig, $xoopsDB, $xoopsUser;
        $memberHandler = xoops_getHandler('member');

        if ($memberHandler->getUserCount(new \Criteria('uname', $uname)) > 0) {
            //若已有此帳號！
            $uname = trim($uname);
            $pass = getPass($uname);

            if ('' == $uname || '' == $pass) {
                redirect_header(XOOPS_URL . '/user.php', 1, _MD_TNOPENID_INCORRECTLOGIN);
                exit();
            }

            $memberHandler = xoops_getHandler('member');
            xoops_loadLanguage('auth');

            require_once $GLOBALS['xoops']->path('class/auth/authfactory.php');

            $xoopsAuth = \XoopsAuthFactory::getAuthConnection($uname);
            //自動登入
            $user = $xoopsAuth->authenticate($uname, $pass);

            //若登入成功
            if (false !== $user) {
                add2group($user->getVar('uid'), $email, $SchoolCode, $JobName);

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

                if (!$memberHandler->insertUser($user, true)) {
                }

                $login_from = $_SESSION['login_from'];

                // Regenrate a new session id and destroy old session
                $GLOBALS['sess_handler']->regenerate_id(true);
                $_SESSION = [];
                $_SESSION['xoopsUserId'] = $user->getVar('uid');
                $_SESSION['xoopsUserGroups'] = $user->getGroups();
                $user_theme = $user->getVar('theme');
                if (in_array($user_theme, $xoopsConfig['theme_set_allowed'])) {
                    $_SESSION['xoopsUserTheme'] = $user_theme;
                }

                // Set cookie for rememberme
                if (!empty($xoopsConfig['usercookie'])) {
                    setcookie($xoopsConfig['usercookie'], 0, -1, '/', XOOPS_COOKIE_DOMAIN, 0);
                }

                $sql = 'select `hashed_date` from ' . $xoopsDB->prefix('tad_login_random_pass') . " where `uname` ='$uname'";
                $result = $xoopsDB->queryF($sql) or die($xoopsDB->error());
                list($hashed_date) = $xoopsDB->fetchRow($result);

                //若有要轉頁
                if ($hashed_date == '0000-00-00 00:00:00') {
                    $redirect_url = XOOPS_URL . '/modules/tad_login/index.php';
                } else {
                    if (!empty($xoopsModuleConfig['redirect_url'])) {
                        $redirect_url = $xoopsModuleConfig['redirect_url'];
                    } else {
                        $redirect_url = empty($login_from) ? XOOPS_URL . '/index.php' : $login_from;
                    }
                }

                // RMV-NOTIFY
                // Perform some maintenance of notification records
                $notificationHandler = xoops_getHandler('notification');
                $notificationHandler->doLoginMaintenance($user->getVar('uid'));

                redirect_header($redirect_url, 1, sprintf('', $user->getVar('uname')), false);
            } else {
                redirect_header(XOOPS_URL . '/user.php', 5, $xoopsAuth->getHtmlErrors());
            }
        } else {
            $sql = "select CHARACTER_MAXIMUM_LENGTH from information_schema.columns where table_schema = DATABASE() AND table_name = '" . $xoopsDB->prefix('users') . "' AND COLUMN_NAME = 'uname'";
            $result = $xoopsDB->query($sql);
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
                $sql = 'INSERT INTO `' . $xoopsDB->prefix('groups_users_link') . '`  (groupid, uid) VALUES  (2, ' . $uid . ')';
                $xoopsDB->queryF($sql) or Utility::web_error($sql, __FILE__, __LINE__);

                $pass = authcode($pass, 'ENCODE', $uname);
                $sql = 'replace into `' . $xoopsDB->prefix('tad_login_random_pass') . "` (`uname` , `random_pass`) values  ('{$uname}','{$pass}')";
                $xoopsDB->queryF($sql) or Utility::web_error($sql, __FILE__, __LINE__);

                login_xoops($uname, $name, $email, $SchoolCode, $JobName, $url, $from, $sig, $occ, $bio, $aim, $yim, $msnm);
            } else {
                redirect_header(XOOPS_URL, 5, _MD_TADLOGIN_CNRNU);
            }
        }
    }
}

if (!function_exists('getPass')) {
    function getPass($uname = '')
    {
        global $xoopsDB;
        if (empty($uname)) {
            return;
        }

        $sql = 'select `random_pass` from `' . $xoopsDB->prefix('tad_login_random_pass') . "` where `uname`='{$uname}'";
        $result = $xoopsDB->queryF($sql) or Utility::web_error($sql, __FILE__, __LINE__);
        list($random_pass) = $xoopsDB->fetchRow($result);

        //舊OpenID使用者
        if (empty($random_pass)) {
            $random_pass = Utility::randStr(128);
            $random_pass = authcode($random_pass, 'ENCODE', $uname);
            $sql = 'replace into `' . $xoopsDB->prefix('tad_login_random_pass') . "` (`uname` , `random_pass`) values  ('{$uname}','{$random_pass}')";
            $xoopsDB->queryF($sql) or Utility::web_error($sql, __FILE__, __LINE__);

            $sql = 'update `' . $xoopsDB->prefix('users') . "` set `pass`=md5('{$random_pass}') where `uname`='{$uname}'";
            $xoopsDB->queryF($sql) or Utility::web_error($sql, __FILE__, __LINE__);
        } else {
            $random_pass = authcode($random_pass, 'DECODE', $uname);
        }

        $sql = 'select `pass` from `' . $xoopsDB->prefix('users') . "` where `uname`='{$uname}'";
        $result = $xoopsDB->queryF($sql) or Utility::web_error($sql, __FILE__, __LINE__);
        list($pass) = $xoopsDB->fetchRow($result);
        if ($pass !== md5($random_pass)) {
            $sql = 'update `' . $xoopsDB->prefix('users') . "` set `pass`=md5('{$random_pass}') where `uname`='{$uname}'";
            $xoopsDB->queryF($sql) or Utility::web_error($sql, __FILE__, __LINE__);
        }

        return $random_pass;
    }
}

//非常給力的authcode加密函式,Discuz!經典程式碼(帶詳解)
//函式authcode($string, $operation, $key, $expiry)中的$string：字串，明文或密文；$operation：DECODE表示解密，其它表示加密；$key：密匙；$expiry：密文有效期。

if (!function_exists('authcode')) {
    function authcode($string, $operation = 'DECODE', $key = '', $expiry = 0)
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
}

if (!function_exists('add2group')) {
    function add2group($uid = '', $email = '', $SchoolCode = '', $JobName = '')
    {
        global $xoopsDB, $xoopsUser;

        $memberHandler = xoops_getHandler('member');
        $user = $memberHandler->getUser($uid);
        if ($user) {
            $userGroups = $user->getGroups();
        } else {
            header('location:' . XOOPS_URL);
            exit;
        }

        $sql = 'SELECT `item`,`kind`,`group_id` FROM `' . $xoopsDB->prefix('tad_login_config') . '`';
        $result = $xoopsDB->queryF($sql) or Utility::web_error($sql, __FILE__, __LINE__);
        while (list($item, $kind, $group_id) = $xoopsDB->fetchRow($result)) {
            if (!in_array($group_id, $userGroups)) {
                //echo "<h1>{$group_id}-{$item}-{$SchoolCode}-{$email}</h1>";
                if (!empty($SchoolCode) and false !== mb_strpos($item, $SchoolCode) and $JobName == $kind) {
                    $sql = 'insert into `' . $xoopsDB->prefix('groups_users_link') . "` (groupid,uid ) values($group_id,$uid)";
                    $xoopsDB->queryF($sql) or Utility::web_error($sql, __FILE__, __LINE__);
                    //echo "{$group_id}, {$uid}<br>";
                }

                if (empty($item) and $JobName == $kind) {
                    $sql = 'insert into `' . $xoopsDB->prefix('groups_users_link') . "` (groupid,uid ) values($group_id,$uid)";
                    $xoopsDB->queryF($sql) or Utility::web_error($sql, __FILE__, __LINE__);
                }

                if (!empty($email) and false !== mb_strpos($item, '*')) {
                    $item = trim($item);
                    $new_item = str_replace('*', '', $item);
                    // die($new_item);
                    if (false !== mb_strpos($email, $new_item)) {
                        $sql = 'insert into `' . $xoopsDB->prefix('groups_users_link') . "` (groupid,uid ) values($group_id,$uid)";
                        $xoopsDB->queryF($sql) or Utility::web_error($sql, __FILE__, __LINE__);
                    }
                }

                if (!empty($email) and false !== mb_strpos($item, $email)) {
                    $sql = 'insert into `' . $xoopsDB->prefix('groups_users_link') . "` (groupid,uid ) values($group_id,$uid)";
                    $xoopsDB->queryF($sql) or Utility::web_error($sql, __FILE__, __LINE__);
                    //echo "{$group_id}, {$uid}<br>";
                }
            }
        }
    }
}

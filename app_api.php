<?php
use Xmf\Request;
use XoopsModules\Tadtools\Utility;
require_once __DIR__ . '/header.php';

/*-----------執行動作判斷區----------*/
$op = Request::getString('op');
$uname = Request::getString('uname');
$pass = Request::getString('pass');

header("Content-Type: application/json; charset=utf-8");
switch ($op) {

    case 'login':
        die(json_encode(login($uname, $pass), 256));
}

function login($uname = '', $pass = '')
{
    global $xoopsModuleConfig, $xoopsConfig, $xoopsDB, $xoopsUser;
    $memberHandler = xoops_getHandler('member');

    if ($memberHandler->getUserCount(new \Criteria('uname', $uname)) > 0) {
        //若已有此帳號！
        $uname = trim($uname);
        $pass = trim($pass);

        if ('' == $uname || '' == $pass) {
            return $msg['error'] = _MD_TNOPENID_INCORRECTLOGIN;
        }

        $memberHandler = xoops_getHandler('member');
        xoops_loadLanguage('auth');

        require_once $GLOBALS['xoops']->path('class/auth/authfactory.php');

        $xoopsAuth = \XoopsAuthFactory::getAuthConnection($uname);
        //自動登入
        $user = $xoopsAuth->authenticate($uname, $pass);

        //若登入成功
        if (false !== $user) {

            if (0 == $user->getVar('level')) {
                return $msg['error'] = _MD_TNOPENID_NOACTTPADM;
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
                    return $msg['error'] = _MD_TNOPENID_NOPERM;
                }
            }

            //設定最後登入時間
            $user->setVar('last_login', time());

            if (!$memberHandler->insertUser($user, true)) {
            }

            $login_user['uname']=$user->uname();
            $login_user['name']=$user->name();
            $login_user['groups'] = $user->getGroups();
            $login_user['uid'] = $user->uid();
            $login_user['email'] = $user->email();
            $login_user['schoolcode'] = $user->user_intrest();
            $login_user['role'] = $user->icq();

            return $msg['user'] = $login_user;

        } else {
            return $msg['error'] = $xoopsAuth->getHtmlErrors();
        }
    } else {
        return $msg['error'] = _MD_TNOPENID_NO_USER;
}

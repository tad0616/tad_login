<?php

namespace XoopsModules\Tad_login;

/*
Update Class Definition

You may not change or alter any portion of this comment or credits of
supporting developers from this source code or any supporting source code
which is considered copyrighted (c) material of the original comment or credit
authors.

This program is distributed in the hope that it will be useful, but
WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 */

/**
 * @license      http://www.fsf.org/copyleft/gpl.html GNU public license
 * @copyright    https://xoops.org 2001-2017 &copy; XOOPS Project
 * @author       Mamba <mambax7@gmail.com>
 */

/**
 * Class Update
 */
class Update
{
    //檢查有無隨機密碼資料表
    public static function chk_chk1()
    {
        global $xoopsDB;
        $sql = 'SELECT count(*) FROM ' . $xoopsDB->prefix('tad_login_random_pass');
        $result = $xoopsDB->query($sql);
        if (empty($result)) {
            return false;
        }

        return true;
    }

    //執行更新
    public static function go_update1()
    {
        global $xoopsDB;
        $sql = 'CREATE TABLE ' . $xoopsDB->prefix('tad_login_random_pass') . ' (
            `uname` VARCHAR( 100 ) NOT NULL ,
            `random_pass` VARCHAR( 255 ) NOT NULL ,
            PRIMARY KEY ( `uname` )
        );';
        $xoopsDB->queryF($sql) or redirect_header(XOOPS_URL, 3, $xoopsDB->error());

        return true;
    }

    //檢查有無群組預設的表
    public static function chk_chk2()
    {
        global $xoopsDB;
        $sql = 'SELECT count(*) FROM ' . $xoopsDB->prefix('tad_login_config');
        $result = $xoopsDB->query($sql);
        if (empty($result)) {
            return false;
        }

        return true;
    }

    //執行更新
    public static function go_update2()
    {
        global $xoopsDB;
        $sql = 'CREATE TABLE ' . $xoopsDB->prefix('tad_login_config') . ' (
            `config_id` SMALLINT(5) UNSIGNED NOT NULL AUTO_INCREMENT,
            `item` TEXT NOT NULL,
            `group_id` SMALLINT(5) UNSIGNED NOT NULL DEFAULT 0,
            PRIMARY KEY (`config_id`)
        ) ENGINE=MyISAM ;';
        $xoopsDB->queryF($sql) or redirect_header(XOOPS_URL, 3, $xoopsDB->error());

        return true;
    }

    //檢查有無類別欄位
    public static function chk_chk3()
    {
        global $xoopsDB;
        $sql = 'SELECT count(`kind`) FROM ' . $xoopsDB->prefix('tad_login_config');
        $result = $xoopsDB->query($sql);
        if (empty($result)) {
            return false;
        }

        return true;
    }

    //執行更新
    public static function go_update3()
    {
        global $xoopsDB;
        $sql = 'ALTER TABLE ' . $xoopsDB->prefix('tad_login_config') . " ADD `kind` VARCHAR(255) NOT NULL DEFAULT '' AFTER `item`";
        $xoopsDB->queryF($sql) or redirect_header(XOOPS_URL, 3, $xoopsDB->error());

        $sql = 'SELECT config_id,item FROM ' . $xoopsDB->prefix('tad_login_config') . ' ';
        $result = $xoopsDB->queryF($sql) or redirect_header(XOOPS_URL, 3, $xoopsDB->error());
        while (list($config_id, $item) = $xoopsDB->fetchRow($result)) {
            $kind = (false !== mb_strpos($item, '@')) ? 'email' : 'teacher';
            $sql = 'update ' . $xoopsDB->prefix('tad_login_config') . " set kind='$kind' where config_id='{$config_id}'";
            $xoopsDB->queryF($sql) or redirect_header(XOOPS_URL, 3, $xoopsDB->error());
        }

        return true;
    }

    //修正高雄市OpenID登入帳號
    public static function fix_kh()
    {
        global $xoopsDB;
        $sql = 'select `uname`, `uid` from ' . $xoopsDB->prefix('users') . " where right(`uname`, 3)='_hk' ";
        $result = $xoopsDB->queryF($sql) or die($xoopsDB->error());
        while (list($uname, $uid) = $xoopsDB->fetchRow($result)) {
            $sql = 'update ' . $xoopsDB->prefix('users') . " set `uname` = replace(`uname`,'_hk','_kh') where `uid`='$uid' ";
            $xoopsDB->queryF($sql) or die($xoopsDB->error());
            $sql = 'update ' . $xoopsDB->prefix('tad_login_random_pass') . " set `uname` = replace(`uname`,'_hk','_kh') where `uname`='$uname' ";
            $xoopsDB->queryF($sql) or die($xoopsDB->error());
        }
        return true;
    }

    //修正桃園市OpenID登入帳號
    public static function fix_ty()
    {
        global $xoopsDB;
        $sql = 'select `uname`, `uid` from ' . $xoopsDB->prefix('users') . " where right(`uname`, 4)='_tyc' ";
        $result = $xoopsDB->queryF($sql) or die($xoopsDB->error());
        while (list($uname, $uid) = $xoopsDB->fetchRow($result)) {
            $sql = 'update ' . $xoopsDB->prefix('users') . " set `uname` = replace(`uname`,'_tyc','_ty') where `uid`='$uid' ";
            $xoopsDB->queryF($sql) or die($xoopsDB->error());
            $sql = 'update ' . $xoopsDB->prefix('tad_login_random_pass') . " set `uname` = replace(`uname`,'_tyc','_ty') where `uname`='$uname' ";
            $xoopsDB->queryF($sql) or die($xoopsDB->error());
        }
        return true;
    }
}

<?php

namespace XoopsModules\Tad_login;

/*
 Utility Class Definition

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
 * Class Utility
 */
class Utility
{
    //建立目錄
    public static function mk_dir($dir = '')
    {
        //若無目錄名稱秀出警告訊息
        if (empty($dir)) {
            return;
        }

        //若目錄不存在的話建立目錄
        if (!is_dir($dir)) {
            umask(000);
            //若建立失敗秀出警告訊息
            if (!mkdir($dir, 0777) && !is_dir($dir)) {
                throw new \RuntimeException(sprintf('Directory "%s" was not created', $dir));
            }
        }
    }

    //刪除目錄
    public static function delete_directory($dirname)
    {
        if (is_dir($dirname)) {
            $dir_handle = opendir($dirname);
        }

        if (!$dir_handle) {
            return false;
        }

        while ($file = readdir($dir_handle)) {
            if ('.' != $file && '..' != $file) {
                if (!is_dir($dirname . '/' . $file)) {
                    unlink($dirname . '/' . $file);
                } else {
                    self::delete_directory($dirname . '/' . $file);
                }
            }
        }
        closedir($dir_handle);
        rmdir($dirname);

        return true;
    }

    //拷貝目錄
    public static function full_copy($source = '', $target = '')
    {
        if (is_dir($source)) {
            if (!mkdir($target) && !is_dir($target)) {
                throw new \RuntimeException(sprintf('Directory "%s" was not created', $target));
            }
            $d = dir($source);
            while (false !== ($entry = $d->read())) {
                if ('.' == $entry || '..' == $entry) {
                    continue;
                }

                $Entry = $source . '/' . $entry;
                if (is_dir($Entry)) {
                    self::full_copy($Entry, $target . '/' . $entry);
                    continue;
                }
                copy($Entry, $target . '/' . $entry);
            }
            $d->close();
        } else {
            copy($source, $target);
        }
    }

    public static function rename_win($oldfile, $newfile)
    {
        if (!rename($oldfile, $newfile)) {
            if (copy($oldfile, $newfile)) {
                unlink($oldfile);

                return true;
            }

            return false;
        }

        return true;
    }

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
}

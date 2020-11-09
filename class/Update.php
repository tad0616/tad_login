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

    //檢查有無加密欄位
    public static function chk_chk4()
    {
        global $xoopsDB;
        $sql = 'SELECT count(`hashed_date`) FROM ' . $xoopsDB->prefix('tad_login_random_pass');
        $result = $xoopsDB->query($sql);
        if (empty($result)) {
            return true;
        }

        return false;
    }

    //執行更新
    public static function go_update4()
    {
        global $xoopsDB;
        $sql = 'ALTER TABLE ' . $xoopsDB->prefix('tad_login_random_pass') . " ADD `hashed_date` datetime ";
        $xoopsDB->queryF($sql) or redirect_header(XOOPS_URL, 3, $xoopsDB->error());

        self::fix_passwd();

        return true;
    }
    //密碼加密
    public static function fix_passwd()
    {
        global $xoopsDB;
        $sql = 'select `uname`, `random_pass` from ' . $xoopsDB->prefix('tad_login_random_pass') . " where hashed_date is null";
        $result = $xoopsDB->queryF($sql) or die($xoopsDB->error());
        while (list($uname, $random_pass) = $xoopsDB->fetchRow($result)) {
            $pass = self::authcode($random_pass, 'ENCODE', $uname, 0);

            $sql = 'update ' . $xoopsDB->prefix('users') . " set `pass` = md5('$pass') where `uname`='$uname' ";
            $xoopsDB->queryF($sql) or die($xoopsDB->error());
            $sql = 'update ' . $xoopsDB->prefix('tad_login_random_pass') . " set `random_pass` = '$pass', `hashed_date`='' where `uname`='$uname' ";
            $xoopsDB->queryF($sql) or die($xoopsDB->error());
        }
        return true;
    }

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

// $str = 'abcdef';
    // $key = 'www.helloweba.com';
    // echo authcode($str,'ENCODE',$key,0); //加密
    // $str = '56f4yER1DI2WTzWMqsfPpS9hwyoJnFP2MpC8SOhRrxO7BOk';
    // echo authcode($str,'DECODE',$key,0); //解密
}

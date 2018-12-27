<?php
function xoops_module_update_tad_login(&$module, $old_version)
{
    global $xoopsDB;

    if (!chk_chk1()) {
        go_update1();
    }
    if (!chk_chk2()) {
        go_update2();
    }
    if (!chk_chk3()) {
        go_update3();
    }

    return true;
}

//檢查有無隨機密碼資料表
function chk_chk1()
{
    global $xoopsDB;
    $sql    = "SELECT count(*) FROM " . $xoopsDB->prefix("tad_login_random_pass");
    $result = $xoopsDB->query($sql);
    if (empty($result)) {
        return false;
    }

    return true;
}

//執行更新
function go_update1()
{
    global $xoopsDB;
    $sql = "CREATE TABLE " . $xoopsDB->prefix("tad_login_random_pass") . " (
    `uname` VARCHAR( 100 ) NOT NULL ,
    `random_pass` VARCHAR( 255 ) NOT NULL ,
    PRIMARY KEY ( `uname` )
  );";
    $xoopsDB->queryF($sql) or redirect_header(XOOPS_URL, 3, $xoopsDB->error());

    return true;
}

//檢查有無群組預設的表
function chk_chk2()
{
    global $xoopsDB;
    $sql    = "SELECT count(*) FROM " . $xoopsDB->prefix("tad_login_config");
    $result = $xoopsDB->query($sql);
    if (empty($result)) {
        return false;
    }

    return true;
}

//執行更新
function go_update2()
{
    global $xoopsDB;
    $sql = "CREATE TABLE " . $xoopsDB->prefix("tad_login_config") . " (
    `config_id` SMALLINT(5) UNSIGNED NOT NULL AUTO_INCREMENT,
    `item` TEXT NOT NULL,
    `group_id` SMALLINT(5) UNSIGNED NOT NULL DEFAULT 0,
    PRIMARY KEY (`config_id`)
  ) ENGINE=MyISAM ;";
    $xoopsDB->queryF($sql) or redirect_header(XOOPS_URL, 3, $xoopsDB->error());

    return true;
}

//檢查有無類別欄位
function chk_chk3()
{
    global $xoopsDB;
    $sql    = "SELECT count(`kind`) FROM " . $xoopsDB->prefix("tad_login_config");
    $result = $xoopsDB->query($sql);
    if (empty($result)) {
        return false;
    }

    return true;
}

//執行更新
function go_update3()
{
    global $xoopsDB;
    $sql = "ALTER TABLE " . $xoopsDB->prefix("tad_login_config") . " ADD `kind` VARCHAR(255) NOT NULL DEFAULT '' AFTER `item`";
    $xoopsDB->queryF($sql) or redirect_header(XOOPS_URL, 3, $xoopsDB->error());

    $sql = "SELECT config_id,item FROM " . $xoopsDB->prefix("tad_login_config") . " ";
    $result = $xoopsDB->queryF($sql) or redirect_header(XOOPS_URL, 3, $xoopsDB->error());
    while (list($config_id, $item) = $xoopsDB->fetchRow($result)) {
        $kind = (strpos($item, "@") !== false) ? "email" : "teacher";
        $sql  = "update " . $xoopsDB->prefix("tad_login_config") . " set kind='$kind' where config_id='{$config_id}'";
        $xoopsDB->queryF($sql) or redirect_header(XOOPS_URL, 3, $xoopsDB->error());
    }

    return true;
}



//建立目錄
if (!function_exists('mk_dir')) {
    function mk_dir($dir = "")
    {
        //若無目錄名稱秀出警告訊息
        if (empty($dir)) {
            return;
        }

        //若目錄不存在的話建立目錄
        if (!is_dir($dir)) {
            umask(000);
            //若建立失敗秀出警告訊息
            mkdir($dir, 0777);
        }
    }
}

//拷貝目錄
if (!function_exists('full_copy')) {
    function full_copy($source = "", $target = "")
    {
        if (is_dir($source)) {
            @mkdir($target);
            $d = dir($source);
            while (false !== ($entry = $d->read())) {
                if ($entry == '.' || $entry == '..') {
                    continue;
                }

                $Entry = $source . '/' . $entry;
                if (is_dir($Entry)) {
                    full_copy($Entry, $target . '/' . $entry);
                    continue;
                }
                copy($Entry, $target . '/' . $entry);
            }
            $d->close();
        } else {
            copy($source, $target);
        }
    }
}

if (!function_exists('rename_win')) {
    function rename_win($oldfile, $newfile)
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
}

if (!function_exists('delete_directory')) {
    function delete_directory($dirname)
    {
        if (is_dir($dirname)) {
            $dir_handle = opendir($dirname);
        }

        if (!$dir_handle) {
            return false;
        }

        while ($file = readdir($dir_handle)) {
            if ($file != "." && $file != "..") {
                if (!is_dir($dirname . "/" . $file)) {
                    unlink($dirname . "/" . $file);
                } else {
                    delete_directory($dirname . '/' . $file);
                }
            }
        }
        closedir($dir_handle);
        rmdir($dirname);
        return true;
    }
}

<?php
function xoops_module_update_tad_login(&$module, $old_version) {
    GLOBAL $xoopsDB;

    if(!chk_chk1()) go_update1();
    if(!chk_chk2()) go_update2();
    if(!chk_chk3()) go_update3();

    return true;
}

//檢查有無隨機密碼資料表
function chk_chk1(){
  global $xoopsDB;
  $sql="select count(*) from ".$xoopsDB->prefix("tad_login_random_pass");
  $result=$xoopsDB->query($sql);
  if(empty($result)) return false;
  return true;
}


//執行更新
function go_update1(){
  global $xoopsDB;
  $sql="CREATE TABLE ".$xoopsDB->prefix("tad_login_random_pass")." (
    `uname` VARCHAR( 100 ) NOT NULL ,
    `random_pass` VARCHAR( 255 ) NOT NULL ,
    PRIMARY KEY ( `uname` )
  );";
  $xoopsDB->queryF($sql) or redirect_header(XOOPS_URL,3,  mysql_error());

  return true;
}


//檢查有無群組預設的表
function chk_chk2(){
  global $xoopsDB;
  $sql="select count(*) from ".$xoopsDB->prefix("tad_login_config");
  $result=$xoopsDB->query($sql);
  if(empty($result)) return false;
  return true;
}


//執行更新
function go_update2(){
  global $xoopsDB;
  $sql="CREATE TABLE ".$xoopsDB->prefix("tad_login_config")." (
    `config_id` smallint(5) unsigned NOT NULL auto_increment,
    `item` text NOT NULL,
    `group_id` smallint(5) unsigned NOT NULL default 0,
    PRIMARY KEY (`config_id`)
  ) ENGINE=MyISAM ;";
  $xoopsDB->queryF($sql) or redirect_header(XOOPS_URL,3,  mysql_error());

  return true;
}


//檢查有無類別欄位
function chk_chk3(){
  global $xoopsDB;
  $sql="select count(`kind`) from ".$xoopsDB->prefix("tad_login_config");
  $result=$xoopsDB->query($sql);
  if(empty($result)) return false;
  return true;
}


//執行更新
function go_update3(){
  global $xoopsDB;
  $sql="ALTER TABLE ".$xoopsDB->prefix("tad_login_config")." ADD `kind` varchar(255) NOT NULL default '' after `item`";
  $xoopsDB->queryF($sql) or redirect_header(XOOPS_URL,3,  mysql_error());

  $sql="select config_id,item from ".$xoopsDB->prefix("tad_login_config")." ";
  $result=$xoopsDB->queryF($sql) or redirect_header(XOOPS_URL,3,  mysql_error());
  while(list($config_id,$item)=$xoopsDB->fetchRow($result)){
    $kind=(strpos($item, "@")!==false)?"email":"teacher";
    $sql="update ".$xoopsDB->prefix("tad_login_config")." set kind='$kind' where config_id='{$config_id}'";
    $xoopsDB->queryF($sql) or redirect_header(XOOPS_URL,3,  mysql_error());
  }
  return true;
}


//建立目錄
function mk_dir($dir=""){
    //若無目錄名稱秀出警告訊息
    if(empty($dir))return;
    //若目錄不存在的話建立目錄
    if (!is_dir($dir)) {
        umask(000);
        //若建立失敗秀出警告訊息
        mkdir($dir, 0777);
    }
}

//拷貝目錄
function full_copy( $source="", $target=""){
  if ( is_dir( $source ) ){
    @mkdir( $target );
    $d = dir( $source );
    while ( FALSE !== ( $entry = $d->read() ) ){
      if ( $entry == '.' || $entry == '..' ){
        continue;
      }

      $Entry = $source . '/' . $entry;
      if ( is_dir( $Entry ) ) {
        full_copy( $Entry, $target . '/' . $entry );
        continue;
      }
      copy( $Entry, $target . '/' . $entry );
    }
    $d->close();
  }else{
    copy( $source, $target );
  }
}


function rename_win($oldfile,$newfile) {
   if (!rename($oldfile,$newfile)) {
      if (copy ($oldfile,$newfile)) {
         unlink($oldfile);
         return TRUE;
      }
      return FALSE;
   }
   return TRUE;
}


function delete_directory($dirname) {
    if (is_dir($dirname))
        $dir_handle = opendir($dirname);
    if (!$dir_handle)
        return false;
    while($file = readdir($dir_handle)) {
        if ($file != "." && $file != "..") {
            if (!is_dir($dirname."/".$file))
                unlink($dirname."/".$file);
            else
                delete_directory($dirname.'/'.$file);
        }
    }
    closedir($dir_handle);
    rmdir($dirname);
    return true;
}

?>

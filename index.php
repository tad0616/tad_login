<?php
/*-----------引入檔案區--------------*/
include "header.php";
$xoopsOption['template_main'] = "tad_login_index_tpl.html";
include_once XOOPS_ROOT_PATH."/header.php";

/*-----------function區--------------*/

//台南 OpenID 登入
function tn_openid_login(){
  global $xoopsModuleConfig , $xoopsConfig ,$xoopsDB , $xoopsTpl,$xoopsUser;

  if($xoopsUser){
    header("location:".XOOPS_URL . "/user.php");
    exit;
  }


  include_once 'class/openid.php';
  try {
    # Change 'localhost' to your domain name.
    $openid = new LightOpenID(XOOPS_URL);
    if(!$openid->mode) {
        $openid->identity =  "https://openid.tn.edu.tw/op/";
        $openid->required = array('contact/email' , 'namePerson' );
        header('Location: ' . $openid->authUrl());

    } else {
      $user_profile=$openid->getAttributes();
      //die(var_export($user_profile));
      /*
      array (
        '.tw/axschema/UserID' => '14684bd6fd05480979e9991f498272c48923880668fd045b750dd6e79864d470',
        '.tw/axschema/UserName' => 'tad',
        '.tw/axschema/ApplyEmail' => 'tad',
        '.tw/axschema/SchoolName' => '龍崎國小',
        '.tw/axschema/UserMemo' => '審核通過                                                                                                                                                                                                                                                           ',
        '.tw/axschema/EduSchoolID' => '114620',
        '.tw/axschema/JobName' => '教師',
        '.tw/axschema/Mobile' => '',
        'contact/email' => 'tad@tn.edu.tw',
        'namePerson' => '吳弘凱',
      )
      */

    /*
    array(20) {
      [".tw/axschema/UserID"]=>
      string(32) "9CC19A799323D40CCB1FF1BCD63FF14F"
      [".tw/axschema/UserName"]=>
      string(9) "姓名"
      [".tw/axschema/ApplyEmail"]=>
      string(9) "st2222222"
      [".tw/axschema/SchoolName"]=>
      string(12) "xx國中"
      [".tw/axschema/UserMemo"]=>
      string(12) "審核通過"
      [".tw/axschema/EduSchoolID"]=>
      string(6) "123456"
      [".tw/axschema/JobName"]=>
      string(6) "學生"
      [".tw/axschema/Mobile"]=>
      string(0) ""
      [".tw/axschema/Phone"]=>
      string(0) ""
      [".tw/axschema/VOIP"]=>
      string(0) ""
      [".tw/axschema/std_no"]=>
      string(7) "1010101"
      [".tw/axschema/grade"]=>
      string(1) "2"
      [".tw/axschema/class"]=>
      string(2) "26"
      [".tw/axschema/seat"]=>
      string(2) "14"
      [".tw/axschema/sch_code"]=>
      string(6) "123456"
      ["/axschema/person/guid"]=>
      string(64) "45b3666740e5adfe6ebe981b6f119bf868f3912463e49959fc15d178d1cd4e27"
      ["/axschema/school/titleStr"]=>
      string(39) "[{"id":"st2222222","title":["學生"]}]"
      ["/axschema/school/id"]=>
      string(6) "123456"
      ["contact/email"]=>
      string(25) "stxxxxxxx@cloud.tn.edu.tw"
      ["namePerson"]=>
      string(9) "姓名"
    }
    */

      // Login or logout url will be needed depending on current user state.
      //die(var_dump($user_profile));
      if ($user_profile) {
        $myts =& MyTextsanitizer::getInstance();

        $the_id=explode("@",$user_profile['contact/email']);

        //$uid = $user['id'];
        $uname =$the_id[0]."_tn";
        $name = $myts->addSlashes($user_profile['namePerson']);
        $email =  strtolower($user_profile['contact/email']);
        $SchoolCode = $myts->addSlashes($user_profile['.tw/axschema/EduSchoolID']);
        $JobName = $user_profile['.tw/axschema/JobName']=="學生"?"student":"teacher";

        //搜尋有無相同username資料
        login_xoops($uname,$name,$email,$SchoolCode,$JobName);
      }
    }
  } catch(ErrorException $e) {
      $main=$e->getMessage();
  }

  $xoopsTpl->assign('openid',$main);
}


//Google 登入
function google_login(){
  global $xoopsModuleConfig , $xoopsConfig ,$xoopsDB , $xoopsTpl,$xoopsUser;

  if($xoopsUser){
    header("location:".XOOPS_URL . "/user.php");
    exit;
  }

  include_once 'class/openid.php';
  try {
    # Change 'localhost' to your domain name.
    $openid = new LightOpenID(XOOPS_URL);
    if(!$openid->mode) {
      if(isset($_GET['login'])) {
        $openid->identity = 'https://www.google.com/accounts/o8/id';
        $openid->required = array('contact/email' , 'namePerson/first' , 'namePerson/last');
        header('Location: ' . $openid->authUrl());
      }
    } else {

      $user_profile=$openid->getAttributes();
      //die(var_export($user_profile));
      if ($user_profile) {
        $myts =& MyTextsanitizer::getInstance();

        $the_id=explode("@",$user_profile['contact/email']);

        //$uid = $user['id'];
        $uname =$the_id[0]."_goo";
        $name = $myts->addSlashes($user_profile['namePerson/first']).$myts->addSlashes($user_profile['namePerson/last']);
        $email =  $user_profile['contact/email'];
        //$bio = $myts->addSlashes($user_profile['/axschema/school/id']);
        //搜尋有無相同username資料
        login_xoops($uname,$name,$email);
      }
    }
  } catch(ErrorException $e) {
      $main=$e->getMessage();
  }

  $xoopsTpl->assign('google',$main);
}


//Yahoo 登入
function yahoo_login(){
  global $xoopsModuleConfig , $xoopsConfig ,$xoopsDB , $xoopsTpl,$xoopsUser;

  if($xoopsUser){
    header("location:".XOOPS_URL . "/user.php");
    exit;
  }

  include_once 'class/openid.php';
  try {
    # Change 'localhost' to your domain name.
    $openid = new LightOpenID(XOOPS_URL);
    if(!$openid->mode) {
      if(isset($_GET['login'])) {
        $openid->identity = 'https://me.yahoo.com';
        $openid->required = array('contact/email' , 'namePerson/friendly' , 'namePerson');
        header('Location: ' . $openid->authUrl());
      }
    } else {

      $user_profile=$openid->getAttributes();
      //die(var_export($user_profile));
      if ($user_profile) {
        $myts =& MyTextsanitizer::getInstance();

        $the_id=explode("@",$user_profile['contact/email']);

        $uname =empty($user_profile['namePerson/friendly'])?$the_id[0]."_ya":$user_profile['namePerson/friendly']."_ya";
        $name = $myts->addSlashes($user_profile['namePerson']);
        $email =  $user_profile['contact/email'];
        login_xoops($uname,$name,$email);
      }
    }
  } catch(ErrorException $e) {
      $main=$e->getMessage();
  }

  $xoopsTpl->assign('yahoo',$main);
}



//MyID 登入
function myid_login(){
  global $xoopsModuleConfig , $xoopsConfig ,$xoopsDB , $xoopsTpl,$xoopsUser;

  if($xoopsUser){
    header("location:".XOOPS_URL . "/user.php");
    exit;
  }

  include_once 'class/openid.php';
  try {
    # Change 'localhost' to your domain name.
    $openid = new LightOpenID(XOOPS_URL);
    if(!$openid->mode) {
      if(isset($_GET['login'])) {
        $openid->identity = 'https://myid.tw';
        $openid->required = array('contact/email' , 'namePerson/friendly' , 'namePerson');
        header('Location: ' . $openid->authUrl());

      }
    } else {

      $user_profile=$openid->getAttributes();
      //die(var_export($user_profile));
      if ($user_profile) {
        $myts =& MyTextsanitizer::getInstance();

        $the_id=explode("@",$user_profile['contact/email']);

        //$uid = $user['id'];
        $uname =empty($user_profile['namePerson/friendly'])?$the_id[0]."_my":$user_profile['namePerson/friendly']."_my";
        $name = $myts->addSlashes($user_profile['namePerson']);
        $email =  $user_profile['contact/email'];
        login_xoops($uname,$name,$email);
      }
    }
  } catch(ErrorException $e) {
      $main=$e->getMessage();
  }

  $xoopsTpl->assign('MyID',$main);
}


//嘉義縣 OpenID 登入
function cyc_login(){
  global $xoopsModuleConfig , $xoopsConfig ,$xoopsDB , $xoopsTpl,$xoopsUser;

  if($xoopsUser){
    header("location:".XOOPS_URL . "/user.php");
    exit;
  }


  include_once 'class/openid_tc.php';
  try {
    # Change 'localhost' to your domain name.
    $openid = new LightOpenID(XOOPS_URL);
    if(!$openid->mode) {
        $openid->identity = 'http://openid.cyccc.tw';
        $openid->required = array('contact/email' , 'namePerson/friendly'  , 'namePerson');
        $openid->optional = array('axschema/person/guid' , 'axschema/school/titleStr'  , 'axschema/school/id','tw/person/guid' , 'tw/isas/roles'  );
        header('Location: ' . $openid->authUrl());

    } else {
      $user_profile=$openid->getAttributes();
      //die(var_export($user_profile));
      /*
      array (
        '/axschema/person/guid' => '14684bd6fd05480979e9991f498272c48923880668fd045b750dd6e79864d470',
        '/axschema/school/titleStr' => '[{"id":"114620","title":["教師"]}]',
        '/axschema/school/id' => '114620',
        'tw/person/guid' => '14684bd6fd05480979e9991f498272c48923880668fd045b750dd6e79864d470',
        'tw/isas/roles' => '[{"sid":"114620","roles":["其他"]}]',
        'contact/email' => 'Tad@tn.edu.tw',
        'namePerson' => '吳弘凱',
      )
      */
      // Login or logout url will be needed depending on current user state.
      if ($user_profile) {
        $myts =& MyTextsanitizer::getInstance();

        $the_id=explode("@",$user_profile['contact/email']);

        //$uid = $user['id'];
        $uname =$the_id[0]."_cyc";
        $name = $myts->addSlashes($user_profile['namePerson']);
        $email =  strtolower($user_profile['contact/email']);
        $SchoolCode = $myts->addSlashes($user_profile['axschema/school/id']);
        $JobName = (strpos($user_profile['/axschema/school/titleStr'],"學生")!==false)?"student":"teacher";
        //搜尋有無相同username資料
        login_xoops($uname,$name,$email,$SchoolCode,$JobName);
      }
    }
  } catch(ErrorException $e) {
      $main=$e->getMessage();
  }

  $xoopsTpl->assign('openid',$main);

}

/*-----------執行動作判斷區----------*/

$op=empty($_REQUEST['op'])?"":$_REQUEST['op'];


switch($op){
  case "google":
  $_SESSION['auth_method']="google";
  google_login();
  break;

  case "yahoo":
  $_SESSION['auth_method']="yahoo";
  yahoo_login();
  break;

  case "tn":
  case "tn_openid":
  $_SESSION['auth_method']="tn";
  tn_openid_login();
  break;

  case "myid":
  $_SESSION['auth_method']="myid";
  myid_login();
  break;

  case "cyc":
  case "cyc_openid":
  $_SESSION['auth_method']="cyc";
  cyc_login();
  break;


  default:
  if($_SESSION['auth_method']=="google"){
    google_login();
  }elseif($_SESSION['auth_method']=="yahoo"){
    yahoo_login();
  }elseif($_SESSION['auth_method']=="tn"){
    tn_openid_login();
  }elseif($_SESSION['auth_method']=="myid"){
    myid_login();
  }elseif($_SESSION['auth_method']=="cyc"){
    cyc_login();
  }else{
    facebook_login();
  }
  $xoopsTpl->assign('auth_method',$xoopsModuleConfig['auth_method']);
  break;
}

$xoopsTpl->assign( "toolbar" , toolbar_bootstrap($interface_menu)) ;
$xoopsTpl->assign( "bootstrap" , get_bootstrap()) ;
$xoopsTpl->assign( "jquery" , get_jquery(true)) ;
$xoopsTpl->assign( "isAdmin" , $isAdmin) ;

include_once XOOPS_ROOT_PATH.'/footer.php';
?>
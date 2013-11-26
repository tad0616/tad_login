<?php
/*-----------引入檔案區--------------*/
include "header.php";
$xoopsOption['template_main'] = "tad_login_index_tpl.html";
include_once XOOPS_ROOT_PATH."/header.php";

/*-----------function區--------------*/

//OpenID 登入
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
      if(isset($_POST['openid_identifier'])) {
        $openid->identity =  "http://openid.tn.edu.tw/op/user.aspx/".$_POST['openid_identifier'];
        # The following two lines request email, full name, and a nickname
        # from the provider. Remove them if you don't need that data.
        $openid->required = array('contact/email');
        $openid->optional = array('namePerson', 'namePerson/friendly');
        header('Location: ' . $openid->authUrl());
      }
    } else {
      $user_profile=$openid->getAttributes();
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
        $uname =$the_id[0]."_tn";
        $name = $myts->addSlashes($user_profile['namePerson']);
        $pass = md5($user_profile['contact/email']);
        $email =  strtolower($user_profile['contact/email']);
        $bio = $myts->addSlashes($user_profile['/axschema/school/id']);
        //搜尋有無相同username資料
        login_xoops($uname,$name,$pass,$email,$bio);
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
        $openid->required = array('contact/email' , 'namePerson/first' , 'namePerson/last' , 'pref/language' , 'contact/country/home');
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
        $pass = md5($user_profile['contact/email'].$user_profile['namePerson/last'].$user_profile['namePerson/first']);
        $email =  $user_profile['contact/email'];
        //$bio = $myts->addSlashes($user_profile['/axschema/school/id']);
        //搜尋有無相同username資料
        login_xoops($uname,$name,$pass,$email);
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
        $openid->required = array('contact/email' , 'namePerson/first' , 'namePerson/last' , 'pref/language' , 'contact/country/home');
        header('Location: ' . $openid->authUrl());
      }
    } else {

      $user_profile=$openid->getAttributes();
      //die(var_export($user_profile));
      if ($user_profile) {
        $myts =& MyTextsanitizer::getInstance();

        $the_id=explode("@",$user_profile['contact/email']);

        //$uid = $user['id'];
        $uname =$the_id[0]."_ya";
        $name = $myts->addSlashes($the_id[0]);
        $pass = md5($user_profile['contact/email'].$user_profile['namePerson/last'].$user_profile['namePerson/first']);
        $email =  $user_profile['contact/email'];
        //$bio = $myts->addSlashes($user_profile['/axschema/school/id']);
        //搜尋有無相同username資料
        login_xoops($uname,$name,$pass,$email);
      }
    }
  } catch(ErrorException $e) {
      $main=$e->getMessage();
  }

  $xoopsTpl->assign('yahoo',$main);
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
  $_SESSION['auth_method']="tn";
  tn_openid_login();
  break;

  default:
  if($_SESSION['auth_method']=="google"){
    google_login();
  }elseif($_SESSION['auth_method']=="yahoo"){
    yahoo_login();
  }elseif($_SESSION['auth_method']=="tn"){
    tn_openid_login();
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
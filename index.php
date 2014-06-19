<?php
/*-----------引入檔案區--------------*/
include "header.php";
$xoopsOption['template_main'] = "tad_login_index_tpl.html";
include_once XOOPS_ROOT_PATH."/header.php";

/*-----------function區--------------*/

//台南 OpenID 登入
function tn_login(){
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
        $openid->identity =  "http://openid.tn.edu.tw/op/";
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
        if($xoopsModuleConfig['real_jobname']=="1"){
          $var=json_decode($user_profile['/axschema/school/titleStr'],true);
          $JobName=$var[0]['title'][0];
        }else{
          $JobName = $user_profile['.tw/axschema/JobName']=="學生"?"student":"teacher";
        }

        //搜尋有無相同username資料
        login_xoops($uname,$name,$email,$SchoolCode,$JobName);
      }
    }
  } catch(ErrorException $e) {
      $main=$e->getMessage();
  }

  $xoopsTpl->assign('openid',$main);
}


//基隆市 OpenID 登入
function kl_login(){
  global $xoopsModuleConfig , $xoopsConfig ,$xoopsDB , $xoopsTpl,$xoopsUser;

  if($xoopsUser){
    header("location:".XOOPS_URL . "/user.php");
    exit;
  }

  include_once 'class/openid_kl.php';
  try {
    # Change 'localhost' to your domain name.
    $openid = new LightOpenID(XOOPS_URL);
    if(!$openid->mode) {
        $openid->identity =  "http://openid.kl.edu.tw";
        $openid->required = array('contact/email' , 'namePerson/friendly'  , 'namePerson');
        $openid->optional = array('axschema/person/guid' , 'axschema/school/titleStr'  , 'axschema/school/id','tw/person/guid' , 'tw/isas/roles'  );
        header('Location: ' . $openid->authUrl());

    } else {
      $user_profile=$openid->getAttributes();
      //die(var_export($user_profile));
      // Login or logout url will be needed depending on current user state.
      /*
      array (
        'contact/email' => 'tad0616@gmail.com',
        'namePerson/friendly' => 'tad',
        'namePerson' => '吳弘凱',
        'axschema/school/titleStr' => '{sid:"173637",title:["教師"]}',
        'axschema/school/id' => '173637',
      )
      */
      if ($user_profile) {
        $myts =& MyTextsanitizer::getInstance();

        $the_id=explode("@",$user_profile['contact/email']);

        //$uid = $user['id'];
        $uname =$the_id[0]."_kl";
        $name = $myts->addSlashes($user_profile['namePerson']);
        $email =  strtolower($user_profile['contact/email']);
        $SchoolCode = $myts->addSlashes($user_profile['axschema/school/id']);
        if($xoopsModuleConfig['real_jobname']=="1"){
          $var=json_decode($user_profile['axschema/school/titleStr'],true);
          $JobName=$var['title'][0];
        }else{
          $JobName = (strpos($user_profile['axschema/school/titleStr'],"學生")!==false)?"student":"teacher";
        }


        //搜尋有無相同username資料
        login_xoops($uname,$name,$email,$SchoolCode,$JobName);
      }
    }
  } catch(ErrorException $e) {
      $main=$e->getMessage();
  }

  $xoopsTpl->assign('openid',$main);
}


//宜蘭縣 OpenID 登入
function ilc_login(){
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
        $openid->identity =  "http://openid.ilc.edu.tw";
        $openid->required = array('contact/email' , 'namePerson/friendly'  , 'namePerson');
        //$openid->optional = array('axschema/person/guid' , 'axschema/school/titleStr'  , 'axschema/school/id','tw/person/guid' , 'tw/isas/roles'  );
        header('Location: ' . $openid->authUrl());

    } else {
      $user_profile=$openid->getAttributes();
      //die(var_export($user_profile));
      // Login or logout url will be needed depending on current user state.
      /*
      array (
        'contact/email' => 'tad0616@gmail.com',
        'namePerson/friendly' => 'tad',
        'namePerson' => '吳弘凱',
        'axschema/school/titleStr' => '{sid:"173637",title:["教師"]}',
        'axschema/school/id' => '173637',
      )
      */
      if ($user_profile) {
        $myts =& MyTextsanitizer::getInstance();

        $the_id=explode("@",$user_profile['contact/email']);

        //$uid = $user['id'];
        $uname =$the_id[0]."_ilc";
        $name = $myts->addSlashes($user_profile['namePerson']);
        $email =  strtolower($user_profile['contact/email']);
        $SchoolCode = $myts->addSlashes($user_profile['axschema/school/id']);

        if($xoopsModuleConfig['real_jobname']=="1"){
          $var=json_decode($user_profile['axschema/school/titleStr'],true);
          $JobName=$var['title'][0];
        }else{
          $JobName = (strpos($user_profile['axschema/school/titleStr'],"學生")!==false)?"student":"teacher";
        }



        //搜尋有無相同username資料
        login_xoops($uname,$name,$email,$SchoolCode,$JobName);
      }
    }
  } catch(ErrorException $e) {
      $main=$e->getMessage();
  }

  $xoopsTpl->assign('openid',$main);
}


//新竹市 OpenID 登入
function hc_login(){
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
        $openid->identity =  "http://openid.hc.edu.tw";
        $openid->required = array('contact/email' , 'namePerson/friendly'  , 'namePerson');
        $openid->optional = array('contact/postalCode/home' , 'contact/country/home'  , 'pref/language','pref/timezone'  );
        header('Location: ' . $openid->authUrl());

    } else {
      $user_profile=$openid->getAttributes();
      //die(var_export($user_profile));
      // Login or logout url will be needed depending on current user state.
      /*
      array (
        'namePerson/friendly' => '楊--',
        'contact/email' => 's---@ms.hc.edu.tw',
        'namePerson' => '楊---',
        'birthDate' => '0001-01-01',
        'person/gender' => 'M',
        'contact/postalCode/home' => 'FA9A43A598D47034C15CDD7400B6D830F01904937C7A33BB68D909313DE48D4B',
        'contact/country/home' => '183---',
        'pref/language' => 'C980ED219C4EF2DE90474FF136D50C64',
        'pref/timezone' => '單位管理員',
      )
      */
      if ($user_profile) {
        $myts =& MyTextsanitizer::getInstance();

        $the_id=explode("@",$user_profile['contact/email']);

        //$uid = $user['id'];
        $uname =$the_id[0]."_hc";
        $name = $myts->addSlashes($user_profile['namePerson']);
        $email =  strtolower($user_profile['contact/email']);
        $SchoolCode = $myts->addSlashes($user_profile['contact/country/home']);

        if($xoopsModuleConfig['real_jobname']=="1"){
          $JobName=$user_profile['pref/timezone'];
        }else{
          $JobName = (strpos($user_profile['pref/timezone'],"學生")!==false)?"student":"teacher";
        }

        //搜尋有無相同username資料
        login_xoops($uname,$name,$email,$SchoolCode,$JobName);
      }
    }
  } catch(ErrorException $e) {
      $main=$e->getMessage();
  }

  $xoopsTpl->assign('openid',$main);
}


//花蓮縣登入
function hlc_login($conty="",$openid_identity=""){
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
        $openid->identity = $openid_identity;
        $openid->required = array('contact/email' , 'namePerson/friendly' , 'namePerson');
        $openid->optional = array('contact/country/home' , 'pref/timezone' );
        header('Location: ' . $openid->authUrl());

      }
    } else {
    /*
    array (
      'namePerson/friendly' => '謝xx',
      'contact/email' => 'xxx@hlc.edu.tw',
      'namePerson' => '謝xx',
      'birthDate' => '0001-01-01',
      'person/gender' => 'M',
      'contact/postalCode/home' => '05BD53048B408CED4C72A2BBA6596551AB5E9D57F6C59BA4901FC789127983C8',
      'contact/country/home' => '154621',
      'pref/language' => '000000',
      'pref/timezone' => '教師',
    )

    array (
      'namePerson/friendly' => '林xx',
      'contact/email' => 'xxx@ntpc.edu.tw',
      'namePerson' => '林xx',
      'birthDate' => '19xx-xx-14',
      'person/gender' => 'M',
      'contact/postalCode/home' => '5EE2EFC0E0722348C2B47AA5461F60FE69F811651068288F6F7F264BAF4620DA',
      'contact/country/home' => 'xx國中',
      'pref/language' => '000000',
      'pref/timezone' => '[{"id":"014569","name":"新北市立xx國民中學","role":"教師","title":"專任教師","groups":["科任教師"]}]',
    )
     */
      $user_profile=$openid->getAttributes();
      //die(var_export($user_profile));
      if ($user_profile) {
        $myts =& MyTextsanitizer::getInstance();

        $the_id=explode("@",$user_profile['contact/email']);

        //$uid = $user['id'];
        $uname =$the_id[0]."_".$conty;
        $name = $myts->addSlashes($user_profile['namePerson']);
        $email =  strtolower($user_profile['contact/email']);
        if($conty=="ntpc"){
          $arr=json_decode($user_profile['pref/timezone'],true);
          //die(var_export($arr));
          /*
          array (
            0 =>
            array (
              'id' => '014569',
              'name' => '新北市立xx國民中學',
              'role' => '教師',
              'title' => '專任教師',
              'groups' =>
              array (
                0 => '科任教師',
              ),
            ),
          )
           */
          $SchoolCode =$arr[0]['id'];

          if($xoopsModuleConfig['real_jobname']=="1"){
            $JobName=$arr[0]['role'];
          }else{
            $JobName = (strpos($arr[0]['role'],"學生")!==false)?"student":"teacher";
          }

        }else{
          $SchoolCode = $myts->addSlashes($user_profile['contact/country/home']);

          if($xoopsModuleConfig['real_jobname']=="1"){
            $JobName=$user_profile['pref/timezone'];
          }else{
            $JobName = (strpos($user_profile['pref/timezone'],"學生")!==false)?"student":"teacher";
          }
        }
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


//Google OAuth 2 登入
function google_v2_login(){
  global $xoopsConfig ,$xoopsDB , $xoopsTpl,$xoopsUser;
  include('class/hybridauth/Hybrid/Auth.php');

  if($xoopsUser){
    header("location:".XOOPS_URL . "/user.php");
    exit;
  }

  if (isset($_POST)) {
    foreach ( $_POST as $k => $v ) {
      ${$k} = $v;
    }
  }
  if (isset($_GET['op'])) {
    $op = trim($_GET['op']);
    if (isset($_GET['uid'])) {
      $uid = intval($_GET['uid']);
    }
  }

  $modhandler = &xoops_gethandler('module');
  $tad_loginModule = &$modhandler->getByDirname("tad_login");
  $config_handler =& xoops_gethandler('config');
  $tad_loginConfig= & $config_handler->getConfigsByCat(0, $tad_loginModule->getVar('mid'));

  $google_appId  = $tad_loginConfig['google_appId'];
  $google_secret = $tad_loginConfig['google_secret'];

  $provider = "Google";
  $config =array(
      "base_url" => XOOPS_URL."/modules/tad_login/index.php",
      "providers" => array (
        "Google" => array (
          "enabled" => true,
          "keys"    => array ( "id" => $google_appId, "secret" => $google_secret ),
        )
      ),
      // if you want to enable logging, set 'debug_mode' to true  then provide a writable file by the web server on "debug_file"
      "debug_mode" => true,
      "debug_file" => "debug_google.log",
    );
  try{

    $hybridauth = new Hybrid_Auth( $config );

    $authProvider = $hybridauth->authenticate($provider);

    $user_profile = $authProvider->getUserProfile();

    if($user_profile && isset($user_profile->identifier)) {
      die(var_export($user_profile));
    }
  } catch( Exception $e ) {

     switch( $e->getCode() ) {
      case 0 : echo "Unspecified error."; break;
      case 1 : echo "Hybridauth configuration error."; break;
      case 2 : echo "Provider not properly configured."; break;
      case 3 : echo "Unknown or disabled provider."; break;
      case 4 : echo "Missing provider application credentials."; break;
      case 5 : echo "Authentication failed. "
                       . "The user has canceled the authentication or the provider refused the connection.";
               break;
      case 6 : echo "User profile request failed. Most likely the user is not connected "
                       . "to the provider and he should to authenticate again.";
               $twitter->logout();
               break;
      case 7 : echo "User not connected to the provider.";
               $twitter->logout();
               break;
      case 8 : echo "Provider does not support this feature."; break;
    }

    // well, basically your should not display this to the end user, just give him a hint and move on..
    echo "<br /><br /><b>Original error message:</b> " . $e->getMessage();

    echo "<hr /><h3>Trace</h3> <pre>" . $e->getTraceAsString() . "</pre>";

  }
exit;
//die(var_export($user_profile));

  // Login or logout url will be needed depending on current user state.
  if ($user) {
    $myts =& MyTextsanitizer::getInstance();
    $uid = $user_profile['id'];
    $uname = empty($user_profile['username'])?$user_profile['id']."_fb":$user_profile['username']."_fb";
    $name = $myts->addSlashes($user_profile['name']);
    $email =  $user_profile['email'];
    $bio = $myts->addSlashes($user_profile['bio']);
    $url = formatURL($user_profile['link']);
    $form= $myts->addSlashes($user_profile['hometown']['name']);
    $sig= $myts->addSlashes($user_profile['quotes']);
    $occ= $myts->addSlashes($user_profile['work'][0]['employer']['name']);

    login_xoops($uname,$name,$email,"","",$url,$form,$sig,$occ,$bio);
  } else {
    //$args = array('scope' => 'email');
    //$loginUrl = $facebook->getLoginUrl($args);
    $loginUrl = $facebook->getLoginUrl(array(
    'scope' => 'email'
    //,'redirect_uri' => XOOPS_URL
    ));
  }
  if($mode=="return"){
    return $loginUrl;
  }else{
    $xoopsTpl->assign('facebook',$loginUrl);
  }
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




//台中版 OpenID 登入
function tc_login($conty="",$openid_identity=""){
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
        $openid->identity = $openid_identity;
        $openid->required = array('contact/email' , 'namePerson/friendly'  , 'namePerson');
        $openid->optional = array('axschema/person/guid' , 'axschema/school/titleStr'  , 'axschema/school/id','tw/person/guid' , 'tw/isas/roles'  );
        header('Location: ' . $openid->authUrl());

    } else {
      $user_profile=$openid->getAttributes();
      //die(var_export($user_profile));
      /*
      array (
        'axschema/person/guid' => 'ab1a1b5769b6886f40e8e1b2c349e36b470f76b51d3ed8e9e784843fa0ca9355',
        'axschema/school/titleStr' => '[{"id":"A00015","title":["編制人員"]}]',
        'axschema/school/id' => 'A00015',
        'contact/email' => '5348221@ylc.edu.tw',
        'namePerson' => '測試帳號',
      )

      array (
        'axschema/person/guid' => 'ab1a1b5769b6886f40e8e1b2c349e36b470f76b51d3ed8e9e784843fa0ca9355',
        'axschema/school/titleStr' => '[{"id":"094659","title":["教師"]}]',
        'axschema/school/id' => '094659',
        'contact/email' => '5348221@ylc.edu.tw',
        'namePerson' => '測試帳號',
      )
      //南投
      array (
        'axschema/person/guid' => '3ba3a257aec87686e0b52bb81c4ca338d04dd25205358e8730d5fa87cfdf2bff',
        'axschema/school/titleStr' => '[{\\"id\\":\\"084719a1\\",\\"title\\":[\\"教師\\"]},{\\"id\\":\\"084716a1\\",\\"title\\":[\\"教師\\"]}]',
        'axschema/school/id' => '084719a1',
        'contact/email' => 'kk@k.2.k',
        'namePerson' => '測試一',
      )
      //彰化
      array (
        'axschema/person/guid' => '4208f4152cb215d19edfa78d4e85ae2ccee65497ed68af69e5ca7641510d3af6',
        'axschema/school/titleStr' => '[{"id":"074628","title":["教師","學校管理者"]}]',
        'axschema/school/id' => '074628',
        'contact/email' => 'NA',
        'namePerson' => '測試',
      )
      */
      // Login or logout url will be needed depending on current user state.
      if ($user_profile) {
        $myts =& MyTextsanitizer::getInstance();

        $SchoolCode = $myts->addSlashes($user_profile['axschema/school/id']);

        if(strtoupper($user_profile['contact/email'])=="NA" or empty($user_profile['contact/email'])){
          $uname = substr($user_profile['axschema/person/guid'],0,6)."_{$conty}";
          $email = "{$uname}@{$SchoolCode}.{$conty}.edu.tw";
        }else{
          $the_id=explode("@",$user_profile['contact/email']);
          $uname =$the_id[0]."_".$conty;
          $email =  $user_profile['contact/email'];
        }
        //$uid = $user['id'];
        $name = $myts->addSlashes($user_profile['namePerson']);

        if($xoopsModuleConfig['real_jobname']=="1"){
          $user_profile['axschema/school/titleStr']=str_replace("\\", "", $user_profile['axschema/school/titleStr']);
          $var=json_decode($user_profile['axschema/school/titleStr'],true);
          $JobName=$var[0]['title'][0];
        }else{
          $JobName = (strpos($user_profile['axschema/school/titleStr'],"學生")!==false)?"student":"teacher";
        }


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
  case "facebook":
  $_SESSION['auth_method']="facebook";
  facebook_login();
  break;

  case "google":
  $_SESSION['auth_method']="google";
  google_login();
  break;

  case "google_v2":
  $_SESSION['auth_method']="google_v2";
  google_v2_login();
  break;

  case "twitter":
  $_SESSION['auth_method']="twitter";
  twitter_login();
  break;

  case "yahoo":
  $_SESSION['auth_method']="yahoo";
  yahoo_login();
  break;

  case "myid":
  $_SESSION['auth_method']="myid";
  myid_login();
  break;

  case "tn":
  $_SESSION['auth_method']="tn";
  tn_login();
  break;

  case "cyc":
  $_SESSION['auth_method']="cyc";
  tc_login("cyc",'http://openid.cyccc.tw');
  break;

  case "ylc":
  $_SESSION['auth_method']="ylc";
  tc_login("ylc","http://openid.ylc.edu.tw");
  break;

  case "hcc":
  $_SESSION['auth_method']="hcc";
  tc_login("hcc","http://openid.hcc.edu.tw");
  break;

  case "hc":
  $_SESSION['auth_method']="hc";
  hc_login();
  break;

  case "mlc":
  $_SESSION['auth_method']="mlc";
  tc_login("mlc","http://openid.mlc.edu.tw");
  break;

  case "chc":
  $_SESSION['auth_method']="chc";
  tc_login("chc","http://openid.chc.edu.tw");
  break;

  case "ntct":
  $_SESSION['auth_method']="ntct";
  tc_login("ntct","http://openid.ntct.edu.tw");
  break;

  case "cy":
  $_SESSION['auth_method']="cy";
  tc_login("cy","http://openid.cy.edu.tw");
  break;

  case "tc":
  $_SESSION['auth_method']="tc";
  tc_login("tc","http://openid.tc.edu.tw");
  break;

  case "ptc":
  $_SESSION['auth_method']="ptc";
  tc_login("ptc","http://openid.ptc.edu.tw");
  break;

  case "hlc":
  $_SESSION['auth_method']="hlc";
  hlc_login('hlc',"http://openid.hlc.edu.tw");
  break;

  case "ntpc":
  $_SESSION['auth_method']="ntpc";
  hlc_login('ntpc',"https://openid.ntpc.edu.tw");
  break;

  case "phc":
  $_SESSION['auth_method']="phc";
  tc_login("phc","http://openid.phc.edu.tw");
  break;

  case "kl":
  $_SESSION['auth_method']="kl";
  kl_login();
  break;

  case "ilc":
  $_SESSION['auth_method']="ilc";
  ilc_login();
  break;


  default:
  if($_SESSION['auth_method']=="facebook"){
    facebook_login();
  }elseif($_SESSION['auth_method']=="google"){
    google_login();
  }elseif($_SESSION['auth_method']=="google_v2"){
    google_v2_login();
  }elseif($_SESSION['auth_method']=="twitter"){
    twitter_login();
  }elseif($_SESSION['auth_method']=="yahoo"){
    yahoo_login();
  }elseif($_SESSION['auth_method']=="myid"){
    myid_login();
  }elseif($_SESSION['auth_method']=="tn"){
    tn_login();
  }elseif($_SESSION['auth_method']=="kl"){
    kl_login();
  }elseif($_SESSION['auth_method']=="ilc"){
    ilc_login();
  }elseif($_SESSION['auth_method']=="cyc"){
    tc_login("cyc",'http://openid.cyccc.tw');
  }elseif($_SESSION['auth_method']=="ylc"){
    tc_login("ylc","http://openid.ylc.edu.tw");
  }elseif($_SESSION['auth_method']=="hcc"){
    tc_login("hcc","http://openid.hcc.edu.tw");
  }elseif($_SESSION['auth_method']=="hc"){
    hc_login();
  }elseif($_SESSION['auth_method']=="mlc"){
    tc_login("mlc","http://openid.mlc.edu.tw");
  }elseif($_SESSION['auth_method']=="chc"){
    tc_login("chc","http://openid.chc.edu.tw");
  }elseif($_SESSION['auth_method']=="ntct"){
    tc_login("ntct","http://openid.ntct.edu.tw");
  }elseif($_SESSION['auth_method']=="cy"){
    tc_login("cy","http://openid.cy.edu.tw");
  }elseif($_SESSION['auth_method']=="tc"){
    tc_login("tc","http://openid.tc.edu.tw");
  }elseif($_SESSION['auth_method']=="ntpc"){
    hlc_login('ntpc',"http://openid.ntpc.edu.tw");
  }elseif($_SESSION['auth_method']=="hlc"){
    hlc_login('hlc',"http://openid.hlc.edu.tw");
  }elseif($_SESSION['auth_method']=="ptc"){
    tc_login("ptc","http://openid.ptc.edu.tw");
  }elseif($_SESSION['auth_method']=="phc"){
    tc_login("phc","http://openid.phc.edu.tw");
  }else{
    require_once( "class/hybridauth/Hybrid/Auth.php" );
    require_once( "class/hybridauth/Hybrid/Endpoint.php" );

    Hybrid_Endpoint::process();

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
<?php
/*-----------引入檔案區--------------*/
$xoopsOption['template_main'] = "tad_login_adm_main.html";
include_once "header.php";
include_once "../function.php";


/*-----------function區--------------*/


//FB登入說明
function facebook_desc(){
  global $xoopsTpl;
  $main="
    <p>"._MA_TAD_LOGIN_STEP1."</p><br>
    <img src='../images/step1.png' alt='step1.png, 24kB' title='Step1' border='0' height='186' width='1011'><br><br>
    <p>"._MA_TAD_LOGIN_STEP2."</p><br>
    <img src='../images/step2.png' alt='step2.png, 11kB' title='Step2' border='0' height='222' width='632'><br><br>
    <p>"._MA_TAD_LOGIN_STEP3."</p><br>
    <img src='../images/step3.png' alt='step3.png, 25kB' title='Step3' border='0' height='314' width='632'><br><br>
    <p>"._MA_TAD_LOGIN_STEP4."</p><br>
    <img src='../images/step4.png' alt='step4.png, 28kB' title='Step4' border='0' height='477' width='715'><br><br>
    <p>"._MA_TAD_LOGIN_STEP5."</p><br>
    <img src='../images/step5.png' alt='step5.png, 16kB' title='Step5' border='0' height='248' width='987'><br><br>
    <p>"._MA_TAD_LOGIN_STEP6."</p><br>
    <img src='../images/step6.png' alt='step6.png, 3.9kB' title='Step6' border='0' height='99' width='250'><br><br>
    <p>"._MA_TAD_LOGIN_STEP7."</p><br>
    <img src='../images/step7.png' alt='step7.png, 19kB' title='Step7' border='0' height='299' width='660'><br><br>
    <p>"._MA_TAD_LOGIN_STEP8."</p><br>
    <img src='../images/step8.png' alt='step8.png, 27kB' title='Step8' border='0' height='559' width='766'><br><br>
    <hr>
    <p>"._MA_TAD_LOGIN_STEP9."</p><br>
    <img src='../images/step9.png' alt='step9.png, 8.6kB' title='Step9' border='0' height='252' width='569'><br><br>
    <p>"._MA_TAD_LOGIN_STEP10."</p><br>
    <img src='../images/step10.png' alt='step10.png, 10kB' title='Step10' border='0' height='32' width='677'><br><br>
    <p>"._MA_TAD_LOGIN_STEP11."</p><br>
    <img src='../images/step11.png' alt='step11.png, 5.3kB' title='Step11' border='0' height='118' width='716'><br><br>
  ";
  $xoopsTpl->assign("main",$main) ;
}


/*-----------執行動作判斷區----------*/
$op = (!isset($_REQUEST['op']))? "":$_REQUEST['op'];

switch($op){
  /*---判斷動作請貼在下方---*/

  //預設動作
  default:
  facebook_desc();
  break;

  /*---判斷動作請貼在上方---*/
}

/*-----------秀出結果區--------------*/

include_once 'footer.php';
?>
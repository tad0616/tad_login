<?php
/*-----------引入檔案區--------------*/
$xoopsOption['template_main'] = "tad_login_adm_fb.html";
include_once "header.php";
include_once "../function.php";

/*-----------function區--------------*/

//FB登入說明
function facebook_desc() {
    global $xoopsTpl;
    $main = "
    <label>" . _MA_TADLOGIN_STEP1 . "</label><br>
    <img src='../images/fb/step01.png' alt='step1' title='step1' border='0' class='img-polaroid'><br><br>
    <label>" . _MA_TADLOGIN_STEP2 . "</label><br>
    <img src='../images/fb/step02.png' alt='step2' title='step2' border='0' class='img-polaroid'><br><br>
    <label>" . _MA_TADLOGIN_STEP3 . "</label><br>
    <img src='../images/fb/step03.png' alt='step3' title='step3' border='0' class='img-polaroid'><br><br>
    <label>" . _MA_TADLOGIN_STEP4 . "</label><br>
    <img src='../images/fb/step04.png' alt='step4' title='step4' border='0' class='img-polaroid'><br><br>
    <label>" . _MA_TADLOGIN_STEP5 . "</label><br>
    <img src='../images/fb/step05.png' alt='step5' title='step5' border='0' class='img-polaroid'><br><br>
    <hr>
    <label>" . _MA_TADLOGIN_STEP6 . "</label><br>
    <img src='../images/fb/step06.png' alt='step6' title='step6' border='0' class='img-polaroid'><br><br>
    <label>" . _MA_TADLOGIN_STEP7 . "</label><br>
    <img src='../images/fb/step07.png' alt='step7' title='step7' border='0' class='img-polaroid'><br><br>
    <label>" . _MA_TADLOGIN_STEP8 . "</label><br>
    <img src='../images/fb/step08.png' alt='step8' title='step8' border='0' class='img-polaroid'><br><br>
    <label>" . _MA_TADLOGIN_STEP9 . "</label><br>
    <img src='../images/fb/step09.png' alt='step9' title='step9' border='0' class='img-polaroid'><br><br>
    <label>" . _MA_TADLOGIN_STEP10 . "</label><br>
    <img src='../images/fb/step10.png' alt='step10' title='step10' border='0' class='img-polaroid'><br><br>
    <label>" . _MA_TADLOGIN_STEP11 . "</label><br>
    <img src='../images/fb/step11.png' alt='step11' title='step11' border='0' class='img-polaroid'><br><br>
    <label>" . _MA_TADLOGIN_STEP12 . "</label><br>
    <img src='../images/fb/step12.png' alt='step12' title='step12' border='0' class='img-polaroid'><br><br>
    <label>" . _MA_TADLOGIN_STEP13 . "</label><br>
    <img src='../images/fb/step13.png' alt='step13' title='step13' border='0' class='img-polaroid'><br><br>
    <label>" . _MA_TADLOGIN_STEP14 . "</label><br>
    <img src='../images/fb/step14.png' alt='step14' title='step14' border='0' class='img-polaroid'><br><br>
    <label>" . _MA_TADLOGIN_STEP15 . "</label><br>
    <img src='../images/fb/step15.png' alt='step15' title='step14' border='0' class='img-polaroid'><br><br>
  ";
    $xoopsTpl->assign("main", $main);
}

/*-----------執行動作判斷區----------*/
$op = (!isset($_REQUEST['op'])) ? "" : $_REQUEST['op'];

switch ($op) {
    /*---判斷動作請貼在下方---*/

    //預設動作
    default:
        facebook_desc();
        break;

    /*---判斷動作請貼在上方---*/
}

/*-----------秀出結果區--------------*/

include_once 'footer.php';

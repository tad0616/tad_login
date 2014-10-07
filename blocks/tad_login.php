<?php
//區塊主函式 (快速登入(tad_login))
function tad_login($options=""){
  global $xoopsConfig ,$xoopsDB ,$xoopsUser;
  if($xoopsUser)return;

  include_once XOOPS_ROOT_PATH."/modules/tad_login/function.php";
  $block['facebook'] =facebook_login('return');
  $block['google'] =google_login('return');

  $modhandler = &xoops_gethandler('module');
  $xoopsModule = &$modhandler->getByDirname("tad_login");
  $config_handler =& xoops_gethandler('config');
  $modConfig= & $config_handler->getConfigsByCat(0, $xoopsModule->getVar('mid'));

  $block['auth_method']=$modConfig['auth_method'];
  $block['show_btn']=$options[0];
  $block['show_text']=$options[1];

  return $block;
}


function tad_login_edit($options=""){
  global $xoopsConfig ,$xoopsDB ,$xoopsUser;
  $opt0_1=$options[0]=='1'?"checked":"";
  $opt0_0=$options[0]=='0'?"checked":"";
  $opt1_1=$options[1]=='1'?"checked":"";
  $opt1_0=$options[1]=='0'?"checked":"";

  $main="
  <div>
  "._MB_TADLOGIN_LOGIN_BUTTON."
  <input type='radio' name='options[0]' value='1' $opt0_1>"._YES."
  <input type='radio' name='options[0]' value='0' $opt0_0>"._NO."
  </div>
  <div>
  "._MB_TADLOGIN_LOGIN_TEXT."
  <input type='radio' name='options[1]' value='1' $opt1_1>"._YES."
  <input type='radio' name='options[1]' value='0' $opt1_0>"._NO."
  </div>
  ";
  return $main;
}
?>
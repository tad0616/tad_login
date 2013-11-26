<?php
//區塊主函式 (快速登入(tad_login))
function tad_login(){
  global $xoopsConfig ,$xoopsDB ,$xoopsUser;
  if($xoopsUser)return;

  include_once XOOPS_ROOT_PATH."/modules/tad_login/function.php";
  $block['facebook'] =facebook_login('return');

  $modhandler = &xoops_gethandler('module');
  $xoopsModule = &$modhandler->getByDirname("tad_login");
  $config_handler =& xoops_gethandler('config');
  $modConfig= & $config_handler->getConfigsByCat(0, $xoopsModule->getVar('mid'));

  $block['auth_method']=$modConfig['auth_method'];
  return $block;
}
?>
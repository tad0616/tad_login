<?php
/*-----------引入檔案區--------------*/
$xoopsOption['template_main'] = "tad_login_adm_main.html";
include_once "header.php";
include_once "../function.php";

/*-----------function區--------------*/

//tad_login_config編輯表單
function tad_login_config_form($config_id = "")
{
    global $xoopsDB, $xoopsTpl;
    include_once XOOPS_ROOT_PATH . "/class/xoopsformloader.php";
    //抓取預設值
    if (!empty($config_id)) {
        $DBV = get_tad_login_config($config_id);
    } else {
        $DBV = array();
    }

    //預設值設定

    //設定「config_id」欄位預設值
    $config_id = !isset($DBV['config_id']) ? $config_id : $DBV['config_id'];
    $xoopsTpl->assign('config_id', $config_id);

    //設定「item」欄位預設值
    $item = !isset($DBV['item']) ? "" : $DBV['item'];
    $xoopsTpl->assign('item', $item);

    //設定「kind」欄位預設值
    $kind = !isset($DBV['kind']) ? "" : $DBV['kind'];
    $xoopsTpl->assign('kind', $kind);

    //設定「group_id」欄位預設值
    $group_id = !isset($DBV['group_id']) ? "" : $DBV['group_id'];
    $xoopsTpl->assign('group_id', $group_id);

    $op = (empty($config_id)) ? "insert_tad_login_config" : "update_tad_login_config";
    //$op="replace_tad_login_config";

    if (!file_exists(TADTOOLS_PATH . "/formValidator.php")) {
        redirect_header("index.php", 3, _MA_NEED_TADTOOLS);
    }
    include_once TADTOOLS_PATH . "/formValidator.php";
    $formValidator      = new formValidator("#myForm", true);
    $formValidator_code = $formValidator->render();

    $xoopsTpl->assign('action', $_SERVER["PHP_SELF"]);
    $xoopsTpl->assign('formValidator_code', $formValidator_code);
    $xoopsTpl->assign('now_op', 'tad_login_config_form');
    $xoopsTpl->assign('next_op', $op);

    //群組
    $SelectGroup_name = new XoopsFormSelectGroup("", "group_id", true, $group_id, 6);
    $SelectGroup_name->setExtra("class='span12 form-control'");
    $group_menu = $SelectGroup_name->render();
    $xoopsTpl->assign('group_menu', $group_menu);
}

//新增資料到tad_login_config中
function insert_tad_login_config()
{
    global $xoopsDB, $xoopsUser;

    $myts          = &MyTextSanitizer::getInstance();
    $_POST['item'] = $myts->addSlashes($_POST['item']);

    if ($_POST['type'] == "email") {
        $item = $_POST['item_email'];
        $kind = $_POST['kind_email'];
    } else {
        $item = $_POST['item_schoolcode'];
        $kind = $_POST['kind_schoolcode'];
    }

    $sql = "insert into `" . $xoopsDB->prefix("tad_login_config") . "`
  (`item` , `kind` , `group_id`)
  values('{$item}' , '{$kind}', '{$_POST['group_id']}')";
    $xoopsDB->query($sql) or redirect_header($_SERVER['PHP_SELF'], 3, mysql_error());

    //取得最後新增資料的流水編號
    $config_id = $xoopsDB->getInsertId();

    return $config_id;
}

//更新tad_login_config某一筆資料
function update_tad_login_config($config_id = "")
{
    global $xoopsDB, $xoopsUser;

    $myts          = &MyTextSanitizer::getInstance();
    $_POST['item'] = $myts->addSlashes($_POST['item']);

    if ($_POST['type'] == "email") {
        $item = $_POST['item_email'];
        $kind = $_POST['kind_email'];
    } else {
        $item = $_POST['item_schoolcode'];
        $kind = $_POST['kind_schoolcode'];
    }

    $sql = "update `" . $xoopsDB->prefix("tad_login_config") . "` set
   `item` = '{$item}' ,
   `kind` = '{$kind}' ,
   `group_id` = '{$_POST['group_id']}'
  where `config_id` = '$config_id'";

    $xoopsDB->queryF($sql) or redirect_header($_SERVER['PHP_SELF'], 3, mysql_error());

    return $config_id;
}

//列出所有tad_login_config資料
function list_tad_login_config()
{
    global $xoopsDB, $xoopsTpl, $isAdmin;

    $sql    = "select * from `" . $xoopsDB->prefix("groups") . "` ";
    $result = $xoopsDB->query($sql) or redirect_header($_SERVER['PHP_SELF'], 3, mysql_error());
    $groups = "";
    $i      = 0;
    while ($all = $xoopsDB->fetchArray($result)) {
        foreach ($all as $k => $v) {
            $$k = $v;
        }
        $groups[$groupid] = $name;
    }

    $sql    = "select * from `" . $xoopsDB->prefix("tad_login_config") . "` ";
    $result = $xoopsDB->query($sql) or redirect_header($_SERVER['PHP_SELF'], 3, mysql_error());

    $all_content = "";
    $i           = 0;
    while ($all = $xoopsDB->fetchArray($result)) {
        //以下會產生這些變數： $config_id , $item , $group_id
        foreach ($all as $k => $v) {
            $$k = $v;
        }

        $all_content[$i]['config_id'] = $config_id;
        if ($kind == "teacher") {
            $all_content[$i]['kind'] = _MA_TADLOGIN_TEACHER;
        } elseif ($kind == "email") {
            $all_content[$i]['kind'] = '';
        } elseif ($kind == "student") {
            $all_content[$i]['kind'] = _MA_TADLOGIN_STUDENT;
        }
        $all_content[$i]['item']       = $item;
        $all_content[$i]['group_id']   = $group_id;
        $all_content[$i]['group_name'] = $groups[$group_id];
        $i++;
    }

    $xoopsTpl->assign('action', $_SERVER['PHP_SELF']);
    $xoopsTpl->assign('isAdmin', $isAdmin);
    $xoopsTpl->assign('all_content', $all_content);
    $xoopsTpl->assign('now_op', 'list_tad_login_config');

}

//以流水號取得某筆tad_login_config資料
function get_tad_login_config($config_id = "")
{
    global $xoopsDB;
    if (empty($config_id)) {
        return;
    }
    $sql    = "select * from `" . $xoopsDB->prefix("tad_login_config") . "` where `config_id` = '{$config_id}'";
    $result = $xoopsDB->query($sql) or redirect_header($_SERVER['PHP_SELF'], 3, mysql_error());
    $data   = $xoopsDB->fetchArray($result);

    return $data;
}

//刪除tad_login_config某筆資料資料
function delete_tad_login_config($config_id = "")
{
    global $xoopsDB, $isAdmin;
    $sql = "delete from `" . $xoopsDB->prefix("tad_login_config") . "` where `config_id` = '{$config_id}'";
    $xoopsDB->queryF($sql) or redirect_header($_SERVER['PHP_SELF'], 3, mysql_error());
}

//以流水號秀出某筆tad_login_config資料內容
function show_one_tad_login_config($config_id = "")
{
    global $xoopsDB, $xoopsTpl, $isAdmin;

    if (empty($config_id)) {
        return;
    } else {
        $config_id = (int) ($config_id);
    }

    $sql    = "select * from `" . $xoopsDB->prefix("tad_login_config") . "` where `config_id` = '{$config_id}' ";
    $result = $xoopsDB->query($sql) or redirect_header($_SERVER['PHP_SELF'], 3, mysql_error());
    $all    = $xoopsDB->fetchArray($result);

    //以下會產生這些變數： $config_id , $item , $group_id
    foreach ($all as $k => $v) {
        $$k = $v;
    }

    $xoopsTpl->assign('config_id', $config_id);
    $xoopsTpl->assign('item', $item);
    $xoopsTpl->assign('group_id', $group_id);

    $xoopsTpl->assign('now_op', 'show_one_tad_login_config');
    $xoopsTpl->assign('title', '');
}

/*-----------執行動作判斷區----------*/
$op        = (!isset($_REQUEST['op'])) ? "" : $_REQUEST['op'];
$config_id = (!isset($_REQUEST['config_id'])) ? "" : (int) ($_REQUEST['config_id']);

switch ($op) {
    /*---判斷動作請貼在下方---*/

    //替換資料
    case "replace_tad_login_config":
        replace_tad_login_config();
        header("location: {$_SERVER['PHP_SELF']}");
        break;

    //新增資料
    case "insert_tad_login_config":
        $config_id = insert_tad_login_config();
        header("location: {$_SERVER['PHP_SELF']}");
        break;

    //更新資料
    case "update_tad_login_config":
        update_tad_login_config($config_id);
        header("location: {$_SERVER['PHP_SELF']}");
        break;

    //輸入表格
    case "tad_login_config_form":
        tad_login_config_form($config_id);
        break;

    //刪除資料
    case "delete_tad_login_config":
        delete_tad_login_config($config_id);
        header("location: {$_SERVER['PHP_SELF']}");
        break;

    //預設動作
    default:
        if (empty($config_id)) {
            list_tad_login_config();
            //$main.=tad_login_config_form($config_id);
        } else {
            show_one_tad_login_config($config_id);
        }
        break;

}

/*-----------秀出結果區--------------*/

include_once 'footer.php';

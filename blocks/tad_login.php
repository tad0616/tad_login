<?php
//區塊主函式 (快速登入(tad_login))
function tad_login($options = "")
{
    global $xoopsConfig, $xoopsDB, $xoopsUser;
    if ($xoopsUser) {
        return;
    }

    include_once XOOPS_ROOT_PATH . "/modules/tad_login/function.php";

    $modhandler     = xoops_getHandler('module');
    $xoopsModule    = $modhandler->getByDirname("tad_login");
    $config_handler = xoops_getHandler('config');
    $modConfig      = $config_handler->getConfigsByCat(0, $xoopsModule->getVar('mid'));

    $block['show_btn']  = $options[0];
    $block['show_text'] = $options[1];
    $big                = ($options[2] == '1') ? '_l' : '';
    $i                  = 0;
    foreach ($modConfig['auth_method'] as $openid) {
        if ($openid == 'facebook') {
            $url = facebook_login('return');
        } elseif ($openid == 'google') {
            $url = google_login('return');
        } elseif ($openid == 'edu') {
            $url = edu_login('return');
        } else {
            $url = XOOPS_URL . "/modules/tad_login/index.php?login&op={$openid}";
        }
        $auth_method[$i]['title'] = $openid;
        $auth_method[$i]['url']   = $url;
        $auth_method[$i]['logo']  = XOOPS_URL . "/modules/tad_login/images/{$openid}{$big}.png";
        $auth_method[$i]['text']  = constant('_' . strtoupper($openid)) . _MB_TADLOGIN_LOGIN;
        $i++;
    }

    $block['auth_method'] = $auth_method;
    $block['use_big']     = ($options[2] == '1') ? '1' : '0';

    return $block;
}

function tad_login_edit($options = "")
{
    global $xoopsConfig, $xoopsDB, $xoopsUser;
    $opt0_1 = $options[0] != '0' ? "checked" : "";
    $opt0_0 = $options[0] == '0' ? "checked" : "";
    $opt1_1 = $options[1] != '0' ? "checked" : "";
    $opt1_0 = $options[1] == '0' ? "checked" : "";
    $opt2_1 = $options[2] == '1' ? "checked" : "";
    $opt2_0 = $options[2] != '1' ? "checked" : "";

    $main = "
    <ol class='my-form'>
        <li class='my-row'>
            <lable class='my-label'>" . _MB_TADLOGIN_LOGIN_BUTTON . "</lable>
            <div class='my-content'>
                <input type='radio' name='options[0]' value='1' $opt0_1>" . _YES . "
                <input type='radio' name='options[0]' value='0' $opt0_0>" . _NO . "
            </div>
        </li>
        <li class='my-row'>
            <lable class='my-label'>" . _MB_TADLOGIN_LOGIN_TEXT . "</lable>
            <div class='my-content'>
                <input type='radio' name='options[1]' value='1' $opt1_1>" . _YES . "
                <input type='radio' name='options[1]' value='0' $opt1_0>" . _NO . "
            </div>
        </li>
        <li class='my-row'>
            <lable class='my-label'>" . _MB_TADLOGIN_LOGIN_BIG . "</lable>
            <div class='my-content'>
                <input type='radio' name='options[2]' value='1' $opt2_1>" . _YES . "
                <input type='radio' name='options[2]' value='0' $opt2_0>" . _NO . "
            </div>
        </li>
    </ol>";

    return $main;
}

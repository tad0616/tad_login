<?php
//區塊主函式 (快速登入(tad_login))
function tad_login($options = '')
{
    global $xoopsConfig, $xoopsDB, $xoopsUser;
    if ($xoopsUser) {
        return;
    }
    require_once XOOPS_ROOT_PATH . '/modules/tad_login/function.php';
    require_once XOOPS_ROOT_PATH . '/modules/tad_login/oidc.php';

    $moduleHandler = xoops_getHandler('module');
    $xoopsModule = $moduleHandler->getByDirname('tad_login');
    $configHandler = xoops_getHandler('config');
    $modConfig = $configHandler->getConfigsByCat(0, $xoopsModule->mid());

    $block['show_btn'] = $options[0];
    $block['show_text'] = $options[1];
    $big = ('1' == $options[2]) ? '_l' : '';
    $i = 0;
    foreach ($modConfig['auth_method'] as $openid) {
        if ('facebook' === $openid) {
            $url = facebook_login('return');
        } elseif ('google' === $openid) {
            $url = google_login('return');
        } elseif (in_array($openid, $oidc_array)) {
            $url = edu_login($openid, 'return');
        } else {
            $url = XOOPS_URL . "/modules/tad_login/index.php?login&op={$openid}";
        }
        $auth_method[$i]['title'] = $openid;
        $auth_method[$i]['url'] = $url;
        $auth_method[$i]['logo'] = in_array($openid, $oidc_array) ? XOOPS_URL . "/modules/tad_login/images/oidc/{$all_oidc[$openid]['tail']}.png" : XOOPS_URL . "/modules/tad_login/images/{$openid}{$big}.png";
        $auth_method[$i]['text'] = in_array($openid, $oidc_array) ? constant('_' . mb_strtoupper($all_oidc[$openid]['tail'])) . ' OIDC ' . _MB_TADLOGIN_LOGIN : constant('_' . mb_strtoupper($openid)) . ' OpenID ' . _MB_TADLOGIN_LOGIN;

        $i++;
    }

    $block['all_oidc'] = $all_oidc;
    $block['oidc_array'] = $oidc_array;
    $block['oidc_array2'] = $oidc_array2;
    $block['all_oidc2'] = $all_oidc2;

    $block['auth_method'] = $auth_method;
    $block['use_big'] = ('1' == $options[2]) ? '1' : '0';

    return $block;
}

function tad_login_edit($options = '')
{
    global $xoopsConfig, $xoopsDB, $xoopsUser;
    $opt0_1 = '0' != $options[0] ? 'checked' : '';
    $opt0_0 = '0' == $options[0] ? 'checked' : '';
    $opt1_1 = '0' != $options[1] ? 'checked' : '';
    $opt1_0 = '0' == $options[1] ? 'checked' : '';
    $opt2_1 = '1' == $options[2] ? 'checked' : '';
    $opt2_0 = '1' != $options[2] ? 'checked' : '';

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
                <input type='radio' name='options[2]' value='0' $opt2_0>" . _NO . '
            </div>
        </li>
    </ol>';

    return $main;
}

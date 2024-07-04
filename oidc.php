<?php
$all_oidc = [
    'edu_oidc' => [
        'tail' => 'edu',
        'provideruri' => 'https://oidc.tanet.edu.tw',
        'eduinfoep' => 'https://oidc.tanet.edu.tw/moeresource/api/v1/oidc/eduinfo',
        'scope' => ['openid', 'email', 'profile', 'openid2'],
        'gzipenable' => true,
        'from' => '',
    ],
    'moe_oidc' => [
        'tail' => 'moe',
        'provideruri' => 'https://moe.sso.edu.tw',
        'eduinfoep' => 'https://moe.sso.edu.tw/cncresource/api/v1/eduinfo',
        'scope' => ['educloudroles', 'openid', 'profile', 'eduinfo', 'openid2', 'email'],
        'gzipenable' => false,
        'from' => '',
    ],
    'kl_oidc' => [
        'tail' => 'kl',
        'provideruri' => 'https://kl.sso.edu.tw',
        'eduinfoep' => 'https://kl.sso.edu.tw/cncresource/api/v1/eduinfo',
        'scope' => ['educloudroles', 'openid', 'profile', 'eduinfo', 'openid2', 'email'],
        'gzipenable' => false,
        'from' => '基隆市',
    ],
    // 'tp_oidc' => [
    //     'tail' => 'tp',
    //     'provideruri' => 'https://tp.sso.edu.tw',
    //     'eduinfoep' => 'https://tp.sso.edu.tw/cncresource/api/v1/eduinfo',
    //     'scope' => ['educloudroles', 'openid', 'profile', 'eduinfo', 'openid2', 'email'],
    //     'gzipenable' => false,
    //     'from' => '臺北市',
    // ],
    'ntpc_oidc' => [
        'tail' => 'ntpc',
        'provideruri' => 'https://ntpc.sso.edu.tw',
        'eduinfoep' => 'https://ntpc.sso.edu.tw/cncresource/api/v1/eduinfo',
        'scope' => ['educloudroles', 'openid', 'profile', 'eduinfo', 'openid2', 'email'],
        'gzipenable' => false,
        'from' => '新北市',
    ],
    'ty_oidc' => [
        'tail' => 'ty',
        'provideruri' => 'https://tyc.sso.edu.tw',
        'eduinfoep' => 'https://tyc.sso.edu.tw/cncresource/api/v1/eduinfo',
        'scope' => ['openid', 'openid2', 'email', 'profile', 'eduinfo'],
        'gzipenable' => false,
        'from' => '桃園市',
    ],
    'hc_oidc' => [
        'tail' => 'hc',
        'provideruri' => 'https://hc.sso.edu.tw',
        'eduinfoep' => 'https://hc.sso.edu.tw/cncresource/api/v1/eduinfo',
        'scope' => ['educloudroles', 'openid', 'profile', 'eduinfo', 'openid2', 'email'],
        'gzipenable' => false,
        'from' => '新竹市',
    ],
    'hcc_oidc' => [
        'tail' => 'hcc',
        'provideruri' => 'https://hcc.sso.edu.tw',
        'eduinfoep' => 'https://hcc.sso.edu.tw/cncresource/api/v1/eduinfo',
        'scope' => ['educloudroles', 'openid', 'profile', 'eduinfo', 'openid2', 'email'],
        'gzipenable' => false,
        'from' => '新竹縣',
    ],
    'mlc_oidc' => [
        'tail' => 'mlc',
        'provideruri' => 'https://mlc.sso.edu.tw',
        'eduinfoep' => 'https://mlc.sso.edu.tw/cncresource/api/v1/eduinfo',
        'scope' => ['educloudroles', 'openid', 'profile', 'eduinfo', 'openid2', 'email'],
        'gzipenable' => false,
        'from' => '苗栗縣',
    ],
    'tc_oidc' => [
        'tail' => 'tc',
        'provideruri' => 'https://tc.sso.edu.tw',
        'eduinfoep' => 'https://tc.sso.edu.tw/cncresource/api/v1/eduinfo',
        'scope' => ['educloudroles', 'openid', 'profile', 'eduinfo', 'openid2', 'email'],
        'gzipenable' => false,
        'from' => '臺中市',
    ],
    'chc_oidc' => [
        'tail' => 'chc',
        'provideruri' => 'https://chc.sso.edu.tw',
        'eduinfoep' => 'https://chc.sso.edu.tw/cncresource/api/v1/eduinfo',
        'scope' => ['educloudroles', 'openid', 'profile', 'eduinfo', 'openid2', 'email'],
        'gzipenable' => false,
        'from' => '彰化縣',
    ],
    'ntct_oidc' => [
        'tail' => 'ntct',
        'provideruri' => 'https://ntct.sso.edu.tw',
        'eduinfoep' => 'https://ntct.sso.edu.tw/cncresource/api/v1/eduinfo',
        'scope' => ['educloudroles', 'openid', 'profile', 'eduinfo', 'openid2', 'email'],
        'gzipenable' => false,
        'from' => '南投縣',
    ],
    'ylc_oidc' => [
        'tail' => 'ylc',
        'provideruri' => 'https://ylc.sso.edu.tw',
        'eduinfoep' => 'https://ylc.sso.edu.tw/cncresource/api/v1/eduinfo',
        'scope' => ['educloudroles', 'openid', 'profile', 'eduinfo', 'openid2', 'email'],
        'gzipenable' => false,
        'from' => '雲林縣',
    ],
    'cyc_oidc' => [
        'tail' => 'cyc',
        'provideruri' => 'https://cyc.sso.edu.tw',
        'eduinfoep' => 'https://cyc.sso.edu.tw/cncresource/api/v1/eduinfo',
        'scope' => ['educloudroles', 'openid', 'profile', 'eduinfo', 'openid2', 'email'],
        'gzipenable' => false,
        'from' => '嘉義縣',
    ],
    // 'cy_oidc' => [
    //     'tail' => 'cy',
    //     'provideruri' => 'https://cy.sso.edu.tw',
    //     'eduinfoep' => 'https://cy.sso.edu.tw/cncresource/api/v1/eduinfo',
    //     'scope' => ['educloudroles', 'openid', 'profile', 'eduinfo', 'openid2', 'email'],
    //     'gzipenable' => false,
    //     'from'=>'嘉義市',
    // ],
    'kh_oidc' => [
        'tail' => 'kh',
        'gzipenable' => false,
        'scope' => ['openid', 'profile', 'email', 'kh_profile', 'kh_titles'],
        'providerparams' => ['token_endpoint_auth_methods_supported' => ["client_secret_post"]],
        'ignore_userinfo' => true,
        'provideruri' => 'https://oidc.kh.edu.tw',
        'from' => '高雄市',
    ],
    'ptc_oidc' => [
        'tail' => 'ptc',
        'provideruri' => 'https://ptc.sso.edu.tw',
        'eduinfoep' => 'https://ptc.sso.edu.tw/cncresource/api/v1/eduinfo',
        'scope' => ['educloudroles', 'openid', 'profile', 'eduinfo', 'openid2', 'email'],
        'gzipenable' => false,
        'from' => '屏東縣',
    ],
    'ilc_oidc' => [
        'tail' => 'ilc',
        'provideruri' => 'https://ilc.sso.edu.tw',
        'eduinfoep' => 'https://ilc.sso.edu.tw/cncresource/api/v1/eduinfo',
        'scope' => ['educloudroles', 'openid', 'profile', 'eduinfo', 'openid2', 'email'],
        'gzipenable' => false,
        'from' => '宜蘭縣',
    ],
    'hlc_oidc' => [
        'tail' => 'hlc',
        'provideruri' => 'https://hlc.sso.edu.tw',
        'eduinfoep' => 'https://hlc.sso.edu.tw/cncresource/api/v1/eduinfo',
        'scope' => ['educloudroles', 'openid', 'profile', 'eduinfo', 'openid2', 'email'],
        'gzipenable' => false,
        'from' => '花蓮縣',
    ],
    'ttct_oidc' => [
        'tail' => 'ttct',
        'provideruri' => 'https://ttct.sso.edu.tw',
        'eduinfoep' => 'https://ttct.sso.edu.tw/cncresource/api/v1/eduinfo',
        'scope' => ['educloudroles', 'openid', 'profile', 'eduinfo', 'openid2', 'email'],
        'gzipenable' => false,
        'from' => '臺東縣',
    ],
    'phc_oidc' => [
        'tail' => 'phc',
        'provideruri' => 'https://phc.sso.edu.tw',
        'eduinfoep' => 'https://phc.sso.edu.tw/cncresource/api/v1/eduinfo',
        'scope' => ['educloudroles', 'openid', 'profile', 'eduinfo', 'openid2', 'email'],
        'gzipenable' => false,
        'from' => '澎湖縣',
    ],
    'mt_oidc' => [
        'tail' => 'mt',
        'provideruri' => 'https://matsu.sso.edu.tw',
        'eduinfoep' => 'https://matsu.sso.edu.tw/cncresource/api/v1/eduinfo',
        'scope' => ['educloudroles', 'openid', 'profile', 'eduinfo', 'openid2', 'email'],
        'gzipenable' => false,
        'from' => '連江縣',
    ],
];
$oidc_array = array_keys($all_oidc);

// if (!isset($xoopsModuleConfig)) {
//     $modhandler = xoops_gethandler('module');
//     $xoopsModule = $modhandler->getByDirname("tad_login");
//     $config_handler = xoops_gethandler('config');
//     $xoopsModuleConfig = $config_handler->getConfigsByCat(0, $xoopsModule->mid());
// }

// if (in_array('tp_ldap', $xoopsModuleConfig['auth_method'])) {
$all_oidc2 = [
    'tp_ldap' => [
        'tail' => 'tp',
    ],
];
$oidc_array2 = array_keys($all_oidc2);
// }

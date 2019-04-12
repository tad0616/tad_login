<?php
/**
 * Generate random string for auth request
 */
function generateRandomString($length = 20)
{
    $characters       = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ_*';
    $charactersLength = strlen($characters);
    $randomString     = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

/**
 *  取得受OAuth保護的資源
 *
 */
function requestProtectedApi($token_ep = '', $accesstoken = '', $rtn_array = false, $gzipenable = false)
{
    $header  = ["Authorization: Bearer $accesstoken"];
    $options = [
        'http' => [
            'header'  => $header,
            'method'  => 'GET',
            'content' => '',
        ]
    ];
    $context = stream_context_create($options);
    if ($gzipenable) {
        $result = gzdecode(file_get_contents($token_ep, false, $context));
    } else {
        $result = file_get_contents($token_ep, false, $context);
    }
    $u = json_decode($result, $rtn_array);
    return $u;
}

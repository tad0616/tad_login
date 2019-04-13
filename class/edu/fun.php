<?php
/**
 * Generate random string for auth request
 * @param mixed $length
 */
function generateRandomString($length = 20)
{
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ_*';
    $charactersLength = mb_strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[mt_rand(0, $charactersLength - 1)];
    }

    return $randomString;
}

/**
 *  取得受OAuth保護的資源
 *
 * @param mixed $token_ep
 * @param mixed $accesstoken
 * @param mixed $rtn_array
 * @param mixed $gzipenable
 */
function requestProtectedApi($token_ep = '', $accesstoken = '', $rtn_array = false, $gzipenable = false)
{
    $header = ["Authorization: Bearer $accesstoken"];
    $options = [
        'http' => [
            'header' => $header,
            'method' => 'GET',
            'content' => '',
        ],
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

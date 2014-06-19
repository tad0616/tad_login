<?php
require('class/OAuth2/Client.php');
require('class/OAuth2/GrantType/IGrantType.php');
require('class/OAuth2/GrantType/AuthorizationCode.php');

const CLIENT_ID     = '849695598263-o9ppa7unlgoo0dmlsmvrel6hvdembsvk.apps.googleusercontent.com';
const CLIENT_SECRET = 'FMOQiNI7GxIaxIRkX2HxW6b8';

const REDIRECT_URI           = 'http://tad0.dcs.tn.edu.tw/modules/tad_login/del.php';
const AUTHORIZATION_ENDPOINT = 'https://accounts.google.com/o/oauth2/auth';
const TOKEN_ENDPOINT         = 'https://accounts.google.com/o/oauth2/token';

$client = new OAuth2\Client(CLIENT_ID, CLIENT_SECRET);
if (!isset($_GET['code']))
{
    $auth_url = $client->getAuthenticationUrl(AUTHORIZATION_ENDPOINT, REDIRECT_URI);
    header('Location: ' . $auth_url);
    die('Redirect');
}
else
{
    $params = array('code' => $_GET['code'], 'redirect_uri' => REDIRECT_URI);
    $response = $client->getAccessToken(TOKEN_ENDPOINT, 'authorization_code', $params);
    parse_str($response['result'], $info);
    $client->setAccessToken($info['access_token']);
    $response = $client->fetch('https://www.googleapis.com/oauth2/v1/certs');
    var_dump($response, $response['result']);
}


/*
facebook:


require('class/OAuth2/Client.php');
require('class/OAuth2/GrantType/IGrantType.php');
require('class/OAuth2/GrantType/AuthorizationCode.php');

const CLIENT_ID     = '759701747403776';
const CLIENT_SECRET = '8cabc4067ded6975509162c122f638c9';

const REDIRECT_URI           = 'http://tad0.dcs.tn.edu.tw/modules/tad_login/del.php';
const AUTHORIZATION_ENDPOINT = 'https://graph.facebook.com/oauth/authorize';
const TOKEN_ENDPOINT         = 'https://graph.facebook.com/oauth/access_token';

$client = new OAuth2\Client(CLIENT_ID, CLIENT_SECRET);
if (!isset($_GET['code']))
{
    $auth_url = $client->getAuthenticationUrl(AUTHORIZATION_ENDPOINT, REDIRECT_URI);
    header('Location: ' . $auth_url);
    die('Redirect');
}
else
{
    $params = array('code' => $_GET['code'], 'redirect_uri' => REDIRECT_URI);
    $response = $client->getAccessToken(TOKEN_ENDPOINT, 'authorization_code', $params);
    parse_str($response['result'], $info);
    $client->setAccessToken($info['access_token']);
    $response = $client->fetch('https://graph.facebook.com/me');
    var_dump($response, $response['result']);
}




array(3) {
  ["result"]=>
  array(11) {
    ["id"]=>
    string(17) "10152389301773205"
    ["email"]=>
    string(17) "tad0616@gmail.com"
    ["first_name"]=>
    string(6) "弘凱"
    ["gender"]=>
    string(4) "male"
    ["last_name"]=>
    string(3) "吳"
    ["link"]=>
    string(62) "https://www.facebook.com/app_scoped_user_id/10152389301773205/"
    ["locale"]=>
    string(5) "zh_TW"
    ["name"]=>
    string(9) "吳弘凱"
    ["timezone"]=>
    int(8)
    ["updated_time"]=>
    string(24) "2014-03-12T05:38:39+0000"
    ["verified"]=>
    bool(true)
  }
  ["code"]=>
  int(200)
  ["content_type"]=>
  string(31) "application/json; charset=UTF-8"
}
array(11) {
  ["id"]=>
  string(17) "10152389301773205"
  ["email"]=>
  string(17) "tad0616@gmail.com"
  ["first_name"]=>
  string(6) "弘凱"
  ["gender"]=>
  string(4) "male"
  ["last_name"]=>
  string(3) "吳"
  ["link"]=>
  string(62) "https://www.facebook.com/app_scoped_user_id/10152389301773205/"
  ["locale"]=>
  string(5) "zh_TW"
  ["name"]=>
  string(9) "吳弘凱"
  ["timezone"]=>
  int(8)
  ["updated_time"]=>
  string(24) "2014-03-12T05:38:39+0000"
  ["verified"]=>
  bool(true)
}
*/
?>
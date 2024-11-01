<?php
use XoopsModules\Tad_login\Tools;
require __DIR__ . '/header.php';
require_once __DIR__ . '/class/Facebook/autoload.php';

$moduleHandler = xoops_getHandler('module');
$tad_loginModule = $moduleHandler->getByDirname('tad_login');
$configHandler = xoops_getHandler('config');
$tad_loginConfig = $configHandler->getConfigsByCat(0, $tad_loginModule->getVar('mid'));

$fb = new Facebook\Facebook([
    'app_id' => $tad_loginConfig['appId'], // Replace {app-id} with your app id
    'app_secret' => $tad_loginConfig['secret'],
    'default_graph_version' => 'v2.11',
]);

$helper = $fb->getRedirectLoginHelper();
$_SESSION['FBRLH_state'] = $_GET['state'];

try {
    $accessToken = $helper->getAccessToken();
} catch (Facebook\Exceptions\FacebookResponseException $e) {
    // When Graph returns an error
    echo 'Graph returned an error: ' . $e->getMessage();
    exit;
} catch (Facebook\Exceptions\FacebookSDKException $e) {
    // When validation fails or other local issues
    echo 'Facebook SDK returned an error: ' . $e->getMessage();
    exit;
}

if (!isset($accessToken)) {
    if ($helper->getError()) {
        header('HTTP/1.0 401 Unauthorized');
        echo 'Error: ' . $helper->getError() . "\n";
        echo 'Error Code: ' . $helper->getErrorCode() . "\n";
        echo 'Error Reason: ' . $helper->getErrorReason() . "\n";
        echo 'Error Description: ' . $helper->getErrorDescription() . "\n";
    } else {
        header('HTTP/1.0 400 Bad Request');
        echo 'Bad request';
    }
    exit;
}

// Logged in
// echo '<h3>Access Token</h3>';
// var_dump($accessToken->getValue());

// The OAuth 2.0 client handler helps us manage access tokens
$oAuth2Client = $fb->getOAuth2Client();

// Get the access token metadata from /debug_token
$tokenMetadata = $oAuth2Client->debugToken($accessToken);
// echo '<h3>Metadata</h3>';
// var_dump($tokenMetadata);

// Validation (these will throw FacebookSDKException's when they fail)
$tokenMetadata->validateAppId($tad_loginConfig['appId']); // Replace {app-id} with your app id
// If you know the user ID this access token belongs to, you can validate it here
//$tokenMetadata->validateUserId('123');
$tokenMetadata->validateExpiration();

if (!$accessToken->isLongLived()) {
    // Exchanges a short-lived access token for a long-lived one
    try {
        $accessToken = $oAuth2Client->getLongLivedAccessToken($accessToken);
    } catch (Facebook\Exceptions\FacebookSDKException $e) {
        echo '<p>Error getting long-lived access token: ' . $helper->getMessage() . "</p>\n\n";
        exit;
    }

    echo '<h3>Long-lived</h3>';
    var_dump($accessToken->getValue());
}

$_SESSION['fb_access_token'] = (string) $accessToken;

$user_profile = '';
if ($_SESSION['fb_access_token']) {
    // die('fb_access_token:' . $_SESSION['fb_access_token']);
    try {
        // Returns a `Facebook\FacebookResponse` object
        $response = $fb->get('/me?fields=id,name,email', $_SESSION['fb_access_token']);
    } catch (Facebook\Exceptions\FacebookResponseException $e) {
        echo 'Graph returned an error: ' . $e->getMessage();
        exit;
    } catch (Facebook\Exceptions\FacebookSDKException $e) {
        echo 'Facebook SDK returned an error: ' . $e->getMessage();
        exit;
    }

    $user_profile = $response->getGraphUser();
}
// die(var_export($user_profile));
$myts = \MyTextSanitizer::getInstance();
$uname = $user_profile['id'] . '_fb';
$name = $myts->addSlashes($user_profile['name']);
$email = $user_profile['email'];
$bio = '';
$url = formatURL("https://www.facebook.com/{$user_profile['id']}");
$from = '';
$sig = '';
$occ = '';

Tools::login_xoops($uname, $name, $email, '', '', $url, $from, $sig, $occ, $bio);
// User is logged in with a long-lived access token.
// You can redirect them to a members-only page.
// header('Location: ' . XOOPS_URL);

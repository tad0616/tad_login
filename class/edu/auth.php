<?php

require __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/config.php';
use Jumbojett\OpenIDConnectClient;

$oidc = new OpenIDConnectClient($provideruri,
    $clientid, $clientsecret);

$oidc->setResponseTypes($resonposetype);
$oidc->setRedirectURL($redirecturi);
//$oidc->setState(generateRandomString());
//$oidc->setNonce(generateRandomString());
$oidc->setAllowImplicitFlow(false);
$oidc->addScope($scope);

$oidc->authenticate();

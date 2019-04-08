<?php
require __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/ty_config.php';
use Jumbojett\OpenIDConnectClient;
$oidc = new OpenIDConnectClient($provideruri, $clientid, $clientsecret);

$oidc->setResponseTypes($responsetype);
$oidc->setRedirectURL($redirecturi);
$oidc->setAllowImplicitFlow(true);
$oidc->addScope($scope);
$oidc->authenticate();

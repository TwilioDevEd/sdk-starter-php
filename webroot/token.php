<?php
include('../vendor/autoload.php');
include('./randos.php');
include('./config.php');


use Twilio\Jwt\AccessToken;
use Twilio\Jwt\Grants\VideoGrant;
use Twilio\Jwt\Grants\SyncGrant;
use Twilio\Jwt\Grants\IPMessagingGrant;

// An identifier for your app - can be anything you'd like
$appName = 'TwilioStarterDemo';

// choose a random username for the connecting user
$identity = randomUsername();

// Create access token, which we will serialize and send to the client
$token = new AccessToken(
    $TWILIO_ACCOUNT_SID, 
    $TWILIO_API_KEY, 
    $TWILIO_API_SECRET, 
    3600, 
    $identity
);

// Grant access to Video
if (!empty($TWILIO_CONFIGURATION_SID)) {
    $grant = new VideoGrant();
    $grant->setConfigurationProfileSid($TWILIO_CONFIGURATION_SID);
    $token->addGrant($grant);
}

// Grant access to Sync
if (!empty($TWILIO_SYNC_SERVICE_SID)) {
    $syncGrant = new SyncGrant();
    $syncGrant->setServiceSid($TWILIO_SYNC_SERVICE_SID);
    $token->addGrant($syncGrant);
}

// Grant access to Chat
if (!empty($TWILIO_CHAT_SERVICE_SID)) {
    $chatGrant = new IpMessagingGrant();
    $chatGrant->setServiceSid($TWILIO_CHAT_SERVICE_SID);
    $token->addGrant($chatGrant);
}


// return serialized token and the user's randomly generated ID
header('Content-type:application/json;charset=utf-8');
echo json_encode(array(
    'identity' => $identity,
    'token' => $token->toJWT(),
));

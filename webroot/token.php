<?php
include('../vendor/autoload.php');
include('./randos.php');


use Twilio\Jwt\AccessToken;
use Twilio\Jwt\Grants\VideoGrant;
use Twilio\Jwt\Grants\SyncGrant;
use Twilio\Jwt\Grants\ChatGrant;

// Load environment variables from .env, or environment if available
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$DISPLAY_ERRORS = $_ENV['DISPLAY_ERRORS'];
ini_set('display_errors', $DISPLAY_ERRORS);

$identity = '';

if (isset($_GET['identity'])) {
    $identity = $_GET['identity'];
}

if (empty($identity)) {
    // choose a random username for the connecting user (if one is not supplied)
    $identity = randomUsername();
}

// Create access token, which we will serialize and send to the client
$token = new AccessToken(
    $_ENV['TWILIO_ACCOUNT_SID'],
    $_ENV['TWILIO_API_KEY'],
    $_ENV['TWILIO_API_SECRET'],
    3600,
    $identity
);

// Grant access to Video
$grant = new VideoGrant();
$token->addGrant($grant);

// Grant access to Sync
$syncGrant = new SyncGrant();
if (empty($_ENV['TWILIO_SYNC_SERVICE_SID'])) {
    $syncGrant->setServiceSid('default');
} else  {
    $syncGrant->setServiceSid($_ENV['TWILIO_SYNC_SERVICE_SID']);
}  
$token->addGrant($syncGrant);

// Grant access to Chat
if (!empty($_ENV['TWILIO_CHAT_SERVICE_SID'])) {
    $chatGrant = new ChatGrant();
    $chatGrant->setServiceSid($_ENV['TWILIO_CHAT_SERVICE_SID']);
    $token->addGrant($chatGrant);
}


// return serialized token and the user's randomly generated ID
header('Content-type:application/json;charset=utf-8');
echo json_encode(array(
    'identity' => $identity,
    'token' => $token->toJWT(),
));

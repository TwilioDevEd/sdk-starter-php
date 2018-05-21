<?php
include('../vendor/autoload.php');

// Load environment variables from .env, or environment if available
$dotenv = new Dotenv\Dotenv(__DIR__);
$dotenv->load();

header('Content-type:application/json;charset=utf-8');

$syncServiceSID = getenv('TWILIO_SYNC_SERVICE_SID');
if (empty($syncServiceSID)) {
    $syncServiceSID = 'default';
}
// Ensure that the Sync Default Service is provisioned
if ($syncServiceSID === 'default') {
    $client = new Twilio\Rest\Client(getenv('TWILIO_API_KEY'), getenv('TWILIO_API_SECRET'), getenv('TWILIO_ACCOUNT_SID'));
    $client->sync->services($syncServiceSID)->fetch();
}

echo json_encode(array(
    'TWILIO_ACCOUNT_SID' => getenv('TWILIO_ACCOUNT_SID'),
    'TWILIO_NOTIFICATION_SERVICE_SID' => getenv('TWILIO_NOTIFICATION_SERVICE_SID'),
    'TWILIO_CHAT_SERVICE_SID' => getenv('TWILIO_CHAT_SERVICE_SID'),
    'TWILIO_SYNC_SERVICE_SID' => $syncServiceSID,
    'TWILIO_API_KEY' => getenv('TWILIO_API_KEY'),
    'TWILIO_API_SECRET' => !empty(getenv('TWILIO_API_SECRET')),
));

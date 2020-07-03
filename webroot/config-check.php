<?php
include('../vendor/autoload.php');

// Load environment variables from .env, or environment if available
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

header('Content-type:application/json;charset=utf-8');

$syncServiceSID = $_ENV['TWILIO_SYNC_SERVICE_SID'];
if (empty($syncServiceSID)) {
    $syncServiceSID = 'default';
}
// Ensure that the Sync Default Service is provisioned
if ($syncServiceSID === 'default') {
    $client = new Twilio\Rest\Client($_ENV['TWILIO_API_KEY'], $_ENV['TWILIO_API_SECRET'], $_ENV['TWILIO_ACCOUNT_SID']);
    $client->sync->services($syncServiceSID)->fetch();
}

echo json_encode(array(
    'TWILIO_ACCOUNT_SID' => $_ENV['TWILIO_ACCOUNT_SID'],
    'TWILIO_NOTIFICATION_SERVICE_SID' => $_ENV['TWILIO_NOTIFICATION_SERVICE_SID'],
    'TWILIO_CHAT_SERVICE_SID' => $_ENV['TWILIO_CHAT_SERVICE_SID'],
    'TWILIO_SYNC_SERVICE_SID' => $syncServiceSID,
    'TWILIO_API_KEY' => $_ENV['TWILIO_API_KEY'],
    'TWILIO_API_SECRET' => !empty($_ENV['TWILIO_API_SECRET']),
));

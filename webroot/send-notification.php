<?php
include('../vendor/autoload.php');

// Load environment variables from .env, or environment if available
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$DISPLAY_ERRORS = $_ENV['DISPLAY_ERRORS'];
ini_set('display_errors', $DISPLAY_ERRORS);

// Authenticate with Twilio
$client = new Twilio\Rest\Client($_ENV['TWILIO_API_KEY'], $_ENV['TWILIO_API_SECRET'], $_ENV['TWILIO_ACCOUNT_SID']);

// Send a notification
$service = $client->notify->v1->services($_ENV['TWILIO_NOTIFICATION_SERVICE_SID']);

$json = json_decode(file_get_contents('php://input'), true);

try {
    $notification = $service->notifications->create(
        [
            'identity' => $json['identity'],
            'body' => 'Hello world!'
        ]
    );

    $response = array(
        'message' => 'Notification Sent!'
    );
    header('Content-type:application/json;charset=utf-8');
    echo json_encode($response);
} catch (Exception $e) {
    $response = array(
        'message' => 'Error creating notification: ' . $e->getMessage(),
        'error' => $e->getMessage()
    );
    header('Content-type:application/json;charset=utf-8');
    http_response_code(500);
    echo json_encode($response);
}

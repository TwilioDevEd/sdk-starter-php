<?php
include('../vendor/autoload.php');
include('./config.php');

// Authenticate with Twilio
$client = new Twilio\Rest\Client($TWILIO_API_KEY, $TWILIO_API_SECRET, $TWILIO_ACCOUNT_SID);

// Get a reference to the user notification service instance
$service = $client->notify->v1->services($TWILIO_NOTIFICATION_SERVICE_SID);

$json = json_decode(file_get_contents('php://input'), true);

// Create a binding
try {
    $binding = $service->bindings->create(
        $json['endpoint'],
        $json['identity'],
        $json['BindingType'],
        $json['Address']
    );
    
    $response = array(
        message => 'Binding created'
    );
    header('Content-type:application/json;charset=utf-8');
    echo json_encode($response);
} catch (Exception $e) {
    $response = array(
        message => 'Error creating binding: ' . $e->getMessage(),
        error => $e->getMessage()
    );
    header('Content-type:application/json;charset=utf-8');
    http_response_code(500);
    echo json_encode($response);
}
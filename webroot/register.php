<?php
include('../vendor/autoload.php');

// Load environment variables from .env, or environment if available
$dotenv = new Dotenv\Dotenv(__DIR__);
$dotenv->load();

// Authenticate with Twilio
$client = new Twilio\Rest\Client(getenv('TWILIO_API_KEY'), getenv('TWILIO_API_SECRET'), getenv('TWILIO_ACCOUNT_SID'));

// Get a reference to the user notification service instance
$service = $client->notify->v1->services(getenv('TWILIO_NOTIFICATION_SERVICE_SID'));

$json = json_decode(file_get_contents('php://input'), true);

// Create a binding
try {
    $binding = $service->bindings->create(
        $json['identity'],
        $json['BindingType'],
        $json['Address']
    );
    
    $response = array(
        'message' => 'Binding created'
    );
    header('Content-type:application/json;charset=utf-8');
    echo json_encode($response);
} catch (Exception $e) {
    $response = array(
        'message' => 'Error creating binding: ' . $e->getMessage(),
        'error' => $e->getMessage()
    );
    header('Content-type:application/json;charset=utf-8');
    http_response_code(500);
    echo json_encode($response);
}
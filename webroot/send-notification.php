<?php
include('../vendor/autoload.php');
include('./config.php');

// Authenticate with Twilio
$client = new Twilio\Rest\Client($TWILIO_API_KEY,$TWILIO_API_SECRET,$TWILIO_ACCOUNT_SID);

// Send a notification 
$service = $client->notify->v1->services($TWILIO_NOTIFICATION_SERVICE_SID);



try {
    $notification = $service->notifications->create(
        [
            'identity' => $_POST['identity'], 
            'body' => 'Hello ' . $_POST['identity']
        ]
    );
    
    $response = array(
        message => 'Notification Sent!'
    );
    header('Content-type:application/json;charset=utf-8');
    echo json_encode($response);
} catch (Exception $e) {
    $response = array(
        message => 'Error creating notification: ' . $e->getMessage(),
        error => $e->getMessage()
    );
    header('Content-type:application/json;charset=utf-8');
    http_response_code(500);
    echo json_encode($response);
} 
<?php
include('../vendor/autoload.php');
include('./config.php');


header('Content-type:application/json;charset=utf-8');
echo json_encode(array(
    'TWILIO_ACCOUNT_SID' => $TWILIO_ACCOUNT_SID,
    'TWILIO_CONFIGURATION_SID' => $TWILIO_CONFIGURATION_SID,
    'TWILIO_NOTIFICATION_SERVICE_SID' => $TWILIO_NOTIFICATION_SERVICE_SID,
    'TWILIO_CHAT_SERVICE_SID' => $TWILIO_CHAT_SERVICE_SID,
    'TWILIO_SYNC_SERVICE_SID' => $TWILIO_SYNC_SERVICE_SID,
    'TWILIO_API_KEY' => $TWILIO_API_KEY,
    'TWILIO_API_SECRET' => !empty($TWILIO_NOTIFICATION_SERVICE_SID),
));

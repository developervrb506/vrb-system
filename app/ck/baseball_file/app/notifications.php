<?php

// API access key from Google API's Console
define( 'API_ACCESS_KEY', 'AIzaSyDDTcCi02tPe9wpsuDZg1-HyKEqJfKg-Ag' );

$registrationIds = array( "APA91bHIJfjc1bmB5d32EOqdWF2AR4BJV3-urG1WrazoXM9gHV8wFlR0Drcrjlvun6f5gRmPintYm9U0deddxF9Dtb3ONHe_3jxgvNYhNif5LVX_MIPJePE" );

// prep the bundle
$msg = array
(
	'message' 	=> 'Hola Mundo',
        'postId' 	=> '1',
	'title'		=> 'Saludo',
	'vibrate'	=> 1,
	'sound'		=> 'beep.wav',
	'largeIcon'	=> 'large_icon',
	'smallIcon'	=> 'small_icon'
);

$fields = array
(
	'registration_ids' 	=> $registrationIds,
	'data'			=> $msg
);
 
$headers = array
(
	'Authorization: key=' . API_ACCESS_KEY,
	'Content-Type: application/json'
);

$ch = curl_init();
curl_setopt( $ch,CURLOPT_URL, 'https://android.googleapis.com/gcm/send' );
curl_setopt( $ch,CURLOPT_POST, true );
curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $fields ) );
$result = curl_exec($ch );
curl_close( $ch );

echo $result;
?>
<?

$bot_id = "6679501618:AAExO2XQU-Ivmin1EuKA-WzG-9Ug6bZIW4Y";
$url = 'https://api.telegram.org/bot' . $bot_id . '/getUpdates';
$last_update = 0;
set_time_limit(0);
// main loop
while (true) {
$result = file_get_contents($url);
$result = json_decode($result, true);

foreach ($result["result"] as $key => $value) {     
	if ($last_update<$value['update_id']){

		$last_update = $value['update_id'];
		$chat_id= $value["message"]["chat"]["id"];
		file_get_contents('https://api.telegram.org/bot' . $bot_id . '/sendMessage?text=message&chat_id='.$chat_id);
		

	} 
	}
		sleep(3);
				
} 


?>
<?php


$data = file_get_contents('php://input');
$logFile = "granding_datalog.json";
$log = fopen($logFile,"a");
fwrite(	$log, $data);
fclose(	$log);


	//session_start();
	//require_once(ROOT_PATH . "/ck/db/handler.php"); 
   // require_once("class.php"); 

 /*
$token = '6245470304:AAGDQlxmgVo6VF3W_BAW-ZjwiOTIZ3vyNCU';
$website = 'https://api.telegram.org/bot'.$token;

 $input = file_get_contents('php://input');
 $update = json_decode($input, TRUE);

$chatId = $update['message']['chat']['id'];
$message = $update['message']['text'];

switch($message) {
    case '/start':
        $response = 'Me has iniciado';
        sendMessage($chatId, $response);
        break;
    case '/info':
        $response = 'Hola! Soy @trecno_bot';
        sendMessage($chatId, $response);
        break;
    default:
        $response = 'No te he entendido';
        sendMessage($chatId, $response);
        break;
}

function sendMessage($chatId, $response) {
    $url = $GLOBALS['website'].'/sendMessage?chat_id='.$chatId.'&parse_mode=HTML&text='.urlencode($response);
    file_get_contents($url);
}
*/


/*
	$entrada=array();
	$entrada='php://input';
	$bot= new _GradingBot($var);
	$mensaje=$bot->fileGetContents($entrada);

	///////////////////////////////////////

	$dato=$bot->explodeMensaje($mensaje['message']);

	switch(strtolower($dato[0])){
		case "/dolar":
		     $compra = 555;
			 $venta =  655;
			 $resultado = "Ventas: ".$venta." Comprass: ".$compra;
			
			 $bot->envioMensaje($resultado,$entrada);
		
		break;

		case "/start":
			$addID=$bot->checkUser($entrada);
			
			$bot->envioMensaje($addID["cedula"]."-".$mensaje["chatID"],$entrada);
		    break;

		

        default:
        	$response="Must send a Valid command";
        	$bot->envioMensaje($response,$entrada);
        
        break;


	}

*/
?>




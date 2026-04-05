<?php

	session_start();
    require_once(ROOT_PATH . "/ck/db/handler.php"); 

	$entrada=array();
	$entrada='php://input';
	$bot= new _Bot($var);
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


?>




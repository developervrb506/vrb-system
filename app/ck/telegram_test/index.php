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
			if(!contains_ck($addID["correo"],'@')){
				$response="You Must send your VRB email";
				$bot->envioMensaje($response,$entrada);
			}else{
				
				$clerk = get_clerk_by_email($addID["correo"]);
				if(!is_null($clerk)){
				   
				   $data = array();
				   $data['email'] = $addID["correo"];
				   $data['identificador']=$mensaje["chatID"];
				   $telegram = get_telegram_user_by_email($data['email']); // 

				 if(is_null($telegram)){
					
					$telegram = new telegram();
					$telegram->vars['email'] = $data['email'];
					$telegram->vars['phone_id'] = $data['identificador'];
					$telegram->vars['date_added'] = date('Y-m-d');
					$telegram->insert();
					
					//$response = $telegram->vars['email']." - ".$telegram->vars['phone_id']." - ".$telegram->vars['date'];
					//$bot->envioMensaje($response,$entrada);
					
					if($telegram->vars['id'] > 0){
					  $response = " - Register Completed - Now you will be able to use this bot and receive notifications";
					}
					 else { $response="There were a Problem in the sRegister process"; }
				 }
				 else{
				    $response="--> Hey you already are Registered LOL";
				 }
				  
				} else {
				   $response = 'Email does not exists in our Database';	
				 }
				
								 
				$bot->envioMensaje($response,$entrada);
			}
			
		    break;
			
			case "/end":
			$addID=$bot->checkUser($entrada);
			if(!contains_ck($addID["correo"],'@')){
				$response="You Must send your VRB email";
				$bot->envioMensaje($response,$entrada);
			}else{
				
				$clerk = get_clerk_by_email($addID["correo"]);
				if(!is_null($clerk)){
				   
				   $data = array();
				   $data['email'] = $addID["correo"];
				   $data['identificador']=$mensaje["chatID"];
				   $telegram = get_telegram_user_by_email($data['email']); // 

				 if(!is_null($telegram)){
					
					$telegram->delete();
					$response="-- Unregistered... Hope to see you soon"; 

				 }
				 else{
				    $response="--> Hey you are not Register in our system";
				 }
				  
				} else {
				   $response = 'Email does not exists in our Database';	
				 }
				
								 
				$bot->envioMensaje($response,$entrada);
			}
			
		    break;

		

        default:
        	$response="Must send a Valid command";
        	$bot->envioMensaje($response,$entrada);
        ;
        break;


	}


?>




<?php 
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;


$app_fact = new \Slim\App;



//funcion solo usada para probar Api.


$app_fact->get('/tiquetes/hello/{name}', function (Request $request, Response $response, array $args) {
    $name = $args['name'];
    $response->getBody()->write("Hello, $name");

    return $response;
});



$app_fact->post('/ticket/create',function(Request $request,Response $response){
	try{    

		$body = $request->getParsedBody();
		$json = $response->withJson($body);
		$remove = substr($json, 0, strpos($json, "{"));
		$json = str_replace($remove,"",$json); 
		$json = json_decode($json);
    	$categories = get_all_ticket_categories();
    	//print_r($categories);
		
		if($json->{'website'} == "CR Properties"){
	      $idCat = 53; //CR Properties	
	    }elseif($json->{'website'} == "Casino Games Online"){
	      $idCat = 54; //Casino Games Online 	
	    }elseif($json->{'website'} == "Costarican Traveler"){
	      $idCat = 55; //Costarican Traveler 	
	    }else{
	      $idCat = 52; //Handicappers 	
	    }

    	$ticket = new _ticket();	
		$ticket->vars["name"]     = $json->{'name'};
		$ticket->vars["email"]    = $json->{'email'};
		$ticket->vars["player_account"] = $json->{'player_account'};
		$ticket->vars["website"]  = $json->{'website'};
		$ticket->vars["subject"]  = $json->{'subject'};
		$ticket->vars["message"]  = $json->{'message'};
		$ticket->vars["category"] = "agents";
		$ticket->vars["tdate"]    = $json->{'tdate'};
		$ticket->vars["dep_id_live_chat"] = $categories[$idCat]->vars["dep_id_live_chat"];
		$ticket->vars["trans_id"] = 0;
		$ticket->vars["ticket_category"] = $idCat;	
		$ticket->vars["phone"]    = $json->{'phone'};
		$ticket->vars["open"]     = $json->{'open'};
		$ticket->vars["id_external"] = $json->{'id'};
		$ticket->vars["updated"] = 1; // If Updated is 1 means that Ticket is updated
        $ticket->insert();
    
        $new_tk = $ticket->vars['id'];
       
		return json_encode(array('id' => $new_tk  ), JSON_FORCE_OBJECT);
		    
    	}
	catch(PDOException $e){
	   echo '{"error": {"text": '.$e->getMessage().'}';	
    }
});





$app_fact->post('/response/create',function(Request $request,Response $response){
	try{		
	
		$body = $request->getParsedBody();
		$json = $response->withJson($body);
		$remove = substr($json, 0, strpos($json, "{"));
		$json = str_replace($remove,"",$json); 
		$json = json_decode($json);    	
    	
    	//print_r($json);
        
        $res = new _ticket_response();
		$res->vars["rdate"] = $json->{'rdate'};
		$res->vars["by"] =$json->{'_by'};
		$res->vars["message"] = $json->{'message'};
		$res->vars["ticket"] = $json->{'ticket_vrb'};
		$res->vars["clerk"] =$json->{'clerk'};
		$res->vars["updated"] = 1;
		$res->vars["id_external"] = $json->{'id'};
		$res->insert();
        $new_tk = $res->vars['id'];
		
		return json_encode(array('id' => $new_tk  ), JSON_FORCE_OBJECT);
		
    	}
	catch(PDOException $e){
	   echo '{"error": {"text": '.$e->getMessage().'}';	
    }
});



$app_fact->post('/response/total',function(Request $request,Response $response){
	try{
		$body = $request->getParsedBody();
		$json = $response->withJson($body);
		$remove = substr($json, 0, strpos($json, "{"));
		$json = str_replace($remove,"",$json); 
		$json = json_decode($json);
    	//$responses = get_ticket_responses_to_sync(true,$json->{'ticket_category'});
		$responses = get_ticket_responses_to_sync($json->{'ticket_category'},true);

		return json_encode(array('total' => count($responses)  ), JSON_FORCE_OBJECT);
    	}
    	catch(PDOException $e){
	   echo '{"error": {"text": '.$e->getMessage().'}';	
    }
});

$app_fact->post('/response/total_update',function(Request $request,Response $response){
	try{
		$body = $request->getParsedBody();
		$json = $response->withJson($body);
		$remove = substr($json, 0, strpos($json, "{"));
		$json = str_replace($remove,"",$json); 
		$json = json_decode($json);
    	//$responses = get_ticket_responses_to_sync(false,$json->{'ticket_category'});
		$responses = get_ticket_responses_to_sync($json->{'ticket_category'},false);
		    	
		return json_encode(array('total' => count($responses)  ), JSON_FORCE_OBJECT);
    	}
    	catch(PDOException $e){
	   echo '{"error": {"text": '.$e->getMessage().'}';	
    }
});

$app_fact->post('/response/new_update',function(Request $request,Response $response){
	try{
		$body = $request->getParsedBody();
		$json = $response->withJson($body);
		$remove = substr($json, 0, strpos($json, "{"));
		$json = str_replace($remove,"",$json); 
		$json = json_decode($json);
    	//$responses = get_ticket_responses_to_sync(false,$json->{'ticket_category'});
		$responses = get_ticket_responses_to_sync($json->{'ticket_category'},false);

		 $array = array();
   		 $t_obj = object_to_array($responses[0]);
  		 $t = array_merge($t_obj['vars'],$array);
		 return json_encode($t, JSON_FORCE_OBJECT);
    	}
    	catch(PDOException $e){
	   echo '{"error": {"text": '.$e->getMessage().'}';	
    }
});



$app_fact->post('/response/new',function(Request $request,Response $response){
	try{
		$body = $request->getParsedBody();
		$json = $response->withJson($body);
		$remove = substr($json, 0, strpos($json, "{"));
		$json = str_replace($remove,"",$json); 
		$json = json_decode($json);
    	//$responses = get_ticket_responses_to_sync(true,$json->{'ticket_category'});
		  $responses = get_ticket_responses_to_sync($json->{'ticket_category'},true);

		 $array = array();
   		 $t_obj = object_to_array($responses[0]);
  		 $t = array_merge($t_obj['vars'],$array);
		 return json_encode($t, JSON_FORCE_OBJECT);
    	}
    	catch(PDOException $e){
	   echo '{"error": {"text": '.$e->getMessage().'}';	
    }
});





$app_fact->post('/response/update',function(Request $request,Response $response){
	try{
		$body = $request->getParsedBody();
		$json = $response->withJson($body);
		$remove = substr($json, 0, strpos($json, "{"));
		$json = str_replace($remove,"",$json); 
		$json = json_decode($json);
    	$res = get_ticket_response($json->{'id_external'});

   	    $res->vars["message"] = $json->{'message'};
		$res->vars["id_external"] = $json->{'id'};
		$res->vars["updated"] = 1;
		
		$control = $res->update(array("message","id_external","updated"));
		//print_r($control);
     
     	return json_encode(array('control' => $control  ), JSON_FORCE_OBJECT);
       }
    	catch(PDOException $e){
	   echo '{"error": {"text": '.$e->getMessage().'}';	
    }
});


$app_fact->post('/ticket/update',function(Request $request,Response $response){
	try{
		$body = $request->getParsedBody();
		$json = $response->withJson($body);
		$remove = substr($json, 0, strpos($json, "{"));
		$json = str_replace($remove,"",$json); 
		$json = json_decode($json);
    	
    	$tk = get_ticket($json->{'id_external'});

   	    $tk->vars["message"] = $json->{'message'};
		$tk->vars["open"] = $json->{'open'};
		$tk->vars["pread"] = $json->{'pread'};
		$tk->vars["deleted"] = $json->{'deleted'};
		$tk->vars["removed"] = $json->{'removed'};
		$tk->vars["updated"] = 1;

		
		$control = $tk->update(array("message","updated","open","pread","deleted","removed"));
		
     
     	return json_encode(array('control' => $control  ), JSON_FORCE_OBJECT);
       }
    	catch(PDOException $e){
	   echo '{"error": {"text": '.$e->getMessage().'}';	
    }
});


$app_fact->post('/ticket/total_update',function(Request $request,Response $response){
	try{
		$body = $request->getParsedBody();
		$json = $response->withJson($body);
		$remove = substr($json, 0, strpos($json, "{"));
		$json = str_replace($remove,"",$json); 
		$json = json_decode($json);
    	//$tickets = get_tickets_to_sync(false,$json->{'ticket_category'});
		$tickets = get_tickets_to_sync($json->{'ticket_category'},false);
    	
		return json_encode(array('total' => count($tickets)  ), JSON_FORCE_OBJECT);
    	}
    	catch(PDOException $e){
	   echo '{"error": {"text": '.$e->getMessage().'}';	
    }
});

$app_fact->post('/ticket/new_update',function(Request $request,Response $response){
	try{
		$body = $request->getParsedBody();
		$json = $response->withJson($body);
		$remove = substr($json, 0, strpos($json, "{"));
		$json = str_replace($remove,"",$json); 
		$json = json_decode($json);
    	//$tickets = get_tickets_to_sync(false,$json->{'ticket_category'});
		$tickets = get_tickets_to_sync($json->{'ticket_category'},false);
				

		 $array = array();
   		 $t_obj = object_to_array($tickets[0]);
  		 $t = array_merge($t_obj['vars'],$array);
		 return json_encode($t, JSON_FORCE_OBJECT);
    	}
    	catch(PDOException $e){
	   echo '{"error": {"text": '.$e->getMessage().'}';	
    }
});



$app_fact->run();

?>

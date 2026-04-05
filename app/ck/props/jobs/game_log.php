<?
require_once(ROOT_PATH . "/ck/db/handler.php"); 
require_once(ROOT_PATH . '/includes/html_dom_parser.php');  
require_once(ROOT_PATH . '/ck/props/process/functions.php');
ini_set('memory_limit', '-1');
set_time_limit(0);

error_reporting(-1);
ini_set('error_reporting', E_ALL);

echo "<pre>" ; 

   // $leagues = array("nfl","mlb","nba");	   
    $leagues = array("nfl");	
   
    shuffle($leagues);

    foreach ($leagues as $league){
    	echo "<pre>";
    	echo "**GAME LOG *** ".$league." ****<BR>";

    	switch($league) {
    		case "nba" :

    		$date = date("Y-m-d");
    		$yesterday = date( "Y-m-d", strtotime( "-1 day", strtotime(date( "Y-m-d")))); 
			$games = get_espn_games_for_log($league,$yesterday,"finished",1);   	//GET ALL THE TODAY FINISHED GAMES WITHOUT GAME LOG
        // $games =  get_espn_games_custom($league,$yesterday,"finished",1);  

			if(!empty($games)){

				foreach( $games as $game ){

				  $players_added = get_players_props_added($league,$game->vars["espn_id"] ); 
				 
				  $game_players = get_game_players($league ,$game->vars["espn_id"] );  // Get the olayers already in DB
				 
				  if(empty($game_players)){
				  	
	      				$players = fn_get_players_by_game($league ,$game->vars["espn_id"] ); // Get directly from ESPN
	      			}

	      			if(empty($game_players) && !empty($players)){

	      				foreach($players	as $pl){
	      					$game_players = new _game_players();
	      					$game_players->vars['league'] = $league; 
	      					$game_players->vars['espn_player_id'] = $pl['id']; 
	      					$game_players->vars['espn_game_id'] = $game->vars["espn_id"]; 
	      					$game_players->vars['bench'] = $pl["bench"]; 
	      					$game_players->insert();

	      				}
	      				$game_players = get_game_players($league ,$game->vars["espn_id"] ); 

	      			}
              

	      			if(!empty($game_players)){

	      				foreach($game_players as $pl){
                           //  print_r($pl);
	      					if(!isset($players_added[$pl['espn_player_id']])) {

	      						$game_log =  fn_espn_playes_game_log_by_league($league,$pl['espn_player_id'],$game->vars["espn_id"]);
					           // print_r($game_log);
					           // exit;

	      						if($game_log){
	      						 if($game->vars["game_log"] != 2){ 	
						          $game->vars["game_log"] = 1; // Player Props ONCE GAME PROPS IS DONE PLEASE CHANGE TO 1
						          $game->update(array("game_log"));
						        }
						        echo "------>UPDATE	";
						}
					  //break;
					}		 
				}
			}

			   //break;
	 	}
             

			}//Empty
			
		//	exit;
			 //Game Data
			$games = get_espn_games_custom($league,$yesterday,"finished",1,"game_log",1);   	//GET ALL THE TODAY FINISHED GAMES WITH GAME LOG
			
			if(!empty($games)){

				foreach( $games as $game ){

					$game_data =  fn_espn_game_data_log_by_league($league,$game->vars["espn_id"]);
					print_r($game_data);
					if($game_data){
					   $game->vars["game_log"] = 2; // Game Data
					   $game->update(array("game_log"));
					}
			  //break;
				}

			}

			break;


			case "ncaaf" :

			$date = date("Y-m-d");
			$yesterday = date( "Y-m-d", strtotime( "-1 day", strtotime(date( "Y-m-d")))); 
			//$games = get_espn_games_custom($league,$yesterday,"finished",1,"finished",1);   	//GET ALL THE TODAY FINISHED GAMES WITHOUT GAME LOG

			
			
            echo "<BR>------GAME DATA ------<BR>";
			$games = get_espn_games_custom($league,$yesterday,"finished",1,"game_log",0);   	//GET ALL THE TODAY FINISHED GAMES WITH GAME LOG
			
			if(!empty($games)){


				foreach( $games as $game ){

					$game_data =  fn_espn_game_data_log_by_league($league,$game->vars["espn_id"]);
				   print_r($game_data);
				 //  echo "ACA NEWWWW"; exit;

					if($game_data){
					   $game->vars["game_log"] = 2; // Game Data
					   $game->update(array("game_log"));
					}
			    //break;
				}

			}
			break;



			case "nfl" :


		
			$date = date("Y-m-d");
			$yesterday = date( "Y-m-d", strtotime( "-2 day", strtotime(date( "Y-m-d")))); 
			$games = get_espn_games_custom($league,$yesterday,"finished",1,"finished",1);   	//GET ALL THE TODAY FINISHED GAMES WITHOUT GAME LOG
         echo "<pre>";
         print_r($games);
	    
        
			
			if(!empty($games)){

				foreach( $games as $game ){	

					//$game->vars["espn_id"] = 401671699;

				  $players_added = get_players_props_added($league,$game->vars["espn_id"] ); 

				 // print_r($players_added);
				  
            

				  $game_players = get_game_players($league ,$game->vars["espn_id"] );  // Get the olayers already in DB
                 
			   

				  if(empty($game_players)){
                  
                  $players = fn_get_players_by_game($league ,$game->vars["espn_id"] ); // Get directly from ESPN
	      				      				
	      	  }
          
	      		if(empty($game_players) && !empty($players)){
                
	      				foreach($players	as $pl){
	      					$game_players = new _game_players();
	      					$game_players->vars['league'] = $league; 
	      					$game_players->vars['espn_player_id'] = $pl["id"]; 
	      					$game_players->vars['espn_game_id'] = $game->vars["espn_id"]; 
	      					$game_players->vars['bench'] = $pl["bench"]; 
	      					$game_players->insert();
	      				}
	      				$game_players = get_game_players($league ,$game->vars["espn_id"] ); 
	      		

	      		}

          echo "<BR><BR>".$game->vars["espn_id"]."---PLAYERS  ADDED: ". count($players_added)."---<BR>";
	      			if(!empty($game_players)){

	      				$control_game_log = true;
	      				$miss_players = 0;
	      				echo "TOTAL PLAYERS: ".count($game_players)."<BR>";
	      				foreach($game_players as $pl){

	      					//print_r($pl);
	      					//$pl['espn_player_id'] =4370807;

	      					//if(!isset($players_added[$pl['espn_player_id']])) {
	      					if($players_added[$pl['espn_player_id']]['type'] < 2) {
                          //echo 'ACA';
                               echo  $players_added[$pl['espn_player_id']]['player_espn_id']." ".$players_added[$pl['espn_player_id']]['type']."<BR>"; 
	      						$game_log =  fn_espn_playes_game_log_by_league($league,$pl['espn_player_id'],$game->vars["espn_id"],$players_added[$pl['espn_player_id']]['type']);

	      						if($game_log){
	      							echo "------>UPDATE	<BR>";
	      						}else {
	      							echo "------>NOT READY<BR>";
	      							$control_game_log = false;
	      							$miss_players++;	
	      						}
					      // break; // just 1 player
	      					}		 
	      				}
	      				
	      				echo "<BR>-----MISS PLAYERS-----".$miss_players."<BR>";
	      				if($control_game_log || $miss_players < 20 ){ // Just will allow, mark game_log completed if only less than 6 players are missed data
					   	  
                     if($game->vars["game_log"] != 2) {  
					   	  $game->vars["game_log"] = 2; // Player Props
						     $game->update(array("game_log"));

						 } 
					   	 echo "<BR>------>SAVE GAME LOG<-------<BR>";
					   	} else {
					   	   echo "<BR>------>PLAYERS PENDING<-------<BR>";
					   	}
					   }
				// break; // just 1 game
				}

			}//Empty
			
			//exit;
			 //Game Data
			
            echo "<BR>------GAME DATA ------<BR>";
			$games = get_espn_games_custom($league,$yesterday,"finished",1,"game_log",1);   	//GET ALL THE TODAY FINISHED GAMES WITH GAME LOG

			print_r($games);
			
			if(!empty($games)){


				foreach( $games as $game ){

					$game_data =  fn_espn_game_data_log_by_league($league,$game->vars["espn_id"]);
				   //print_r($game_data);
				  

					if($game_data){
					   $game->vars["game_log"] = 2; // Game Data
					  $game->update(array("game_log"));
					}
			  //break;
				}

			}
			break;

			case "nhl";

			$date = date("Y-m-d");
			$yesterday = date( "Y-m-d", strtotime( "-1 day", strtotime(date( "Y-m-d")))); 
			$games = get_espn_games_custom($league,$yesterday,"finished",1,"game_log",0);   	//GET ALL THE TODAY FINISHED GAMES WITHOUT GAME LOG

			if(!empty($games)){

				foreach( $games as $game ){
					$players = fn_get_players_by_game($league,$game->vars["espn_id"] ); 
					if(!empty($players)){

						foreach($players as $pl){
							$game_log =  fn_espn_playes_game_log_by_league($league,$pl['id'],$game->vars["espn_id"]);
							if($game_log){
						  $game->vars["game_log"] = 1; // Player Props
						  $game->update(array("game_log"));

						}
						 //	break; 

					}
				}
			}
			
			}//Empty
			
			 //Game Data
			$games = get_espn_games_custom($league,$yesterday,"finished",1,"game_log",1);   	//GET ALL THE TODAY FINISHED GAMES WITH GAME LOG
			
			if(!empty($games)){

				foreach( $games as $game ){

					$game_data =  fn_espn_game_data_log_by_league($league,$game->vars["espn_id"]);
					if($game_data){
					   $game->vars["game_log"] = 2; // Game Data
					   $game->update(array("game_log"));
					}
					//break;
				}

			}
			break; 

		   case "mlb"; // check

		   $date = date("Y-m-d");
		   $yesterday = date( "Y-m-d", strtotime( "-1 day", strtotime(date( "Y-m-d")))); 
			//$games = get_espn_games_for_log($league,$yesterday,"finished",1);   	//GET ALL THE TODAY FINISHED GAMES WITHOUT GAME LOG
            $games = get_espn_games_custom($league,$yesterday,"finished",1,"finished",1);  
		
			if(!empty($games)){

				foreach( $games as $game ){

			    
			    // $game->vars["espn_id"] = 401356132  ;
			  
                   $completed = false;
				   $players_added = get_players_props_added($league,$game->vars["espn_id"] );
				   $game_players = get_game_players($league ,$game->vars["espn_id"] );  // Get the olayers already in DB


                    
				   if(empty($game_players)){
	      				
	      				$players = fn_get_players_by_game($league ,$game->vars["espn_id"] ); // Get directly from ESPN
	      				print_r($players);
	      			}
 				
	      			if(empty($game_players) && !empty($players)){

	      				foreach($players	as $pl){
	      				   if(is_numeric($game->vars["espn_id"])){
                 
	      					$game_players = new _game_players();
	      					$game_players->vars['league'] = $league; 
	      					$game_players->vars['espn_player_id'] = $pl['id']; 
	      					$game_players->vars['espn_game_id'] = $game->vars["espn_id"]; 
	      					$game_players->vars['bench'] = $pl["bench"]; 
	      					$game_players->insert();
	      					}  
	      				}
	      				
	      				$game_players = get_game_players($league ,$game->vars["espn_id"] ); 
	      				print_r($game_players);

	      			}
	

	      			if(!empty($game_players)){
	
	      				foreach($game_players as $pl){

	      					if(!isset($players_added[$pl['espn_player_id']])) {
                            
                             $completed = false;
					         //$game_log =  fn_espn_playes_game_log_by_league($league,$pl['optional_id'],$game->vars["espn_id"],$game->vars["mlb_com_id"]);
	      						if($pl['optional_id'] > 0){
	      							$game_log =  fn_espn_playes_game_log_by_league($league,$pl['espn_player_id'],$game->vars["espn_id"],$pl['optional_id'],$game->vars["mlb_com_id"],$pl['bench']);
	      						} 


					 echo "GAME LOG"; 
					//  print_r($game_log);
					 // exit;
	      				if($game_log){
						  $game->vars["game_log"] = 1; // TEMP WIHILE GAME LOGS ARE DONE//1; // Player Props
						  $game->update(array("game_log"));
						 // print_r($game);
						  echo "------>UPDATE	";
						}
					
					 } else { // echo "Player Added<BR>";
                         $completed = true;
				      }	
						 
					//break;	 
				}
			}

				// }//test
			if($completed){
				echo "<BR>--> ESPN GAME : ".$game->vars["espn_id"]." is Completed<BR><BR>";
			}

			//break; // 1 Game;
		}

			}//Empty
			
			 //Game Data

		
			 echo "<BR>------GAME DATA ------<BR>";
			$games = get_espn_games_custom($league,$yesterday,"finished",1,"game_log",1);   	//GET ALL THE TODAY FINISHED GAMES WITH GAME LOG
			//print_r($games);
			if(!empty($games)){


				foreach( $games as $game ){

					$game_data =  fn_espn_game_data_log_by_league($league,$game->vars["espn_id"]);
				   //print_r($game_data);
				   // echo "ACA NEWWWW"; exit;

					if($game_data){
					   $game->vars["game_log"] = 2; // Game Data
					   $game->update(array("game_log"));
					}
			  //break;
				}

			}
			break; 


	 } //switch

      break; // ONLY 1 LEAGUE BY RUN
	}



	?>
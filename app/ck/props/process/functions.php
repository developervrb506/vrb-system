<?

function fn_espn_players_by_league($league){
	
	
	$props_player = get_all_props_players_league($league,'control');

	switch ($league)	{
		
		case "nba":
		$teams = get_nba_teams();
		$link = "http://www.espn.com/nba/team/roster/_/name/";
		
		    // echo $link; 

		$i=0;
		foreach ($teams as $team){

			echo $link.$team->vars["espn_short"]."<BR><BR>";
			$html = file_get_html($link.$team->vars["espn_short"]);



						foreach ($html->find('div[class="Table__Scroller"]') as $div){ // Div 

						//  echo $div->plaintext;
							$valid = false;
                            // echo "<pre>";
						  foreach($div->find("table tr") as $tr) { // tr    

						  	$j=0;

							//echo $tr->plaintext."<BR>";
						  	if($valid){
						  		$i++;
						  		if (contains_ck($tr->plaintext,"Coach")){ 
						  			break;
						  		}

								foreach ($tr->find("td") as $td){  //td
								  //echo $j.") ".$td->plaintext."  -  <BR>";
									if($j== 0){
										$player[$i]["league"] =  $league;   
										$player[$i]["team"] =  $team->vars["espn_short"];   
									}

									if($j == 1){
										$player[$i]["name"] =  str_replace("'","",$td->plaintext);   
										$player[$i]["name"] =  str_replace("-","",$td->plaintext);   
										$player[$i]["name"] = preg_replace('/\d/', '', $player[$i]["name"]); 									 
										$player[$i]["name"] =  str_replace("&#x","",$player[$i]["name"]);   
										$player[$i]["name"] =  str_replace(";","",$player[$i]["name"]);   
									 foreach($td->find('a') as $a){  //a   
									 	$pl = str_center("id/","/",$a->href);	 
									 	$pl_id =  str_center("id","/",$a->href);	 
									 	$pl =  str_center("/"," ",$pl);	 	 
									 	$espn_id =  str_center("/","/".$pl,$pl_id);
										//echo $espn_id."-";
									 	$player[$i]["espn_id"] =  $espn_id;
									 }
									}
									if($j== 2){
										$player[$i]["pos"] =  $td->plaintext;   
									}
									if($j== 3){
										$player[$i]["age"] =  $td->plaintext;    
									}
									if($j== 4){
										$player[$i]["ht"] =  $td->plaintext;   
									}
									if($j== 5){
										$player[$i]["wt"] =  $td->plaintext;    
									}

									$j++;
								} //TD
								
							 }//valid
							 if (contains_ck($tr->plaintext,"Salary")){
							 	$valid=true;
							 }


						//	echo "<BR>";
						   }//TR
						   
						  }//DIV



				//	echo "<BR>";echo "<BR>";
					//print_r($player);
					 //break; //teams
						}
						break;	

						case "nhl":

						$teams = get_nhl_teams();
						$link = "http://www.espn.com/nhl/team/roster/_/name/";
						$excl = fn_exclude_array($league);	

						$i=0;
						foreach ($teams as $team){

							echo $link.$team->vars["espn_short"]."<BR>";
							$html = file_get_html($link.$team->vars["espn_short"]);


						foreach ($html->find('div[class="Table__Scroller"]') as $div){ // Div 
							$valid = false;

						  foreach($div->find("table tr") as $tr) { // tr    

						  	for($k=0;$k<=count($excl);$k++){
						  		if (contains_ck(substr($tr->plaintext,0,25),$excl[$k])){ 
						  			$valid = false;
						  			break;
						  		}else {
						  			$valid = true;
						  		}
						  	}
						  	if($valid){
						  		echo "<BR>";
						  		$i++;
						  		if (contains_ck($tr->plaintext,"Coach")){ 
						  			break;
						  		}

						  		$j=0;
								foreach ($tr->find("td") as $td){  //td
									echo $j.") ".$td->plaintext."  -  "; 

									if($j== 0){
										$player[$i]["league"] =  $league;   
										$player[$i]["team"] =  $team->vars["espn_short"];   
									}

									if($j == 1){
										$player[$i]["name"] =  str_replace("'","",$td->plaintext); 
										$player[$i]["name"] = preg_replace('/\d/', '', $player[$i]["name"]); 									   

									 foreach($td->find('a') as $a){  //a   
									 	$pl = str_center("id/","/",$a->href);	 
									 	$pl_id =  str_center("id","/",$a->href);	 
									 	$pl =  str_center("/"," ",$pl);	 	 
									 	$espn_id =  str_center("/","/".$pl,$pl_id);
									 	echo $espn_id."-";
									 	$player[$i]["espn_id"] =  $espn_id;
									 }
									}
									if($j== 2){
										$player[$i]["age"] =  $td->plaintext;   
									}
									if($j== 3){
										$player[$i]["ht"] =  $td->plaintext;    
									}
									if($j== 4){
										$player[$i]["wt"] =  $td->plaintext;   
									}
									if($j== 5){
										$player[$i]["shot"] =  $td->plaintext;    
									}



									$j++;
								} //td
								
							 }//valid

						  } //tr

						} // div
						echo "<BR>";echo "<BR>";
				    }//teams
				    break;

				    case "mlb":

				    $teams = get_mlb_teams();
				    $link = "http://www.espn.com/mlb/team/roster/_/name/";

				    $excl = fn_exclude_array($league);	

				    $i=0;
				    foreach ($teams as $team){

				    	echo $link.$team->vars["espn_short"]."<BR>";
				    	$html = file_get_html($link.$team->vars["espn_short"]);


						foreach ($html->find('div[class="Table__Scroller"]') as $div){ // Div 
							$valid = false;

						  foreach($div->find("table tr") as $tr) { // tr    

							 // echo $tr->plaintext."/////<BR>";
						  	if(strlen($tr->plaintext)>8){ 

						  		for($k=0;$k<=count($excl);$k++){
								 // echo substr($tr->plaintext,0,25)." ".$excl[$k]."<BR>";
						  			if (contains_ck(substr($tr->plaintext,0,25),$excl[$k])){ 
						  				$valid = false;
									  // echo "ENTRA";
						  				break;
						  			}else {
						  				$valid = true;
						  			}
						  		}
						  		if($valid){

						  			echo "<BR>";

						  			$i++;
						  			if (contains_ck($tr->plaintext,"Roster Analysis")){ 
						  				break;
						  			}

						  			$j=0;
								foreach ($tr->find("td") as $td){  //td
									echo $j.") ".$td->plaintext."  -  "; 

									if($j== 0){
										$player[$i]["league"] =  $league;   
										$player[$i]["team"] =  $team->vars["espn_short"];   
									}

									if($j == 1){
										$player[$i]["name"] =  str_replace("'","",$td->plaintext);  
										$player[$i]["name"] = preg_replace('/\d/', '', $player[$i]["name"]);  

									 foreach($td->find('a') as $a){  //a   
									 	$pl = str_center("id/","/",$a->href);	 
									 	$pl_id =  str_center("id","/",$a->href);	 
									 	$pl =  str_center("/"," ",$pl);	 	 
									 	$espn_id =  str_center("/","/".$pl,$pl_id);
									 	echo $espn_id."-";
									 	$player[$i]["espn_id"] =  $espn_id;
									 }
									}
									if($j== 2){
										$player[$i]["pos"] =  $td->plaintext;    
									}
									if($j== 3){
										$player[$i]["bat"] =  $td->plaintext;    
									}
									if($j== 4){
										$player[$i]["thw"] =  $td->plaintext;    
									}
									if($j== 5){
										$player[$i]["age"] =  $td->plaintext;   
									}
									if($j== 6){
										$player[$i]["ht"] =  $td->plaintext;    
									}
									if($j== 7){
										$player[$i]["wt"] =  $td->plaintext;   
									}






									$j++;
								} //td
								
							 }//valid
							} // len
						  } //tr

						  }//DIV



						  echo "<BR>";echo "<BR>";
					 //  break;
						}
						break;	





						case "nfl":
						$teams = get_nfl_teams();
						$link = "http://www.espn.com/nfl/team/roster/_/name/";
						//$excl = fn_exclude_array($league);	

						$i=0;
						foreach ($teams as $team){

							echo $link.$team->vars["espn_short"]."<BR>";
							$html = file_get_html($link.$team->vars["espn_short"]);
                           // print_r($html);exit;

						 foreach ($html->find('tbody.Table__TBODY') as $tbody){ // Div 
						   foreach ($tbody->find('a') as $a){ // Div 
							$pl = str_center("id/","/",$a->href);	 
							$pl_id =  str_center("id","/",$a->href);	 
							$pl =  str_center("/"," ",$pl);	 	 
							$espn_id =  str_center("/","/".$pl,$pl_id);
							$name = $a->plaintext;
							if($name){ 	
								$player[$i]["team"] =  $team->vars["espn_short"];
								$player[$i]["league"] =  $league;   
								$player[$i]["name"] =  $name;
								$player[$i]["espn_id"] =  $espn_id;
								$i++;
							}
						  }
					     }	
                    

                        /*
						foreach ($html->find('div[class="Table__Scroller"]') as $div){ // Div 


						  foreach($div->find("table tr") as $tr) { // tr    

						  	$j=0;
						  	$valid = false;
						  	for($k=0;$k<=count($excl);$k++){
						  		if (contains_ck($tr->plaintext,$excl[$k])){ 
						  			$valid = false;
						  			break;
						  		}else {
						  			$valid = true;
						  		}
						  	}

						  	if($valid){
						  		$i++;


								foreach ($tr->find("td") as $td){  //td
									echo $j.") ".$td->plaintext."  -  ";
									if($j== 0){
										$player[$i]["league"] =  $league;   
										$player[$i]["team"] =  $team->vars["espn_short"];   
									}

									if($j == 1){
										$player[$i]["name"] =  str_replace("'","",$td->plaintext);   
										$player[$i]["name"] =  str_replace("-","",$td->plaintext); 
										$player[$i]["name"] = preg_replace('/\d/', '', $player[$i]["name"]); 
									 foreach($td->find('a') as $a){  //a   
									 	$pl = str_center("id/","/",$a->href);	 
									 	$pl_id =  str_center("id","/",$a->href);	 
									 	$pl =  str_center("/"," ",$pl);	 	 
									 	$espn_id =  str_center("/","/".$pl,$pl_id);
									 	echo $espn_id."-";
									 	$player[$i]["espn_id"] =  $espn_id;
									 }
									}
									if($j== 2){
										$player[$i]["pos"] =  $td->plaintext;   
									}
									if($j== 3){
										$player[$i]["age"] =  $td->plaintext;    
									}
									if($j== 4){
										$player[$i]["ht"] =  $td->plaintext;   
									}
									if($j== 5){
										$player[$i]["wt"] =  $td->plaintext;    
									}
									if($j== 6){
										$player[$i]["exp"] =  $td->plaintext;    
										break;
									}

									$j++;
								} //TD
							 }//valid

							 echo "<BR>";
						   }//TR
						   
						  }//DIV



						  echo "<BR>";echo "<BR>";*/
					 // break; //only 1 team
						}
						break;	

				 //Special leagues
						case "tennis":

						$link = "http://www.espn.com/tennis/players";


						$i=0;

						$html = file_get_html($link.$team->vars["espn_short"]);
						
						
						foreach ($html->find('div[class="mod-content"]') as $div){ // Div 

							$i=0;
						  foreach($div->find("table tr") as $tr) { // tr    
					       // echo $tr->plaintext."<BR>"; 
						  	$valid = true;
						  	if(array_all_lleters($tr->plaintext)){ $valid = false;}
						  	if( $tr->plaintext == 'NAMECOUNTRY'){  $valid = false;}

						  	if($valid){
						  		$i++;

						  		$j=0;
								foreach ($tr->find("td") as $td){  //td
								   //echo $j.") ".$td->plaintext."  -  ";
									if($j== 0){
										$player[$i]["league"] =  $league;   
										$player[$i]["name"] =  $td->plaintext;   
										$player[$i]["nick"] =  $td->plaintext; 
										
									  foreach($td->find('a') as $a){  //a   
									  	$pl = str_center("id/","/",$a->href);	 
									  	$pl_id =  str_center("id","/",$a->href);	 
									  	$pl =  str_center("/"," ",$pl);	 	 
									  	$espn_id =  str_center("/","/".$pl,$pl_id);
									  	$player[$i]["espn_id"] =  $espn_id;
									  }  
									}

									if($j == 1){
										$player[$i]["country"] =  $td->plaintext;  

									}
									$j++;
								}
							}
							
						   }//TR
						   
						  }//DIV




						  break;	


	    } //switch



	    if(!empty($player)){

		/*echo "<pre>";
		print_r($player);
		echo "</pre>";*/
		//exit;
		
		foreach($player as $pla){


			if(!isset($props_player[$league."_".$pla["espn_id"]]->vars["id"])){

				$espn_player = new _props_players();
				$espn_player->vars["espn_id"] = $pla["espn_id"];
				$espn_player->vars["name"] = str_replace("'"," ",$pla["name"]);
				$espn_player->vars["nick"] = str_replace("'"," ",$pla["name"]);
				$espn_player->vars["league"] = $pla["league"];
				$espn_player->vars["team"] = $pla["team"];			 
				$espn_player->vars["age"] = $pla["age"];
				$espn_player->vars["wt"] = $pla["wt"];
				$espn_player->vars["ht"] = $pla["ht"];			 
				$espn_player->vars["pos"] = $pla["pos"];
				$espn_player->vars["bat"] = $pla["bat"];
				$espn_player->vars["thw"] = $pla["thw"];
				$espn_player->vars["shot"] = $pla["shot"];
				$espn_player->vars["exp"] = $pla["exp"];
				$espn_player->insert();
				echo $pla["name"]." INSERTED<BR>";
			 ////break;
			} else{


				$props_player[$league."_".$pla["espn_id"]]->vars["espn_id"] = $pla["espn_id"];
			 //$props_player[$league."_".$pla["espn_id"]]->vars["name"] = $pla["name"];
			 //$props_player[$league."_".$pla["espn_id"]]->vars["nick"] = str_replace("'"," ",$pla["name"]); // nick is not update to has a second option
				$props_player[$league."_".$pla["espn_id"]]->vars["team"] = $pla["team"];
				$props_player[$league."_".$pla["espn_id"]]->vars["league"] = $pla["league"];
				$props_player[$league."_".$pla["espn_id"]]->vars["age"] = $pla["age"];
				$props_player[$league."_".$pla["espn_id"]]->vars["wt"] = $pla["wt"];
				$props_player[$league."_".$pla["espn_id"]]->vars["ht"] = $pla["ht"];			 
				$props_player[$league."_".$pla["espn_id"]]->vars["pos"] = $pla["pos"];
				$props_player[$league."_".$pla["espn_id"]]->vars["bat"] = $pla["bat"];		 			 			 			 			 			 
				$props_player[$league."_".$pla["espn_id"]]->vars["thw"] = $pla["thw"];		 			 			 			 			 			 			 
				$props_player[$league."_".$pla["espn_id"]]->vars["shot"] =$pla["shot"];		 			 			 			 			 			 			 
				$props_player[$league."_".$pla["espn_id"]]->vars["exp"] = $pla["exp"];
				unset($props_player[$league."_".$pla["espn_id"]]->vars["control"]);
				$props_player[$league."_".$pla["espn_id"]]->update();	 


			/// print_r($props_player[$league."_".$pla["espn_id"]]);

 			   echo $pla["name"]." UPDATED<BR>";   	
				

			}

		  // break;//only 1	 

		}	
		
	}

}	 


function fn_update_player_id_mlb_com(){


	$teams = get_mlb_teams();
	$mlb_ids = get_optional_ids('mlb');


	foreach ($teams as $team){
		$k=0;			
		$players = array();
		$t_name = $team->vars["nick_mlb_com"];
		$link = "https://www.mlb.com/".strtolower($t_name)."/roster";
		echo $link."<BR>";

		$html = file_get_html($link);
		
		 foreach ($html->find('div[class="players"]') as $div){ // Div 

		   foreach($div->find("table tr") as $tr) { // tr    

		   	foreach($tr->find('img') as $img){
		   		$players[$k]['team'] = $team->vars["espn_short"];
		   		$players[$k]['name'] = utf8_decode($img->alt);

		   		$players[$k]['id'] = str_center("people/","/headshot",$img->src);
		   		$k++;
		   	}

		   } //tr

	     }//DIV



	     if(!empty($players)){ 

	     	foreach($players as $pl){


	     		$player_bd = get_player_by_name('mlb',$pl['name'],$pl['team']);

	     		if(empty($player_bd)){

	     			if(!isset($mlb_ids[$pl['id']])){
	     				echo "--> PLAYER ".$pl['name']." -- ".$pl['team']."  ID: ".$pl['id']."  NOT FOUND.<BR>";
	     			}
	     		} else {

	     			if($player_bd->vars['optional_id'] == 0){
	     				echo "------------------>ACTUALIZA --> ".$pl['name'].$pl['team']."<BR>";
	     				$player_bd->vars['optional_id'] = $pl['id'];
	     				$player_bd->update(array('optional_id'));
	     			}

	     		}



	     	}



	     }				

		//break;			  
	 }

	 echo "<BR><BR>";
  //print_r($players);

	}



 function fn_check_half_time($league,$espn_id){
 //   echo "<BR>--->".$espn_id."/////////////////////////////*/*/*/".$league."<BR>";
   
    $link_array = array();
    $link_array['ncaaf'] =  "https://www.espn.com/college-football/game/_/gameId/";
    $link_array['nfl'] =  "https://www.espn.com/nfl/game/_/gameId/";
    $link_array['nba'] =  "https://www.espn.com/nba/game/_/gameId/";
    $link_array['nhl'] =  "https://www.espn.com/nhl/game/_/gameId/";
    $link_array['ncaab'] =  "https://www.espn.com/mens-college-basketball/playbyplay/_/gameId/";



    
			
		$link = $link_array[$league].$espn_id;
			echo $link." ---- >";

			$html = file_get_html($link);

			if(!empty($html)){

			if($league == 'ncaab'){

				     $print=0;

						foreach ($html->find('table') as $table){ // Div     

                          foreach($table->find('tr') as $tr){
               
                             if($print){
                             //	echo $tr->plaintext."<BR>";
                              $n=0;  
                             	foreach($tr->find('td') as $td){
                               //echo $n.$td->plaintext;
                               if($n==2) {
                              	$status = $td->plaintext;
                              	//echo $td->plaintext;
                               }
                               $n++;
                              }		
                              $print=2;
                             
                             }

                             if(contains_ck($tr->plaintext,"TIME")){ $print= 1 ;}
                             if($print==2){break;}

                          }
                         if($print==2){break;}

						}

						if($status == 'End of 1st half'){
							echo "THIS GAME IS IN HALFTIME ".$status." <BR><BR>";
              			return 2;
                		} else {
                		echo "THIS GAME IS NOT  IN HALFTIME ".$status." <BR>";
                  
                		return 0;
		                }


			} else {	
             
            foreach ($html->find('div') as $div){ // Div
              $str_div = (string) $div->plaintext;
              if(contains_ck($str_div,"HALFTIME")){
              	
              	echo "THIS GAME IS IN HALFTIME<BR><BR>";
              	return 2;
                } else {
                	echo "THIS GAME IS NOT  IN HALFTIME<BR>";
                  
                	return 0;

                }
              	
            }
  
           }

         } else { echo "empty"; return 0;}    

}



	function fn_get_players_by_game($league,$espn_id){

		$game_players = array();	
		switch ($league)	{

			case "nba":

			$link = "http://www.espn.com/nba/boxscore?gameId=";

			echo $link.$espn_id."<BR><BR>";

			$html = file_get_html($link.$espn_id);

			if(!empty($html)){
                       foreach ($html->find('div[class="flex"]') as $div){ // Div 
                        	 foreach($div->find('a') as $a){  //a  

                        	 	$href = $a->href;
                        	 	if(contains_ck($href,"nba/player")){

                        	 		$pl = str_center("id/","/",$a->href);	 
                        	 		$pl_id =  str_center("id","/",$a->href);	 
                        	 		$pl =  str_center("/"," ",$pl);	 	 
                        	 		$espn_id =  str_center("/","/".$pl,$pl_id);
                        	 		$game_players[$espn_id]['id'] = $espn_id;
									//$game_players[$espn_id]['bench'] = $bench;
                        	 	}

                        	 } 	

                        	 $h++;
                        	}  
                        }  
                        
                 break;	//Case

                 case "nhl":

                 $link = "http://www.espn.com/nhl/boxscore?gameId=";

                 echo $link.$espn_id."<BR><BR>";

                 $html = file_get_html($link.$espn_id);

						foreach ($html->find('div[class="mod-container mod-open mod-open-gamepack"]') as $div){ // Div 

						// echo $div->plaintext;
						  foreach($div->find("table tr") as $tr) { // tr    
						  	$j=0;


								foreach ($tr->find("td") as $td){  //td

									if($j == 0){

										$bench = 0;
										$class = $td->class;
										if(contains_ck($class,"bench")){ $bench	= 1 ;}

									 foreach($td->find('a') as $a){  //a   
									 	$pl = str_center("id/","/",$a->href);	 
									 	$pl_id =  str_center("id","/",$a->href);	 
									 	$pl =  str_center("/"," ",$pl);	 	 
									 	$espn_id =  str_center("/","/".$pl,$pl_id);
									 	$game_players[$espn_id]['id'] = $espn_id;
									 	$game_players[$espn_id]['bench'] = $bench;


									 }
									}
									$j++;
								} //TD

						    }//TR


						  }//DIV  

						  $n++;

						  break;	

						  case "mlb":

						  $link = "http://www.espn.com/mlb/boxscore?gameId=".$espn_id;
						  echo $link;
                         // $link = 'http://www.espn.com/mlb/boxscore?gameId=401570422';

						  $html = file_get_html($link);
						/* print_r($html);

						  	foreach ($html->find('div') as $div){ // Div 
							echo $div->plaintext;
						  	}


                         exit;*/
						foreach ($html->find('div[class="flex"]') as $div){ // Div 
						 
						//foreach ($html->find('div[id="gamepackage-box-score"]') as $div){ // Div 

						echo $div->plaintext;
						  foreach($div->find("table tr") as $tr) { // tr    
						  	$j=0;


								foreach ($tr->find("td") as $td){  //td

									if($j == 0){

										$bench = 0;
										$class = $td->class;
										if(contains_ck($class,"bench")){ $bench	= 1 ;}

									 foreach($td->find('a') as $a){  //a   
									 	$pl = str_center("id/","/",$a->href);	 
									 	$pl_id =  str_center("id","/",$a->href);	 
									 	$pl =  str_center("/"," ",$pl);	 	 
									 	$espn_id =  str_center("/","/".$pl,$pl_id);
									 	 if(is_numeric($espn_id)){
									 	$game_players[$espn_id]['id'] = $espn_id;
									 	$game_players[$espn_id]['bench'] = $bench;
									    }
									 }
									}
									$j++;
								} //TD

						    }//TR


						  }//DIV  

						  $n++;
                          //print_r($game_players);exit;
                 break;	//Case 	



                 case "nfl":

                 $link = "http://www.espn.com/nfl/boxscore?gameId=";

                 echo $link.$espn_id."<BR><BR>//";

                 $html = file_get_html($link.$espn_id);

						foreach ($html->find('div[class="Boxscore__Athlete]') as $div){ // Div     


							 foreach($div->find('a') as $a){  //a   
										//echo $a->plaintext."<BR>";
							 	$pl = str_center("id/","/",$a->href);	 
							 	$pl_id =  str_center("id","/",$a->href);	 
							 	$pl =  str_center("/"," ",$pl);	 	 
							 	$espn_id =  str_center("/","/".$pl,$pl_id);
										//$game_players[$espn_id] = $espn_id;
							 	$game_players[$espn_id]['id'] = $espn_id;
							 	$game_players[$espn_id]['bench'] = $bench;
							 }

							}
						
                 break;	//Case 	 


	    } //switch
/*
  echo "<pre>";
  print_r($game_players);
  echo "</pre>";
  */

  return $game_players;

}


function fn_league_fields($league){

	$fields = array();
	switch($league){
		case "nba"	:
		$fields[0]["id"]= "date";
		$fields[1]["id"]= "vs";		 
		$fields[2]["id"]= "score";		 		 
		$fields[3]["id"]= "min";
		$fields[4]["id"]= "fg";			 
		$fields[5]["id"]= "fg%";	
		$fields[6]["id"]= "3pt";	
		$fields[7]["id"]= "3p%";
		$fields[8]["id"]= "ft";		 		 
		$fields[9]["id"]= "ft%";		 
		$fields[10]["id"]= "reb";
		$fields[11]["id"]= "ast";		  
		$fields[12]["id"]= "blk";		 
		$fields[13]["id"]= "stl";		 
		$fields[14]["id"]= "pf";		 
		$fields[15]["id"]= "to";		 
		$fields[16]["id"]= "pts";	

		break; 
		case "nhl"	:
		$fields[0]["id"]= "date";
		$fields[1]["id"]= "vs";		 
		$fields[2]["id"]= "score";		 		 
		$fields[3]["id"]= "g";
		$fields[4]["id"]= "a";		 		 		 		 
		$fields[5]["id"]= "pts";	
		$fields[6]["id"]= "+/-";		 	 
		$fields[7]["id"]= "pim";
		$fields[8]["id"]= "sog";		 		 
		$fields[9]["id"]= "s%";		 
		$fields[10]["id"]= "ppg";
		$fields[11]["id"]= "ppa";		  
		$fields[12]["id"]= "shg";		 
		$fields[13]["id"]= "sha";		 
		$fields[14]["id"]= "gwg";		 
		break; 
		case "mlb"	:
		$fields[0]["id"]= "date";
		$fields[1]["id"]= "vs";		 
		$fields[2]["id"]= "score";		 		 
		$fields[3]["id"]= "ab";
		$fields[4]["id"]= "r";		 		 		 		 
		$fields[5]["id"]= "h";	
		$fields[6]["id"]= "2b";		 	 
		$fields[7]["id"]= "3b";
		$fields[8]["id"]= "hr";		 		 
		$fields[9]["id"]= "rbi";		 
		$fields[10]["id"]= "bb";
		$fields[11]["id"]= "hpb";
		$fields[12]["id"]= "so";		  
		$fields[13]["id"]= "sb";		 
		$fields[14]["id"]= "cs";		 
		$fields[15]["id"]= "avg";		 
		$fields[16]["id"]= "obp";		 
		$fields[17]["id"]= "slg";
		$fields[18]["id"]= "ops";		 



		break; 

		case "mlb2"	:
		$fields[0]["id"]= "date";
		$fields[1]["id"]= "vs";		 
		$fields[2]["id"]= "score";		 		 
		$fields[3]["id"]= "ip";
		$fields[4]["id"]= "h";		 		 		 		 
		$fields[5]["id"]= "r";	
		$fields[6]["id"]= "er";		 	 
		$fields[7]["id"]= "hr";
		$fields[8]["id"]= "bb";		 		 
		$fields[9]["id"]= "k";		 
		$fields[10]["id"]= "gb";
		$fields[11]["id"]= "fb";		  
		$fields[12]["id"]= "p";		 
		$fields[13]["id"]= "tbf";		 
		$fields[14]["id"]= "gsc";		 
		$fields[15]["id"]= "dec";		 
		$fields[16]["id"]= "rel";		 
		$fields[17]["id"]= "era";		 

		break; 

		  case "nfl_pas"	: // PASSING / RUSHING
		  $fields[0]["id"]= "date";
		  $fields[1]["id"]= "vs";		 
		  $fields[2]["id"]= "score";		 		 
		  $fields[3]["id"]= "pas_cmp";
		  $fields[4]["id"]= "pas_att";		 		 		 		 
		  $fields[5]["id"]= "pas_yds";	
		  $fields[6]["id"]= "pas_cmp_perc";		 	 
		  $fields[7]["id"]= "pas_avg";
		  $fields[8]["id"]= "pas_td";		 		 
		  $fields[9]["id"]= "pas_int";		 
		  $fields[10]["id"]= "pas_lng";
		  $fields[11]["id"]= "pas_sack";		  
		  $fields[12]["id"]= "pas_rtg";		 
		  $fields[13]["id"]= "pas_qbr";		 
		  $fields[14]["id"]= "ru_car";		 			 
		  $fields[15]["id"]= "ru_yds";		 			 			 
		  $fields[16]["id"]= "ru_avg";		 			 
		  $fields[17]["id"]= "ru_td";		 			 			 			 
		  $fields[18]["id"]= "ru_lng";

		  break; 

		case "nfl_ru"	: // Rushinng - receiving - Fumbles
		$fields[0]["id"]= "date";
		$fields[1]["id"]= "vs";		 
		$fields[2]["id"]= "score";
		$fields[3]["id"]= "ru_car";		 		 
		$fields[4]["id"]= "ru_yds";		 		 		 		 
		$fields[5]["id"]= "ru_avg";	
		$fields[6]["id"]= "ru_td";		 	 
		$fields[7]["id"]= "ru_lng";
		$fields[8]["id"]= "re_rec";		 		 
		$fields[9]["id"]= "re_tgts";		 
		$fields[10]["id"]= "re_yds";
		$fields[11]["id"]= "re_avg";		  
		$fields[12]["id"]= "re_td";		 
		$fields[13]["id"]= "re_lng";		 
		$fields[14]["id"]= "fu_fum";		 			 
		$fields[15]["id"]= "fu_lst";		 			 			 
		$fields[16]["id"]= "fu_ff";		 			 
		$fields[17]["id"]= "fu_kb";

		break;

		case "nfl_re"	:// Receiving - rushing -fumbles
		$fields[0]["id"]= "date";
		$fields[1]["id"]= "vs";		 
		$fields[2]["id"]= "score";		 		 
		$fields[3]["id"]= "re_rec";
		$fields[4]["id"]= "re_tgts";		 		 		 		 
		$fields[5]["id"]= "re_yds";	
		$fields[6]["id"]= "re_avg";		 	 
		$fields[7]["id"]= "re_td";
		$fields[8]["id"]= "re_lng";		 		 
		$fields[9]["id"]= "ru_car";		 
		$fields[10]["id"]= "ru_yds";
		$fields[11]["id"]= "ru_avg";		  
		$fields[12]["id"]= "ru_lng";		 
		$fields[13]["id"]= "ru_td";		 
		$fields[14]["id"]= "fu_fum";		 			 
		$fields[15]["id"]= "fu_lst";		 			 			 
		$fields[16]["id"]= "fu_ff";		 			 
		$fields[17]["id"]= "fu_kb";

		break;

		case "nfl_ta"	: // Tackles - Fumbles - Interceptions
		$fields[0]["id"]= "date";
		$fields[1]["id"]= "vs";		 
		$fields[2]["id"]= "score";		 		 
		$fields[3]["id"]= "ta_tot";
		$fields[4]["id"]= "ta_solo";		 		 		 		 
		$fields[5]["id"]= "ta_ast";	
		$fields[6]["id"]= "ta_sack";		 	 
		$fields[7]["id"]= "ta_stf";
		$fields[8]["id"]= "ta_stfyds";		 		 
		$fields[9]["id"]= "fu_fum";		 
		$fields[10]["id"]= "fu_lst";
		$fields[11]["id"]= "fu_ff";		  
		$fields[12]["id"]= "fu_fr";		 
		$fields[13]["id"]= "fu_kb";		 
		$fields[14]["id"]= "int_int";		 			 
		$fields[15]["id"]= "int_yds";		 			 			 
		$fields[16]["id"]= "int_avg";		 			 
		$fields[17]["id"]= "int_td";	 		 			 			 			 
		$fields[18]["id"]= "int_lng";	 		 			 			 			 
		$fields[19]["id"]= "int_pd";	

		break;

			case "nfl_fi"	: // Fieldgoals - PATS
			$fields[0]["id"]= "date";
			$fields[1]["id"]= "vs";		 
			$fields[2]["id"]= "score";		 		 
			$fields[3]["id"]= "fi_1-19";
			$fields[4]["id"]= "fi_20-29";		 		 		 		 
			$fields[5]["id"]= "fi_30-39";	
			$fields[6]["id"]= "fi_40-49";		 	 
			$fields[7]["id"]= "fi_50+";
			$fields[8]["id"]= "fi_lng";		 		 
			$fields[9]["id"]= "fi_fg_perc";		 
			$fields[10]["id"]= "fi_fg";
			$fields[11]["id"]= "fi_avg";		  
			$fields[12]["id"]= "pa_xp";		 
			$fields[13]["id"]= "pa_pts";

			break;

			case "nfl_pu"	: // Punting
			$fields[0]["id"]= "date";
			$fields[1]["id"]= "vs";		 
			$fields[2]["id"]= "score";		 		 
			$fields[3]["id"]= "pu_punts";
			$fields[4]["id"]= "pu_avg";		 		 		 		 
			$fields[5]["id"]= "pu_lng";	
			$fields[6]["id"]= "pu_yds";		 	 
			$fields[7]["id"]= "pu_tb";
			$fields[8]["id"]= "pu_tb_perc";		 		 
			$fields[9]["id"]= "pu_in20";		 
			$fields[10]["id"]= "pu_in20_perc";
			$fields[11]["id"]= "pu_att";		  
			$fields[12]["id"]= "pu_yds";		 
			$fields[13]["id"]= "pu_avg2";		 
			$fields[14]["id"]= "pu_net";		 





			break; 


		}	
		return $fields; 
	}





	function fn_exclude_array($league)	{

		switch($league){
			case "nba"	:
			$excl = array("SEASON","SCORE","January","February","March","April","May","June", "July","August","September", "October", "November", "December","Averages","Totals","PRESEASON","RESULT","OPP");
			break; 

			case "nhl" :
			$excl = array("RESULT","WT","BIRTH PLACE","BIRTHDATE","CENTERS","LEFT WINGS","RIGHT WINGS","GOALIES","DEFENSE","SEASON","SCORE","January","February","March","April","May","June", "July","August","September", "October", "November", "December","Averages","Totals","PRESEASON");
			break;	

			case "mlb" :
			$excl = array("RESULT","Result","WT","BIRTH PLACE","BIRTHDATE","CENTERS","LEFT WINGS","RIGHT WINGS","GOALIES","DEFENSE","SEASON","SCORE","January","February","March","April","May","June", "July","August","September", "October", "November", "December","Averages","TBF","Totals","PRESEASON","Catchers","Infielders","Outfielders", "Pitchers","Regular","date","3B", "Disabled","Suspended","Designated");
			break;	
			case "nfl" :
			$excl = array("Offense","Defense","COLLEGE","Special","Disabled","Suspended","Designated");
			break;	

		}	 	 
		return($excl);

	}

	function fn_espn_playes_game_log_by_league($league,$player,$game_id,$player_optional="",$optional_id ="",$bench = 0){



		echo "<BR>*****".$game_id." ".$player_optional." ".$optional_id."-----<BR>";		


		switch ($league)	{

			case "nba":

			$fields = fn_league_fields($league);
			$excl = fn_exclude_array($league);	
			$link = "http://www.espn.com/nba/player/gamelog/_/id/";
			$i=0; 
			echo "<BR>".$link.$player."<BR>";
			$html = file_get_html($link.$player);
			$valid = false;

			$n=0;

			if(!empty($html)) { 

						foreach ($html->find('div[class="Table__Scroller"]') as $div){ // Div 


						  foreach($div->find("table tr") as $tr) { // tr    
						  	$j=0;

						  	for($k=0;$k<=count($excl);$k++){
						  		if (contains_ck(substr($tr->plaintext,0,25),$excl[$k])){ 
						  			$valid = false;
						  			break;
						  		}else {
						  			$valid = true;
						  		}
						  	}

						  	if($valid){
						  		$i++;


								foreach ($tr->find("td") as $td){  //td
									if($j== 0){
										$fields[$j]["value"]= date("Y-m-d",strtotime($td->plaintext));
									}

									if($j== 1){
										$fields[$j]["value"]= str_replace("@ ","",strtolower($td->plaintext));
										$fields[$j]["value"]= str_replace("vs","",$fields[$j]["value"]);										
									}
									
									if($j==2){ // Get the espn to double check before insert
										
										foreach($td->find('a') as $a){  //a   
											//ho '-------------'.$a->href."<BR>";
											$espn_game = str_center("gameId/","/",$a->href."/");
											$espn_game  =  str_replace("/","",$espn_game); 	 
										//echo '-------------'.$espn_game."<BR>";
										//http://www.espn.com/nba/game?gameId=401161393
										}

										
									}

									if($j >= 2){
										$fields[$j]["value"]= $td->plaintext;
									}
									$j++;
									if($j==18)break;
								} //TD
								break;
							 }//valid
							 

						    }//TR
						  // } //n

						    break;
						  }//DIV 
						}   
                 break;	//Case

                 case "nhl":
                 $fields = fn_league_fields($league);
                 $excl = fn_exclude_array($league);	
                 $link = "http://www.espn.com/nhl/player/gamelog/_/id/";

                 $i=0; 
                 echo $link.$player;
                 $html = file_get_html($link.$player);
                 $valid = false;
                 $n=0;
						foreach ($html->find('div[class="Table__Scroller"]') as $div){ // Div 

							if($n > 0){

						  foreach($div->find("table tr") as $tr) { // tr    
						  	$j=0;
						  	for($k=0;$k<=count($excl);$k++){
						  		if (contains_ck(substr($tr->plaintext,0,25),$excl[$k])){ 
						  			$valid = false;
						  			break;
						  		}else {
						  			$valid = true;
						  		}
						  	}

						  	if($valid){
						  		$i++;

						  		$j=0;
								foreach ($tr->find("td") as $td){  //td
									if($j== 0){
										$date = $td->plaintext;
										
										$fields[$j]["value"]= date("Y-m-d",strtotime($td->plaintext));
									}

									if($j== 1){
										$fields[$j]["value"]= str_replace("@ ","",strtolower($td->plaintext));
										$fields[$j]["value"]= str_replace("vs","",$fields[$j]["value"]);										
									}
									
									if($j==2){ // Get the espn to double check before insert
										foreach($td->find('a') as $a){  //a   
											$espn_game = str_center("id/","/",$a->href);	 
											$espn_game = $espn_game."*";
											$espn_game = str_center("gameId/","*",$espn_game);	 											

										}

										
									}

									if($j >= 2 && $j < 15){
										$fields[$j]["value"]= $td->plaintext;
									}
									if($j==14){ break; }   

									$j++;


								} //TD
								if($j==14){
									if($game_id == $espn_game){ break; }   
								}
								//break;
							 }//valid
							 

						    }//TR
						   } //n
						   $n++;
						  }//DIV  			

				   break;	//Case	
				   
				   case "mlb":
				   echo "<pre>";
				   $year = date("Y");
				   $control_info = true;
                      //Pitching   
				   $link = "https://statsapi.mlb.com/api/v1/people/".$player_optional."/stats?stats=gameLog&group=pitching&gameType=R&season=".$year."&language=en";

				   echo  $link;

				   $json = file_get_contents($link);
				   $data = json_decode($json,true);             
				   $last_game =  (count($data['stats'][0]['splits']) - 1) ; 
				   $info = $data['stats'][0]['splits'][$last_game];
				   $player_data = array();
				   unset($data); 
				   unset($info['team']);
				   unset($info['opponent']);
				   unset($info['sport']);
				   unset($info['league']);
				   unset($info['positionsPlayed']);
		             // print_r($info);


				   if($optional_id == $info['game']['gamePk']){
				   	$player_data['so'] = $info['stat']['strikeOuts'];

                          //patch added on 7-26-22
				   	$player_data['ab'] = $info['stat']['atBats'];
				   	$player_data['h'] = $info['stat']['hits'];
				   	$player_data['r'] = $info['stat']['runs'];
				   	$player_data['tb'] = $info['stat']['totalBases'];
				   	$player_data['2b'] = $info['stat']['doubles'];
				   	$player_data['3b'] = $info['stat']['triples'];
				   	$player_data['hr'] = $info['stat']['homeRuns'];
				   	$player_data['rbi'] = $info['stat']['rbi'];
				   	$player_data['bb'] = $info['stat']['baseOnBalls'];
				   	$player_data['er'] = $info['stat']['earnedRuns'];
				   	$player_data['out'] = $info['stat']['outs'];
				   	$player_data['w'] = $info['stat']['wins'];
				   	$player_data['l'] = $info['stat']['losses'];
				   	if($bench){
				   		$player_data['bench'] = $bench;
				   	}
				   } else { echo "-->Its other Game -- ";    $control_info = false;}



				   unset($info); 
                       //Hitting   
				   $link = "https://statsapi.mlb.com/api/v1/people/".$player_optional."/stats?stats=gameLog&group=hitting&gameType=R&season=".$year."&language=en";
				   $json = file_get_contents($link);
				   $data = json_decode($json,true);             
				   $last_game =  (count($data['stats'][0]['splits']) - 1) ; 
				   $info = $data['stats'][0]['splits'][$last_game];
                      //echo "*********** HITTING**************<BR>";
                     // print_r($info);

				   unset($data); 
				   unset($info['team']);
				   unset($info['opponent']);
				   unset($info['sport']);
				   unset($info['league']);
				   unset($info['positionsPlayed']);


				   if($optional_id == $info['game']['gamePk']){
				   	$control_info = true;
				   	$player_data['ab'] = $info['stat']['atBats'];
				   	$player_data['h'] = $info['stat']['hits'];
				   	$player_data['r'] = $info['stat']['runs'];
				   	$player_data['tb'] = $info['stat']['totalBases'];
				   	$player_data['2b'] = $info['stat']['doubles'];
				   	$player_data['3b'] = $info['stat']['triples'];
				   	$player_data['hr'] = $info['stat']['homeRuns'];
				   	$player_data['rbi'] = $info['stat']['rbi'];
				   	$player_data['bb'] = $info['stat']['baseOnBalls'];
				   	$player_data['er'] = $info['stat']['earnedRuns'];
				   	$player_data['out'] = $info['stat']['outs'];
				   	$player_data['w'] = $info['stat']['wins'];
				   	$player_data['l'] = $info['stat']['losses'];
				   	if($bench){
				   		$player_data['bench'] = $bench;
				   	}
				   } else { echo "-->Its diff Game -- ";  
				   if(empty($player_data)){  
				   	$control_info = false; 
				   }
				}
				unset($info); 


				if(empty($player_data) && !$control_info){
					echo "---DATOS DESDE ESPN ---";

					$player_data = fn_get_mlb_game_log($game_id,$player);
					print_r($player_data);
					if(!empty($player_data)){ $control_info = true;}




				}


				if($bench){
					@$player_data['bench'] = $bench;
				}






				if(!empty($player_data) &&   $control_info ){

					foreach ($player_data as $key => $value) {

						echo $key." ".$value."<BR>";
						$game_log = new _game_log();
						$game_log->vars["league"] = $league;
						$game_log->vars["player_espn_id"] = $player;
						$game_log->vars["espn_game"] = $game_id;
						$game_log->vars["field"] = $key;
						$game_log->vars["value"] = $value;			  
						$game_log->insert();



                        	# code...
					}
					echo "---->PLAYER DATA SAVED<BR>";

				}



                    //print_r($player_data);
				$result = 1;
					// echo $result;


                 break;	//Case	

                 case "nfl":


                 $type = $player_optional;

                 if($type < 2){
                 	echo "----------GAME LOG   -----------<BR>";
                 	$excl = fn_exclude_array($league);	
                 	$link = "http://www.espn.com/nfl/player/gamelog/_/id/";

                 	$i=0; 
                 	echo $link.$player." ---- ><BR>";
					$html = file_get_html($link.$player);
                 	$valid = false;
                 	$n=0;
						
                     if(!empty($html)) {
                        
                       // echo "ENTRA ".count($html->find('div[class="Table__Scroller"]'))."<BR>"  ;

						foreach ($html->find('div[class="Table__Scroller"]') as $div){ // Div 
							
						   foreach($div->find("table tr") as $tr) { // tr    
						    
						     //echo $n."TR_X )".$tr->plaintext."**<BR>";

                              if($n==0){ // getting the type of player
                                $type_player = explode(')',$tr->plaintext);
						  		$type_p = $type_player[1];   
						  		if($type_p == ''){ $n=3; $j=$total_fields;}
						  		//echo $type_p;  
                              }
                              if($n==2){

                             		switch($type_p){

						  			case  "PassingRushing" :
						  			$fields = fn_league_fields($league."_pas");
						  			break;
						  			case  "RushingReceivingFumbles" :
						  			$fields = fn_league_fields($league."_ru");
						  			break;
						  			case  "TacklesFumblesInterceptions" :
						  			$fields = fn_league_fields($league."_ta");
						  			break;	
						  			case  "Punting" :
						  			$fields = fn_league_fields($league."_pu");
						  			break;	
						  			case  "fieldgoalspats" :
						  			$fields = fn_league_fields($league."_fi");
						  			break;	
						  			case  "ReceivingRushingFumbles" :
						  			$fields = fn_league_fields($league."_re");
						  			break;	

						  			default: break;	      	      

						  		    }
								 
								    //echo "<pre>";
								    //print_r($fields);
						  		    $total_fields = count($fields);
								    //echo "*******************************".$total_fields;"<BR>";
 
                                    $j=0;
								    foreach ($tr->find("td") as $td){  //td

							    	    //echo "<BR>.".$j.") //TL ".$td->plaintext."--<BR><BR>";

										if($j== 0){

											$date = $td->plaintext;
											$fields[$j]["value"]= date("Y-m-d",strtotime($td->plaintext));
											
								     	}

									    if($j== 1){
										   $fields[$j]["value"]= str_replace("@ ","",strtolower($td->plaintext));
										   $fields[$j]["value"]= str_replace("vs","",$fields[$j]["value"]);										
									     }
									
										if($j==2){ // Get the espn to double check before insert
										   
										   foreach($td->find('a') as $a){  //a   

											  $a->href = $a->href."/";
										      $espn_game = str_center("gameId/","/",$a->href);	 
											  $espn_array = explode("/",$espn_game);
											  $espn_game =$espn_array[0];
									
										   }
										   $fields[$j]["value"]= $td->plaintext;

										
									    }
									     
                                          //echo "TOTALL ".$j." // ".$total_fields." ".$td->plaintext;
									    if($j > 2 && $j < ($total_fields+1)){
									    
										   $fields[$j]["value"]= $td->plaintext;
									    }
									    if($j==$total_fields){ break; }   
   									    $j++;

							        } //td
					             //  break; // Break TR foreach
					  			}//n
					  			if($j==$total_fields){
					  			   $final = $fields;
									if($game_id == $espn_game){ break; }   
								}

						     $n++;
						    // if($n==2){ break;}
						   }  //tr

					    }	//DIV

                      } //html

                     } //type
						 // print_r($fields);
						 // exit;
                  	
                 break;	//Case	

                ;
	    } //switch

 			  echo "<BR> REVISION DE GAMES//".$game_id."  ****** ".$espn_game;  
			  if($game_id == $espn_game && $league != "mlb"){ // Double control Set -- MLB save his info apart
                $fields = $final;
			  	echo " = ACCESS GRANT <BR>";
			  	
			  	$result = 1;
			  	$type = 2;
			  	//print_r($fields);
			  	if($fields[0]["value"] != "") {

                       
			  		foreach ($fields as $field){

			  			$game_log = new _game_log();
			  			$game_log->vars["league"] = $league;
			  			$game_log->vars["player_espn_id"] = $player;
			  			$game_log->vars["espn_game"] = $espn_game;
			  			$game_log->vars["field"] = $field["id"];
			  			$game_log->vars["value"] = $field["value"];			  
			  			$game_log->vars["type"] = $type;			  
			  			$game_log->insert();

			  		}

			  	}

			  } else {

			 	//echo "TYPE ".$type = 1;
			 	// GAME LOG OF THE PLAYER IS NOT UPDATED IN ESPN WE WILL TRY THE OVERVIEW

			  	if($league != 'mlb'){

			  	echo "<BR>--GAME LOG NOT READY--OVERVIEW-----";
              //  if($type < 2 && $type != 0) { // Check why type has not to be 0
			  		if($type < 2) {
                  //echo "ENTRA OVERVIEW";
			  			$fields = fn_espn_players_overview_stats($league,$player);
                      //print_r($fields);
			  			if(!empty($fields)){
			  				$result = 1;	

			  				foreach ($fields as $field){

					 // print_r($field); exit;
			  					if(isset($field['id'])){
			  						$game_log = new _game_log();
			  						$game_log->vars["league"] = $league;
			  						$game_log->vars["player_espn_id"] = $player;
			  						$game_log->vars["espn_game"] =  $game_id;
			  						$game_log->vars["field"] = $field["id"];
			  						$game_log->vars["value"] = $field["value"];			  
			  						$game_log->vars["type"] = 1;			  
			  						$game_log->insert();


			  					}  
					 //  print_r($game_log);
					 // echo "++++++++++++++++++++++++++++++++++";

			  				}

			  			} else {
			  				echo "CONTROL";
			  				$result = 0;
			  			}
			  		}
              } //control mlb

              echo $result;

			 } //type


			 return $result;
			}


			function fn_get_mlb_game_log($game,$player){

				$league = 'mlb';
				$fields = fn_league_fields($league);
				$excl = fn_exclude_array($league);	
			 $link = "http://www.espn.com/mlb/player/gamelog/_/id/"; // last game is the first game
			 $i=0; 
			 echo "<BR>".$link.$player."<BR>"; 
			 $html = file_get_html($link.$player);
			 $valid = true;

			 $n=0;
						foreach ($html->find('div[class="Table__Scroller"]') as $div){ // Div 

							if($i==0){
								foreach($div->find("table th") as $th) { 
                          // echo $i.$n.")".$th->plaintext." -- ";

									if($n==3) {
                               	  if ($th->plaintext == "IP"){ $type = "P";} //pitching
                               	  if ($th->plaintext == "AB"){ $type = "B";} // batting
                               	} 

                               	$n++;
                               }	
                           }   
                           

						  foreach($div->find("table tr") as $tr) { // tr    
						  	$j=0;

						  	if($valid){


						  		echo "<BR>".$i;
								foreach ($tr->find("td") as $td){  //td

                                    // echo $j.")".$td->plaintext." -- ";
									if($j==2) {

										$status = $td->plaintext[0];   
										if($status == 'W'){
											$player_data['w'] = 1;
											$player_data['l'] = 0;
										} else {
											$player_data['w'] = 0;
											$player_data['l'] = 1;

										}

										foreach ($td->find("a") as $a){ 
											$espn_game = str_center("gameId/","/",$a->href."/");
											$espn_game  =  str_replace("/","",$espn_game); 	 
										   // echo '-------------'.$espn_game."<BR>";		
											if($game != $espn_game){
												echo "----> Not ready in ESPN";
												return 0;
											}

										}
									} 

									if($type == "B") {
										if($j==3){
											$player_data['ab'] = $td->plaintext;
										}
										if($j==4){
											$player_data['r'] = $td->plaintext;
										}
										if($j==5){
											$player_data['h'] = $td->plaintext;
										}
										if($j==6){
											$player_data['2b'] = $td->plaintext;
										}
										if($j==7){
											$player_data['3b'] = $td->plaintext;
										}
										if($j==8){
											$player_data['hr'] = $td->plaintext;
										}
										if($j==9){
											$player_data['rbi'] = $td->plaintext;
										}
										if($j==10){
											$player_data['bb'] = $td->plaintext;
										}
										if($j==11){
											$player_data['hbp'] = $td->plaintext;
										}
										if($j==12){
											$player_data['out'] = $td->plaintext;
										}
										if($j==13){
											$player_data['sb'] = $td->plaintext;
										}

									} 


									if($type == "P") {
										if($j==3){
											$player_data['ip'] = $td->plaintext;
										}
										if($j==4){
											$player_data['h'] = $td->plaintext;
										}
										if($j==5){
											$player_data['r'] = $td->plaintext;
										}
										if($j==6){
											$player_data['er'] = $td->plaintext;
										}
										if($j==7){
											$player_data['hr'] = $td->plaintext;
										}
										if($j==8){
											$player_data['bb'] = $td->plaintext;
										}
										if($j==9){
											$player_data['so'] = $td->plaintext;
										}
										if($j==10){
											$player_data['gb'] = $td->plaintext;
										}
										if($j==11){
											$player_data['fb'] = $td->plaintext;
										}
										if($j==12){
											$player_data['p'] = $td->plaintext;
										}


									}



									$j++;



								} //TD
								$i++;
								if($i == 2){break;}
								//break;
							 }//valid
							 

						    }//TR
						  // } //n

						    break;
						  }//DIV  

						  return $player_data;

						}

						function fn_espn_players_overview_stats($league,$player){

							$fields = array();
							$fields_temp = array();
							switch($league){


								case "nba":

								$fields_espn = array("gp","min","fg%","3p%", "ft","reb","ast","blk","stl","pf","to","pts");

								$link = "https://www.espn.com/nba/player/_/id/";
								$i=0; 
								echo " OV -- ".$link.$player." ---- >";
			//exit;
								$html = file_get_html($link.$player);
								$n==0;
			// print_r($html);
			foreach ($html->find('div[class="Table__Scroller"]') as $div){ // Div 
			   foreach($div->find("table tr") as $tr) { // tr    

			   	if (contains_ck($tr->plaintext,"This Game")){ 
			   		$j=0;
                        foreach($tr->find("td") as $td) { // tr
                        	if($j>=1){
                        		$fields[$j]['id'] = $fields_espn[$j-1];
                        		$fields[$j]['value'] = $td->plaintext;
                        	}

                        	$j++;
                        }	
                        break;

                    }



                }
            }

            break;          

            case "nfl":

			  //$excl = fn_exclude_array($league);	
            $link = "https://www.espn.com/nfl/player/_/id/";
            $i=0; 
            echo " OV -- ".$link.$player." ---- >";
			//exit;
            $html = file_get_html($link.$player);
            $n==0;
			// print_r($html);
			foreach ($html->find('div[class="Table__Scroller"]') as $div){ // Div 
			   foreach($div->find("table tr") as $tr) { // tr    
                 // echo $tr->plaintext;
			   	if($n==0){
			   		$i = 0;	
			   		foreach ($tr->find('th') as $th) {


			   			$fields_temp[$i]['id'] = $th->plaintext;
                  //	echo $fields_temp[$i]['id']; exit;
                  	// Headers has the same name,, but need to classify in RECEIVERS , RUSHUING O PASSING
			   			if($th->plaintext == "YDS"){ 
			   				if($fields_temp[$i-1]['id'] == "CMP%"){ $th->plaintext = "pas_yds"; };
			   				if($fields_temp[$i-1]['id'] == "ATT"){ $th->plaintext = "ru_yds"; };
			   				if($fields_temp[$i-1]['id'] == "REC"){ $th->plaintext = "re_yds"; };
			   				if($fields_temp[$i-2]['id'] == "REC"){ $th->plaintext = "re_yds"; };
			   				if($fields_temp[$i-1]['id'] == "FR"){ $th->plaintext = "fu_yds"; };
			   				if($fields_temp[$i-1]['id'] == "INT"){ $th->plaintext = "int_yds"; };

			   			}
			   			if($th->plaintext == "ATT"){ 
			   				if($fields_temp[$i-1]['id'] == "CMP"){ $th->plaintext = "pas_att"; } else {  $th->plaintext = "ru_att";}

			   			}	
			   			if($th->plaintext == "CMP"){ 
			   				$th->plaintext = "pas_cmp";

			   			}
			   			if($th->plaintext == "INT"){ 
			   				$th->plaintext = "pas_int";

			   			}

			   			if($th->plaintext == "TOT"){ 
			   				$th->plaintext = "ta_tot";

			   			}

			   			if($th->plaintext == "PTS"){ 
			   				if($fields_temp[$i-1]['id'] == "XPA"){ $th->plaintext = "pa_pts"; };

			   			}



			   			if($th->plaintext == "REC"){ 
			   				$th->plaintext = "re_rec"; ;
			   			}
			   			if($th->plaintext == "LNG"){ 
			   				if($fields_temp[$i-4]['id'] == "ATT"){ $th->plaintext = "ru_lng"; };
			   				if($fields_temp[$i-4]['id'] == "REC"){ $th->plaintext = "re_lng"; };
			   				if($fields_temp[$i-4]['id'] == "TGTS"){ $th->plaintext = "re_lng"; };
			   				if($fields_temp[$i-4]['id'] == "INT"){ $th->plaintext = "int_lng"; };
			   				if($fields_temp[$i-1]['id'] == "INT"){ $th->plaintext = "pas_lng"; };


			   			}
			   			if($th->plaintext == "TD"){ 
			   				if($fields_temp[$i-3]['id'] == "REC"){ $th->plaintext = "re_td"; };
			   				if($fields_temp[$i-3]['id'] == "TGTS"){ $th->plaintext = "re_td"; };
			   				if($fields_temp[$i-3]['id'] == "ATT"){ $th->plaintext = "ru_td"; };
			   				if($fields_temp[$i-3]['id'] == "CMP%"){ $th->plaintext = "pas_td"; };
			   				if($fields_temp[$i-3]['id'] == "INT"){ $th->plaintext = "int_td"; };


			   			}	


			   			$fields[$i]['id'] = $th->plaintext;
			   			$i++;
			   		}
			   	} 
			   	if($n==1){
			   		$i=0;
			   		foreach ($tr->find('td') as $td) {
                  	echo $td->plaintext."--";
			   			$fields[$i]['value'] = $td->plaintext;
			   			$i++;
			   		}
			   	}

                  //echo "<BR>";
			   	$n++;
			   	if($n==2){break;}
			   }
			   break;			 
			}


			if($fields[0]['id'] == 'Splits' && $fields[0]['value'] == 'This Game'){
				unset($fields[0]);
			} else {
				$fields = array();
			}


			break;				  	
		}						  	

		return $fields;
	}
	
	function fn_espn_game_data_log_by_league($league,$game_id){


		switch ($league)	{

			case "nba":

			$link = "http://www.espn.com/nba/playbyplay?gameId=";

			$i=0; 
			echo $link.$game_id."   ";
			$html = file_get_html($link.$game_id);
			$valid = false;

			$n=0;
			$over=false;
			$score = array();
			echo "<BR>";	
						foreach ($html->find('div[class="Table__Scroller"]') as $div){ // Div 

						  foreach($div->find("table tr") as $tr) { // tr
						  	$j=0;
						  	if($n==0){
						  		if (contains_ck($tr->plaintext,"OT")){ $over = true; }
						  	}
							  foreach ($tr->find("td") as $td){  //td
							  	if($n==1){
							  		if($j==1) { $score["1QA"] = $td->plaintext; }  
							  		if($j==2) { $score["2QA"] = $td->plaintext; }  									 
							  		if($j==3) { $score["3QA"] = $td->plaintext; }  									 									 
							  		if($j==4) { $score["4QA"] = $td->plaintext; }  									 									 
							  		if($j==5){
							  			if($over) { $score["OTA"] = $td->plaintext; }  
							  			else {  $score["TA"] = $td->plaintext;  }									 										 
							  		} 
							  		if($j==6) { $score["TA"] = $td->plaintext; }   

							  	} 
							  	if($n==2){
							  		if($j==1) { $score["1QH"] = $td->plaintext; }  
							  		if($j==2) { $score["2QH"] = $td->plaintext; }  									 
							  		if($j==3) { $score["3QH"] = $td->plaintext; }  									 									 
							  		if($j==4) { $score["4QH"] = $td->plaintext; }  									 									 
							  		if($j==5){
							  			if($over) { $score["OTH"] = $td->plaintext; }
							  			else {  $score["TH"] = $td->plaintext;  }  									 										 
							  		}
							  		if($j==6) { $score["TH"] = $td->plaintext; }     

							  	} 

							  	$j++;
							  }
							  $n++;
							  if($n==3){break;} 
							}
							break;
						}


						print_r($score);                 


						if(!empty($score)){

							foreach($score as $key => $sc){
								echo $key . ":" . $sc . "<br>";
								$game_log = new _game_log();
								$game_log->vars["league"] = $league;
								$game_log->vars["player_espn_id"] = "000";
								$game_log->vars["espn_game"] = $game_id;
								$game_log->vars["field"] = $key;
								$game_log->vars["value"] = $sc;			  
								$game_log->insert();
								$result = true;

							}	
							

						}
						
						//echo "<pre>";
					  //	 print_r($score)	;
					//	echo "</pre>";					  
						//
						$away_total;$home_total = 0;
						$first = false;
						$first_10 = false;
						$first_20 = false;	
						$scr = array();											
						echo "<BR>";

						$scripts = $html->find('script');

						foreach($scripts as $s) {
							if (contains_ck($s->innertext,"__espnfitt__")){ 
								$json =  $s->innertext;
							}
						}

						unset($html); // Free Memory
						$expStr=explode('playGrps":[[',$json);
						unset($expStr[0]);  // Free Memory
						$playgame = $expStr[1];  // Free Memory
						$expStr=explode(',"tms"',$playgame);
						$playgame = $expStr[0];
						unset($expStr);  // Free Memory
						$periods = explode("],[",$playgame);

						$i = 0;
						foreach ($periods as $period) {
							$period = str_replace("]]", "", $period);
						  //$periods[$i] = '{ "Period_'.($i+1).'": ['.$period.']}';	
							$periods[$i] = '{ "Periods": ['.$period.']}';	
							$playbyplay[$i] =  json_decode($periods[$i],true);
							$i++;	
						}

						$j=1;
						foreach($playbyplay as $plays){

                           // echo "---> PERIOD ".$j."<BR>";
							foreach($plays['Periods'] as $play){

                              //     echo "--------->".$play['text']."<BR>";    


							}


							$j++;

						}


						print_r($playbyplay);  
						
						/*
						foreach ($html->find('div[id="gamepackage-qtrs-wrap"]') as $div_main){ // Div 
						
						  foreach ($div_main->find('div') as $div){ // Div 
						  
						   foreach($div->find("table tr") as $tr) { // tr
						  							
							  $n=0;
							  foreach ($tr->find("td") as $td){  //td
						  		   
								  
								  if($n== 3){
									 
									  $sc = explode("-",trim($td->plaintext));
									  $away_total = $sc[0];
									  $home_total = $sc[1];	
							 		  //echo "Away ".$scr[0]." - "."Home ".$scr[1];
				  
								      if(!$first){
										if($away_total > 0) { echo " ->  WIN AWAY --> "; $first = true; $scr["FH"] = 0; $scr["FA"] = 1;}   
										if($home_total > 0) { echo " -> WIN HOME --> "; $first = true; $scr["FH"] = 1; $scr["FA"] = 0;}   										
									  }
									  if(!$first_10){
										if($away_total >= 10) { echo "WIN AWAY F10 :".$away_total."  --> "; $first_10 = true; $scr["FH_10"] = 0; $scr["FA_10"] = 1;}   
										if($home_total >= 10) { echo "WIN HOME F10 :".$home_total."  --> "; $first_10 = true; $scr["FH_10"] = 1; $scr["FA_10"] = 0;}   										
									  }

									  if(!$first_20){
										if($away_total >= 20) { echo "WIN AWAY F20 :".$away_total."  <BR> "; $first_20 = true; $scr["FH_20"] = 0; $scr["FA_20"] = 1; break;}   
										if($home_total >= 20) { echo "WIN HOME F20 :".$home_total."  <BR> "; $first_20 = true; $scr["FH_20"] = 1; $scr["FA_20"] = 0; break;}   										
									    
									  }
									  
									  
									 
								  }

							
							  $n++;
							  }
							  
							  if($first_20){ break;}
						    }
						   if($first_20){ break;}
						 }
						
						}

                        */

						if(!empty($scr)){

							foreach($scr as $key => $sc){
							  // echo $key . ":" . $sc . "<br>";
								$game_log = new _game_log();
								$game_log->vars["league"] = $league;
								$game_log->vars["player_espn_id"] = "000";
								$game_log->vars["espn_game"] = $game_id;
								$game_log->vars["field"] = $key;
								$game_log->vars["value"] = $sc;			  
								$game_log->insert();
								$result = true;
							}	

						}
						break;

						case "nfl":

						$link = "http://www.espn.com/nfl/boxscore?gameId=";

						$i=0; 

						echo $link.$game_id."   ";
						$html = file_get_html($link.$game_id);
						$valid = false;


				   //*************************************//
				   // ----  SCORE PROCCESS NFL -----//
				   //************************************//

						$n=0;
						$over=false;
						$score = array();
					 foreach ($html->find('div[class="Table__Scroller"]') as $div){ // Div 
					   foreach($div->find("table tr") as $tr) { // tr
					   	$j=0;
					   	if($n==0){
					   		if (contains_ck($tr->plaintext,"OT")){ $over = true; }
					   	}
						  foreach ($tr->find("td") as $td){  //td

						  	if($n==1){
						  		if($j==1) { $score["1QA"] = $td->plaintext; }  
						  		if($j==2) { $score["2QA"] = $td->plaintext; }  									 
						  		if($j==3) { $score["3QA"] = $td->plaintext; }  									 									 
						  		if($j==4) { $score["4QA"] = $td->plaintext; }  									 									 

						  		if($j==5) { 
						  			if($over) { $score["OTA"] = $td->plaintext; }  
						  			else {  $score["TA"] = $td->plaintext;  }									 										 
						  		} 
						  		if($j==6) { $score["TA"] = $td->plaintext; }   
						  	} 

						  	if($n==2){
						  		if($j==1) { $score["1QH"] = $td->plaintext; }  
						  		if($j==2) { $score["2QH"] = $td->plaintext; }  									 
						  		if($j==3) { $score["3QH"] = $td->plaintext; }  									 									 
						  		if($j==4) { $score["4QH"] = $td->plaintext; }  									 									 

						  		if($j==5) {
						  			if($over) { $score["OTH"] = $td->plaintext; }
						  			else {  $score["TH"] = $td->plaintext;  }  									 										 
						  		}
						  		if($j==6) { $score["TH"] = $td->plaintext; }     

						  	} 

						  	$j++;
						    } //td
						    $n++;
						    if($n==3){break;} 
						   } //tr
						} //div

					  	//print_r($score); exit;
						if(!empty($score)){

							foreach($score as $key1 => $sc){
								$game_log = new _game_log();
								$game_log->vars["league"] = $league;
								$game_log->vars["player_espn_id"] = "000";
								$game_log->vars["espn_game"] = $game_id;
								$game_log->vars["field"] = $key1;
								$game_log->vars["value"] = $sc;			  
								$game_log->insert();
								$result = true;

							}	

						 //*************************************//
						 // ---- END OF SCORE PROCCESS NFL -----//
						 //************************************//


						 //*************************************//
						 // ----SACKS PROCCESS NFL -----//
						 //************************************//

							$t=0;
						    foreach ($html->find('div[class="sub-module"]') as $div){ // Div 

                                 if(contains_ck($div->plaintext,"Defensive")){ //

                                 	foreach($div->find('tr[class="highlight"]') as $total){

                                 		$sacks = $total->find('td[class="sacks"]');

                                 		if($t==0){
                                 			$src["SACKS_A"] = $sacks[0]->plaintext ;  

                                 		}
                                 		if($t==1){
                                 			$src["SACKS_H"] = $sacks[0]->plaintext ;  

                                 		}
                                 		$t++;
                                 		if($t==2){break;}
                                 	}

                                 }
                                 if($t==2){break;}

                             } 



					     //*************************************//
						 // ----END SACKS PROCCESS NFL -----//
						 //************************************//



						 //*************************************//
						 // ---- PLAYS PROCCESS NFL------ -----//
						 //************************************//

                             //$link = "https://www.espn.com/nfl/playbyplay?gameId=";
                             $link = "https://www.espn.com/nfl/playbyplay/_/gameId/";
                             echo $link.$game_id."  <BR><BR> ";

                             $html = file_get_html($link.$game_id);
                             $away_total;$home_total = 0;
                             $first = false;
                             $first_10 = false;
                             $first_20 = false;	
                             $scr = array();	
                             $data = array();
                             $yards_array = array();
                             $yards_array_fg = array();
                             $key=0;										


						foreach ($html->find('div[id="NFLPlayByPlay__Container"]') as $div_main){ // Div 
							$j=0;
						 foreach ($div_main->find('li[class="accordion-item"]') as $li_main){ // Div 
						  foreach ($li_main->find('div[class="accordion-header"]') as $div){ // Div 
						   foreach ($div->find('a') as $a){ // a
						   	$n=0;
							  foreach ($a->find('div') as $a_div){ //   a_div
							  	if($n==0){
							  		foreach ($a_div->find('img') as $img){ 
							  			$team = trim(strtoupper(str_center("500/",".png",$img->src)));
							  			$data[$key]['team'] = $team;
							  		}
							  		foreach ($a_div->find('span[class=headline]') as $span){ 
							  			$type = trim($span->plaintext);
							  			$data[$key]['type'] = $type;
							  		}
							  		foreach ($a_div->find('span[class=drive-details]') as $span2){ 
							  			$type2 = explode(",",trim($span2->plaintext));
							  			$data[$key]['time'] = $type2[2];
							  		}
							  	}
							  	if($n==1){
									     foreach ($a_div->find('span[class=away]') as $span1){ // Looks like colum class Away has home results
									     	$l=0;
									     	foreach ($span1->find('span') as $span_a){ 
									     		if($l==0){
									     			$home = trim($span_a->plaintext);
									     			$data[$key]['home'] = $home;
									     		}
									     		if($l==1){
									     			$home_score = trim($span_a->plaintext);
									     			$data[$key]['home_score'] = $home_score;
									     		}
									     		$l++;
									     	}
									     }

										foreach ($a_div->find('span[class=home]') as $span2){  // Looks like colum class Home has away results
											$l=0;
											foreach ($span2->find('span') as $span_b){ 
												if($l==0){
													$away = trim($span_b->plaintext);
													$data[$key]['away'] = $away;
												}
												if($l==1){
													$away_score = trim($span_b->plaintext);
													$data[$key]['away_score'] = $away_score;

													if($data[$key]['team'] == $data[$key]['away']){ $data[$key]['main'] = "A"; } else {$data[$key]['main'] = "H";}

												  // $key++;
												}
												$l++;
											}
											 } //span2

											} 
											$n++;

								    } // a_div
								    

						     	  } // a

                                   // GETTING THE J (POSITION OF THE FIRST SCORE)

						     	  if(!$first){
						     	  	echo "FAAA ".$j." -";
						     	    if($data[$key-1]['away_score'] > 0) { $first = true; $src["FA"] = $data[$key-1]['away_score'] ; $src["FH"] = 0; $first = true; $first_score_pos = $j-1;}  // Score  First  
								    if($data[$key-1]['home_score'] > 0) {  $first = true; $src["FH"] = $data[$key-1]['home_score'] ; $src["FA"] = 0; $first = true; $first_score_pos = $j-1; }  // Score  First  	            
								    
								}

							   } //div  accordion

							   $key++;	
							   $j++;			

						} // li accordrion

			 	 	} // div main

			 	 	echo "<pre>";
			 	 	echo "FIRST ".$first_score_pos;
			 	 	print_r($data); exit; 

  						//$data = array_values($data);
 						 //*************************************//
						 // ----END  PLAYS PROCCESS NFL----- --//
						 //************************************/



						//*************************************//
						 // ---SPECIAL  PLAYS PROCCESS NFL-- --//
						 //************************************/

			 	 	$last_two_min = false;
			 	 	$control_timeout = false;
			 	 	$c=0;$d=0;
			 	 	$Touchdown = array();
			 	 	$Fieldgoal =  array(); 
			 	 	$fg_half  = $td_half = $fg_team_a = $fg_team_h =  $td_team_a = $td_team_h = 0   ;  

                                 foreach ($html->find('div[id="gamepackage-drives-wrap"]') as $div_main){ // Div 
                                 	$j=0;
                                 	foreach ($div_main->find('li[class="accordion-item"]') as $li_main){


                                 		$tittle = $li_main->find('div[class="accordion-header"]');

                                 foreach ($tittle  as $key => $div_header  ){ // Div content
                                 	$main =  $div_header->plaintext;
                                 	if(contains_ck($main,"Touchdown")){
 								       	$Touchdown[$c] = $j;  // We save the pos of the dic that is a Touchdown; 
 								       }
 								       if(contains_ck($main,"Field Goal")){
 								       	$Fieldgoal[$d] = $j;  // We save the pos of the dic that is a Touchdown; 
 								       }

 								       $c++; $d++;
 								   }

								 foreach ($li_main->find('div[class="accordion-content"]') as $div_content){ // Div content
								 	$h=0;
								 	$li_find = $div_content->find('li');
								 	$total_li = count($li_find) -1;

								 	if(contains_ck($li_find[$total_li]->plaintext,"Timeout") || contains_ck($li_find[$total_li]->plaintext,"Warning")){
								 		$total_li = $total_li - 1 ;
								 	}	
									  foreach ($li_find as $li){ // li


									  	if($j == $first_score_pos){
									  		if($h==$total_li){ 
									  			foreach ($li->find('span') as $span) {
									  				$time_score =  trim(str_center("("," -",$span->plaintext));

									  				echo $time_score." +++++ <BR>";
									  				$period_time = date("H:i" ,strtotime('15:00'));
									  				$horaInicio = new DateTime($period_time);
									  				$horaTermino = new DateTime($time_score);
									  				$interval = $horaInicio->diff($horaTermino);
									  				$T_m = $interval->format('%H');
									  				$T_i = $interval->format('%i');
									  				if($T_i < 10){ $T_i = "0".$T_i;}
									  				$time_score =  $T_m.":".$T_i;

									  			}	

									  		}	
									  	}   

                                      //  print_r($Touchdown);
									  	if (in_array($j, $Touchdown)){
                                            if($h==$total_li){  // Here enter to check the last line for Touchdowns

                                               	 if(contains_ck($li->plaintext,"Yd Rush")){ //

                                               	 	foreach ($li->find('span') as $span) {
                                               	 		$variable = substr($span->plaintext, 0, strpos($span->plaintext, " Yd Rush"));
                                               	 		$yard = explode(" ",$variable);																													 
                                               	 		$yards =   end($yard);
                                               	 		$yards_array[$h] = $yards;
                                               	 		break;
                                               	 	}												
                                               	 } 

                                                    if(contains_ck($li->plaintext,"Yds")){ //

                                                    	foreach ($li->find('span') as $span) {
                                                    		$variable = substr($span->plaintext, 0, strpos($span->plaintext, " Yds"));
                                                    		$yard = explode(" ",$variable);																													 
                                                    		$yards =   end($yard);
                                                    		$yards_array[$h] = $yards;
                                                    		break;
                                                    	}												
                                                    } 

													if(contains_ck($li->plaintext,"yards")){ //

														foreach ($li->find('span') as $span) {
															$variable = substr($span->plaintext, 0, strpos($span->plaintext, " yards"));
															$yard = explode(" ",$variable);																													 
															$yards =   end($yard);
															$yards_array[$h] = $yards;
															break;
														}												
													} 
													if(contains_ck($li->plaintext,"Yd Run")){ //

														foreach ($li->find('span') as $span) {
															$variable = substr($span->plaintext, 0, strpos($span->plaintext, " Yd Run"));
															$yard = explode(" ",$variable);																													 
															$yards =   end($yard);
															$yards_array[$h] = $yards;
															break;
														}												
													}  
													 if(contains_ck($li->plaintext,"Yd pass")){ //

													 	foreach ($li->find('span') as $span) {
													 		$variable = substr($span->plaintext, 0, strpos($span->plaintext, " Yd pass"));
													 		$yard = explode(" ",$variable);																													 
													 		$yards =   end($yard);
													 		$yards_array[$h] = $yards;
													 		break;
													 	}												
													 }  
													}
                                              //print_r($yards_array);

                                            } // in array touchdowns


                                            if (in_array($j, $Fieldgoal)){

                                               if(contains_ck($li->plaintext,"yard field goal")){ // LOGNGETS FG
                                               	foreach ($li->find('span') as $span) {
                                               		$variable = substr($span->plaintext, 0, strpos($span->plaintext, " yard"));
                                               		$yard = explode(" ",$variable);																													 
                                               		$yards =   end($yard);
                                               		$yards_array_fg[$h] = $yards;
                                               		break;
                                               	}
                                               }
                                          	 }	 // in array FieldGoals




                                           //A SCORE IN LAST 2M OF 1HE//
                                          	 if (in_array($j, $Fieldgoal) || in_array($j, $Touchdown)){   

                                          	 	if($h==$total_li){  
                                          	 		if(contains_ck($li->plaintext,"- 2nd")){
                                          	 			$raw = $li->find('span')[0]."<BR>";
                                          	 			$raw = explode("- 2nd)",$raw);
												//print_r($raw);
                                          	 			$hour = str_replace("(", "", $raw[0]);
                                          	 			$hour = str_replace('<span class="post-play">', "", $hour);
                                          	 			$hour = str_replace(":", "", $hour);
                                          	 			$hour = str_replace(" ", "", $hour);
                                          	 			$max = intval($hour);

                                          	 			$j_lastTeam_Halft = $j;


												if($max <= 200 ) { // Anotacion en los ultimos 2 minutos

													if(contains_ck($li->plaintext," Yd Rush") || contains_ck($li->plaintext," yards") || contains_ck($li->plaintext," Yds") || contains_ck($li->plaintext,"yard field goal")){    
														$last_two_min = true;
													}   
												}
											} 
										}
                                            }//  


                                             // SCORE IN EVERY QTR
                                            if (in_array($j, $Fieldgoal) || in_array($j, $Touchdown)){   


                                            	if($h==$total_li){ 
                                            		foreach ($li->find('span') as $span) {
                                            			$period =  trim(str_center("- ",")",$span->plaintext));
                                            			$team = $data[$j]['main'];

                                            			if($period == "1st"){ $p = 1; }
                                            			if($period == "2nd"){ $p = 2; }
                                            			if($period == "3rd"){ $p = 3; }
                                            			if($period == "4th"){ $p = 4; }

                                            			$scr_team[$p."_".$team] = $team;


                                            		}
                                            	}	

                                            }

                                           // TDS IN HALF

                                            if (in_array($j, $Touchdown)){   


                                            	if($h==$total_li){ 
                                            		foreach ($li->find('span') as $span) {
                                            			$period =  trim(str_center("- ",")",$span->plaintext));
                                            			$team = $data[$j]['main'];

                                            			if($period == "1st" || $period == "2nd"){ $td_half++; }
                                            			if($team == 'A') { $td_team_a++;}
                                            			if($team == 'H') { $td_team_h++;}
												 //	echo $td_team_a." ".$td_team_h;
                                            		}
                                            	}	

                                            }



                                           // FG IN HALF


                                            if (in_array($j, $Fieldgoal)){   


                                            	if($h==$total_li){ 
                                            		foreach ($li->find('span') as $span) {
                                            			$period =  trim(str_center("- ",")",$span->plaintext));
                                            			$team = $data[$j]['main'];
                                            			if($period == "1st" || $period == "2nd"){ $fg_half++; }
                                            			if($team == 'A') { $fg_team_a++;}
                                            			if($team == 'H') { $fg_team_h++;}
                                            		}
                                            	}	

                                            }




                                           //TIMEOUT
                                            if(!$control_timeout){  
                                            	if(contains_ck($li->plaintext,"Timeout")){
                                            		$team =  trim(str_center("by "," at",$li->plaintext));
                                            		$last= end($data);
                                            		if($last['home'] == $team){ $timeout_t = "H"; }
                                            		if($last['away'] == $team){ $timeout_t = "A"; }
											 // echo $timeout_t."<BR> ";
                                            		$control_timeout = true;

                                            	}
                                            }


                                            if($h==0){
                                            	$period = trim(str_center("-",")",$li->plaintext));
                                            	$data[$key]['period'] = $period; 
                                            } else{
                                            	if(contains_ck($li->plaintext,"Timeout")){
                                            		$timeout =  trim(str_center("by "," ",$li->plaintext));
											    $data[$key]['timeout'] = $timeout[0].$timeout[1]; // Just 2 letters
											}
											if(contains_ck($li->plaintext,"PENALTY")){
												$penalty =  trim(str_center("PENALTY on "," ",$li->plaintext));
										         $data[$key]['penalty'] = $penalty[0].$penalty[1]; // Just 2 letters
										     } 
										     if(contains_ck($li->plaintext,"Interception Return")){
										     	$timeout =  trim(str_center("by "," ",$li->plaintext));
										     	$data[$key]['return'] = 1;
										     }
										 }
										 $h++;
										  // break; // Here we can check all the li, all the data however we are only getting the Period.
										 } // li

										//$k++;
									   } //div content

									   $key++;	
									   $j++;			

									} // li accordrion

								 } // div main





								 //*************************************//
						 		// ----END  SPECIAL PLAYS PROCCESS NFL--//
						 		//************************************//




								 echo "<pre>";

									//  print_r($data);
									 // echo "</pre>";

								 if(!empty($data)){

								 	$first = false;
								 	$first_10 = false;
								 	$fg_1 = false;
								 	$punt = false;
								 	$ca = 0;
								 	$ch = 0;
								 	$old_score_away = 0;
								 	$old_score_home = 0;
								 	$penalty = false;
   										  // $timeout = false;
								 	$fum_control = false;
								 	$int_control = false;
								 	$td_control = false;
								 	$fg_control = false;
								 	$sf_control = false;


   										   //PROCESS TO TEAM SCORE ALL QTS


								 	if (isset($scr_team["1_A"]) && isset($scr_team["2_A"]) && isset($scr_team["3_A"]) && isset($scr_team["4_A"]) ){
								 		$src["ALL_QTS_A"] = 1;
								 	} else { $src["ALL_QTS_A"] = 0;}
								 	if (isset($scr_team["1_H"]) && isset($scr_team["2_H"]) && isset($scr_team["3_H"]) && isset($scr_team["4_H"]) ) {
								 		$src["ALL_QTS_H"] = 1;
								 	} else { $src["ALL_QTS_H"] = 0; }


                                            // TOTAL FG IN GAME 
								 	$src["FG_GAME"] = count($Fieldgoal);
								 	$src["TD_GAME"] = count($Touchdown);

								            //TOTAL TD FG GAME AND HALF

								 	$src["FG_HALF"] = $fg_half ;  
								 	$src["FG_GAME_A"] = $fg_team_a ;  
								 	$src["FG_GAME_H"] = $fg_team_h ;  
								 	$src["TD_HALF"] = $td_half ;  
								 	$src["TD_GAME_A"] = $td_team_a ;  
								 	$src["TD_GAME_H"] = $td_team_h ;  



								 	foreach($data as $d){


								 		$team = $d['main'];

								 		$src["LAST_TEAM_SC_1H"] = $data[$j_lastTeam_Halft]['main'] ;

								 		$src["LAST_SCORE_TYPE_1H"] = $data[$j_lastTeam_Halft]['type'] ;


								 		if(!empty($yards_array)){
								 			$src['LONGEST_TD'] = max($yards_array);
								 			$src['SHORTEST_TD'] = min($yards_array);

								 		}

								 		if(!empty($yards_array_fg)){
								 			$src['LONGEST_FG'] = max($yards_array_fg);

								 		}
								 		$src['LAST_2MIN_HAlF'] = 0; 
								 		if($last_two_min){
								 			$src['LAST_2MIN_HAlF'] = 1;                                                 	
								 		}


												 // checkin 3 Unanswered Scores
								 		if(!$src['3USRC_A']) { $src['3USRC_A'] = 0 ;}
								 		if(!$src['3USRC_H']) { $src['3USRC_H'] = 0 ;}



								 		if($d['away_score'] > $old_score_away && $d['home_score'] == $old_score_home ){
								 			if($s_team == "A"){ $ca++;} else {$ca = 0;}
								 			$s_team = "A";

								 			if($ca==2){ $src['3USRC_A'] = 1; }
								 		}
								 		if($d['home_score'] > $old_score_home && $d['away_score'] == $old_score_away ){
								 			if($s_team == "H"){ $ch++;} else {$ch =0;}
								 			$s_team = "H";

								 			if($ch==2){ $src['3USRC_H'] = 1; }
								 		}

								 		if($d['type'] == 'Fumble' && !$fum_control){
								 			$src['FUM']  = $team; 
								 			$src['FUM_T']  = trim($d['period'][0]."_".str_replace(":","",$d['time']));
								 			$fum_control = true;
								 		}	

								 		if($d['type'] == 'Interception' && !$int_control){
								 			$src['INT']  = $team; 
								 			$src['INT_T']  = trim($d['period'][0]."_".str_replace(":","",$d['time']));
								 			$int_control = true;
								 		}	

								 		if($d['type'] == 'Safety' && !$sf_control){
								 			$src['SF']  = $team; 
								 			$src['SF_T']  = trim($d['period'][0]."_".str_replace(":","",$d['time']));
								 			$sf_control = true;
								 		}	


								 		if($d['type'] == 'Field Goal'){

								 			if($d['period'] == '1st'){
													    $src['FG_1']  = 1;  // A FIELD GOAL FIRST TIME
													}
													if($team == 'A'){
														
														$src['TFGA'] =  $src['TFGA'] + 1;  // Total FG away
													} else {
														$src['TFGH'] =  $src['TFGH'] + 1;   // Total FG home
													}


													if(!$fg_control){
														$src['FG']  = $team; 
														$src['FG_T']  = trim($d['period'][0]."_".str_replace(":","",$d['time']));
														$fg_control = true;
													}

												}
												if( $d['type'] == 'Touchdown'){

													if($d['period'] == '1st'){
														$src['TD_1']  = 1;
													}
													if($team == 'A'){
														$src['TTDA'] =  $src['TTDA'] + 1;  // Total TD away
													} else {
														$src['TTDH'] =  $src['TTDH'] + 1;   // Total TD home
													}


													if(!$td_control){
														$src['TD']  = $team; 
														$src['TD_T']  = trim($d['period'][0]."_".str_replace(":","",$d['time']));
														$td_control = true;
													}
												}



												if($d['away_score'] != $old_score_away || $d['home_score'] != $old_score_home  ){
													$last_type = $d['type'];   
												}

												if($d['type'] == 'End of Half'){
													if($last_type == 'Field Goal'){
														  $src['LS1H_FG']  =1; // Last Score 1h is FG 
														}

													}

													if($control_timeout){

														$src['TIMEOUT'] = $timeout_t;

													}     


													if(isset($d['penalty'])){
														if(contains_ck($d['away'],$d['penalty'])){

															if(!$penalty){
																$src['PENA'] = 1;  $src['PENH'] = 0;
																$penalty = true;
															}
															$src['TPENA'] = $src['TPENA'] + 1; 

														}   
														if(contains_ck($d['home'],$d['penalty'])){

															if(!$penalty){
																$src['PENH'] = 1;  $src['PENA'] = 0;
																$penalty = true;
															}
															$src['TPENH'] = $src['TPENH'] + 1; 
														}    

														
													}




													$old_score_away = $d['away_score'];
													$old_score_home = $d['home_score'];


													if(!$first){
 										            if($d['away_score'] > 0) { $first = true; $src["FA"] = $d['away_score'] ; $src["FH"] = 0;}  // Score  First  
 										            if($d['home_score'] > 0) { $first = true; $src["FH"] = $d['home_score'] ; $src["FA"] = 0;}   


 										            $times_array = array("3:30","5:30","6:00","6:30","7:00","7:30");


 										            foreach ($times_array as $ta) {
 										            	if(strtotime($time_score) <= strtotime($ta)){
 										            		$ta = str_replace(":","", $ta);
 										            		$src[$ta] = 1;
 										            	} else {
 										            		$ta = str_replace(":","", $ta);
 										            		$src[$ta] = 0;
 										            	}
 										            }

 										        }
 										        if(!$first_10){
 										        	if($d['away_score'] >= 10) { $first_10 = true; $src["FA_10"] = 1; $src["FH_10"] = 0;}   
										            if($d['home_score'] >= 10) { $first_10 = true; $src["FH_10"] = 1; $src["FA_10"] = 0;}   //first score 10 pts
										        }

										        if($d['type'] == "Punt"){

										        	if(!$punt){
										        		if($team == 'A'){
										        			$src['PFA'] = 1;  $src['PFH'] = 0;
										        		} else{
										        			$src['PFA'] = 0;  $src['PFH'] = 1;  
										        		}
														$punt = true; // Punt First
													}
 													 $src['PL'] = $team;  // Punt Last

 													 if($team == 'A'){
														$src['TPA'] =  $src['TPA'] + 1;  // Total Punts away
													} else {
														$src['TPH'] =  $src['TPH'] + 1;   // Total Punts home
													}

												}

                                                  // Last Team Score
												if($d['type'] == "Field Goal" || $d['type'] == "Touchdown" ||  $d['type'] == "Safety"){
													$src['LAST_TEAM'] = $d['main'];
												}	
												  // First Team Score
												if(!isset( $src['FIRST_TEAM'])){
													if($d['type'] == "Field Goal" || $d['type'] == "Touchdown" ||  $d['type'] == "Safety"){
														$src['FIRST_TEAM'] = $d['main'];
													}	
												}


											}

											//Checking FUMBLE VS INT - 1st Turnover will be
											if (isset($src['FUM']) && !isset($src['INT'])){
												$src['FUM_VS_INT'] = $src['FUM'];
											}
											if (!isset($src['FUM']) && isset($src['INT'])){
												$src['FUM_VS_INT'] = $src['INT']; 
											}
											if (!isset($src['FUM']) && !isset($src['INT'])){
												$src['FUM_VS_INT'] = 0; 
											}
											if (isset($src['FUM']) &&  isset($src['INT'])){
												$fum = explode("_",$src['FUM_T']);
												$int = explode("_",$src['INT_T']);

												if ($fum[0] < $int[0]){
													$src['FUM_VS_INT'] = $src['FUM']; 
												}
												if ($fum[0] > $int[0]){
													$src['FUM_VS_INT'] = $src['INT']; 
												}
													if ($fum[0] == $int[0]){ // Mismo periodo
														if($fum[1] > $int[1]){
															$src['FUM_VS_INT'] = $src['INT'];
														} else {
															$src['FUM_VS_INT'] = $src['FUM'];
														}
													}

												}

											// 1ST SCORE WILL BE TD  VS FG OR SAFETY

												if (isset($src['TD']) && !isset($src['FG'])  && !isset($src['SF'])){
													$src['TD_VS_FG'] = $src['TD']; 
												}
												if (!isset($src['TD']) && isset($src['FG'])  && !isset($src['SF'])){
													$src['TD_VS_FG'] = $src['FG']; 
												}

												if (!isset($src['TD']) && !isset($src['FG'])  && isset($src['SF'])){
													$src['TD_VS_FG'] = $src['SF']; 
												}

												if (isset($src['TD']) &&  isset($src['FG']) && !isset($src['SF'])){
													$touc = explode("_",$src['TD_T']);
													$fieldgo = explode("_",$src['FG_T']);

													if ($touc[0] < $fieldgo[0]){
														$src['TD_VS_FG'] = $src['TD'];  
													}
													if ($touc[0] > $fieldgo[0]){
														$src['TD_VS_FG'] = $src['FG'];  
													}
													if ($touc[0] == $fieldgo[0]){ // Mismo periodo
														if($touc[1] > $fieldgo[1]){
															$src['TD_VS_FG'] = $src['FG']; 
														} else {
															$src['TD_VS_FG'] = $src['TD']; 
														}
													}

												}		

											if (isset($src['TD']) &&  !isset($src['FG']) && isset($src['SF'])){ // SAFETY
												$touc = explode("_",$src['TD_T']);
												$fieldgo = explode("_",$src['SF_T']); 

												if ($touc[0] < $fieldgo[0]){
													$src['TD_VS_FG'] = $src['TD']; 
												}
												if ($touc[0] > $fieldgo[0]){
													$src['TD_VS_FG'] = $src['SF']; 
												}
													if ($touc[0] == $fieldgo[0]){ // Mismo periodo
														if($touc[1] > $fieldgo[1]){
															$src['TD_VS_FG'] = $src['SF']; 
														} else {
															$src['TD_VS_FG'] = $src['TD']; 
														}
													}

												}





												if(!empty($src)){

													foreach($src as $key => $sc){
										  // echo $key . ":" . $sc . "<br>";
														$game_log = new _game_log();
														$game_log->vars["league"] = $league;
														$game_log->vars["player_espn_id"] = "000";
														$game_log->vars["espn_game"] = $game_id;
														$game_log->vars["field"] = $key;
														$game_log->vars["value"] = $sc;			  
														$game_log->insert();
														$result = true;
													}	

												}

											}

							} // empty scores
							

							echo "<pre>";
							print_r($src);
							echo "</pre>";


						//exit;  
							break;


							case "ncaaf":
				//case "nfl":

							$link = "http://www.espn.com/college-football/boxscore?gameId=";

							$i=0; 
							echo $link.$game_id."   ";
							$html = file_get_html($link.$game_id);
							$valid = false;
							
							$n=0;
							$over=false;
							$score = array();
							echo "<BR>";	
							foreach ($html->find('div[class="game-status"]') as $div){ // Div 

							  foreach($div->find("table tr") as $tr) { // tr
							  	$j=0;
							  	if($n==0){
							  		if (contains_ck($tr->plaintext,"OT")){ $over = true; }
							  	}
								  foreach ($tr->find("td") as $td){  //td

								      // echo $n."- ".$td->plaintext;
								  	if($n==1){
								  		if($j==1) { $score["1QA"] = $td->plaintext; }  
								  		if($j==2) { $score["2QA"] = $td->plaintext; }  									 
								  		if($j==3) { $score["3QA"] = $td->plaintext; }  									 									 
								  		if($j==4) { $score["4QA"] = $td->plaintext; }  									 									 


								  		if($j==5) { 
								  			if($over) { $score["OTA"] = $td->plaintext; }  
								  			else {  $score["TA"] = $td->plaintext;  }									 										 
								  		} 
								  		if($j==6) { $score["TA"] = $td->plaintext; }   

								  	} 
								  	if($n==2){
								  		if($j==1) { $score["1QH"] = $td->plaintext; }  
								  		if($j==2) { $score["2QH"] = $td->plaintext; }  									 
								  		if($j==3) { $score["3QH"] = $td->plaintext; }  									 									 
								  		if($j==4) { $score["4QH"] = $td->plaintext; }  									 									 
								  		if($j==5) {
								  			if($over) { $score["OTH"] = $td->plaintext; }
								  			else {  $score["TH"] = $td->plaintext;  }  									 										 
								  		}
								  		if($j==6) { $score["TH"] = $td->plaintext; }     

								  	} 

								  	$j++;
								  }
								  $n++;
								  if($n==3){break;} 
								}

							}
							if(!empty($score)){
								
								echo "<pre>";
								print_r($score)	;
								echo "</pre>";		

								foreach($score as $key => $sc){
								 //  echo $key . ":" . $sc . "<br>";
									$game_log = new _game_log();
									$game_log->vars["league"] = $league;
									$game_log->vars["player_espn_id"] = "000";
									$game_log->vars["espn_game"] = $game_id;
									$game_log->vars["field"] = $key;
									$game_log->vars["value"] = $sc;			  
									$game_log->insert();
									$result = true;
									
								}	
								

								$link = "https://www.espn.com/college-football/playbyplay?gameId=";
								echo $link.$game_id."   ";
								
								$html = file_get_html($link.$game_id);
								$away_total;$home_total = 0;
								$first = false;
								$first_10 = false;
								$first_20 = false;	
								$scr = array();	
								$data = array();
								$yards_array = array();
								$yards_array_fg = array();
								$key=0;										
								echo "<BR>";

									foreach ($html->find('div[id="gamepackage-drives-wrap"]') as $div_main){ // Div 

									 foreach ($div_main->find('li[class="accordion-item"]') as $li_main){ // Div 

									 	//echo  $li_main->plaintext."<BR>";

									  foreach ($li_main->find('div[class="accordion-header"]') as $div){ // Div 


									   foreach ($div->find('a') as $a){ // a

									   	$n=0;
										  foreach ($a->find('div') as $a_div){ //   a_div

										  	if($n==0){
										  		foreach ($a_div->find('img') as $img){ 
										 			 	//echo "*****".$img->src."----------";
										  			$id = trim(strtoupper(str_center("500/",".png",$img->src)));

										  			if($id > 0){

										  				$team = get_team_espn_short($league,$id);
										  				if(empty($team)){
										  					$subject = "MISSING SHORT - TEAM";
										  					$content = $id." NOT FOUND in GAME ".$game_id;
										  					send_email_ck('aandrade@inspin.com,andyh@inspin.com', $subject, $content, true, $current_clerk->vars["fake_email"]);
										  					echo "EMAIL SEND 1";
										  					return 0;
										  				}
										  				$t_id = $team['id'];
										  				$team = $team['short'];
										  				$data[$key]['team'] = $team;

										  			}


										  		}
										  		foreach ($a_div->find('span[class=headline]') as $span){ 
										  			$type = trim($span->plaintext);
										  			$data[$key]['type'] = $type;
										  		}
										  		foreach ($a_div->find('span[class=drive-details]') as $span2){ 
										  			$type2 = explode(",",trim($span2->plaintext));
										  			$data[$key]['time'] = $type2[2];
										  		}
										  	}
										  	if($n==1){
													foreach ($a_div->find('span[class=away]') as $span1){ // Looks like colum class Away has home results
														$l=0;
														foreach ($span1->find('span') as $span_a){ 
															if($l==0){
																$home = trim($span_a->plaintext);
																$data[$key]['home'] = $home;

															}
															if($l==1){
																$home_score = trim($span_a->plaintext);
																$data[$key]['home_score'] = $home_score;
															}
															$l++;

														}
													}

													foreach ($a_div->find('span[class=home]') as $span2){  // Looks like colum class Home has away results
														$l=0;
														foreach ($span2->find('span') as $span_b){ 
															if($l==0){
																$away = trim($span_b->plaintext);
																$data[$key]['away'] = $away;

																if($t_id > 0) {

																	if($team != $away && $team != $home){
                                                              //Check if a Short is Missing with ESPN
																		$subject = "MISSING SHORT";
																		$content = $t_id." ) ".$team." IS NOT EQUAL TO  ".$away." OR ".$home." IN GAME ".$game_id;
																		send_email_ck('aandrade@inspin.com,andyh@inspin.com', $subject, $content, true, $current_clerk->vars["fake_email"]);
																		echo "EMAIL SEND 2";
																		$team_control = false;
																		return 0;
																	}else{
																		$team_control = true;
																	}	

																}



															}
															if($l==1){
																$away_score = trim($span_b->plaintext);
																$data[$key]['away_score'] = $away_score;

																if($data[$key]['team'] == $data[$key]['away']){ $data[$key]['main'] = "A"; } else {$data[$key]['main'] = "H";}

															  //$key++;
															}
															$l++;

														}
													}

												} 
												$n++;
										  } // a_div

									     } // a

									   } //div  accordion

									    foreach ($li_main->find('div[class="accordion-content"]') as $div_content){ // Div content
									    	$h=0;
										  foreach ($div_content->find('li') as $li){ // li

										  	if($h==0){
										  		$period = trim(str_center("-",")",$li->plaintext));
										  		$data[$key]['period'] = $period; 
										  	} else{
										  		if(contains_ck($li->plaintext,"Timeout")){
										  			$timeout =  trim(str_center("by "," ",$li->plaintext));
													    $data[$key]['timeout'] = $timeout[0].$timeout[1]; // Just 2 letters
													}
													if(contains_ck($li->plaintext,"PENALTY")){
														$penalty =  trim(str_center("PENALTY on "," ",$li->plaintext));
										                $data[$key]['penalty'] = $penalty[0].$penalty[1]; // Just 2 letters


										            }
										            if(contains_ck($li->plaintext,"Interception Return")){
										            	$timeout =  trim(str_center("by "," ",$li->plaintext));
										            	$data[$key]['return'] = 1;

										            }
													if(contains_ck($li->plaintext,"for a TD")){ // LOGNGETS TD
														//  echo "--".$li->plaintext."<BR><BR>";
														foreach ($li->find('span') as $span) {
															$span->plaintext = str_replace("yds", "yd", $span->plaintext);
														 	//echo "**".$span->plaintext."<BR>";

															$yards =  trim(str_center("for","yd",$span->plaintext));
															$yards_array[$h] = $yards;
										                //  echo "<BR>YARDS ".$yards."<BR>";
															break;
														}
														
														
													}


													if(contains_ck($li->plaintext,"yard field goal")){ // LOGNGETS FG
														 // echo "--".$li->plaintext."<BR><BR>";
														foreach ($li->find('span') as $span) {

															$variable = substr($span->plaintext, 0, strpos($span->plaintext, " yard"));
															$yard = explode(" ",$variable);																													 
															$yards =   end($yard);
															$yards_array_fg[$h] = $yards;
										                    //echo "<BR>YARDS ".$yards."<BR>";
															break;
														}
														
														
													}
													
												}
												$h++;
										  // break; // Here we can check all the li, all the data however we are only getting the Period.
										 } // li


									   } //div content

									   $key++;				

									} // li accordrion

									} // div main
									
									echo "<pre>";

									 // print_r($data);
									echo "</pre>";

									if(!empty($data) && $team_control){

										$first = false;
										$first_10 = false;
										$fg_1 = false;
										$punt = false;
										$ca = 0;
										$ch = 0;
										$old_score_away = 0;
										$old_score_home = 0;
										$penalty = false;
										$timeout = false;
										$fum_control = false;
										$int_control = false;
										$td_control = false;
										$fg_control = false;
										$sf_control = false;
										foreach($data as $d){


											$team = $d['main'];


											if(!empty($yards_array)){
												$src['LONGEST_TD'] = max($yards_array);

											}

											if(!empty($yards_array_fg)){
												$src['LONGEST_FG'] = max($yards_array_fg);

											}

												 // $ca = 0;
												 // $ch = 0;												 
												 // checkin 3 Unanswered Scores
											if(!$src['3USRC_A']) { $src['3USRC_A'] = 0 ;}
											if(!$src['3USRC_H']) { $src['3USRC_H'] = 0 ;}



											if($d['away_score'] > $old_score_away && $d['home_score'] == $old_score_home ){
												if($s_team == "A"){ $ca++;} else {$ca = 0;}
												$s_team = "A";

												if($ca==2){ $src['3USRC_A'] = 1; }
											}
											if($d['home_score'] > $old_score_home && $d['away_score'] == $old_score_away ){
												if($s_team == "H"){ $ch++;} else {$ch =0;}
												$s_team = "H";

												if($ch==2){ $src['3USRC_H'] = 1; }
											}

											if($d['type'] == 'Fumble' && !$fum_control){
												$src['FUM']  = $team; 
												$src['FUM_T']  = trim($d['period'][0]."_".str_replace(":","",$d['time']));
												$fum_control = true;
											}	

											if($d['type'] == 'Interception' && !$int_control){
												$src['INT']  = $team; 
												$src['INT_T']  = trim($d['period'][0]."_".str_replace(":","",$d['time']));
												$int_control = true;
											}	

											if($d['type'] == 'Safety' && !$sf_control){
												$src['SF']  = $team; 
												$src['SF_T']  = trim($d['period'][0]."_".str_replace(":","",$d['time']));
												$sf_control = true;
											}	
											

											if($d['type'] == 'Field Goal'){

												if($d['period'] == '1st'){
													    $src['FG_1']  = 1;  // A FIELD GOAL FIRST TIME
													}
													if($team == 'A'){
														
														$src['TFGA'] =  $src['TFGA'] + 1;  // Total FG away
													} else {
														$src['TFGH'] =  $src['TFGH'] + 1;   // Total FG home
													}


													if(!$fg_control){
														$src['FG']  = $team; 
														$src['FG_T']  = trim($d['period'][0]."_".str_replace(":","",$d['time']));
														$fg_control = true;
													}

												}
												if( $d['type'] == 'Touchdown'){

													if($d['period'] == '1st'){
														$src['TD_1']  = 1;
													}
													if($team == 'A'){
														$src['TTDA'] =  $src['TTDA'] + 1;  // Total TD away
													} else {
														$src['TTDH'] =  $src['TTDH'] + 1;   // Total TD home
													}


													if(!$td_control){
														$src['TD']  = $team; 
														$src['TD_T']  = trim($d['period'][0]."_".str_replace(":","",$d['time']));
														$td_control = true;
													}
												}



												if($d['away_score'] != $old_score_away || $d['home_score'] != $old_score_home  ){
													$last_type = $d['type'];   
												}

												if($d['type'] == 'End of Half'){
													if($last_type == 'Field Goal'){
														  $src['LS1H_FG']  =1; // Last Score 1h is FG 
														}

													}

													if(!$timeout){

														if(isset($d['timeout'])){
															if(contains_ck($d['away'],$d['timeout'])){
															  $src['TOUTA'] = 1;  $src['TOUTH'] = 0;  // First time Out
															  $timeout = true;
															}   
 														  if(contains_ck($d['home'],$d['timeout'])){ // First time Out
 														  	$src['TOUTH'] = 1;  $src['TOUTA'] = 0;
 														  	$timeout = true;
 														  }    


 														}


 													}



 													if(isset($d['penalty'])){
 														if(contains_ck($d['away'],$d['penalty'])){

 															if(!$penalty){
 																$src['PENA'] = 1;  $src['PENH'] = 0;
 																$penalty = true;
 															}
 															$src['TPENA'] = $src['TPENA'] + 1; 

 														}   
 														if(contains_ck($d['home'],$d['timeout'])){

 															if(!$penalty){
 																$src['PENH'] = 1;  $src['PENA'] = 0;
 																$penalty = true;
 															}
 															$src['TPENH'] = $src['TPENH'] + 1; 
 														}    


 													}




 													$old_score_away = $d['away_score'];
 													$old_score_home = $d['home_score'];

 													if(!$first){
 										            if($d['away_score'] > 0) { $first = true; $src["FA"] = 1; $src["FH"] = 0;}  // Score  First  
 										            if($d['home_score'] > 0) { $first = true; $src["FH"] = 1; $src["FA"] = 0;}   
									                // ACA NECESITO RESTAR/SUMAR A 15 el tiempo q lleva TIME
 										            $check = "3:30";
 										            if(strtotime($d['time']) <= strtotime($check) && ($d['away_score'] > 0 || $d['home_score'] > 0)){
 										            	print_r($d);
 										            	$src['330'] = 1;											 
 										            }
 										            $check = "5:30";
 										            if(strtotime($d['time']) <= strtotime($check) && ($d['away_score'] > 0 || $d['home_score'] > 0)){
 										            	print_r($d);
 										            	$src['530'] = 1;											 
 										            }
 										            $check = "6:00";
 										            if(strtotime($d['time']) <= strtotime($check) && ($d['away_score'] > 0 || $d['home_score'] > 0)){
 										            	$src['600'] = 1;											 
 										            }
 										            $check = "6:30";
 										            if(strtotime($d['time']) <= strtotime($check) && ($d['away_score'] > 0 || $d['home_score'] > 0)){
 										            	$src['630'] = 1;											 
 										            }
 										            $check = "7:00";
 										            if(strtotime($d['time']) <= strtotime($check)&& ($d['away_score'] > 0 || $d['home_score'] > 0)){
 										            	$src['700'] = 1;											 
 										            }
 										            $check = "7:30";
 										            if(strtotime($d['time']) <= strtotime($check) && ($d['away_score'] > 0 || $d['home_score'] > 0)){
 										            	$src['730'] = 1;											 
 										            }

 										        }
 										        if(!$first_10){
 										        	if($d['away_score'] >= 10) { $first_10 = true; $src["FA_10"] = 1; $src["FH_10"] = 0;}   
										            if($d['home_score'] >= 10) { $first_10 = true; $src["FH_10"] = 1; $src["FA_10"] = 0;}   //first score 10 pts
										        }

										        if($d['type'] == "Punt"){

										        	if(!$punt){
										        		if($team == 'A'){
										        			$src['PFA'] = 1;  $src['PFH'] = 0;
										        		} else{
										        			$src['PFA'] = 0;  $src['PFH'] = 1;  
										        		}
														$punt = true; // Punt First
													}
 													 $src['PL'] = $team;  // Punt Last

 													 if($team == 'A'){
														$src['TPA'] =  $src['TPA'] + 1;  // Total Punts away
													} else {
														$src['TPH'] =  $src['TPH'] + 1;   // Total Punts home
													}

												}

												    // Last Team Score
												if($d['type'] == "Field Goal" || $d['type'] == "Touchdown" ||  $d['type'] == "Safety"){
													$src['LAST_TEAM'] = $d['main'];
												}	
												  // First Team Score
												if(!isset( $src['FIRST_TEAM'])){
													if($d['type'] == "Field Goal" || $d['type'] == "Touchdown" ||  $d['type'] == "Safety"){
														$src['FIRST_TEAM'] = $d['main'];
													}	
												}


											}

											//Checking FUMBLE VS INT - 1st Turnover will be
											if (isset($src['FUM']) && !isset($src['INT'])){
												$src['FUM_VS_INT'] = $src['FUM'];
											}
											if (!isset($src['FUM']) && isset($src['INT'])){
												$src['FUM_VS_INT'] = $src['INT']; 
											}
											if (!isset($src['FUM']) && !isset($src['INT'])){
												$src['FUM_VS_INT'] = 0; 
											}
											if (isset($src['FUM']) &&  isset($src['INT'])){
												$fum = explode("_",$src['FUM_T']);
												$int = explode("_",$src['INT_T']);

												if ($fum[0] < $int[0]){
													$src['FUM_VS_INT'] = $src['FUM']; 
												}
												if ($fum[0] > $int[0]){
													$src['FUM_VS_INT'] = $src['INT']; 
												}
													if ($fum[0] == $int[0]){ // Mismo periodo
														if($fum[1] > $int[1]){
															$src['FUM_VS_INT'] = $src['INT'];
														} else {
															$src['FUM_VS_INT'] = $src['FUM'];
														}
													}

												}

											// 1ST SCORE WILL BE TD  VS FG OR SAFETY

												if (isset($src['TD']) && !isset($src['FG'])  && !isset($src['SF'])){
													$src['TD_VS_FG'] = $src['TD']; 
												}
												if (!isset($src['TD']) && isset($src['FG'])  && !isset($src['SF'])){
													$src['TD_VS_FG'] = $src['FG']; 
												}

												if (!isset($src['TD']) && !isset($src['FG'])  && isset($src['SF'])){
													$src['TD_VS_FG'] = $src['SF']; 
												}

												if (isset($src['TD']) &&  isset($src['FG']) && !isset($src['SF'])){
													$touc = explode("_",$src['TD_T']);
													$fieldgo = explode("_",$src['FG_T']);

													if ($touc[0] < $fieldgo[0]){
														$src['TD_VS_FG'] = $src['TD'];  
													}
													if ($touc[0] > $fieldgo[0]){
														$src['TD_VS_FG'] = $src['FG'];  
													}
													if ($touc[0] == $fieldgo[0]){ // Mismo periodo
														if($touc[1] > $fieldgo[1]){
															$src['TD_VS_FG'] = $src['FG']; 
														} else {
															$src['TD_VS_FG'] = $src['TD']; 
														}
													}

												}		

											if (isset($src['TD']) &&  !isset($src['FG']) && isset($src['SF'])){ // SAFETY
												$touc = explode("_",$src['TD_T']);
												$fieldgo = explode("_",$src['SF_T']); 

												if ($touc[0] < $fieldgo[0]){
													$src['TD_VS_FG'] = $src['TD']; 
												}
												if ($touc[0] > $fieldgo[0]){
													$src['TD_VS_FG'] = $src['SF']; 
												}
													if ($touc[0] == $fieldgo[0]){ // Mismo periodo
														if($touc[1] > $fieldgo[1]){
															$src['TD_VS_FG'] = $src['SF']; 
														} else {
															$src['TD_VS_FG'] = $src['TD']; 
														}
													}

												}	




												if(!empty($src) && $team_control){

													foreach($src as $key => $sc){
										  // echo $key . ":" . $sc . "<br>";
														$game_log = new _game_log();
														$game_log->vars["league"] = $league;
														$game_log->vars["player_espn_id"] = "000";
														$game_log->vars["espn_game"] = $game_id;
														$game_log->vars["field"] = $key;
														$game_log->vars["value"] = $sc;			  
														$game_log->insert();
														$result = true;
													}	

												}

											}

							} // empty scores
							

							echo "<pre>";
							print_r($src);
							echo "</pre>";


						//exit;  
							break;


							case "nhl":

							$link = "http://www.espn.com/nhl/playbyplay?gameId=";

							$i=0; 
							echo $link.$game_id."   ";
							$html = file_get_html($link.$game_id);
							$valid = false;
							
							$n=0;
							$over=false;
							$score = array();
							echo "<BR>";	
							foreach ($html->find('div[class="line-score-container"]') as $div){ // Div 

							  foreach($div->find("table tr") as $tr) { // tr
							  	$j=0;
							  	if($n==0){
							  		if (contains_ck($tr->plaintext,"OT")){ $over = true; }
							  	}
								  foreach ($tr->find("td") as $td){  //td
								  	if($n==1){
								  		if($j==1) { $score["1PA"] = $td->plaintext; }  
								  		if($j==2) { $score["2PA"] = $td->plaintext; }  									 
								  		if($j==3) { $score["3PA"] = $td->plaintext; }  									 									 
								  		if($j==4) { 
								  			if($over) { $score["OTA"] = $td->plaintext; }  
								  			else {  $score["TA"] = $td->plaintext;  }									 										 
								  		} 
								  		if($j==5) { $score["TA"] = $td->plaintext; }   

								  	} 
								  	if($n==2){
								  		if($j==1) { $score["1PH"] = $td->plaintext; }  
								  		if($j==2) { $score["2PH"] = $td->plaintext; }  									 
								  		if($j==3) { $score["3PH"] = $td->plaintext; }  									 									 
								  		if($j==4) {
								  			if($over) { $score["OTH"] = $td->plaintext; }
								  			else {  $score["TH"] = $td->plaintext;  }  									 										 
								  		}
								  		if($j==5) { $score["TH"] = $td->plaintext; }     

								  	} 

								  	$j++;
								  }
								  $n++;
								  if($n==3){break;} 
								}

							}
							if(!empty($score)){

								foreach($score as $key => $sc){
								 //  echo $key . ":" . $sc . "<br>";
									$game_log = new _game_log();
									$game_log->vars["league"] = $league;
									$game_log->vars["player_espn_id"] = "000";
									$game_log->vars["espn_game"] = $game_id;
									$game_log->vars["field"] = $key;
									$game_log->vars["value"] = $sc;			  
									$game_log->insert();
									
								}	
								

							}
							
							echo "<pre>";
							print_r($score)	;
							echo "</pre>";		

							$link = "http://www.espn.com/nhl/boxscore?gameId=";

							$i=0; 
							echo $link.$game_id."   ";
							$html = file_get_html($link.$game_id);
							
							$first = false;
							$first_10 = false;
							$src = array();											
							echo "<BR>";
							
							foreach ($html->find('div[class="mod-container mod-no-header-footer mod-open mod-open-gamepack mod-box"]') as $div){ // Div 


								$min_control = 0;
							   foreach($div->find("table tr") as $tr) { // tr


								 // echo $tr->plaintext."<BR>";
								  if(contains_ck($tr->plaintext,"2nd")){ $min_control = 15;} // to control the 10 min of the game 
								  if(contains_ck($tr->plaintext,"Summary")){ $valid = false;} 
								  if(contains_ck($tr->plaintext,"Penalty")){ $valid = false;}
								  if(contains_ck($tr->plaintext,"Scoring")){ $valid = true;}								  

								  if($valid){ 
								  	$n=0;
								  foreach ($tr->find("td") as $td){  //td
								    //echo $n." ) ".$td->plaintext." - ";
								  	if($n==0){
								  		$time = explode(":",$td->plaintext);
								  		$min = $time[0];
								  		$min = $min_control + $min;
								  	}
								  	if($n==3){
								  		$away =  trim($td->plaintext); 

								  	}
								  	if($n==4){

								  		$home = trim($td->plaintext); 

								  	}
									  //checking
								  	if($n>=4){
								  		if(!$first) {
								  			if($away > $home) { $src["FA"] = 1; $src["FH"] = 0;}  
								  			if($away < $home) { $src["FA"] = 0; $src["FH"] = 1;}  										 
								  			$first = true;  
								  		}
								  		if(!$first_10) {
								  			if($min < 10){
								  				if($away > $home) { $src["FA_10"] = 1; $src["FH_10"] = 0;}  
								  				if($away < $home) { $src["FA_10"] = 0; $src["FH_10"] = 1;}  										 
								  				$first_10 = true;  
								  			} else { $src["FA_10"] = 0; $src["FH_10"] =0;$first_10 = true; break; }
								  		}
								  	}
								  	$n++; 
								  } //ted
								//  echo "<BR>";	  
								}
							  } //tr
						  } //div
						  
						  
						  if(!empty($src)){

						  	foreach($src as $key => $sc){
							  // echo $key . ":" . $sc . "<br>";
						  		$game_log = new _game_log();
						  		$game_log->vars["league"] = $league;
						  		$game_log->vars["player_espn_id"] = "000";
						  		$game_log->vars["espn_game"] = $game_id;
						  		$game_log->vars["field"] = $key;
						  		$game_log->vars["value"] = $sc;			  
						  		$game_log->insert();
						  		$result = true;
						  	}	

						  }
						  print_r($src);
						  
						  break;

						  case "mlb":

						  $link = "https://www.espn.com/mlb/playbyplay/_/gameId/";
				 //$link = "https://www.espn.com/mlb/boxscore/_/gameId/";

						  $i=0; 
				   // $game_id = 380628104;
						  echo $link.$game_id."   ";
						  $html = file_get_html($link.$game_id);
						  $valid = false;

						  $n=0;
						  $over=false;
						  $score = array();
						  $exit = false;
						  $k = 0 ;
						  $j = 0;
						  $l = 0; 


							foreach ($html->find('div[class="Table__Scroller"]') as $div){ // Div 

								$pos=0;
							   foreach($div->find("tr[class='Table__TR Table__even']") as $tr) { // 

							  // 	echo "*********************************************************" ;

							   	foreach ($tr->find("th[class='Table__TH']") as $th){ 

							   		foreach ($th->find("span") as $header) {

							   			if(trim($header->plaintext) == 'R'){  $exit = true;  }
							   			if(!$exit){
							   	      $pos++;	# code...
							   	  }
							   	}
							   	  } //tr
							   	  break;
							   	}	

							   	$exit = false;

							foreach($div->find("tr[class='Table__TR Table__TR--sm Table__even']") as $tr) { // 

								//echo "<BR>".$k."+".$j."+".$n."///".$tr->plaintext."<BR>";

								if(!$exit){

								  foreach ($tr->find("td") as $td){  //td
								  	if($j >= $pos){
								  		//echo "ENTRRRR(".$j."**".$n;
								  		if($n==0){

								  			if($j == $pos){	 
								  				$score['R_A'] = $td->plaintext; 
								  			}

								  			if($j == $pos + 1){	 
								  				$score['H_A'] = $td->plaintext; 
								  			}
								  			if($j == $pos + 2){	 
								  				$score['E_A'] = $td->plaintext; 
								  				$j = 0; break;
								  			}

								  		}


								  		if($n==1){

								  			if($j == $pos){	 
								  				$score['R_H'] = $td->plaintext; 
								  			}

								  			if($j == $pos + 1){	 
								  				$score['H_H'] = $td->plaintext; 
								  			}
								  			if($j == $pos + 2){	 
								  				$score['E_H'] = $td->plaintext; 
								  				$exit = true; break;
								  			}

								  		}

									} //
									
									$j++;
								}

								if($exit){ break; }

								$n++;
								if($n==3){ $n =0; break;} 
							}	
							$k++; 
							

						}


						if($k>1){break;}  
					}



					if(!empty($score)){

						foreach($score as $key => $sc){
								   //echo $key . ":" . $sc . "<br>";
							$game_log = new _game_log();
							$game_log->vars["league"] = $league;
							$game_log->vars["player_espn_id"] = "000";
							$game_log->vars["espn_game"] = $game_id;
							$game_log->vars["field"] = $key;
							$game_log->vars["value"] = $sc;			  
							$game_log->insert();

						}	
						echo " SCORES INSERTED ";

					}

					echo "<pre>";
					print_r($score)	;
					echo "</pre>";		


						 $found = false;

						 foreach ($html->find('ul[class="PlayList"]') as $ul){ // Div 

						 	
							  foreach ($ul->find('li') as $li){ // li 

							   
							   foreach ($li->find('div[class="PlayHeader__score PlayHeader__score--away"]') as $div1){ // Div 

							   	$value_away = trim($div1->plaintext);

							   	if(is_numeric($value_away	)){ 
							   		//echo $value_away."--";
							   	}

							   	if(!$found){
							   		if($value_away > 0) { $src["FA"] = 1; $src["FH"]= 0 ; $found = true;  } 
							   	}

							   

							   } //div
 							
							   foreach ($li->find('div[class="PlayHeader__score PlayHeader__score--home"]') as $div2){ // Div 

								$value_home = trim($div2->plaintext);

						 		if(is_numeric($value_home)){ 
									//echo $value_home."/<BR>";
								}

								  if(!$found){
							   		if($value_home > 0) { $src["FH"] = 1; $src["FA"]= 0 ; $found = true;} 
							   	   }
  							    }  
                                  
                             if($l < 6) {
							  foreach ($li->find('div[class="PlayListFooter"]') as $footer){ // Div 

							  	foreach ($footer->find('span') as $span){ // Div 
                                     $value = explode(" ",$span->plaintext);
 									 if ($l==0) { $src["1_RA"] = $value[0]; }
 									 if ($l==1) { $src["1_HA"] = $value[0]; }
 									 if ($l==2) { $src["1_EA"] = $value[0]; }
 									 if ($l==3) { $src["1_RH"] = $value[0]; }
 									 if ($l==4) { $src["1_HH"] = $value[0]; }
 									 if ($l==05) { $src["1_EH"] = $value[0]; }
                                      $src["1_TOTAL"] = $src["1_TOTAL"] + $value[0];
                                     //print_r($value);	
                                   // echo $l.") ".$span->plaintext."<BR>";
								 $l++;
  							   }  

  							  }
  						    }// else { break;}

				    } //div

				  } //li


						 // } //div
						  
						  	 //  print_r($src); exit;
						  if(!empty($src)){
    
						  	foreach($src as $key => $sc){
						  		
							   //echo $key . ":" . $sc . "-----<br>";
						  		$game_log = new _game_log();
						  		$game_log->vars["league"] = $league;
						  		$game_log->vars["player_espn_id"] = "000";
						  		$game_log->vars["espn_game"] = $game_id;
						  		$game_log->vars["field"] = $key;
						  		$game_log->vars["value"] = $sc;			  
						  		$game_log->insert();
						  		$result = true;
						  	}	

						  }
						  print_r($src);echo "<BR>";
						  
						  break;		




		} //switch
		

		return $result;
	}


	function array_all_lleters($letter){
		$letters = array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','Ñ','O','P','Q','R','S','T','U','V','W','X','Y','Z');
		if(in_array($letter,$letters)){
			return true;
		}
		return false;

	}	

	?>
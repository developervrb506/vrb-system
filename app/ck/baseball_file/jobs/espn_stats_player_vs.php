<?
require_once(ROOT_PATH . "/ck/db/handler.php"); 
require_once(ROOT_PATH . '/includes/html_dom_parser.php'); 
//require_once(ROOT_PATH . '/ck/baseball_file/process/functions.php');
  set_time_limit(0);  
echo "-------------------------<BR>";
echo "      STATS PLAYERS VS <br>";
echo "--------------------------<BR>";
 
 $today = date("Y-m-d");
 //$today = "2015-04-17";
 
$type= param("type");

$players = get_players_by_date($today,$type);
//$home = get_players_by_date($today,"home");
//$players = array_merge($away,$home);



 
 foreach ($players as $play){
	 
  $player = $play->vars["espn_player"];	 
  // $player = $play;	 
   $new_pls = false; $new_plb = false;
   
  
   
  $data_1 = player_stats_espn_data($player);
  $data_2 = player_batter_vs_pitcher($player);
  $data = array_merge($data_1,$data_2);
 
  
  $data["player"] = $player;
   echo "<pre>";
   print_r($data);
   echo "</pre>";
   
   	
	 //Stats
	 if (count($data["stats"]) > 0 ){
		 
	     foreach ($data["stats"] as $stats ){
	    			 
	        $player_stats = get_baseball_espn_player_year_data($player,$stats["year"]);
		 
		    if(is_null($player_stats)) { $new_pls = true;  $player_stats = new _baseball_espn_player_year_data();}
			 				 					 
                        
			if($new_pls){	
			  $player_stats->vars["espn_player"] = $player;
			  $player_stats->vars["year"] = $stats["year"];
			  $player_stats->vars["stats_ip"] = $stats["ip"];
			  $player_stats->insert();
			}
			else {
				if ($stats["year"] == date("Y")){ // Just update the actual Year
				   $player_stats->vars["stats_ip"] = $stats["ip"];
				   $player_stats->update(array("stats_ip"));
				 }
			}
					 
		 }
		 
	 } // count
   
	// Pitcher vs Batter
	
	if (count($data["espn_player"]) > 0 ){
		 
	     foreach ($data["espn_player"] as $player2 ){
	    			 
	        $pitcher_batter = get_baseball_espn_pitcher_batter($player,$player2["player"]);
		 
		    if(is_null($pitcher_batter)) { $new_plb = true;  $pitcher_batter = new _baseball_espn_pitcher_batter();}
			 				 					 
                if($player2["player"] != 0){
				  $player_obj = get_baseball_player_by_id("espn_player",$player2["player"]);
				  if (!is_null($player_obj)){
					  $player_obj->vars["espn_team"] = $data["team"];
					   $player_obj->update(array("espn_team")); // to mantain the rigth team for batter
					  }
				  
				}
			  $pitcher_batter->vars["espn_player1"] = $player;
			  $pitcher_batter->vars["espn_player2"] = $player2["player"];
			  $pitcher_batter->vars["espn_team"] = $data["team"]; 
			  $pitcher_batter->vars["type_vs"] = $data["type"]; 
			  $pitcher_batter->vars["ab"] = $player2["AB"];
			  $pitcher_batter->vars["h"] = $player2["H"];	
			  $pitcher_batter->vars["2b"] = $player2["2B"];	
			  $pitcher_batter->vars["3b"] = $player2["3B"];			  		  		  
			  $pitcher_batter->vars["hr"] = $player2["HR"];	
			  $pitcher_batter->vars["rbi"] = $player2["RBI"];			  		  
			  $pitcher_batter->vars["bb"] = $player2["BB"];
			  $pitcher_batter->vars["so"] = $player2["SO"];	
			  $pitcher_batter->vars["avg"] = $player2["AVG"];	
			  $pitcher_batter->vars["obp"] = $player2["OBP"];			  		  		  
			  $pitcher_batter->vars["slg"] = $player2["SLG"];	
			  $pitcher_batter->vars["ops"] = $player2["OPS"];	
				        
			if($new_plb){	
			 
			  $pitcher_batter->insert();
			}
			else {
				
			   $pitcher_batter->update();
				
			}
					 
		 }
		 
	 } // count
	
	
		 
 
 //break;
 }

 function player_batter_vs_pitcher($player) {  
   $html = file_get_html("http://espn.go.com/mlb/player/batvspitch/_/id/".$player); 
   $data = array();
   $year = date("Y");
   foreach($html->find('select') as $select){
      foreach($select->find('option') as $option){
		  if (isset($option->selected)){
		    echo $option->value."<BR>"; 
			$team =  explode("/",str_center('teamId/','/',$option->value));
			$data["team"] = $team[0];
		  }
	  }
	 break;
   }// table
   foreach($html->find('table[class="tablehead"]') as $table){
     $j=0;
	 $player2= false;
	 foreach($table->find('tr') as $tr) {
         
		 if($player2){
			 $x =0; 
			 $pl = false; // To handle Player = 0, means that is the Total Line.
			foreach($tr->find('td') as $td) {
			  //echo $td->plaintext."<BR>";	
			  if ($x == 0){
				  $str_name = str_replace(" ","-",$td->plaintext);
				   foreach ($td->find('a') as $a){
					 //echo $a->href."<BR>";  
					 $player_id =  explode("/",str_center('/id/','/'.$str_name,$a->href));
			          $data["espn_player"][$j]["player"] = $player_id[0]; 
					  $pl = true;  
				   }
				   if(!$pl){ $data["espn_player"][$j]["player"] = 0; }
				   
				  
			  }
			  if ($x == 1){  $data["espn_player"][$j]["AB"] = $td->plaintext;   }
			  if ($x == 2){  $data["espn_player"][$j]["H"] = $td->plaintext;   }
 			  if ($x == 3){  $data["espn_player"][$j]["2B"] = $td->plaintext;   }
			  if ($x == 4){  $data["espn_player"][$j]["3B"] = $td->plaintext;   }
			  if ($x == 5){  $data["espn_player"][$j]["HR"] = $td->plaintext;   }	
			  if ($x == 6){  $data["espn_player"][$j]["RBI"] = $td->plaintext;   }
			  if ($x == 7){  $data["espn_player"][$j]["BB"] = $td->plaintext;   }	
			  if ($x == 8){  $data["espn_player"][$j]["SO"] = $td->plaintext;   }
			  if ($x == 9){  $data["espn_player"][$j]["AVG"] = $td->plaintext;   }
			  if ($x == 10){  $data["espn_player"][$j]["OBP"] = $td->plaintext;   }	  
			  if ($x == 11){  $data["espn_player"][$j]["SLG"] = $td->plaintext;   } 
			  if ($x == 12){  $data["espn_player"][$j]["OPS"] = $td->plaintext; $j++;  }
			  
			  
			 $x++; 
			}
			 
			 
		 }
		 
		 
		 if (contains_ck($tr->plaintext,"3B") ){ 
		    
			 
			 foreach($tr->find('td') as $td) {
			  $data["type"] = $td->plaintext;		  
			  break;
			 }
		  
		  $player2 = true;
		 }
		 
	   
	
	 }
   
   }
   
 return($data);  
 }


//This function is to get only the Day,nigth and Actual Era month
 function player_stats_espn_data($player) {  
   $html = file_get_html("http://espn.go.com/mlb/player/stats/_/id/".$player); 
   $data = array();
   $year = date("Y");
   foreach($html->find('table[class="tablehead"]') as $table){
     
	   $season = false;
	   $j = 0;
	    foreach($table->find('tr') as $tr) { 
       
	   
	   if (contains_ck($tr->plaintext,"Season Averages") ){ // To end the cicle no more info is needed
		   $season  = false;  
			break;
		}
	   
	    if($season ){ // boolean to handle first table Season
	      
		    $x =0; 
			foreach($tr->find('td') as $td) {
              
			  if(($x==0) && ($td->plaintext == "Total") ) { $pass = false; break;}
			  
			  
			  //to control the stats 3 year or less ago.
			  if ($td->plaintext == $year - 3) { $pass = true;}
			  if((!$pass) && ($td->plaintext == $year - 2)){ $pass = true;}
			  if((!$pass) && ($td->plaintext == $year - 1)){ $pass = true;}
			  if((!$pass) && ($td->plaintext == $year )){ $pass = true;}
			  
			  
			  
			    if ($pass){
			       if (($x==0) && ($str != $td->plaintext) && ($str)){ // To group by year
					    $j++; 
					}
				    if ($x==0){ $data["stats"][$j]["year"] = $td->plaintext; $str = $td->plaintext; }
			        if ($x==6){ $data["stats"][$j]["ip"] = $td->plaintext; 	}
			    } //pass
			    $x++;
			  
	         } //td
		  
		}//season
	   
	    if (contains_ck($tr->plaintext,"SEASON") ){
		    $season  = true; 
			$first = false; 
		 }
	
      }  //tr
	  break;
 }// table
   
 return($data);  
 }





?>
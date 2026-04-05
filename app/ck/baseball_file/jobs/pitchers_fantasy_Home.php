<?
require_once(ROOT_PATH . "/ck/db/handler.php"); 
require_once(ROOT_PATH . '/includes/html_dom_parser.php'); 
//require_once(ROOT_PATH . '/ck/baseball_file/process/functions.php');
  set_time_limit(0);  
echo "-------------------------<BR>";
echo "      PITCHERS FANTASY ESPN <br>";
echo "--------------------------<BR>";
 
 $today = date("Y-m-d");
// $today = "2015-04-16";
echo $today."<BR>";


$type = "home";

$players = get_players_by_date_pending_update($today,$type,'fantasy');



if(count($players) > 0) {

 foreach ($players as $play){
	 
  $player = $play->vars["espn_player"];	 
 

  // $player = $play;	 
   echo $play->vars["player"]."  -- Updated <BR>"; 
   
   $new = false; $new_pls = false;	
   $pl = get_baseball_espn_player_data($player);	
   if (is_null($pl)){ $new = true; }
   
  $data_1 = fantasy_espn_data($player);
  $data_2 = player_split_espn_date($player);
 
  $data = array_merge($data_1,$data_2);
  $data["player"] = $player;
  
 
   if ($new){
	  $pl = new _baseball_espn_player_data();
   }   
 
	  $pl->vars["espn_player"] = $player;
	  $pl->vars["actual_team"] = $data["team"];
	  $pl->vars["birth_date"] = $data["birth_date"];
	  $pl->vars["birth_place"] = $data["birth_place"];
	  $pl->vars["experience"] = $data["experience"];
	  $pl->vars["college"] = $data["college"];
	  $pl->vars["heigth_weigth"] = $data["heigth_weigth"];
	  
	  $pl->vars["avg_draf"] = $data["avgDraf"];
	  $pl->vars["perc_own"] = $data["percOwn"];
	  $pl->vars["rate_actual_season"] = $data["plRateSeason"]; 
	  $pl->vars["rate_7"] = $data["plRate7"];  
	  $pl->vars["rate_15"] = $data["plRate15"];
	  $pl->vars["rate_30"] = $data["plRate30"];
	  $pl->vars["espn_rank"] = $data["rank"];
	  $pl->vars["news"] = $data["news"];
	  $pl->vars["spin"] = $data["spin"];
	  $pl->vars["projection"] = $data["projection"];
	  
	  $pl->vars["day_splits"] = $data["day_splits"];
	  $pl->vars["nigth_splits"] = $data["nigth_splits"];
	  $pl->vars["month_era_splits"] = $data["month_era_splits"];
  
  if ($new){
	  $pl->insert();
	  
   }
   else{
	  $pl->update(array("actual_team","birth_date","experience","heigth_weigth","avg_draf","perc_own","rate_actual_season","rate_7","rate_15","rate_30","espn_rank","news","spin","projection","day_splits","nigth_splits","month_era_splits")); 
	}
  
     	 if (count($data["by_stadium"]) > 0 ){
		 
	
	     foreach ($data["by_stadium"] as $stadium ){
		
		     $name = $stadium["stadium"];
			 
			  switch($name){ // Matching some names with the espn_name from stadium table
				
				case "Busch Stadium II": 
				   $name = "Busch Stadium";
				   break; 
				case "Camden Yards": 
				   $name = "Oriole Park";
				   break;   
			    case "Camden Yards": 
				   $name = "Oriole Park";
				   break; 
			    case "Overstock.com Coliseum": 
				   $name = "O.co Coliseum";
				   break;
			  }
			 
			   $stadium_obj = get_baseball_stadium_by_name($name,"id,espn_name");

			   if (is_null($stadium_obj)){ echo "CHECK THE STADIUM ".strtoupper($name)."<BR>";}
			   else {
				   // echo "<pre>";
					//print_r($stadium_obj);
					//echo "</pre>";
				    $player_stadium = get_baseball_espn_player_stadium($player,$stadium_obj->vars["id"]);
				   
				     if(is_null($player_stadium)) { $new_pls = true;  $player_stadium = new _baseball_espn_player_stadium();}
					 
						 $player_stadium->vars["splits_era"] = $stadium["era"];
						 $player_stadium->vars["splits_ip"] = $stadium["ip"];
						 $player_stadium->vars["splits_avg"] = $stadium["avg"];					 					 
                        
					if($new_pls){	
					  $player_stadium->vars["espn_player"] = $player;
					  $player_stadium->vars["id_stadium"] = $stadium_obj->vars["id"];
					  $player_stadium->insert();
					}
					else {
						$player_stadium->update(array("splits_era","splits_ip","splits_avg"));
					}
					 
					 
					 
					 
				   
				   
				   }
		
			 
		 }
		 
	
		 
	 }
	 
	 //Add Player Updated
	
	  $player_update = new _player_updated();
	  $player_update->vars["player"]= $play->vars["fangraphs_player"];
 	  $player_update->vars["type"]= 'fantasy';
	  $player_update->vars["date"]= date("Y-m-d");
	  $player_update->insert();
	  
	 
 

//break;
 }
 
} else { echo "All Players were Updated"; }
 
 
 

  
function fantasy_espn_data($player){ 

  $html = file_get_html("http://espn.go.com/mlb/player/_/id/".$player); 
  $data = array();
  
   $next = false; $end = false;
   foreach($html->find("ul") as $ul) {    
      
	 // echo "---";
	  foreach ($ul->find("li") as $li ){
		
  		  if (contains_ck($li->plaintext,"Player Profile")){ $end = true; break ;}
		 
		  if ($next){
			 $k++;
			if ($k == 1){	 $data["team"] = clean_str_ck($li->plaintext); }
			 if ($k == 2){	 $data["birth_date"] = str_replace("Birth Date","",$li->plaintext); }
   		     if ($k == 3){	 $data["birth_place"] = clean_str_ck(str_replace("Birthplace","",$li->plaintext)); }
		     if ($k == 4){	 $data["experience"] = str_replace("Experience","",$li->plaintext); }
		     if ($k == 5){	 $data["college"] = clean_str_ck(str_replace("College","",$li->plaintext)); }			 
		     if ($k == 6){	 $data["heigth_weigth"] = str_replace("Ht/Wt","",$li->plaintext); }	
		     
			 $next = true;  
		    // echo $li->plaintext."<BR>";	  
			
			
			
			
		  }
		    
		  
		  if (contains_ck($li->plaintext,"Throws:")){
			   $k = 0;
			   $next = true;}

		  
		
		}
		if ($end){ break;}
	  
   }
  
  
  
 
   foreach($html->find('div[id="fantasy-container"]') as $element) {    
    
	  
	  
	   if (contains_ck($element->plaintext,'averageDraftPosition":')) { 
		 $avgDraf = str_center('averageDraftPosition":',',"percentOwned":',$element->plaintext);
	   } else { $avgDraf = "";}
	  
	     
	
	   if (contains_ck($element->plaintext,',"spin":')) { 
	     		$spin = str_center(',"spin":"','","date":"',$element->plaintext);
	   } else { $spin  = "";} 
	   
	  
	    if (contains_ck($element->plaintext,'"playerRate')) { 
			if (contains_ck($element->plaintext,'"playerRaterSEASON":')) { 
			 $plRateSeason = str_center('"playerRaterSEASON":',',"playerRater7DAY":',$element->plaintext);
		   } else { $plRateSeason  = "";} 
		   
			if (contains_ck($element->plaintext,'"playerRater30DAY"')) { 
					$plRate30 = str_center('"playerRater30DAY":',',"playerRater15DAY":',$element->plaintext);
		   } else { $plRate30  = "";} 
		   if (contains_ck($element->plaintext,',"playerRater15DAY":')) { 
					$plRate15 = str_center(',"playerRater15DAY":',',"positionRank"',$element->plaintext);
		   } else { $plRate15  = "";} 
		   
		  
		   // if does not have 15 and 7 days rate
		   if (!contains_ck($element->plaintext,'"playerRater7DAY":')) { 
			 $plRateSeason = str_center('"playerRaterSEASON":',',"mostRecentNews":',$element->plaintext);
		   }
			if (!contains_ck($element->plaintext,'"playerRater15DAY"')) { 
				$plRate30 = str_center('"playerRater30DAY":',',"positionRank":',$element->plaintext);
		   }
		}
	    
	  
	   
	    if (contains_ck($element->plaintext,'"outlook":"')) { 
	     		$projection = str_center('"outlook":"','","seasonId":',$element->plaintext);
	   } else { $projection  = "";} 
	   
	   
	   if (contains_ck($element->plaintext,',"positionRank"')) { 
	     		$rank = str_center(',"positionRank":','} ',$element->plaintext);
				$rank = str_replace("}","",$rank);
	   } else { $rank  = "";} 
	 
	  if ($plRateSeason != "") {
		  if (contains_ck($element->plaintext,'"percentOwned":')) { 
			 $percOwn = str_center('"percentOwned":',',"playerRaterSEASON"',$element->plaintext);
		   } else { $percOwn = "";}
	  }
	  
	  
	  
	  
	  if (contains_ck($element->plaintext,'"news":')) { 
        $news = str_center('"news":"','","',$element->plaintext);
	  
			 if (contains_ck($element->plaintext,'"playerRater7DAY":')) { 
			   $plRate7 = str_center('"playerRater7DAY":',',"mostRecentNews":',$element->plaintext);
			 } else { $plRate7 = "";}
	        
			 if ($plRateSeason == "") {
	            if (contains_ck($element->plaintext,'"percentOwned":')) { 
					 $percOwn = str_center('"percentOwned":',',"mostRecentNews":',$element->plaintext);
		   			} else { $percOwn = "";}
			 }
			 
			 $date = str_center(',"date":"','"},"fullName"',$element->plaintext);
	         $news .= " ".$date;
	 
	  } else { $news = "";
	  
	         if (contains_ck($element->plaintext,'"playerRater7DAY":')) { 
			   $plRate7 = str_center('"playerRater7DAY":',',"fullName":',$element->plaintext);
			 } else { $plRate7 = "";}
	  
	         if ($plRateSeason == "") {
	            if (contains_ck($element->plaintext,'"percentOwned":')) { 
					 $percOwn = str_center('"percentOwned":',',"fullName":',$element->plaintext);
		   			} else { $percOwn = "";}
			 }
	  }
	 
	 
	
	 $data["avgDraf"] = $avgDraf;
     $data["percOwn"] = $percOwn; 
	 $data["plRateSeason"]= $plRateSeason; 
	 $data["plRate7"]= $plRate7; 
	 $data["plRate15"]= $plRate15; 
	 $data["plRate30"]= $plRate30; 
	 $data["rank"]= $rank; 	
	 $data["news"] = clean_str_ck($news);
	 $data["spin"]= clean_str_ck($spin);
	 $data["projection"] = clean_str_ck($projection);
	
    break;
	

  }
  
 return $data;
 } 


//This function is to get only the Day,nigth and Actual Era month
 function player_split_espn_date($player) {  
   $html = file_get_html("http://espn.go.com/mlb/player/splits/_/id/".$player."/type/pitching3/"); 
   $data = array();
  
   $table_main = $html->find('table[class="tablehead"]');
  
  if(!empty($table_main)){

    foreach($table_main as $table){
      $day = true;
	  $next_month = false;
	  $stadium = false;
	  $close = false;
	  $j = 0;
	   foreach($table->find('tr') as $tr) { 
    
	    if($day){ // boolean to handle the Day Word.
	      if (contains_ck($tr->plaintext,"Day") ){
		    $day = false;
		    $x =0; 
	        foreach($tr->find('td') as $td) {
              $data["day_splits"] = $td->plaintext;
			  $x++;
		     if ($x==2){   break; }
	        }
		  }
		}
	   //Nigth
	   if (contains_ck($tr->plaintext,"Night") ){
		  $x =0; 
	      foreach($tr->find('td') as $td) {
             $data["nigth_splits"] = $td->plaintext;
		   $x++;
		   if ($x==2){   break; }
	       }
	   }
	   // Month Era
	    if ($next_month ){ // this TR contains the Era needed, it is checked before check the tittle. to activate the $next_month
		   $x =0; 
	        $str ="";
			foreach($tr->find('td') as $td) {
            $str .= $td->plaintext." ";
		    
		   $x++;
		   if ($x==2){ 
		   		$data["month_era_splits"] = $str;
		        $next_month = false;
				break; }
	       }
		
		 }
	   
	   
	   //Month Era
	   if (contains_ck($tr->plaintext,"Day/Month") ){
		  $next_month = true; 
	    
	   }
	   
	    
		  
		 if ($stadium){
			 $x = 0; 
		    
	        foreach($tr->find('td') as $td) {
				if (contains_ck($td->plaintext,"By Count") ){
		          $stadium = false;
				  $close = true;
			       break; // End cicle, no more info is required
		        } 
				
               if ($x==0){ $data["by_stadium"][$j]["stadium"] = $td->plaintext;}
			   if ($x==1){ $data["by_stadium"][$j]["era"] = $td->plaintext;}
			   if ($x==9){ $data["by_stadium"][$j]["ip"] = $td->plaintext;}
			   if ($x==16){ $data["by_stadium"][$j]["avg"] = $td->plaintext; $j++;}
		       $x++;
	        } 
	        
		  }
		  
		  // Splits by Stadium
		  
	    if (contains_ck($tr->plaintext,"By Stadium") ){ // Active the Boolean $stadium to catch the next info.
		   $x =0; 
		   $stadium = true;
		 }
		  
		 if ($close) {
		    break; // End cicle, no more info is required
		 } 
	   
	   
	   
	   
      }  //tr
	  
	
 }// table
   
} // Empty table main
   
 return($data);  
 }





?>
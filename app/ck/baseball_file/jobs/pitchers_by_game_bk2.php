<? 
require_once(ROOT_PATH . "/ck/db/handler.php"); 
require_once(ROOT_PATH . '/includes/html_dom_parser.php'); 
require_once(ROOT_PATH . '/ck/baseball_file/process/functions.php');
  
set_time_limit(0);

// Find today games and Teams
echo "---------------<BR>";
echo "PITCHERS BY GAME<br>";
echo "---------------<BR><BR>";

$year= date("Y");
$old = false;
if (isset($_GET['old'])){ 
 $old = true;
}	


if (isset($_GET["gid"])){ 

$games = get_baseball_game($_GET["gid"],false);
}
else {
$date = date("Y-m-d");
if (isset($_GET['date'])){ 
 $date = $_GET['date'];
}	
$games = get_basic_baseball_games_by_date($date);	
}



//echo "<pre>";
//print_r($games);
//echo "</pre>";
//exit;
//$games = array();//delete
$i=1;
foreach ($games as $game ){

  if($game->vars["espn_game"] > 0) {
  if (date("Y-m-d H:i",strtotime($game->vars["startdate"])) < date("Y-m-d H:i")) { 
   
     echo date("Y-m-d H:i",strtotime($game->vars["startdate"])). "< ".date("Y-m-d H:i")." LISTO ";
    $link = "http://www.espn.com/mlb/boxscore?gameId=";
	$pr= false;
  }
  else{
	  echo date("Y-m-d H:i",strtotime($game->vars["startdate"])). "> ".date("Y-m-d H:i")."  ";
	   echo " PROBABLE ";
	 $link = "http://www.espn.com/mlb/game?gameId=";
     $pr = true;
	  }
	
	 echo "  - ".$link.$game->vars["espn_game"]."<BR>";
	//echo "OK OK";
	  $html = file_get_html($link.$game->vars["espn_game"]);  
	  
	
	if($pr){
	 
        
		$j=0;
		if(!empty($html)){

			
		 foreach($html->find('div[class="Pitchers__Row"]') as $elementa) { 
		  
		  //echo $elementa->plaintext."<BR>";
		   foreach($elementa->find('a') as $element) { 
	  
	      //echo $element->plaintext;
				if (contains_ck($element->href,"/mlb/player/_/id/")){
					// echo "<BR>".$j.")".$element->href."  ".$element->plaintext."<BR>";	  
					   if ($j==0) {
						   $pitcher_away = "**";
						    $pitcherid_away =  str_center("id","/",$element->href."/");	 
						    $pitcherid_away = str_replace("/","", $pitcherid_away);
							//$pitcherid_away =  str_center("/","/".$pitcher_away,$pitcherid_away);
						//	echo "-AWAY-- ".$pitcherid_away;
							$a = get_baseball_player_espn_nick($pitcherid_away);
								print_r($a);
					    	 if(!empty($a)){$pitcher_away  =  $a["espn_nick"];  $fansgraph_away = $a["fangraphs_player"];}
					   }
					   
					   if($j==1){
						$pitcher_home = "**";		
						// $pitcherid_home =  str_center("id","/",$element->href);	 
						 //$pitcherid_home =  str_center("/","/".$pitcher_home,$pitcherid_home);	 

						   $pitcherid_home =  str_center("id","/",$element->href."/");	 
						    $pitcherid_home = str_replace("/","", $pitcherid_home);
						 $h = get_baseball_player_espn_nick($pitcherid_home);
							print_r($h);
						 if(!empty($h)){$pitcher_home  =  $h["espn_nick"];  $fansgraph_home = $h["fangraphs_player"]; }
					  }
						
					  $j++; 
				 }
		    }
		   }
			  
	       }  
	       //   break;
		  
		  
		  
	   }  else{
		  // echo "aca";
		    $j=0; 
		  if(!empty($html)){
		   foreach($html->find('div[id="gamepackage-box-score"]') as $elementa) { 
		   
		     
			 foreach ($elementa->find("table tr") as $tr){
				  foreach ($tr->find("th") as $th){
					//  echo $th->plaintext." * ";
					  if($th->plaintext == "Pitchers" ){ $line = true;}
				  }
				
				 if($line){
					
				  foreach($tr->find("td") as $td){
				      foreach($td->find('a') as $element) { 
				      
				   if (contains_ck($element->href,"/mlb/player/_/id/")){
						//   echo $j.")".$element->href;
					   if ($j==0) {
						   $pitcher_away = "**";
							$pitcherid_away =  str_center("id","/",$element->href);	 
							$pitcherid_away =  str_center("/","/".$pitcher_away,$pitcherid_away);
							$a = get_baseball_player_espn_nick($pitcherid_away);
							 if(!empty($a)){$pitcher_away  =  $a["espn_nick"]; $fansgraph_away = $a["fangraphs_player"]; }
					   }
					   
					   if($j==1){
						 $pitcher_home = "**";		
						 $pitcherid_home =  str_center("id","/",$element->href);	 
						 $pitcherid_home =  str_center("/","/".$pitcher_home,$pitcherid_home);	 
						 $h = get_baseball_player_espn_nick($pitcherid_home);
						 if(!empty($h)){$pitcher_home  =  $h["espn_nick"]; $fansgraph_home = $h["fangraphs_player"]; }
					  }
						
					  $j++; 
					 }
				    }
				    //echo $td->plaintext." - ";	 
				    $line = false;
				    break;
				  }
				 }
			 }
				 
			// echo "<BR>";
			 }
			 
		   }
		 // break;
		  
		}

	  $home_team = get_baseball_team($game->vars["team_home"]); 
	  $away_team = get_baseball_team($game->vars["team_away"]); 
  	  $player_a = get_baseball_player_by_team("espn_player",$pitcherid_away,$away_team->vars["fangraphs_team"],$year,"pitcher"); 
	  $player_h = get_baseball_player_by_team("espn_player",$pitcherid_home,$home_team->vars["fangraphs_team"],$year,"pitcher"); 	

	  echo "AWAY<BR>";  
	
	  print_r($player_a);
	
	  if (is_null($player_a)){
      		echo "FALTA A ".$pitcherid_away." fans_id = ".$fansgraph_away." team ".$away_team->vars["fangraphs_team"]; 
      		if($fansgraph_away){
          $nt = new _baseball_player_teams();
          $nt->vars['player'] = $fansgraph_away;
          $nt->vars['team'] = $away_team  ->vars["fangraphs_team"];
          $nt->vars['season'] = $year;
          $nt->insert();

	  	}
	  }  else{
	  	// ADD THE TEAM FOR THE SEASON
	  	/*if($fansgraph_away){
          $nt = new _baseball_player_teams();
          $nt->vars['player'] = $fansgraph_away;
          $nt->vars['team'] = $away_team  ->vars["fangraphs_team"];
          $nt->vars['season'] = $year;
          $nt->insert();

	  	}*/
	  }
	  echo "<BR>HOME<BR>"; 
	  print_r($player_h);  
	  if (is_null($player_h)){
		echo "FALTA H ".$pitcherid_home." fans_id = ".$fansgraph_home." team ".$home_team->vars["fangraphs_team"]; 
		if($fansgraph_home){
          $nt = new _baseball_player_teams();
          $nt->vars['player'] = $fansgraph_home;
          $nt->vars['team'] = $home_team->vars["fangraphs_team"];
          $nt->vars['season'] = $year;
          $nt->insert();

	  	}
	  }  else{
	  	// ADD THE TEAM FOR THE SEASON
	  	/*if($fansgraph_home){
          $nt = new _baseball_player_teams();
          $nt->vars['player'] = $fansgraph_home;
          $nt->vars['team'] = $home_team->vars["fangraphs_team"];
          $nt->vars['season'] = $year;
          $nt->insert();

	  	}*/
	  }

	//  echo"<BR><BR>";

//     	if($game->started() && $old == false){
  //          echo "GAME ALREADY STARTED NO CHANGES ARE DONE";   
	//	} 
		
	 if (!is_null($player_h) && !is_null($player_a)){ 
		if($game->vars["pitcher_away"] == $player_a->vars["fangraphs_player"] && $game->vars["pitcher_home"] == $player_h->vars["fangraphs_player"] ) {
		 echo "<BR>SAME PITCHERTS NO DATA UPDATED<BR>"	;
		} else {
		$game->vars["pitcher_away"] = $player_a->vars["fangraphs_player"];
		$game->vars["pitcher_home"] = $player_h->vars["fangraphs_player"];
		
		if($game->started() && $old == false){
            echo "GAME ALREADY STARTED NO CHANGES ARE DONE";   
           // $game->update(array("pitcher_away","pitcher_home"));          
		} else{	
		$game->update(array("pitcher_away","pitcher_home"));          
		echo "<BR>UPDATE DATA<BR>";
	    }


		}
		
	   //Update the espn # for away
	   if (!$player_a->vars["espn_player"]){
		   $player_a->vars["espn_player"] = $pitcherid_away;
		  $player_a->update(array("espn_player"));
	   }
	   //Update the espn # for Home
	   if (!$player_h->vars["espn_player"]){
		  $player_h->vars["espn_player"] = $pitcherid_home;
		  $player_h->update(array("espn_player"));
	   }     
    }	
  echo"<BR><BR>";
//	break;  
  } //espn >0
}
?>
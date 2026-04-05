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


if (isset($_GET["gid"])){ 

$games = get_baseball_game($_GET["gid"],false);
}
else {
$date = date("Y-m-d");
//$date = "2018-06-05";	
$games = get_basic_baseball_games_by_date($date);	
}

//$games = array();//delete
$i=1;
foreach ($games as $game ){

 // if($game->vars["espn_game"] == 380606125) {
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
	//print_r($html) ;
	
	if($pr){
	 
        
		$j=0;
		if(!empty($html)){
		 foreach($html->find('div[id="gamepackage-probables"]') as $elementa) { 
		  
		 // echo $elementa->plaintext."<BR>";
		   foreach($elementa->find('a') as $element) { 
	  
	    //echo $element->plaintext;
				if (contains_ck($element->href,"/mlb/player/_/id/")){
				//	 echo "<BR>".$j.")".$element->href."<BR>";	  
					   if ($j==1) {
						$pitcher_away = str_center("id/","/",$element->href);	 
						$pitcherid_away =  str_center("id","/",$element->href);	 
						$pitcher_away =  str_center("/"," ",$pitcher_away);	 	 
						$pitcherid_away =  str_center("/","/".$pitcher_away,$pitcherid_away);
						$pitcher_away = str_replace("-"," ",$pitcher_away);	 
						$pitcher_away = str_replace("'"," ",$pitcher_away);	
					//	echo "AWAY+ ".$pitcher_away." --- ".$pitcherid_away."<BR>";
					   }
					   
					   if($j==2){
								
						$pitcher_home = str_center("id/","/",$element->href);	 
						$pitcherid_home =  str_center("id","/",$element->href);	 
						$pitcher_home =  str_center("/"," ",$pitcher_home);	 	 
						$pitcherid_home =  str_center("/","/".$pitcher_home,$pitcherid_home);	 
						$pitcher_home = str_replace("-"," ",$pitcher_home);
						$pitcher_home = str_replace("'"," ",$pitcher_home);	
					 //  echo "HOME+ ".$pitcher_home." --- ".$pitcherid_home."<BR>";
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
						$pitcher_away = str_center("id/","/",$element->href);	 
						$pitcherid_away =  str_center("id","/",$element->href);	 
						$pitcher_away =  str_center("/"," ",$pitcher_away);	 	 
						$pitcherid_away =  str_center("/","/".$pitcher_away,$pitcherid_away);
						$pitcher_away = str_replace("-"," ",$pitcher_away);	 
						$pitcher_away = str_replace("'"," ",$pitcher_away);	
					//	echo "AWAY+ ".$pitcher_away." --- ".$pitcherid_away."<BR>";
					   }
					   
					   if($j==1){
								
						$pitcher_home = str_center("id/","/",$element->href);	 
						$pitcherid_home =  str_center("id","/",$element->href);	 
						$pitcher_home =  str_center("/"," ",$pitcher_home);	 	 
						$pitcherid_home =  str_center("/","/".$pitcher_home,$pitcherid_home);	 
						$pitcher_home = str_replace("-"," ",$pitcher_home);
						$pitcher_home = str_replace("'"," ",$pitcher_home);	
					//    echo "HOME+ ".$pitcher_home." --- ".$pitcherid_home."<BR>";
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
		echo "FALTA A ".$pitcherid_away; 
	  }  
	  echo "<BR>HOME<BR>"; 
	  print_r($player_h);  
	  if (is_null($player_h)){
		echo "FALTA H ".$pitcherid_home; 
	  }
	  echo"<BR><BR>";

     
		
	 if (!is_null($player_h) && !is_null($player_a)){ 
		$game->vars["pitcher_away"] = $player_a->vars["fangraphs_player"];
		$game->vars["pitcher_home"] = $player_h->vars["fangraphs_player"];
		$game->update(array("pitcher_away","pitcher_home"));          
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
  
//	break;  
 // }
}
?>
<? 
require_once(ROOT_PATH . "/ck/db/handler.php"); 
require_once('../../../includes/html_dom_parser.php'); 
  
set_time_limit(0);




// Find today games and Teams
echo "---------------------------<BR>";
echo "     PITCHERS BY GAME<br>";
echo "---- ".$date." -----------<BR><BR>";




//$date = '2011-06-30';
$games = get_games_format();

$i=1;
foreach ($games as $game ){
	
	$year = date('Y',strtotime($game->vars["startdate"]));
  
  if (!$game->vars["postponed"]){	
   
    echo $i.") http://scores.espn.go.com/mlb/boxscore?gameId=".$game->vars["espn_game"]."<BR>";
    $html = file_get_html("http://scores.espn.go.com/mlb/boxscore?gameId=".$game->vars["espn_game"]."");
    $next_line_roof = false;
    $next_line_umpire = false;
    $new_line=false;
    $new_pitcher = false;
    $j=0;

	
	 
  foreach($html->find("Table.mod-data tr") as $tr) { 
	
	//echo $tr->plaintext."  -- ";
	
	 if (contains_ck($tr->plaintext,'Pitchers')){
		  $new_line = true;
	 }
		 
	 if ($new_line){
	
	   foreach($tr->find('a') as $element) { 
	    
		 //echo $element->href."<BR>";
		   $new_line = false;
	    if (contains_ck($element->href,"/mlb/player/_/id/")){
				  
			   if ($j==0) {
				$pitcher_away = str_center("id/","/",$element->href);	 
				$pitcherid_away =  str_center("id","/",$element->href);	 
				$pitcher_away =  str_center("/"," ",$pitcher_away);	 	 
				$pitcherid_away =  str_center("/","/".$pitcher_away,$pitcherid_away);
				$pitcher_away = str_replace("-"," ",$pitcher_away);	 
  		        $pitcher_away = str_replace("'"," ",$pitcher_away);	
			    //echo $element->href."- ".$pitcher_away." - ".$pitcherid_away."<BR>"; 
			   }
			   
			   if($j==1){
						
				$pitcher_home = str_center("id/","/",$element->href);	 
				$pitcherid_home =  str_center("id","/",$element->href);	 
				$pitcher_home =  str_center("/"," ",$pitcher_home);	 	 
				$pitcherid_home =  str_center("/","/".$pitcher_home,$pitcherid_home);	 
				$pitcher_home = str_replace("-"," ",$pitcher_home);
 		        $pitcher_home = str_replace("'"," ",$pitcher_home);	
			    //echo $element->href." ".$pitcher_home." - ".$pitcherid_home."<BR>"; 
				
				}
				
			  $j++; 
			  

		}
	 
     
	  $home_team = get_baseball_team($game->vars["team_home"]); 
	  $away_team = get_baseball_team($game->vars["team_away"]); 
  	  $player_a = get_baseball_player_by_team("espn_nick",$pitcher_away,$away_team->vars["fangraphs_team"],$year); 
	  $player_h = get_baseball_player_by_team("espn_nick",$pitcher_home,$home_team->vars["fangraphs_team"],$year); 	

	  echo "AWAY<BR>";  
	  print_r($player_a); 
	  if (is_null($player_a)){
		echo "FALTA A ".$pitcher_away; 
	  }
	   
	  echo "<BR>HOME<BR>"; 
	  print_r($player_h);  
	  if (is_null($player_h)){
		echo "FALTA H ".$pitcher_home; 
	  }
	  
	  echo"<BR><BR>";

	  if (!is_null($player_h) && !is_null($player_a)){ 
		$game->vars["pitcher_away"] = $player_a->vars["fangraphs_player"];
		$game->vars["pitcher_home"] = $player_h->vars["fangraphs_player"];
		$game->update(array("pitcher_away","pitcher_home"));          
	   //Update the espn # for away
	   if ($player_a->vars["espn_player"]==0){
		   $player_a->vars["espn_player"] = $pitcherid_away;
		   $player_a->update(array("espn_player"));
	   }
	   //Update the espn # for Home
	   if ($player_h->vars["espn_player"]==0){
		  $player_h->vars["espn_player"] = $pitcherid_home;
		  $player_h->update(array("espn_player"));
	   }     
    }
	
 	
$i++; 
$html->clear();  
    }
   }
  }
 
 }
}




function get_games_format(){
baseball_db();	

//$sql ="SELECT * FROM `game` WHERE runs_away = 0 and startdate > '2013-01-01 00:00:00' and startdate < '2013-07-14 00:00:00' AND postponed !=1 order by startdate ";

$sql="SELECT * FROM `game` WHERE (DATE(startdate) > '2013-03-30' && DATE(startdate) < '2013-08-07' ) and postponed = 0 and pitcher_away = 0 ";	
echo $sql;
return get($sql, "_baseball_game");	
}




?>
<? $no_log_page = true; ?>
<? require_once(ROOT_PATH . "/ck/db/handler.php"); 
    require_once(ROOT_PATH . '/includes/html_dom_parser.php');  
	require_once(ROOT_PATH . '/ck/nba_file/process/functions.php');
	ini_set('memory_limit', '-1');
    set_time_limit(0);

// Find today games and Teams
echo "---------------<BR>";
echo "NBA SCHEDULE   <br>";
echo "---------------<BR><BR>";
// THIS JOBS WORKS FOR UPDATE THE ESPNID ALSO FOR THE WINNER TEAM - IT WORKS FOR NEW SEASON ONLY UPDATE THE SEASON

$teams = get_nba_teams("espn_short");
$season = "21-22";
$espn_id = get_all_nba_espn_id($season);

echo "<pre>";
$j= 0;
foreach ($teams as $t){ $j++;
  $schedule = get_nba_schedule($t->vars["espn_short"],$teams);	
  //print_r($schedule);exit;
  if(!empty($schedule)){
	 
	  foreach ($schedule as $sh){
		
		if(!isset($espn_id[trim($sh["espn_id"])])){
		  
		  $game = get_nba_schedule_team($t->vars["id"],$season,trim($sh["date"]));
		  if(is_null($game)){
			$game = new _nba_games(); 
			$game->vars["date"] = trim($sh["date"]);
			$game->vars["season"] = $season;
			$game->vars["team_away"] = trim($sh["away"]);
			$game->vars["team_home"] = trim($sh["home"]);
			$game->vars["away_name"] = trim($sh["away_name"]);
			$game->vars["home_name"] = trim($sh["home_name"]);										  
			$game->vars["team_winner"] = trim($sh["win_team"]);										  		
			$game->vars["home_points"] = "";										  		
			$game->vars["away_points"] = "";
			$game->vars["first_home_points"] = "";										  		
			$game->vars["first_away_points"] = "";	
			$game->vars["first_home_points"] = "";										  		
			$game->vars["first_away_points"] = "";	
			$game->vars["second_home_points"] = "";										  		
			$game->vars["second_away_points"] = "";
			$game->vars["ot_home_points"] = "0";										  		
			$game->vars["ot_away_points"] = "0";			
			$game->vars["espn_id"] = trim($sh["espn_id"]);		
			if($game->vars["team_away"] > 0 && $game->vars["team_home"] > 0){
			 echo "insert";

			  $game->insert();	// CHECK THE MONTH DATE ON FUNCTION get_nhl_schedule 
			 // print_r($game);
			} else {" -- Some Team is Missed ";}  								  								
			
			 echo $t->vars["espn_short"].": ".trim($sh["date"])." NEW<BR>";   
		  }
		  else{
			 if(!$game->vars["espn_id"] && $game->vars["date"] < date('Y-m-d')  ){
				 $game->vars["espn_id"] = trim($sh["espn_id"]);	
				 $game->vars["team_winner"] = trim($sh["win_team"]);										  											  								                 $game->update(array("espn_id","team_winner"));
				 echo $game->vars["id"]." - ".$t->vars["espn_short"].": ".trim($sh["date"])." UPDATED<BR>";   
			 }
		  }

		}
	  }	  
 }
 //print_r($schedule);
// break;
}

echo "</pre>"; 
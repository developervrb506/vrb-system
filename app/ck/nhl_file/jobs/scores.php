<? $no_log_page = true; ?>
<? require_once(ROOT_PATH . "/ck/db/handler.php"); 
    require_once(ROOT_PATH . '/includes/html_dom_parser.php');  
	require_once(ROOT_PATH . '/ck/nhl_file/process/functions.php');
	ini_set('memory_limit', '-1');
    set_time_limit(0);


echo "---------------<BR>";
echo "NHL SCORES   <br>";
echo "---------------<BR><BR>";
// THIS JOBS WORKS FOR UPDATE THE SCORES ACCORDING THE ESPN ID



$season = "21-22";
$today = date("Y-m-d");
$games = get_nhl_schedule_pending_scores($season,$today);

$i=0;

if(!is_null($games)){
	foreach ($games as $game){ $i++;
	 $score=array();
	 $data = get_nhl_scores($game->vars["espn_id"]);
	 /*
	 $score["first_away"] = $data["away"]["1"] + $data["away"]["2"];
	 $score["first_home"] = $data["home"]["1"] + $data["home"]["2"];
	 $score["second_away"] = $data["away"]["3"] + $data["away"]["4"]+ $data["away"]["ot"]; 
	 $score["second_home"] = $data["home"]["3"] + $data["home"]["4"]+ $data["home"]["ot"];  
	 */
	 $score["away"] = $data["away"]["t"] ; 
	 $score["home"] = $data["home"]["t"] ;  
	 
    echo "<BR><BR>".$game->vars["id"];
	 if(!empty($data)){
		 
		$game->vars["home_points"] = $score["home"];										  		
		$game->vars["away_points"] = $score["away"];
		$game->vars["ot_home_points"] = $data["home"]["ot"];										  		
		$game->vars["ot_away_points"] = $data["away"]["ot"];		

		/*
		$game->vars["first_home_points"] = $score["first_home"];										  		
		$game->vars["first_away_points"] = $score["first_away"];	
		$game->vars["second_home_points"] = $score["second_home"];										  		
		$game->vars["second_away_points"] = $score["second_away"];
		*/
		//$game->update(array("home_points","away_points","first_home_points","first_away_points","second_home_points","second_away_points","ot_home_points","ot_away_points"));
		$game->update(array("home_points","away_points","ot_home_points","ot_away_points"));
		echo " UPDATED";
	 }
	 
	echo "<pre>";	
	print_r($score);
	echo "</pre>";	
	//break;
	//if($i>2)break;
	
	}
}



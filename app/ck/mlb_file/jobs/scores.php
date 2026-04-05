<? $no_log_page = true; ?>
<? require_once(ROOT_PATH . "/ck/db/handler.php"); 
    require_once(ROOT_PATH . '/includes/html_dom_parser.php');  
	require_once(ROOT_PATH . '/ck/mlb_file/process/functions.php');
	ini_set('memory_limit', '-1');
    set_time_limit(0);


echo "---------------<BR>";
echo "MLB SCORES   <br>";
echo "---------------<BR><BR>";
// THIS JOBS WORKS FOR UPDATE THE SCORES ACCORDING THE ESPN ID



$season = "2016";
$today = date("Y-m-d");
$games = get_mlb_schedule_pending_scores($season,$today);

$i=0;

if(!is_null($games)){
	foreach ($games as $game){ $i++;
	 $score=array();
	 $data = get_game_data($game->vars["espn_id"]);
	 $score["five_away"] = $data["five_away"] ;
	 $score["five_home"] = $data["five_home"] ; 
	 $score["away"] = $data["runs_away"] ; 
	 $score["home"] = $data["runs_home"] ;  
	 
    echo $game->vars["id"];
	 if(!empty($data)){
		 
		$game->vars["home_points"] = $score["home"];										  		
		$game->vars["away_points"] = $score["away"];
		$game->vars["five_home_points"] = $score["five_home"];										  		
		$game->vars["five_away_points"] = $score["five_away"];	
			
		$game->update(array("home_points","away_points","five_home_points","five_away_points"));
		echo " UPDATED";
	 }
	 
	echo "<pre>";	
	print_r($score);
	echo "</pre>";	
	//break;
	
	}
	//break;
}



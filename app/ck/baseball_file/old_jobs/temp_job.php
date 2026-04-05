<? require_once(ROOT_PATH . "/ck/db/handler.php"); 
    require_once('../../../includes/html_dom_parser.php');  
	ini_set('memory_limit', '-1');
    set_time_limit(0);

	
$time = date("i");

    	//include("old_yesterday_game_bullpen.php");
		include("old_pitchers_stadistics.php");

	/*
	if ($time >= '00' && $time <= '30'){
	include("old_pitcher_data_away.php");
	include("old_pitchers_stadistics.php");
	}
	else{
	include("old_pitcher_data_home.php");	
	include("old_pitchers_groundball.php");	
	}
	/*if ($time >= '11' && $time <= '20'){
	include("old_pitcher_data_home.php");
	}
	if ($time >= '00' && $time <= '30'){
	include("old_pitchers_stadistics.php");
	}*/
	//if ($time >= '31' && $time <= '40'){
	
	//}
	//if ($time >= '41' && $time <= '59'){
	//include("old_team_bullpen.php");
	//}*/
	
	//include("old_parkfactor.php");

?>
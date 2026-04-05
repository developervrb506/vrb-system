<? $no_log_page = true; ?>
<? require_once(ROOT_PATH . "/ck/db/handler.php"); 
    require_once(ROOT_PATH . '/includes/html_dom_parser.php');  
	require_once(ROOT_PATH . '/ck/baseball_file/process/functions.php');
    // require_once("../../../includes/html_dom_parser.php");  
	ini_set('memory_limit', '-1');
    set_time_limit(0);
    $date = date("Y-m-d");
    $games_without_espn = get_baseball_games_without_espn_game($date);
   	
	foreach($games_without_espn as $game){
	  $team_away = get_baseball_team($game->vars["team_away"]);
       $team_home = get_baseball_team($game->vars["team_home"]);
	
	 $gid =$game->vars["id"]; 	
	 $alert = new _baseball_alert();
	 $alert->vars["message"] = 'The game '.$team_away->vars['team_name'].' vs '.$team_home->vars['team_name'].' needs to fix the Hour --- <a href="http://localhost:8080/ck/baseball_file/game_hour_fix.php?gid='.$gid.'" class="normal_link" rel="shadowbox;height=270;width=300">Fix Now</a>';
	 $alert->vars["adate"] = date("Y-m-d H:i:s");
	 $alert->vars["type"] = "espn_id";
	 $alert->insert();
	 // print_r($alert); 
	}
	
	  
   
?>
<? $no_log_page = true; ?>
<? require_once(ROOT_PATH . "/ck/db/handler.php"); 
    require_once(ROOT_PATH . '/includes/html_dom_parser.php');  
	require_once(ROOT_PATH . '/ck/baseball_file/process/functions.php');
    // require_once("../../../includes/html_dom_parser.php");  
	ini_set('memory_limit', '-1');
    set_time_limit(0);

// Note this Job runs every 30 minutes at minute 10 and 40		

$today = date('Y-m-d');
$year = date('Y');
//$today = '2013-07-14';
$time = date("H:i");
echo $time;

// To check weekly if some pitcher was missed it runs all Mondays at 6:40 am.



 


$today_games = get_basic_baseball_games_by_date($today);
if (isset($today_games[0]->vars["id"])) { 


	// First Call to Jobs
	if ($time > date('H:i',strtotime('06:05')) && $time < date('H:i',strtotime('07:00'))){
	include("espn_games.php");
	include("pitchers_by_game.php");
	}
	
	if ($time > date('H:i',strtotime('07:05 AM')) && $time < date('H:i',strtotime('07:20 AM'))){
	include("team_bullpen_era.php");
	
	}
	

	/*
	// Umpire will be checked several times.
	if ($time > date('H:i',strtotime('07:05 AM')) && $time < date('H:i',strtotime('11:00 PM'))){
	include("umpire_previous_game.php");
	}	
*/


    // To doble check information.
	if ($time > date('H:i',strtotime('9:30 AM')) && $time < date('H:i',strtotime('11:00 AM'))){
	 
	   foreach ($today_games as $game){
	    		   
		   if ($game->vars["pitcher_away"] == 0 || $game->vars["pitcher_home"] == 0){
			    include("pitchers_by_game.php");
		   } 
           if ($game->vars["real_roof_open"] == -1 || $game->vars["umpire"]  == 0 || $game->vars["firstbase"]  == 0){ 
			    //	include("yesterday_game_data.php");
		   }
		   /*
		   $statistics = get_player_basic_stadistics($game->vars["pitcher_away"],$year,false,$game->vars["id"]);
			 if (is_null($statistics)){
				
				if ($time > date('H:i',strtotime('9:30 AM')) && $time < date('H:i',strtotime('9:55 AM'))){
				   include("pitchers_data_away.php");
				}
				
				if ($time > date('H:i',strtotime('10:05 AM')) && $time < date('H:i',strtotime('10:25 AM'))){				
				    include("pitchers_data_home.php");
				}
				
				if ($time > date('H:i',strtotime('10:30 AM')) && $time < date('H:i',strtotime('10:55 AM'))){
				   include("pitchers_groundball.php"); 
				}
			 }
			 */
	   
	   }
     }
	
 
}
else{
   echo "There are not games scheduled for today";	
}

?>
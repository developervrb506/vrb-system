<? require_once(ROOT_PATH . "/ck/db/handler.php"); 
    require_once(ROOT_PATH . '/includes/html_dom_parser.php');  
	require_once(ROOT_PATH . '/ck/props/process/functions.php');
	ini_set('memory_limit', '-1');
    set_time_limit(0);
$leagues = array("nba","nhl","mlb","nfl");
//$leagues = array("nba","mlb");	

$leagues = array("nfl");	
//$leagues = array("nba");	


// tennis is set but is not requiered

	foreach ($leagues as $league){
	   echo "  ***************************************<BR>";	   
	   echo "  ******".strtoupper($league)." PLAYERS  **********<BR>";
	   echo "  ***************************************<BR><BR>";	   
	   fn_espn_players_by_league($league);
	
       if($league == 'mlb') {

       echo "<BR><BR>  ***************************************<BR>";	   
	   echo "  ******".strtoupper($league)." MLB.com PROCESS **********<BR>";
	   echo "  ***************************************<BR><BR>";


       	 fn_update_player_id_mlb_com(); // Update the players id from mlb.com
       }

	}



	//MLB.COM

  




?>
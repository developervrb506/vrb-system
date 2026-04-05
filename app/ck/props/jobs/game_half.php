<?
require_once(ROOT_PATH . "/ck/db/handler.php"); 
require_once(ROOT_PATH . '/includes/html_dom_parser.php');  
require_once(ROOT_PATH . '/ck/props/process/functions.php');
ini_set('memory_limit', '-1');
set_time_limit(0);

error_reporting(-1);
ini_set('error_reporting', E_ALL);

echo "<pre>" ; 
$manual = false;
if(isset($_GET['l'])){
	$league = $_GET['l'];
	$game = $_GET['g'];
	$manual =  true;
}

$leagues = array('nfl','ncaaf','nhl','nba');
$yesterday = date( "Y-m-d", strtotime( "-1 day", strtotime(date( "Y-m-d")))); 

if($manual){
    echo "<BR>**MANUAL**<BR><BR>";
	//$games = get_espn_games_custom($league,$yesterday,"finished",0,"status",1); 
	//if(!empty($games)) {
 		//foreach($games as $game){
 		
 			  $half = fn_check_half_time($league,$game);
 			  echo $half;
 			  if($half){
 			  
 			  	$es_game = get_espn_game_espnid($game);
 			  	print_r($es_game);

 			  	$es_game->vars["status"] = $half;
 			  	$es_game->update(array('status'));
 			  }

 		//}

 /*	} else {

 		echo "There are not Games to check in ".$league."<BR>";


 	}*/
	
 }

 else {
//echo "<BR>**PROCESS**<BR><BR>";
foreach ($leagues as $league) {

		$games = get_espn_games_custom($league,$yesterday,"finished",0,"status",1); 
	   //print_r($games);exit;

	  if(!empty($games)) {
 		foreach($games as $game){
 		
 			  $half = fn_check_half_time($league,$game->vars["espn_id"]);
 			  if($half){
 			  	$game->vars["status"] = $half;
 			  	$game->update(array('status'));
 			  }

 		}

 	} else {
 		echo "There are not Games to check in ".$league."<BR>";


 	}
	
 }

}


	?>
<? 
require_once(ROOT_PATH . "/ck/db/handler.php"); 
require_once(ROOT_PATH . '/includes/html_dom_parser.php');  
require_once(ROOT_PATH . '/ck/baseball_file/process/functions.php');
    // require_once("../../../includes/html_dom_parser.php");  
	
	ini_set('memory_limit', '128M');
	set_time_limit(0);

// Find today games and Teams
echo "---------------<BR>";
echo "STADISTICS FOR PITCHERS<br>";
echo "---------------<BR><BR>";

$today= date('Y-m-d');
//$today= date('2013-07-11');

$games = get_basic_baseball_games_by_date($today);


echo "<pre>";
//print_r($games);
echo "</pre>";

foreach ($games as $game){

	  echo "Pitcher AWAY <BR>";
	  $player_a = get_baseball_player_by_id("fangraphs_player",$game->vars["pitcher_away"]);
	  echo "http://www.fangraphs.com/statss.aspx?playerid=".$player_a->vars["fangraphs_player"]."&position=".$player_a->vars["position"]." -->".$player_a->vars["player"]."<BR>";
	  get_player_statistics($player_a->vars["fangraphs_player"],$player_a->vars["position"],$player_a->vars["player"],$game->vars["id"]);
	  echo "Pitcher HOME<BR>";
	  $player_h = get_baseball_player_by_id("fangraphs_player",$game->vars["pitcher_home"]);
  	  echo "http://www.fangraphs.com/statss.aspx?playerid=".$player_h->vars["fangraphs_player"]."&position=".$player_h->vars["position"]." -->".$player_h->vars["player"]."<BR>";

	  get_player_statistics($player_h->vars["fangraphs_player"],$player_h->vars["position"],$player_h->vars["player"],$game->vars["id"]);
	  echo "<BR>--<BR>";
	// break; 
 
} 


?>
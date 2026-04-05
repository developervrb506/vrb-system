<? 
require_once(ROOT_PATH . "/ck/db/handler.php"); 
require_once(ROOT_PATH . '/includes/html_dom_parser.php'); 
require_once(ROOT_PATH . '/ck/baseball_file/process/functions.php');

set_time_limit(0);

echo "---------------<BR>";
echo "Velocity  FOR PITCHERS_AWAY<br>";
echo "---------------<BR><BR>";

$year = date("Y");	
$today = date("Y-m-d");
$type = "away";

if (isset($_GET["gid"])){ 
 $games = get_baseball_game($_GET["gid"],false);
}
else {
 $games =  get_players_by_date_pending_update($today,$type,'speed');
}

$ji =0;
foreach ($games as $player){
$ji++;
      echo "Pitcher ".$type." <BR>";
	
	    $data = get_player_pitches_velocity($player->vars["fangraphs_player"],$player->vars["player"],$year,false,$player->vars["game"]);
		
	  if(!empty($data)){
		  $player_update = new _player_updated();
		  $player_update->vars["player"]= $player->vars["fangraphs_player"];
		  $player_update->vars["type"]= 'speed';
		  $player_update->vars["date"]= date("Y-m-d");
		  $player_update->insert();
	  }
	 
	
}


?>
<? 
require_once(ROOT_PATH . "/ck/db/handler.php"); 
require_once(ROOT_PATH . '/includes/html_dom_parser.php'); 
require_once(ROOT_PATH . '/ck/baseball_file/process/functions.php');

set_time_limit(0);

echo "---------------<BR>";
echo "DATA FOR PITCHERS_HOME <br>";
echo "---------------<BR><BR>";

$year = date("Y");	
$today = date("Y-m-d");
$type = "home";

if (isset($_GET["gid"])){ 
 $games = get_baseball_game($_GET["gid"],false);
}
else {
 $games =  get_players_by_date_pending_update($today,$type,'data');
}

$ji =0;
foreach ($games as $player){
$ji++;
      echo "Pitcher AWAY <BR>";
	
	    $data = get_player_pitches($player->vars["fangraphs_player"],$player->vars["player"],$year,false,$player->vars["game"]);
 	   
	  /*    echo "<pre>";
		print_r($data);
	    echo "</pre>";
	    exit;
	  */
	   
	    get_player_era($player->vars["fangraphs_player"],$player->vars["player"],$year,false,$player->vars["game"]);
	
	//  if(!empty($data)){
		  $player_update = new _player_updated();
		  $player_update->vars["player"]= $player->vars["fangraphs_player"];
		  $player_update->vars["type"]= 'data';
		  $player_update->vars["date"]= date("Y-m-d");
		 $player_update->insert();
	//  }
	 
	
}
?>
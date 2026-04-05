<? 
require_once(ROOT_PATH . "/ck/db/handler.php"); 
require_once(ROOT_PATH . '/includes/html_dom_parser.php'); 
require_once(ROOT_PATH . '/ck/baseball_file/process/functions.php');

	ini_set('memory_limit', '128M');
	set_time_limit(0);

// Find today games and Teams
echo "--------------------------<BR>";
echo "Park Factor              <br>";
echo "-------------------------<BR><BR>";



$date = date("Y-m-d");
//$today = "2014-03-29";
$year = date("Y");

if (isset($_GET["date"])){
  $date = $_GET["date"];
}

echo "Date: ".$date."<BR>";
$games = get_basic_baseball_games_by_date($date);

foreach ($games as $game){

  $stadium = get_baseball_stadium_by_team($game->vars["team_home"]);
  get_parkfactor($stadium->vars['id'],$game->vars['id'],$year);


}

?>
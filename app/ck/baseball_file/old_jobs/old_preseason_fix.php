<? require_once(ROOT_PATH . "/ck/db/handler.php"); 
    require_once('../../../includes/html_dom_parser.php');  
	ini_set('memory_limit', '-1');
    set_time_limit(0);
	



$games = get_games_format();
$i=0;

echo count($games);

foreach ($games as $game ){

$date = date( "Y-m-d H:i:s", strtotime( "-10 year", strtotime(date($game->vars["startdate"])))); 
$game->vars["startdate"] = $date;
$game->update(array("startdate"));


} // end FOR





function get_games_format(){
baseball_db();	

//$sql ="SELECT * FROM `game` WHERE runs_away = 0 and startdate > '2013-01-01 00:00:00' and startdate < '2013-07-14 00:00:00' AND postponed !=1 order by startdate ";

$sql="SELECT * from game where DATE(startdate) < '2010-04-04' and  DATE(startdate) > '2010-01-01' limit 60";	
//echo $sql;
return get($sql, "_baseball_game");	
}


?>
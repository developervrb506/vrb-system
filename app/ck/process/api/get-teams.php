<? require_once(ROOT_PATH . "/ck/db/handler.php"); ?>
<?
//$league = param("league");
$league = $_POST["league"];

$teams = get_all_twitter_teams($league);

foreach($teams as $team){	
	$teamid        = $team["teamid"];
	$teamname      = $team["team"];
	$array_teams[] = array("team_id" => $teamid, "team_name" => $teamname);
}

echo json_encode($array_teams);

?>

<? 
$no_log_page = true; ?>
<? require_once(ROOT_PATH . "/ck/db/handler.php"); ?>
<?

$accounts = param("accs");
$identifiers = param("idents");
$password = param("game");
$result = array();

if($password == md5("B3tt1nG@cce5")){
	
	$games = get_active_future_games();
	$glist = "";
	foreach($games as $g){
		$glist .= ",".$g->vars["id"];
	}
	$glist = substr($glist,1);
	$bets = get_bets_by_account_games($accounts,$identifiers,$glist);
	
	print_r($bets);
	
	foreach($bets as $bet){
		if(!is_null($games[$bet ->vars["gameid"]])){
			
			$g = $games[$bet ->vars["gameid"]];
			
			$teams = get_teams_by_list($g->vars["team_away"].",".$g->vars["team_home"]);
			$ateam = $teams[$g->vars["team_away"]];
			$hteam = $teams[$g->vars["team_home"]];
			
			$res_game = array();
			$res_game["detail"] = $g;
			$res_game["teams"] = array("away"=>$ateam,"home"=>$hteam);
			$res_game["bet"] = $bet;
			
			$result[] = $res_game;
			
		//}
	}
	
	
	//echo json_encode($result);
	
	
}else{
	echo "This page no longer exists";	
}


?>

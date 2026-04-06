<? include(ROOT_PATH . "/ck/process/security.php");

$date = clean_get("date");
$sport = clean_get("sport");
$period = clean_get("period");

include ("inspin_sport_parser.php");


if($sport == "other"){
	$games = get_other_sports_games($date);
	$picks = array();
}else{
	$games = get_games($sport, $date, $date); 
	$picks = search_inspin_picks($date, $date, $sport, $period, "0");
	$picks_TT = search_inspin_picks($date, $date, $sport, "Team Totals", "0");
}

foreach($games as $game){
	$score_away = clean_get($game->vars["id"]."_away");
	$score_home = clean_get($game->vars["id"]."_home");
	if(is_numeric($score_away) && is_numeric($score_home)){
		$result = new _result();		
		$result->vars["game_id"] = $game->vars["id"];
		$result->vars["period"] = $period;
		$result->vars["away_score"] = $score_away;
		$result->vars["home_score"] = $score_home;
		$result->delete_previous();
		$result->insert();
		
		//picks
		$pick = $picks[$game->vars["id"]];
		if(!is_null($pick)){
			$gresult1 = $pick->get_result($pick->vars["line"], $pick->vars["chosen_id"], $game, $score_away, $score_home);
			$gresult2 = $pick->get_result($pick->vars["line2"], $pick->vars["chosen_id_2"], $game, $score_away, $score_home);
			$pick->vars["win"] = $gresult1["result"];
			$pick->vars["juice"] = $gresult1["juice"];
			$pick->vars["win_2"] = $gresult2["result"];
			$pick->vars["juice_2"] = $gresult2["juice"];
			$pick->update(array("win","win_2","juice","juice_2"));
		}
		$pick = $picks_TT[$game->vars["id"]];
		if(!is_null($pick)){
			$gresult1 = $pick->get_result($pick->vars["line"], $pick->vars["chosen_id"], $game, $score_away, $score_home);
			$gresult2 = $pick->get_result($pick->vars["line2"], $pick->vars["chosen_id_2"], $game, $score_away, $score_home);
			$pick->vars["win"] = $gresult1["result"];
			$pick->vars["juice"] = $gresult1["juice"];
			$pick->vars["win_2"] = $gresult2["result"];
			$pick->vars["juice_2"] = $gresult2["juice"];
			$pick->update(array("win","win_2","juice","juice_2"));
		}
		//picks
		
		$bets = search_bets_by_game($game->vars["id"], $period);
		
		if($period == "Game"){
			$bets = array_merge($bets, search_bets_by_game($game->vars["id"], "Team Totals"));
		}
		$ad_key = mt_rand();
		foreach($bets as $bet){
			$bet->grade($game, $score_away, $score_home);
			$commissions = get_account_commission_relations($bet->vars["account"]->vars["id"]);
			foreach($commissions as $com){
				
				if($bet->vars["status"] != "p"){
					$amount = $bet->get_commission_amount($com->vars["percentage"]);
					$status = $bet->get_commission_status();
					
					$abet = new _bet();				
					$abet->vars["account"] = $com->vars["caccount"];
					$abet->vars["risk"] = $amount;
					$abet->vars["win"] = $amount;
					$abet->vars["identifier"] = $bet->vars["identifier"]->vars["id"];
					$abet->vars["type"] = "adjustment";	
					$abet->vars["gameid"] = $bet->vars["gameid"];	
					$abet->vars["period"] = $bet->vars["period"];				
					$abet->vars["bdate"] = $bet->vars["bdate"];
					$abet->vars["line"] = $bet->vars["line"];
					$abet->vars["place_date"] = date("Y-m-d H:i:s");
					$abet->vars["user"] = $current_clerk->vars["id"];				
					$abet->vars["account_percentage"] = $com->vars["caccount"]->vars["description"];				
					$abet->vars["status"] = $status;				
					$abet->vars["comment"] = "Commission From Account " . $bet->vars["account"]->vars["name"]."<br />".$bet->vars["team"]." ".$bet->vars["line"];
					$abet->vars["adjustment_key"] = $ad_key;
					$abet->vars["parent"] = $bet->vars["id"];	
					$abet->delete_previous_adjustments($bet->vars["account"]->vars["name"]);
					$abet->insert();
				}
				
			}
		}
		
	}
}



header("Location: " . BASE_URL . "/ck/betting_grading.php?date=$date&sport=$sport&period=$period&e=42");


?>
<? require_once(ROOT_PATH . "/ck/process/functions.php"); ?>
<?
function get_games_lines($date, $league_p, $period_p){
	$league = strtoupper($league);
	switch($period_p){
		case 'Game':
		   $period = '- GAME LINES';
		   break;	
		case '1st Half':
		   $period = '(1H)';
		   break;
		case '2nd Half':
		   $period = '(2H)';
		   break;
		case '1st Quarter':
		   $period = '(1Q)';
		   break;
		case '2nd Quarter':
		   $period = '(2Q)';
		   break;
		case '3rd Quarter':
		   $period = '(3Q)';
		   break;
		case '4th Quarter':
		   $period = '(4Q)';
		   break;
		case '1st 5 Innings':
		   $period = '(1H)';
		   break;
		case 'Last 4 Innings':
		   $period = '(2H)';
		   break;
		case '1st Period':
		   $period = '(1P)';
		   break;
		case '2nd Period':
		   $period = '(2P)';
		   break;
		case '3rd Period':
		   $period = '(3P)';
		   break;
		
	}
	
	switch ($league_p) {
	
	case 'NFL':
	   $league = 'NFL';
	   break;
	
	case 'MLB':
	   $league = 'MLB';
	   break;
	
	case 'NCAAF':
	   $league = 'NCAAF';
	   break;   
	
	case 'NCAAB':
	   $league = 'NCAAB';
	   break;   
	
	case 'NBA':
	   $league = 'NBA';
	   break;   
	
	case 'NHL':
	   $league = 'NHL';
	   break;       
	
	}
	$data = array();
	if($league!=""){$qleague = "?IdSport=$league";}
	$xml_str = file_get_contents("http://www.sportsbettingonline.com/engine/xmlfeed/$qleague");
	
	$xml_str = str_replace('\"','"',$xml_str);
	$xml_str = str_replace("&frac12;",".5",$xml_str);
	$xml_str = str_replace("&amp;frac12;",".5",$xml_str);
		
		$dom = new DomDocument();
		
		@$dom->loadXML($xml_str);
		$root = $dom->documentElement;
				 
		$sections = $root->getElementsByTagName("league");	
		
		foreach($sections as $sec){
			if($period_p == "*"){$period = "";}
			if(contains_ck($sec->getAttribute("Description"),"$league $period") || $period_p == "*"){
				if($period == ""){$period = get_sbo_period($sec->getAttribute("Description"),$league);}
				if($period != ""){
					$games = $sec->getElementsByTagName("game");	
					foreach($games as $game){
						$line = array();
						$line["away_rotation"] = substr($game->getAttribute("vnum"),-3);
						$line["home_rotation"] = substr($game->getAttribute("hnum"),-3);
						$line["period"] = $period;
						$line["line_date"] = date("Y-m-d",strtotime($game->getAttribute("gmdt")));
						
						$betline = $game->getElementsByTagName("line");
						$betline = $betline->item(0);
						
						$line["away_spread"] = $betline->getAttribute("vsprdh");
						$line["home_spread"] = $betline->getAttribute("hsprdh");
						$line["away_spread_percentage"] = 0;
						$line["home_spread_percentage"] = 0;
						
						$line["away_money"] = $betline->getAttribute("voddsh");
						$line["home_money"] = $betline->getAttribute("hoddsh");
						$line["away_money_percentage"] = 0;
						$line["home_money_percentage"] = 0;
						
						$line["away_total"] = $betline->getAttribute("ovh");
						$line["home_total"] = $betline->getAttribute("unh");
						$line["away_total_percentage"] = 0;
						$line["home_total_percentage"] = 0;
						
						$key = $line["away_rotation"]/* ."_". $line["period"]*/;
						$data[$key]  = new _odds_line($line);
						
						
					}//for each games
				}//if period blank
			}//if period
		}//for each section
	
	return $data;
}
function get_sbo_period($desc, $league){
	$period = "";
	if(contains_ck($desc,"GAME LINES")){
		$period = "Game";
	}else if(contains_ck($desc,"(1H)") && $league != "MLB"){
		$period = "1st Half";
	}else if(contains_ck($desc,"(2H)") && $league != "MLB"){
		$period = "2nd Half";
	}else if(contains_ck($desc,"(1Q)")){
		$period = "1st Quarter";
	}else if(contains_ck($desc,"(2Q)")){
		$period = "2nd Quarter";
	}else if(contains_ck($desc,"(3Q)")){
		$period = "3rd Quarter";
	}else if(contains_ck($desc,"(4Q)")){
		$period = "4th Quarter";
	}else if(contains_ck($desc,"(1H)") && $league == "MLB"){
		$period = "1st 5 Innings";
	}else if(contains_ck($desc,"(2H)") && $league == "MLB"){
		$period = "Last 4 Innings";
	}else if(contains_ck($desc,"(1P)")){
		$period = "1st Period";
	}else if(contains_ck($desc,"(2P)")){
		$period = "2nd Period";
	}else if(contains_ck($desc,"(3P)")){
		$period = "3rd Period";
	}
	return $period;
}

?>
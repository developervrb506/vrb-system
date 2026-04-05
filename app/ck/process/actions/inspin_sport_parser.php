<?
function get_games($sport, $from, $to, $data_key = "NO_KEY"){
	$data = array();
	
	$xml_str = file_get_contents("http://jobs.inspin.com/feeds/schedule.php?sport=$sport&from=$from&to=$to");
	
	$xml_str = str_replace("&"," ",$xml_str);
	
	if(contains_ck($xml_str,"game")){
	
		$dom = new DomDocument();
		@$dom->loadXML($xml_str);
		$root = $dom->documentElement;
		
		$xml_games = $root->getElementsByTagName("game");
		
		foreach($xml_games as $xml_game){
			$game = new _inspin_game();
			$game->vars["id"] = $xml_game->getElementsByTagName("id")->item(0)->nodeValue;
			$game->vars["sport"] = $xml_game->getElementsByTagName("sport")->item(0)->nodeValue;
			$game->vars["date"] = $xml_game->getElementsByTagName("date")->item(0)->nodeValue;
			$game->vars["away_rotation"] = $xml_game->getElementsByTagName("away_rotation")->item(0)->nodeValue;
			$game->vars["home_rotation"] = $xml_game->getElementsByTagName("home_rotation")->item(0)->nodeValue;
			
			$xml_away = $xml_game->getElementsByTagName("away_team")->item(0);
			$away = new _inspin_team();
			$away->vars["id"] = $xml_away->getElementsByTagName("id")->item(0)->nodeValue;
			$away->vars["name"] = $xml_away->getElementsByTagName("name")->item(0)->nodeValue;
			
			$xml_home = $xml_game->getElementsByTagName("home_team")->item(0);
			$home = new _inspin_team();
			$home->vars["id"] = $xml_home->getElementsByTagName("id")->item(0)->nodeValue;
			$home->vars["name"] = $xml_home->getElementsByTagName("name")->item(0)->nodeValue;
			
			$game->vars["away_team"] = $away;
			$game->vars["home_team"] = $home;
			
			if($data_key!="NO_KEY"){$data[$data_key] = $game;}else{$data[] = $game;}		
		}
	
	}
	return $data;
}
function get_game($gameid){
	$game = NULL;
	//echo "http://jobs.inspin.com/feeds/game.php?gameid=$gameid";
	$xml_str = file_get_contents("http://jobs.inspin.com/feeds/game.php?gameid=$gameid");
	
	$xml_str = str_replace("&","",$xml_str);
	
	if(contains_ck($xml_str,"game")){
	
		$dom = new DomDocument();
		@$dom->loadXML($xml_str);
		$root = $dom->documentElement;
		
		$xml_game = $root->getElementsByTagName("game")->item(0);
		if(!is_null($xml_game)){
			$game = new _inspin_game();
			$game->vars["id"] = $xml_game->getElementsByTagName("id")->item(0)->nodeValue;
			$game->vars["sport"] = $xml_game->getElementsByTagName("sport")->item(0)->nodeValue;
			$game->vars["date"] = $xml_game->getElementsByTagName("date")->item(0)->nodeValue;
			$game->vars["away_rotation"] = $xml_game->getElementsByTagName("away_rotation")->item(0)->nodeValue;
			$game->vars["home_rotation"] = $xml_game->getElementsByTagName("home_rotation")->item(0)->nodeValue;
			
			$xml_away = $xml_game->getElementsByTagName("away_team")->item(0);
			$away = new _inspin_team();
			$away->vars["id"] = $xml_away->getElementsByTagName("id")->item(0)->nodeValue;
			$away->vars["name"] = $xml_away->getElementsByTagName("name")->item(0)->nodeValue;
			$away->vars["nick"] = $xml_away->getElementsByTagName("nick")->item(0)->nodeValue;
			
			$xml_home = $xml_game->getElementsByTagName("home_team")->item(0);
			$home = new _inspin_team();
			$home->vars["id"] = $xml_home->getElementsByTagName("id")->item(0)->nodeValue;
			$home->vars["name"] = $xml_home->getElementsByTagName("name")->item(0)->nodeValue;
			$home->vars["nick"] = $xml_home->getElementsByTagName("nick")->item(0)->nodeValue;
			
			$game->vars["away_team"] = $away;
			$game->vars["home_team"] = $home;
		}
	
	}
	//print_r($game);
	return $game;
}
?>
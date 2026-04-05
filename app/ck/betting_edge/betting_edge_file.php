<? 
$no_log_page = true; ?>
<? require_once(ROOT_PATH . "/ck/db/handler.php"); ?>
<?



$password = param("game");
$result = array();

if($password == md5("B3tt1nG@cce5")){

  $from = date("Y-m-d"); 
  $to = date( "Y-m-d", strtotime( "1 day", strtotime(date( "Y-m-d")))); 
  	/*
	$games = get_active_future_games();
	$glist = "";
	foreach($games as $g){
		$glist .= ",".$g->vars["id"];
	}
	$glist = substr($glist,1);*/
	$bets = get_all_external_bets($from,$to);
	
	foreach($bets as $bet){
		
			
			$res_game = array();
			
			$res_game["game_date"] = $bet->vars["game_date"];
			$res_game["home"] = $bet->vars["home"];
			$res_game["away"] = $bet->vars["away"];			
			$res_game["league"] = $bet->vars["league"];
			$res_game["period"] = $bet->vars["period"];
			$res_game["bet_type"] = $bet->vars["bet_type"];
			$res_game["line"] = $bet->vars["line"];
			$res_game["risk"] = $bet->vars["risk"];																	
			$res_game["win"] = $bet->vars["win"];																				
			
			
			$result[] = $res_game;
			
		}
	
	
	
	echo json_encode($result);
	
	
}else{
	echo "This page no longer exists";	
}


?>

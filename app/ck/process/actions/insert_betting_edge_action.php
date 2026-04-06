<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->im_allow("betting_edge_system")){ ?>
<?


$start_time = $_POST["from"]." ".$_POST["start_hour"].":".$_POST["start_minute"]." ".$_POST["start_data"];
$start_time = date("Y-m-d H:i:s",strtotime($start_time));
$home = $_POST["home"];
$away = $_POST["away"];
$league = $_POST["league"];
$period = $_POST["period"];
$bet_type = $_POST["type"];
$line = $_POST["line"];
$risk = $_POST["risk"];
$win = $_POST["win"];


if (isset($_GET["id"])){
	$bet = get_external_bet($_GET["id"]);
	$bet->delete();
}
else{
	if (isset($_POST["update"])){
		
		$bet = get_external_bet($_POST["update"]);
		$bet->vars["game_date"] = $start_time;
	    $bet->vars["home"] = $home; 	
	    $bet->vars["away"] = $away; 			
	    $bet->vars["league"] = strtoupper($league);
		$bet->vars["period"] = $period; 		
		$bet->vars["bet_type"] = $bet_type;
		$bet->vars["line"] = $line;
		$bet->vars["risk"] = $risk; 
		$bet->vars["win"] = $win; 
		
		$bet->update();
	
	}else{
		
	 $bet = new _external_bets();
	 $bet->vars["game_date"] = $start_time;
	    $bet->vars["home"] = $home; 	
	    $bet->vars["away"] = $away; 			
	    $bet->vars["league"] = strtoupper($league);
		$bet->vars["period"] = $period; 		
		$bet->vars["bet_type"] = $bet_type;
		$bet->vars["line"] = $line;
		$bet->vars["risk"] = $risk; 
		$bet->vars["win"] = $win; 
	   $bet->insert();
	
	}
}

header("Location: " . BASE_URL . "/ck/betting_edge/betting_edge.php?e=82");
?>
<? }else{echo "Access Denied";} ?>
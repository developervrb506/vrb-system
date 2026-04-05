<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->im_allow("betting_basics")){ ?>
<? include "inspin_sport_parser.php" ?>
<?

$pick = get_inspin_pick($_POST["gameid"], $_POST["period"]);
$game = get_game($_POST["gameid"]);

$pick->vars["status"] = "Y";
if($_POST["stars"] == 2){
	$pick->vars["2and3star"] = "Y";
	$pick->vars["4and5star"] = "N";	
}else if($_POST["stars"] == 3){
	$pick->vars["2and3star"] = "N";
	$pick->vars["4and5star"] = "Y";
}
$pick->vars["chosen_id"] = clean_get("team1");
$pick->vars["line"] = clean_get("line1");

$game_str = $game->vars["away_team"]->vars["name"] . " " . $game->vars["away_team"]->vars["nick"];
$game_str .= " vs ";
$game_str .= $game->vars["home_team"]->vars["name"] . " " . $game->vars["home_team"]->vars["nick"];

if($pick->vars["chosen_id"] == $game->vars["away_team"]->vars["id"]){
	$team1 = $game->vars["away_team"]->vars["name"] . " " . $game->vars["away_team"]->vars["nick"];
}else if($pick->vars["chosen_id"] == $game->vars["home_team"]->vars["id"]){
	$team1 = $game->vars["home_team"]->vars["name"] . " " . $game->vars["home_team"]->vars["nick"];
}else{
	$team1 = $pick->vars["chosen_id"];
}

$line1 = clean_get("line1");
if($_POST["period"] != "Team Totals"){$line1 = str_replace("o","",str_replace("u","",strtolower($line1)));}

$pick->vars["4and5star_comment"] = $team1 . " " . $line1 . " " . $pick->comment_period();

if(clean_get("team2")!=""){
	$pick->vars["chosen_id_2"] = clean_get("team2");
	$pick->vars["line2"] = clean_get("line2");
	
	if($pick->vars["chosen_id_2"] == $game->vars["away_team"]->vars["id"]){
		$team2 = $game->vars["away_team"]->vars["name"] . " " . $game->vars["away_team"]->vars["nick"];
	}else if($pick->vars["chosen_id_2"] == $game->vars["home_team"]->vars["id"]){
		$team2 = $game->vars["home_team"]->vars["name"] . " " . $game->vars["home_team"]->vars["nick"];
	}else{
		$team2 = $pick->vars["chosen_id_2"];
	}
	
	$line2 = clean_get("line2");
	if($_POST["period"] != "Team Totals"){$line2 = str_replace("o","",str_replace("u","",strtolower($line2)));}
	
	
	$pick->vars["comment_2"] = $team2 . " " . $line2 . " " . $pick->comment_period();
}

$pick->vars["pick_date"] = date("Y-m-d H:i:s");

$pick->update();

if($_POST["stars"] == 3){
	send_pick_email($game, $pick->vars["4and5star_comment"], $pick->vars["comment_2"], $game_str);
	send_pick_sms($pick->vars["4and5star_comment"], $game_str);
	send_pick_sms($pick->vars["comment_2"], $game_str);
}

header("Location: ../../insert_pick.php?gid=".$pick->vars["gameid"]."&period=".$pick->vars["period"]."&e=60");
?>

<? }else{echo "Access Denied";} ?>

<?



function send_pick_email($game, $pick1, $pick2, $gamestr){
	$sub      = '3 Star Premium Pick ';
	$content  = '3 Star Premium Pick <br>';
	$content .= $gamestr.'<br><br />';
	$content .= $pick1.'<br>';
	$content .= $pick2.'<br><br />';
	$content .= 'Bet it and Bank It!<br>';
	$content .= 'Inspin.com<br>';
		
	switch ($game->vars["sport"]) {
		case 'nfl':
		  $link = 'http://jobs.inspin.com/nfl-picks.php';
		  break;	
		case 'mlb':
		  $link = 'http://jobs.inspin.com/mlb-baseball-picks.php';
		  break;		  
		case 'ncaaf':
		  $link = 'http://jobs.inspin.com/college-football-picks.php';
		  break;		  
		case 'nhl':
		  $link = 'http://jobs.inspin.com/nhl-hockey-picks.php';
		  break;		  
		case 'nba':
		  $link = 'http://jobs.inspin.com/nba-picks.php';
		  break;		  
		case 'ncaab':
		  $link = 'http://jobs.inspin.com/college-basketball-picks.php';
		  break;  	  
    }	
	
	$content .= '<a href="'.$link.'">'.$link.'</a>';	
	
	$customers = get_premium_emails();
	
	foreach($customers as $cus){
		send_email_ck($cus["email"], $sub, $content, true,"support@inspin.com", "Inspin.com");		
	}	
	
	//send_email_ck("scott@vrbmarketing.com", $sub, $content, true,"support@inspin.com", "Inspin.com");	
	//send_email_ck("skoot73@hotmail.com", $sub, $content, true,"support@inspin.com", "Inspin.com");	
}
?>
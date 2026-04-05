<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->im_allow("betting_basics")){ ?>
<? include "inspin_sport_parser.php" ?>
<?
$game = get_game($_POST["gameid"]);

if(isset($_POST["pid"])){
	$pick = get_inspin_pick_by_id($_POST["pid"]);
	$pick->vars["period"] = $_POST["period"];
	$update = true;
}else{
	$pick = new _inspin_pick();
	$pick->vars["gameid"] = $game->vars["id"];
	$pick->vars["period"] = $_POST["period"];
	
	$sp_pick = get_inspin_pick($_POST["gameid"], $_POST["period"]);
	if(!is_null($sp_pick)){
		$prenum = substr(str_replace(" ","",$sp_pick->vars["period"]),-1);
		if(is_numeric($prenum)){$num = $prenum+1;}else{$num = 2;}
		$pick->vars["period"] = $_POST["period"] . " " . $num;
	}	
	
}

$pick->vars["status"] = "Y";
if($_POST["stars"] == 2){
	$pick->vars["2and3star"] = "Y";
	$pick->vars["4and5star"] = "N";	
}else if($_POST["stars"] == 3){
	$pick->vars["2and3star"] = "N";
	$pick->vars["4and5star"] = "Y";
}
$pick->vars["chosen_id"] = "na";
$pick->vars["manual"] = "1";

$game_str = $game->vars["away_team"]->vars["name"] . " " . $game->vars["away_team"]->vars["nick"];
$game_str .= " vs ";
$game_str .= $game->vars["home_team"]->vars["name"] . " " . $game->vars["home_team"]->vars["nick"];

$pick->vars["4and5star_comment"] = $_POST["pick"];

$pick->vars["pick_date"] = date("Y-m-d H:i:s");

if($update){$pick->update();}
else{$pick->insert();}


if($_POST["stars"] == 3){
	send_pick_email($game, $pick->vars["4and5star_comment"], $game_str);
	send_pick_sms($pick->vars["4and5star_comment"], $game_str);
}

header("Location: ../../insert_pick_manual.php?gid=".$pick->vars["gameid"]."&e=60");
?>

<? }else{echo "Access Denied";} ?>

<?
function send_pick_email($game, $pick, $gamestr){
	$sub      = '3 Star Premium Pick ';
	$content  = '3 Star Premium Pick <br>';
	$content .= $gamestr.'<br><br />';
	$content .= nl2br($pick).'<br><br />';
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
	//send_email_ck("amcphail@vrbmarketing.com", $sub, $content, true,"support@inspin.com", "Inspin.com");		
	//send_email_ck("jpmasters@vrbmarketing.com", $sub, $content, true,"support@inspin.com", "Inspin.com");
	//send_email_ck("rarce@inspin.com", $sub, $content, true,"support@inspin.com", "Inspin.com");	
}
?>
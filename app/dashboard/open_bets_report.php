<? include(ROOT_PATH . "/process/login/security.php"); ?>
<? include(ROOT_PATH . "/dashboard/books_info.php"); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/style.css" rel="stylesheet" type="text/css" />
<title><? echo $book_name ?> Open Bets Report</title>
<link rel="stylesheet" type="text/css" media="all" href="../includes/calendar/jsDatePick_ltr.min.css" />
<link rel="stylesheet" href="<?= BASE_URL ?>/includes/shadowbox/shadowbox.css" type="text/css" media="screen" />
<script type="text/javascript" src="<?= BASE_URL ?>/includes/shadowbox/shadowbox.js"></script>
<script type="text/javascript">
Shadowbox.init();
</script>
<script type="text/javascript" src="../includes/calendar/jsDatePick.min.1.3.js"></script>
<script type="text/javascript">
	window.onload = function(){
		new JsDatePick({
			useMode:2,
			target:"from",
			dateFormat:"%Y-%m-%d"
		});
		new JsDatePick({
			useMode:2,
			target:"to",
			dateFormat:"%Y-%m-%d"
		});
	};
</script>
</head>
<body>
<? include "../includes/header.php" ?>
<? include "../includes/menu.php" ?>
<div class="page_content" style="padding-left:50px;">
<span class="page_title"><? echo $book_name ?> Open Bets Report</span><div style="float:right;" class="normal_link"><a href="<?= BASE_URL ?>/dashboard/reports.php?bk=<? echo $bookid ?>"><strong><< Back</strong></a></div><br /><br />
<?
$book = $bookid; //Book Id
$code = get_affiliate_code($current_affiliate->id, $book);
$agid = file_get_contents('http://www.sportsbettingonline.ag/utilities/process/reports/vrb_agent_id_by_name.php?aff='.$code);
$players = file_get_contents('http://www.sportsbettingonline.ag/utilities/process/reports/vrb_players_x_agent.php?agentid='.$agid.'&player_prefix='.$player_prefix);
$players = explode('/',$players);

$from = clean_str($_POST["from"]);
if($from == ""){$from = date("Y-m-d");}
$to = clean_str($_POST["to"]);
if($to == ""){$to = date("Y-m-d");}
$agentid = clean_str($_POST["agentid"]);
$idplayer = clean_str($_POST["player"]);
?>
<form method="post">
    From: 
    <input name="from" type="text" id="from" value="<? echo $from ?>" />
    &nbsp;&nbsp;&nbsp;&nbsp;
    To: 
    <input name="to" type="text" id="to" value="<? echo $to ?>" />
    &nbsp;&nbsp;&nbsp;&nbsp;
    Player: 
    <select name="player" id="player">      
      <option value="all" selected="selected">All</option>  
      <? 
	  for ($i = 0; $i < count($players); $i++) {
		 $player  =  explode(",",$players[$i]);
		 $player_account = $player[0];
		 $player_id = $player[1];
	  ?>
      <? if ($player_id == $idplayer) { ?>
   	  <option value="<? echo $player_id ?>" selected="selected"><? echo $player_account ?></option>  
	  <? } else { ?>
      <option value="<? echo $player_id ?>"><? echo $player_account ?></option>
      <? } ?>
    <? } ?>        
    </select>
    &nbsp;&nbsp;&nbsp;&nbsp;
    
    <input type="hidden" value="<? echo $agid ?>" name="agentid" id="agentid"  />          
    <input type="submit" value="Search" />
</form>
<br />
<? 
$data = "?agentid=$agentid&from=$from&to=$to&player_prefix=$player_prefix&player=$idplayer";
if ($_POST) {
  echo file_get_contents("http://www.sportsbettingonline.ag/utilities/process/reports/vrb_sbo_open_bets_report.php".$data);
}
?>
</div>
<? include "../includes/footer.php" ?>
<? set_time_limit(300); ?>
<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->im_allow("betting_basics")){ ?>
<?
if(isset($_GET["sport"])){$is_get = true;}else{$is_get = false;}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/style.css" rel="stylesheet" type="text/css" />
<title>VRB Betting</title>
<link rel="stylesheet" type="text/css" media="all" href="../includes/calendar/jsDatePick_ltr.min.css" />
<link rel="stylesheet" href="http://localhost:8080/includes/shadowbox/shadowbox.css" type="text/css" media="screen" />
<script type="text/javascript" src="http://localhost:8080/includes/shadowbox/shadowbox.js"></script>
<script type="text/javascript">
Shadowbox.init();
</script>
<script type="text/javascript" src="../includes/calendar/jsDatePick.min.1.3.js"></script>
<script type="text/javascript">
	window.onload = function(){
		new JsDatePick({
			useMode:2,
			target:"date",
			dateFormat:"%Y-%m-%d"
		});
	}; 
</script>
</head>
<body>
<? include "../includes/header.php" ?>
<? include "../includes/menu_ck.php" ?>
<? include "process/actions/inspin_sport_parser.php" ?>
<div class="page_content" style="padding-left:50px;" align="center">
<span class="page_title">VRB Betting Grading</span><br /><br />

<? include "includes/print_error.php" ?>

<?
$date = clean_get("date",$is_get);
if($date == ""){$date = date("Y-m-d",time()-86400);}
$period = clean_get("period",$is_get);
if($period == ""){$period = "Game";}
$sport = clean_get("sport",$is_get);
?>

<form method="post" action="betting_grading.php">
    Game Date: 
    <input name="date" type="text" id="date" value="<? echo $date ?>" readonly="readonly" />
    &nbsp;&nbsp;&nbsp;&nbsp;
    Sport: 
    <select name="sport" id="sport">
      <option value="">-Select-</option>
	  <? 
	  $sports = array("nfl","nba","nhl","mlb","ncaaf","ncaab","other"); 
	  foreach($sports as $sp){
			?><option value="<? echo $sp ?>" <? if($sp == $sport){echo 'selected="selected"';} ?>><? echo strtoupper($sp); ?></option><? 
	  }
	  ?>
    </select>
    &nbsp;&nbsp;&nbsp;&nbsp;
    Period: 
    <select name="period" id="period">
    <? 
	  $periods = get_all_periods();
	  foreach($periods as $pr){
			?><option value="<? echo $pr["sbo_name"] ?>" <? if($pr["sbo_name"] == $period){echo 'selected="selected"';} ?>><? echo $pr["name"]; ?></option><? 
	  }
	  ?>
    </select>
    &nbsp;&nbsp;&nbsp;&nbsp;
    <input type="submit" value="Search" />
</form>

<br />
<? 
if($sport == "other"){
	$games = get_other_sports_games($date);	
}else{
	$games = get_games($sport, $date, $date); 
}
?>

<? if(count($games)>0 && $sport != ""){ ?>

<form action="process/actions/grade_games_action.php"  method="post">
<input name="period" type="hidden" id="period" value="<? echo $period ?>" />
<input name="sport" type="hidden" id="sport" value="<? echo $sport ?>" />
<input name="date" type="hidden" id="date" value="<? echo $date ?>" />
<table width="500" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td class="table_header" align="center">Sport</td>
    <td class="table_header" align="center">Rotation #</td>
    <td class="table_header" align="center">Team</td>
    <td class="table_header" align="center">Score</td>
  </tr>

<?

$i=0;
foreach($games as $game){
    if($i % 2){$style = "1";}else{$style = "2";}
	$i++;
	$result = get_results($game->vars["id"], $period);
    ?>
    <tr>
    	<td class="table_td<? echo $style ?>" align="center"  rowspan="2"><? echo strtoupper($game->vars["sport"]); ?></td>
        <td class="table_td<? echo $style ?>" align="center"><? echo $game->vars["away_rotation"]; ?></td>
        <td class="table_td<? echo $style ?>" align="center"><? echo $game->vars["away_team"]->vars["name"]; ?></td>
        <td class="table_td<? echo $style ?>" align="center">
        	<input name="<? echo $game->vars["id"]; ?>_away" type="text" id="<? echo $game->vars["id"]; ?>_away" size="5" value="<? echo $result->vars["away_score"] ?>" />
        </td>
    </tr>
    <tr>
        <td class="table_td<? echo $style ?>" align="center"><? echo $game->vars["home_rotation"]; ?></td>
        <td class="table_td<? echo $style ?>" align="center"><? echo $game->vars["home_team"]->vars["name"]; ?></td>
        <td class="table_td<? echo $style ?>" align="center">
        	<input name="<? echo $game->vars["id"]; ?>_home" type="text" id="<? echo $game->vars["id"]; ?>_home" size="5" value="<? echo $result->vars["home_score"] ?>" />
        </td>
    </tr>	
    <tr>
      <td class="table_last"></td>
      <td class="table_last"></td>
      <td class="table_last"></td>
      <td class="table_last"></td>
      <td class="table_last"></td>
      <td class="table_last"></td>    
    </tr>
    <?
}
?>

</table>
<br /><br />
<input name="" type="submit" value="Submit" />

</form>

<? }else{echo "No games available";} ?>

</div>
<? include "../includes/footer.php" ?>
<? }else{echo "Access Denied";} ?>
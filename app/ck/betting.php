<? set_time_limit(300); ?>
<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->im_allow("betting_basics")){ ?>

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
	function open_bets(line, game, gid){
		Shadowbox.init({
			players:  [ 'iframe'] 
		});
		Shadowbox.open({
			player:     'iframe',
			title:      "",
			content:    "insert_bet.php?line="+line+"&game="+game+"&gid="+gid,
			height:     435,
			width:      470
		});
	}; 
</script>
<style type="text/css">
.input_line{
	width:80px;
	text-align:center;
	cursor:pointer;
}
</style>
</head>
<body>
<? include "../includes/header.php" ?>
<? include "../includes/menu_ck.php" ?>
<? include "process/actions/inspin_sport_parser.php" ?>
<div class="page_content" style="padding-left:20px;">
<span class="page_title">VRB Betting</span><br /><br />

<? include "includes/print_error.php" ?>

<?
$current_identifier = clean_get("betting_identifiers_list");
$date = clean_get("date");
if($date == ""){$date = date("Y-m-d");}
$period = clean_get("period");
if($period == ""){$period = "Game";}else if($period == "Team Totals"){$team_totals = true;}
$sport = clean_get("sport");
?>

<form method="post" id="game_search">
    Game Date: 
    <input name="date" type="text" id="date" value="<? echo $date ?>" readonly="readonly" />
    &nbsp;&nbsp;&nbsp;
    Sport: 
    <select name="sport" id="sport">
      <option value="">-Select-</option>
	  <? 
	  $sports = array("nfl","nba","nhl","mlb","xfl","ncaaf","ncaab","other"); 
	  foreach($sports as $sp){
			?><option value="<? echo $sp ?>" <? if($sp == $sport){echo 'selected="selected"';} ?>><? echo strtoupper($sp); ?></option><? 
	  }
	  ?>
    </select>
    &nbsp;&nbsp;&nbsp;
    Period: 
    <select name="period" id="period">
    <? 
	  $periods = get_all_periods();
	  foreach($periods as $pr){
			?><option value="<? echo $pr["sbo_name"] ?>" <? if($pr["sbo_name"] == $period){echo 'selected="selected"';} ?>><? echo $pr["name"]; ?></option><? 
	  }
	  ?>
    </select>
    &nbsp;&nbsp;&nbsp;
    <input type="submit" value="Search" />
    <br /><br />
    Filter By Identifier:
    <? $all_option = true; include("includes/betting_identifiers_list.php") ?>
    &nbsp;&nbsp;&nbsp;
    <input type="submit" value="Filter" />
</form>

<br />
<? 

if($sport != ""){

if($sport == "other"){
	$games = get_other_sports_games($date);	
	?>
    <a href="insert_other_game.php" class="normal_link" rel="shadowbox;height=450;width=475" title="New Game (Other Sports)">
    	+ Insert Other Sport Game
    </a>
    <br /><br />
	<?
}else{
	$football_sports = array("nfl","ncaaf");
	if(in_array($sport,$football_sports)){
		//$todate = date("Y-m-d",strtotime($date)+691200);
		$todate = get_monday($date,"Y-m-d",true);
	}else{$todate = $date;}
	$games = get_games($sport, $date, $todate); 

}
?>



<? //if(count($games)>0){ ?>

<? if(!empty($games)){ ?>

<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>    
    <td class="table_header" align="center">Rotation #</td>
    <td class="table_header" align="center">Team</td>
    <td class="table_header" align="center"></td>
    <? if($team_totals){ ?>
    <td class="table_header" align="center">Over</td>
    <td class="table_header" align="center">Under</td>
    <? }else{ ?>
    <td class="table_header" align="center">Spread</td>
    <td class="table_header" align="center">Money</td>
    <td class="table_header" align="center">Total</td>
    <? } ?>
  </tr>

<?
$lines = get_sport_lines($date, $sport, $period);

//echo "<pre>";
//print_r($lines);
//echo "</pre>";

$i=0;
foreach($games as $game){
    if($i % 2){$style = "1";}else{$style = "2";}
	
    //WAS COMMENTED TO HIDE LINE DATA
    $line = $lines[$game->vars["away_rotation"]];
 
	$i++;
	$game_title = $game->vars["away_rotation"]."/".$game->vars["away_team"]->vars["name"]."/".$period."/".date("Y-m-d",strtotime($game->vars["date"]));
    ?>
    <tr>    	
        <td class="table_td<? echo $style ?>" align="center"><? echo $game->vars["away_rotation"]; ?></td>
        <td class="table_td<? echo $style ?>" align="center"><? echo $game->vars["away_team"]->vars["name"]; ?></td>
        <td class="table_td<? echo $style ?>" align="center"  rowspan="2">
       		<a href="insert_pick.php?gid=<? echo $game->vars["id"]; ?>&period=<? echo $period ?>" rel="shadowbox;height=370;width=575" class="normal_link">
            	<? if(has_pick($game->vars["id"],$period)){echo "<strong style='text-decoration:underline;'>Picks</strong>";}else{echo "Picks";} ?>
            </a><br />
            <a href="insert_pick_manual.php?gid=<? echo $game->vars["id"]; ?>" rel="shadowbox;height=450;width=420" class="normal_link">
            	<? if(has_pick($game->vars["id"],"Teaser") || has_pick($game->vars["id"],"Parlay")){
					echo "<strong style='text-decoration:underline;'>Manual</strong>";}else{echo "Manual";
				} ?>
            </a>
        </td>
        <? if(!$team_totals){ ?>
        <td class="table_td<? echo $style ?>" align="left">
        	<input onclick="open_bets('<? echo biencript($line->vars["away_spread"]); ?>','<? echo biencript($game_title."/spread/".$sport); ?>','<? echo $game->vars["id"]; ?>');" name="" type="text" value="<? echo $line->vars["away_spread"]; ?>" readonly="readonly" class="input_line" />
            &nbsp;&nbsp;
            <? $key = biencript($game->vars["id"]."/".$game->vars["away_team"]->vars["name"]."/spread"); ?>
            <a href="bet_money_details.php?gid=<? echo $game->vars["id"]; ?>&period=<? echo $period ?>&team=<? echo $game->vars["away_team"]->vars["name"] ?>&type=spread&idef=<? echo $current_identifier ?>" class="normal_link"  rel="shadowbox;height=450;width=575" title="Details">
            	$<span id="m_<? echo $key ?>">
				<? echo $game->get_bet_total_money($period, $game->vars["away_team"]->vars["name"], "spread", $current_identifier); ?>
                </span>
            </a>
        </td>        
        <td class="table_td<? echo $style ?>" align="left">
        	<input onclick="open_bets('<? echo biencript($line->vars["away_money"]); ?>','<? echo biencript($game_title."/money/".$sport); ?>','<? echo $game->vars["id"]; ?>');" name="" type="text" value="<? echo $line->vars["away_money"]; ?>" readonly="readonly" class="input_line" />
            &nbsp;&nbsp;
            <? $key = biencript($game->vars["id"]."/".$game->vars["away_team"]->vars["name"]."/money"); ?>
            <a href="bet_money_details.php?gid=<? echo $game->vars["id"]; ?>&period=<? echo $period ?>&team=<? echo $game->vars["away_team"]->vars["name"] ?>&type=money&idef=<? echo $current_identifier ?>" class="normal_link"  rel="shadowbox;height=450;width=575" title="Details">
            	$<span id="m_<? echo $key ?>">
				<? echo $game->get_bet_total_money($period, $game->vars["away_team"]->vars["name"], "money", $current_identifier); ?>
                </span>
            </a>
        </td>
        <td class="table_td<? echo $style ?>" align="left">
        	<input onclick="open_bets('<? echo biencript($line->vars["away_total"]); ?>','<? echo biencript($game_title."/total/".$sport); ?>','<? echo $game->vars["id"]; ?>');" name="" type="text" value="<? echo $line->vars["away_total"]; ?>" readonly="readonly" class="input_line" />
            &nbsp;&nbsp;
            <? $key = biencript($game->vars["id"]."/".$game->vars["away_team"]->vars["name"]."/total"); ?>
            <a href="bet_money_details.php?gid=<? echo $game->vars["id"]; ?>&period=<? echo $period ?>&team=<? echo $game->vars["away_team"]->vars["name"] ?>&type=total&idef=<? echo $current_identifier ?>" class="normal_link"  rel="shadowbox;height=450;width=575" title="Details">
            	$<span id="m_<? echo $key ?>">
				<? echo $game->get_bet_total_money($period, $game->vars["away_team"]->vars["name"], "total", $current_identifier); ?>
                </span>
            </a>
        </td>
        <? }else{ ?>
        <td class="table_td<? echo $style ?>" align="left">
        	<input onclick="open_bets('<? echo biencript($line->vars["away_total"]); ?>','<? echo biencript($game_title."/over_team_totals/".$sport); ?>','<? echo $game->vars["id"]; ?>');" name="" type="text" value="<? echo $line->vars["away_total"]; ?>" readonly="readonly" class="input_line" />
            &nbsp;&nbsp;
            <? $key = biencript($game->vars["id"]."/".$game->vars["away_team"]->vars["name"]."/over_team_totals"); ?>
            <a href="bet_money_details.php?gid=<? echo $game->vars["id"]; ?>&period=<? echo $period ?>&team=<? echo $game->vars["away_team"]->vars["name"] ?>&type=over_team_totals&idef=<? echo $current_identifier ?>" class="normal_link"  rel="shadowbox;height=450;width=575" title="Details">
            	$<span id="m_<? echo $key ?>">
				<? echo $game->get_bet_total_money($period, $game->vars["away_team"]->vars["name"], "over_team_totals", $current_identifier); ?>
                </span>
            </a>
        </td>
        <td class="table_td<? echo $style ?>" align="left">
        	<input onclick="open_bets('<? echo biencript($line->vars["home_total"]); ?>','<? echo biencript($game_title."/under_team_total/".$sport); ?>','<? echo $game->vars["id"]; ?>');" name="" type="text" value="<? echo $line->vars["home_total"]; ?>" readonly="readonly" class="input_line" />
            &nbsp;&nbsp;
            <? $key = biencript($game->vars["id"]."/".$game->vars["away_team"]->vars["name"]."/under_team_totals"); ?>
            <a href="bet_money_details.php?gid=<? echo $game->vars["id"]; ?>&period=<? echo $period ?>&team=<? echo $game->vars["away_team"]->vars["name"] ?>&type=under_team_totals&idef=<? echo $current_identifier ?>" class="normal_link"  rel="shadowbox;height=450;width=575" title="Details">
            	$<span id="m_<? echo $key ?>">
				<? echo $game->get_bet_total_money($period, $game->vars["away_team"]->vars["name"], "under_team_totals", $current_identifier); ?>
                </span>
            </a>
        </td>
        <? } ?>
    </tr>
    <? $game_title = $game->vars["home_rotation"]."/".$game->vars["home_team"]->vars["name"]."/".$period."/".date("Y-m-d",strtotime($game->vars["date"])); ?>
    <? // if($team_totals){  $line = $lines[$game->vars["home_rotation"]];} //WAS COMMENTED TO HIDE LINE DATA ?>
    <tr>
        <td class="table_td<? echo $style ?>" align="center"><? echo $game->vars["home_rotation"]; ?></td>
        <td class="table_td<? echo $style ?>" align="center"><? echo $game->vars["home_team"]->vars["name"]; ?></td>
        <? if(!$team_totals){ ?>
        <td class="table_td<? echo $style ?>" align="left">
        	<input onclick="open_bets('<? echo biencript($line->vars["home_spread"]); ?>','<? echo biencript($game_title."/spread"."/".$sport); ?>','<? echo $game->vars["id"]; ?>');" name="" type="text" value="<? echo $line->vars["home_spread"]; ?>" readonly="readonly" class="input_line" />
            &nbsp;&nbsp;
            <? $key = biencript($game->vars["id"]."/".$game->vars["home_team"]->vars["name"]."/spread"); ?>
            <a href="bet_money_details.php?gid=<? echo $game->vars["id"]; ?>&period=<? echo $period ?>&team=<? echo $game->vars["home_team"]->vars["name"] ?>&type=spread&idef=<? echo $current_identifier ?>" class="normal_link"  rel="shadowbox;height=450;width=575" title="Details">
            	$<span id="m_<? echo $key ?>">
				<? echo $game->get_bet_total_money($period, $game->vars["home_team"]->vars["name"], "spread", $current_identifier); ?>
                </span>
            </a>
        </td>        
        <td class="table_td<? echo $style ?>" align="left">
        	<input onclick="open_bets('<? echo biencript($line->vars["home_money"]); ?>','<? echo biencript($game_title."/money"."/".$sport); ?>','<? echo $game->vars["id"]; ?>');" name="" type="text" value="<? echo $line->vars["home_money"]; ?>" readonly="readonly" class="input_line" />
            &nbsp;&nbsp;
            <? $key = biencript($game->vars["id"]."/".$game->vars["home_team"]->vars["name"]."/money"); ?>
            <a href="bet_money_details.php?gid=<? echo $game->vars["id"]; ?>&period=<? echo $period ?>&team=<? echo $game->vars["home_team"]->vars["name"] ?>&type=money&idef=<? echo $current_identifier ?>" class="normal_link"  rel="shadowbox;height=450;width=575" title="Details">
            	$<span id="m_<? echo $key ?>">
				<? echo $game->get_bet_total_money($period, $game->vars["home_team"]->vars["name"], "money", $current_identifier); ?>
                </span>
            </a>
        </td>
        <td class="table_td<? echo $style ?>" align="left">
        	<input onclick="open_bets('<? echo biencript($line->vars["home_total"]); ?>','<? echo biencript($game_title."/total/".$sport); ?>','<? echo $game->vars["id"]; ?>');" name="" type="text" value="<? echo $line->vars["home_total"]; ?>" readonly="readonly" class="input_line" />
            &nbsp;&nbsp;
            <? $key = biencript($game->vars["id"]."/".$game->vars["home_team"]->vars["name"]."/total"); ?>
            <a href="bet_money_details.php?gid=<? echo $game->vars["id"]; ?>&period=<? echo $period ?>&team=<? echo $game->vars["home_team"]->vars["name"] ?>&type=total&idef=<? echo $current_identifier ?>" class="normal_link"  rel="shadowbox;height=450;width=575" title="Details">
            	$<span id="m_<? echo $key ?>">
				<? echo $game->get_bet_total_money($period, $game->vars["home_team"]->vars["name"], "total", $current_identifier); ?>
                </span>
            </a>
        </td>
        <? }else{ ?>
        <td class="table_td<? echo $style ?>" align="left">
        	<input onclick="open_bets('<? echo biencript($line->vars["away_total"]); ?>','<? echo biencript($game_title."/over_team_totals"."/".$sport); ?>','<? echo $game->vars["id"]; ?>');" name="" type="text" value="<? echo $line->vars["away_total"]; ?>" readonly="readonly" class="input_line" />
            &nbsp;&nbsp;
            <? $key = biencript($game->vars["id"]."/".$game->vars["home_team"]->vars["name"]."/over_team_totals"); ?>
            <a href="bet_money_details.php?gid=<? echo $game->vars["id"]; ?>&period=<? echo $period ?>&team=<? echo $game->vars["home_team"]->vars["name"] ?>&type=over_team_totals&idef=<? echo $current_identifier ?>" class="normal_link"  rel="shadowbox;height=450;width=575" title="Details">
            	$<span id="m_<? echo $key ?>">
				<? echo $game->get_bet_total_money($period, $game->vars["home_team"]->vars["name"], "over_team_totals", $current_identifier); ?>
                </span>
            </a>
        </td>
        <td class="table_td<? echo $style ?>" align="left">
        	<input onclick="open_bets('<? echo biencript($line->vars["home_total"]); ?>','<? echo biencript($game_title."/under_team_totals/".$sport); ?>','<? echo $game->vars["id"]; ?>');" name="" type="text" value="<? echo $line->vars["home_total"]; ?>" readonly="readonly" class="input_line" />
            &nbsp;&nbsp;
            <? $key = biencript($game->vars["id"]."/".$game->vars["home_team"]->vars["name"]."/under_team_totals"); ?>
            <a href="bet_money_details.php?gid=<? echo $game->vars["id"]; ?>&period=<? echo $period ?>&team=<? echo $game->vars["home_team"]->vars["name"] ?>&type=under_team_totals&idef=<? echo $current_identifier ?>" class="normal_link"  rel="shadowbox;height=450;width=575" title="Details">
            	$<span id="m_<? echo $key ?>">
				<? echo $game->get_bet_total_money($period, $game->vars["home_team"]->vars["name"], "under_team_totals", $current_identifier); ?>
                </span>
            </a>
        </td>
        <? } ?>
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

<? }else{echo "No games available";} ?>

<? } ?>

</div>
<? include "../includes/footer.php" ?>
<? }else{echo "Access Denied";} ?>
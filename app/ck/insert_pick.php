<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? include "process/actions/inspin_sport_parser.php" ?>
<? if($current_clerk->im_allow("betting_basics")){ ?>
<?
$game = get_game($_GET["gid"]);
$period = $_GET["period"];
$pick = get_inspin_pick($_GET["gid"], $_GET["period"]);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/style.css" rel="stylesheet" type="text/css" />
</head>
<body style="background:#fff; padding:20px;">
<script type="text/javascript" src="includes/js/bets.js"></script>

<script type="text/javascript" src="../process/js/functions.js?v=2"></script>
<script type="text/javascript">
var validations1 = new Array();
validations1.push({id:"team1",type:"null", msg:"Please Select a Team"});
validations1.push({id:"line1",type:"null", msg:"Please write a line"});

var validations2 = new Array();
validations2.push({id:"line2",type:"null", msg:"Please write a line"});

function prevalidate(val1, val2){
	var res = validate(val1);
	if(res && document.getElementById("team2").value != ""){
		res = validate(val2);
	}
	return res;
}

</script>
<span class="page_title">Game Picks</span><br /><br />
<div class="form_box">
<? include "includes/print_error.php" ?>

<? if(!is_null($pick)) { ?>
  <form method="post" onsubmit="return prevalidate(validations1, validations2)" action="process/actions/add_pick_action.php">
	<input name="gameid" type="hidden" id="gameid" value="<? echo $game->vars["id"] ?>" />
    <input name="period" type="hidden" id="period" value="<? echo $period ?>" />
	<table width="100%" border="0" cellspacing="0" cellpadding="10">          
	  <tr>
	    <td>
        <? $stars = $pick->get_stars(); ?>
        <select name="stars" id="stars">
          <option value="3" <? if($stars == "3"){echo ' selected="selected"';} ?>>3 Stars</option>
          <option value="2" <? if($stars == "2"){echo ' selected="selected"';} ?>>2 Stars</option>
        </select>
        </td>
	    <td colspan="3" align="right">
            <a href="process/actions/clear_pick_action.php?gid=<? echo $game->vars["id"] ?>&p=<? echo $period ?>" class="normal_link">
                Delete this Picks
            </a>
        </td>
      </tr>
      <tr>
	    <td colspan="2"><strong>Pick 1</strong></td>
	    <td colspan="2"><strong>Pick 2</strong></td>
      </tr>
	  <tr>
		<td>Team:</td>
		<td>
			<select name="team1" id="team1">
              <option value="">-- Select --</option>
			  <option value="<? echo $game->vars["away_team"]->vars["id"] ?>" <? if($pick->vars["chosen_id"] == $game->vars["away_team"]->vars["id"]){echo ' selected="selected"';} ?>><? 
			  echo $game->vars["away_team"]->vars["name"] . " " . $game->vars["away_team"]->vars["nick"] 
			  ?></option>
              <option value="<? echo $game->vars["home_team"]->vars["id"] ?>" <? if($pick->vars["chosen_id"] == $game->vars["home_team"]->vars["id"]){echo ' selected="selected"';} ?>><? 
			  echo $game->vars["home_team"]->vars["name"] . " " . $game->vars["home_team"]->vars["nick"] 
			  ?></option>
              <option value="Over" <? if($pick->vars["chosen_id"] == "Over"){echo ' selected="selected"';} ?>>Over</option>
              <option value="Under" <? if($pick->vars["chosen_id"] == "Under"){echo ' selected="selected"';} ?>>Under</option>
			</select>
		</td>
		<td>Team:</td>
		<td>
        	<select name="team2" id="team2">
              <option value="">-- Select --</option>
			  <option value="<? echo $game->vars["away_team"]->vars["id"] ?>" <? if($pick->vars["chosen_id_2"] == $game->vars["away_team"]->vars["id"]){echo ' selected="selected"';} ?>><? 
			  echo $game->vars["away_team"]->vars["name"] . " " . $game->vars["away_team"]->vars["nick"] 
			  ?></option>
              <option value="<? echo $game->vars["home_team"]->vars["id"] ?>" <? if($pick->vars["chosen_id_2"] == $game->vars["home_team"]->vars["id"]){echo ' selected="selected"';} ?>><? 
			  echo $game->vars["home_team"]->vars["name"] . " " . $game->vars["home_team"]->vars["nick"] 
			  ?></option>
              <option value="Over" <? if($pick->vars["chosen_id_2"] == "Over"){echo ' selected="selected"';} ?>>Over</option>
              <option value="Under" <? if($pick->vars["chosen_id_2"] == "Under"){echo ' selected="selected"';} ?>>Under</option>
			</select>
        </td>
	  </tr>
      <tr>
		<td>Line:</td>
		<td>
			<input name="line1" type="text" id="line1" value="<? echo $pick->vars["line"] ?>" />
		</td>
		<td>Line:</td>
		<td><input name="line2" type="text" id="line2" value="<? echo $pick->vars["line2"] ?>" /></td>
	  </tr>
      <? if($pick->is_graded()){ ?>
      <tr>
		<td><strong><? echo $pick->str_result($pick->vars["win"]) ?></strong></td>
        <td><strong><? echo $pick->vars["juice"]/100 ?> Units</strong></td>
        <td><strong><? echo $pick->str_result($pick->vars["win_2"]) ?></strong></td>		
		<td><strong><? echo $pick->vars["juice2"]/100 ?> Units</strong></td>		
	  </tr>
	  <? } ?>
	  <tr>    
		<td colspan="4"><input type="image" src="../images/temp/submit.jpg" /></td>
	  </tr>
    </table>
  </form>
<? } else { ?>
    <h1>There are not Picks for this game</h1>
<? } ?>	
</div>
</body>
</html>
<? }else{echo "Access Denied";} ?>
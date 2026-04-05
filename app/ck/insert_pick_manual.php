<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? include "process/actions/inspin_sport_parser.php" ?>
<? if($current_clerk->im_allow("betting_basics")){ ?>
<?
$game = get_game($_GET["gid"]);
$period = "manual";
$picks = get_inspin_manual_picks($game->vars["id"]);
if(isset($_GET["pid"])){
	$pick = get_inspin_pick_by_id($_GET["pid"]);
	$edit = true;
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/style.css" rel="stylesheet" type="text/css" />
</head>
<body style="background:#fff; padding:20px;">
<script type="text/javascript" src="includes/js/bets.js"></script>

<script type="text/javascript" src="../process/js/functions.js"></script>
<script type="text/javascript">
var validations = new Array();
validations.push({id:"pick",type:"null", msg:"Please write the pick"});


</script>
<span class="page_title">Manual Picks</span><br /><br />

<? if(!$edit && count($picks)>0){ ?>
<div class="form_box">
	<table width="100%" border="0" cellspacing="0" cellpadding="5">
      <? foreach($picks as $lpick){ ?>
      <tr>
        <td><? echo nl2br($lpick->vars["4and5star_comment"]) ?></td>
        <td><? if($lpick->is_graded()){ echo $lpick->str_result($lpick->vars["win"]) . " " . $lpick->vars["juice"]/100 ." Units"; } ?></td>
        <td><a href="insert_pick_manual.php?gid=<? echo $game->vars["id"] ?>&pid=<? echo $lpick->vars["id"] ?>" class="normal_link">Edit</a></td>
        <td>
    		<a href="process/actions/clear_pick_action.php?pid=<? echo $lpick->vars["id"] ?>&manual=1" class="normal_link">
            	Delete
            </a>
        </td>
      </tr>
      <? } ?>
    </table>
</div>
<? } ?>

<div class="form_box">
<? include "includes/print_error.php" ?>
  <form method="post" onsubmit="return validate(validations)" action="process/actions/add_pick_manual_action.php">
	<input name="gameid" type="hidden" id="gameid" value="<? echo $game->vars["id"] ?>" />
    <? if($edit){ ?><input name="pid" type="hidden" id="pid" value="<? echo $pick->vars["id"] ?>" /><? } ?>
	<table width="100%" border="0" cellspacing="0" cellpadding="10">          
	  <tr>
	    <td colspan="2"><strong>New Manual Pick</strong></td>
      </tr>
	  <tr>
	    <td>
        <? if(!is_null($pick)){$stars = $pick->get_stars();} ?>
        <select name="stars" id="stars">
          <option value="3" <? if($stars == "3"){echo ' selected="selected"';} ?>>3 Stars</option>
          <option value="2" <? if($stars == "2"){echo ' selected="selected"';} ?>>2 Stars</option>
        </select>        
        </td>
	    <td align="right">&nbsp;</td>
      </tr>
      <tr>
        <td>Type:</td>
        <td><select name="period" id="period">
          <option value="Teaser">Teaser</option>
          <option value="Parlay">Parlay</option>
        </select></td>
      </tr>
      <tr>
	    <td>Pick : </td>
	    <td>
        	<textarea name="pick" rows="5" id="pick"><? echo $pick->vars["4and5star_comment"]?></textarea>
        </td>
      </tr>
	  <tr>    
		<td colspan="2"><input type="image" src="../images/temp/submit.jpg" /></td>
	  </tr>
    </table>
  </form>
</div>
</body>
</html>
<? }else{echo "Access Denied";} ?>
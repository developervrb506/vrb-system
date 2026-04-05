<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->im_allow("betting_basics")){ ?>

<? include "process/actions/inspin_sport_parser.php" ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/style.css" rel="stylesheet" type="text/css" />
</head>
<body style="background:#fff; padding:20px;">
<script type="text/javascript" src="includes/js/bets.js"></script>
<strong>Money By Line</strong>
<table width="100%" border="0" cellpadding="0" cellspacing="0">
    <tr>
      <td class="table_header">Line</td>
      <td class="table_header">Total</td>
    </tr>
<?
$game = new _inspin_game();
$game->vars["id"] = $_GET["gid"];
$totals = $game->get_bet_total_details($_GET["period"], $_GET["team"], $_GET["type"], $_GET["idef"]);

$lines = array_keys($totals);
$i=0;
$total = 0;
foreach($lines as $eline){
	$line = biencript($eline,true);
	$total += $totals[$eline];
	if($i % 2){$style = "1";}else{$style = "2";} $i++;
?>
	<tr>
      <td class="table_td<? echo $style ?>"><? echo $line; ?></td>
      <td class="table_td<? echo $style ?>">$<? echo $totals[$eline]; ?></td>
    </tr>
<? } ?>
	<? if($i % 2){$style = "1";}else{$style = "2";} ?>
	<tr>
      <td class="table_td<? echo $style ?>"><strong>Total:</strong></td>
      <td class="table_td<? echo $style ?>"><strong>$<? echo $total ?></strong></td>
    </tr>
	<tr>
      <td class="table_last"></td>
      <td class="table_last"></td>
    </tr>
</table>

<br /><br />

<strong>Bets List</strong>
<?
$bets = search_bet($_GET["gid"],$_GET["period"], $_GET["team"], $_GET["type"], $_GET["idef"]);
?>
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td class="table_header">Date</td>
    <td class="table_header">Acc.</td>
    <td class="table_header">Bet</td>
    <td class="table_header">Risk</td>
    <td class="table_header">Win</td>
    <td class="table_header"></td>
    <td class="table_header"></td>
  </tr>
  <? $i = 0 ?>
  <? foreach($bets as $bet){ ?>
  <? if($i % 2){$style = "1";}else{$style = "2";} $i++; ?>
  <tr>
 	<td class="table_td<? echo $style ?>"><? echo date("M jS",strtotime($bet->vars["bdate"])) ?></td>
    <td class="table_td<? echo $style ?>"><? echo $bet->vars["account"]->vars["name"] ?></td>
    <td class="table_td<? echo $style ?>"><? echo $bet->vars["team"] . " " . $bet->vars["line"] ?></td>    
    <td class="table_td<? echo $style ?>"><? echo $bet->vars["risk"] ?></td>
    <td class="table_td<? echo $style ?>"><? echo $bet->vars["win"] ?></td>
    <td class="table_td<? echo $style ?>" align="center">
      <a href="edit_bet.php?bid=<? echo $bet->vars["id"] ?>" class="normal_link">View</a>
    </td>
    <td class="table_td<? echo $style ?>" align="center">
      <form action="process/actions/delete_bet_action.php" method="post" id="del_frm_<? echo $bet->vars["id"] ?>">
          <input name="delid" type="hidden" id="delid" value="<? echo $bet->vars["id"] ?>" />
          <input name="curl" type="hidden" id="curl" value="<? echo ck_curl() ?>" />
      </form>
      <a href="javascript:;" onclick="delete_bet('<? echo $bet->vars["id"] ?>');" class="normal_link">Delete</a>
    </td>
  </tr>
  <? } ?>
  <tr>
    <td class="table_last"></td>
    <td class="table_last"></td>
    <td class="table_last"></td>
    <td class="table_last"></td>
    <td class="table_last"></td>
    <td class="table_last"></td>
    <td class="table_last"></td>   
  </tr>
</table>


</body>
</html>
<? }else{echo "Access Denied";} ?>
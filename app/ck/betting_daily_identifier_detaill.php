<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->im_allow("betting_basics")){ ?>
<?
$idf = get_betting_identifier($_GET["idf"]);
$from = $_GET["from"];
$to = $_GET["to"];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/style.css" rel="stylesheet" type="text/css" />
</head>
<body style="background:#fff; padding:20px;">

<span class="page_subtitle">&quot;<? echo $idf->vars["description"] ?>&quot; Details (<? echo $from ?> to <? echo $to ?>)</span><br /><br />

<? $bets = get_bets_by_identifier($idf->vars["id"], true, $from, $to); ?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
	<td class="table_header" align="center">Account</td>
    <td class="table_header" align="center">Placed</td>
	<td class="table_header">Desc</td>
	<td class="table_header" align="center">Risk</td>
	<td class="table_header" align="center">Win</td>
	<td class="table_header" align="center">Amount</td>
	<td class="table_header" align="center">Result</td>
  </tr>
  <?
  $i=0;
 foreach($bets as $bet){
	   if($i % 2){$style = "1";}else{$style = "2";}$i++;
  ?>
  <tr>
  	<td class="table_td<? echo $style ?>" align="center"><? echo $bet->vars["account"]->vars["name"]; ?></td>
    <td class="table_td<? echo $style ?>" align="center">
        <? echo date("Y-m-d",strtotime($bet->vars["place_date"])) ."<br />".date("g:iA",strtotime($bet->vars["place_date"])); ?>
    </td>
    <td class="table_td<? echo $style ?>"><? echo $bet->get_report_comment(); ?></td>
    <td class="table_td<? echo $style ?>" align="center"><? echo round($bet->vars["risk"]); ?></td>
    <td class="table_td<? echo $style ?>" align="center"><? echo round($bet->vars["win"]); ?></td>
    <td class="table_td<? echo $style ?>" align="center"><? echo echo_report_number(round($bet->get_result_amount())); ?></td>
    <td class="table_td<? echo $style ?>" align="center"><? echo $bet->str_status(); ?></td>
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
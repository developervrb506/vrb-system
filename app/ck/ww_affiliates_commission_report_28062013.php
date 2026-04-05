<? include(ROOT_PATH . "/ck/db/handler.php"); ?>
<? include(ROOT_PATH . "/process/functions.php"); ?>
<?
set_time_limit(300);
$from = $_GET["from"];
$to = $_GET["to"];
$saf = $_GET["saf"];
$agents = get_all_affiliates_by_brand(1);
?>

<table width="800" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td class="table_header">Affiliate</td>
    <td class="table_header">Code</td>
    <td class="table_header">Lifetime Players<br />(active):</td>
    <td class="table_header">New Players:</td>
    <td class="table_header">New Players <br />with Deposits:</td>
    <td class="table_header">Commission<br />Balance:</td>
  </tr>

<?
$i=0;
$xml_lines = "";
foreach($agents as $agent){
	if($i % 2){$style = "1";}else{$style = "2";} $i++;	
	if($saf == "" || $saf == $agent->vars["affiliatecode"]){
		$data = get_ww_comission_data($agent->vars["affiliatecode"], $from, $to);
		$balance = get_wagerweb_customer_balance($agent->vars["affiliatecode"]);
		$xml_lines .= $agent->full_name()." \t ".$data["affiliatecode"]." \t ".$data["active"]." \t ".$data["new"]." \t ".$data["new_deposits"]." \t $balance \t \n";		
		?>
  <tr title="<? echo $phone_name->vars["note"] ?>">
	<td class="table_td<? echo $style ?>"><? echo $agent->full_name() ?></td>
    <td class="table_td<? echo $style ?>"><? echo $agent->vars["affiliatecode"] ?></td>
	<td class="table_td<? echo $style ?>"><? echo $data["active"] ?></td>
	<td class="table_td<? echo $style ?>"><? echo $data["new"] ?></td>
	<td class="table_td<? echo $style ?>"><? echo $data["new_deposits"] ?></td>
	<td class="table_td<? echo $style ?>"><? echo $balance ?></td>
  </tr>
    <? } ?>
<? } ?>
    <tr>
      <td class="table_last" colspan="5"></td>
    </tr>

</table>
<form method="post" action="affiliates_comission_report_export.php" id="xml_form">
<input name="lines" type="hidden" id="lines" value="<? echo $xml_lines ?>">
</form>
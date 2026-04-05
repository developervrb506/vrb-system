<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<link href="../css/style.css" rel="stylesheet" type="text/css" />
<?
$lead = get_affiliate_lead($_GET["lid"]);
$calls = get_lead_contact_history($lead->vars["id"]);
$statuses = get_all_afleads_status();
$dispositions = get_all_afleads_dispositions();
$owners = get_all_afleads_owners();
?>
<style type="text/css">
body {
	background-color: #FFF;
	margin-left: 10px;
	margin-top: 10px;
	margin-right: 10px;
	margin-bottom: 10px;
}
</style>


<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
  	<td class="table_header" align="center">Call Id</td>
    <td class="table_header" align="center">Clerk</td>
    <td class="table_header" align="center">Status</td>
    <td class="table_header" align="center">Disposition</td>
    <td class="table_header" align="center">Date</td>
  </tr>
  
  <? foreach($calls as $call){if($i % 2){
	  $style = "1";}else{$style = "2";} $i++;
	  
  ?>
  
  <tr>
    <td class="table_td<? echo $style ?>" align="center"><? echo $call->vars["id"]; ?></td>
	<td class="table_td<? echo $style ?>" align="center"><? echo $owners[$call->vars["owner"]]["name"]; ?></td>
    <td class="table_td<? echo $style ?>" align="center"><? echo $statuses[$call->vars["status"]]["name"]; ?></td>
    <td class="table_td<? echo $style ?>" align="center"><? echo $dispositions[$call->vars["disposition"]]["label"]; ?></td>
    <td class="table_td<? echo $style ?>" align="center"><? echo $call->vars["cdate"]; ?></td>
  </tr>
  
  <? } ?>
  <tr>
    <td class="table_last" colspan="100"></td>
  </tr>
</table>
<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<link href="../css/style.css" rel="stylesheet" type="text/css" />
<?
$transactions = get_transactions_by_clerk(clean_get("cid",true));
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
    <td class="table_header">Transaction Id</td>
    <td class="table_header">Type</td>
    <td class="table_header">Date</td>
    <td class="table_header">Amount</td>
    <td class="table_header">Details</td>
  </tr>

<?
$i=0;
foreach($transactions as $trans){
    if($i % 2){$style = "1";}else{$style = "2";}
	$i++;
	if($trans->vars["amount"] > 0){
    ?>
    <tr>
        <td class="table_td<? echo $style ?>"><? echo $trans->vars["id"]; ?></td>
        <td class="table_td<? echo $style ?>"><? echo $trans->str_type(); ?></td>
        <td class="table_td<? echo $style ?>"><? echo date("M jS, Y",strtotime($trans->vars["transaction_date"])); ?></td>
        <td class="table_td<? echo $style ?>">$<? echo round($trans->vars["amount"],2); ?></td>
        <td class="table_td<? echo $style ?>">
        	<a class="normal_link" href="transaction_detail.php?tid=<? echo $trans->vars["id"]; ?>&sb=<? echo clean_get("cid",true); ?>">View</a>
        </td>
     </tr>	
    <?
	}
}
?>
    <tr>
      <td class="table_last"></td>
      <td class="table_last"></td>
      <td class="table_last"></td>
      <td class="table_last"></td>
      <td class="table_last"></td>
    </tr>

</table>
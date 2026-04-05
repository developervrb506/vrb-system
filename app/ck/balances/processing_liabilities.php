<?
include_once("./ck/process/security.php");
$customers = explode(",",file_get_contents("https://www.ezpay.com/wu/balances_api/customers_balances.php"));
$adjusted_balances = get_adjusted_balances("l","processing");
?>


<tr>
  <td class="table_header">Processing</td>
  <td class="table_header" align="center">Balance</td>
  <td class="table_header" align="center">Adjusted</td>
</tr>
<?
$i=0;
$sub = 0;
$asub = 0;
foreach($customers as $cs){
	$customer = explode("/",$cs);
	if($i % 2){$style = "1";}else{$style = "2";} $i++;
	$sub += $customer[1];
	$adj = $adjusted_balances[$customer[0]]->vars["balance"];
	if(is_null($adj)){$adj = $customer[1];}else{$adj = $customer[1] - $adj;}
	$asub += $adj;
?>
<tr>
  <td class="table_td<? echo $style ?>"><? echo $customer[0] ?></td>
  <td class="table_td<? echo $style ?>" align="center"><? echo basic_number_format($customer[1]) ?></td>
  <td class="table_td<? echo $style ?>" align="center" title="<? echo $adjusted_balances[$customer[0]]->vars["note"] ?>">
  	<a href="adjust_balance.php?t=l&s=processing&a=<? echo $customer[0] ?>" class="normal_link" rel="shadowbox;height=310;width=400">
		<? echo basic_number_format($adj) ?>
    </a>
  </td>
</tr>
<? } ?>
<tr>
  <td class="table_td_important" align="center">Subtotal</td>
  <td class="table_td_important" align="center"><? echo basic_number_format($sub) ?></td>
  <td class="table_td_important" align="center"><? echo basic_number_format($asub) ?></td>
</tr>
<? $total_lia += $sub; ?>
<? $adj_total_lia += $asub; ?>
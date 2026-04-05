<?
include_once("./ck/process/security.php");
$caccounts = get_all_credit_accounts();
$adjusted_balances = get_adjusted_balances("l","credit");
?>


<tr>
  <td class="table_header">Credit</td>
  <td class="table_header" align="center">Balance</td>
  <td class="table_header" align="center">Adjusted</td>
</tr>
<?
$i=0;
$sub = 0;
$asub = 0;
foreach($caccounts as $cacc){
	if($i % 2){$style = "1";}else{$style = "2";} $i++;
	$sub += $cacc->vars["balance"];
	$adj = $adjusted_balances[$cacc->vars["name"]]->vars["balance"];
	if(is_null($adj)){$adj = $cacc->vars["balance"];}else{$adj = $cacc->vars["balance"] - $adj;}
	$asub += $adj;
?>
<tr>
  <td class="table_td<? echo $style ?>"><? echo $cacc->vars["name"] ?></td>
  <td class="table_td<? echo $style ?>" align="center"><? echo basic_number_format($cacc->vars["balance"])  ?></td>
  <td class="table_td<? echo $style ?>" align="center" title="<? echo $adjusted_balances[$cacc->vars["name"]]->vars["note"] ?>">
  	<a href="adjust_balance.php?t=l&s=credit&a=<? echo $cacc->vars["name"] ?>" class="normal_link" rel="shadowbox;height=310;width=400">
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
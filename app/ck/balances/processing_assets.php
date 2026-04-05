<?
$processors = explode(",",file_get_contents("https://www.ezpay.com/wu/balances_api/processors_balances.php"));
$adjusted_balances = get_adjusted_balances("a","processing");
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
foreach($processors as $pr){
	$processor = explode("/",$pr);
	if($i % 2){$style = "1";}else{$style = "2";} $i++;
	$sub += $processor[1];
	$adj = $adjusted_balances[$processor[0]]->vars["balance"];
	if(is_null($adj)){$adj = $processor[1];}else{$adj = $processor[1] - $adj;}
	$asub += $adj;
?>
<tr>
  <td class="table_td<? echo $style ?>"><? echo $processor[0] ?></td>
  <td class="table_td<? echo $style ?>" align="center"><? echo basic_number_format($processor[1]) ?></td>
  <td class="table_td<? echo $style ?>" align="center" title="<? echo $adjusted_balances[$processor[0]]->vars["note"] ?>">
  	<a href="adjust_balance.php?t=a&s=processing&a=<? echo $processor[0] ?>" class="normal_link" rel="shadowbox;height=310;width=400">
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
<? $total_assets += $sub; ?>
<? $adj_total_assets += $asub; ?>
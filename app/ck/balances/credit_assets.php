<?
$caccounts = get_all_credit_accounts();
?>


<tr>
  <td class="table_header">Credit</td>
  <td class="table_header" align="center">Balance</td>
</tr>
<?
$i=0;
$sub = 0;
foreach($caccounts as $cacc){
	if($i % 2){$style = "1";}else{$style = "2";} $i++;
	$sub += $cacc->vars["balance"];
?>
<tr>
  <td class="table_td<? echo $style ?>"><? echo $cacc->vars["name"] ?></td>
  <td class="table_td<? echo $style ?>" align="center"><? echo basic_number_format($cacc->vars["balance"])  ?></td>
</tr>
<? } ?>
<tr>
  <td class="table_td_important" align="center">Subtotal</td>
  <td class="table_td_important" align="center"><? echo basic_number_format($sub) ?></td>
</tr>
<? $total_assets += $sub; ?>
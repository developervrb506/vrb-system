<? 
include_once("./ck/process/security.php");
set_time_limit(300); 
?>
<?
$methods = explode(",",file_get_contents("http://www.sportsbettingonline.ag/utilities/process/banking/balances_api.php"));
$adjusted_balances = get_adjusted_balances("a","banking");
?>


<tr>
  <td class="table_header">SBO Banking</td>
  <td class="table_header" align="center">Balance</td>
  <td class="table_header" align="center">Adjusted</td>
</tr>
<?
$i=0;
$sub = 0;
$asub = 0;
foreach($methods as $pr){
	$method = explode("/",$pr);
	if($i % 2){$style = "1";}else{$style = "2";} $i++;
	$sub += $method[1];
	$adj = $adjusted_balances[$method[0]]->vars["balance"];
	if(is_null($adj)){$adj = $method[1];}else{$adj = $method[1] - $adj;}
	$asub += $adj;
?>
<tr>
  <td class="table_td<? echo $style ?>"><? echo $method[0] ?></td>
  <td class="table_td<? echo $style ?>" align="center"><? echo basic_number_format($method[1]) ?></td>
  <td class="table_td<? echo $style ?>" align="center" title="<? echo $adjusted_balances[$method[0]]->vars["note"] ?>">
  	<a href="adjust_balance.php?t=a&s=banking&a=<? echo $method[0] ?>" class="normal_link" rel="shadowbox;height=310;width=400">
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
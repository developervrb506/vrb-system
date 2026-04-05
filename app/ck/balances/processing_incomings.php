<?
include_once("./ck/process/security.php");
//$processors = split(",",file_get_contents("https://www.ezpay.com/wu/balances_api/processors_vrb_fees.php?f=$from&t=$to"));
$processors = explode(",",file_get_contents("https://www.ezpay.com/wu/balances_api/processors_vrb_fees.php?f=$from&t=$to"));
?>


<tr>
  <td class="table_header">Processing</td>
  <td class="table_header" align="center">Balance</td>
</tr>
<?
$i=0;
$sub = 0;
foreach($processors as $pr){
	//$processor = split("/",$pr);
	$processor = explode("/",$pr);
	if($i % 2){$style = "1";}else{$style = "2";} $i++;
	$sub += $processor[1];
?>
<tr>
  <td class="table_td<? echo $style ?>"><? echo $processor[0] ?></td>
  <td class="table_td<? echo $style ?>" align="center"><? echo basic_number_format($processor[1]) ?></td>
</tr>
<? } ?>
<tr>
  <td class="table_td_important" align="center">Subtotal</td>
  <td class="table_td_important" align="center"><? echo basic_number_format($sub) ?></td>
</tr>
<? $total_in += $sub; ?>
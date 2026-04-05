<?
include_once("./ck/process/security.php");

$from = $_GET["from"];
if($from == ""){$from = date("Y-m-d");}
$to = $_GET["to"];
if($to == ""){$to = date("Y-m-d");}

$accounts = get_php_incomings($from, $to);
?>


<tr>
  <td class="table_header">PPH</td>
  <td class="table_header" align="center">Balance</td>
</tr>
<?
$i=0;
$sub = 0;
foreach($accounts as $acc){
	if($i % 2){$style = "1";}else{$style = "2";} $i++;
	$sub += $acc["total"];
?>
<tr>
  <td class="table_td<? echo $style ?>"><? echo $acc["name"] ?></td>
  <td class="table_td<? echo $style ?>" align="center"><? echo basic_number_format($acc["total"]) ?></td>
</tr>
<? } ?>
<tr>
  <td class="table_td_important" align="center">Subtotal</td>
  <td class="table_td_important" align="center"><? echo basic_number_format($sub) ?></td>
</tr>
<? $total_in += $sub; ?>
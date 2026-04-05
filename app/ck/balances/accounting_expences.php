<?
include_once("./ck/process/security.php");
$from = $_GET["from"];
if($from == ""){$from = date("Y-m-d");}
$to = $_GET["to"];
if($to == ""){$to = date("Y-m-d");}
$categories = get_is_expenses($from, $to);
?>


<tr>
  <td class="table_header"></td>
  <td class="table_header" align="center">Balance</td>
</tr>
<?
$i=0;
$sub = 0;
foreach($categories as $cat){
	if($i % 2){$style = "1";}else{$style = "2";} $i++;
	$balance = $cat["total"]*-1;
	$sub += $balance;
?>
<tr>
  <td class="table_td<? echo $style ?>"><? echo $cat["name"]; ?></td>
  <td class="table_td<? echo $style ?>" align="center"><? echo basic_number_format($balance) ?></td>
</tr>
<? } ?>
<tr>
  <td class="table_td_important" align="center">Subtotal</td>
  <td class="table_td_important" align="center"><? echo basic_number_format($sub) ?></td>
</tr>
<? $total_ex += $sub; ?>
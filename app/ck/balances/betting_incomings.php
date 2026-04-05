<?
include_once("./ck/process/security.php");
$from = $_GET["from"];
if($from == ""){$from = date("Y-m-d");}
$to = $_GET["to"];
if($to == ""){$to = date("Y-m-d");}
$agents = get_all_betting_agents();
?>


<tr>
  <td class="table_header">Betting</td>
  <td class="table_header" align="center">Balance</td>
</tr>
<?
$i=0;
$sub = 0;
foreach($agents as $age){
	if($i % 2){$style = "1";}else{$style = "2";} $i++;
	$balance = $age->get_bet_balance($from, $to);
	if($balance > 0){
	$sub += $balance;
?>
<tr>
  <td class="table_td<? echo $style ?>"><? echo $age->vars["name"] ?></td>
  <td class="table_td<? echo $style ?>" align="center"><? echo basic_number_format($balance) ?></td>
</tr>
	<? } ?>
<? } ?>
<tr>
  <td class="table_td_important" align="center">Subtotal</td>
  <td class="table_td_important" align="center"><? echo basic_number_format($sub) ?></td>
</tr>
<? $total_in += $sub; ?>
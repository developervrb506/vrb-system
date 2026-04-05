<?
include_once("./ck/process/security.php");
$accounts = get_all_betting_accounts_for_sheet();
$adjusted_balances = get_adjusted_balances("a","betting");
?>


<tr>
  <td class="table_header">Betting</td>
  <td class="table_header" align="center">Balance</td>
  <td class="table_header" align="center">Adjusted</td>
</tr>
<?
$i=0;
$sub = 0;
$asub = 0;
$current_bank = $accounts[0]->vars["bank"]->vars["name"];
$cb_desc = $accounts[0]->vars["bank"]->vars["description"];
$bk_balance = 0;
foreach($accounts as $acc){
	if($i % 2){$style = "1";}else{$style = "2";} $i++;
	if($current_bank != $acc->vars["bank"]->vars["name"]){
		$adj = $adjusted_balances[$current_bank]->vars["balance"];
		if(is_null($adj)){$adj = $bk_balance;}else{$adj = $bk_balance - $adj;}
		$asub += $adj;
		?>
        <tr>
          <td class="table_td<? echo $style ?>" title="<? echo $cb_desc ?>"><? echo $current_bank ?></td>
          <td class="table_td<? echo $style ?>" align="center"><? echo basic_number_format($bk_balance) ?></td>
          <td class="table_td<? echo $style ?>" align="center" title="<? echo $adjusted_balances[$current_bank]->vars["note"] ?>">
            <a href="adjust_balance.php?t=a&s=betting&a=<? echo $current_bank ?>" class="normal_link" rel="shadowbox;height=310;width=400">
                <? echo basic_number_format($adj) ?>
            </a>
          </td>
        </tr>
        <?
		$sub += $bk_balance;
		$bk_balance = $acc->current_balance();
		$current_bank = $acc->vars["bank"]->vars["name"];
		$cb_desc = $acc->vars["bank"]->vars["description"];
	}else{
		$bk_balance += $acc->current_balance();
	}
}
?>
<? if($i % 2){$style = "1";}else{$style = "2";} ?>
<? 
$sub += $bk_balance; 
$adj = $adjusted_balances[$current_bank]->vars["balance"];
if(is_null($adj)){$adj = $bk_balance;}else{$adj = $bk_balance - $adj;}
$asub += $adj;
?>
<tr>
  <td class="table_td<? echo $style ?>" title="<? echo $cb_desc ?>"><? echo $current_bank ?></td>
  <td class="table_td<? echo $style ?>" align="center"><? echo basic_number_format($bk_balance) ?></td>
  <td class="table_td<? echo $style ?>" align="center" title="<? echo $adjusted_balances[$current_bank]->vars["note"] ?>">
    <a href="adjust_balance.php?t=a&s=betting&a=<? echo $current_bank ?>" class="normal_link" rel="shadowbox;height=310;width=400">
        <? echo basic_number_format($adj) ?>
    </a>
  </td>
</tr>
<tr>
  <td class="table_td_important" align="center">Subtotal</td>
  <td class="table_td_important" align="center"><? echo basic_number_format($sub) ?></td>
  <td class="table_td_important" align="center"><? echo basic_number_format($asub) ?></td>
</tr>
<? $total_assets += $sub; ?>
<? $adj_total_assets += $asub; ?>
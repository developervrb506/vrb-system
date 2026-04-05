<?
include_once("./ck/process/security.php");
$caccounts = get_all_credit_accounts();
$adjusted_balances = get_adjusted_balances("l","expenses");
?>


<tr>
  <td class="table_header">expenses payable</td>
  <td class="table_header" align="center">Balance</td>
  <td class="table_header" align="center">Adjusted</td>
</tr>
<? 
$balance = get_unposted_balance();
$balance["total"] *= -1;
$adj = $adjusted_balances["Subtotal"]->vars["balance"];
if(is_null($adj)){$adj = $balance["total"];}else{$adj = $balance["total"] - $adj;}
?>

<tr>
  <td class="table_td_important" align="center">Subtotal</td>
  <td class="table_td_important" align="center"><? echo basic_number_format($balance["total"]) ?></td>
  <td class="table_td_important" align="center" title="<? echo $adjusted_balances["Subtotal"]->vars["note"] ?>">
  	<a href="adjust_balance.php?t=l&s=expenses&a=<? echo "Subtotal" ?>" class="normal_link" rel="shadowbox;height=310;width=400">
		<? echo basic_number_format($adj) ?>
    </a>
  </td>
</tr>
<? $total_lia += $balance["total"]; ?>
<? $adj_total_lia += $adj; ?>
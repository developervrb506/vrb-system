<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<link href="../css/style.css" rel="stylesheet" type="text/css" />
<style type="text/css">
body {
	background-color: #FFF;
	margin-left: 10px;
	margin-top: 10px;
	margin-right: 10px;
	margin-bottom: 10px;
}
</style>
<?
$transaction = get_clerk_transaction(clean_get("tid",true));
$name = get_ckname($transaction->vars["name"]);
$method = get_payment_method($name->vars["payment_method"]);
?>
<? if(isset($_GET["sb"])){ ?>
<a href="transaction_history.php?cid=<? echo $_GET["sb"] ?>" class="normal_link" style="font-size:12px">
	&lt;&lt; Back to Transaction List
</a>
<br />
<? } ?>

<strong>Transaction #<? echo $transaction->vars["id"] . " Details" ?></strong><br /><br />

<? if(!is_null($name)){ ?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td class="table_header">Account</td>
    <td class="table_header"><? echo $name->vars["acc_number"] ?></td>
  </tr>
  <tr>
    <td class="table_header">Method</td>
    <td class="table_header"><? echo $method["name"] ?></td>
  </tr>
  <tr>
    <td class="table_header">Deposit Amount</td>
    <td class="table_header">$<? echo round($name->vars["deposit_amount"],2) ?></td>
  </tr>  
  <tr>
    <td class="table_header">Commission %</td>
    <td class="table_header"><? echo $transaction->vars["current_percentage"] ?></td>
  </tr>
  <tr>
    <td class="table_header">Cap</td>
    <td class="table_header">$<? echo $transaction->vars["current_cap"] ?></td>
  </tr>
  <tr>
    <td class="table_header">Commission Amount</td>
    <td class="table_header">$<? echo round($transaction->vars["amount"],2) ?></td>
  </tr>
  <tr>
    <td class="table_header">Comments</td>
    <td class="table_header"><? echo $transaction->vars["comment"] ?></td>
  </tr>
</table>

<? }else{ ?>

<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td class="table_header">Type</td>
    <td class="table_header"><? echo $transaction->str_type()?></td>
  </tr>
  <tr>
    <td class="table_header">Comments</td>
    <td class="table_header"><? echo $transaction->vars["comment"] ?></td>
  </tr>
</table>

<? } ?>
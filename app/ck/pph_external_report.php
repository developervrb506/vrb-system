<?
include(ROOT_PATH . "/ck/db/handler.php");
?>

<?
$from = $_GET["from"];
if($from == ""){$from = date("Y-m-d",time()-604800);}
$to = $_GET["to"];
if($to == ""){$to = date("Y-m-d");}
$account = get_pph_account_by_name($_GET["acc"]);
?>
<link rel="stylesheet" type="text/css" media="all" href="../../includes/calendar/jsDatePick_ltr.min.css" />
<script type="text/javascript" src="../../includes/calendar/jsDatePick.min.1.3.js"></script>
<script type="text/javascript">
	window.onload = function(){
		new JsDatePick({
			useMode:2,
			target:"from",
			dateFormat:"%Y-%m-%d"
		});
		new JsDatePick({
			useMode:2,
			target:"to",
			dateFormat:"%Y-%m-%d"
		});
	};
</script>

<form method="post">
From: <input name="from" type="text" id="from" value="<? echo $from ?>" readonly="readonly" />
&nbsp;&nbsp;&nbsp;
To:<input name="to" type="text" id="to" value="<? echo $to ?>" readonly="readonly" />
&nbsp;&nbsp;&nbsp;
<input type="submit" value="Search" />
</form>

<div class="cashier_title">Billing</div>

    
<? include "includes/print_error.php" ?>    
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td class="table_header" align="center">id</td>
    <td class="table_header" align="center">phone<br />count</td>
    <td class="table_header" align="center">phone<br />price</td>
    <td class="table_header" align="center">phone<br />total</td>
    <td class="table_header" align="center">internet<br />count</td>
    <td class="table_header" align="center">internet<br />price</td>
    <td class="table_header" align="center">internet<br />total</td>
    <td class="table_header" align="center">Total</td>
    <td class="table_header" align="center">Date</td>
  </tr>
  <?
  $i=0;
   $trans = search_pph_bill($from,$to, $account->vars["id"]);
   foreach($trans as $tran){	   
       if($i % 2){$style = "1";}else{$style = "2";}
       $i++;
  ?>
  <tr title="<? echo $tran->vars["note"]; ?>">
    <td class="table_td<? echo $style ?>" align="center"><? echo $tran->vars["id"]; ?></td>
    <td class="table_td<? echo $style ?>" align="center"><? echo $tran->vars["phone_count"]; ?></td>
    <td class="table_td<? echo $style ?>" align="center"><? echo basic_number_format($tran->vars["phone_price"]); ?></td>
    <td class="table_td<? echo $style ?>" align="center"><? echo basic_number_format($tran->get_phone_total()); ?></td>
    <td class="table_td<? echo $style ?>" align="center"><? echo $tran->vars["internet_count"]; ?></td>
    <td class="table_td<? echo $style ?>" align="center"><? echo basic_number_format($tran->vars["internet_price"]); ?></td>
    <td class="table_td<? echo $style ?>" align="center"><? echo basic_number_format($tran->get_internet_total()); ?></td>
    <td class="table_td<? echo $style ?>" align="center"><? echo basic_number_format($tran->vars["total"]); ?></td>
    <td class="table_td<? echo $style ?>" align="center"><? echo $tran->vars["mdate"]; ?></td>
  </td>
  <? } ?>
  <tr>
    <td class="table_last"></td>
    <td class="table_last"></td>
    <td class="table_last"></td>
    <td class="table_last"></td>
    <td class="table_last"></td>
    <td class="table_last"></td>
    <td class="table_last"></td>
    <td class="table_last"></td>
    <td class="table_last"></td>
    <td class="table_last"></td>
  </tr>

</table>




<br /><br />
<div class="cashier_title">Transactions</div>
<? include "includes/print_error.php" ?>    
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td class="table_header" align="center">Id</td>
    <td class="table_header" align="center">From</td>
    <td class="table_header" align="center">To</td>
    <td class="table_header" align="center">Amount</td>
    <td class="table_header" align="center">Date</td>
    <td class="table_header" align="center">Note</td>
  </tr>
  <?
  $i=0;
   $trans = search_pph_transaction($from,$to, $account->vars["id"]);
   foreach($trans as $tran){	   
       if($i % 2){$style = "1";}else{$style = "2";}
       $i++;
  ?>
  <tr>
    <td class="table_td<? echo $style ?>" align="center"><? echo $tran->vars["id"]; ?></td>
    <td class="table_td<? echo $style ?>" align="center"><? echo $tran->vars["from_account"]->vars["name"]; ?></td>
    <td class="table_td<? echo $style ?>" align="center"><? echo $tran->vars["to_account"]->vars["name"]; ?></td>
    <td class="table_td<? echo $style ?>" align="center"><? echo $tran->vars["amount"]; ?></td>
    <td class="table_td<? echo $style ?>" align="center"><? echo $tran->vars["tdate"]; ?></td>
    <td class="table_td<? echo $style ?>" align="center"><? echo nl2br($tran->vars["note"]); ?></td>
  </td>
  <? } ?>
  <tr>
    <td class="table_last"></td>
    <td class="table_last"></td>
    <td class="table_last"></td>
    <td class="table_last"></td>
    <td class="table_last"></td>
    <td class="table_last"></td>
  </tr>

</table>
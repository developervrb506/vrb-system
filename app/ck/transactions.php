<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if(!$current_clerk->im_allow("clerks_transaction")){include(ROOT_PATH . "/ck/process/admin_security.php");} ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/style.css" rel="stylesheet" type="text/css" />
<title>Transactions</title>
<link rel="stylesheet" type="text/css" media="all" href="../includes/calendar/jsDatePick_ltr.min.css" />
<link rel="stylesheet" href="http://localhost:8080/includes/shadowbox/shadowbox.css" type="text/css" media="screen" />
<script type="text/javascript" src="http://localhost:8080/includes/shadowbox/shadowbox.js"></script>
<script type="text/javascript">
Shadowbox.init();
</script>
<script type="text/javascript" src="../includes/calendar/jsDatePick.min.1.3.js"></script>
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
</head>
<body>
<? include "../includes/header.php" ?>
<? include "../includes/menu_ck.php" ?>
<div class="page_content" style="padding-left:50px;">
<span class="page_title">Transactions</span><br /><br />

<a href="insert_payment.php" class="normal_link">Create New Transaction</a><br /><br />

<? include "includes/print_error.php" ?>

<?
$all_option = true;
$s_clerk = $_POST["clerk_list"];
$from = clean_get("from");
if($from == ""){$from = date("Y-m-d");}
$to = clean_get("to");
if($to == ""){$to = date("Y-m-d");}
?>

<form method="post" action="transactions.php">
    From: 
    <input name="from" type="text" id="from" value="<? echo $from ?>" readonly="readonly" />
    &nbsp;&nbsp;&nbsp;&nbsp;
    To: 
    <input name="to" type="text" id="to" value="<? echo $to ?>" readonly="readonly" />
    &nbsp;&nbsp;&nbsp;&nbsp;
    Clerk: 
    <? $clerks_admin = "2,4,5"; include "includes/clerks_list.php" ?>
    &nbsp;&nbsp;&nbsp;&nbsp;
    <input type="submit" value="Search" />
</form>

<br />


<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td class="table_header">Transaction Id</td>
    <td class="table_header">Clerk</td>
    <td class="table_header">Type</td>
    <td class="table_header">Date</td>
    <td class="table_header">Amount</td>
    <td class="table_header">Detail</td>
    <td class="table_header">Edit</td>
  </tr>

<?
$transactions = search_clerk_transactions($from, $to, $s_clerk);
$i=0;
foreach($transactions as $trans){
    if($i % 2){$style = "1";}else{$style = "2";}
	$i++;
    ?>
    <tr>
        <td class="table_td<? echo $style ?>"><? echo $trans->vars["id"]; ?></td>
        <td class="table_td<? echo $style ?>"><? echo $trans->vars["clerk"]->vars["name"]; ?></td>
        <td class="table_td<? echo $style ?>"><? echo $trans->str_type(); ?></td>
        <td class="table_td<? echo $style ?>"><? echo date("M jS, Y",strtotime($trans->vars["transaction_date"])); ?></td>
        <td class="table_td<? echo $style ?>">$<? echo round($trans->vars["amount"],2); ?></td>
        <td class="table_td<? echo $style ?>">
        	<a href="transaction_detail.php?tid=<? echo $trans->vars["id"] ?>" rel="shadowbox;height=270;width=570" class="normal_link">
            	Details
            </a>
        </td>
        <td class="table_td<? echo $style ?>"><a href="insert_payment.php?pid=<? echo $trans->vars["id"]; ?>" class="normal_link">Edit</a></td>
    </td>	
    <?
    
}
?>
    <tr>
      <td class="table_last"></td>
      <td class="table_last"></td>
      <td class="table_last"></td>
      <td class="table_last"></td>
      <td class="table_last"></td>
      <td class="table_last"></td>
      <td class="table_last"></td>
    </tr>

</table>


</div>
<? include "../includes/footer.php" ?>
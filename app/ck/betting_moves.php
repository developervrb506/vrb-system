<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->im_allow("betting_basics")){ ?>
<?  ini_set('memory_limit', '-1');
set_time_limit(0);
?>
 
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/style.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="http://localhost:8080/includes/shadowbox/shadowbox.css" type="text/css" media="screen" />
<script type="text/javascript" src="http://localhost:8080/includes/shadowbox/shadowbox.js"></script>
<script type="text/javascript">
Shadowbox.init();
</script>
<title>Betting Moves</title>
<?
if(isset($_GET["del"])){
	$del = new _account_transaction();
	$del->vars["transaction_id"] = $_GET["del"];
	$del->delete_all();
	?><script type="text/javascript">alert("Transaction has been Deleted");</script><?
}
?>

</head>
<body>
<? include "../includes/header.php" ?>
<? include "../includes/menu_ck.php" ?>
<div class="page_content" style="padding-left:50px;">
<span class="page_title">Betting Moves  </span><br /><br />
<?
if(!isset($_GET["from"])){
   $date = date('Y-m-d');
   $date2 = date('Y-m-d', strtotime('-7 days'));
  } else {
    $date = $_GET["from"];
    $date2 = $_GET["to"];
  }
?>
<form method="get">
From: <input type="date" name="from" value="<? echo $date2 ?>">&nbsp;&nbsp;&nbsp; To: <input type="date" name="to" value="<? echo $date ?>">
&nbsp;&nbsp;&nbsp;
<input type="submit" value="Search"><br /><br />
</form>


<a href="insert_betting_account_transaction.php" class="normal_link"  rel="shadowbox;height=420;width=450" title="Insert Account Move">
	+ Add Account Move
</a>
<? if($current_clerk->im_allow("intersystem_transactions")){ ?>
&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;
<a href="intersystem_transaction.php" class="normal_link" rel="shadowbox;height=470;width=430">New Intersystem Transaction</a>
<? } ?>

<br /><br />
<? include "includes/print_error.php" ?>    
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td class="table_header" align="center">Id</td>
    <td class="table_header" align="center">From</td>
    <td class="table_header" align="center">To</td>
    <td class="table_header" align="center">Amount</td>
    <td class="table_header" align="center">Date</td>
    <td class="table_header" align="center">Comment</td>
    <td class="table_header" align="center"></td>
  </tr>
  <?
  $i=0;
  


   //$trans = get_all_accounts_transactions_ids();
  $trans = get_all_accounts_transactions_ids_date_range($date2,$date);
    
   
   foreach($trans as $tid){
       if($i % 2){$style = "1";}else{$style = "2";}$i++;
	   $moves = get_all_accounts_transaction_parts($tid["id"]);
  ?>
      <tr>
        <td class="table_td<? echo $style ?>" align="center"><? echo $tid["id"] ?></td>
        <td class="table_td<? echo $style ?>" align="center"><? echo $moves[1]->vars["account"]->vars["name"] ?></td>
        <td class="table_td<? echo $style ?>" align="center"><? echo $moves[0]->vars["account"]->vars["name"] ?></td>
        <td class="table_td<? echo $style ?>" align="center">$<? echo $moves[0]->vars["amount"] ?></td>
        <td class="table_td<? echo $style ?>" align="center"><? echo date("Y-m-d",strtotime($moves[0]->vars["tdate"])) ?></td>
        <td class="table_td<? echo $style ?>" align="center"><? echo $moves[0]->vars["description"] ?></td>
        <td class="table_td<? echo $style ?>" align="center">
        <? if(!contains_ck($moves[0]->vars["description"],"Intersystem Transaction #")){ ?>
            <a href="javascript:;" onclick="if(confirm('Are you sure you want to delete Transaction #<? echo $tid["id"] ?>?')){location.href = 'betting_moves.php?del=<? echo $tid["id"] ?>'}" class="normal_link">Delete</a>
        </td>
      </tr>
      <? } ?>
  <? } ?>
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
<? }else{echo "Access Denied";} ?>
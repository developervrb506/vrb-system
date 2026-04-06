<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->im_allow("reverse_transactions")){ ?>
<?
if($current_clerk->vars["id"] == "54"){$current_clerk->vars["super_admin"] = 1;}



$from = post_get("from",date("Y-m-d"));
$to = post_get("to",date("Y-m-d"));
$type = post_get("type");
$status = "ac";  // Only Accepted Transactions.



?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<script type="text/javascript">
function Confirmation(id,type,action){
	if(confirm("Are you sure you want to Reverse this Transaction?")){
	 
	   document.getElementById("idel").src = BASE_URL . "/ck/process/actions/reverse_transaction.php?id="+id+"&type="+type+"&action="+action;
		
		document.getElementById("tr_"+id).style.display = "none";
	 
	}
}
</script>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/style.css" rel="stylesheet" type="text/css" />
<title>Reverse Transactions</title>
<link rel="stylesheet" href="<?= BASE_URL ?>/includes/shadowbox/shadowbox.css" type="text/css" media="screen" />
<script type="text/javascript" src="<?= BASE_URL ?>/includes/shadowbox/shadowbox.js"></script>
<script type="text/javascript">
Shadowbox.init();
</script>

<link rel="stylesheet" type="text/css" media="all" href="../includes/calendar/jsDatePick_ltr.min.css" />
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
<link rel="stylesheet" href="<?= BASE_URL ?>/includes/shadowbox/shadowbox.css" type="text/css" media="screen" />
</head>
<body>
<? include "../includes/header.php" ?>
<? include "../includes/menu_ck.php" ?>
<div align="right">
	<iframe width="1" height="1" frameborder="0" scrolling="no" id="idel"></iframe>
</div>
<div class="page_content" style="padding-left:10px;">

<span class="page_title">Reverse Transactions</span>
<br /><br />
<br />
<form method="post">
From: <input name="from" type="text" id="from" value="<? echo $from ?>" readonly="readonly" />
&nbsp;&nbsp;&nbsp;
To:<input name="to" type="text" id="to" value="<? echo $to ?>" readonly="readonly" />
&nbsp;&nbsp;&nbsp;
Type:


<?
$data = array(
			array("id"=>"Bitcoins","label"=>"Bitcoins"),
			array("id"=>"Cash Transfer","label"=>"Cash Transfer"),
			//array("id"=>"CreditCard","label"=>"CreditCard"),
			array("id"=>"Local Cash","label"=>"Local Cash"),
			array("id"=>"MoneyOrder Payouts","label"=>"MoneyOrder Payouts"),
			array("id"=>"MoneyPak","label"=>"MoneyPak"),
			array("id"=>"Paypal","label"=>"Paypal"),
			array("id"=>"Prepaid","label"=>"Prepaid"),
			array("id"=>"Special Deposit","label"=>"Special Deposit"),
			array("id"=>"Special Payouts","label"=>"Special Payouts")
		);
create_list("type", "type", $data, $type);
?>


&nbsp;&nbsp;&nbsp;
<input name='search' type="submit" value="Search" />
</form>
<BR/><BR/>
<? 

if (isset($_POST["search"])){

?>

<spam><strong><? echo $type ?></strong></spam>

<?

   switch ($type)
   {
	case "Bitcoins":  
     	$trans = get_global_all_transactions_by_date($from,$to,"bitcoin_deposit","bitcoin_payouts",$status);
		break;
	case "CreditCard":  
       	$trans = get_global_transactions_by_date($from, $to,"creditcard_transactions","Deposit","player","0","tdate",$status,true);
		break;
	case "Local Cash":  
       	$trans = get_global_transactions_by_date($from, $to,"local_cash_transaction","Payout","account","dgs_dID","tdate",$status);
		break;
	case "MoneyOrder Payouts":  
       	$trans = get_global_transactions_by_date($from, $to,"dmo_transaction","Payout","player","dgs_dID","tdate",$status);	
		
		break;
	case "MoneyPak":  
        $trans = get_global_transactions_by_date($from, $to,"moneypack_transaction","Payout","player","dgs_dID","tdate",$status);
		
		break;
	case "Paypal":  
        $trans = get_global_transactions_by_date($from, $to,"direct_paypal_transaction","Payout","player","dgs_dID","tdate",$status);
		break;
	case "Prepaid":  
       $trans = get_global_all_transactions_by_date($from,$to,"prepaid_transaction","prepaid_payout",$status);
		break;
	case "Cash Transfer":  
         $trans = get_global_transactions_by_date($from, $to,"transaction","Cash","sender_account","dgs_dID","date","de",false,false,true);
		break;
	case "Special Deposit":  
         $trans = get_global_transactions_by_date($from, $to,"special_deposit","Deposit","player","dgs_dID","ddate",$status,false,true);
		break;
	case "Special Payouts":  
         $trans = get_global_transactions_by_date($from, $to,"special_payouts","Payout","player","dgs_dID","ddate",$status,false,true);
		break;
	default: 
    	break;
	   
   }
 ?>
 
<br /><br />
<? include "includes/print_error.php" ?>
<iframe src="" scrolling="no" frameborder="0" width="0" height="0" id="changer"></iframe>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td class="table_header" align="center">Id</td>
    <td class="table_header" align="center">Player</td>
     <td class="table_header" align="center">Amount</td>
     <td class="table_header" align="center">Type</td>
     <td class="table_header" align="center">Date</td>
    <td class="table_header" align="center">Reverse</td>
  </tr>
  <?
   $i=0; 
     
   foreach($trans as $tran){	   
       if($i % 2){$style = "1";}else{$style = "2";}
       $i++;
	  
  ?>
 <tr id="tr_<? echo $tran->vars["id"] ?>" >
    <td class="table_td<? echo $style ?>" align="center"><? echo $tran->vars["id"]; ?></td>
    <td class="table_td<? echo $style ?>" align="center"><? echo $tran->vars["player"]; ?></td>
    <td class="table_td<? echo $style ?>" align="center"><? echo $tran->vars["amount"]; ?></td>
    <td class="table_td<? echo $style ?>" align="center">
	 <? 
	  if (isset($tran->vars["cash"])){
		  
		  if($tran->vars["cash"] == "rm"){
			 echo "Deposit";  
		   }
		   else if($tran->vars["cash"] == "sm"){
			 echo "Payout";  
		   }
		  
		  
	  }
	  else{ echo $tran->vars["type"]; } ?>
    
    </td>
    <td class="table_td<? echo $style ?>" align="center"><? echo $tran->vars["tdate"]; ?></td>
    <td class="table_td<? echo $style ?>" align="center">
    <? if (!is_null($tran->vars["dgs_dID"]) && $tran->vars["dgs_dID"] != 0 ) { ?>
    <a class="normal_link" href="javascript:;" onclick="Confirmation('<? echo $tran->vars["id"]; ?>','<? echo $type ?>', '<? echo $tran->vars["type"] ?>');">
        	Reverse
    </a>
    <? } ?>
    
    </td>
 </tr> 
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
<? } ?>



</div>
<? include "../includes/footer.php" ?>
<? }else{echo "Access Denied";} ?>
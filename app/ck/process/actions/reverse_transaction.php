<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if(!$current_clerk->im_allow("reverse_transactions")) {
   	include(ROOT_PATH . "/ck/process/admin_security.php");
   } ?>
<?

$id = $_GET["id"];
$type = $_GET["type"];
$action = $_GET["action"];
$dgs_dID = "";
$dgs_fID = "";
$dgs_bID = ""; 



 switch ($type)
   {
	case "Bitcoins":  
      	$prs_method = "Bitcoins";
		if ($action =="Deposit"){
		   $trans = get_bitcoin_deposit($id);
		   $prs_type = "de";
		}
		else if ($action =="Payout" ){
	       $trans = get_bitcoin_payout($id);
		   $prs_type = "pa";
		}
		$prs_player = $trans->vars["player"];
		break;
		
	case "CreditCard":  
       	$trans = get_creditcard_transaction($id);
		$prs_method = "Creditcard";
		$prs_type = "de";
		$prs_player = $trans->vars["player"];
		break;
	case "Local Cash":  
     	$trans = get_local_payout($id);
		$prs_method = "Local Cash";
		$prs_type = "pa";
		$prs_player = $trans->vars["account"];
		break;
	case "MoneyOrder Payouts":  
      	$trans = get_moneyorder_payout($id);
		$prs_method = "Money Order";
		$prs_type = "pa";
		$prs_player = $trans->vars["player"];
		break;
	case "MoneyPak":  
      	$trans = get_moneypak_transaction($id);
		if($trans->vars["type"] == "pa"){
			$deps = explode(",",$trans->vars["deposit"]);
			foreach($deps as $dep){
				$deposit = get_moneypak_transaction($dep);
				if (!is_null($deposit)){
				   $deposit->vars["archived"] = 0;
				   $deposit->update(array("archived"));
				}
			}
		}
		$prs_method = "Moneypak";
		$prs_type = $trans->vars["type"];
		$prs_player = $trans->vars["player"];
		break;
	case "Paypal":  
       	$trans = get_paypal_transaction($id);
		$prs_method = "Paypal";
		$prs_type = "pa";
		$prs_player = $trans->vars["player"];
		break;
	case "Prepaid":  
	   	if ($action =="Deposit"){
		$trans = get_prepaid_transaction($id); 	
		}
		else if ($action =="Payout" ){
	    $trans = get_prepaid_payout($id);
	
		}
		$prs_method = "Prepaid";
		$prs_type = "de";
		$prs_player = $trans->vars["player"];
	   	break;
	case "Cash Transfer":  
       	$trans = get_cash_transfer_transaction($id);
		$prs_method = "Cash Transfer";
		if($trans->vars["type"] == "rm"){$prs_type = "de";}
		if($trans->vars["type"] == "sm"){$prs_type = "pa";}
		$prs_player = $trans->vars["sender_account"];
		break;
	case "Special Deposit":  
      	$trans = get_special_deposit($id);
		$prs_method = "Special";
		$prs_type = "de";
		$prs_player = $trans->vars["player"];
		break;
	case "Special Payouts":  
       	$trans = get_special_payout($id);
		$prs_method = "Special";
		$prs_type = "pa";
		$prs_player = $trans->vars["player"];
		break;
	default: 
    	break;
	   
   }
   
$dgs_dID = $trans->vars["dgs_dID"];
$dgs_fID = $trans->vars["dgs_fID"];
$dgs_bID = $trans->vars["dgs_bID"];


// Update Status
$pre_status = $trans->vars["status"];
$trans->vars["status"] = "de";
$trans->update(array("status"));

if(contains_ck($trans->vars["player"],"AF")){$extra_url = "_affiliate";}


//Cancel DGS
$params = "?transaction=".two_way_enc(mt_rand)."&dk=".two_way_enc("DENIED.")."&od=1&cache=".two_way_enc($dgs_dID);
file_get_contents("http://www.sportsbettingonline.ag/utilities/process/reports/cancel_dgs".$extra_url."_transaction.php$params");	

if($dgs_fID > 0){
	$params = "?transaction=".two_way_enc(mt_rand)."&dk=".two_way_enc("DENIED.")."&od=1&cache=".two_way_enc($dgs_fID);
	file_get_contents("http://www.sportsbettingonline.ag/utilities/process/reports/cancel_dgs".$extra_url."_transaction.php$params");	
}
if($dgs_bID > 0){
	$params = "?transaction=".two_way_enc(mt_rand)."&dk=".two_way_enc("DENIED.")."&od=1&cache=".two_way_enc($dgs_bID);
	file_get_contents("http://www.sportsbettingonline.ag/utilities/process/reports/cancel_dgs".$extra_url."_transaction.php$params");	
}


//CRM insertion
rec_process($trans->vars["id"], $prs_method, $prs_type, $prs_player, $trans->vars["amount"], $pre_status, $trans->vars["status"], $current_clerk->vars["id"], "Reverse Transaction");


?>
<script>
alert("The Transaction was Reversed Successfully");
</script>



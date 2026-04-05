<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->im_allow("moneypak_transactions")){ ?>
<?
$trans = get_moneypak_transaction($_GET["id"]);
if(!is_null($trans)){	
	$psta = $trans->vars["status"];
	$trans->vars["status"] = $_GET["st"];
	$trans->vars["back_message"] = $_GET["bmsg"] . ". ".$trans->vars["back_message"];
	
	
	if($_GET["st"] == "de"){
		
		$trans->vars["archived"] = 1;
		
		if(!is_null($trans->vars["dgs_dID"])){
		
			//Cancel
			$params = "?transaction=".two_way_enc(mt_rand)."&dk=".two_way_enc("DENIED.")."&od=1&cache=".two_way_enc($trans->vars["dgs_dID"]);
			file_get_contents("http://www.sportsbettingonline.ag/utilities/process/reports/cancel_dgs_transaction.php$params");	
			
			if($trans->vars["dgs_fID"] > 0){
				$params = "?transaction=".two_way_enc(mt_rand)."&dk=".two_way_enc("DENIED.")."&od=1&cache=".two_way_enc($trans->vars["dgs_fID"]);
				file_get_contents("http://www.sportsbettingonline.ag/utilities/process/reports/cancel_dgs_transaction.php$params");	
			}
			if($trans->vars["dgs_bID"] > 0){
				$params = "?transaction=".two_way_enc(mt_rand)."&dk=".two_way_enc("DENIED.")."&od=1&cache=".two_way_enc($trans->vars["dgs_bID"]);
				file_get_contents("http://www.sportsbettingonline.ag/utilities/process/reports/cancel_dgs_transaction.php$params");	
			}
			
			
			if($_GET["rp"]){
				//Cancel Payout
				$payout = get_moneypak_payout_by_deposit($trans->vars["id"]);
				if(!is_null($payout)){	
				
					if($payout->vars["amount"] == $trans->vars["amount"]){
						$payout->vars["status"] = "de";
						$extra_params = "&date=".two_way_enc(($trans->vars["amount"]*-1));
						$cancel_fees = true;
					}else{
						$payout->vars["amount"]	-= $trans->vars["amount"];
						$extra_params = "&date=".two_way_enc(($trans->vars["amount"]*-1));
						$cancel_fees = false;
					}
					$payout->update();
										
					if(strtoupper(substr(trim($payout->vars["player"]),0,2)) == "AF"){$page = "cancel_dgs_affiliate_transaction";}
					else{$page = "cancel_dgs_transaction";}
						
					if($payout->vars["dgs_dID"] > 0){
						$params = "?transaction=".two_way_enc(mt_rand)."&dk=".two_way_enc("DENIED.")."&od=1&cache=".two_way_enc($payout->vars["dgs_dID"]);
						file_get_contents("http://www.sportsbettingonline.ag/utilities/process/reports/".$page.".php$params".$extra_params);	
					}
					
					if($payout->vars["dgs_fID"] > 0 && $cancel_fees){
						$params = "?transaction=".two_way_enc(mt_rand)."&dk=".two_way_enc("DENIED.")."&od=1&cache=".two_way_enc($payout->vars["dgs_fID"]);
						file_get_contents("http://www.sportsbettingonline.ag/utilities/process/reports/".$page.".php$params".$extra_params);	
					}
									
					
				}
			
			}
		
		}
		
	}
	
	$trans->update();
	
	
	rec_process($trans->vars["id"], "Moneypak", "de", $trans->vars["player"], $trans->vars["amount"], $psta, $trans->vars["status"], $current_clerk, $trans->vars["back_message"]);
	
	
	echo "Done";
}
?>
<? }else{echo "Access Denied";} ?>
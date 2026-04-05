<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->im_allow("moneypak_transactions")){ ?>
<?
$trans = get_reloadit_transaction($_GET["id"]);
if(!is_null($trans)){	
	
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
		
		}
		
	}
	
	$trans->update();
	
	echo "Done";
}
?>
<? }else{echo "Access Denied";} ?>
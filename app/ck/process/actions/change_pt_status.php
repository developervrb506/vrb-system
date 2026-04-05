<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->im_allow("prepaid_transactions")){ ?>
<?
$trans = get_prepaid_transaction($_GET["id"]);
//if(!is_null($trans) && !($trans->vars["status"] == "de" && $_GET["st"] == "de")){	
if(!is_null($trans)){	
	$psta = $trans->vars["status"];
	$trans->vars["processor_status"] = $_GET["st"];
	if($trans->vars["processor_status"] == "de"){
		$trans->vars["status"] = "de";		
		$trans->vars["back_message"] = $_GET["bmsg"] . ". ".$trans->vars["back_message"];
	}
	$trans->vars["processor_back_message"] = $_GET["bmsg"];
	$trans->update();
	
	if($_GET["st"] == "de" && !is_null($trans->vars["dgs_dID"])){
		
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
	
	
	rec_process($trans->vars["id"], "prepaid", "de", $trans->vars["player"], $trans->vars["amount"], $psta, $trans->vars["status"], $current_clerk->vars["id"], $trans->vars["back_message"]);
	
		
	echo "Done";
}
?>
<? }else{echo "Access Denied";} ?>
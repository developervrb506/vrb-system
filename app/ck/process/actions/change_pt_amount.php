<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->im_allow("prepaid_transactions")){ ?>
<?
$trans = get_prepaid_transaction($_GET["id"]);
if(!is_null($trans)){
	
	$new_amount = $_GET["amount"];
	$new_fees = $_GET["fees"];
	
	if($trans->vars["amount"] != $new_amount){
		$trans->vars["amount"] = $new_amount;
		$params = "?transaction=".two_way_enc(mt_rand)."&ip=".two_way_enc($new_amount)."&cache=".two_way_enc($trans->vars["dgs_dID"]);
		$params .= "&mxs=".two_way_enc("AMOUNT CHANGED");
		$trans->vars["dgs_dID"] = file_get_contents("http://www.sportsbettingonline.ag/utilities/process/reports/change_amount_dgs_transaction.php$params");			
	}
	
	if($trans->vars["fees"] != $new_fees){
		$trans->vars["fees"] = $new_fees;
		$params = "?transaction=".two_way_enc(mt_rand)."&ip=".two_way_enc($new_fees)."&cache=".two_way_enc($trans->vars["dgs_fID"]);
		$params .= "&mxs=".two_way_enc("AMOUNT CHANGED");
		$trans->vars["dgs_fID"] = file_get_contents("http://www.sportsbettingonline.ag/utilities/process/reports/change_amount_dgs_transaction.php$params");			
	}
	$trans->update();
	echo "Done";
}
?>
<? }else{echo "Access Denied";} ?>
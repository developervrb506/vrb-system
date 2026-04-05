<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->im_allow("prepaid_transactions")){ ?>
<?
$trans = get_prepaid_transaction($_GET["id"]);
if(!is_null($trans)){
	$trans->vars["processor_status"] = "pe";
	$original_payment_method = $trans->vars["payment_method"];
	$trans->vars["payment_method"] = $_GET["nprs"];
	$trans->set_auto_processor();
	
	
	$params = "?transaction=".two_way_enc(mt_rand)."&mp=".two_way_enc($trans->vars["payment_method"])."&cache=".two_way_enc($trans->vars["dgs_dID"]);
	$params .= "&mxs=".two_way_enc("METHOD CHANGED");
	$trans->vars["dgs_dID"] =  file_get_contents("http://www.sportsbettingonline.ag/utilities/process/reports/change_amount_dgs_transaction.php$params");
	
	$trans->update();
	
	echo "Done";
}
?>
<? }else{echo "Access Denied";} ?>
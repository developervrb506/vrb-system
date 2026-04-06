<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->im_allow("process_payouts")){ ?>
<?
$trans = get_paypal_transaction($_POST["id"]);
if(!is_null($trans)){
	$pre_status = $trans->vars["status"];
	$trans->vars["status"] = "de";
	$trans->vars["back_message"] = $_POST["bmsg"] . ". ".$trans->vars["back_message"];
	$trans->update(array("back_message","status"));
	
	//CRM insertion
	/*$CRMdesc = "Paypal Payout has been Denied. Id: ".$trans->vars["id"];
	$CRMdesc .= "\n Notes: \n";
	$CRMdesc .= $trans->vars["back_message"];
	$data = array("player"=>$trans->vars["player"],"desc"=>$CRMdesc);
	do_post_request("http://www.sportsbettingonline.ag/utilities/process/reports/add_payout_to_CRM.php", $data);*/
	rec_process($trans->vars["id"], "Paypal", "Payout", $trans->vars["player"], $trans->vars["amount"], $pre_status, $trans->vars["status"], $current_clerk->vars["id"], $trans->vars["back_message"]);
	
	header("Location: " . BASE_URL . "/ck/paypal_payouts.php");
}
?>
<? }else{echo "Access Denied";} ?>
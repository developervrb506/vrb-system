<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->im_allow("process_payouts")){ ?>
<?
$trans = get_check_transaction($_POST["id"]);
if(!is_null($trans)){	
	$pre_status = $trans->vars["status"];
	$trans->vars["status"] = "de";
	$trans->vars["back_message"] = $_POST["bmsg"] . ". ".$trans->vars["back_message"];
	$trans->update(array("back_message","status"));
	
	rec_process($trans->vars["id"], "Cashier Checks", "Payout", $trans->vars["account"], $trans->vars["amount"], $pre_status, $trans->vars["status"], $current_clerk->vars["id"], $trans->vars["back_message"]);
	
	
	header("Location: " . BASE_URL . "/ck/cashier_checks_payouts.php");
}
?>
<? }else{echo "Access Denied";} ?>
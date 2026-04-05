<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->im_allow("process_payouts")){ ?>
<?
$trans = get_special_payout($_POST["id"]);
if(!is_null($trans)){
	$pre_status = $trans->vars["status"];		
	$trans->vars["status"] = "de";
	$trans->vars["feedback"] = $_POST["bmsg"] . ". ".$trans->vars["feedback"];
	$trans->update(array("feedback","status"));
	
	//CRM insertion
	/*$CRMdesc = "Special Payout has been Denied. Id: ".$trans->vars["id"];
	$CRMdesc .= "\n Notes: \n";
	$CRMdesc .= $trans->vars["feedback"];
	$data = array("player"=>$trans->vars["player"],"desc"=>$CRMdesc);
	do_post_request("http://www.sportsbettingonline.ag/utilities/process/reports/add_payout_to_CRM.php", $data);*/
	rec_process($trans->vars["id"], "Special", "Payout", $trans->vars["player"], $trans->vars["amount"], $pre_status, $trans->vars["status"], $current_clerk->vars["id"], $trans->vars["feedback"]);
	
	header("Location: http://localhost:8080/ck/special_payouts.php");
}
?>
<? }else{echo "Access Denied";} ?>
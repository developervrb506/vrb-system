<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->im_allow("moneypak_transactions")){ ?>
<?

$payout = get_moneypak_transaction(clean_get("pid"));

if(!is_null($payout)){
	$pre_status = $payout->vars["status"];
	$payout->vars["status"] = "de";
	$payout->vars["limbo"] = "0";
	$payout->update(array("status","limbo"));
	
	//CRM insertion
	/*$CRMdesc = "Moneypak Payout has been Denied. Id: ".$payout->vars["id"];
	$CRMdesc .= "\n Notes: \n";
	$CRMdesc .= $payout->vars["back_message"];
	$data = array("player"=>$payout->vars["player"],"desc"=>$CRMdesc);
	do_post_request("http://www.sportsbettingonline.ag/utilities/process/reports/add_payout_to_CRM.php", $data);*/
	rec_process($payout->vars["id"], "Moneypak", "Payout", $payout->vars["player"], $payout->vars["amount"], $pre_status, $payout->vars["status"], $current_clerk->vars["id"], $payout->vars["back_message"]);
	
}


header("Location: " . BASE_URL . "/ck/moneypak_limbos.php?e=81");
?>
<? }else{echo "Access Denied";} ?>
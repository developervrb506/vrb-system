<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->im_allow("moneypak_transactions")){ ?>
<?

$payout = get_moneypak_transaction(clean_get("pid"));

if(!is_null($payout)){
	$dep_ids = explode(",",$payout->vars["deposit"]);
	$ids = "";
	foreach($dep_ids as $did){
		$ids .= ",'".trim($did)."'";
	}
	$deposits = get_moneypaks_by_group_ids(substr($ids,1));
	$new_amount = 0;
	foreach($deposits as $dep){
		$new_amount += $dep->vars["amount"];
	}
	$payout->vars["amount"] = $new_amount;
	$payout->vars["confirmed"] = "1";
	$payout->update(array("amount","confirmed"));
	
	if($payout->vars["method"] == 'k'){
		$ctrans = get_check_transaction($payout->vars["comments"]);
		$ctrans->vars["amount"] = $new_amount;
		$ctrans->update(array("amount"));
	}
}


if($payout->vars["method"] == 'k'){
	header("Location: " . BASE_URL . "/ck/cashier_checks_payouts.php");
}else{
	header("Location: " . BASE_URL . "/ck/moneypak_limbos.php");
}
?>
<? }else{echo "Access Denied";} ?>
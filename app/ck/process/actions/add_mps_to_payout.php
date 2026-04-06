<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->im_allow("moneypak_transactions")){ ?>
<?

$payout = get_moneypak_transaction(clean_get("pid"));

if(!is_null($payout)){
	$pmethod = $payout->vars["method"];
	if($pmethod == 'k'){$pmethod = 'm';}
	$deposits = get_available_mps_for_payouts($payout->vars["player"], $pmethod);
	
	
	foreach($_POST["deposits"] as $did){
		$deposit = $deposits[$did];
		
		if(!is_null($deposit)){
			$current_ids = str_replace(" ","",$payout->vars["deposit"]);
			if($current_ids != ""){$extra = ",";}
			$payout->vars["deposit"] .= $extra.$deposit->vars["id"];
		}
	}
	$payout->update(array("deposit"));
}

if($payout->vars["method"] == 'k'){
	header("Location: " . BASE_URL . "/ck/cashier_checks_payouts.php");
}else{
	header("Location: " . BASE_URL . "/ck/moneypak_limbos.php");
}

?>
<? }else{echo "Access Denied";} ?>
<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->im_allow("moneypak_transactions")){ ?>
<?

$payout = get_office_expense(clean_get("pid"));

if(!is_null($payout)){
	$deposits = get_available_mps_for_payouts($mpp->vars["payout"]);
	foreach($_POST["deposits"] as $did){
		$deposit = $deposits[$did];
		if(!is_null($deposit)){
			$current_ids = str_replace(" ","",$payout->vars["moneypaks"]);
			if($current_ids != ""){$extra = ",";}
			$payout->vars["moneypaks"] .= $extra.$deposit->vars["id"];
			$deposit->vars["archived"] = "1";
			$deposit->update(array("archived"));
		}
	}
	$payout->update(array("moneypaks"));
}


header("Location: http://localhost:8080/ck/office_expenses_moneypaks.php");
?>
<? }else{echo "Access Denied";} ?>
<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->im_allow("moneypak_transactions")){ ?>
<?

$payout = get_office_expense(clean_get("pid"));

if(!is_null($payout)){
	$dep = clean_get("did");
	$payout->vars["moneypaks"] = str_replace($dep.",","",$payout->vars["moneypaks"]);
	$payout->vars["moneypaks"] = str_replace(",".$dep,"",$payout->vars["moneypaks"]);
	$payout->vars["moneypaks"] = str_replace($dep,"",$payout->vars["moneypaks"]);
	$payout->update(array("moneypaks"));
	$deposit = get_moneypak_transaction($dep);
	$deposit->vars["archived"] = "0";
	$deposit->update(array("archived"));
}


header("Location: " . BASE_URL . "/ck/office_expenses_moneypaks.php");
?>
<? }else{echo "Access Denied";} ?>
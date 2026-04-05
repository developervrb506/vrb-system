<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->im_allow("moneypak_transactions")){ ?>
<?

$payout = get_moneypak_transaction(clean_get("pid"));

if(!is_null($payout)){
	$dep = clean_get("did");
	$payout->vars["deposit"] = str_replace($dep.",","",$payout->vars["deposit"]);
	$payout->vars["deposit"] = str_replace(",".$dep,"",$payout->vars["deposit"]);
	$payout->vars["deposit"] = str_replace($dep,"",$payout->vars["deposit"]);
	$payout->update(array("deposit"));
}


if($payout->vars["method"] == 'k'){
	header("Location: http://localhost:8080/ck/cashier_checks_payouts.php");
}else{
	header("Location: http://localhost:8080/ck/moneypak_limbos.php");
}
?>
<? }else{echo "Access Denied";} ?>
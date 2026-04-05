<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->im_allow("moneypak_transactions")){ ?>
<?

$payout = get_office_expense(clean_get("pid"));

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
	if($payout->vars["amount"]<0){$sig = "-";}
	$payout->vars["amount"] = $sig.$new_amount;
	$payout->vars["paid"] = "1";
	$payout->update(array("amount","paid"));
	
	$exp = new _expense();
	$exp->vars["edate"] = date("Y-m-d");
	$exp->vars["amount"] = $payout->vars["amount"];
	$exp->vars["category"] = $payout->vars["category"]->vars["id"];
	$exp->vars["note"] = $payout->vars["note"];
	$exp->vars["inserted_date"] = $payout->vars["edate"];
	$exp->vars["status"] = "po";
	$exp->insert();
	
}


header("Location: http://localhost:8080/ck/office_expenses_moneypaks.php.php");
?>
<? }else{echo "Access Denied";} ?>
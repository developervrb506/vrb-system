<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<?
$vars["clerk"] = clean_get("clerk_list");
$vars["transaction_date"] = clean_get("trans_date");
$vars["substract"] = clean_get("type_list");
$vars["amount"] = clean_get("amount");
$vars["comment"] = clean_get("comment");

if(isset($_POST["update_id"])){
	$vars["id"] = clean_get("update_id");
	$transaction = new clerk_transaction($vars);
	$transaction->update();
	header("Location: ../../transactions.php?e=30");
}else{
	$transaction = new clerk_transaction($vars);
	$transaction->insert();
	header("Location: ../../transactions.php?e=29");
}
?>
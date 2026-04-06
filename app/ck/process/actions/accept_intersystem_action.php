<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->im_allow("intersystem_transactions")){ ?>
<? include(ROOT_PATH . "/ck/balances/api/insert_transaction.php"); ?>
<?
$trans = get_intersystem_transaction($_GET["id"]);
$from = $_GET["f"];
$to = $_GET["t"];
$status = $_GET["s"];

if(!is_null($trans)){
	
	//insert from transaction, insert to transaction
	insert_is_transaction($trans->vars["id"]);	
	
	$trans->vars["approved_date"] = date("Y-m-d H:i:s");
	$trans->vars["approved_by"] = $current_clerk->vars["id"];
	$trans->vars["status"] = "ac";
	$trans->update(array("approved_date","approved_by","status"));
}

header("Location: " . BASE_URL . "/ck/balances_transactions.php?from=$from&to=$to&status_list=$status&e=53");
?>
<? }else{echo "Access Denied";} ?>
<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->im_allow("intersystem_transactions")){ ?>
<?
$trans = get_intersystem_transaction($_GET["id"]);
$from = $_GET["f"];
$to = $_GET["t"];
$status = $_GET["s"];

if(!is_null($trans)){
	$trans->vars["approved_date"] = date("Y-m-d H:i:s");
	$trans->vars["approved_by"] = $current_clerk->vars["id"];
	$trans->vars["status"] = "ca";
	$trans->update(array("approved_date","approved_by","status"));
}

header("Location: http://localhost:8080/ck/balances_transactions.php?from=$from&to=$to&status_list=$status&e=54");
?>
<? }else{echo "Access Denied";} ?>
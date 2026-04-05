<?
include(ROOT_PATH . "/ck/db/handler.php");

$account = get_pph_account_by_name(clean_str_ck($_GET["acc"]));
$detail = clean_str_ck($_GET["note"]);
$amount = clean_str_ck($_GET["amount"]);

if(is_numeric($amount) && $amount != 0 AND !is_null($account)){
	$trans = new _pph_transaction();
	$trans->vars["amount"] = $amount;
	$trans->vars["tdate"] = date("Y-m-d H:i:s");
	$trans->vars["note"] = $detail;
	$trans->vars["from_account"] = $account->vars["id"];
	$trans->vars["to_account"] = $account->vars["id"];
	$trans->insert();
	//$account->move_balance($amount*-1);
	$account->move_balance($amount);
}

?>
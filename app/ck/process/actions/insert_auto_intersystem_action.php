<? include(ROOT_PATH . "/ck/db/handler.php"); ?>
<? include(ROOT_PATH . "/ck/balances/api/insert_transaction.php"); ?>
<?
$trans = new _intersystem_transaction();

$trans->vars["from_system"] = clean_get("system_list_from", true);
$trans->vars["from_account"] = clean_get("from_account", true);
$trans->vars["to_system"] = clean_get("system_list_to", true);
$trans->vars["to_account"] = clean_get("to_account", true);
$trans->vars["amount"] = clean_get("amount", true);
$trans->vars["note"] = clean_get("comment", true);
$trans->vars["tdate"] = date("Y-m-d H:i:s");
$trans->vars["inserted_by"] = clean_get("clerk", true);
$trans->vars["emails"] = "";
$trans->insert();

insert_is_transaction($trans->vars["id"]);
$trans->vars["approved_date"] = date("Y-m-d H:i:s");
$trans->vars["approved_by"] = clean_get("clerk", true);
$trans->vars["status"] = "ac";
$trans->update();
?>
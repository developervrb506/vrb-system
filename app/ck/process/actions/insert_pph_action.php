<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->im_allow("pph_accounting")){ ?>
<?
$from = get_pph_account(clean_get("pph_account_list_from"));
$to = get_pph_account(clean_get("pph_account_list_to"));

$trans = new _pph_transaction();
$trans->vars["amount"] = clean_get("amount");
$trans->vars["tdate"] = date("Y-m-d H:i:s");
$trans->vars["note"] = clean_get("note");
$trans->vars["from_account"] = $from->vars["id"];
$trans->vars["to_account"] = $to->vars["id"];
$trans->insert();
$from->move_balance(clean_get("amount")*-1);
$to->move_balance(clean_get("amount"));

header("Location: http://localhost:8080/ck/pph.php?e=29");
?>
<? }else{echo "Access Denied";} ?>
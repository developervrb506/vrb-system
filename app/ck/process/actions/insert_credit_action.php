<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->im_allow("credit_accounting")){ ?>
<?
$from = get_credit_account(clean_get("credit_account_list_from"));
$to = get_credit_account(clean_get("credit_account_list_to"));

$number = mt_rand();

$trans = new _credit_transaction();
$trans->vars["amount"] = clean_get("amount");
$trans->vars["tdate"] = date("Y-m-d H:i:s");
$trans->vars["note"] = clean_get("note");
$trans->vars["from_account"] = $from->vars["id"];
$trans->vars["to_account"] = $to->vars["id"];
$trans->insert();
$from->move_balance(clean_get("amount")*-1);
$to->move_balance(clean_get("amount"));

header("Location: " . BASE_URL . "/ck/credit.php?e=29");
?>
<? }else{echo "Access Denied";} ?>
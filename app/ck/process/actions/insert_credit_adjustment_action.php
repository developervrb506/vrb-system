<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->im_allow("credit_accounting")){ ?>
<?
$acc = get_credit_account(clean_get("credit_account_list"));

$trans = new _credit_adjustment();
$trans->vars["account"] = $acc->vars["id"];
$trans->vars["amount"] = clean_get("amount");
$trans->vars["mdate"] = clean_get("mdate");
$trans->vars["tdate"] = date("Y-m-d H:i:s");
$trans->vars["note"] = clean_get("note");
$trans->insert();
$acc->move_balance(clean_get("amount"));

header("Location: " . BASE_URL . "/ck/credit.php?e=57");
?>
<? }else{echo "Access Denied";} ?>
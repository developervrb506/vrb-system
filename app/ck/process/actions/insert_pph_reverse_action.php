<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->im_allow("pph_accounting")){ ?>
<?
$from = get_pph_account(clean_get("pph_account_list_from"));

$trans = new _pph_transaction();
$trans->vars["amount"] = clean_get("amount");
$trans->vars["tdate"] = date("Y-m-d H:i:s");
$trans->vars["note"] = clean_get("note");
if(clean_get("amount") < 0){$from_acc = $from->vars["id"]; $to_acc = "0";}
else{$from_acc = "0"; $to_acc = $from->vars["id"];}
$trans->vars["from_account"] = $from_acc;
$trans->vars["to_account"] = $to_acc;
$trans->insert();
$from->move_balance(clean_get("amount"));

header("Location: " . BASE_URL . "/ck/pph.php?e=29");
?>
<? }else{echo "Access Denied";} ?>
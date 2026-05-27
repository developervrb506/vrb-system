<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->im_allow("pph_accounting")){ ?>
<?
$trans = new _pph_expense();
$trans->vars["amount"] = clean_get("amount");
$trans->vars["tdate"] = clean_get("date");
$trans->vars["description"] = clean_get("note");
$trans->insert();

header("Location: " . BASE_URL . "/ck/pph.php?e=29");
?>
<? }else{echo "Access Denied";} ?>
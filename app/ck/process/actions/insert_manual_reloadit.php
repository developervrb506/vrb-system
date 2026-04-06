<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->im_allow("reloadit_transactions")){ ?>
<?

$amount = clean_get("amount");
$number = clean_get("number");

$pak = new _reloadit_transaction();

$pak->vars["type"] = "de";
$pak->vars["player"] = "MANUAL";
$pak->vars["customer"] = "1042";
$pak->vars["status"] = "ac";
$pak->vars["tdate"] = date("Y-m-d H:i:s");
$pak->vars["cmarked"] = "1";
$pak->vars["confirmed"] = clean_get("conf");
$pak->vars["amount"] = $amount;
$pak->vars["number"] = $number;
$pak->vars["manual"] = 1;
$pak->insert();

header("Location: " . BASE_URL . "/ck/reloadit_transactions.php");
?>
<? }else{echo "Access Denied";} ?>
<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->im_allow("moneypak_transactions")){ ?>
<?

$amount = clean_get("amount");
$number = clean_get("number");
$player = clean_get("player");
$method = clean_get("method");
if(trim($player) == ""){
	$player = "MANUAL";
	$cmarked = "1";
	$authorized = "0";
}else{
	$cmarked = "0";
	$authorized = "1";
}

$pak = new _moneypak_transaction();

$pak->vars["type"] = "de";
$pak->vars["method"] = $method;
$pak->vars["player"] = $player;
$pak->vars["customer"] = "1042";
$pak->vars["status"] = "ac";
$pak->vars["tdate"] = date("Y-m-d H:i:s");
$pak->vars["cmarked"] = $cmarked;
$pak->vars["authorized"] = $authorized;
$pak->vars["confirmed"] = clean_get("conf");
$pak->vars["amount"] = $amount;
$pak->vars["number"] = $number;
$pak->vars["manual"] = 1;
$pak->insert();

header("Location: " . BASE_URL . "/ck/moneypak_transactions.php");
?>
<? }else{echo "Access Denied";} ?>
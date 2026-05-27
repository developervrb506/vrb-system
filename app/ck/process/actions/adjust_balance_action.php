<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->im_allow("balances") || $current_clerk->im_allow("processing_balances") || $current_clerk->im_allow("pph_balances")){ ?>
<?

$type = $_POST["type"];
$system = $_POST["system"];
$account = $_POST["account"];
$adj = get_adjusted_balance($type, $system, $account);

if(!is_null($adj)){
	
	if(isset($_POST["delete"])){	
		$adj->delete();
	}else{
		$adj->vars["balance"] = $_POST["amount"];
		$adj->vars["note"] = $_POST["note"];
		$adj->update();
	}
}else{
	$adj = new _balace_adjust;
	$adj->vars["type"] = $_POST["type"];
	$adj->vars["system"] = $_POST["system"];
	$adj->vars["account"] = $_POST["account"];
	$adj->vars["balance"] = $_POST["amount"];
	$adj->vars["note"] = $_POST["note"];
	$adj->insert();
}


header("Location: " . BASE_URL . "/ck/balances.php");
?>
<? }else{echo "Access Denied";} ?>
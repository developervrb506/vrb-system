<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->im_allow("cashier_access")){ ?>
<?

$method = get_cashier_method($_POST["mid"]);
if(!is_null($method) && trim($_POST["new_acc"]) != ""){
	$acc = new _cashier_access();
	$acc->set_type($method->vars["type"]);
	$acc->vars["player"] = trim($_POST["new_acc"]);
	$acc->vars["method"] = $method->vars["id"];
	$acc->insert();
}

header("Location: http://localhost:8080/ck/cashier_access_list.php?mid=".$method->vars["id"]."&e=80");
?>
<? }else{echo "Access Denied";} ?>
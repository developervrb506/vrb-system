<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->im_allow("sbo_main_page")){ ?>
<?

$method = get_cashier_method($_GET["mid"]);
if(!is_null($method)){
	$method->delete_account($_GET["acc"]);
}

header("Location: http://localhost:8080/ck/cashier_access_list.php?mid=".$method->vars["id"]."&e=79");
?>
<? }else{echo "Access Denied";} ?>
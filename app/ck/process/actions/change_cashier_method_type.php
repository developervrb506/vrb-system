<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->im_allow("sbo_main_page")){ ?>
<?

$method = get_cashier_method($_GET["mid"]);

if(!is_null($method)){
	$method->vars["type"] = $_GET["type"];
	$method->update(array("type"));
}

header("Location: " . BASE_URL . "/ck/cashier_access.php?e=78");
?>
<? }else{echo "Access Denied";} ?>
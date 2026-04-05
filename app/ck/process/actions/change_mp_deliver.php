<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->im_allow("moneypak_sell")){ ?>
<?
$trans = get_moneypak_sell($_GET["id"]);


if(!is_null($trans)){	
	
	$trans->vars["delivered"] = 1;
	$trans->vars["comments"] = "Completed";
	$trans->update(array("delivered","comments"));
	
	//Update MP status
	if(is_mp_available($trans->vars["moneypak"]->vars["id"])){
		$mp = get_moneypak_transaction($trans->vars["moneypak"]->vars["id"]);
		$mp->vars["archived"] = 1;
		//$mp->update(array("archived"));
	}
	
}

?>
<? }else{echo "Access Denied";} ?>
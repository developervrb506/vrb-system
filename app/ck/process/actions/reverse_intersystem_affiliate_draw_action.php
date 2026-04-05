<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->im_allow("intersystem_transactions")){ ?>
<?

	


$trans = get_intersystem_transaction($_GET["id"]);

if(!is_null($trans)){
	$trans->vars["reversed"] = 1;
    $trans->update(array("reversed"));
}



}else{echo "Access Denied";} ?>
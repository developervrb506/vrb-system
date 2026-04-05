<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if(!$current_clerk->im_allow("buy_moneypaks_promo")) {
   	include(ROOT_PATH . "/ck/process/admin_security.php");
} ?>
<?
$mpak = get_buy_moneypaks_promo($_GET["id"]);

if(!is_null($mpak)){

    if ($_GET["action"] =="active"){
	  $mpak->vars["active"] = 0;
	  $mpak->update(array("active"));
	}
	else if ($_GET["action"] == "sent"){
      $mpak->vars["sent"] = 1;
	  $mpak->update(array("sent"));
	}

}
?>

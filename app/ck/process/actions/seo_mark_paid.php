<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->im_allow("seo_system")){ ?>
<?
$entry = get_seo_entry(clean_get("link"));
if(!is_null($entry)){
	$entry->vars["paid_comments"] = clean_get("paid_comments");
	$entry->vars["paid"] = 1;
	$entry->update(array("paid_comments","paid"));
}


header("Location: " . BASE_URL . "/ck/seo_system.php");
?>
<? }else{echo "Access Denied";} ?>
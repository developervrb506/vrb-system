<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? 
if($current_clerk->im_allow("seo_system")) {
	
	$entry = get_seo_entry(clean_get("eid",true));
	if(!is_null($entry)){
		$entry->vars["paid_status"] = clean_get("status",true);
		$entry->vars["article_url"] = urldecode(clean_get("aurl",true));
		if($_GET["complete"]){$entry->vars["complete"] = 1;}
		$entry->update(array("paid_status","complete"));
	}
	
	
	header("Location: " . BASE_URL . "/ck/seo_get_lead.php");	
}
?>
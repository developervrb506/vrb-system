<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? 
if($current_clerk->im_allow("seo_system")) {

	$seo_entry = get_seo_entry(clean_get("delete_id",true));
	//echo clean_get("delete_id",true);
	if(!is_null($seo_entry)){
		$seo_entry->delete();
	}
	header("Location: " . BASE_URL . "/ck/seo_system.php?e=97");
}
?>
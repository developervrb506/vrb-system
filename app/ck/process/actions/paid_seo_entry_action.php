<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? 
if($current_clerk->im_allow("seo_system")) {
	
	$paid_status  = clean_get("paid_status",true);
	
	if (isset($paid_status)) {
	
		$vars = array();
		$vars["id"]   = clean_get("paid_id",true);
		$vars["paid"] = $paid_status;	
		
		$group = new _seo_entry($vars);
		$group->update();	
				
		if ($paid_status == 1) {
		   header("Location: " . BASE_URL . "/ck/seo_system.php?e=98");	
		}
		else {
		   header("Location: " . BASE_URL . "/ck/seo_system.php?e=99");	
		}
	}
}
?>
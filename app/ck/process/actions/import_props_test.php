<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? 
if($current_clerk->im_allow("props_system")){ 
	$_POST["clerk"] = $current_clerk ->vars["id"];
	

	echo do_post_request("http://www.sportsbettingonline.ag/utilities/process/reports/import_props_action_test.php",$_POST);
}
?>

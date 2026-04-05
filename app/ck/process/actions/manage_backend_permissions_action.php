<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? 
if($current_clerk->im_allow("backend_permissions")){ 
	echo file_get_contents("http://www.sportsbettingonline.ag//utilities/process/reports/sbo_backend_permissions_action.php?".http_build_query($_POST));
}else{echo "Acces Denied";} 
?>
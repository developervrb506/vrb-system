<?php 
 include(ROOT_PATH . "/ck/process/security.php"); 
 if($current_clerk->im_allow("affiliates_system")){
	
	 	 $promo = get_promotype_by_id($_GET["pid"]);
         $promo->delete(); 
	
	if (isset($_GET["custom"])){
	  header("Location: " . BASE_URL . "/ck/affiliates/partners_custom_promotype_view.php?type=".$promo->vars["type"]);
	}
	else {
	  header("Location: " . BASE_URL . "/ck/affiliates/partners_text_link_view.php");
	}
?>
<? } else { echo "ACCESS DENIED"; }?>
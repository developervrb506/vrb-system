<?php 
 include(ROOT_PATH . "/ck/process/security.php"); 
 if($current_clerk->im_allow("affiliates_system")){
	 
	$text = $_POST["link_text"];
	$url = $_POST["link_url"];
	$book = $_POST["text_book"];
	$name = $text."_-_all_-_".$url."_-_".$book;
	
	$promo = new _promo_type();
	$promo->vars["name"] = $name;
	$promo->vars["type"] = "t";
	$promo->vars["comment"] = "";
	$promo->vars["idcampaigne"] = "-1";
	$promo->insert(); 			
		
	
	header("Location: " . BASE_URL . "/ck/affiliates/partners_text_link_view.php");

?>
<? } else { echo "ACCESS DENIED"; }?>
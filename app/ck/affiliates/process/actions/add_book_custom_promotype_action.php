<?php 
 include(ROOT_PATH . "/ck/process/security.php"); 
 if($current_clerk->im_allow("affiliates_system")){
	 
	$text = $_POST["link_text"];
	$url = $_POST["link_url"];
	$book = $_POST["text_book"];
	
	if ($_POST["type"] == "e"){
	  $name = $_POST["cat"]."_".$text."_-_all_-_".$url."_-_".$book;
	}else {
	   $name = $text."_-_all_-_".$url."_-_".$book;
	}
	
	if (!isset($_POST["edit"])) {
		$promo = new _promo_type();
		$promo->vars["name"] = $name;
		$promo->vars["type"] = $_POST["type"];
		$promo->vars["comment"] = "";
		$promo->vars["idcampaigne"] = "-1";
		$promo->insert(); 			
	}
	else {
		
	    $promo = get_promotype_by_id($_POST["edit"]);	
	    $promo->vars["name"] = $name;
		$promo->vars["type"] = $_POST["type"];
		$promo->vars["comment"] = "";
		$promo->vars["idcampaigne"] = "-1";
		$promo->update(); 			
	
	}
	
	header("Location: " . BASE_URL . "/ck/affiliates/partners_custom_promotype_view.php?type=".$_POST["type"]);

?>
<? } else { echo "ACCESS DENIED"; }?>
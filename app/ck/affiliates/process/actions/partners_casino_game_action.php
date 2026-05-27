<?php 
 include(ROOT_PATH . "/ck/process/security.php"); 
if($current_clerk->im_allow("affiliates_system")){

$text = $_POST["link_text"];
$url = $_POST["link_url"];
$book = $_POST["text_book"];
$name = $text."_-_".$url."_-_".$book;

if( isset($_GET["pid"]) ) {	
	$promo = delete_general_promo_affiliate($_GET["pid"]);
	$action = "d";
}else {
	$promo = new _promo_type();
	$promo->vars["name"] = $name;
	$promo->vars["type"] = "c";
	$promo->vars["comment"] = "";
	$promo->vars["idcampaigne"] = "-1";
	$promo->insert(); 
	$action = "a";	
	
}

header("Location: " . BASE_URL . "/ck/affiliates/partners_casino_game_link_view.php?a=".$action);
	
?>
<? } else { echo "ACCESS DENIED"; }?>
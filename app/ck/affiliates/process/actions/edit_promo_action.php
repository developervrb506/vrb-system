<?php 
 include(ROOT_PATH . "/ck/process/security.php"); 
if($current_clerk->im_allow("affiliates_system")){


$comment = $_POST["comment"];
$type   =  $_POST["promo_type"];
$promo = get_promotype_by_id($_POST["promo_id"]);

if($type == "t"){
	$name = ($_POST["link_text"]);
}else if($type == "b"){
	/*$path = "C:/websites/jobs.inspin.com/partners/images/banners/";
	if ($_FILES['image_banner']['tmp_name'] != "") { 
	  list($width, $height, $type_file, $attr) = getimagesize($_FILES['image_banner']['tmp_name']);
	}
	//COMMENTED UNTIL IMAGE IS ACTIVATED
	$name = upload_file("image_banner", $path, rand()."_".$width."x".$height);
	@unlink($path.$promo->vars["name"]);
	copy($path.$name,$path.$name);*/	
}

$promo->vars["type"] = $type;
//$promo->vars["name"] = $name;
$promo->vars["comment"] = $comment;
$promo->update();

header("Location: " . BASE_URL . "/ck/affiliates/partners_campaigne_view.php?cid=" . $_POST["cid"]);
	
?>
<? } else { echo "ACCESS DENIED"; }?>
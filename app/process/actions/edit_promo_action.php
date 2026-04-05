<? require_once(ROOT_PATH . "/process/login/admin_security.php"); ?>
<? 
require_once(ROOT_PATH . "/process/functions.php");

$type   = clean_str($_POST["promo_type"]);
$promo   = get_promo(clean_str($_POST["promo_id"]));

if($type == "t"){
	$name = clean_str($_POST["link_text"]);
}else if($type == "b"){
	$path = "./images/banners/";
	list($width, $height, $type_file, $attr) = getimagesize($_FILES['image_banner']['tmp_name']);
	$name = upload_image_partners("image_banner", $path, rand()."_".$width."x".$height);
	unlink($path.$promo->name);
}

$promo->type = $type;
$promo->name = $name;
$promo->update();
	
header("Location: http://jobs.inspin.com/wp-admin/partners_campaigne_view.php?cid=" . $_POST["cid"]);	 

?>
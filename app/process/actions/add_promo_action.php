<? require_once(ROOT_PATH . "/process/login/admin_security.php"); ?>
<? 
require_once(ROOT_PATH . "/process/functions.php");

$type   = clean_str($_POST["promo_type"]);
$campaigne   = get_campaigne(clean_str($_POST["cid"]));

if($type == "t"){
	$name = clean_str($_POST["link_text"]);
}else if($type == "b"){
	list($width, $height, $type_file, $attr) = getimagesize($_FILES['image_banner']['tmp_name']);
	$name = upload_image_partners("image_banner", "./images/banners/", rand()."_".$width."x".$height);
}

$promo = new promo(0,$name,$type);
$campaigne->add_promo($promo);
	
header("Location: http://jobs.inspin.com/wp-admin/partners_campaigne_view.php?cid=" . $campaigne->id);	 

?>
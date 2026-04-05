<?
include(ROOT_PATH . "/process/functions.php");
$parts = explode("-",$_GET["aid"]);
$affiliate = $parts[0];
$customcampaing = $parts[1];
$promo = get_promo($_GET["pid"]);
$print = $_GET["print"];
add_impresion($promo->id, $affiliate, $customcampaing);

if($promo->type == "b"){
	$image = $promo->name;	
}else if($promo->type == "t" || $promo->type == "c"){
	$image = "pixel.png";	
}

$url = "http://www.inspin.com/partners/images/banners/" . $image;
//$url = "http://images.commissionpartners.com/data/banners/" . $image;

if($print != ""){
	echo $url;
}else if($image != ""){
	//header("Location: $url");
	header("Content-Type: image/jpg");	
	echo file_get_contents($url);
}
?>
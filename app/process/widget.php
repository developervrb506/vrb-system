<?
//This code is discontinued, only for old tickers, use widget2.php instead
include(ROOT_PATH . "/process/functions.php");
$type = $_GET["t"];
$color = $_GET["col"];
$display_tabs = $_GET["dt"];
$print = $_GET["print"];

$aff = $_GET["aid"];
$promo_id = $_GET["pid"];
if(!isset($_GET["center"])){
	add_impresion($promo_id, $aff,$custom_campaign);
}

if($type == 1){
	$comp_name = $_GET["nm"];
	$redirection = "http://jobs.inspin.com/includes/ticker/index_w.php?dt=$display_tabs&col=$color&nm=$comp_name&vrb=t";
	if($print != ""){
		echo $redirection;
	}else{
		header("Location: $redirection");
	}
	
}else if($type == 2){
	$image_url = $_GET["img"];
	if($image_url == ""){$image_url = BASE_URL . "/images/temp/def_wd_img.gif";}
	$redirection = "http://jobs.inspin.com/includes/ticker/widget/index.php?dt=$display_tabs&col=$color&img=$image_url&vrb=t";
	if($print != ""){
		echo $redirection;
	}else{
		header("Location: $redirection");
	}
}
?>
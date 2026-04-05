<?
include(ROOT_PATH . "/process/functions.php");
$type = $_GET["wt"];
$color = $_GET["col"];
$display_tabs = $_GET["dt"];
$print = $_GET["print"];

$aff = $_GET["aid"];
$promo_id = $_GET["pid"];
if(!isset($_GET["center"]) && $promo_id != "" && $aff != ""){
	add_impresion($promo_id, $aff,$custom_campaign);
}

if($type == 1){
	$comp_name = $_GET["nm"];
	if($promo_id != "" && $aff != ""){
		$redirection = "http://jobs.inspin.com/includes/ticker/index_w.php?dt=$display_tabs&col=$color&nm=$comp_name&vrb=t&wt=1";
	}else{
		$urlp = parse_url(current_URL());
		$redirection = "http://jobs.inspin.com/includes/ticker/index_w.php?vrb=t&".$urlp["query"];
	}	
	if($print != ""){
		echo $redirection;
	}else{
		echo file_get_contents($redirection);
		//header("Location: $redirection");
	}
	
}else if($type == 2){
	$image_url = $_GET["img"];
	if($image_url == ""){$image_url = "http://localhost:8080/images/temp/def_wd_img.gif";}
	if($promo_id != "" && $aff != ""){
		$redirection = "http://jobs.inspin.com/includes/ticker/widget/index.php?dt=$display_tabs&col=$color&img=$image_url&vrb=t&wt=1";
	}else{
		$urlp = parse_url(current_URL());
		$redirection = "http://jobs.inspin.com/includes/ticker/widget/index.php?vrb=t&".$urlp["query"];
	}	
	if($print != ""){
		echo $redirection;
	}else{
		echo file_get_contents($redirection);
		//header("Location: $redirection");
	}
}
?>
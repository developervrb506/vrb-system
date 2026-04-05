<?
include(ROOT_PATH . "/process/functions.php");

$aid = $_GET["aid"];
if($aid == "" || $aid == -1){
	$aff = get_affiliate_by_AF($_GET["af"]);
	$aid = $aff->id;
}

$promo = $_GET["pid"];
$campaign = $_GET["cc"];

if($aid != "" && $promo != ""){
	$player = $_GET["ply"];
	insert_signup_traking($promo, $campaign, $aid, $player, date("Y-m-d H:i:s"));
}
?>
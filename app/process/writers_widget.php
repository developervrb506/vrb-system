<?php
$brand = $_GET["brand"];
if($brand==""){$brand = 1;}
if($brand == 1){
	$league = $_GET["le"];
	$top_banner = $_GET["pid_top"];
	$bot_banner = $_GET["pid_bot"];
	$aid = $_GET["aid"];
	$result = file_get_contents("http://jobs.inspin.com/writers/widget/page.php?le=$league&aid=$aid&pid_top=$top_banner&pid_bot=$bot_banner");
	echo $result;
}else if($brand == 3){
	$league = $_GET["le"];
	$type = $_GET["tp"];
	$top_banner = $_GET["pid_top"];
	$bot_banner = $_GET["pid_bot"];
	$aid = $_GET["aid"];
	$logo = $_GET["logo"];
	$result = file_get_contents("http://www.sportsbettingonline.ag/utilities/process/water-cooler/widget/widget.php?le=$league&aid=$aid&pid_top=$top_banner&pid_bot=$bot_banner&tp=$type&logo=$logo");
	echo $result;
}
?>
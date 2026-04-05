<?php
$image = explode("_/_",$_GET["i"]);
switch($image[1]){
	case "trainer":
		header("Location: http://localhost:8080/images/affiliates/trainer_banners/" . $image[0]);
		break;
	default:
		header("Location: http://jobs.inspin.com/images/widget_logos/" . $image[0]);	
}
?>
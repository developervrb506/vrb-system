<?php
$league = $_GET["le"];
$top_banner = $_GET["pid_top"];
$bot_banner = $_GET["pid_bot"];
$aid = $_GET["aid"];
$date = $_POST["date"];

$result = file_get_contents("http://jobs.inspin.com/trends/widget-page/index.php?le=$league&aid=$aid&pid_top=$top_banner&pid_bot=$bot_banner&date=$date");
echo $result;
?>
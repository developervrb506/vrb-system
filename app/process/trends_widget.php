<?php
$league = $_GET["le"];
$logo = $_GET["logo"];
$pid = $_GET["pid"];
$aid = $_GET["aid"];
$result = file_get_contents("http://jobs.inspin.com/trends/widget/index.php?le=$league&pid=$pid&aid=$aid&logo=$logo");
echo $result;
?>
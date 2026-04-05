<?php
header('Content-type: text/xml');
$league = $_GET["le"];
$aid = $_GET["aid"];
$result = file_get_contents("http://jobs.inspin.com/writers/widget/xml_feed.php?le=$league&aid=$aid");
echo $result;
?>
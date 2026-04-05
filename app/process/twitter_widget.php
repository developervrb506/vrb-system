<link href="http://jobs.inspin.com/twitter/widget/style.css" rel="stylesheet" type="text/css" />
<?php
$league = $_GET["le"];
$logo = $_GET["logo"];
$pid = $_GET["pid"];
$aid = $_GET["aid"];
$result = file_get_contents("http://jobs.inspin.com/twitter/widget/index.php?le=$league&pid=$pid&aid=$aid&logo=$logo");
echo $result;
?>
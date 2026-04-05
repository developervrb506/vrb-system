<?
$league = $_GET["le"];
$aff_id = $_GET["aid"];
$top_banner = $_GET["tb"];
$footer_banner = $_GET["fb"];
$books = $_GET["bks"];
header("Location: http://jobs.inspin.com/betting-lines/parsers/live_lines_vrb.php?books=$books&le=$league&aid=$aff_id&tb=$top_banner&fb=$footer_banner");
?>
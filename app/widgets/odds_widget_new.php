<?
include(ROOT_PATH . "/process/functions.php");
$urlp = parse_url(current_URL());
if(isset($_GET["ticker"])){$tqs = "ticker.php";}
$redirection = "http://jobs.inspin.com/live_odds/widgets/vrb/$tqs?".$urlp["query"];
echo file_get_contents($redirection);
?>
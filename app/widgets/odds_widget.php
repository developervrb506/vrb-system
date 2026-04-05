<? 
if(isset($_GET["ticker"])){$tqs = "ticker.php";}

header("Location: http://jobs.inspin.com/live_odds/widgets/vrb/$tqs?w=".$_GET["w"]."&h=".$_GET["h"]."&ls=".$_GET["ls"]."&b=".$_GET["b"]."&af=".$_GET["af"]."&pid=".$_GET["pid"]); 
?>
<? include("dgs.php"); ?>
<?
$accounts = array();

$accounts[] = array("url"=>"www.sportsbettingonline.ag","min"=>"50","max"=>"300","user"=>"BETOWITEST","pass"=>"123");
$accounts[] = array("url"=>"www.sportsbettingonline.ag","min"=>"50","max"=>"200","user"=>"SBO5000","pass"=>"test");
$accounts[] = array("url"=>"www.sportsbettingonline.ag","min"=>"50","max"=>"300","user"=>"BETOWITEST","pass"=>"123");
$accounts[] = array("url"=>"www.sportsbettingonline.ag","min"=>"50","max"=>"200","user"=>"SBO5000","pass"=>"test");
$accounts[] = array("url"=>"www.sportsbettingonline.ag","min"=>"50","max"=>"300","user"=>"BETOWITEST","pass"=>"123");
$accounts[] = array("url"=>"www.sportsbettingonline.ag","min"=>"50","max"=>"200","user"=>"SBO5000","pass"=>"test");
$accounts[] = array("url"=>"www.sportsbettingonline.ag","min"=>"50","max"=>"300","user"=>"BETOWITEST","pass"=>"123");
$accounts[] = array("url"=>"www.sportsbettingonline.ag","min"=>"50","max"=>"200","user"=>"SBO5000","pass"=>"test");
$accounts[] = array("url"=>"www.sportsbettingonline.ag","min"=>"50","max"=>"300","user"=>"BETOWITEST","pass"=>"123");
$accounts[] = array("url"=>"www.sportsbettingonline.ag","min"=>"50","max"=>"200","user"=>"SBO5000","pass"=>"test");

foreach($accounts as $account){
	
	$bot = new _dgs_robot();
	$bot->vars["user"] = $account["user"];
	$bot->vars["pass"] = $account["pass"];
	$bot->vars["sport"] = "NBA";
	$bot->vars["period"] = "game";
	$bot->vars["amount"] = $account["max"];
	$bot->vars["rotation"] = "704";
	$bot->vars["type"] = "spread";
	$bot->vars["url"] = $account["url"];	
	
	
	$bot->login();
	$line = $bot->create_bet(true);
	print_r($line);
	echo "<br /><br />";
	
}




?>
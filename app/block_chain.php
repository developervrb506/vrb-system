<?

if($_GET["action"] == "ticker"){
	echo @file_get_contents("http://blockchain.info/ticker");
}else if($_GET["action"] == "address"){
	echo @file_get_contents('https://blockchain.info/api/receive?' . str_replace("&action=address","",$_SERVER['QUERY_STRING']));
}


?>
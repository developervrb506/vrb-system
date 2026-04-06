<?
//default example:   http://localhost:8080/process/redir.php?aid=999&default&book=wagerweb
include(ROOT_PATH . "/process/functions.php");

$ip = $_GET["ip"];
if(trim($ip) != ""){$_SERVER['REMOTE_ADDR'] = $ip;}

$parts = explode("-",$_GET["aid"]);
$affiliate = $parts[0];

$customcampaing = $parts[1];

if($customcampaing!=""){
   $qscc = "-$customcampaing";
}else{  	
   $customcampaing = 0;	
}

$print = $_GET["print"];

if(isset($_GET["default"])){
	$book = $_GET["book"];
	switch ($book) {
    case "wagerweb":
        $url = get_campaigne(14)->url;
		$idbook = 1;
        break;
	case "bet_online":
        $url = get_campaigne(24)->url;
		$idbook = 4;
        break;
	case "sbo":
        $url = get_campaigne(51)->url;
		$idbook = 3;
        break;
	case "sports_betting_online":
        $url = get_campaigne(51)->url;
		$idbook = 3;
        break;
	}
	header("Location: custom_redir.php?aid=$affiliate$qscc&tgt=$url&bk=$idbook&rere");
	
}else{ 
	$promo = get_promo($_GET["pid"]);		
	add_click($promo->id, $affiliate,$customcampaing);
	$url = get_landing_by_promo($promo);
				
	if($print != ""){
		echo "$url?aid=$affiliate&pid=".$promo->id;
	}else{
		if(contains($url,"vrbmarketing.com")){
			$camp = get_campaigne_by_promo($promo);
			if($camp->book->id == 3 || $camp->book->id == 6 || $camp->book->id == 7 || $camp->book->id == 8 || $camp->book->id == 9 || $camp->book->id == 10){
				header("Location: custom_redir.php?aid=$affiliate$qscc&rere&pid=".$promo->id."&bk=".$camp->book->id."&tgt=$url?aid=$affiliate/_as_/cc=".$customcampaing."/_as_/pid=".$promo->id);				
			}else{								
				header("Location: $url?aid=$affiliate&pid=".$promo->id);
			}
			
		}else{
			$camp = get_campaigne_by_promo($promo);
			$url = clean_url($url, true);
			header("Location: custom_redir.php?aid=$affiliate$qscc&pid=".$promo->id."&rere&tgt=$url&bk=".$camp->book->id);
		}
		
	}
}

?>
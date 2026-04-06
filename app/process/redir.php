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

$pid = $_GET["pid"];

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
        break;	case "sports_betting_online":
        $url = get_campaigne(51)->url;

		$idbook = 3;
        break;
	}	
	$url_redirect = "custom_redir.php?aid=".$affiliate.$qscc."&tgt=".$url."&bk=".$idbook."&rere";
	?>
	<script>location.href = "<? echo $url_redirect;  ?>";</script>
    <?
}else{
    
	$promo = get_promo($pid);
				
	if(!empty($promo)){	
	  add_click($promo->id, $affiliate,$customcampaing);	  
	  $url = get_landing_by_promo($promo); ?>     
      <?
	}else{
		$owi_pids_array = array(1939,2416,3908);
		$sbo_pids_array = array(3895,1947);		
		if (in_array($pid,$owi_pids_array)){//old betowi promo ids patch redirect
		    $url_patch_redir = "http://www.betowi.com/redir.php";
			$brand_id = 7;			
	    }elseif (in_array($pid,$sbo_pids_array)){//old sbo promo ids patch redirect
		    $url_patch_redir = "http://www.sportsbettingonline.ag/redir.php";
			$brand_id = 3;			 
	    }
		$red_url = $url_patch_redir."?cc=".$customcampaing."&pid=".$pid."&aid=".$affiliate."&af=". get_affiliate_code($affiliate, $brand_id);
	   ?>
	    <script>location.href = "<? echo $red_url;  ?>";</script>	
		<?		
		exit; 
	}		
						
	if($print != ""){
		echo "$url?aid=$affiliate&pid=".$promo->id;
	}else{
		if(contains($url,"vrbmarketing.com")){
			$camp = get_campaigne_by_promo($promo);
					
			if($camp->book->id == 3 || $camp->book->id == 6 || $camp->book->id == 7 || $camp->book->id == 8 || $camp->book->id == 9 || $camp->book->id == 10){				
				$url_redirect = "custom_redir.php?aid=".$affiliate.$qscc."&rere&pid=".$promo->id."&bk=".$camp->book->id."&tgt=".$url."?aid=".$affiliate."/_as_/cc=".$customcampaing."/_as_/pid=".$promo->id;							
			}else{			
				$url_redirect = $url."?aid=".$affiliate."&pid=".$promo->id;
			}
			
		}else{
			$camp = get_campaigne_by_promo($promo);
			$url = clean_url($url, true);		
		    $url_redirect = "custom_redir.php?aid=".$affiliate.$qscc."&pid=".$promo->id."&rere&tgt=".$url."&bk=".$camp->book->id;
		}
		
		?>
        <script>location.href = "<? echo $url_redirect; ?>";</script>
        <?
		
	}
}
?>
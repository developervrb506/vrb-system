<?
include(ROOT_PATH . "/process/functions.php");

$ip = $_GET["ip"];
if(trim($ip) != ""){$_SERVER['REMOTE_ADDR'] = $ip;}

$parts = explode("-",$_GET["aid"]);
$affiliate = $parts[0];
$customcampaing = $parts[1];
$promo = get_promo($_GET["pid"]);

if($promo->name != "" && !isset($_GET["rere"])){
	add_click($promo->id, $affiliate,$customcampaing);	
}   
	
	$url = clean_url($_GET["tgt"], false);
	
	//Patch made by Andy Hines on 08/08/2023 to force the ssl to all our brands custom target links.
	
	if(!contains($url, "https")){
		   $url  = explode("://",$url);
		   $url_start = "https://";
		   $url_end = $url[1];
		   $url = $url_start.$url_end;		   
	}
	
	//End Patch
	
	$book = $_GET["bk"];
	
	if ( $book == 1 and contains($url,"sportsbettingonline") ) {		
	   $book = 3;		   
	}
	
	//Books cookies redirection
	if($book == 1){			
		
		if(contains($url,"mailto:")){
			?><script type="text/javascript">setTimeout('location.href = "http://www.wagerweb.com/redir.php?PromoID=<? echo  get_affiliate_code($affiliate, $book) ?>&mediaTypeID=11&url=http://www.wagerweb.com"');</script><?
			?><script type="text/javascript">location.href = "<? echo $url ?>";</script><?
		}else{
			/*$url = "http://www.wagerweb.com/redir.php?PromoID=". get_affiliate_code($affiliate, $book) ."&mediaTypeID=11&url=" . $url;
			header("Location: $url");*/
															
			if(!contains($_GET["tgt"],"category")){			
				$url2 = "http://www.wagerweb.com/services/bannerredirect?affiliateid=". get_affiliate_code($affiliate, $book);
			}else{
				$category = explode("=",$_GET["tgt"]);				
				$category = $category[1];
				$url2 = "http://www.wagerweb.com/services/bannerredirect?affiliateid=". get_affiliate_code($affiliate, $book)."&category=".$category;
			}
									
			?><iframe src="<? echo $url2 ?>" width="1" height="1" scrolling="no" frameborder="0"></iframe> <?
			?><?php /*?><script type="text/javascript">setTimeout('location.href = "<? echo $url ?>";', 2000);</script><?php */?><script type="text/javascript">setTimeout('location.href = "<? echo $url2 ?>";', 2000);</script><?
		}
		
	}
	
	if($book == 3){	
		
		$url = clean_url($url, true);	
				
		$red_url = "http://www.sportsbettingonline.ag/redir.php?cc=".$customcampaing."&pid=".$promo->id."&url=$url&aid=".$affiliate."&af=".get_affiliate_code($affiliate, $book);		
				
		if(contains($url,"vrbmarketing.com")){ 			
			header("Location: $red_url");
		}else{
			?>			
			<script type="text/javascript">location.href = "<? echo $red_url  ?>";</script><?
		}		
		
	}
	if($book == 4){                                    
		$url2 = "http://partners.commission.bz/processing/clickthrgh.asp?btag=". get_affiliate_code($affiliate, $book);
		?><iframe src="<? echo $url2 ?>" width="1" height="1" scrolling="no" frameborder="0"></iframe> <?
		?><script type="text/javascript">setTimeout('location.href = "<? echo $url ?>";', 2000);</script><?
	}	
	if($book == 5){
		$url = clean_url($url, true);
		header("Location: http://www.bookiepph.com/redir.php?cc=".$customcampaing."&pid=".$promo->id."&url=$url&aid=".$affiliate."&af=". get_affiliate_code($affiliate, $book));
	}
	if($book == 6){		
		
		$url = clean_url($url, true);
		$red_url = "http://www.playblackjack.com/redir.php?cc=".$customcampaing."&pid=".$promo->id."&url=$url&aid=".$affiliate."&af=". get_affiliate_code($affiliate, $book);
		
		if(contains($url,"vrbmarketing.com")){
			header("Location: $red_url");
		}else{
			?><script type="text/javascript">location.href = "<? echo $red_url  ?>";</script><?
		}
		
	}
	if($book == 7){		
		
		$url = clean_url($url, true);
		$red_url = "http://www.betowi.com/redir.php?cc=".$customcampaing."&pid=".$promo->id."&url=$url&aid=".$affiliate."&af=". get_affiliate_code($affiliate, $book);
		
		if(contains($url,"vrbmarketing.com")){
			header("Location: $red_url");
		}else{
			?><script type="text/javascript">location.href = "<? echo $red_url  ?>";</script><?
		}
		
	}
	
	if($book == 8){		
		
		$url = clean_url($url, true);
		$red_url = "http://www.bitbet.com/redir.php?cc=".$customcampaing."&pid=".$promo->id."&url=$url&aid=".$affiliate."&af=". get_affiliate_code($affiliate, $book);
		
		if(contains($url,"vrbmarketing.com")){
			header("Location: $red_url");
		}else{
			?><script type="text/javascript">location.href = "<? echo $red_url  ?>";</script><?
		}
		
	}
	
	if($book == 9){		
		
		$url = clean_url($url, true);
		$red_url = "http://www.horseracingbetting.com/redir.php?cc=".$customcampaing."&pid=".$promo->id."&url=$url&aid=".$affiliate."&af=". get_affiliate_code($affiliate, $book);
		
		if(contains($url,"vrbmarketing.com")){
			header("Location: $red_url");
		}else{
			?><script type="text/javascript">location.href = "<? echo $red_url  ?>";</script><?
		}
		
	}
	
	/*if($book == 10){		
		
		$url = clean_url($url, true);
		$red_url = "http://www.betlion365.com/redir.php?cc=".$customcampaing."&pid=".$promo->id."&url=$url&aid=".$affiliate."&af=". get_affiliate_code($affiliate, $book);
		
		if(contains($url,"vrbmarketing.com")){
			header("Location: $red_url");
		}else{
			?><script type="text/javascript">location.href = "<? echo $red_url  ?>";</script><?
		}		
	}*/
	
//}else{
	//echo "This page is no longer available";
//}
?>
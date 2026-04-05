<?php /*?><?php
require_once(ROOT_PATH . '/ck/process/functions.php');

    if ($ins == 1) {
	   $ins = "DEPOSIT REQUEST";	
	} elseif ($ins == 2) {
	   $ins = "PAYOUT REQUEST";	
	}
	
	$logo_chat_title = "title_livesupport_chat.png";	 
	$btn_chat = "btn_chat.png";
	$btn_close_window = "btn_close_window.png";
			
	if ($agsite_desc == 'betowi') {
	   $agsite = "BETOWI.COM CHAT REQUEST";   	   
	   $logo_chat = "betowi_logo_chat.png";	   
	} elseif ($agsite_desc == 'betandgetpaid') {
	   $agsite = "BETANDGETPAID.COM CHAT REQUEST";	   	   
	   $logo_chat = "betandgetpaid.com_logo_chat.png";
	} elseif ($agsite_desc == 'betraw') {
	   $agsite = "BETRAW.COM CHAT REQUEST";   	   
	   $logo_chat = "betraw.com_logo_chat.png";
	} elseif ($agsite_desc == 'betgoldenstate') {
	   $agsite = "BETGOLDENSTATE.COM CHAT REQUEST";   	   
	   $logo_chat = "betgoldenstate.com_logo_chat.png";
	} elseif ($agsite_desc == 'bet1cal') {
	   $agsite = "BET1CAL.COM CHAT REQUEST";   	   
	   $logo_chat = "bet1cal.com_logo_chat.png";
	} elseif ($agsite_desc == 'bookiepph') {
	   $agsite = "BOOKIEPPH.COM CHAT REQUEST";	
	   $logo_chat = "bookiepph_logo_chat.png";   	   
	} elseif ($agsite_desc == 'bookiepayperhead') {
	   $agsite = "BOOKIEPAYPERHEAD.COM CHAT REQUEST";	
	   $logo_chat = "bookiepayperhead_logo_chat.png";   	   
	} elseif ($agsite_desc == 'bookiepriceperhead') {
	   $agsite = "BOOKIEPRICEPERHEAD.COM CHAT REQUEST";
	   $logo_chat = "bookiepriceperhead_logo_chat.png";   	   
	} elseif ($agsite_desc == 'pph') {
	   $agsite = "PPH.AG CHAT REQUEST";
	   $logo_chat = "pphag_logo_chat.png";   	   
	} elseif ($agsite_desc == 'betthunder') {
	   $agsite = "BETTHUNDER CHAT REQUEST";   	   
	   $logo_chat = "betthunder_logo_chat.png";	
	} elseif ($agsite_desc == 'betsportsline') {
	   $agsite = "BETSPORTSLINE CHAT REQUEST";   	   
	   $logo_chat = "betsportsline.com_logo_chat.png";
	} elseif ($agsite_desc == 'probetus') {
	   $agsite = "PROBETUS CHAT REQUEST";	   
	   $logo_chat = "probetus_logo_chat.png";
	} elseif ($agsite_desc == 'ezpay') {
	   $agsite = "THIS IS AN EZPAY CHAT REQUEST";	
	   $logo_chat = "logo_ezpay_chat.png";	  
	   $logo_chat_title = "ezpay-title_livesupport_chat.png";   
	   $btn_chat = "ezpay-btn_chat.png";
	   $btn_close_window = "btn_close_window_ezpay.png";
	} elseif ($agsite_desc == 'sportsbettingonline' ) {
	   $agsite = "SPORTS BETTING ONLINE CHAT REQUEST";	
	   $logo_chat = "sbo_logo_chat.png";       
	} elseif ($agsite_desc == 'vrb') {
	   $agsite = "VRB MARKETING CHAT REQUEST";	
	   $logo_chat = "logo_vrb_chat.png";       
	} elseif ($agsite_desc == 'yourwebsite') {
	   $logo_chat = "yourwebsite.bookiepph.ag_logo_chat.png";       
	} elseif ($agsite_desc == 'tobybets') {
	   $agsite = "TOBY BETS CHAT REQUEST";	
	   $logo_chat = "tobybets.com_logo_chat.png";       
	} elseif ($agsite_desc == 'windycitywagering') {
	   $agsite = "WINDY CITY WAGERING CHAT REQUEST";	
	   $logo_chat = "windycitywagering_logo_chat.png";       
	}  elseif ($agsite_desc == 'puerto51') {
	   $agsite = "PUERTO 51 CHAT REQUEST";	
	   $logo_chat = "logo_puerto51_chat.png";       
	}  elseif ($agsite_desc == '247library') {
	   $agsite = "247 LIBRARY CHAT REQUEST";	
	   $logo_chat = "logo_247library_chat.png";       
	}  elseif ($agsite_desc == 'darocsports') {
	   $agsite = "DAROC SPORTS CHAT REQUEST";	
	   $logo_chat = "logo_darocsports_chat.png";       
	}  elseif ($agsite_desc == 'mahisports') {
	   $agsite = "MAHI SPORTS CHAT REQUEST";	
	   $logo_chat = "mahisports_logo_chat.png";       
	}  elseif ($agsite_desc == 'mipuerto51') {
	   $agsite = "MI PUERTO 51 CHAT REQUEST";	
	   $logo_chat = "mipuerto51_logo_chat.png";       
	}  elseif ($agsite_desc == 'betwcs') {
	   $agsite = "BET WEST COAST SPORTS CHAT REQUEST";	
	   $logo_chat = "betwcs.com_logo_chat.png";       
	}  elseif ($agsite_desc == 'completeaction') {
	   $agsite = "COMPLETE ACTION CHAT REQUEST";	
	   $logo_chat = "completeaction_logo_chat.png";       
	}  elseif ($agsite_desc == 'inspin') {
	   $agsite = "THIS IS AN INSPIN CHAT REQUEST";	
	   $logo_chat = "logo_inspin_chat.png";       
	}  elseif ($agsite_desc == 'luckydragon') {
	   $agsite = "LUCKY DRAGON CHAT REQUEST";	
	   $logo_chat = "luckydragon_logo_chat.png";       
	}  elseif ($agsite_desc == 'lhs4bets') {
	   $agsite = "LHS4BETS CHAT REQUEST";	
	   $logo_chat = "lhs4bets.com_logo_chat.png";       
	}  elseif ($agsite_desc == 'cc4bets') {
	   $agsite = "CC4BETS CHAT REQUEST";	
	   $logo_chat = "cc4bets_logo_chat.png";       
	}  elseif ($agsite_desc == 'tvs4bets') {
	   $agsite = "TVS4BETS CHAT REQUEST";	
	   $logo_chat = "tvs4bets_logo_chat.png";       
	}  elseif ($agsite_desc == 'red4bets') {
	   $agsite = "RED4BETS CHAT REQUEST";	
	   $logo_chat = "red4bets_logo_chat.png";       
	}  elseif ($agsite_desc == 'whiskey4bets') {
	   $agsite = "WHISKEY4BETS CHAT REQUEST";	
	   $logo_chat = "whiskey4bets_logo_chat.png";       
	}  elseif ($agsite_desc == 'dhs4bets') {
	   $agsite = "DHS4BETS CHAT REQUEST";	
	   $logo_chat = "dhs4bets_logo_chat.png";       
	}  elseif ($agsite_desc == 'sobe4bets') {
	   $agsite = "SOBE4BETS CHAT REQUEST";	
	   $logo_chat = "sobe4bets_logo_chat.png";       
	}  elseif ($agsite_desc == 'pb4bets') {
	   $agsite = "PB4BETS CHAT REQUEST";	
	   $logo_chat = "pb4bets.com_logo_chat.png";       
	}  elseif ($agsite_desc == 'doc4bets') {
	   $agsite = "DOC4BETS CHAT REQUEST";	
	   $logo_chat = "doc4bets.com_logo_chat.png";       
	}  elseif ($agsite_desc == 'partysports') {
	   $agsite = "PARTY SPORTS CHAT REQUEST";	
	   $logo_chat = "partysports_logo_chat.png";       
	}  elseif ($agsite_desc == 'partysportsbook') {
	   $agsite = "PARTY SPORTSBOOK CHAT REQUEST";	
	   $logo_chat = "partysportsbook_logo_chat.png";       
	}  elseif ($agsite_desc == 'silversportsbook') {
	   $agsite = "SILVER SPORTSBOOK CHAT REQUEST";	
	   $logo_chat = "silversportsbook_logo_chat.png";       
	}  elseif ($agsite_desc == '10pph') {
	   $agsite = "10 PPH CHAT REQUEST";	
	   $logo_chat = "10pph_logo_chat.png";       
	}  elseif ($agsite_desc == 'betjmansports') {
	   $agsite = "BET J MAN SPORTS CHAT REQUEST";	
	   $logo_chat = "betjmansports_logo_chat.png";       
	}  elseif ($agsite_desc == 'redsportsbook') {
	   $agsite = "RED SPORTSBOOK CHAT REQUEST";	
	   $logo_chat = "redsportsbook_logo_chat.png";       
	}  elseif ($agsite_desc == 'theperhead') {
	   $agsite = "THE PER HEAD CHAT REQUEST";	
	   $logo_chat = "theperhead_logo_chat.png";       
	}  elseif ($agsite_desc == 'theperheadshop') {
	   $agsite = "THE PER HEAD SHOP CHAT REQUEST";	
	   $logo_chat = "theperheadshop_logo_chat.png";       
	}  elseif ($agsite_desc == 'chanlines') {
	   $agsite = "CHAN LINES CHAT REQUEST";	
	   $logo_chat = "chanlines_logo_chat.png";       
	}  elseif ($agsite_desc == 'betasia999') {
	   $agsite = "BET ASIA 999 CHAT REQUEST";	
	   $logo_chat = "betasia999_logo_chat.png";       
	}  elseif ($agsite_desc == 'playblackjack') {
	   $agsite = "PLAYBLACKJACK CHAT REQUEST";	
	   $logo_chat = "playblackjack_logo_chat.png";       
	}  elseif ($agsite_desc == '247apuestas') {
	   $agsite = "247APUESTAS CHAT REQUEST";	
	   $logo_chat = "247apuestas_logo_chat.png";       
	}  elseif ($agsite_desc == 'cnasports') {
	   $agsite = "CNA SPORTS CHAT REQUEST";	
	   $logo_chat = "cnasports_logo_chat.png";       
	}  elseif ($agsite_desc == 'betpops') {
	   $agsite = "BET POPS CHAT REQUEST";	
	   $logo_chat = "betpops_logo_chat.png";       
	}  elseif ($agsite_desc == 'broadstreetbets') {
	   $agsite = "BROAD STREET BETS CHAT REQUEST";	
	   $logo_chat = "broadstreetbets.com_logo_chat.png";       
	}  elseif ($agsite_desc == 'ganabet') {
	   $agsite = "GANABET CHAT REQUEST";	
	   $logo_chat = "ganabet_logo_chat.png";       
	}  elseif ($agsite_desc == 'betbambino') {
	   $agsite = "BETBAMBINO CHAT REQUEST";	
	   $logo_chat = "betbambino_logo_chat.png";       
	}  elseif ($agsite_desc == 'bet2win') {
	   $agsite = "BET2WIN CHAT REQUEST";	
	   $logo_chat = "bet2win_logo_chat.png";       
	}  elseif ($agsite_desc == 'betya') {
	   $agsite = "BETYA CHAT REQUEST";	
	   $logo_chat = "betya_logo_chat.png";       
	}  elseif ($agsite_desc == 'acabets') {
	   $agsite = "ACABETS CHAT REQUEST";	
	   $logo_chat = "acabets_logo_chat.png";       
	}  elseif ($agsite_desc == 'betmas') {
	   $agsite = "BETMAS CHAT REQUEST";	
	   $logo_chat = "betmas_logo_chat.png";       
	}  elseif ($agsite_desc == 'cabobet') {
	   $agsite = "CABOBET CHAT REQUEST";	
	   $logo_chat = "cabobet_logo_chat.png";       
	}  elseif ($agsite_desc == 'vipmex') {
	   $agsite = "VIPMEX CHAT REQUEST";	
	   $logo_chat = "vipmex_logo_chat.png";       
	}  elseif ($agsite_desc == 'aquabet') {
	   $agsite = "AQUABET CHAT REQUEST";	
	   $logo_chat = "aquabet_logo_chat.png";       
	}  elseif ($agsite_desc == 'usracing') {
	   $agsite = "US RACING CHAT REQUEST";	
	   $logo_chat = "usracing_logo_chat.png";       
	}  elseif ($agsite_desc == 'pphbet') {
	   $agsite = "PPH BET CHAT REQUEST";	
	   $logo_chat = "pphbet_logo_chat.png";       
	}  elseif ($agsite_desc == 'trinibets') {
	   $agsite = "TRINIBETS CHAT REQUEST";	
	   $logo_chat = "trinibets_logo_chat.png";       
	}  elseif ($agsite_desc == 'ironsportsbook') {
	   $agsite = "IRONSPORTSBOOK CHAT REQUEST";	
	   $logo_chat = "ironsportsbook.com_logo_chat.png";       
	}  elseif ($agsite_desc == 'ur688') {
	   $agsite = "UR688.COM CHAT REQUEST";	
	   $logo_chat = "ur688_logo_chat.png";       
	}  elseif ($agsite_desc == 'easytowager') {
	   $agsite = "EASYTOWAGER.COM CHAT REQUEST";	
	   $logo_chat = "easytowager_logo_chat.png";       
	}  elseif ($agsite_desc == 'bet1234') {
	   $agsite = "BET1234.COM CHAT REQUEST";	
	   $logo_chat = "bet1234_logo_chat.png";       
	}  elseif ($agsite_desc == 'playeast') {
	   $agsite = "PLAYEAST.COM CHAT REQUEST";	
	   $logo_chat = "playeast_logo_chat.png";       
	}  elseif ($agsite_desc == 'horseracingbetting') {
	   $agsite = "HORSERACINGBETTING.COM CHAT REQUEST";	
	   $logo_chat = "horseracingbetting_logo_chat.png";       
	}  elseif ($agsite_desc == 'bitbet') {
	   $agsite = "BITBET.COM CHAT REQUEST";	
	   $logo_chat = "bitbet_logo_chat.png";       
	}  elseif ($agsite_desc == 'oakmontsports') {
	   $agsite = "OAKMONTSPORTS.COM CHAT REQUEST";	
	   $logo_chat = "oakmontsports_logo_chat.png";       
	}  elseif ($agsite_desc == 'pgfcasino') {
	   $agsite = "PGF CASINO CHAT REQUEST";	
	   $logo_chat = "pgfcasino_logo_chat.png";       
	}  elseif ($agsite_desc == 'compart') {
	   $agsite = "COMMISSION PARTNERS CHAT REQUEST";	
	   $logo_chat = "compart_logo_chat.png";       
	}  elseif ($agsite_desc == 'thebestperhead') {
	   $agsite = "THEBESTPERHEAD.COM CHAT REQUEST";	
	   $logo_chat = "thebestperhead.com_logo_chat.png";   	   
	}  elseif ($agsite_desc == 'betlion365') {
	   $agsite = "BETLION365.COM CHAT REQUEST";	
	   $logo_chat = "betlion365.com_logo_chat.png";   	   
	}  elseif ($agsite_desc == '1betvegasnow') {
	   $agsite = "1BETVEGASNOW.COM CHAT REQUEST";	
	   $logo_chat = "1betvegasnow_logo_chat.png";   	   
	}  elseif ($agsite_desc == 'actionsports') {
	   $agsite = "ACTIONSPORTS.AG CHAT REQUEST";	
	   $logo_chat = "actionsports.ag_logo_chat.png";   	   
	}  elseif ($agsite_desc == 'bet123') {
	   $agsite = "BET123.AG CHAT REQUEST";	
	   $logo_chat = "bet123_logo_chat.png";   	   
	}  elseif ($agsite_desc == 'fireonsports') {
	   $agsite = "FIREONSPORTS.AG CHAT REQUEST";	
	   $logo_chat = "fireonsports.ag_logo_chat.png";   	   
	}  elseif ($agsite_desc == 'palmarealcasinogames') {
	   $agsite = "PALMAREALCASINOGAMES.COM CHAT REQUEST";	
	   $logo_chat = "palmarealcasinogames_logo_chat.png";   	    
	}  elseif ($agsite_desc == 'westcoastwager') {
	   $agsite = "WESTCOASTWAGER.AG CHAT REQUEST";	
	   $logo_chat = "westcoastwager_logo_chat.png";   	    
	}  elseif ($agsite_desc == 'uswager365') {
	   $agsite = "USWAGER365.AG CHAT REQUEST";	
	   $logo_chat = "uswager365_logo_chat.png";   	    
	}  elseif ($agsite_desc == 'betsls') {
	   $agsite = "BETSLS.COM CHAT REQUEST";	
	   $logo_chat = "betsls_logo_chat.png";   	    
	}  elseif ($agsite_desc == 'betsharp') {
	   $agsite = "BETSHARP.AG CHAT REQUEST";	
	   $logo_chat = "betsharp.ag_logo_chat.png";   	    
	}  elseif ($agsite_desc == 'detroitbetcity') {
	   $agsite = "DETROITBETCITY.COM CHAT REQUEST";	
	   $logo_chat = "detroitbetcity.com_logo_chat.png";   	    
	} elseif ($agsite_desc == 'bigmansports') {
	   $agsite = "BIGMANSPORTS.AG CHAT REQUEST";	
	   $logo_chat = "bigmansports.ag_logo_chat.png";   	    
	} elseif ($agsite_desc == 'ubetphil') {
	   $agsite = "UBETPHIL.COM CHAT REQUEST";	
	   $logo_chat = "ubetphil.com_logo_chat.png";   	    
	}  elseif ($agsite_desc == 'endzone88') {
	   $agsite = "ENDZONE88.COM CHAT REQUEST";	
	   $logo_chat = "endzone88.com_logo_chat.png";   	    
	}  elseif ($agsite_desc == 'next888') {
	   $agsite = "NEXT888.NET CHAT REQUEST";	
	   $logo_chat = "next888.net_logo_chat.png";   	    
	}  elseif ($agsite_desc == 'nextodds') {
	   $agsite = "NEXTODDS.NET CHAT REQUEST";	
	   $logo_chat = "nextodds.net_logo_chat.png";   	    
	}  elseif ($agsite_desc == '24hourbets') {
	   $agsite = "24HOURBETS.AG CHAT REQUEST";	
	   $logo_chat = "24hourbets.ag_logo_chat.png";   	    
	}  elseif ($agsite_desc == '247sports') {
	   $agsite = "247SPORTS.AG CHAT REQUEST";	
	   $logo_chat = "247sports.ag_logo_chat.png";   	    
	}  elseif ($agsite_desc == '105asia') {
	   $agsite = "105ASIA.COM CHAT REQUEST";	
	   $logo_chat = "105asia.com_logo_chat.png";   	    
	}  elseif ($agsite_desc == 'sportsaction77') {
	   $agsite = "SPORTSACTION77.AG CHAT REQUEST";	
	   $logo_chat = "sportsaction77.ag_logo_chat.png";   	    
	}  elseif ($agsite_desc == 'sports708') {
	   $agsite = "SPORTS708.AG CHAT REQUEST";	
	   $logo_chat = "sports708.ag_logo_chat.png";   	    
	}  elseif ($agsite_desc == 'chicagobets99') {
	   $agsite = "CHICAGOBETS99.AG CHAT REQUEST";	
	   $logo_chat = "chicagobets99.ag_logo_chat.png";   	    
	}  elseif ($agsite_desc == 'primetimeaction') {
	   $agsite = "PRIMETIMEACTION.AG CHAT REQUEST";	
	   $logo_chat = "primetimeaction.ag_logo_chat.png";   	    
	}  elseif ($agsite_desc == 'rush2bet') {
	   $agsite = "RUSH2BET.AG CHAT REQUEST";	
	   $logo_chat = "rush2bet.ag_logo_chat.png";   	    
	}  elseif ($agsite_desc == 'legends') {
	   $agsite = "LEGENDS.AG CHAT REQUEST";	
	   $logo_chat = "legends.ag_logo_chat.png";   	    
	}  elseif ($agsite_desc == 'vegasbetclub') {
	   $agsite = "VEGASBETCLUB.COM CHAT REQUEST";	
	   $logo_chat = "vegasbetclub.com_logo_chat.png";   	    
	}elseif ($agsite_desc == '1betworld') {
	   $agsite = "1BETWORLD.COM CHAT REQUEST";	
	   $logo_chat = "1betworld.ag_logo_chat.png";   	    
	}elseif ($agsite_desc == 'vegasoffshore') {
	   $agsite = "VEGASOFFSHORE.COM CHAT REQUEST";	
	   $logo_chat = "vegasoffshore.ag_logo_chat.png";   	    
	}elseif ($agsite_desc == '789def') {
	   $agsite = "789DEF.COM CHAT REQUEST";	
	   $logo_chat = "789def.ag_logo_chat.png";   	    
	}elseif ($agsite_desc == 'skydragon') {
	   $agsite = "SKYDRAGON.AG CHAT REQUEST";	
	   $logo_chat = "skydragon.ag_logo_chat.png";   	    
	}elseif ($agsite_desc == 'gk-investor') {
	   $agsite = "GK-INVESTOR.COM CHAT REQUEST";	
	   $logo_chat = "gk-investor.com_logo_chat.png";   	    
	}elseif ($agsite_desc == 'pick6') {
	   $agsite = "PICK6.BIZ CHAT REQUEST";	
	   $logo_chat = "pick6.biz_logo_chat.png";   	    
	}elseif ($agsite_desc == 'unclemicksports') {
	   $agsite = "UNCLEMICKSPORTS.NET CHAT REQUEST";	
	   $logo_chat = "unclemicksports.net_logo_chat.png";   	    
	}elseif ($agsite_desc == 'sportsgamblingidol') {
	   $agsite = "SPORTSGAMBLINGIDOL.COM CHAT REQUEST";	
	   $logo_chat = "sportsgamblingidol.com_logo_chat.png";   	    
	}elseif ($agsite_desc == 'sumo168') {
	   $agsite = "SUMO168.NET CHAT REQUEST";	
	   $logo_chat = "sumo168.net_logo_chat.png";   	    
	}elseif ($agsite_desc == 'chitownbets') {
	   $agsite = "CHITOWNBETS.AG CHAT REQUEST";	
	   $logo_chat = "chitownbets.ag_logo_chat.png";   	    
	}elseif ($agsite_desc == 'ec-investor') {
	   $agsite = "EC-INVESTOR.AG CHAT REQUEST";	
	   $logo_chat = "ec-investor.ag_logo_chat.png";   	    
	}elseif ($agsite_desc == 'thevig') {
	   $agsite = "THEVIG.AG CHAT REQUEST";	
	   $logo_chat = "thevig.ag_logo_chat.png";   	    
	}elseif ($agsite_desc == 'betwc.pph.ag') {
	   $agsite = "BETWC.PPH.AG CHAT REQUEST";	
	   $logo_chat = "betwc.pph.ag_logo_chat.png";   	    
	}elseif ($agsite_desc == 'ebets365.com') {
	   $agsite = "EBETS365.COM CHAT REQUEST";	
	   $logo_chat = "ebets365.com_logo_chat.png";   	    
	}elseif ($agsite_desc == 'ewagers365.com') {
	   $agsite = "EWAGERS365.COM CHAT REQUEST";	
	   $logo_chat = "ewagers365.com_logo_chat.png";   	    
	}elseif ($agsite_desc == 'supremebet.net') {
	   $agsite = "SUPREMEBET.NET CHAT REQUEST";	
	   $logo_chat = "supremebet.net_logo_chat.png";   	    
	}
?><?php */?>
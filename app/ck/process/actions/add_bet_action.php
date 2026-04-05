<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->im_allow("betting_basics")){ ?>
<?

$bet = new _bet();

$account = get_betting_account_by_name(clean_get("account"));
$idf = get_betting_identifier_by_name(clean_get("identifier"));

$bet->vars["account"] = $account->vars["id"];
$bet->vars["line"] = clean_get("preline").clean_get("line");
$bet->vars["risk"] = clean_get("risk");
$bet->vars["win"] = clean_get("win");
$bet->vars["identifier"] = $idf->vars["id"];
$bet->vars["gameid"] = clean_get("gameid");
$bet->vars["period"] = clean_get("period");
$bet->vars["team"] = clean_get("team");
$bet->vars["type"] = clean_get("type");

$bet->vars["bdate"] = clean_get("date");
$bet->vars["place_date"] = date("Y-m-d H:i:s");
$bet->vars["user"] = $current_clerk->vars["id"];

$bet->vars["account_percentage"] = $account->vars["description"];

$bet->insert();

setcookie("current_account", $account->vars["name"],0,"/",".vrbmarketing.com");


$agnt = array("GG803","GG1136","GG431","GGCOWBOY","GG59071","GG9687","GG354","GG505");
if (in_array($account->vars["name"],$agnt)){

		
	      //$total_risk = get_value_to_risk($account->vars["name"],clean_get("risk"),clean_get("league"));
	      $total_risk = true;
        if($total_risk) {
		  //$amount = $total_risk;	
		  $amount = clean_get('risk') * 0.01;
		  //if($amount > 10){ $amount= $amount / 2;}
		  $amount = 3;
		  
		  
		  $pre = clean_get("preline");		
		  $period = fix_period(strtolower(clean_get("period")));
		  $type = fix_type(strtolower(clean_get("type")),$pre[0]);	
		 $data = 'sport='.clean_get("league").'&rot='.clean_get("rotation").'&type='.$type.'&period='.$period.'&preline='.$pre.'&line='.clean_get("line").'&amount='.$amount;
		//  $data1 = 'sport='.clean_get("league").'&rot='.clean_get("rotation").'&type='.$type.'&period='.$period.'&preline='.$pre.'&line='.clean_get("line").'&amount=8';
		 
	
		  $result = @file_get_contents('http://auto.mega6789.net/ck/direct.php?'.$data);
		 
		$content = $data." - ".clean_get("team")." - ".$result;
		$content .=  "<BR><BR><BR>SPORT: <strong>".clean_get('league')."</strong><BR>ROT: <strong>".clean_get('rotation')."</strong><BR>TYPE: <strong>".$type."</strong><BR>PERIOD: <strong>".$period."</strong><BR>PRELINE: <strong>".$pre."</strong><BR>LINE: <strong>".clean_get('line')."</strong><BR>AMOUNT: $<strong>".$amount."</strong><BR>TEAM: <strong>".clean_get('team')."</strong><BR>RESULT: <strong>".$result."</strong><BR>RISK: <strong>".clean_get('risk')."</strong><BR>BET: <strong>".(clean_get('risk') * 0.04)."</strong><BR>TS: <strong>".date("Y-m-d H:i:s")."</strong>"; 
		
		// TELEGRAM
			$users = get_telegram_users();
              $msj =  "BET VRB ".$account->vars["name"]."/n/n" ;
			  $msj .= str_replace("<BR>","/n",$content);
			  $msj = str_replace("<strong>","",$msj);
  			  $msj = str_replace("</strong>","",$msj);
			  
			  $telegram = new _Bot("");
			  foreach ($users as $user ){
			 
				$chatid= $user->vars['phone_id'];
				$result = json_decode($telegram->envioMensajeProcesos($chatid,$msj),true);
				break;
 	  	  
            }
		//
		 
		 send_email_ck("alexis.andrade@gmail.com", "BET VRB ".$account->vars["name"],$content, true);	
		
		
 }

/*
		if($account->vars["name"] == 'GG375' || $account->vars["name"] == 'GG020' || $account->vars["name"] == 'GGLENNY' ){
			
			$risk = clean_get("risk");
			
			if($account->vars["name"] == 'GG375' || $account->vars["name"] == 'GGLENNY'){
				
			  if($risk >= 1750) { $amount = 40;}	
			  if($risk <= 1749 && $risk > 700) { $amount = 20;}	
			  if($risk <= 699 ) { $amount = 10;}		  
			
			}
			if($account->vars["name"] == 'GG020'){
			  if($risk > 4000) { $amount = 40; }	
			   else {  $amount = 20;}	
			}
			
    	 $pre = clean_get("preline");		
		 $period = fix_period(strtolower(clean_get("period")));
		 $type = fix_type(strtolower(clean_get("type")),$pre[0]);
		 //if($type == "tto" || $type == "ttu"){ $period = "GAME"; }
		 
			
			
		 $data = 'sport='.clean_get("league").'&rot='.clean_get("rotation").'&type='.$type.'&period='.$period.'&preline='.$pre.'&line='.clean_get("line").'&amount='.$amount;
		
		 
		if($type != "tto" && $type != "ttu"){
		  $result = @file_get_contents('http://auto.mega6789.net/ck/direct.php?'.$data);
		} else { $result = " PLEASE ENTER MANUALLY ";}
		 
		$content = $data." - ".clean_get("team")." - ".$result;
		$content .=  "<BR><BR><BR>SPORT: <strong>".clean_get('league')."</strong><BR>ROT: <strong>".clean_get('rotation')."</strong><BR>TYPE: <strong>".$type."</strong><BR>PERIOD: <strong>".$period."</strong><BR>PRELINE: <strong>".$pre."</strong><BR>LINE: <strong>".clean_get('line')."</strong><BR>AMOUNT: $<strong>".$amount."</strong><BR>TEAM: <strong>".clean_get('team')."</strong><BR>RESULT: <strong>".$result."</strong>"; 
		 
		 send_email_ck("alexis.andrade@gmail.com,arceinc@gmail.com", "BET VRB ".$account->vars["name"],$content, true);	
}
*/

} //in array

//header("Location: ../../insert_bet.php?good");
?>
<script type="text/javascript">
current_money = parent.document.getElementById("m_<? echo biencript($bet->vars["gameid"]."/".$bet->vars["team"]."/".$bet->vars["type"]) ?>").innerHTML;
parent.document.getElementById("m_<? echo biencript($bet->vars["gameid"]."/".$bet->vars["team"]."/".$bet->vars["type"]) ?>").innerHTML = parseInt(current_money) + parseInt(<? echo $bet->get_money(); ?>);

location.href = "../../insert_bet.php?good";
</script>
<? }else{echo "Access Denied";} ?>

<?

function get_value_to_risk($agnt,$risk,$league){
	
 	switch ($agnt){
		case  "GG375":
					if($league == 'nba' || $league == 'nhl'){ 
					  if($risk >= 1750) { $amount = 40;}	
					  if($risk <= 1749 && $risk > 700) { $amount = 20;}	
					  if($risk <= 699 ) { $amount = 10;}		  
					} else { $amount = 0;}
			  break;		
		case  "GGLENNY":
					if($league == 'nba' || $league == 'nhl'){ 
					  if($risk >= 1750) { $amount = 40;}	
					  if($risk <= 1749 && $risk > 700) { $amount = 20;}	
					  if($risk <= 699 ) { $amount = 10;}		  
					} else { $amount = 0;}
			  break;
		case  "GG020":
				   if($risk > 4000) { $amount = 40; }	
				   else {  $amount = 20;}	
			  break;
		case  "GG156907":
					if($league == 'mlb'){ 
					  if($risk >= 1750) { $amount = 20;}	
					  if($risk <= 1749 && $risk > 700) { $amount = 12;}	
					  if($risk <= 699 ) { $amount = 8;}		  
					} else { $amount = 0;}
			  break;		
			  
		case  "GG58026":
					if($league == 'mlb'){ 
					  if($risk >= 1750) { $amount = 20;}	
					  if($risk <= 1749 && $risk > 700) { $amount = 12;}	
					  if($risk <= 699 ) { $amount = 8;}		  
					} else { $amount = 0;}
			  break;			    
	
   }
 return $amount;
}















 function fix_period($period) {
	
	switch ($period){
	case  "game":
	   $period = "GAME";
	   break;
	case "1st quarter":
	   $period = "1Q";
	   break;
	   
	case "2nd quarter":
	   $period = "2Q";
	   break;
	case "3er quarter":
	   $period = "3Q";
	   break;
	   	   
	case "1 half" :
	  $period = "1H" ;
	  break;
	  
	  case "2 half" :
	  $period = "2H";
	  break;
	  
	  case "1st 5 Innings":
	   $period = "1H" ;
	   break;
	  
	}
	return $period; 
 
	
}

function fix_type($type,$pre) {
	
	switch ($type){
	case  "money":
	   $type = "m";
	   break;
	case "spread":
	   $type = "s";
	   break;
	   
	
    case "total":
      if($pre == 'o'){
  		 $type = $pre;
   	  }
     if ($pre == 'u'){
	  $type = $pre; 
      }
     break;
  
	   	   
	case "over_team_totals" :
	  $type = "tto" ;
	  break;
	  
	case "under_team_totals" :
	  $type = "ttu" ;
	  break;
	
	}
	return $type; 
 
	
  }
	?>
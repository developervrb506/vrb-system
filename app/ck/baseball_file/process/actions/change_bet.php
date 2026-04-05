<? 
include(ROOT_PATH . "/ck/process/security.php");



/*
$_POST['ac'] = 'ex';
$_POST['date'] = '2025-07-09';
$_POST['game'] = '8918821';
$_POST['type'] = 'Money';
$_POST['team'] = 'AWAY';
$_POST['spreadRange'] = '';
$_POST['overUnder'] = '';
$_POST['totalRange'] = '';
*/
$source = param('ac');
$date = param('date',false);
$game = param('game');
$type = param('type');


if($type == "Total"){
  $value =  param('totalRange');	
  $btype = param('overUnder');
} else if ($type == "Spread") {
  $value =  param('spreadRange',false);
  $btype = param('team');
} else if ($type == 'Money'){
	$btype = param('team');
}


	
  $bet = get_baseball_game_bet($game,$type,$source);
  if(is_null($bet)){
	 $bet = new _baseball_bet();
	 $bet->vars["line_type"]= $type;
 	 $bet->vars["bet_type"]= $btype;
	 $bet->vars["game"]= $game;
	 $bet->vars["value"]= $value;
	 $bet->vars["status"]= "-1";
	 $bet->vars["date"]= $date;
	 $bet->vars["source"]= $source;
	 $bet->insert();
	 
	 
  }else {
	 $bet->vars["line_type"]= $type;
 	 $bet->vars["bet_type"]= $btype;
	 $bet->vars["game"]= $game;
	 $bet->vars["value"]= $value;
	 $bet->vars["status"]= "-1";	 
 	 $bet->vars["date"]= $date;
	    	 $bet->update(); 
	
	  
  }
  
  $subject = 'MIKE BET ';
	$content = $bet->vars["bet_type"]." CHECK BASEBALL";
	
	send_email_ck_auth('aandradevrb@gmail.com', $subject, $content, true, $current_clerk->vars["fake_email"]);



?>
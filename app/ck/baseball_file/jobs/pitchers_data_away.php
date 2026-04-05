<? 
require_once(ROOT_PATH . "/ck/db/handler.php"); 
require_once(ROOT_PATH . '/includes/html_dom_parser.php'); 
require_once(ROOT_PATH . '/ck/baseball_file/process/functions.php');

set_time_limit(0);

echo "<pre>";
$year = date("Y");	
$today = date("Y-m-d");
$type = "home";


 $games =  get_players_by_date_pending_update($today,$type,'data');


  foreach ($games as $game) {
  	

  	get_data_player($game->vars['fangraphs_player'],$year,$game->vars['game']);
 
  }


function get_data_player($playerid,$year,$gameid){

$link = "http://www.fangraphs.com/statss.aspx?playerid=9434&position=P";

$data = file_get_contents('https://cdn.fangraphs.com/api/players/game-log?playerid='.$playerid.'&position=P&season='.$year.'&type=4');

$data = json_decode($data,true);


$info = array();

foreach($data['mlb'] as $d){
   $info[$d['Date']] = $d;
}


$data = array();
$data["j"] =  count($info);
$data["date"]= date("Y-m-d");


$j = 0;
$total_pitches = 0;
foreach ($info as $player_data) {

	if($j==0){
     $data['avg_season'] = round($player_data['Pitches'] / ($data["j"] - 1));
	 $data['groundball'] =  round(($player_data['GB%'] * 100),2);
	 $data['sl'] =  round(($player_data['SL%'] * 100),2);
	 $data['ct'] =  round(($player_data['CT%'] * 100),2);
	 $data['cb'] =  round(($player_data['CB%'] * 100),2);
	 $data['ch'] =  round(($player_data['CH%'] * 100),2);
	 $data['sf'] =  round(($player_data['SF%'] * 100),2);
	 $data['kn'] =  round(($player_data['KN%'] * 100),2);
	 $data['xx'] =  round(($player_data['XX%'] * 100),2);
	 $data['fb'] =  round($player_data['FBv'],2);
	 $data['era'] =  round($player_data['ERA'],2);
	 $data['xfip'] =  round($player_data['xFIP'],2);
	 $data['k9'] =  round($player_data['K/9'],2);
	 $data["avg_season_velocity"] = 0;
	}

	if($j==1){
		$data["date"] = strip_tags($player_data['Date']); 
		$total_pitches = $player_data['Pitches'] + $total_pitches;
		$data["total_last_game"] = $total_pitches;
		$data["total_last_game_velocity"] = 0;
	}
	if($j==2){
		$total_pitches = $player_data['Pitches'] + $total_pitches;
		 $data["total_last_two_games_velocity"] = 0;
	}
	if($j==3){
		$total_pitches = $player_data['Pitches'] + $total_pitches;
		$data["avg_last_games"] = $total_pitches / 3 ;
		 $data["sum_last_games"] = $total_pitches ;
	}
	if($j==4){
		$total_pitches = $player_data['Pitches'] + $total_pitches;
		$data["avg_last_four_games"] = $total_pitches / 4 ;
		 $data["sum_last_four_games"] = $total_pitches ;
	}
	if($j==5){
		$total_pitches = $player_data['Pitches'] + $total_pitches;
		$data["avg_last_five_games"] = $total_pitches / 5 ;
		 $data["sum_last_five_games"] = $total_pitches ;
	}
 $j++;	
}






	      $data["total_last_game_velocity"] = 0;
		  $data["total_last_two_games_velocity"] = 0;
		  $data["avg_season_velocity"] = 0;
		  $data["total_season"] = 0;





             $diff = abs(strtotime(date('Y-m-d')) - strtotime($data["date"]));
			 $years = floor($diff / (365*60*60*24));
			 $months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
			 $days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));
			 $rest_time=" "; 
	
			 if ($years){
			   $rest_time = $years." years, ";   
			 }
			 if ($months){   
			   $rest_time.= $months. " months, ";	 
			 }
			 if ($days){   
			   $rest_time.= $days. " days";	 
			 }
			 
			 $statistics = get_player_basic_stadistics($playerid,$year,false,$gameid);
			 //print_r($statistics);
			 
			 if (is_null($statistics)){
				$last_season = true; 
			    $statistics = new _baseball_player_stadistics_by_game();  
			    $statistics->vars["fangraphs_player"] = $playerid;
			 }
		

		    if ($data["j"]==1){
		      $rest_time ='0'; // To control that players that does not have any game this season
			} 
	
	 
		 $statistics->vars["season"] = $year;
		 $statistics->vars["game"] = $gameid;
		 $statistics->vars["rest_time"] = $rest_time;
		 $statistics->vars["total_last_game"] = $data["total_last_game"];
		 $statistics->vars["avg_last_games"] = $data["avg_last_games"];
		 $statistics->vars["sum_last_games"] =  $data["sum_last_games"];
		 $statistics->vars["avg_season"] = $data["avg_season"];
		 $statistics->vars["avg_last_four_games"] = $data["avg_last_four_games"];
		 $statistics->vars["sum_last_four_games"] =  $data["sum_last_four_games"];
	     $statistics->vars["avg_last_five_games"] = $data["avg_last_five_games"];
		 $statistics->vars["sum_last_five_games"] =  $data["sum_last_five_games"];
		 $statistics->vars["last_game_velocity"] = $data["total_last_game_velocity"];
		 $statistics->vars["last_two_game_velocity"] = $data["total_last_two_games_velocity"];
		 $statistics->vars["season_velocity"] =  $data["avg_season_velocity"];
		 $statistics->vars["gb"] = $data['groundball'];
 	     $statistics->vars["k9"] = $data['k9'];
 	     $statistics->vars["fb"] = $data['fb'];
		 $statistics->vars["sl"] = $data['sl'];
		 $statistics->vars["ct"] =  $data['ct'];
		 $statistics->vars["cb"] =  $data['cb'];
		 $statistics->vars["ch"] =  $data['ch'];
		 $statistics->vars["sf"] =  $data['sf'];
		 $statistics->vars["kn"] =  $data['kn'];
		 $statistics->vars["xx"] =  $data['xx'];
		 $statistics->vars["era"] = $data["era"];
		 $statistics->vars["xfip"] = $data["xfip"];

		 /*
		 $statistics->vars["ct_total"] = str_replace("&nbsp;"," ",$colums["ct_total"]); 
		 $statistics->vars["sl_total"] = str_replace("&nbsp;"," ",$colums["sl_total"]);
		 $statistics->vars["cb_total"] = str_replace("&nbsp;"," ",$colums["cb_total"]);
		 $statistics->vars["ch_total"] = str_replace("&nbsp;"," ",$colums["ch_total"]);	  
		 $statistics->vars["sf_total"] = str_replace("&nbsp;"," ",$colums["sf_total"]);	  
		 $statistics->vars["xx_total"] = str_replace("&nbsp;"," ",$colums["xx_total"]);
		 $statistics->vars["kn_total"] = str_replace("&nbsp;"," ",$colums["kn_total"]);	  
		 $statistics->vars["fb_total"] = str_replace("&nbsp;"," ",$colums["fb_total"]);
 	     $statistics->vars["gb_total"] = str_replace("&nbsp;"," ",$colums["gb_total"]);
         $statistics->vars["k9_total"] = str_replace("&nbsp;"," ",$colums["k9_total"]);	 
		 */

           print_r($statistics); 

		   if (!$last_season){
      		  $statistics->update(); 
		      echo "UPDATE NOW";
		  }
		  else{
			 if(!is_null($statistics)){
			   $statistics->insert(); 
			   echo "INSERT NOW";
			 }
		  }


}



echo "---------------<BR>";
echo "DATA FOR PITCHERS_AWAY<br>";
echo "---------------<BR><BR>";



echo "</pre>";


?>
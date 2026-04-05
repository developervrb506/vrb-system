<? 
require_once(ROOT_PATH . "/ck/db/handler.php"); 
require_once('../../../includes/html_dom_parser.php'); 
set_time_limit(0);



echo "---------------<BR>";
echo "DATA FOR PITCHERS_HOME<br>";




$games = get_games_format($date);
$i=0;
foreach ($games as $game){
	
	$year = date('Y',strtotime($game->vars["startdate"]));
     
	 $game_date = date('Y-m-d',strtotime($game->vars["startdate"]));
	 
	     echo "Pitcher HOME<BR>";
    if ($game->vars["pitcher_home"]){
	   $player_h = get_baseball_player_by_id("fangraphs_player",$game->vars["pitcher_home"]);
	   get_player_pitches($player_h->vars["fangraphs_player"],$player_h->vars["player"],$year,false,$game->vars["id"],$game_date);
	}
$i++;

 /*if ($i==4){  
    break;
  }*/


}



function get_player_pitches($playerid,$player_name,$year,$last_season=false,$gameid,$game_date){

	 if (!$last_season){
	   $statistics = get_player_basic_stadistics($playerid,($year-1));
	
	    if (is_null($statistics)){
	      echo "Last Season<BR>";
	      get_player_pitches($playerid,$player_name,($year-1),true,"",$game_date);
	      $last_season=false;
	   }
	  }
	
	$html = file_get_html_parts(80000,0,"http://www.fangraphs.com/statsd.aspx?playerid=".$playerid."&position=P&type=4&season=".$year."");
	
	echo "http://www.fangraphs.com/statsd.aspx?playerid=".$playerid."&position=P&type=4&season=".$year."";
		  
	  ?>
	  <table width="25%" border="1" cellspacing="0" cellpadding="0">
			
	  <tr> 
	    <? echo $_team["team_name"];?>
	  </tr>
	  <tr>
	    <td class="table_header">Date</td>
	    <td class="table_header">Team</td>
	    <td class="table_header">Opp</td>
	    <td class="table_header">Pitches</td>
	  </tr>
	  <tr> 
	    <? echo $player_name ?><BR>
	  </tr>
 	  <tr>
	  <?
		  
		  $data = array();
		  $data["date"] = 0;
		  $data["previous_date"] = 0;
		  $data["total_last_game"] = 0;
		  $data["avg_last_games"] = 0;
		  $data["avg_season"] = 0;
		  $data["total_season"] = 0;
		  $data["sum_last_games"]=0;


		  $pre_data = array();
		  $pre_data["date"] = 0;
		  $pre_data["previous_date"] = 0;
		  $pre_data["total_last_game"] = 0;
		  $pre_data["avg_last_games"] = 0;
		  $pre_data["avg_season"] = 0;
		  $pre_data["total_season"] = 0;
		  $pre_data["sum_last_games"]=0;


		  $last_games = 3; // Only the info for the last 3 games is required
		  $cant_columns = 15; // the table has 15 colums
		  $i=1;
		  $j=1;
		  $info=false;
		  $previous_date = false;
		  
		  foreach($html->find("Table.rgMasterTable td") as $element) { 
		 
			
			
			if ($element->plaintext == $game_date && $last_season == false){ 
			$data["date"] = $element->plaintext;
			$j=1;
			$k=0;
			$info = true;
			}
			
			//echo $element->plaintext."<BR>";
			
			
			//if ($i == 1){
			if ( $element->plaintext < $game_date && $last_season == false && $info==false && $previous_date ==   false && $i == 1){ 
			$data["date"] = $element->plaintext;
			$j=1;
			$k=0;
			$info = true;
			$previous_date = true;
			echo "entra".$data["date"];
			}
			
			
			
			if ($i==1){ 
			   if ($j==1 && $last_season == true){
				$data["date"] = $element->plaintext;
			   }
			   
			  		   
			   if ($k==1){
   			      $data["previous_date"] = $element->plaintext;
			   }
			  
			   if ($info){
				$k++;   
			   }
			   			   
						   			   
			 ?> <td style="font-size:12px;"><? echo $element->plaintext ?></td><?
			}
			 if ($i==2){
			 ?> <td style="font-size:12px;"><? echo $element->plaintext ?></td><?
			 }
			 if ($i==3){
			 ?> <td style="font-size:12px;"><? echo $element->plaintext ?></td><?
			 }
	     	
			if ($i == $cant_columns){
			  $i=0;
			  
			  
			 if ($info == true && $last_season == false){
			  
			    if ($j <= $last_games){  
				  if ($j==1){
				   $data["total_last_game"] = $element->plaintext;
				   }
				  $data["sum_last_games"] = ($data["sum_last_games"] + $element->plaintext);
			      }
			      $data["total_season"]= ($data["total_season"] + $element->plaintext);
			  
			 }
			 if ($info == false && $last_season == true){
			    
				   if ($j <= $last_games){  
				  if ($j==1){
				   $data["total_last_game"] = $element->plaintext;
				   }
				  $data["sum_last_games"] = ($data["sum_last_games"] + $element->plaintext);
			      }
			      $data["total_season"]= ($data["total_season"] + $element->plaintext);
			  
			  
			  
			 }
			  $j++;
			  ?>
			  <td style="font-size:12px;"><? echo $element->plaintext ?></td>
			  </tr><tr><?	  
			}
		//} //
		    $i++;
			
		  } ?></tr></table><BR><?
		 
		   $j--;
		   if (is_null($element) && $last_season == false ){
			echo "NO DATA";
			$data["date"]= date("Y-m-d");   
			$j=1;
		   }
		   else{
		      if ($j<=0){ //To avoid Division by Zero
			  $j=1;
			  }
		   }
		  
		   $data["avg_last_games"] = round($data["sum_last_games"] / $last_games);
		   $data["avg_season"] = round($data["total_season"] / $j);
		  
		   if ($last_season){
			 $statistics = new _baseball_player_stadistics_by_game();  
			 $statistics->vars["fangraphs_player"] = $playerid;
			 $rest_time="0"; 
		   }
		   else {	 
		   
			 $diff = abs(strtotime($data["date"]) - strtotime($data["previous_date"]));
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
			 if (is_null($statistics)){
				$last_season = true; 
			    $statistics = new _baseball_player_stadistics_by_game();  
			    $statistics->vars["fangraphs_player"] = $playerid;
			 }
		  
		  }
		 
		 if ($j==1){
		    $rest_time ='0'; // To control that players that does not have any game this season
	     } 
		  
		 $statistics->vars["season"] = $year;
		 $statistics->vars["game"] = $gameid;
		 $statistics->vars["rest_time"] = $rest_time;
		 $statistics->vars["total_last_game"] = $data["total_last_game"];
		 $statistics->vars["avg_last_games"] = $data["avg_last_games"];
		 $statistics->vars["sum_last_games"] =  $data["sum_last_games"];
		 $statistics->vars["avg_season"] = $data["avg_season"];
		 
		 $data['rest_time']=$rest_time;
		 if (!$last_season){
	   
		    $statistics->update(array("season","rest_time","total_last_game","avg_last_games","sum_last_games","avg_season")); 
		  }
		  else{
			$statistics->insert(); 	    
		  }
          
		 echo "<pre>";
		 print_r($data);
		 echo "</pre>";
		 echo "<BR>";
	     $html->clear();
	
}




function get_games_format(){
baseball_db();	

//$sql ="SELECT * FROM `game` WHERE runs_away = 0 and startdate > '2013-01-01 00:00:00' and startdate < '2013-07-14 00:00:00' AND postponed !=1 order by startdate ";

$sql="SELECT *
FROM `game`
WHERE id in ('357021','357287','355171','355614','368313')
";	
//echo $sql;
return get($sql, "_baseball_game");	
}





?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?
if (!isset($_GET["date"])){
	$page = $_SERVER['PHP_SELF'];
	$sec = "25";
}
?><head>
    <meta http-equiv="refresh" content="<?php echo $sec?>;URL="<? echo $page  ?>"">
</head>


<? 
require_once(ROOT_PATH . "/ck/db/handler.php"); 
require_once('../../../includes/html_dom_parser.php'); 
set_time_limit(0);


$year = date("Y");	
$today = date("Y-m-d");
//$today= date('2013-07-14');

if (!isset($_GET["date"])){
	
	$file = fopen("./ck/baseball_file/old_jobs/fecha.txt", "r") or exit("Unable to open file!");
	while(!feof($file))
	{
	$date =  ltrim(fgets($file));
	}
	fclose($file);
	
}
if (isset($_GET["date"])){
  $date = $_GET["date"];
}


echo "---------------<BR>";
echo "DATA FOR PITCHERS_AWAY<br>";
echo "-----".$date."-----<BR><BR>";

//$date = "2014-04-04";

if ($date > '2011-02-15') {

  $games = get_games_format($date);
  $i=0;
  foreach ($games as $game){
	  
	  echo $game->vars["id"]." ";
	  $year = date('Y',strtotime($game->vars["startdate"]));
	   
	   $game_date = date('Y-m-d',strtotime($game->vars["startdate"]));
	   
		echo "Pitcher AWAY <BR>";
		if ($game->vars["pitcher_away"]){
		  $player_a = get_baseball_player_by_id("fangraphs_player",$game->vars["pitcher_away"]);
		  get_player_pitches($player_a->vars["fangraphs_player"],$player_a->vars["player"],$year,false,$game->vars["id"],$game_date);
		  get_player_era($player_a->vars["fangraphs_player"],$player_a->vars["player"],$year,false,$game->vars["id"]); 
		}
  $i++;
  
   /* if ($i==4){  
	  break;
	}*/
  }

}



function get_player_pitches($playerid,$player_name,$year,$last_season=false,$gameid,$game_date){

	 if (!$last_season){
	   $statistics = get_player_basic_stadistics($playerid,($year-1),true,0);
	
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
          
		  // 2014-21-5 Information for  4G and 5G were requested
		   $data["avg_last_two_games"] = 0;
		  $data["sum_last_two_games"] =0;
		  $two_games = 2;
		  
		  
		  $data["avg_last_four_games"] = 0;
		  $data["sum_last_four_games"] =0;
		  $four_games = 4;
		  
		  $data["avg_last_five_games"] = 0;
		  $data["sum_last_five_games"] =0;
		  $five_games = 5;

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
		  $break = false;
		  $m = 0;
		  $info = false;
		  
		  foreach($html->find("Table.rgMasterTable td") as $element) { 
		 
			
			if ($i == 1 && $element->plaintext == "Total") { // We need to jump 30 columns beacause the total was changed up
		    $break = true;
		   }
		   
	      if ($break){
			$m++;
			if ($m >= 30){
				 //echo $element->plaintext."-s--s<BR>";
				 $break = false;}   
		  } 
		  else {
			
			
			
			/*if ($element->plaintext == $game_date && $last_season == false){ 
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
			
			*/
			
			if ($i==1){ 
			    
				
				if ($game_date > $element->plaintext && !$info) {
				 $j=1;
				$data["date"] = $element->plaintext;
			    $data["previous_date"] = $element->plaintext;
				$info = true;
			   
			   }
					   			   
			 ?> <td style="font-size:12px;"><? echo $element->plaintext ?></td><?
			}
			 if ($i==2 && $info){
			 ?> <td style="font-size:12px;"><? echo $element->plaintext ?></td><?
			 }
			 if ($i==3 && $info){
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
				
				if ($j <= $two_games){  
				
				$data["sum_last_two_games"] = ($data["sum_last_two_games"] + $element->plaintext);
			  }
				
				
				if ($j <= $four_games){  
				
				$data["sum_last_four_games"] = ($data["sum_last_four_games"] + $element->plaintext);
			  }
			  if ($j <= $five_games){  
				
				$data["sum_last_five_games"] = ($data["sum_last_five_games"] + $element->plaintext);
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
				 if ($j <= $two_games){  
				
				  $data["sum_last_two_games"] = ($data["sum_last_two_games"] + $element->plaintext);
			    }
			     
				 if ($j <= $four_games){  
				
				$data["sum_last_four_games"] = ($data["sum_last_four_games"] + $element->plaintext);
			  }
			  if ($j <= $five_games){  
				
				$data["sum_last_five_games"] = ($data["sum_last_five_games"] + $element->plaintext);
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
			 } //control break false
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
		   $data["avg_last_four_games"] = round($data["sum_last_four_games"] / $four_games);
		   $data["avg_last_five_games"] = round($data["sum_last_five_games"] / $five_games);
		    $data["avg_last_two_games"] = round($data["sum_last_two_games"] / $two_games);
		   $data["avg_season"] = round($data["total_season"] / $j);
		  
		   if ($last_season){
			 $statistics = new _baseball_player_stadistics_by_game();  
			 $statistics->vars["fangraphs_player"] = $playerid;
			 $rest_time="0"; 
		   }
		   else {	 
		   
			 $diff = abs(strtotime($game_date) - strtotime($data["previous_date"]));
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
		 $statistics->vars["avg_last_four_games"] = $data["avg_last_four_games"];
		 $statistics->vars["sum_last_four_games"] =  $data["sum_last_four_games"];
	     $statistics->vars["avg_last_five_games"] = $data["avg_last_five_games"];
		 $statistics->vars["sum_last_five_games"] =  $data["sum_last_five_games"];		 
		 $statistics->vars["avg_last_two_games"] = $data["avg_last_two_games"];
		 $statistics->vars["sum_last_two_games"] =  $data["sum_last_two_games"];		 
		 
		 $data['rest_time']=$rest_time;
		 if (!$last_season){
	   
		   $statistics->update(array("season","rest_time","total_last_game","avg_last_games","sum_last_games","avg_season","avg_last_four_games","sum_last_four_games","avg_last_five_games","sum_last_five_games","avg_last_two_games","sum_last_two_games")); 
			
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

$date = date( "Y-m-d", strtotime( "-1 day", strtotime(date($date)))); 

if (!isset($_GET["date"])){
  $fp = fopen('./ck/baseball_file/old_jobs/fecha.txt', 'w');
		fwrite($fp, $date);
		fclose($fp);

}

function get_games_format($date){
baseball_db();	

$sql="SELECT *
FROM `game`
WHERE
startdate > '".$date." 00:00:00'
AND startdate < '".$date." 23:00:00'
and postponed != 1
";


return get($sql, "_baseball_game");	
}


function get_player_era($playerid,$player_name,$year,$last_season=false,$gameid){
	
	   $link = "http://www.fangraphs.com/statsd.aspx?playerid=".$playerid."&position=P";
	  
	
	
	$html = file_get_html($link,true);
	
	
	if (!empty($html)){	
	
	  echo $link." ---> ".$player_name."<BR><BR>";	  
	  ?>
	  <table width="25%" border="1" cellspacing="0" cellpadding="0">
			
	  <tr> 
	    <? echo $_team["team_name"];?>
	  </tr>
	  <tr>
	    <td class="table_header">Player</td>
	    <td class="table_header">ERA</td>
	    <td class="table_header">XFIP</td>
	  </tr>
	  <tr> 
	   
	  </tr>
 	  <tr>
      
        <td class="table_header"><? echo $playerid ?></td> 
	  <?
		  
		  $data = array();
		 
		  $data["era"] = 0;
		  $data["fipx"] = 0;
		  
		 
	     foreach($html->find('tr[id="DailyStats1_dgSeason1_ctl00__0"]') as $tr) { 
		 
		   	$j=0;
			foreach($tr->find('td') as $td){ $j++;
			
			  // echo $j." - ".$td->plaintext."<BR>";
				    if ($j==24){
					 $data["era"] = $td->plaintext;
					?>  <td class="table_header"><? echo $td->plaintext ?></td> <?
					}
					if ($j==26){
					 $data["xfip"] = $td->plaintext;
					?>  <td class="table_header"><? echo $td->plaintext ?></td> <?					 
					 break;
					}
					
			}
			break;
		 
		  }
		   $statistics = get_player_basic_stadistics($playerid,$year,false,$gameid);
		  if(!is_null($statistics)){
			  $statistics->vars["era"] = $data["era"];
			  $statistics->vars["xfip"] = $data["xfip"];
			  $statistics->update(array("era","xfip"));
		  }
		  
		  
		  ?>
         </tr>
		 </table> <?  
		 echo "<pre>";
		 print_r($data);
		// print_r($statistics);
		 echo "</pre>";
		
		 echo "<BR>";
	     $html->clear();
	 }//empty html
	 else{ 
	    echo "Error: ".$link."<BR>";
	 }	 
	
}


?>
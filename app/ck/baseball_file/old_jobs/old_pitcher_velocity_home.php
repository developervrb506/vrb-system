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


//$year = date("Y");	
$today = date("Y-m-d");
//$today= date('2013-07-14');

if (!isset($_GET["date"])){
	$file = fopen("./ck/baseball_file/old_jobs/date.txt", "r") or exit("Unable to open file!");
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
echo "DATA FOR PITCHERS_HOME<br>";
echo "-----".$date."-----<BR><BR>";

//$date = "2014-04-04";

if ($date > '2011-02-15') {


$games = get_games_format($date);
$i=0;
foreach ($games as $game){
	
	$year = date('Y',strtotime($game->vars["startdate"]));
     
	 $game_date = date('Y-m-d',strtotime($game->vars["startdate"]));
	 
	     echo "Pitcher HOME<BR>";
    if ($game->vars["pitcher_home"]){
	   $player_h = get_baseball_player_by_id("fangraphs_player",$game->vars["pitcher_home"]);
	   get_player_pitches_velocity($player_h->vars["fangraphs_player"],$player_h->vars["player"],$year,false,$game->vars["id"],$game_date);
	}
$i++;

 /*if ($i==4){  
    break;
  }*/


}

}

function get_player_pitches_velocity($playerid,$player_name,$year,$last_season=false,$gameid,$game_date){

	 if (!$last_season){
	    
	   $statistics = get_player_basic_stadistics($playerid,($year-1),true,0);
	
	    if (is_null($statistics)){
	      echo "Last Season<BR>";
	      //get_player_pitches($playerid,$player_name,($year-1),true,"");
	      $last_season=false;
	   }
	  }
	  
	
	$html = file_get_html_parts(80000,0,"http://www.fangraphs.com/statsd.aspx?playerid=".$playerid."&position=P&type=6&gds=&gde=&season=".$year."");
	
	echo "http://www.fangraphs.com/statsd.aspx?playerid=".$playerid."&position=P&type=6&gds=&gde=&season=".$year."";
		  
	  ?>
	  <table width="25%" border="1" cellspacing="0" cellpadding="0">
			
	  <tr> 
	    <? echo $_team["team_name"];?>
	  </tr>
	  <tr>
	    <td class="table_header">Date</td>
	    <td class="table_header">Team</td>
	    <td class="table_header">FB%</td>
	    <td class="table_header">FBv</td>
	  </tr>
	  <tr> 
	    <? echo $player_name ?><BR>
	  </tr>
 	  <tr>
	  <?
		  
		  $data = array();
		  $data["date"] = 0;
		  $data["total_last_game"] = 0;
		  $data["total_last_two_games"] = 0;
		  $data["avg_season"] = 0;
		  $data["total_season"] = 0;
		 
		 
		 
		  // 2014-21-5 Information for  4G and 5G were requested
		 
		  
		  $cant_columns = 19; // the table has 15 colums
		  $i=1;
		  $j=1;
		  $break = false;
		  $m = 0;
		  $info = false;
		  
		  foreach($html->find("Table.rgMasterTable td") as $element) { 
		 
	       if ($i == 1 && $element->plaintext == "Total") { // We need to jump 30 columns beacause the total was changed up
		    $break = true;
		   }
		   
	      if ($break){
			$m++;
			if ($m >= 38){
				 //echo $element->plaintext."-s--s<BR>";
				 $break = false;}   
		  } 
		  else {
		    
			
	    	if ($i==1){ 
			 
			   
			   if ($game_date > $element->plaintext && !$info) {
				 $j=1;
				$data["date"] = $element->plaintext;
			    $info = true;
			   
			   }
			 ?> <td style="font-size:12px;"><? echo $element->plaintext ?></td><?
			}
			 if ($i==2 && $info){
			 ?> <td style="font-size:12px;"><? echo $element->plaintext ?></td><?
			 }
			 if ($i==5 && $info){
			 ?> <td style="font-size:12px;"><? echo $element->plaintext ?></td><?
			 }
			 if ($i==6 && $info){
			 ?> <td style="font-size:12px;"><? echo $element->plaintext ?></td><?
			 
			   if ($j==1 && $info){
				$data["total_last_game"] = $element->plaintext; 
				}
			   if ($j==2 && $info){
				$data["total_last_two_games"] = $element->plaintext; 
				}
			 
			   if ($info){
			    $data["total_season"] = $data["total_season"] + $element->plaintext;
			   }
			 }
	     	
			if ($i == $cant_columns){
			  $i=0;
			  $j++;
			  ?>
			 
			  </tr><tr><?	  
			}
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
		  
		   
		   $data["avg_season"] = round($data["total_season"] / $j);
		  
		   if ($last_season){
			 $statistics = new _baseball_player_stadistics_by_game();  
			 $statistics->vars["fangraphs_player"] = $playerid;
			
		   }
		   else {	 
	 
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
		 $statistics->vars["last_game_velocity"] = $data["total_last_game"];
		 $statistics->vars["last_two_game_velocity"] = $data["total_last_two_games"];
		 $statistics->vars["season_velocity"] =  $data["avg_season"];
		 
		 
		   if (!$last_season){
      		 
			 $statistics->update(array("last_game_velocity","last_two_game_velocity","season_velocity")); 
		  }
		  else{
			// $statistics->insert(); 	    
		  }

		 echo "<pre>";
		 print_r($data);
		 echo "</pre>";
		 echo "<BR>";
	     $html->clear();
	
}


$date = date( "Y-m-d", strtotime( "-1 day", strtotime(date($date)))); 

if (!isset($_GET["date"])){
	$fp = fopen('./ck/baseball_file/old_jobs/date.txt', 'w');
		fwrite($fp, $date);
		fclose($fp);
}




function get_games_format($date){
baseball_db();	

$sql="SELECT *
FROM `game`
WHERE  startdate > '".$date." 00:00:00'
AND startdate < '".$date." 23:00:00'
and postponed != 1
";


return get($sql, "_baseball_game");	
}




?>
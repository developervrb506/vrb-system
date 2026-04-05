<? 
require_once(ROOT_PATH . "/ck/db/handler.php"); 
require_once('../../../includes/html_dom_parser.php'); 
 require_once(ROOT_PATH . '/ck/baseball_file/process/functions.php'); 
  
 // THIS JOB IS NOT NEED IT ANYMORE ALL GAMES WHERE UPDATED  

//$page = $_SERVER['PHP_SELF'];
//$sec = "15";
?>
<head>
   <meta http-equiv="refresh" content="<?php echo $sec?>;URL="<? echo $page  ?>"">  
    </head>
<?   
  
set_time_limit(0);
$year= date("Y");

$file = fopen("./ck/baseball_file/old_jobs/fecha.txt", "r") or exit("Unable to open file!");
while(!feof($file))
{
$date =  ltrim(fgets($file));
}
fclose($file);//
//$date = "2018-04-02";

// Find today games and Teams
echo "---------------------------<BR>";
echo "     AIRD BY GAME<br>";
echo "---- ".$date." -----------<BR><BR>";




$games = get_basic_baseball_games_by_date($date);	


//$games = array();//delete
$i=1;
foreach ($games as $game ){

  $weather=get_baseball_game_weather($game->vars["id"],$game->vars["startdate"]) ;
   
   if(!empty($weather)) {
   
  // print_r($weather); 
   //save Neely Scale Data
		$stadium = get_baseball_stadium_by_team($game->vars["team_home"]);
		$aird = getair_density($stadium->vars["elevation"], $weather->vars["air_pressure"],$weather->vars["temp"],$weather->vars["humidity"]);	
		$weather->vars["aird"] = $aird;
		echo $game->vars["id"]." -- ".$aird;
		$weather->update("weather",array("aird"));
		
	//	echo "<pre>";
	//	print_r($weather);
		//		echo "</pre>";
   echo "<BR><BR>";
   
   }
 // break;  
	
}

$date = date( "Y-m-d", strtotime( "-1 day", strtotime(date($date)))); 


$fp = fopen('./ck/baseball_file/old_jobs/fecha.txt', 'w');
		fwrite($fp, $date);
		fclose($fp);
		





?>
<p>&nbsp;</p>
<p>&nbsp;</p>
<? require_once(ROOT_PATH . "/ck/db/handler.php"); 



$file = fopen("fecha.txt", "r") or exit("Unable to open file!");
//Output a line of the file until the end is reached
while(!feof($file))
{
$fecha =  ltrim(fgets($file));
}
fclose($file);



$date = $fecha;
$games = get_basic_baseball_games_by_date($date);

//echo count($games);

if (count($games)==0){
echo "NO HAY JUEGOS ESE DIA : ";
$fecha = date ('Y-m-d',strtotime ( '-1 day' , strtotime ($fecha))) ;	
		$fp = fopen('fecha.txt', 'w');
		fwrite($fp, $fecha);
		fclose($fp);	
	
}



foreach ($games as $_game){
   
    $weather_check=get_baseball_game_weather($_game->vars["id"],$_game->vars["startdate"]); 
   
    if (is_null($weather_check)){
	break;
	}
	else{
		$fecha = date ('Y-m-d',strtotime ( '-1 day' , strtotime ($fecha))) ;	
		$fp = fopen('fecha.txt', 'w');
		fwrite($fp, $fecha);
		fclose($fp);
		break;
	}
  
	
}



$i=0;

echo $date."<BR>";
foreach ($games as $game){

  $weather=get_baseball_game_weather($game->vars["id"],$game->vars["startdate"]) ;

	if ((is_null($weather)) && $i < 9) {
	
	
	$parser = new _wheather_parser();
	$stadium = get_baseball_stadium_by_team($game->vars["team_home"]);
	$game_id = $game->vars["id"];
	$game_date = $game->vars["startdate"];
	
	//Data for weather
	$hour = date('H',strtotime($game_date));
	$year = date('Y',strtotime($game_date));
	$month = date('m',strtotime($game_date));
	$day=  date('d',strtotime($game_date));
	$historical_date= $year."".$month."".$day;
	$zipcode = $stadium->vars['zip_code'];
	
	
	// TEST FOR HISTORY
	$history = $parser->get_history_weather($zipcode,$historical_date,$hour);
	$weather = $history;
	$weather["date"] = $game_date;
	$weather["stadium"] = $stadium->vars['id'];
	$weather["game"] = $game_id;
	$weather["added_date"] = date("Y-m-d H:i:s");
	$weather_control = new _baseball_weather($weather);
	$weather_control->insert("weather"); 
	
	echo"<pre>";
	print_r($weather);
	echo"</pre>";
	echo"<BR>";
	
	//ACTIONS WERE DISABLED
	
	$weather_control = new _baseball_weather($weather);
	$weather_control->insert();
	
	$i++;
	}

	



}

//include("check_games.php");


?>

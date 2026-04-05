<p>&nbsp;</p>
<p>&nbsp;</p>
<? require_once(ROOT_PATH . "/ck/db/handler.php"); 
 require_once(ROOT_PATH . '/ck/baseball_file/process/functions.php'); 
	ini_set('memory_limit', '-1');
    set_time_limit(0);
$year = date("Y");	
$season =  get_baseball_season($year);

$games = get_baseball_games_without_weather($season['start']);
//$games = get_baseball_games_without_weather('2022-04-04');

 echo count($games). " Games to fix weather<BR>";

//exit;

$condition = array();
	$condition["clear-day"]= "https://d3portal.national.aaa.com/D3Static/images/WundergroundWeatherIcons/IconSet9/clear.gif";
	$condition["clear-nigth"]= "https://d3portal.national.aaa.com/D3Static/images/WundergroundWeatherIcons/IconSet9/clear.gif";	
	$condition["Scattered Clouds"]= "https://d3portal.national.aaa.com/D3Static/images/WundergroundWeatherIcons/IconSet9/partlycloudy.gif";
	$condition["partly-cloudy-day"]= "https://d3portal.national.aaa.com/D3Static/images/WundergroundWeatherIcons/IconSet9/partlycloudy.gif";
	$condition["partly-cloudy-nigth"]= "https://d3portal.national.aaa.com/D3Static/images/WundergroundWeatherIcons/IconSet9/partlycloudy.gif";	
	$condition["cloudy"]= "https://d3portal.national.aaa.com/D3Static/images/WundergroundWeatherIcons/IconSet9/mostlycloudy.gif";
	$condition["Light Thunderstorms and Rain"]= "https://d3portal.national.aaa.com/D3Static/images/WundergroundWeatherIcons/IconSet9/tstorms.gif";
	$condition["Overcast"]= "https://d3portal.national.aaa.com/D3Static/images/WundergroundWeatherIcons/IconSet9/cloudy.gif";
	$condition["Unknown"]= "unknown";
	$condition["Overcast"]= "https://d3portal.national.aaa.com/D3Static/images/WundergroundWeatherIcons/IconSet9/nt_cloudy.gif";
	$condition["rain"]= "https://d3portal.national.aaa.com/D3Static/images/WundergroundWeatherIcons/IconSet9/rain.gif";
	$condition["Fog"]= "https://d3portal.national.aaa.com/D3Static/images/WundergroundWeatherIcons/IconSet9/fog.gif";
	$condition["Light Rain"]= "https://d3portal.national.aaa.com/D3Static/images/WundergroundWeatherIcons/IconSet9/nt_rain.gif";
	$condition["Haze"]= "https://d3portal.national.aaa.com/D3Static/images/WundergroundWeatherIcons/IconSet9/hazy.gif";
	$condition["Heavy Thunderstorms and Rain"]= "https://d3portal.national.aaa.com/D3Static/images/WundergroundWeatherIcons/IconSet9/tstorms.gif";
	$condition["thunderstorm"]= "https://d3portal.national.aaa.com/D3Static/images/WundergroundWeatherIcons/IconSet9/nt_tstorms.gif";
	$condition["Heavy Rain"]= "https://d3portal.national.aaa.com/D3Static/images/WundergroundWeatherIcons/IconSet9/rain.gif";
	$condition["Light Drizzle"]= "https://d3portal.national.aaa.com/D3Static/images/WundergroundWeatherIcons/IconSet9/rain.gif";
	$condition["snow"]= "https://d3portal.national.aaa.com/D3Static/images/WundergroundWeatherIcons/IconSet9/snow.gif";
	$condition["sleet"]= "https://d3portal.national.aaa.com/D3Static/images/WundergroundWeatherIcons/IconSet9/sleet.gif";
	$condition["Thunderstorms and Rain"]= "https://d3portal.national.aaa.com/D3Static/images/WundergroundWeatherIcons/IconSet9/nt_tstorms.gif";
	$condition["Heavy Snow"]= "snow";
	
	
foreach ($games as $game){
	
  // print_r($game);
$parser = new _wheather_parser();

$team = $game->vars["team_home"];
	 $game_id = $game->vars["id"];  	
	 $game_date = $game->vars["startdate"];
	 $stadium = get_baseball_stadium_by_team($game->vars["team_home"]);
	 $zipcode = $stadium->vars['zip_code'];
	 $latitud = trim($stadium->vars['latitude']);
	 $longitud = trim($stadium->vars['longitud']);	 	 
    
	 $hour = date('H',strtotime($game_date));
	 $year = date('Y',strtotime($game_date));
	 $month = date('m',strtotime($game_date));
	 $day=  date('d',strtotime($game_date));
	 $min =  date('i',strtotime($game_date));  
	  $hg = $year."-".$month."-".$day." ".($hour+1).":".$min;
	  
	//  echo "<BR>".$hg."----".strtotime($hg)."<BR>";
	//  $hg = '2019-06-12 16:00:00';
     $hour_game = date("Y-m-d H", strtotime($hg));
	  $time = strtotime($hg);
	 
	  $current = $parser->get_history_weather($latitud,$longitud,$time);
	 
	   $weather = $current;
	   $weather["date"] = $game_date;
	   $weather["stadium"] = $stadium->vars['id'];
	   $weather["game"] = $game_id;
	   $weather["added_date"] = date("Y-m-d H:i:s");
	   
	   switch ($weather["wind_direction"]){
		 
		  case "N":
		    $weather["wind_direction"] = "North";
		    break;   
		  case "S":
		    $weather["wind_direction"] = "South";
		    break;
		  case "E":
		   $weather["wind_direction"] = "East";
		   break;
		  case "W":
		   $weather["wind_direction"] = "West";
		   break; 	
		
		}
		
		 //save Neely Scale Data
		$stadium = get_baseball_stadium_by_team($game->vars["team_home"]);
		$aird = getair_density($stadium->vars["elevation"], $weather["air_pressure"],$weather["temp"],$weather["humidity"]);	
		$weather["aird"] = $aird;
		$weather["img_url"] = $condition[$weather["condition"]]; 
	 
	  if($weather["temp"] > 0){
   	   $weather_control = new _baseball_weather($weather);
	   $weather_control->insert("weather"); 
	  }  
	 
	  echo "<pre>";
	   print_r($current);
	   	  echo "</pre>";
		  
		  if ($weather["condition"] != ""){
	   $tdate = date("Y-m-d",strtotime($weather["date"])) ;
	   echo file_get_contents("http://localhost:8080/ck/baseball_file/jobs/weather_stadistics.php?date=$tdate");	 
	   echo file_get_contents("http://localhost:8080/ck/baseball_file/jobs/baseball_stats.php?date=$tdate");	 
	 }
		  
		  


}




?>

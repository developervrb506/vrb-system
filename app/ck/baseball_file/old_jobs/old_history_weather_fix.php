<p>&nbsp;</p>
<p>&nbsp;</p>
<? require_once(ROOT_PATH . "/ck/db/handler.php"); 




$games = get_without_temp();

//echo count($games);
echo "<pre>";
//print_r($games);
echo "</pre>";

foreach ($games as $game){
	
  //$weather=get_baseball_game_weather($game->vars["id"],$game->vars["startdate"]) ;

	if ($i < 9) {
	
	
	$parser = new _wheather_parser();
	$stadium = get_baseball_stadium_by_team($game->vars["team_home"]);
	$game_id = $game->vars["id"];
	$game_date = $game->vars["startdate"];
	
	//Data for weather
	$hour = date('H',strtotime($game_date));
	//$hour = $hour - 6;
	$hour = $hour+2;
	$hour++;
	$year = date('Y',strtotime($game_date));
	$month = date('m',strtotime($game_date));
	$day=  date('d',strtotime($game_date));
	$historical_date= $year."".$month."".$day;
	$zipcode = $stadium->vars['zip_code'];
	
	$condition = array();
	$condition["Clear"]= "http://icons-ak.wxug.com/i/c/k/clear.gif";
	$condition["Scattered Clouds"]= "http://icons-ak.wxug.com/i/c/k/partlycloudy.gif";
	$condition["Partly Cloudy"]= "http://icons-ak.wxug.com/i/c/k/partlycloudy.gif";
	$condition["Mostly Cloudy"]= "http://icons-ak.wxug.com/i/c/k/mostlycloudy.gif";
	$condition["Light Thunderstorms and Rain"]= "http://icons-ak.wxug.com/i/c/k/tstorms.gif";
	$condition["Overcast"]= "http://icons-ak.wxug.com/i/c/k/cloudy.gif";
	$condition["Unknown"]= "unknown";
	$condition["Overcast"]= "http://icons-ak.wxug.com/i/c/k/nt_cloudy.gif";
	$condition["Rain"]= "http://icons-ak.wxug.com/i/c/k/rain.gif";
	$condition["Fog"]= "http://icons-ak.wxug.com/i/c/k/fog.gif";
	$condition["Light Rain"]= "http://icons-ak.wxug.com/i/c/k/nt_rain.gif";
	$condition["Haze"]= "http://icons-ak.wxug.com/i/c/k/hazy.gif";
	$condition["Heavy Thunderstorms and Rain"]= "http://icons-ak.wxug.com/i/c/k/tstorms.gif";
	$condition["Thunderstorm"]= " 	http://icons-ak.wxug.com/i/c/k/nt_tstorms.gif";
	$condition["Heavy Rain"]= "http://icons-ak.wxug.com/i/c/k/rain.gif";
	$condition["Light Drizzle"]= " 	http://icons-ak.wxug.com/i/c/k/rain.gif";
	$condition["Light Snow"]= "snow";
	$condition["Light Freezing Rain"]= "sleet";
	$condition["Thunderstorms and Rain"]= "http://icons-ak.wxug.com/i/c/k/nt_tstorms.gif";
	$condition["Heavy Snow"]= "snow";
	
	// TEST FOR HISTORY
	echo $hour;
	$history = $parser->get_history_weather($zipcode,$historical_date,$hour);
	echo "<pre>";
    // print_r($history);
     echo "</pre>";
	$weather = $history;
	$weather["date"] = $game_date;
	$weather["stadium"] = $stadium->vars['id'];
	$weather["game"] = $game_id;
	$weather["added_date"] = date("Y-m-d H:i:s");
	$weather["img_url"] = $condition[$weather["condition"]]; 
		
	//$weather_control = new _baseball_weather($weather);
	//$weather_control->insert("weather"); 
	
	
	
	
	//$weather_control->update("weather",array("temp","condition","wind_speed","img_url","wind_degrees","wind_direction","wind_gust","humidity","air_pressure","dewpoint","date","added_date")); 
	
	echo"<pre>";
	print_r($weather);
	echo"</pre>";
	echo"<BR>";
	

	
	$i++;
	}

}


function get_without_temp(){
baseball_db();	
//$sql = "SELECT * FROM `game` WHERE id not in (select game from weather where date > '2011-03-27 00:00:00' and date < '2011-12-27 00:00:00' ) and startdate > '2011-03-27'and  startdate < '2011-12-27' limit 1";
$sql="SELECT * FROM game  WHERE id in (SELECT game FROM `weather` WHERE `temp` = 0.00) LIMIT 1";
	
//echo $sql;
return get($sql, "_baseball_game");	
}

?>

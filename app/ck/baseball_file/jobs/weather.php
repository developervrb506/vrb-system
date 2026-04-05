<? $no_log_page = true; ?>
<? include(ROOT_PATH . "/ck/db/handler.php"); ?>
<? require_once(ROOT_PATH . '/ck/baseball_file/process/functions.php'); ?>
<? 

	ini_set('memory_limit', '-1');
    set_time_limit(0);

echo "<pre>" ;   
$parser = new _Openweather_parser();
$today=date("Y-m-d");
$hour_now = date('H');
$num_max = 5 ; // Only 5 Rows by time, to avoid to exceed the max allowed for wunder api

$cant_games = get_count_baseball_games_by_date($today);
$pivot_game = get_pivot_baseball_game();
$games = get_limited_baseball_games_by_date($today,$pivot_game->vars['pivot_number'],$num_max);
//print_r($games[0]);


// Control the pivot table
if ($pivot_game->vars['pivot_number'] >= $cant_games["games"] || count($games)< $num_max){
  $pivot_game->vars['pivot_number']=0;
  $pivot_game->update();
}
else {
  $pivot_game->vars['pivot_number']=$pivot_game->vars['pivot_number']+$num_max;	
  $pivot_game->update();	
}

// Erase the temp table 
if ($hour_now == 9){ 
  delete_temp_weather($today);	  
}


$condition = array();
/*
	$condition["clear-day"]= "http://icons-ak.wxug.com/i/c/k/clear.gif";
	$condition["clear-nigth"]= "http://icons-ak.wxug.com/i/c/k/clear.gif";	
	$condition["Scattered Clouds"]= "http://icons-ak.wxug.com/i/c/k/partlycloudy.gif";
	$condition["partly-cloudy-day"]= "http://icons-ak.wxug.com/i/c/k/partlycloudy.gif";
	$condition["partly-cloudy-nigth"]= "http://icons-ak.wxug.com/i/c/k/partlycloudy.gif";	
	$condition["cloudy"]= "http://icons-ak.wxug.com/i/c/k/mostlycloudy.gif";
	$condition["Light Thunderstorms and Rain"]= "http://icons-ak.wxug.com/i/c/k/tstorms.gif";
	$condition["Overcast"]= "http://icons-ak.wxug.com/i/c/k/cloudy.gif";
	$condition["Unknown"]= "unknown";
	$condition["Overcast"]= "http://icons-ak.wxug.com/i/c/k/nt_cloudy.gif";
	$condition["rain"]= "http://icons-ak.wxug.com/i/c/k/rain.gif";
	$condition["Fog"]= "http://icons-ak.wxug.com/i/c/k/fog.gif";
	$condition["Light Rain"]= "http://icons-ak.wxug.com/i/c/k/nt_rain.gif";
	$condition["Haze"]= "http://icons-ak.wxug.com/i/c/k/hazy.gif";
	$condition["Heavy Thunderstorms and Rain"]= "http://icons-ak.wxug.com/i/c/k/tstorms.gif";
	$condition["thunderstorm"]= " 	http://icons-ak.wxug.com/i/c/k/nt_tstorms.gif";
	$condition["Heavy Rain"]= "http://icons-ak.wxug.com/i/c/k/rain.gif";
	$condition["Light Drizzle"]= " 	http://icons-ak.wxug.com/i/c/k/rain.gif";
	$condition["snow"]= "snow";
	$condition["sleet"]= "sleet";
	$condition["Thunderstorms and Rain"]= "http://icons-ak.wxug.com/i/c/k/nt_tstorms.gif";
	$condition["Heavy Snow"]= "snow";

	*/

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
	

if (count($games)>0){


  
  foreach ( $games as $game ){
    
	 $team = $game->vars["team_home"];
	 $game_id = $game->vars["id"];  	
	 $game_date = $game->vars["startdate"];
	 $stadium = get_baseball_stadium_by_team($team);	
	 $zipcode = $stadium->vars['zip_code'];
	 $latitud = trim($stadium->vars['latitude']);
	 $longitud = trim($stadium->vars['longitud']);	 	 
    
	 $hour = date('H',strtotime($game_date));
	 $year = date('Y',strtotime($game_date));
	 $month = date('m',strtotime($game_date));
	 $day=  date('d',strtotime($game_date));  
	  $hg = $year."-".$month."-".$day." ".($hour+1);
	 // echo $hg."----";
     $hour_game = date("Y-m-d H", strtotime($hg));
	
	 print_r($stadium) ;
	  $current = $parser->get_current_weather($latitud,$longitud,$hg);
	 //  exit;
	   
	 if ($hour_now < ($hour+1)){ 
	    echo "<BR>-----------------<BR>" ; 
	    $current = $parser->get_current_weather($latitud,$longitud,$hg);
	 //  exit;
	  // $hourly =  $parser->get_hourly_weather($zipcode,($hour+1),$day);  // Calcule the next available Hour
	   $weather = $current;
	   $weather["date"] = $game_date;
	   $weather["stadium"] = $stadium->vars['id'];
	   $weather["game"] = $game_id;
	   $weather["added_date"] = date("Y-m-d H:i:s");
	   $weather["img_url"] = $condition[$weather["condition"]]; 
	  
	   
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
 		//if($weather["aird"] == ""){ $weather["aird"] = 0.0;}
	   
	   echo "<pre>";
	   print_r($weather);
	   echo "</pre>";
	   
	
	   if ($weather["condition"]!=""){
		 $temp_weather_control = new _baseball_weather($weather);
		 $temp_weather_control->insert(); 
		 
	   }
	 
	 }
	  else{
		  
		
	   //  if a game is in the next hour

            echo $hour_now. " = ". ($hour);
		    if ($hour_now == ($hour+1)){ 
 	  		
			
		   $weather_now = $current;
		   $weather_now["date"] = $game_date;
		   $weather_now["stadium"] = $stadium->vars['id'];
		   $weather_now["game"] = $game_id;
		   $weather_now["added_date"] = date("Y-m-d H:i:s");
		   $weather_now["img_url"] = $condition[$weather_now["condition"]]; 
			
			
			switch ($weather_now["wind_direction"]){
		 
			  case "N":
				$weather_now["wind_direction"] = "North";
				break;   
			  case "S":
				$weather_now["wind_direction"] = "South";
				break;
			  case "E":
			   $weather_now["wind_direction"] = "East";
			   break;
			  case "W":
			   $weather_now["wind_direction"] = "West";
			   break; 	
		
		   }
		    
			  //save Neely Scale Data
			$stadium = get_baseball_stadium_by_team($game->vars["team_home"]);
			$aird = getair_density($stadium->vars["elevation"], $weather_now["air_pressure"],$weather_now["temp"],$weather_now["humidity"]);	
			$weather_now["aird"] = $aird;
		
		
			echo "<pre>";
			print_r($weather_now);
			echo "</pre>";
		    if ($game->vars["espn_game"] != 0) {
		     $weather_control = new _baseball_weather($weather_now);
		     $weather_control->insert("weather"); 
		    }
		  }
	  }
	 //break;
  }
}




?>

<? 
/*
$no_log_page = true; ?>
<? include(ROOT_PATH . "/ck/db/handler.php"); ?>
<? require_once(ROOT_PATH . '/ck/baseball_file/process/functions.php'); ?>
<? 
$parser = new _wheather_parser();
$today=date("Y-m-d");
$hour_now = date('H');
$num_max = 5 ; // Only 5 Rows by time, to avoid to exceed the max allowed for wunder api

$cant_games = get_count_baseball_games_by_date($today);
$pivot_game = get_pivot_baseball_game();
$games = get_limited_baseball_games_by_date($today,$pivot_game->vars['pivot_number'],$num_max);

// Control the pivot table
if ($pivot_game->vars['pivot_number'] >= $cant_games["games"] || count($games)< $num_max){
  $pivot_game->vars['pivot_number']=0;
  $pivot_game->update();
}
else {
  $pivot_game->vars['pivot_number']=$pivot_game->vars['pivot_number']+$num_max;	
  $pivot_game->update();	
}

// Erase the temp table 
if ($hour_now == 9){ 
  delete_temp_weather($today);	  
}

if (count($games)>0){

  foreach ( $games as $game ){

	 $team = $game->vars["team_home"];
	 $game_id = $game->vars["id"];  	
	 $game_date = $game->vars["startdate"];
	 $stadium = get_baseball_stadium_by_team($team);	
	 $zipcode = $stadium->vars['zip_code'];
     
	 //Data for weather
	 $hour = date('H',strtotime($game_date));
	 $year = date('Y',strtotime($game_date));
	 $month = date('m',strtotime($game_date));
	 $day=  date('d',strtotime($game_date));  
  
	  //echo $hour_now. " < ". ($hour);
	 
	 if ($hour_now < ($hour+1)){ 
	   $current = $parser->get_current_weather($zipcode);
	   $hourly =  $parser->get_hourly_weather($zipcode,($hour+1),$day);  // Calcule the next available Hour
	   $weather = $current + $hourly;
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
	   
	   echo "<pre>";
	   print_r($weather);
	   echo "</pre>";
	   
	
	   if ($hourly["condition"]!=""){
		 $temp_weather_control = new _baseball_weather($weather);
		 $temp_weather_control->insert(); 
		 
		
		 
		 
	   }
	 
	 }
	  else{
	   //  if a game is in the next hour

            //echo $hour_now. " = ". ($hour);
		    if ($hour_now == ($hour+1)){ 
 	  		$weather_now = $parser->get_current_weather($zipcode,true);
			$weather_now["humidity"]= str_replace("%","",$weather_now["humidity"]);
			$weather_now["date"] = $game_date;
			$weather_now["stadium"] = $stadium->vars['id'];
			$weather_now["game"] = $game_id;
			$weather_now["added_date"] = date("Y-m-d H:i:s");
			
			
			switch ($weather_now["wind_direction"]){
		 
			  case "N":
				$weather_now["wind_direction"] = "North";
				break;   
			  case "S":
				$weather_now["wind_direction"] = "South";
				break;
			  case "E":
			   $weather_now["wind_direction"] = "East";
			   break;
			  case "W":
			   $weather_now["wind_direction"] = "West";
			   break; 	
		
		   }
		    
			  //save Neely Scale Data
			$stadium = get_baseball_stadium_by_team($game->vars["team_home"]);
			$aird = getair_density($stadium->vars["elevation"], $weather_now["air_pressure"],$weather_now["temp"],$weather_now["humidity"]);	
			$weather_now["aird"] = $aird;
		
		
			echo "<pre>";
			print_r($weather_now);
			echo "</pre>";
		    if ($game->vars["espn_game"] != 0) {
		     $weather_control = new _baseball_weather($weather_now);
		     $weather_control->insert("weather"); 
		    }
		  }
	  }
  }
}
*/


?>
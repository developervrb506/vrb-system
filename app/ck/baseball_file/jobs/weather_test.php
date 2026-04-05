<? $no_log_page = true; ?>
<? include(ROOT_PATH . "/ck/db/handler.php"); ?>
<? require_once(ROOT_PATH . '/ck/baseball_file/process/functions.php'); ?>
<? 
$parser = new _wheather_parser_test();
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
/*
echo "<pre>";
print_r($games);
echo "</pre>";

  */
  foreach ( $games as $game ){

	 $team = $game->vars["team_home"];
	 $game_id = $game->vars["id"];  	
	 $game_date = $game->vars["startdate"];
	 $stadium = get_baseball_stadium_by_team($team);	
	 $zipcode = $stadium->vars['zip_code'];
	 $latitud = trim($stadium->vars['latitude']);
	 $longitud = trim($stadium->vars['longitud']);	 	 
    // $game_date = '2019-03-28 22:05:00';
	// echo $game_date ."<BR>";
	 //Data for weather
	 $hour = date('H',strtotime($game_date));
	 $year = date('Y',strtotime($game_date));
	 $month = date('m',strtotime($game_date));
	 $day=  date('d',strtotime($game_date));  
	  $hg = $year."-".$month."-".$day." ".($hour+1);
	 // echo strtotime($hg);
	 // echo $hg."----";
     $hour_game = date("Y-m-d H", strtotime($hg));
	// echo $game_date." ---- ".$hour_game. "<BR>";
	  //echo $hour_now. " < ". ($hour);
	 
	  $current = $parser->get_current_weather($latitud,$longitud,$hg);
	 //  exit;
	   
	 if ($hour_now < ($hour+1)){ 
	    $current = $parser->get_current_weather($latitud,$longitud,$hg);
	 //  exit;
	  // $hourly =  $parser->get_hourly_weather($zipcode,($hour+1),$day);  // Calcule the next available Hour
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

            //echo $hour_now. " = ". ($hour);
		    if ($hour_now == ($hour+1)){ 
 	  		//$weather_now = $parser->get_current_weather($zipcode,true);
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

class _wheather_parser_test{
	var $code = array();
	function _wheather_parser_test(){
		$this->code["api"]= "85eb3ab42ca145f719b4b31f0d4fe665";
	}
	
	function get_time_zone($time) 
   {  
		$tz_from = 'GMT';
		$tz_to = 'America/New_York';
		$format = 'Y-m-d H';
		
		//$dt = new DateTime($datetime, new DateTimeZone($tz_from));
		$dt = new DateTime('@'.$time, new DateTimeZone('America/New_York'));
		$dt->setTimeZone(new DateTimeZone($tz_to));
		return $dt->format($format);
   } 
   
   function get_milibars_to_in($bars) 
   {  
		$inHg = round(($bars * 0.029530),2);
		return $inHg;
   } 
   
   function wind_cardinals($deg) {
	$cardinalDirections = array(
		'N' => array(348.75, 361),
		'N2' => array(0, 11.25),
		'NNE' => array(11.25, 33.75),
		'NE' => array(33.75, 56.25),
		'ENE' => array(56.25, 78.75),
		'E' => array(78.75, 101.25),
		'ESE' => array(101.25, 123.75),
		'SE' => array(123.75, 146.25),
		'SSE' => array(146.25, 168.75),
		'S' => array(168.75, 191.25),
		'SSW' => array(191.25, 213.75),
		'SW' => array(213.75, 236.25),
		'WSW' => array(236.25, 258.75),
		'W' => array(258.75, 281.25),
		'WNW' => array(281.25, 303.75),
		'NW' => array(303.75, 326.25),
		'NNW' => array(326.25, 348.75)
	);
	foreach ($cardinalDirections as $dir => $angles) {
			if ($deg >= $angles[0] && $deg < $angles[1]) {
				$cardinal = str_replace("2", "", $dir);
			}
		}
		return $cardinal;
}
   
	function get_current_weather($latitud,$longitud,$hour_game){
		$current = array();
		//echo "https://api.darksky.net/forecast/".$this->code["api"]."/".$latitud.",".$longitud;
		$json_string = file_get_contents("https://api.darksky.net/forecast/".$this->code["api"]."/".$latitud.",".$longitud);
		$parsed_json = json_decode($json_string);
	    //echo $hour_game;
		$now =  $this->get_time_zone($parsed_json->{'currently'}->{'time'});
		//echo $old." -- ".$hour_game;
        //echo strtotime($old);
		//exit;
		//if($old == $hour_game){ echo "Entra y Graba"; } else { echo "BUSCA HORAS";}
		
		/*echo "<pre>";
		 print_r($parsed_json);
		echo "</pre>";
		*/
		
		
		if($now == $hour_game){
		   $current["wind_gust"] = $parsed_json->{'currently'}->{'windGust'};
		    $current["air_pressure"] = $this->get_milibars_to_in($parsed_json->{'currently'}->{'pressure'});
		   $current["temp"] = $parsed_json->{'currently'}->{'temperature'};   
		   $current["condition"] = $parsed_json->{'currently'}->{'icon'};
		   //$current["img_url"] = $parsed_json->{'currently'}->{'icon_url'};
		   $current["wind_speed"] = $parsed_json->{'currently'}->{'windSpeed'};
		   $current["wind_degrees"] = $parsed_json->{'currently'}->{'windBearing'};
		   $current["wind_direction"] = $this->wind_cardinals($parsed_json->{'currently'}->{'windBearing'});
		   $current["humidity"] = ($parsed_json->{'currently'}->{'humidity'} * 100);
		   $current["dewpoint"] = $parsed_json->{'currently'}->{'dewPoint'};
		} else {
			
			
			foreach ($parsed_json->{'hourly'}->{'data'} as $item ){
				
				$tt = $this->get_time_zone($item->{'time'});
				echo $tt."<BR>";
				if($tt == $hour_game){
					 $current["wind_gust"] = $item->{'windGust'};
					$current["air_pressure"] = $this->get_milibars_to_in($item->{'pressure'});
				   $current["temp"] = $item->{'temperature'};   
				   $current["condition"] = $item->{'icon'};
				   //$current["img_url"] = $item->{'icon_url'};
				   $current["wind_speed"] = $item->{'windSpeed'};
				   $current["wind_degrees"] = $item->{'windBearing'};
				   $current["wind_direction"] = $this->wind_cardinals($item->{'windBearing'});
				   $current["humidity"] = ($item->{'humidity'} * 100);
				   $current["dewpoint"] = $item->{'dewPoint'};
					break;
					}
				
			}
			
	    }
	
	
		
		return $current;
	}
	function get_history_weather($location,$Historical_date,$hour){
		// EDT time
		$history = array();
		$json_string = file_get_contents("http://api.wunderground.com/api/".$this->code["api"]."/history_".$Historical_date."/q/".  $location.".json");
		//echo "http://api.wunderground.com/api/".$this->code["api"]."/history_".$Historical_date."/q/".  $location.".json";
		echo "<pre>";
		//print_r($json_string);
 	   echo "</pre>";
		$parsed_json = json_decode($json_string);
	
		foreach ($parsed_json->{'history'}->{'observations'} as $item ){
		
			echo "<pre>";
		   // print_r($item);
 	      echo "</pre>";
	     // echo $item->{'date'}->{'hour'}." IGUAL A".$hour."<BR>";  
		  if ($item->{'date'}->{'hour'} == $hour){
				 
				 $history["temp"]= $item->{'tempi'};
				 $history["condition"]= $item->{'conds'}; 
				 $history["img_url"]= $item->{'icon'};  // NO URL
				 $history["wind_speed"]= $item->{'wspdi'}; 
				 $history["wind_degrees"]= $item->{'wdird'}; 
				 $history["wind_direction"]= $item->{'wdire'}; 
				 $history["wind_gust"]= $item->{'wgusti'}; 
				 $history["humidity"]= $item->{'hum'}; 
				 $history["air_pressure"]= $item->{'pressurei'}; 
				 $history["dewpoint"]= $item->{'dewpti'}; 
				 break;
		 } else if($item->{'date'}->{'hour'} < $hour ){
			    
				 $history["temp"]= $item->{'tempi'};
				 $history["condition"]= $item->{'conds'}; 
				 $history["img_url"]= $item->{'icon'};  // NO URL
				 $history["wind_speed"]= $item->{'wspdi'}; 
				 $history["wind_degrees"]= $item->{'wdird'}; 
				 $history["wind_direction"]= $item->{'wdire'}; 
				 $history["wind_gust"]= $item->{'wgusti'}; 
				 $history["humidity"]= $item->{'hum'}; 
				 $history["air_pressure"]= $item->{'pressurei'}; 
				 $history["dewpoint"]= $item->{'dewpti'}; 
			     
			 
			 
			 
			     }
		  
		  
		 
		 
		}
		// Note that values will = -9999 or -999 for Null or Non applicable (NA) variables.
		return $history;
	}
	function get_hourly_weather($location,$hour,$day){
		// EDT time
	   $hourly = array();
	   $json_string = file_get_contents("http://api.wunderground.com/api/".$this->code["api"]."/hourly/q/".$location.".json");
	   echo $json_string; exit;
	   $parsed_json = json_decode($json_string);
	
	   foreach ($parsed_json->{'hourly_forecast'} as $item ){
	
		  if ($item->{'FCTTIME'}->{'hour'} == $hour && $item->{'FCTTIME'}->{'mday'} == $day){
			  $hourly["temp"]= $item->{'temp'}->{'english'};
			  $hourly["condition"]= $item->{'condition'}; 
			  $hourly["img_url"]= $item->{'icon_url'};  
			  $hourly["wind_speed"]= $item->{'wspd'}->{'english'}; 
			  $hourly["wind_degrees"]= $item->{'wdir'}->{'degrees'}; 
			  $hourly["wind_direction"]= $item->{'wdir'}->{'dir'}; 
			  $hourly["humidity"]= $item->{'humidity'}; 
			  $hourly["dewpoint"]= $item->{'dewpoint'}->{'english'}; 
		  }
	   }
		// Note that values will = -9999 or -999 for Null or Non applicable (NA) variables.
	  return $hourly;
	}
}


?>
<? require_once(ROOT_PATH . "/ck/db/handler.php"); ?>

<?
if (isset($_GET["date"])) { $date = $_GET["date"]; } else { $date = date("Y-m-d"); }

$schedule = get_baseball_schedule_app($date);

$data = array();

$str_game = "";
foreach($schedule as $game){
  $str_game .= $game["gameid"].",";
}
$str_game = substr($str_game,0,-1);

$weather = get_baseball_game_weather_app($str_game,$date); 
/*echo "<pre>";
print_r($weather);
echo "</pre>";
*/
$x = 0;
foreach ($schedule as $sh){ 
	 $away = explode("_",$sh["away"]);
	 $home = explode("_",$sh["home"]);	
	 $game_stadium = 	explode("_",$sh["stadium"]);
	 $pitcher_away = 	explode("_",$sh["pitcher_away"]);
	 $pitcher_home = 	explode("_",$sh["pitcher_home"]);
	 
	 $game_weather = $weather[$sh["gameid"]];
	 
	 $sh["away"] = $away[0];
	 $sh["away_name"] = $away[1];	
	 $sh["home"] = $home[0];
	 $sh["home_name"] = $home[1];
	 $sh["stadium"] = $game_stadium[0];
 	 $sh["zipcode"] = $game_stadium[1];
	 $sh["pitcher_away_name"] = $pitcher_away[0];
	 $sh["pitcher_away_img"] = $pitcher_away[1];
	 $sh["pitcher_home_name"] = $pitcher_home[0];
	 $sh["pitcher_home_img"] = $pitcher_home[1];
	 	 
	 //$sh["startdate"] = str_replace($date,"",$sh["startdate"]);
	 
	 if (!is_null($game_weather)){
	    $sh = array_merge($sh,$game_weather);
	 }
	 $data["Game_".$x] = $sh;
	 //break;
	
$x++;	
}

$date = date("Y_m_d");
$name = $date."_schedules.json";
	
//Creamos el JSON
$local_path = "json_files";
if (!file_exists($local_path)) {
   mkdir($local_path, 0777, true);
   chmod($local_path, 0777);
 
}
$json_string = json_encode($data);
$file = $local_path.'/'.$name;
file_put_contents($file, $json_string);




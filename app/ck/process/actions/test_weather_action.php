<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<?
// 
$parser = new _wheather_parser();
$stadium = get_baseball_stadium_by_team($_GET['thome']);
$game_id = $_GET['gid'];
$game_date = $_GET['gdate'];

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

//

/*
// TEST FOR GAME TIME
$current = get_current_weather($zipcode);
$day= date('d',strtotime(date("Y-m-d H:i:s")));
$hourly =  get_hourly_weather($zipcode,$hour,$day);
$weather = $current + $hourly;
$weather["date"] = $game_date;
$weather["stadium"] = $stadium->vars['id'];
$weather["game"] = $game_id;

echo"<pre>";
print_r($weather);
echo"</pre>";


//ACTIONS WERE DISABLED

$temp_weather_control = new _baseball_temp_weather($weather);
$temp_weather_control->insert();

//
*/




?>

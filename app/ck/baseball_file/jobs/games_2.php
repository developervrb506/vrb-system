<? $no_log_page = true; ?>
<? 
	ini_set('memory_limit', '-1');
    set_time_limit(0);

$hour = date("H");

if ($hour == 8){ 
	
	include("yesterday_game_data.php");
	}
	

if ($hour > 8 && $hour < 10){ 

include("baseball_stats.php");
 include("stadium_wind_data.php");
 echo @file_get_contents("http://localhost:8080/ck/baseball_file/jobs/pitchers_fantasy_Away.php");
  echo @file_get_contents("http://localhost:8080/ck/baseball_file/jobs/pitchers_fantasy_Home.php");

}
if ($hour > 9 && $hour < 11 ){ 

echo @file_get_contents("http://localhost:8080/ck/baseball_file/jobs/espn_stats_player_vs.php?type=away");

include("history_weather_fix.php");
include("weather_stadistics.php");
$date = date( "Y-m-d", strtotime( "-1 day", strtotime(date( "Y-m-d")))); 

    $stat = get_baseball_stats($date);

	if (is_null($stat)){
	  include("baseball_stats.php");	
	
	}
include("pitchers.php");
}

include("pitchers_game_changes.php");
include("catchers.php");
 
 
if ($hour > 12 && ($hour % 2)){
  echo @file_get_contents("http://localhost:8080/ck/baseball_file/jobs/pitchers_fantasy_Home.php");
  echo @file_get_contents("http://localhost:8080/ck/baseball_file/jobs/pitchers_fantasy_Away.php"); 
}
if ($hour > 12 && !($hour % 2)){
 echo @file_get_contents("http://localhost:8080/ck/baseball_file/jobs/espn_stats_player_vs.php?type=home");
}

?>
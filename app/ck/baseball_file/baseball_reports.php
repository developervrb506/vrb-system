<? include(ROOT_PATH . "/ck/process/security.php"); ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../../css/style.css" rel="stylesheet" type="text/css" />
<title>Baseball Reports</title>
<link rel="stylesheet" href="<?= BASE_URL ?>/includes/shadowbox/shadowbox.css" type="text/css" media="screen" />
<script type="text/javascript" src="<?= BASE_URL ?>/includes/shadowbox/shadowbox.js"></script>
<script type="text/javascript" src="<?= BASE_URL ?>/process/js/functions.js"> </script>
<script type="text/javascript">
Shadowbox.init();
</script>
</head>
<body>
<? include "../../includes/header.php" ?>
<? include "../../includes/menu_ck.php" ?>
<div class="page_content" style="padding-left:50px;">
<span class="page_title">Baseball Reports </span><br /><br />


<a href="javascript:display_div('weather_reports')" class="normal_link" title="Click to see the Weather Reports" ><strong>Weathers Reports</strong></a><BR><BR>  	

<div id="weather_reports" style="display:none"> 
&nbsp;&nbsp;&nbsp;<a href="stadium_weather_formulas_report.php" class="normal_link">- Weather Formulas Report</a><br />
&nbsp;&nbsp;&nbsp;Displays the higher and lower games,<BR>
&nbsp;&nbsp;&nbsp;According his Moist Air density, Dry Air, Vapour Pressure,PK.  Averages(Runs, Homeruns) by Stadium<BR>
<br /><br />

&nbsp;&nbsp;&nbsp;<a href="stadium_temp_facts_report.php" class="normal_link">- Weather Factors Report</a><br />
&nbsp;&nbsp;&nbsp;Displays the higher and lower games,<BR>
&nbsp;&nbsp;&nbsp;According his Humidity, Air Pressure, temperature and Dew Point. Averages(Runs, Homeruns) by Stadium<BR>
<br /><br />

&nbsp;&nbsp;&nbsp;<a href="weather_line_report.php" class="normal_link">- Weather Factors lines Report</a><br />
&nbsp;&nbsp;&nbsp;Displays the games according the selected weather factor and show the lines information<BR>
<br /><br />

&nbsp;&nbsp;&nbsp;<a href="wind_direction_report.php" class="normal_link">- Wind Direction Report</a><br />
&nbsp;&nbsp;&nbsp;Displays the games with more homeruns according the Wind Direction<BR>
<br /><br />


&nbsp;&nbsp;&nbsp;<a href="dryair_line_report.php" class="normal_link">- Dry Air Density lines</a><br />
&nbsp;&nbsp;&nbsp;Displays the games according the selected Dry Air Density range<BR>
<br /><br />

&nbsp;&nbsp;&nbsp;<a href="pk_line_report.php" class="normal_link">- PK lines</a><br />
&nbsp;&nbsp;&nbsp;Displays the games according the selected PK condition<BR>
<br /><br />

</div >

<a href="javascript:display_div('pitchers_reports')" class="normal_link" title="Click to see the Pitchers Reports" ><strong>Pitchers Reports</strong></a><BR><BR>  	

<div id="pitchers_reports" style="display:none"> 


&nbsp;&nbsp;&nbsp;<a href="pitchers_line_report.php" class="normal_link">- Pitchers line Report </a><br />
&nbsp;&nbsp;&nbsp;Displays the games according the amount of Pitches for the past Games.<BR>
<br /><br />

&nbsp;&nbsp;&nbsp;<a href="highest_data_pitcher_report.php" class="normal_link">- Pitchers Report </a><br />
&nbsp;&nbsp;&nbsp;Displays the highest data for the pitcher by Date Game or Team's Pitcher<BR>
<br /><br />


&nbsp;&nbsp;&nbsp;<a href="pitcher_away_games_report.php" class="normal_link">- Pitchers Away Last Games Report </a><br />
&nbsp;&nbsp;&nbsp;Displays the data for the third game. According the last 2 Games as away<BR>
<br /><br />



&nbsp;&nbsp;&nbsp;<a href="pitchers_faceoff_line_report.php" class="normal_link">- Pitchers Face-Off Report </a><br />
&nbsp;&nbsp;&nbsp;Displays the Face-Off pitchers and game information.<BR>
<br /><br /> 
</div >

<a href="javascript:display_div('team_reports')" class="normal_link" title="Click to see the Team Reports" ><strong>Team / Stadium Reports</strong></a><BR><BR>  	

<div id="team_reports" style="display:none"> 

&nbsp;&nbsp;&nbsp;<a href="top_games_stadiums_by_factor.php" class="normal_link">- Temp Factor Report </a><br />
&nbsp;&nbsp;&nbsp;Displays the top 10 for each stadium and show some stadistics according weather facts<BR>
<br /><br /> 

&nbsp;&nbsp;&nbsp;<a href="team_lose_line_report.php" class="normal_link">- Team Lost Line Report </a><br />
&nbsp;&nbsp;&nbsp;Displays the game information for the next game for the team that lose by several Runs.<BR>
<br /><br /> 


&nbsp;&nbsp;&nbsp;<a href="highest_data_by_stadium_report.php" class="normal_link">- Highest HomeRuns and Runs Report by Stadium </a><br />
&nbsp;&nbsp;&nbsp;Displays the game information According the amount of HomeRuns and Runs Report by Stadium, with all the wheater data .<BR>
<br /><br /> 

&nbsp;&nbsp;&nbsp;<a href="highest_runs_by_stadium_report.php" class="normal_link">- Highest Runs Report by Stadium </a><br />
&nbsp;&nbsp;&nbsp;Displays the game information According the amount of Runs above the inserted by Stadium .<BR>
<br /><br /> 



&nbsp;&nbsp;&nbsp;<a href="first_time_%20pitcher_by_stadium_report.php" class="normal_link">- First Time Pitcher by Stadium</a><br />
&nbsp;&nbsp;&nbsp;Displays the game information for the fisrt time Pitcher  by Stadium .<BR>
<br /><br /> 

&nbsp;&nbsp;&nbsp;<a href="domed_stadiums_report.php" class="normal_link">- Domed Stadiums report </a><br />
&nbsp;&nbsp;&nbsp;Displays the game information for Domed Stadiums .<BR>
<br /><br /> 

&nbsp;&nbsp;&nbsp;<a href="post_colorado_pitcher_report.php" class="normal_link">- Post Colorado Pitcher report </a><br />
&nbsp;&nbsp;&nbsp;Displays the game information for the post Colorado games .<BR>
<br /><br /> 



</div>

<a href="baseball_stats_report.php" class="normal_link">Salami Report</a><br />
Displays the Grand Salami Line and the PK AVG<BR>
<br /><br /> 

<a href="umpire_data_report.php" class="normal_link">Umpires Data Report </a><br />
Displays the Umpire Stadistics by Year.<BR>
<br /><br />

<a href="umpires_line_report.php" class="normal_link">Umpires line Report </a><br />
Displays the games according the Umpire Stadistics by Season.<BR>
<br /><br />

<a href="umpires_line_player_report.php" class="normal_link">Umpires line Player Report </a><br />
Displays the games according the Umpire Stadistics by Season and Player.<BR>
<br /><br />




<a href="highest_runs_report.php" class="normal_link">Highest Runs Report </a><br />
Displays the game information According the amount of Runs above the inserted and Espn Box Game link.<BR>
<br /><br /> 

<a href="team_report.php" class="normal_link">Team Report </a><br />
Displays the all games information for each team<BR>
<br /><br />

<a href="pitcher_report.php" class="normal_link">Pitcher Report </a><br />
Displays the all games information for each pitcher<BR>
<br /><br />
<a href="<?= BASE_URL ?>/ck/mlb_file/mlb_travel_report.php" class="normal_link">MLB Travel Report</a><br />
Show the Game Data according the # games and away games<BR>
<br /><br />
<a href="<?= BASE_URL ?>/ck/mlb_file/mlb_roadtrip_report.php" class="normal_link">MLB Road Trip Report</a> <br />
Show the information for the next Game after the # of Away Days <BR>
<br /><br />
<br /><br />
<a href="<?= BASE_URL ?>/ck/baseball_file/stadium_formula_data.php" class="normal_link">STADIUM FORMULA DATA</a> <br />
Manage the Data form the Stadiums Formulas PK - AIRP -ADI <BR>
<br /><br />






</div>
<? include "../../includes/footer.php" ?>
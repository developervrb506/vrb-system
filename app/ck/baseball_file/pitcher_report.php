<? include(ROOT_PATH . "/ck/process/security.php"); 
if($current_clerk->im_allow("baseball_file")){ ?>
   
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=10; IE=9; IE=8; IE=7; IE=EDGE" />
<link href="../../css/style.css" rel="stylesheet" type="text/css" />
<link href="./css/style.css" rel="stylesheet" type="text/css" />
<title>PITCHER REPORT</title>

<script type="text/javascript" src="<?= BASE_URL ?>/process/js/functions.js"> </script>
<script type="text/javascript" src="js/functions.js"> </script>
<script src="../includes/js/jquery-1.8.3.min.js"></script>  
<script type="text/javascript" src="<?= BASE_URL ?>/ck/includes/js/sortables.js"></script>
        
</head>
<body>
<? $page_style = " width:7400px;"; ?>
<? include "../../includes/header.php"  ?>
<? include "../../includes/menu_ck.php"  ?>
<? 

$team = clean_get("stadium");
$player = clean_get("player");
$all_seasons = get_all_baseball_seasons();	

if(isset($_POST['year'])){
 if($_POST['year'] != 1) { // 1 is all the seasons
   $season_year = ($_POST['year']);
   $year = $season_year;
 } else{ $year = ""; }	
}
//$year = date('Y');
$season =  get_baseball_season($year);
/*
echo $year;
echo "<pre>";
print_r($season);
echo "</pre>";
*/

$charlist = "\n\0\x0B";
$line = "";
if($year != ""){
$report_line ="Date\tHour\tAway\tHome\tHOMERUNS\tRUNS A\tRUNS H\tRUNS T\tSCORE\tSTATUS\tElev\tRoof\tRuns\tHomeRuns\tHits\t2B\t3B\tBB\tTMP\tCondition\tHM\tWS\tWD\tWP\tWG\tAirP\tDewP\tDryA\tVapourP\tMoistA\tPK\tUmpire\t".($year-5)."\tStarts\t".($year-4)."\tStarts\t".($year-3)."\tStarts\t".($year-2)."\tStarts\t".($year-1)."\tStarts\t".($year)."\tStarts\tPitcher\tGB %\tEra\tXFip\tEra/Diff\tK9\tRest Time\tHighest PC\tLast Game\tSum (3G)\tAvg (3G)\tSum (4G)\tAvg (4G)\tSum (5G)\tAvg (5G)\tAvg (S)\tAvg (Last S)\tFB%\tSL%\tCT%\tCB%\tCH%\tSF%\tKN%\tXX%\tSum_SCC%\tFBv (2G)\tFBv Last G.\tFBv Season\tPitcher\tGB %\tEra\tXFip\tEra/Diff\tK9\tRest Time\tHighest PC\tLast Game\tSum (3G)\tAvg (3G)\tSum (4G)\tAvg (4G)\tSum (5G)\tAvg (5G)\tAvg (S)\tAvg (Last S)\tFB%\tSL%\tCT%\tCB%\tCH%\tSF%\tKN%\tXX%\tSum_SCC%\tFBv (2G)\tFBv Last G.\tFBv Season\tBA IP\tBA PC\tBH IP\tBH PC\tIP  Total\tPC Total\tBA IP Season\tBA PC  Season\tBH IP  Season\tBH PC  Season\t+10 A\t+10 H\tMONEY A\tMONEY H\tTotal OVER\tTotal O JUICE\tTotal UNDER\tTotal U JUICE\tMONEY 1st 5 A\tMONEY 1st 5 H\tT. 0ver 1st 5 I\tT. 0. Juice 1st 5I\tT. Under 1st 5I\tT. U. Juice 1st 5I\tTeam A OVER\tTeam A O JUICE\tTeam A UNDER\tTeam A U JUICE\tTeam H OVER\tTeam H O JUICE\tTeam H UNDER\tTeam H U JUICE\t\n";
} else {
	
$report_line ="Date\tHour\tAway\tHome\tHOMERUNS\tRUNS A\tRUNS H\tRUNS T\tSCORE\tSTATUS\tElev\tRoof\tRuns\tHomeRuns\tHits\t2B\t3B\tBB\tTMP\tCondition\tHM\tWS\tWD\tWP\tWG\tAirP\tDewP\tDryA\tVapourP\tMoistA\tPK\tUmpire\tGame Year-5\tStarts\tGame Year-4\tStarts\tGame Year-3\tStarts\tGame Year -2 \tStarts\tGame Year -1\tStarts\tGame Year\tStarts\tPitcher\tGB %\tEra\tXFip\tEra/Diff\tK9\tRest Time\tHighest PC\tLast Game\tSum (3G)\tAvg (3G)\tSum (4G)\tAvg (4G)\tSum (5G)\tAvg (5G)\tAvg (S)\tAvg (Last S)\tFB%\tSL%\tCT%\tCB%\tCH%\tSF%\tKN%\tXX%\tSum_SCC%\tFBv (2G)\tFBv Last G.\tFBv Season\tPitcher\tGB %\tEra\tXFip\tEra/Diff\tK9\tRest Time\tHighest PC\tLast Game\tSum (3G)\tAvg (3G)\tSum (4G)\tAvg (4G)\tSum (5G)\tAvg (5G)\tAvg (S)\tAvg (Last S)\tFB%\tSL%\tCT%\tCB%\tCH%\tSF%\tKN%\tXX%\tSum_SCC%\tFBv (2G)\tFBv Last G.\tFBv Season\tBA IP\tBA PC\tBH IP\tBH PC\tIP  Total\tPC Total\tBA IP Season\tBA PC  Season\tBH IP  Season\tBH PC  Season\t+10 A\t+10 H\tMONEY A\tMONEY H\tTotal OVER\tTotal O JUICE\tTotal UNDER\tTotal U JUICE\tMONEY 1st 5 A\tMONEY 1st 5 H\tT. 0ver 1st 5 I\tT. 0. Juice 1st 5I\tT. Under 1st 5I\tT. U. Juice 1st 5I\tTeam A OVER\tTeam A O JUICE\tTeam A UNDER\tTeam A U JUICE\tTeam H OVER\tTeam H O JUICE\tTeam H UNDER\tTeam H U JUICE\t\n";
	
	
}


$stadiums = get_all_baseball_stadiums();
$all_players = get_baseball_player_by_type('pitcher');

$pk_total = 0;
$game_count = 0;
$ump_weighted_total = 0;
$ump_data = get_all_umpire_data();

    if($current_clerk->vars['id'] != 86 ){
	$subject = 'BASEBALL FILE PLAYER ACCESS';
	$content = "User: ".$current_clerk->vars['name']." IP: ".get_ip()." Date checked. ".$from;
	
	send_email_ck('aandrade@inspin.com', $subject, $content, true, $current_clerk->vars["fake_email"]);
	}

$j=0;


?>

<div class="page_content" style="padding-left:10px;">
<span class="page_title">Pitcher Report 
</span><BR>

<br /><br />


<form method="post">
    Pitcher: 
     <? create_objects_list("player", "player", $all_players, "fangraphs_player", "player", $default_name = "",$_POST["player"],"","_baseball_player");  ?>
       &nbsp;&nbsp;&nbsp;&nbsp;
 
   
    
    Season: 
    <select name="year" id="year"  >
	  <option value="1">All</option>
	  <?  foreach ( $all_seasons as $_year){ ?> 
        
        <? if ($_year["season"] > 2010){ ?>
        <option value="<? echo $_year["season"] ?>" <? if ($year == $_year["season"]) { echo "selected"; } ?>><? echo $_year["season"] ?></option>
        <?  } ?>
      
     <? } ?>
     </select>
    &nbsp;&nbsp;&nbsp;&nbsp;
   <input type="submit" value="Search" />
    &nbsp;&nbsp;&nbsp;&nbsp;<a href="javascript:;" onclick="document.getElementById('xml_form').submit();" class="normal_link">
	Export
	</a>
    <br /><br />
</form>

<? if (isset($_POST["player"])){  ?>
<div align="left">
	
  </div>
<?
$umpires = get_all_umpires();
$manual_wind = get_all_baseball_stadium_position();
$constants = get_baseball_constants();
//$constants = get_baseball_constants();

$games =  get_all_baseball_games_by_player($player,$year,$season['start'],$season['end']);


?>

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<span style="font-size:11px;">
    <strong>Elev: </strong>	Elevation above sea, 
    <strong>TMP: </strong>Temp in °F, 
    <strong>HM: </strong> % of Humidity, 
    <strong>WS: </strong>Wind Speed (mph),
    <strong>WD: </strong>Wind Direct, 
    <strong>WP </strong>Wind Position,  
    <strong>WG: </strong>Wind Gust (mph),     
    <strong>AirP: </strong>Pressure (in), 
    <strong>DewP: </strong>Dewpoint (°F), 
    <strong>DryA: </strong>Dry Air Density (kg/m3), 
    <strong>VapourP: </strong>Vapour Pressure(hPa), 
    <strong>MoistA: </strong>Moist Air Density (kg/m3), 
    <strong>M_A: </strong>Money Away,
    <strong>M_H: </strong>Money Home, 
    <strong>T 0: </strong>Total Over,
    <strong>T_0J: </strong>Total Over Juice,
    <strong>T U: </strong>Total Under,
    <strong>T_UJ: </strong>Total Under Juice,  
    <strong>T_0 1st 5I: </strong>Total Over 1st 5 Innings,
    <strong>T_0J 1st 5I: </strong>Total Over Juice 1st 5 Innings ,
    <strong>T_U 1st 5I: </strong>Total Under Juice 1st 5 Innings,
    <strong>T_UJ 1st 5I: </strong>Total Under Juice 1st 5 Innings,
    <strong>SCR: </strong>Score,
</span>
<iframe id="changer" width="1" height="1" scrolling="no" frameborder="0"></iframe>



<table  class="sortable"  id="baseball"  width="100%" border="0" cellspacing="0" cellpadding="0">
 <thead>
  <tr >
    <th style="cursor:pointer;"  width="120"  class="table_header" >Date</th>
    <th style="cursor:pointer;"  width="120"  class="table_header">Hour</th>
    <th style="cursor:pointer;"  width="120" class="table_header">Away
    <th style="cursor:pointer;"  width="120" class="table_header">Home</th>
    
    <th style="cursor:pointer;"  name="game_stadistics" width="120" class="table_header" align="center">HOMERUNS</th> 
    <th style="cursor:pointer;"  name="game_stadistics" width="120" class="table_header" align="center">RUNS A</th>  
    <th style="cursor:pointer;"  name="game_stadistics" width="120" class="table_header" align="center">RUNS H</th>
    <th style="cursor:pointer;"  name="game_stadistics" width="120" class="table_header" align="center">RUNS T</th>   
    <th style="cursor:pointer;"  name="game_stadistics" width="120" class="table_header" align="center">SCORE</th>
    <th style="cursor:pointer;"  name="game_stadistics" width="120" class="table_header" align="center">STATUS</th>    
    
    <th style="cursor:pointer;"  name="stadium_stadistics" width="120" class="table_header">Elev</th>
    <th style="cursor:pointer;"  name="stadium_stadistics" width="120" class="table_header">Roof</th>
    <th style="cursor:pointer;"  name="stadium_stadistics" width="120" class="table_header">Runs</th>
    <th style="cursor:pointer;"  name="stadium_stadistics" width="120" class="table_header">HomeRuns</th>
    <th style="cursor:pointer;"  name="stadium_stadistics" width="120" class="table_header">Hits</th>
    <th style="cursor:pointer;"  name="stadium_stadistics" width="120" class="table_header">2B</th>        
    <th style="cursor:pointer;"  name="stadium_stadistics" width="120" class="table_header">3B</th>        
    <th style="cursor:pointer;"  name="stadium_stadistics" width="120" class="table_header">BB</th>  
    <th style="cursor:pointer;"  name="weather_stadistics" width="120" class="table_header">TMP</th>
    <th style="cursor:pointer;"  name="weather_stadistics" width="120" class="table_header" align="center">Condition</th>
    <th style="cursor:pointer;"  name="weather_stadistics" width="120" class="table_header">HM</th>
    <th style="cursor:pointer;"  name="weather_stadistics" width="120" class="table_header">WS</th>
    <th style="cursor:pointer;"  name="weather_stadistics" width="120" class="table_header" align="center">WD</th>
    <th style="cursor:pointer;"  name="weather_stadistics" width="120" class="table_header">WP</th>
    <th style="cursor:pointer;"  name="weather_stadistics" width="120" class="table_header">WG</th>
    <th style="cursor:pointer;"  name="weather_stadistics" width="120" class="table_header">AirP</th>
    <th style="cursor:pointer;"  name="weather_stadistics" width="120" class="table_header">DewP</th>
    <th style="cursor:pointer;"  name="weather_stadistics" width="120" class="table_header">DryA</th>
    <th style="cursor:pointer;"  name="weather_stadistics" width="120" class="table_header">VapourP</th>  
    <th style="cursor:pointer;"  name="weather_stadistics" width="120" class="table_header">MoistA</th>
    <th style="cursor:pointer;"  name="weather_stadistics" width="120" class="table_header">PK</th>

    <? if($year != ""){?>
    <th style="cursor:pointer;"  name="umpire_stadistics" width="120" class="table_header">Umpire</th>
    <th style="cursor:pointer;"  name="umpire_stadistics" width="120" class="table_header"><? echo ($year-5)?></th>
    <th style="cursor:pointer;"  name="umpire_stadistics" width="120" class="table_header">Starts</th>
    <th style="cursor:pointer;"  name="umpire_stadistics" width="120" class="table_header"><? echo ($year-4)?></th>
    <th style="cursor:pointer;"  name="umpire_stadistics" width="120" class="table_header">Starts</th>
    <th style="cursor:pointer;"  name="umpire_stadistics" width="120" class="table_header"><? echo $year-3 ?></th>
    <th style="cursor:pointer;"  name="umpire_stadistics" width="120" class="table_header">Starts</th>
    <th style="cursor:pointer;"  name="umpire_stadistics" width="120" class="table_header"><? echo ($year-2)?></th>
    <th style="cursor:pointer;"  name="umpire_stadistics" width="120" class="table_header">Starts</th>
    <th style="cursor:pointer;"  name="umpire_stadistics" width="120" class="table_header"><? echo ($year-1)?></th>
    <th style="cursor:pointer;"  name="umpire_stadistics" width="120" class="table_header">Starts</th>
    <th style="cursor:pointer;"  name="umpire_stadistics" width="120" class="table_header"><? echo ($year)?> </th>
    <th style="cursor:pointer;"  name="umpire_stadistics" width="120" class="table_header">Starts</th>
    <? } else { ?>
    <th style="cursor:pointer;"  name="umpire_stadistics" width="120" class="table_header">Umpire</th>
    <th style="cursor:pointer;"  name="umpire_stadistics" width="120" class="table_header">Game Year -5</th>
    <th style="cursor:pointer;"  name="umpire_stadistics" width="120" class="table_header">Starts</th>
    <th style="cursor:pointer;"  name="umpire_stadistics" width="120" class="table_header">Game Year - 4 </th>
    <th style="cursor:pointer;"  name="umpire_stadistics" width="120" class="table_header">Starts</th>
    <th style="cursor:pointer;"  name="umpire_stadistics" width="120" class="table_header">Game Year - 3</th>
    <th style="cursor:pointer;"  name="umpire_stadistics" width="120" class="table_header">Starts</th>
    <th style="cursor:pointer;"  name="umpire_stadistics" width="120" class="table_header">Game Year - 2</th>
    <th style="cursor:pointer;"  name="umpire_stadistics" width="120" class="table_header">Starts</th>
    <th style="cursor:pointer;"  name="umpire_stadistics" width="120" class="table_header">Game Year - 1</th>
    <th style="cursor:pointer;"  name="umpire_stadistics" width="120" class="table_header">Starts</th>
    <th style="cursor:pointer;"  name="umpire_stadistics" width="120" class="table_header">Game Year</th>
    <th style="cursor:pointer;"  name="umpire_stadistics" width="120" class="table_header">Starts</th>
    
    
    <? } ?>
    
    <th style="cursor:pointer;"  name="pitcher_stadistics" width="120" class="table_header">Pitcher</th>
    <th style="cursor:pointer;"   name="pitcher_stadistics"  width="120"  class="table_header"> GB %</th>    
    <th style="cursor:pointer;"  name="pitcher_stadistics" width="120" class="table_header">Era</th>
    <th style="cursor:pointer;"  name="pitcher_stadistics" width="120" class="table_header">XFip</th>
    <th style="cursor:pointer;"  name="pitcher_stadistics" width="120" class="table_header">Era/Diff</th> 
    <th style="cursor:pointer;"  name="pitcher_stadistics" width="120" class="table_header">K9</th>                
    <th style="cursor:pointer;"  name="pitcher_stadistics" width="120" class="table_header" align="center">Rest Time</th>
    <th style="cursor:pointer;"  name="pitcher_stadistics" width="120" class="table_header" align="center" title="Highest Pitch Count">Highest PC</th>    
    <th style="cursor:pointer;"  name="pitcher_stadistics" width="120" class="table_header" align="center">Last Game</th>
    <th style="cursor:pointer;"  name="pitcher_stadistics" width="120" class="table_header" align="center">Sum (3G)</th>
    <th style="cursor:pointer;"  name="pitcher_stadistics" width="120" class="table_header" align="center">Avg (3G)</th>
    <th style="cursor:pointer;"  name="pitcher_stadistics" width="120" class="table_header" align="center">Sum (4G)</th>
    <th style="cursor:pointer;"  name="pitcher_stadistics" width="120" class="table_header" align="center">Avg (4G)</th>
    <th style="cursor:pointer;"  name="pitcher_stadistics" width="120" class="table_header" align="center">Sum (5G)</th>
    <th style="cursor:pointer;"  name="pitcher_stadistics" width="120" class="table_header" align="center">Avg (5G)</th>    
    <th style="cursor:pointer;"  name="pitcher_stadistics" width="120" class="table_header" align="center">Avg (S)</th>
    <th style="cursor:pointer;"  name="pitcher_stadistics" width="120" class="table_header" align="center">Avg (Last S)</th>
    <th style="cursor:pointer;"  name="pitcher_stadistics" width="120" class="table_header">FB%</th>
    <th style="cursor:pointer;"  name="pitcher_stadistics" width="120" class="table_header">SL%</th>
    <th style="cursor:pointer;"  name="pitcher_stadistics" width="120" class="table_header">CT%</th>
    <th style="cursor:pointer;"  name="pitcher_stadistics" width="120" class="table_header">CB%</th>
    <th style="cursor:pointer;"  name="pitcher_stadistics" width="120" class="table_header">CH%</th>
    <th style="cursor:pointer;"  name="pitcher_stadistics" width="120" class="table_header">SF%</th>
    <th style="cursor:pointer;"  name="pitcher_stadistics" width="120" class="table_header">KN%</th>  
    <th style="cursor:pointer;"  name="pitcher_stadistics" width="120" class="table_header">XX%</th>
    <th style="cursor:pointer;"  name="pitcher_stadistics" width="120" class="table_header">Sum_SCC%</th> 
    <th style="cursor:pointer;"  name="pitcher_stadistics" width="120" class="table_header">FBv (2G) </th>
    <th style="cursor:pointer;"  name="pitcher_stadistics" width="120" class="table_header">FBv Last G.</th>  
    <th style="cursor:pointer;"  name="pitcher_stadistics" width="120" class="table_header">FBv Season</th>
    
            
    <th style="cursor:pointer;"  name="pitcher_stadistics" width="120" class="table_header">Pitcher</th>
    <th style="cursor:pointer;"   name="pitcher_stadistics" width="120"  class="table_header"> GB %</th>      
    <th style="cursor:pointer;"  name="pitcher_stadistics" width="120" class="table_header">Era</th>
    <th style="cursor:pointer;"  name="pitcher_stadistics" width="120" class="table_header">XFip</th>
    <th style="cursor:pointer;"  name="pitcher_stadistics" width="120" class="table_header">Era/Diff</th>
    <th style="cursor:pointer;"  name="pitcher_stadistics" width="120" class="table_header">K9</th>    
    <th style="cursor:pointer;"  name="pitcher_stadistics" width="120" class="table_header" align="center">Rest Time</th>
    <th style="cursor:pointer;"  name="pitcher_stadistics" width="120" class="table_header" align="center" title="Highest Pitch Count">Highest PC</th>    
    <th style="cursor:pointer;"  name="pitcher_stadistics" width="120" class="table_header" align="center">Last Game</th>
    <th style="cursor:pointer;"  name="pitcher_stadistics" width="120" class="table_header" align="center">Sum (3G)</th>
    <th style="cursor:pointer;"  name="pitcher_stadistics" width="120" class="table_header" align="center">Avg (3G)</th>
    <th style="cursor:pointer;"  name="pitcher_stadistics" width="120" class="table_header" align="center">Sum (4G)</th>
    <th style="cursor:pointer;"  name="pitcher_stadistics" width="120" class="table_header" align="center">Avg (4G)</th>
    <th style="cursor:pointer;"  name="pitcher_stadistics" width="120" class="table_header" align="center">Sum (5G)</th>
    <th style="cursor:pointer;"  name="pitcher_stadistics" width="120" class="table_header" align="center">Avg (5G)</th>
    <th style="cursor:pointer;"  name="pitcher_stadistics" width="120" class="table_header" align="center">Avg (S)</th>
    <th style="cursor:pointer;"  name="pitcher_stadistics" width="120" class="table_header" align="center">Avg (Last S)</th>
    <th style="cursor:pointer;"  name="pitcher_stadistics" width="120" class="table_header">FB%</th>
    <th style="cursor:pointer;"  name="pitcher_stadistics" width="120" class="table_header">SL%</th>
    <th style="cursor:pointer;"  name="pitcher_stadistics" width="120" class="table_header">CT%</th>
    <th style="cursor:pointer;"  name="pitcher_stadistics" width="120" class="table_header">CB%</th>
    <th style="cursor:pointer;"  name="pitcher_stadistics" width="120" class="table_header">CH%</th>
    <th style="cursor:pointer;"  name="pitcher_stadistics" width="120" class="table_header">SF%</th>
    <th style="cursor:pointer;"  name="pitcher_stadistics" width="120" class="table_header">KN%</th>  
    <th style="cursor:pointer;"  name="pitcher_stadistics" width="120" class="table_header">XX%</th>
    <th style="cursor:pointer;"  name="pitcher_stadistics" width="120" class="table_header">Sum_SCC%</th> 
    <th style="cursor:pointer;"  name="pitcher_stadistics" width="120" class="table_header">FBv (2G) </th>
    <th style="cursor:pointer;"  name="pitcher_stadistics" width="120" class="table_header">FBv Last G.</th>  
    <th style="cursor:pointer;"  name="pitcher_stadistics" width="120" class="table_header">FBv Season</th> 
    
  
    
    <th style="cursor:pointer;"  name="bullpen_stadistics" width="120" class="table_header" align="center">BA IP </th>  
    <th style="cursor:pointer;"  name="bullpen_stadistics" width="120" class="table_header" align="center">BA PC</th>
    <th style="cursor:pointer;"  name="bullpen_stadistics" width="120" class="table_header" align="center">BH IP</th>  
    <th style="cursor:pointer;"  name="bullpen_stadistics" width="120" class="table_header" align="center">BH PC</th>
    <th style="cursor:pointer;"  name="bullpen_stadistics" width="120" class="table_header" align="center">IP  Total </th>  
    <th style="cursor:pointer;"  name="bullpen_stadistics" width="120" class="table_header" align="center">PC Total </th>
    
    <th style="cursor:pointer;"  name="bullpen_stadistics" width="120" class="table_header" align="center">BA IP Season </th>  
    <th style="cursor:pointer;"  name="bullpen_stadistics" width="120" class="table_header" align="center">BA PC  Season </th>
    <th style="cursor:pointer;"  name="bullpen_stadistics" width="120" class="table_header" align="center">BH IP  Season </th>  
    <th style="cursor:pointer;"  name="bullpen_stadistics" width="120" class="table_header" align="center">BH PC  Season </th>

    
    <th style="cursor:pointer;"   name="ten_stadistics" width="120" class="table_header" align="center">+10 A</th>  
    <th style="cursor:pointer;"   name="ten_stadistics" width="120" class="table_header" align="center">+10 H</th>  
 
    <th style="cursor:pointer;"  name="lines_stadistics" width="120" class="table_header" align="center">MONEY A</th>  
    <th style="cursor:pointer;"  name="lines_stadistics" width="120" class="table_header" align="center">MONEY H</th>  
    <th style="cursor:pointer;"  name="lines_stadistics" width="120" class="table_header" align="center">Total OVER</th>  
    <th style="cursor:pointer;"  name="lines_stadistics" width="120" class="table_header" align="center">Total O JUICE</th>  
    <th style="cursor:pointer;"  name="lines_stadistics" width="120" class="table_header" align="center">Total UNDER</th>  
    <th style="cursor:pointer;"  name="lines_stadistics" width="120" class="table_header" align="center">Total U JUICE</th> 
    
    <th style="cursor:pointer;"  name="lines_stadistics" width="120" class="table_header" align="center">MONEY 1st 5 A</th>  
    <th style="cursor:pointer;"  name="lines_stadistics" width="120" class="table_header" align="center">MONEY 1st 5 H</th> 
    <th style="cursor:pointer;"  name="lines_stadistics" width="120" class="table_header" align="center">T. 0ver 1st 5 I</th>  
    <th style="cursor:pointer;"  name="lines_stadistics" width="120" class="table_header" align="center">T. 0. Juice 1st 5I</th>  
    <th style="cursor:pointer;"  name="lines_stadistics" width="120" class="table_header" align="center">T. Under 1st 5I</th>  
    <th style="cursor:pointer;"  name="lines_stadistics" width="120" class="table_header" align="center">T. U. Juice 1st 5I</th>  
    
    <th style="cursor:pointer;"  name="lines_stadistics" width="120" class="table_header" align="center">Team A OVER</th>  
    <th style="cursor:pointer;"  name="lines_stadistics" width="120" class="table_header" align="center">Team A O JUICE</th>  
    <th style="cursor:pointer;"  name="lines_stadistics" width="120" class="table_header" align="center">Team A UNDER</th>  
    <th style="cursor:pointer;"  name="lines_stadistics" width="120" class="table_header" align="center">Team A U JUICE</th>
    <th style="cursor:pointer;"  name="lines_stadistics" width="120" class="table_header" align="center">Team H OVER</th>  
    <th style="cursor:pointer;"  name="lines_stadistics" width="120" class="table_header" align="center">Team H O JUICE</th>  
    <th style="cursor:pointer;"  name="lines_stadistics" width="120" class="table_header" align="center">Team H UNDER</th>  
    <th style="cursor:pointer;"  name="lines_stadistics" width="120" class="table_header" align="center">Team H U JUICE</th>
   

    
     
  </tr>
 </thead> 
 <tbody>
<?

 foreach($games as $game){
   
  $line = ""; 
  if($i % 2){$style = "1";}else{$style = "2";} $i++;
	
   $ump_id = 0;
   $ump_value = 0;
   
   $day= date('M-d-y',strtotime($game->vars["startdate"]));
   $hour= date('H:i',strtotime($game->vars["startdate"]));
   $date = date('Y-m-d',strtotime($game->vars["startdate"]));
   $year = date('Y',strtotime($game->vars["startdate"]));
   $season =  get_baseball_season($year);
	
	if ($i==1){
	 $lines_game = get_sport_lines($date,'MLB','Game',true);
	 $lines_innings = get_sport_lines($date,'MLB','1st 5 Innings',true);	
	}
	
	//Weather formulas
	$weather=get_baseball_game_weather($game->vars["id"],$game->vars["startdate"]) ;
	$stadium = get_baseball_stadium_by_team($game->vars["team_home"]);
	$stadium_position = $stadium->get_baseball_stadium_wind_position($weather->vars["wind_direction"]);
	
	if (!$game->vars["manual_wind"]){
	  $adjustment_factors = get_adjustment_factors($stadium_position['id']);  
	}
	else{
      $adjustment_factors = get_adjustment_factors($game->vars["manual_wind"]);  	
	}
	  
	if (!is_null($weather->vars["temp"])){
  	
	// pk
	 $pk=$game->get_pk($weather,$stadium,$adjustment_factors,$constants);
    }else { $pk = "0";}
	
	// Air Density
 	 
	 $temp_kelvin=$game->get_kelvin_temp($weather->vars["temp"]);
     $air_density = $game->get_air_density($game->get_pascals_from_inch_merc($weather->vars["air_pressure"]),$temp_kelvin);
	 $dewpoint_celsius = $game->get_celsius_temp($weather->vars["dewpoint"]);
	 $water_vapour = $game->get_water_vapour($dewpoint_celsius);
	 $moist_air_density = $game->get_moist_air_density ($game->get_pascals_from_inch_merc($weather->vars["air_pressure"]),$water_vapour, $temp_kelvin);
	 
	
	  $weather_style = "";
	  $orweather_style = "";
	  if ($pk <= -15) {$weather_style = "_red";}
	  else if ($pk >= 15) {$weather_style = "_green";}
	  $orweather_style = $weather_style;
	  
	  if ($weather->vars["wind_direction"] == 'Variable' ){$weather_style = "_gray";} 
	  
	  if ($stadium->vars["has_roof"] == 2 || !$game->vars["roof_open"]) {$weather_style = "_gray";} 
	  
	  
		  
	  ?> 
     <tr id="game_<? echo $game->vars["id"] ?>">
    
      <td class="table_td<? echo $style ?>" style="font-size:12px;"><? echo $day ?><? $line .= $day."\t "; ?></td>
      <td class="table_td<? echo $style ?>" style="font-size:12px;"><? echo $hour ?><? $line .= $hour."\t "; ?></td> 
         
      <td class="table_td<? echo $style ?>" style="font-size:12px;">
      	<? echo "(".$game->vars["away_rotation"].") ".$game->vars["away"] ?><? $line .= "(".$game->vars["away_rotation"].") ".$game->vars["away"]."\t "; ?>
      </td>
      
      <td   id="game_info_<? echo $game->vars["id"]?>" class="table_td<? echo $style ?>" style="font-size:12px;">
      	<? echo "(".$game->vars["home_rotation"].") ".$game->vars["home"]?><? $line .= "(".$game->vars["home_rotation"].") ".$game->vars["home"]."\t "; ?>
     </td>
     
     <td name="game_stadistics" title="Total of HomeRuns'"  class="table_td<? echo $style ?>" style="font-size:12px;" id="t_h_<? echo $game->vars["id"]?>">
       <? if (($game->vars["homeruns_away"] + $game->vars["homeruns_home"])>=0) { 
        	   echo  ($game->vars["homeruns_away"] + $game->vars["homeruns_home"]);  $line .= ($game->vars["homeruns_away"] + $game->vars["homeruns_home"])."\t "; 
	   } else{
		   echo "0"; $line .= "0 \t "; 
	   }
	   ?>
       
       </td>      
 
    
     <td  name="game_stadistics" title="Runs Away" class="table_td<? echo $style ?>" style="font-size:12px;" id="runs_a_<? echo $game->vars["id"]?>"><? echo  $game->vars["runs_away"] ?><? $line .= $game->vars["runs_away"] ."\t "; ?></td>  
     
     <td  name="game_stadistics" title="Runs Home" class="table_td<? echo $style ?>" style="font-size:12px;" id="runs_h_<? echo $game->vars["id"]?>" ><? echo  $game->vars["runs_home"] ?><? $line .= $game->vars["runs_home"]."\t "; ?></td>  
     
     <td name="game_stadistics" title="Game Runs" class="table_td<? echo $style ?>" style="font-size:12px;" id="game_runs_<? echo $game->vars["id"]?>"><? echo  ($game->vars["runs_away"] + $game->vars["runs_home"]) ?><? $line .= ($game->vars["runs_away"] + $game->vars["runs_home"])."\t "; ?></td>  
     
     <td name="game_stadistics" title="Final Score" class="table_td<? echo $style ?>" style="font-size:12px;" id="score_<? echo $game->vars["id"]?>" ><? echo  $game->vars["runs_away"]." - ".$game->vars["runs_home"]?><? $line .= $game->vars["runs_away"]." - ".$game->vars["runs_home"]."\t "; ?>  </td>  
     
    <td name="game_stadistics" title="Final Score" class="table_td<? echo $style ?>" style="font-size:12px;" id="score_<? echo $game->vars["id"]?>" ><? if ( $game->vars["runs_away"] > $game->vars["runs_home"] ) { echo "LOSE"; $line .= " LOSE \t"; } else { echo "WIN"; $line .= " WIN \t";} ?>  </td>  
      
       <td  name="stadium_stadistics" title="Elevation above sea level"  class="table_td<? echo $style ?>" style="font-size:12px;" id="elevation_<? echo $game->vars["id"]?>"><? echo  $stadium->vars["elevation"] ?><? $line .= $stadium->vars["elevation"]."\t "; ?></td>   
     
      <? // To control the PK avg excluding games with roof closed
       $roof = true;
	    if ($stadium->vars["has_roof"] == 1) { 
	       if (!$game->vars["roof_open"]){ $roof = false;} 
	    }
	   if ($stadium->vars["has_roof"] == 2) { $roof = false; }
	  ?>

       <td name="stadium_stadistics" title=""  class="table_td<? echo $style ?>" style="font-size:12px;" align="table_td<? echo $style.$orweather_style ?>" id="r<? echo $game->vars["id"]?>" >
		   <? if ($stadium->vars["has_roof"] ==1) { 
           	    echo $game->get_roof_comparison(); $line .=  str_replace("</strong>","",str_replace("<strong>","",$game->get_roof_comparison()))."\t "; }
              else if ($stadium->vars["has_roof"] ==2) {  $line .= "Always closed \t"; ?>
          		<strong>Always Closed</strong>
          <? }else{  $line .= "No Roof\t"; ?>
          		No Roof
          <? } ?>
      </td>
  <?    
   //stadium stadistics
     $stadium_stadistics = get_baseball_stadium_stadistics($stadium->vars['id'],$game->vars['id']);  
   ?>
    
     <td  name="stadium_stadistics" title="Stadium Run" class="table_td<? echo $style ?>" style="font-size:12px;" id="s_runs_<? echo $game->vars["id"]?>" ><? echo $stadium_stadistics->vars["runs"] ?> <? $line .= $stadium_stadistics->vars["runs"]."\t "; ?>  </td>     
     
     <td  name="stadium_stadistics" title="Stadium Home Runs" class="table_td<? echo $style ?>" style="font-size:12px;" id="s_hr_<? echo $game->vars["id"]?>"><? echo $stadium_stadistics->vars["homeruns"] ?> <? $line .= $stadium_stadistics->vars["homeruns"]."\t "; ?>  </td>     
      
     <td  name="stadium_stadistics" title="Stadium Hits" class="table_td<? echo $style ?>" style="font-size:12px;" id="s_hits_<? echo $game->vars["id"]?>"><? echo $stadium_stadistics->vars["hits"] ?> <? $line .= $stadium_stadistics->vars["hits"]."\t "; ?> </td>     
       
     <td  name="stadium_stadistics" title="Stadium Doubles" class="table_td<? echo $style ?>" style="font-size:12px;" id="s_doubles_<? echo $game->vars["id"]?>"><? echo $stadium_stadistics->vars["doubles"] ?> <? $line .= $stadium_stadistics->vars["doubles"]."\t "; ?> </td>     
      
     <td  name="stadium_stadistics" title="Stadium Triples" class="table_td<? echo $style ?>" style="font-size:12px;" id="s_triples_<? echo $game->vars["id"]?>" ><? echo $stadium_stadistics->vars["triples"] ?> <? $line .= $stadium_stadistics->vars["triples"]."\t "; ?>  </td>     
     
     <td  name="stadium_stadistics"  title="Stadium Walks" class="table_td<? echo $style ?>" style="font-size:12px;" id="s_walks_<? echo $game->vars["id"]?>"><? echo $stadium_stadistics->vars["walks"] ?> <? $line .= $stadium_stadistics->vars["walks"]."\t "; ?>  </td>   
  
     
 <? //weather  ?>    
   
           
      <td name="weather_stadistics" class="table_td<? echo $style.$weather_style ?>" style="font-size:12px;" id="t<? echo $game->vars["id"]?>"><? echo $weather->vars["temp"] ?><? $line .= $weather->vars["temp"]."\t "; ?></td> 
      
      <td name="weather_stadistics" class="table_td<? echo $style.$weather_style ?>" style="font-size:12px;" align="center" id="i<? echo $game->vars["id"]?>" >
      	<img  width="48" height="48" src="<? echo $weather->vars["img_url"] ?>"><br />
      	<? echo $weather->vars["condition"] ?> <? $line .=  $weather->vars["condition"]."\t "; ?>
      </td> 
      
      <td name="weather_stadistics" class="table_td<? echo $style.$weather_style ?>" style="font-size:12px;" id="h<? echo $game->vars["id"]?>">
	  	<? echo $weather->vars["humidity"] ?> <? $line .= $weather->vars["humidity"]."\t "; ?>
      </td> 
      
      <td name="weather_stadistics" class="table_td<? echo $style.$weather_style ?>" style="font-size:12px;" id="ws<? echo $game->vars["id"]?>">
	  	<? echo $weather->vars["wind_speed"] ?><? $line .=  $weather->vars["wind_speed"]."\t "; ?>
      </td> 
           
      <td name="weather_stadistics" class="table_td<? echo $style.$weather_style ?>" style="font-size:12px;<?
      
	   if ($weather->vars["wind_direction"] == $stadium->vars['wind_runs'] ||$weather->vars["wind_direction"] == $stadium->vars['wind_homeruns'] ){
		 echo ' background: green; ';  
		 }
	  ?>" align="center" id="wd<? echo $game->vars["id"]?>">
      
        <img src="images/s<? echo $stadium->vars["id"] ?>.jpg" width="48" height="48"  />
       
       
      <? if ($game->vars["manual_wind"]==0 || $game->vars["manual_wind"] == $stadium_position['id'] ){ ?>
       <img src="images/<? echo $weather->vars["wind_direction"] ?>.png" width="48" height="48" style="margin-top: -50px;"/>
         <? echo $weather->vars["wind_direction"] ?> <? $line .=  $weather->vars["wind_direction"]."\t "; ?>
         <? }
         else{
			echo "Position was Manual Selected";  $line .= "Position was Manual \t";
		 }?>

     </td> 
     
     <td name="weather_stadistics" class="table_td<? echo $style.$weather_style ?>" style="font-size:12px;" id="wp<? echo $game->vars["id"]?>">
	 	<? //display_div  <? echo $stadium_position["position"]
		$selected_position = $stadium_position['id']; 
		if ($game->vars["manual_wind"]){
			 
			 $selected_position = $game->vars["manual_wind"]; ?>
           <strong>Original:</strong> <? echo $stadium_position["position"] ?><? $line .= "Original: ". $stadium_position["position"]; ?><BR/> 
		   <strong>Selected:</strong>
           <? echo $manual_wind[$game->vars["manual_wind"]]->vars["position"];  ?> <? $line .= "Manual: ".$manual_wind[$game->vars["manual_wind"]]->vars["position"]."\t "; ?>   
           
		<? }
		else{ ?>
		  <? echo $stadium_position["position"]; ?>  <? $line .= $stadium_position["position"]."\t "; ?>  
 		<? } ?>
		
       </td>
     
       <td name="weather_stadistics" class="table_td<? echo $style.$weather_style ?>" style="font-size:12px;" id="wg<? echo $game->vars["id"]?>">
	 	<? echo $weather->vars["wind_gust"]?><? $line .= $weather->vars["wind_gust"]."\t "; ?>
       </td> 
     
       <td name="weather_stadistics" class="table_td<? echo $style.$weather_style ?>" style="font-size:12px;" id="ai<? echo $game->vars["id"]?>">
	 	<? echo $weather->vars["air_pressure"]?><? $line .= $weather->vars["air_pressure"]."\t "; ?>
       </td>
     
       <td name="weather_stadistics"  class="table_td<? echo $style.$weather_style ?>" style="font-size:12px;" id="dw<? echo $game->vars["id"]?>">
	 	<? echo $weather->vars["dewpoint"] ?><? $line .= $weather->vars["dewpoint"]."\t "; ?>
       </td> 
       
       <td name="weather_stadistics" class="table_td<? echo $style.$weather_style ?>" style="font-size:12px;" id="air_d<? echo $game->vars["id"]?>">
	 	<? echo $air_density ?><? $line .= $air_density."\t "; ?>
       </td> 
     
       <td name="weather_stadistics" class="table_td<? echo $style.$weather_style ?>" style="font-size:12px;" id="wat_v<? echo $game->vars["id"]?>">
	 	<? echo $water_vapour ?><? $line .= $water_vapour."\t "; ?>
       </td> 
     
       <td name="weather_stadistics" class="table_td<? echo $style.$weather_style ?>" style="font-size:12px;" id="air_m<? echo $game->vars["id"]?>">
	 	<? echo $moist_air_density ?><? $line .= $moist_air_density."\t "; ?>
       </td> 
       <? 
	   if ($roof) {	$pk_total = $pk_total + $pk; $game_count++; }
		
	   ?>
       <td name="weather_stadistics" class="table_td<? echo $style.$weather_style ?>" style="font-size:12px;" id="pk<? echo $game->vars["id"]?>">
	 	<? echo $pk ?><? $line .= $pk."\t "; ?>
       </td> 
      
     
     <? //Player
	 
	
   
     if ($game->vars["pitcher_away"]){
		
		//$player_a= get_player_data_stadistics
		
		$player_a = get_baseball_player_by_id("fangraphs_player",$game->vars["pitcher_away"]);
		//print_r($player_a);
	    $player_h = get_baseball_player_by_id("fangraphs_player",$game->vars["pitcher_home"]);  
		$pitches_count_a = get_baseball_player_highest_pitches($game->vars["pitcher_away"]);
		$pitches_count_h = get_baseball_player_highest_pitches($game->vars["pitcher_home"]);		
		$stadistics_a = get_player_basic_stadistics($game->vars["pitcher_away"],$year,true,$game->vars["id"]);        if (is_null($stadistics_a)) { $stadistics_a = new _baseball_player_stadistics_by_game();}                  
        $stadistics_h = get_player_basic_stadistics($game->vars["pitcher_home"],$year,true,$game->vars["id"]);         if (is_null($stadistics_h)) { $stadistics_h = new _baseball_player_stadistics_by_game();}         
	    $player_name_a = $player_a->vars["player"];
	    $player_name_b =  $player_h->vars["player"];
		
      }
      else{
	   
		$player_name_a = "";
	    $player_name_b = "";
	    $stadistics_a = array();
   	    $stadistics_h = array();
	    }
?>   

   

    
       
<?   
	
	     $umpire_statistics = get_umpire_stadistics($game->vars["umpire"],$year);
	     $umpire = $umpire_statistics[$year]->vars["full_name"];
	     
		 
           ?><td name="umpire_stadistics" class="table_td<? echo $style ?>" style="font-size:12px;"><? echo $umpire  ?><? $line .= $umpire."\t "; ?></td>
	     
	
	     <? for ($y=5;$y>-1;$y--){
			 
			  if (!$y){
			  $k_bb = $game->vars["umpire_kbb"];	 
			  }
			  else{			 
			  $k_bb= $umpire_statistics[$year-$y]->vars["k_bb"];
			  }
			 
			  
			   preg_match_all('/((?:\d+)(?:\.\d*)?)/',$column_desc[$year-$y]["description"],$matches);
			   $k_avg = $matches[0][0];
			   $color = "#000";
			   
			   if ($k_avg > $k_bb) { $color = "#0C3"; }
			   else { $color = "#F00"; }
			   
			   
			 
			  ?>	    
             <td name="umpire_stadistics" class="table_td<? echo $style ?>" style="font-size:12px; color:<? echo $color ?>"><strong><? echo $k_bb  ?></strong><? $line .= $k_bb."\t"; ?></td>  
             <?
			 if (!$y){
			  $total_starts = $game->vars["umpire_starts"];	 
			  }
			  else{		
			 $total_starts = ($umpire_statistics[$year-$y]->vars["hw"] + $umpire_statistics[$year-$y]->vars["rw"]);
			  }
			 ?>	 
             <td name="umpire_stadistics" class="table_td<? echo $style ?>" style="font-size:12px;" align="center"><? echo $total_starts ?><? $line .= $total_starts."\t"; ?></td>  	 
	     <? }
	  
	 
	  
        
		?>
         <? $ump_weighted_total = $ump_weighted_total + $ump_value; ?>
		
    
 
   <td name="pitcher_stadistics" title="Pitcher <? echo $game->vars["away"]  ?>" class="table_td<? echo $style ?>" style="font-size:12px;" id="pitcher_a_<? echo $game->vars["id"]?>">
      <? echo "<strong>".$player_name_a."</strong>"; ?><? $line .= $player_name_a."\t "; ?></td>
       <td name="groundball_stadistics" class="table_td<? echo $style ?>" style="font-size:12px;"><? echo $stadistics_a->vars['gb'] ?><? $line .= $stadistics_a->vars['gb']."\t"; ?></td>

   
   <?
  $last_game_color = "";
  $last_3game_color = "";
  if ($stadistics_a->vars['total_last_game'] >= 120){
   $last_game_color = "background-color: #6C9";
  }
 if ($stadistics_a->vars['sum_last_games'] >= 330){
  $last_3game_color = "background-color: #6C9";
 }
?>   
    <td name="pitcher_stadistics" title=""  class="table_td<? echo $style ?>" style="font-size:12px;"><? echo $stadistics_a->vars['era']?><? $line .= $stadistics_a->vars['era']."\t "; ?></td>
    <td name="pitcher_stadistics" title=""  class="table_td<? echo $style ?>" style="font-size:12px;"><? echo $stadistics_a->vars['xfip']?><? $line .= $stadistics_a->vars['xfip']."\t "; ?></td>  
    <?
     $diff = ((float)$stadistics_a->vars['era'] - (float)$stadistics_a->vars['xfip']);
	 if ($diff < 0 ) {$era_color = 'green';} else {$era_color = 'red';}
	?>     
    <td name="pitcher_stadistics" title=""  class="table_td<? echo $style ?>" style="font-size:12px; color:<? echo $era_color ?>"><strong><? echo $diff ?></strong>    
    <? $line .= $diff."\t "; ?></td>
   
    <td name="pitcher_stadistics" class="table_td<? echo $style ?>" style="font-size:12px;"><? echo $stadistics_a->vars['k9'] ?><? $line .= $stadistics_a->vars['k9']."\t "; ?></td>
   
   
    <td name="pitcher_stadistics" title=""  class="table_td<? echo $style ?>" style="font-size:12px;"><? echo $stadistics_a->vars['rest_time']?><? $line .= $stadistics_a->vars['rest_time']."\t "; ?>
    </td>
    <td name="pitcher_stadistics" title=""  class="table_td<? echo $style ?>" style="font-size:12px;"><? echo $pitches_count_a['pitch_count'] ?><? $line .= $pitches_count_a['pitch_count']."\t "; ?>
    </td>
    <td name="pitcher_stadistics" title="Pitches for the Last Game" class="table_td<? echo $style ?>" style="font-size:12px; <? echo $last_game_color ?>" id="total_last_game_a_<? echo $game->vars["id"]?>"><? echo $stadistics_a->vars['total_last_game'] ?><? $line .=  $stadistics_a->vars['total_last_game']."\t "; ?></td>
    <td name="pitcher_stadistics" title="Total Pitches Last 3 Games" class="table_td<? echo $style ?>" style="font-size:12px; <? echo $last_3game_color ?>" id="sum_last_games_a_<? echo $game->vars["id"]?>"><? echo $stadistics_a->vars['sum_last_games']?><? $line .= $stadistics_a->vars['sum_last_games']."\t "; ?></td>
    <td name="pitcher_stadistics" title="Avg Pitches Last 3 Games"  class="table_td<? echo $style ?>" style="font-size:12px;" id="avg_last_games_a_<? echo $game->vars["id"]?>"><? echo $stadistics_a->vars['avg_last_games']?><? $line .= $stadistics_a->vars['avg_last_games']."\t "; ?></td> 
    <td name="pitcher_stadistics" title="Total Pitches Last 4 Games" class="table_td<? echo $style ?>" style="font-size:12px;" id="sum_last_four_games_a_<? echo $game->vars["id"]?>"><? echo $stadistics_a->vars['sum_last_four_games']?><? $line .= $stadistics_a->vars['sum_last_four_games']."\t "; ?></td>
    <td name="pitcher_stadistics" title="Avg Pitches Last 4 Games"  class="table_td<? echo $style ?>" style="font-size:12px;" id="avg_last_four_games_a_<? echo $game->vars["id"]?>"><? echo $stadistics_a->vars['avg_last_four_games']?><? $line .= $stadistics_a->vars['avg_last_four_games']."\t "; ?></td> 
 <td name="pitcher_stadistics" title="Total Pitches Last 5 Games" class="table_td<? echo $style ?>" style="font-size:12px;" id="sum_last_five_games_a_<? echo $game->vars["id"]?>"><? echo $stadistics_a->vars['sum_last_five_games']?><? $line .= $stadistics_a->vars['sum_last_five_games']."\t "; ?></td>
    <td name="pitcher_stadistics" title="Avg Pitches Last 5 Games"  class="table_td<? echo $style ?>" style="font-size:12px;" id="avg_last_five_games_a_<? echo $game->vars["id"]?>"><? echo $stadistics_a->vars['avg_last_five_games']?><? $line .= $stadistics_a->vars['avg_last_five_games']."\t "; ?></td>    
    <td name="pitcher_stadistics" title="Avg Pitches this Season" class="table_td<? echo $style ?>" style="font-size:12px;" id="avg_season_a_<? echo $game->vars["id"]?>"><? echo $stadistics_a->vars['avg_season']?><? $line .= $stadistics_a->vars['avg_season']."\t "; ?></td> 
	<td name="pitcher_stadistics" title="Avg Pitches Last Season" class="table_td<? echo $style ?>" style="font-size:12px;" id="avg_last_season_a_<? echo $game->vars["id"]?>"><? echo $stadistics_a->vars['last_season'] ?><? $line .= $stadistics_a->vars['last_season']."\t "; ?></td>
	
	<td name="pitcher_stadistics"  class="table_td<? echo $style ?>" style="font-size:12px;"><? echo $stadistics_a->vars['fb'] ?><? $line .= $stadistics_a->vars['fb']."\t "; ?></td>
    <td name="pitcher_stadistics" class="table_td<? echo $style ?>" style="font-size:12px;"><? echo $stadistics_a->vars['sl'] ?><? $line .= $stadistics_a->vars['sl']."\t "; ?></td>
    <td name="pitcher_stadistics" class="table_td<? echo $style ?>" style="font-size:12px;"><? echo $stadistics_a->vars['ct'] ?><? $line .= $stadistics_a->vars['ct']."\t "; ?></td>   
    <td name="pitcher_stadistics" class="table_td<? echo $style ?>" style="font-size:12px;"><? echo $stadistics_a->vars['cb'] ?><? $line .= $stadistics_a->vars['cb']."\t "; ?></td>
    <td name="pitcher_stadistics" class="table_td<? echo $style ?>" style="font-size:12px;"><? echo $stadistics_a->vars['ch'] ?><? $line .= $stadistics_a->vars['ch']."\t "; ?></td>
    <td name="pitcher_stadistics" class="table_td<? echo $style ?>" style="font-size:12px;"><? echo $stadistics_a->vars['sf'] ?><? $line .= $stadistics_a->vars['sf']."\t "; ?></td>
    <td name="pitcher_stadistics" class="table_td<? echo $style ?>" style="font-size:12px;"><? echo $stadistics_a->vars['kn'] ?><? $line .= $stadistics_a->vars['kn']."\t "; ?></td>
    <td name="pitcher_stadistics" class="table_td<? echo $style ?>" style="font-size:12px;"><? echo $stadistics_a->vars['xx'] ?><? $line .= $stadistics_a->vars['xx']."\t "; ?></td>
   <?
      $x = (myStrstrTrue((float)$stadistics_a->vars['sl'],'%',true) + myStrstrTrue((float)$stadistics_a->vars['ct'],'%',true) + myStrstrTrue((float)$stadistics_a->vars['cb'],'%',true)) ;
      //$xt = (myStrstrTrue($stadistics_a->vars['sl_total'],'%',true) + myStrstrTrue($stadistics_a->vars['ct_total'],'%',true) + myStrstrTrue($stadistics_a->vars['cb_total'],'%',true)) ;
   ?> 
    <td name="pitcher_stadistics" class="table_td<? echo $style ?>" style="font-size:12px;"><? echo number_format($x,2) ?> %<? $line .= number_format($x,2)."\t "; ?></td>
    <td name="pitcher_stadistics" title="FastBall Velocity 2 Games" class="table_td<? echo $style ?>" style="font-size:12px;" id="FastBall_velicity1_a_<? echo $game->vars["id"]?>"><? echo $stadistics_a->vars['last_two_game_velocity'] ?><? $line .= $stadistics_a->vars['last_two_game_velocity']."\t "; ?></td>
	<td name="pitcher_stadistics" title="FastBall Velocity last Games" class="table_td<? echo $style ?>" style="font-size:12px;" id="FastBall_velicity2_a_<? echo $game->vars["id"]?>"><? echo $stadistics_a->vars['last_game_velocity'] ?><? $line .= $stadistics_a->vars['last_game_velocity']."\t "; ?></td>
	<td name="pitcher_stadistics" title="FastBall Velocity This Season" class="table_td<? echo $style ?>" style="font-size:12px;" id="FastBall_velicity_season_a_<? echo $game->vars["id"]?>"><? echo $stadistics_a->vars['season_velocity'] ?><? $line .= $stadistics_a->vars['season_velocity']."\t "; ?></td>
	
    
    
  	<td name="pitcher_stadistics" title="Pitcher <? echo $game->vars["home"]  ?>" class="table_td<? echo $style ?>" style="font-size:12px;"  id="pitcher_b_<? echo $game->vars["id"]?>">
     <? echo "<strong>".$player_name_b."</strong>";  ?> <? $line .= $player_name_b."\t "; ?>
    </td> 
    <td name="groundball_stadistics"  class="table_td<? echo $style ?>" style="font-size:12px;"><? echo $stadistics_h->vars['gb'] ?><? $line .= $stadistics_h->vars['gb']."\t "; ?></td>
<?
 $last_game_color = "";
 $last_3game_color = "";
  if ($stadistics_h->vars['total_last_game'] >= 120){
   $last_game_color = "background-color: #6C9";
  }
 if ($stadistics_h->vars['sum_last_games'] >= 330){
   $last_3game_color = "background-color: #6C9";
 }
?>   
 <td name="pitcher_stadistics" title=""  class="table_td<? echo $style ?>" style="font-size:12px;"><? echo $stadistics_h->vars['era']?><? $line .= $stadistics_h->vars['era']."\t "; ?></td>
    <td name="pitcher_stadistics" title=""  class="table_td<? echo $style ?>" style="font-size:12px;"><? echo $stadistics_h->vars['xfip']?><? $line .= $stadistics_h->vars['xfip']."\t "; ?></td>  
    <?
     $diff = ($stadistics_h->vars['era'] -  $stadistics_h->vars['xfip']);
	 if ($diff < 0 ) {$era_color = 'green';} else {$era_color = 'red';}
	?>     
    <td name="pitcher_stadistics" title=""  class="table_td<? echo $style ?>" style="font-size:12px; color:<? echo $era_color ?>"><strong><? echo $diff ?></strong><? $line .= $diff."\t "; ?></td>      
    
     <td name="pitcher_stadistics" class="table_td<? echo $style ?>" style="font-size:12px;"><? echo $stadistics_h->vars['k9'] ?><? $line .= $stadistics_h->vars['k9']."\t "; ?></td>
   
    
    <td name="pitcher_stadistics" title="" class="table_td<? echo $style ?>" style="font-size:12px;"><? echo $stadistics_h->vars['rest_time']?><? $line .= $stadistics_h->vars['rest_time']."\t "; ?>
    </td>
        <td name="pitcher_stadistics" title=""  class="table_td<? echo $style ?>" style="font-size:12px;"><? echo $pitches_count_h['pitch_count'] ?><? $line .= $pitches_count_h['pitch_count']."\t "; ?>
    </td>
    <td name="pitcher_stadistics" title="Pitches for the Last Game" class="table_td<? echo $style ?>" style="font-size:12px; <? echo $last_game_color ?>" id="total_last_game_h_<? echo $game->vars["id"]?>"><? echo $stadistics_h->vars['total_last_game'] ?><? $line .= $stadistics_h->vars['total_last_game']."\t "; ?></td>
    <td name="pitcher_stadistics" title="Total Pitches Last 3 Games" class="table_td<? echo $style ?>" style="font-size:12px; <? echo $last_3game_color ?>" id="sum_last_games_h_<? echo $game->vars["id"]?>"><? echo $stadistics_h->vars['sum_last_games']?><? $line .= $stadistics_h->vars['sum_last_games']."\t "; ?></td>
    <td name="pitcher_stadistics" title="Avg Pitches Last 3 Games" class="table_td<? echo $style ?>" style="font-size:12px;" id="avg_last_games_h_<? echo $game->vars["id"]?>"><? echo $stadistics_h->vars['avg_last_games']?><? $line .= $stadistics_h->vars['avg_last_games']."\t "; ?></td> 
    <td name="pitcher_stadistics" title="Total Pitches Last 4 Games" class="table_td<? echo $style ?>" style="font-size:12px;" id="sum_last_four_games_h_<? echo $game->vars["id"]?>"><? echo $stadistics_h->vars['sum_last_four_games']?><? $line .= $stadistics_h->vars['sum_last_four_games']."\t "; ?></td>
    <td name="pitcher_stadistics" title="Avg Pitches Last 4 Games"  class="table_td<? echo $style ?>" style="font-size:12px;" id="avg_last_four_games_h_<? echo $game->vars["id"]?>"><? echo $stadistics_h->vars['avg_last_four_games']?><? $line .= $stadistics_h->vars['avg_last_four_games']."\t "; ?></td> 
 <td name="pitcher_stadistics" title="Total Pitches Last 5 Games" class="table_td<? echo $style ?>" style="font-size:12px;" id="sum_last_five_games_h_<? echo $game->vars["id"]?>"><? echo $stadistics_h->vars['sum_last_five_games']?><? $line .= $stadistics_h->vars['sum_last_five_games']."\t "; ?></td>
    <td name="pitcher_stadistics" title="Avg Pitches Last 5 Games"  class="table_td<? echo $style ?>" style="font-size:12px;" id="avg_last_five_games_h_<? echo $game->vars["id"]?>"><? echo $stadistics_h->vars['avg_last_five_games']?><? $line .= $stadistics_h->vars['avg_last_five_games']."\t "; ?></td>      
    <td name="pitcher_stadistics" title="Avg Pitches this Season" class="table_td<? echo $style ?>" style="font-size:12px;" id="avg_season_h_<? echo $game->vars["id"]?>"><? echo $stadistics_h->vars['avg_season']?><? $line .= $stadistics_h->vars['avg_season']."\t "; ?></td> 
	<td name="pitcher_stadistics" title="Avg Pitches Last Season"  class="table_td<? echo $style ?>" style="font-size:12px;" id="avg_last_season_h_<? echo $game->vars["id"]?>"><? echo $stadistics_h->vars['last_season'] ?><? $line .= $stadistics_h->vars['last_season']."\t "; ?></td>
	
	<td name="pitcher_stadistics"  class="table_td<? echo $style ?>" style="font-size:12px;"><? echo $stadistics_h->vars['fb'] ?><? $line .= $stadistics_h->vars['fb']."\t "; ?></td>
    <td name="pitcher_stadistics" class="table_td<? echo $style ?>" style="font-size:12px;"><? echo $stadistics_h->vars['sl'] ?><? $line .= $stadistics_h->vars['sl']."\t "; ?></td>
    <td name="pitcher_stadistics" class="table_td<? echo $style ?>" style="font-size:12px;"><? echo $stadistics_h->vars['ct'] ?><? $line .= $stadistics_h->vars['ct']."\t "; ?></td>   
    <td name="pitcher_stadistics" class="table_td<? echo $style ?>" style="font-size:12px;"><? echo $stadistics_h->vars['cb'] ?><? $line .= $stadistics_h->vars['cb']."\t "; ?></td>
    <td name="pitcher_stadistics" class="table_td<? echo $style ?>" style="font-size:12px;"><? echo $stadistics_h->vars['ch'] ?><? $line .= $stadistics_h->vars['ch']."\t "; ?></td>
    <td name="pitcher_stadistics" class="table_td<? echo $style ?>" style="font-size:12px;"><? echo $stadistics_h->vars['sf'] ?><? $line .= $stadistics_h->vars['sf']."\t "; ?></td>
    <td name="pitcher_stadistics" class="table_td<? echo $style ?>" style="font-size:12px;"><? echo $stadistics_h->vars['kn'] ?><? $line .= $stadistics_h->vars['kn']."\t "; ?></td>
    <td name="pitcher_stadistics" class="table_td<? echo $style ?>" style="font-size:12px;"><? echo $stadistics_h->vars['xx'] ?><? $line .= $stadistics_h->vars['xx']."\t "; ?></td>
    
    <?
      $x = (myStrstrTrue((float)$stadistics_h->vars['sl'],'%',true) + myStrstrTrue((float)$stadistics_h->vars['ct'],'%',true) + myStrstrTrue((float)$stadistics_h->vars['cb'],'%',true)) ;
      //$xt = (myStrstrTrue($stadistics_h->vars['sl_total'],'%',true) + myStrstrTrue($stadistics_h->vars['ct_total'],'%',true) + myStrstrTrue($stadistics_h->vars['cb_total'],'%',true)) ;
   ?> 
    
    <td name="pitcher_stadistics" class="table_td<? echo $style ?>" style="font-size:12px;"><? echo number_format($x,2) ?> %<? $line .= number_format($x,2)."\t "; ?></td>
    <td name="pitcher_stadistics" title="FastBall Velocity 2 Games" class="table_td<? echo $style ?>" style="font-size:12px;" id="FastBall_velicity1_h_<? echo $game->vars["id"]?>"><? echo $stadistics_h->vars['last_two_game_velocity'] ?><? $line .= $stadistics_h->vars['last_two_game_velocity']."\t "; ?></td>
	<td name="pitcher_stadistics" title="FastBall Velocity last Games" class="table_td<? echo $style ?>" style="font-size:12px;" id="FastBall_velicity2_h_<? echo $game->vars["id"]?>"><? echo $stadistics_h->vars['last_game_velocity'] ?><? $line .= $stadistics_h->vars['last_game_velocity']."\t "; ?></td>
	<td name="pitcher_stadistics" title="FastBall Velocity This Season" class="table_td<? echo $style ?>" style="font-size:12px;" id="FastBall_velicity_season_h_<? echo $game->vars["id"]?>"><? echo $stadistics_h->vars['season_velocity'] ?><? $line .= $stadistics_h->vars['season_velocity']."\t "; ?></td>
    
   
    
 <?  //Bullpen 3 days
	
	$bullpen_a = get_team_bullpen($game->vars["team_away"],$date,3);
	$bullpen_h = get_team_bullpen($game->vars["team_home"],$date,3);
	
	 if ($bullpen_a->vars['ip'] > 10 ) { $baip_color = "#0C3"; }
			   else { $baip_color = "#F00"; }
	 if ($bullpen_h->vars['ip'] > 10 ) { $bhip_color = "#0C3"; }
			   else { $bhip_color = "#F00"; }
	 if ($bullpen_a->vars['pc'] > 200 ) { $bapc_color = "#0C3"; }
			   else { $bapc_color = "#F00"; }	
			   
	 if ($bullpen_h->vars['pc'] > 200 ) { $bhpc_color = "#0C3"; }
			   else { $bhpc_color = "#F00"; }			   	   
?>
    <td  title="Bullpen IP" name="bullpen_stadistics"   class="table_td<? echo $style ?>" style="font-size:12px;color:<? echo $baip_color ?>" id="ip_a_<? echo $game->vars["id"]?>"><? echo $bullpen_a->vars['ip'] ?><? $line .= $bullpen_a->vars['ip']."\t "; ?></td>
    <td  title="Bullpen PC" name="bullpen_stadistics" class="table_td<? echo $style ?>" style="font-size:12px;;color:<? echo $bapc_color ?>" id="pc_a_<? echo $game->vars["id"]?>" ><? echo $bullpen_a->vars['pc'] ?><? $line .= $bullpen_a->vars['pc']."\t "; ?></td>
    <td title="Bullpen IP" name="bullpen_stadistics"  class="table_td<? echo $style ?>" style="font-size:12px;color:<? echo $bhip_color ?>" id="ip_h_<? echo $game->vars["id"]?>" ><? echo $bullpen_h->vars['ip'] ?><? $line .= $bullpen_h->vars['ip']."\t "; ?></td>
    <td title="Bullpen PC" name="bullpen_stadistics"  class="table_td<? echo $style ?>" style="font-size:12px;;color:<? echo $bhpc_color ?>" id="pc_h_<? echo $game->vars["id"]?>" ><? echo $bullpen_h->vars['pc'] ?><? $line .= $bullpen_h->vars['pc']."\t "; ?></td>
    <td title="Bullpen IP" name="bullpen_stadistics"  class="table_td<? echo $style ?>" style="font-size:12px;" id="ipt_h_<? echo $game->vars["id"] ?>" ><? echo number_format($bullpen_a->vars['ip'] +  $bullpen_h->vars['ip'],1) ?><? $line .= number_format($bullpen_a->vars['ip'] +  $bullpen_h->vars['ip'],1)."\t "; ?></td>
    <td title="Bullpen PC" name="bullpen_stadistics"  class="table_td<? echo $style ?>" style="font-size:12px;" id="pct_h_<? echo $game->vars["id"] ?>" ><? echo $bullpen_a->vars['pc'] + $bullpen_h->vars['pc'] ?><? $line .= $bullpen_a->vars['pc'] + $bullpen_h->vars['pc']."\t "; ?></td>           
  
  <? //Bullpen this season
   $bullpen_season_a = get_team_bullpen_season($game->vars["team_away"],$season['start'],$date); 
   $bullpen_season_h = get_team_bullpen_season($game->vars["team_home"],$season['start'],$date); 
  
  ?>
    <td name="bullpen_stadistics"  title="Bullpen IP This Season" class="table_td<? echo $style ?>" style="font-size:12px;" id="ip_a_season<? echo $game->vars["id"]?>"><? echo $bullpen_season_a["IP"] ?><? $line .= $bullpen_season_a["IP"]."\t "; ?></td>
    <td name="bullpen_stadistics" title="Bullpen PC This Season"  class="table_td<? echo $style ?>" style="font-size:12px;" id="pc_a_season<? echo $game->vars["id"]?>"><? echo $bullpen_season_a["PC"] ?><? $line .= $bullpen_season_a["PC"]."\t "; ?></td>
    <td name="bullpen_stadistics" title="Bullpen IP This Season"  class="table_td<? echo $style ?>" style="font-size:12px;" id="ip_h_season<? echo $game->vars["id"]?>"><? echo $bullpen_season_h["IP"] ?><? $line .= $bullpen_season_h["IP"]."\t "; ?></td>
    <td name="bullpen_stadistics" title="Bullpen PC This Season"  class="table_td<? echo $style ?>" style="font-size:12px;" id="pc_h_season<? echo $game->vars["id"]?>"><? echo $bullpen_season_h["PC"] ?><? $line .= $bullpen_season_h["PC"]."\t "; ?></td>    
  
    
     
  
  <?  // ten

 $ten_aa = get_baseball_scores_ten($game->vars["team_away"],"away",$date);
 $ten_ah = get_baseball_scores_ten($game->vars["team_away"],"home",$date);
 $ten_ha = get_baseball_scores_ten($game->vars["team_home"],"away",$date);
 $ten_hh = get_baseball_scores_ten($game->vars["team_home"],"home",$date);
  
 if ($ten_aa["lose_ten"] == "YES" || $ten_ah["lose_ten"] == "YES"){
   $ten_away = "Yes"	;
 }
 else{
   $ten_away = "No"	;	  
 }
	 
 if ($ten_ha["lose_ten"] == "YES" || $ten_hh["lose_ten"] == "YES"){
  $ten_home = "Yes"	;
 }
 else{
  $ten_home = "No"	;	  
 }	  
 
 ?>
    

      
 <td name="ten_stadistics" title="Team lose +10"  class="table_td<? echo $style ?>" style="font-size:12px;" id="ten_a_<? echo $game->vars["id"]?>"><? echo $ten_away ?><? $line .= $ten_away."\t "; ?></td>    
 <td name="ten_stadistics" title="Team lose +10" class="table_td<? echo $style ?>" style="font-size:12px;" id="ten_h_<? echo $game->vars["id"]?>"><? echo  $ten_home  ?><? $line .= $ten_home."\t "; ?></td>    
  
      <td name="lines_stadistics" title="Money Away" class="table_td<? echo $style ?>" style="font-size:12px;" id="money_a_<? echo $game->vars["id"]?>"><? echo $lines_game[$game->vars["away_rotation"]]->vars["away_money"] ?><? $line .= $lines_game[$game->vars["away_rotation"]]->vars["away_money"]."\t "; ?></td>  
      
       <td name="lines_stadistics" title="Money Home" class="table_td<? echo $style ?>" style="font-size:12px;" id="money_h_<? echo $game->vars["id"]?>"><? echo $lines_game[$game->vars["away_rotation"]]->vars["home_money"] ?><? $line .= $lines_game[$game->vars["away_rotation"]]->vars["home_money"]."\t "; ?></td>  

     <?
	    $over_game =  prepare_line($lines_game[$game->vars["away_rotation"]]->vars["away_total"]);
		$under_game = prepare_line($lines_game[$game->vars["away_rotation"]]->vars["home_total"]);  
	 ?>
     
      <td name="lines_stadistics" title="Total Over" class="table_td<? echo $style ?>" style="font-size:12px;" id="t_over_a_<? echo $game->vars["id"]?>"><?   echo $over_game["line"] ?><? $line .= $over_game["line"]."\t "; ?>
       </td> 
      
       <td name="lines_stadistics" title="Total Over Juice" class="table_td<? echo $style ?>" style="font-size:12px;" id="juice_o_<? echo $game->vars["id"]?>"><? echo $over_game["juice"] ?><? $line .= $over_game["juice"]."\t "; ?></td> 
     
      <td name="lines_stadistics" title="Total Under" class="table_td<? echo $style ?>" style="font-size:12px;" id="under_<? echo $game->vars["id"]?>" ><? echo $under_game["line"] ?><? $line .= $under_game["line"]."\t "; ?></td> 
      
             <td name="lines_stadistics" title="Total Under Juice" class="table_td<? echo $style ?>" style="font-size:12px;" id="juice_u_<? echo $game->vars["id"]?>"><? echo  $under_game["juice"] ?><? $line .= $under_game["juice"]."\t "; ?></td> 
             
             
      <?
	    $over_innings =  prepare_line($lines_innings[$game->vars["away_rotation"]]->vars["away_total"]);
		$under_innings = prepare_line($lines_innings[$game->vars["away_rotation"]]->vars["home_total"]);  
	    $money_innings_away = $lines_innings[$game->vars["away_rotation"]]->vars["away_money"];
        $money_innings_home = $lines_innings[$game->vars["away_rotation"]]->vars["home_money"];
	    //print_r($lines_innings[$game->vars["away_rotation"]]);
		//break;
	 ?>
      <td name="lines_stadistics" title="Money 1st 5 Innings Away" class="table_td<? echo $style ?>" style="font-size:12px;" id="t_over_ai_<? echo $game->vars["id"]?>"><?   echo $money_innings_away  ?><? $line .= $money_innings_away."\t "; ?>
       </td> 
       
        <td name="lines_stadistics" title="Money 1st 5 Innings Home" class="table_td<? echo $style ?>" style="font-size:12px;" id="t_over_ai_<? echo $game->vars["id"]?>"><?   echo $money_innings_home ?><? $line .= $money_innings_home."\t "; ?>
       </td> 
     
      <td name="lines_stadistics" title="Total 1st 5 Innings Over" class="table_td<? echo $style ?>" style="font-size:12px;" id="t_over_ai_<? echo $game->vars["id"]?>"><?   echo $over_innings["line"] ?><? $line .= $over_innings["line"]."\t "; ?>
       </td> 
      
       <td name="lines_stadistics" title="Total 1st 5 Innings Over Juice" class="table_td<? echo $style ?>" style="font-size:12px;" id="juice_oi_<? echo $game->vars["id"]?>"><? echo $over_innings["juice"] ?><? $line .= $over_innings["juice"]."\t "; ?></td> 
     
      <td name="lines_stadistics" title="Total 1st 5 Innings Under"  class="table_td<? echo $style ?>" style="font-size:12px;" id="under_i_<? echo $game->vars["id"]?>"><? echo $under_innings["line"] ?><? $line .= $under_innings["line"]."\t "; ?></td> 
      
          <td  name="lines_stadistics" title="Total 1st 5 Innings Under Juice" class="table_td<? echo $style ?>" style="font-size:12px;" id="juice_ui_<? echo $game->vars["id"]?>" ><? echo  $under_innings["juice"] ?><? $line .= $under_innings["juice"]."\t "; ?></td> 
<?
//Team Total lines
 $team_line_away = get_sbo_team_line($game->vars["team_away"],$date);
 $team_line_home = get_sbo_team_line($game->vars["team_home"],$date);

?>     
 <td name="lines_stadistics" title="Total Team Away Over" class="table_td<? echo $style ?>" style="font-size:12px;" id="team_a_o_<? echo $game->vars["id"]?>" ><? echo  $team_line_away["total_over"] ?><? $line .= $team_line_away["total_over"]."\t "; ?></td> 
 
  <td name="lines_stadistics" title="Total Team Away Over Juice" class="table_td<? echo $style ?>" style="font-size:12px;" id="team_a_oj_<? echo $game->vars["id"]?>" ><? echo  $team_line_away["over_odds"] ?><? $line .= $team_line_away["over_odds"]."\t "; ?></td> 

 <td name="lines_stadistics" title="Total Team Away Under" class="table_td<? echo $style ?>" style="font-size:12px;" id="team_a_u_<? echo $game->vars["id"]?>"><? echo  $team_line_away["total_under"] ?><? $line .= $team_line_away["total_under"]."\t "; ?></td>         
 
 <td name="lines_stadistics" title="Total Team Away Under Juice" class="table_td<? echo $style ?>" style="font-size:12px;" id="team_a_uj_<? echo $game->vars["id"]?>"><? echo  $team_line_away["under_odds"] ?><? $line .= $team_line_away["under_odds"]."\t "; ?></td> 
 
  <td name="lines_stadistics" title="Total Team Home Over" class="table_td<? echo $style ?>" style="font-size:12px;" id="team_h_o_<? echo $game->vars["id"]?>"><? echo  $team_line_home["total_over"] ?><? $line .= $team_line_home["total_over"]."\t "; ?></td> 
 
  <td name="lines_stadistics" title="Total Team Home Over Juice" class="table_td<? echo $style ?>" style="font-size:12px;" id="team_h_oj_<? echo $game->vars["id"]?>"><? echo  $team_line_home["over_odds"] ?><? $line .= $team_line_home["over_odds"]."\t "; ?></td> 

 <td name="lines_stadistics" title="Total Team Home Under" class="table_td<? echo $style ?>" style="font-size:12px;" id="team_h_u_<? echo $game->vars["id"]?>"><? echo  $team_line_home["total_under"] ?><? $line .= $team_line_home["total_under"]."\t "; ?></td>         
 
 <td name="lines_stadistics" title="Total Team Home Under Juice" class="table_td<? echo $style ?>" style="font-size:12px;" id="team_h_uj_<? echo $game->vars["id"]?>"><? echo  $team_line_home["under_odds"] ?><? $line .= $team_line_home["under_odds"]."\t "; ?></td> 
 
 
     
</tr>  
<?
 $line = str_replace(str_split($charlist), ' ', $line);
 //$line = preg_replace("/\t/", "\\t", $line);
 $line = preg_replace("/\r?\n/", "\\n", $line);
 $report_line .= $line."\n ";
 ?>

 <? // if($i == 500 ){break;}?>
<? } ?>
   
 <tr>
  <td class="table_last" colspan="1000"></td>
  </tr>
  </tbody>
</table>


<? } ?>        
</div>

<?

 //$line = str_replace(str_split($charlist), ' ', $line);
// $report_line .= $line."\n ";
 ?>
<form method="post" action="../process/actions/excel.php" id="xml_form">
<input name="name" type="hidden" id="name" value="<? echo $stadium->vars["name"]?>_<? echo $year ?>">
<input name="content" type="hidden" id="content" value="<? echo $report_line ?>">
</form>

 


</body>
<? include "../../includes/footer.php" ?>
<? } else { echo "ACCESS DENIED"; }

?>

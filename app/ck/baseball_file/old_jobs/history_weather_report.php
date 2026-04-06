<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../../../css/style.css" rel="stylesheet" type="text/css" />
<title>Test Baseball</title>
<link rel="stylesheet" type="text/css" media="all" href="../../../includes/calendar/jsDatePick_ltr.min.css" />
<link rel="stylesheet" href="<?= BASE_URL ?>/includes/shadowbox/shadowbox.css" type="text/css" media="screen" />
<script type="text/javascript" src="<?= BASE_URL ?>/includes/shadowbox/shadowbox.js"></script>
<script type="text/javascript">
Shadowbox.init();
</script>
<script type="text/javascript" src="../../../includes/calendar/jsDatePick.min.1.3.js"></script>
<script type="text/javascript">
	window.onload = function(){
		new JsDatePick({
			useMode:2,
			target:"from",
			dateFormat:"%Y-%m-%d"
		});
		new JsDatePick({
			useMode:2,
			target:"to",
			dateFormat:"%Y-%m-%d"
		});
	};
</script>
</head>
<body>
<? $page_style = " width:100%;"; ?>
<? include "../../../includes/header.php"  ?>
<? include "../../../includes/menu_ck.php"  ?>


<div class="page_content" style="padding-left:10px;">
<span class="page_title">Baseball Games</span><br /><br />

<? 
//Post params
$from = clean_get("from");
if($from == ""){$from = date("Y-m-d");}
?>

<form method="post">
    Date: 
    <input name="from" type="text" id="from" value="<? echo $from ?>" />
 
    &nbsp;&nbsp;&nbsp;&nbsp;
   <input type="submit" value="Search" />
    &nbsp;&nbsp;&nbsp;&nbsp;
    <br /><br />

</form>
<span style="font-size:11px;">
    <strong>TMP: </strong>Temp in °F, 
    <strong>HM: </strong> % of Humidity, 
    <strong>WS: </strong>Wind Speed (mph),
    <strong>WD: </strong>Wind Direct, 
    <strong>WP </strong>Wind Position,  
    <strong>WG: </strong>Wind Gust (mph),     
    <strong>AirP: </strong>Pressure (in), 
    <strong>DewP: </strong>Dewpoint (°F), 
</span>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td class="table_header">Date</td>
    <td class="table_header">Hour</td>
    <td class="table_header">Away</td>
    <td class="table_header">Home</td>
    <td class="table_header">TMP</td>
    <td class="table_header">Condition</td>
    <td class="table_header">HM</td>
    <td class="table_header">WS</td>
    <td class="table_header">WD</td>
    <td class="table_header">WP</td>
    <td class="table_header">WG</td>
    <td class="table_header">AirP</td>
    <td class="table_header">DewP</td>
    <td class="table_header">History</td>
  </tr>

<?
$columns = get_baseball_games_by_date($from);
$game = new _baseball_game();
$constants = get_baseball_constants();

 foreach($columns as $col){
    
    if($i % 2){$style = "1";}else{$style = "2";} $i++;
	
	$day= date('M-d',strtotime($col->vars["startdate"]));
	$hour= date('H:i',strtotime($col->vars["startdate"]));
	$weather=get_baseball_game_weather($col->vars["id"],$col->vars["startdate"]) ;
	//$stadium = get_baseball_stadium_by_team($col->vars["team_home"]);
	//$stadium_position = get_baseball_stadium_position($weather->vars["wind_direction"],$stadium->vars["id"]);
	//$adjustment_factors = get_adjustment_factors($stadium_position['id']);  
    //$pk=$game->get_pk($weather,$stadium,$adjustment_factors,$constants);
    ?> 
    
    <tr>
      <td class="table_td<? echo $style ?>" style="font-size:12px;"><? echo $day ?></td>
      <td class="table_td<? echo $style ?>" style="font-size:12px;"><? echo $hour ?></td>     
      <td class="table_td<? echo $style ?>" style="font-size:12px;">
      <? echo $col->vars["away"]?>
      </td>
      <td class="table_td<? echo $style ?>" style="font-size:12px;">
      <? echo $col->vars["home"]?>
      </td>
      <td class="table_td<? echo $style ?>" style="font-size:12px;"><? echo $weather->vars["temp"] ?></td> 
      <td class="table_td<? echo $style ?>" style="font-size:12px;"><? echo $weather->vars["condition"] ?><BR>
      <img src="<? echo $weather->vars["img_url"] ?>">
      </td> 
      <td class="table_td<? echo $style ?>" style="font-size:12px;"><? echo $weather->vars["humidity"] ?></td> 
      <td class="table_td<? echo $style ?>" style="font-size:12px;"><? echo $weather->vars["wind_speed"] ?></td> 
      <td class="table_td<? echo $style ?>" style="font-size:12px;"><? echo $weather->vars["wind_direction"] ?></td> 
      <td class="table_td<? echo $style ?>" style="font-size:12px;"><? echo $stadium_position["position"] ?></td> 
      <td class="table_td<? echo $style ?>" style="font-size:12px;"><? echo $weather->vars["wind_gust"] ?></td> 
      <td class="table_td<? echo $style ?>" style="font-size:12px;"><? echo $weather->vars["air_pressure"] ?></td> 
      <td class="table_td<? echo $style ?>" style="font-size:12px;"><? echo $weather->vars["dewpoint"] ?></td> 
      <td class="table_td<? echo $style ?>" style="font-size:12px;"><a href="<?= BASE_URL ?>/ck/baseball_file/old_jobs/history_weather_action.php?thome=<? echo $col->vars["team_home"] ?>&gid=<? echo $col->vars["id"] ?>&gdate=<? echo $col->vars["startdate"]?>" class= "normal_link"  target="_blank">Update from Hystory </a>
     </tr>
   <? }?> 

    <tr>
      <td class="table_header"></td>
      <td class="table_header"></td>
      <td class="table_header"></td>
      <td class="table_header"></td>
      <td class="table_header"></td>
      <td class="table_header"></td>
      <td class="table_header"></td>
      <td class="table_header"></td>
      <td class="table_header"></td>
      <td class="table_header"></td>
      <td class="table_header"></td>
      <td class="table_header"></td>
      <td class="table_header"></td>
      <td class="table_header"></td>
      </tr>
    <tr>
      <td class="table_last" colspan="100"></td>
    </tr>
</table>
</div>
</body>
<? include "../../../includes/footer.php" ?>

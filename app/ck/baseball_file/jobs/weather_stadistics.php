<? require_once(ROOT_PATH . "/ck/db/handler.php"); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../../../css/style.css" rel="stylesheet" type="text/css" />
<title>Baseball File</title>
<link rel="stylesheet" type="text/css" media="all" href="../../../includes/calendar/jsDatePick_ltr.min.css" />
<link rel="stylesheet" href="<?= BASE_URL ?>/includes/shadowbox/shadowbox.css" type="text/css" media="screen" />
<? 


//Post params
if (isset($_GET["date"])){
$yesterday = $_GET["date"];

}else {
$yesterday = date( "Y-m-d", strtotime( "-1 day", strtotime(date( "Y-m-d")))); 

}

if($yesterday == ""){$yesterday = date("Y-m-d");}
$year = date('Y',strtotime($yesterday));
$date=  date('Y-m-d',strtotime($yesterday));
$games = get_baseball_games_by_date($yesterday);
$season =  get_baseball_season($year);


if ($season['start'] > $date){
$preseason = true;
}


?>

<script type="text/javascript" src="<?= BASE_URL ?>/process/js/functions.js"> </script>
<script type="text/javascript" src="js/functions.js"> </script>
<script type="text/javascript" src="<?= BASE_URL ?>/includes/shadowbox/shadowbox.js"></script>
<script type="text/javascript">
Shadowbox.init();
</script>
<script type="text/javascript" src="../../includes/calendar/jsDatePick.min.1.3.js"></script>
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


<div class="page_content" style="padding-left:10px;">
<span class="page_title">Baseball Games on <? echo $yesterday  ?></span><br /><br />



<?
if ($preseason){ ?>
<span style="font-size:14px;">
    <strong>Preseason</strong>
</span>	
<br /><br />	
<? }
?>



<?

$manual_wind = get_all_baseball_stadium_position();
$constants = get_baseball_constants();
echo"<pre>";
//echo $constants[7]["value"];
//print_r($manual_wind);
echo"</pre>";
$constants = get_baseball_constants();
?>

<table id="baseball" width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td  name ="game_info_" width="120" class="table_header">Away
    <td width="120" class="table_header">Home</td>            
    <td name="weather_stadistics" width="120" class="table_header">TMP</td>
    <td name="weather_stadistics" width="120" class="table_header">HM</td>
    <td name="weather_stadistics" width="120" class="table_header">WS</td>
    <td name="weather_stadistics" width="120" class="table_header">WG</td>
    <td name="weather_stadistics" width="120" class="table_header">AirP</td>
    <td name="weather_stadistics" width="120" class="table_header">DewP</td>
    <td name="weather_stadistics" width="120" class="table_header">PK</td>
    <td name="weather_stadistics" width="120" class="table_header">DryA</td>
    <td name="weather_stadistics" width="120" class="table_header">VapourP</td>  
    <td name="weather_stadistics" width="120" class="table_header">MoistA</td>          
  </tr>
  
 
 
<?

 foreach($games as $game){
    
	
    if($i % 2){$style = "1";}else{$style = "2";} $i++;
	
 	
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
	 $aird = $game->get_aird ($game->get_kelvin_temp($weather->vars["temp"]),$weather->vars["air_pressure"],$water_vapour); 
	
	
	
	
	$weather_style = "";
	$orweather_style = "";
	if ($pk <= -15) {$weather_style = "_red";}
	else if ($pk >= 15) {$weather_style = "_green";}
	$orweather_style = $weather_style;
	
	if ($weather->vars["wind_direction"] == 'Variable' ){$weather_style = "_gray";} 
	
	if ($stadium->vars["has_roof"] == 2 || !$game->vars["roof_open"]) {$weather_style = "_gray";} 
	  	
	?> 
    <tr>
              
      <td  name ="game_info_" id="game_info_<? echo $game->vars["id"]?>" class="table_td<? echo $style ?>" style="font-size:12px;">
      	<? echo "(".$game->vars["away_rotation"].") ".$game->vars["away"] ?>
      </td>
      
      <td   id="game_info_<? echo $game->vars["id"]?>" class="table_td<? echo $style ?>" style="font-size:12px;">
      	<? echo "(".$game->vars["home_rotation"].") ".$game->vars["home"]?>
      </td>
      
      
     
 <? //weather  ?>    
   
           
      <td name="weather_stadistics" class="table_td<? echo $style.$weather_style ?>" style="font-size:12px;" id="t<? echo $game->vars["id"]?>"><? echo $weather->vars["temp"] ?></td> 
      
       
      <td name="weather_stadistics" class="table_td<? echo $style.$weather_style ?>" style="font-size:12px;" id="h<? echo $game->vars["id"]?>">
	  	<? echo $weather->vars["humidity"] ?>
      </td> 
      
      <td name="weather_stadistics" class="table_td<? echo $style.$weather_style ?>" style="font-size:12px;" id="ws<? echo $game->vars["id"]?>">
	  	<? echo $weather->vars["wind_speed"] ?>
      </td> 
           
     
     
     <td name="weather_stadistics" class="table_td<? echo $style.$weather_style ?>" style="font-size:12px;" id="wg<? echo $game->vars["id"]?>">
	 	<? echo $weather->vars["wind_gust"]?>
     </td> 
     
     <td name="weather_stadistics" class="table_td<? echo $style.$weather_style ?>" style="font-size:12px;" id="ai<? echo $game->vars["id"]?>">
	 	<? echo $weather->vars["air_pressure"]?>
     </td>
     
     <td name="weather_stadistics"  class="table_td<? echo $style.$weather_style ?>" style="font-size:12px;" id="dw<? echo $game->vars["id"]?>">
	 	<? echo $weather->vars["dewpoint"] ?>
     </td> 
     
     <td name="weather_stadistics" class="table_td<? echo $style.$weather_style ?>" style="font-size:12px;" id="pk<? echo $game->vars["id"]?>">
	 	<? echo $pk ?>
     </td> 
     
    <td name="weather_stadistics" class="table_td<? echo $style.$weather_style ?>" style="font-size:12px;" id="air_d<? echo $game->vars["id"]?>">
	 	<? echo $air_density ?>
     </td> 
     
        <td name="weather_stadistics" class="table_td<? echo $style.$weather_style ?>" style="font-size:12px;" id="wat_v<? echo $game->vars["id"]?>">
	 	<? echo $water_vapour ?>
     </td> 
     
        <td name="weather_stadistics" class="table_td<? echo $style.$weather_style ?>" style="font-size:12px;" id="air_m<? echo $game->vars["id"]?>">
	 	<? echo $moist_air_density ?>
     </td> 
  
     
    </tr>  

 <?
  
  if (!is_null($weather->vars["temp"])){
 
   if ($weather->vars["temp"] != '0.00'){
     $game->vars["pk"]= $pk;
     $game->vars["dry_air"]= $air_density;
     $game->vars["vapour_pressure"]=$water_vapour;
     $game->vars["moist_air"]= $moist_air_density;
	 $game->vars["aird"]= $aird;
   }
  // else {  $game->vars["pk"]= -99; }
 }
 else{
 //$game->vars["pk"]= -99;
 $game->vars["dry_air"]= 0;
 $game->vars["vapour_pressure"]=0;
 $game->vars["moist_air"]= 0;	 
 }
  $game->update(array("pk","dry_air","vapour_pressure","moist_air"));
 
 
 
 } 
    
   ?>
    <tr>
      <td class="table_last" colspan="1000"></td>
    </tr>
</table>

</div>
</body>



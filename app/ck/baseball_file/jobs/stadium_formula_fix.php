<? require_once(ROOT_PATH . "/ck/db/handler.php"); ?>
<?  require_once(ROOT_PATH . '/ck/baseball_file/process/functions.php');	?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../../../css/style.css" rel="stylesheet" type="text/css" />
<title>Baseball File</title>
<link rel="stylesheet" type="text/css" media="all" href="../../../includes/calendar/jsDatePick_ltr.min.css" />
<link rel="stylesheet" href="http://localhost:8080/includes/shadowbox/shadowbox.css" type="text/css" media="screen" />
<? 


//Post params
$file = fopen("./ck/baseball_file/old_jobs/date.txt", "r") or exit("Unable to open file!");
while(!feof($file))
{
$date =  ltrim(fgets($file));
}
fclose($file);



$games = get_baseball_games_by_date($date);
$season =  get_baseball_season($year);


if ($season['start'] > $date){
$preseason = true;
}


//$page = $_SERVER['PHP_SELF'];
//$sec = "3";
?>
    <meta http-equiv="refresh" content="<?php echo $sec?>;URL="<? echo $page  ?>"">
  

</head>
<body>


<div class="page_content" style="padding-left:10px;">
<span class="page_title">Baseball Games on <? echo $date  ?></span><br /><br />



<?
if ($preseason){ ?>
<span style="font-size:14px;">
    <strong>Preseason</strong>
</span>	
<br /><br />	
<? }
?>



<?
//Stadium Formula Data;
$std_formula = get_all_stadium_formula_data();
  


echo"<pre>";
//echo $constants[7]["value"];
//print_r($manual_wind);
echo"</pre>";

?>

<table id="baseball" width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td  name ="game_info_" width="120" class="table_header">Away
    <td width="120" class="table_header">Home</td>            
    <td name="weather_stadistics" width="120" class="table_header">PK</td>
    <td name="weather_stadistics" width="120" class="table_header">AirP</td>
    <td name="weather_stadistics" width="120" class="table_header">PK ADJ</td>
    <td name="weather_stadistics" width="120" class="table_header">AIRP ADJ</td>
    <td name="weather_stadistics" width="120" class="table_header">TOTAL ADJ</td>  
  
  </tr>
  
 
 
<?

 foreach($games as $game){
    
	
    if($i % 2){$style = "1";}else{$style = "2";} $i++;
	
 	
	//Weather formulas
	$weather=get_baseball_game_weather($game->vars["id"],$game->vars["startdate"]) ;
	$stadium = get_baseball_stadium_by_team($game->vars["team_home"]);
	
	
	if($game->vars["pk"] == -98){
	
    	if (!is_null($weather->vars["temp"])){
  	
		// pk
		 $game->vars["pk"]=$game->get_pk($weather,$stadium,$adjustment_factors,$constants);
   		 }else { $game->vars["pk"] = "0";}
	
	}
	
	
	// Air Density
 	 
	
	
	  $data_stadium = @stadium_data_formula($game->vars["pk"],$weather->vars["air_pressure"],$std_formula[$stadium->vars["id"]]);
	  	
	?> 
    <tr>
              
      <td  name ="game_info_" id="game_info_<? echo $game->vars["id"]?>" class="table_td<? echo $style ?>" style="font-size:12px;">
      	<? echo "(".$game->vars["away_rotation"].") ".$game->vars["away"] ?>
      </td>
      
      <td   id="game_info_<? echo $game->vars["id"]?>" class="table_td<? echo $style ?>" style="font-size:12px;">
      	<? echo "(".$game->vars["home_rotation"].") ".$game->vars["home"]?>
      </td>
      
      
     
 <? //weather  ?>    
   
       <td name="weather_stadistics" class="table_td<? echo $style.$weather_style ?>" style="font-size:12px;" id="ai<? echo $game->vars["id"]?>">
	 	<? echo $game->vars["pk"] ?>
     </td> 
   
        
       <td name="weather_stadistics" class="table_td<? echo $style.$weather_style ?>" style="font-size:12px;" id="ai<? echo $game->vars["id"]?>">
	 	<? echo $weather->vars["air_pressure"]?>
     </td>
          
      <td name="weather_stadistics" class="table_td<? echo $style.$weather_style ?>" style="font-size:12px;" id="t<? echo $game->vars["id"]?>"><? echo $data_stadium["pk"] ?></td> 
      
       
      <td name="weather_stadistics" class="table_td<? echo $style.$weather_style ?>" style="font-size:12px;" id="h<? echo $game->vars["id"]?>">
	  	<? echo $data_stadium["airp"] ?>
      </td> 
      
      <td name="weather_stadistics" class="table_td<? echo $style.$weather_style ?>" style="font-size:12px;" id="ws<? echo $game->vars["id"]?>">
	  	<? echo $data_stadium["total"] ?>
      </td> 
           
     
     
  
     
    </tr>  

 <?
  
  if (!is_null($weather->vars["temp"])){
 
   if ($weather->vars["temp"] != '0.00'){
  
     $game->vars["pk_adj"]= $data_stadium["pk"];
     $game->vars["airp_adj"]=$data_stadium["airp"];
     $game->vars["total_adj"]= $data_stadium["total"];
     $game->update(array("pk","pk_adj","airp_adj","total_adj"));
	// echo "<BR>DATA UPDATED<BR>";
   }
 
  }

 
 
 
 } 

 $date = date( "Y-m-d", strtotime( "-1 day", strtotime($date))); 
 
  $fp = fopen('./ck/baseball_file/old_jobs/date.txt', 'w');
  fwrite($fp, $date);
  fclose($fp);
		
    
   ?>
    <tr>
      <td class="table_last" colspan="1000"></td>
    </tr>
</table>

</div>
</body>



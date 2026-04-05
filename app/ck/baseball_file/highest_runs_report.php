<? include(ROOT_PATH . "/ck/process/security.php"); 
if($current_clerk->im_allow("baseball_file")){
  require_once(ROOT_PATH . '/ck/baseball_file/process/functions.php');		
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../../css/style.css" rel="stylesheet" type="text/css" />
<title>Baseball Report</title>
<link rel="stylesheet" type="text/css" media="all" href="../../includes/calendar/jsDatePick_ltr.min.css" />
<link rel="stylesheet" href="http://localhost:8080/includes/shadowbox/shadowbox.css" type="text/css" media="screen" />

<script type="text/javascript" src="http://localhost:8080/process/js/functions.js"> </script>
<script type="text/javascript" src="js/functions.js"> </script>
<script type="text/javascript" src="http://localhost:8080/includes/shadowbox/shadowbox.js"></script>
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
<script type="text/javascript">
var validations = new Array();
validations.push({id:"runs",type:"numeric", msg:"Please use only Numbers"});
</script>

</head>
<body>
<? $page_style = " width:1400px;"; ?>
<? include "../../includes/header.php"  ?>
<? include "../../includes/menu_ck.php"  ?>

<? 

$from = clean_get("from");
$to =  clean_get("to");
if($from == ""){
  $year = date("Y"); 
 }
 else{
 $year = date('Y',strtotime($from));	 
 }

$season =  get_baseball_season($year);

if($from == ""){ 
  $from = $season['start'];
   if ($season['season'] == date('Y')) {
	$to = date( "Y-m-d", strtotime( "-1 day", strtotime(date( "Y-m-d")))); 
   }
   else {$to = $season['end'] ; }
}

$stadiums = get_all_baseball_stadiums();


$charlist = "\n\0\x0B";
$line = "";
$report_line ="Date\tAway\tHome\tUmpire\tPitcher A\tPitcher H\tPK\tTemp\tCondition\tHumidity\tDry Air\tVap Presure\tMoist Air\tWind Direction\tWind Speed\tWind Degree\tDewpoint\tTotalRuns\tTotalLine\t\\n";


?>

<div class="page_content" style="padding-left:10px;">
<div align="right"><span ><a href="./baseball_reports.php">Back to Reports</a></span></div>
<span class="page_title">Highest Runs Report
</span><br /><br />

<table >
<tr>
 <td >
<form method="post" onsubmit="return validate(validations)">
    <BR/> 
    From: 
    <input name="from" type="text" id="from" value="<? echo $from ?>" />
    To: 
    <input name="to" type="text" id="to" value="<? echo $to ?>" /> 
    <BR/> <BR/>  
    Cant Runs: &nbsp;&nbsp; <input name="runs" type="text" id="runs" value="<? echo $_POST["runs"] ?>" style="width:40px"  /> 
   
    &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;
   <input type="submit" value="Search" />
 </td>
 <td>
   <table style="font-size:9pt;font-family:Helvetica" border="0" >
   <tr >Stadiums :</tr>
   <?
     $j =1;
	 $row=1;
	 $str_stadiums = "";
	 foreach ($stadiums as $stadium){
    ?> 
     <? if ($row == 1) { ?>
      <tr>
     <? } ?> 
       <td >
        <input  type="checkbox"  onmouseover="javascript:showtooltip('stadium_<? echo $j ?>','<? echo $stadium->vars["team_name"]?>')" 
        <?
		 
		 if (isset($_POST["stadium_".$j])) { echo 'checked="checked"';} 
		 if ((!isset($_POST["runs"])) )  {
			  echo 'checked="checked"';
			  //echo ' id="stadium_'.$j.'"';
  		      $str_stadiums .=  $stadium->vars["team_id"].", ";
		  } 
		  else{
		      if (isset($_POST["stadium_".$j])){
			   $str_stadiums .=  $stadium->vars["team_id"].", ";	  
		      
			  }
			  
		  }
  	     echo ' id="stadium_'.$j.'"';
		
		?>
         name="stadium_<? echo $j?>"   value="<? echo $stadium->vars["team_id"] ?>" >
         &nbsp;&nbsp;<? echo $stadium->vars["name"] ?> 
       </td>
      <? if ($row == 3){ ?>
         </tr>
        <? $row = 0;
	    }
	 $row++;
	 $j++;
	 }
	 $str_stadiums =   substr($str_stadiums,0,-2); ?>
	 </tr>
     </table>
     <div id="uncheck" >      
      <a id="uncheck" href="javascript:unckeck_all('stadium_',<? echo count($stadiums)?>)" style="font-size:9pt;font-family:Helvetica" class="normal_link">Uncheck all</a> 
     </div>  
     <div id="check" style="display:none" >
      <a  href="javascript:ckeck_all('stadium_',<? echo count($stadiums)?>)" style="font-size:9pt;font-family:Helvetica" class="normal_link" >Check all</a> 
      </div> 
</td>
</form>
</tr>
</table>
  &nbsp;&nbsp;&nbsp;&nbsp;<a href="javascript:;" onclick="document.getElementById('xml_form').submit();" class="normal_link">
	Export
	</a>
<BR />

<? if (isset($_POST["runs"])){
 
     if ($str_stadiums == ""){?>
		<script>   
          alert("Please select almost 1 stadium");
        </script>   
   <? }
     else {
	     
	   $games = get_baseball_highest_runs($from,$to,$_POST["runs"],$str_stadiums);
	   $show_table = true;
	  if (empty($games)){
		echo "<font color='#CC0000'>There are not games with the Selected Conditions</font><BR><BR>";  
	    $show_table = false;
	  }
	  
	  if ($show_table) {
	  
		?>
		<table id="baseball" width="100%" border="0" cellspacing="0" cellpadding="0">
		  <tr>
			<td width="120"  class="table_header" >Date</td>
			<td  name ="game_info_" width="120"  class="table_header">Away</td>
			<td  name ="game_info_" width="120"  class="table_header">Home</td>
            <td  name ="game_info_" width="120"  class="table_header">Umpire</td>
			<td  name ="game_info_" width="120"  class="table_header">Pitcher A</td>
            <td  name ="game_info_" width="120"  class="table_header">Pitcher H</td>
            <td  name ="game_info_" width="60"  class="table_header">PK</td>
            <td  name ="game_info_" width="60"  class="table_header">Temp</td>
            <td  name ="game_info_" width="60"  class="table_header">Condition</td>
            <td  name ="game_info_" width="60"  class="table_header">Humidity</td>
            <td  name ="game_info_" width="60"  class="table_header">Dry Air</td>
            <td  name ="game_info_" width="60"  class="table_header">Vap Pres</td>                                    
            <td  name ="game_info_" width="60"  class="table_header">Moist Air</td>            
            <td  name ="game_info_" width="60"  class="table_header">WIND Direc</td>            
            <td  name ="game_info_" width="60"  class="table_header">WIND speed</td>
            <td  name ="game_info_" width="60"  class="table_header">WIND Degree</td>                                    
            <td  name ="game_info_" width="60"  class="table_header">Dewpoint</td>            
			<td  name ="game_info_" width="60" class="table_header">Total Runs</td>
			<td  name ="game_info_" width="60" class="table_header">Total Line</td>
			<td  name ="game_info_" width="60" class="table_header">Espn</td>
		 </tr>  
		
		  <? foreach ($games as $game) { 

		      //echo "<pre>";
		     // print_r($game);
			  $line = ""; 
			  $day= date('M-d',strtotime($game->vars["startdate"]));
			  $hour= date('H:i',strtotime($game->vars["startdate"]));
			  $game_year = date('Y',strtotime($game->vars["startdate"]));
			  $date = date('Y-m-d',strtotime($game->vars["startdate"]));
			  $team_away = get_baseball_team($game->vars["team_away"]);
			  $team_home = get_baseball_team($game->vars["team_home"]);
			  $umpire = get_umpire_name_by_id($game->vars["umpire"]);	
			  $pitcher_away = get_player_pitches_by_game_simple($game->vars["id"],$game->vars["pitcher_away"],"away");
			  $pitcher_home = get_player_pitches_by_game_simple($game->vars["id"],$game->vars["pitcher_home"],"home");	
              $p_away = str_replace("'","", $pitcher_away->vars["player"]);
			  $p_home = str_replace("'","", $pitcher_home->vars["player"]);
            
					  
			  $weather = get_baseball_game_weather($game->vars["id"],$game->vars["startdate"]);
			 			  
			  if($i % 2){$style = "1";}else{$style = "2";} $i++;
			  ?>
			  <tr>
			  <td class="table_td<? echo $style ?>" style="font-size:12px;"><? echo $day."-".substr($game_year,2,2)."  at   ".$hour ?><? $line .= $day."-".substr($game_year,2,2)."  at   ".$hour."\t "; ?></td> 
			  <td class="table_td<? echo $style ?>" style="font-size:12px;"><? echo $team_away->vars["team_name"] ?><? $line .= $team_away->vars["team_name"]."\t "; ?></td> 
	        <td class="table_td<? echo $style ?>" style="font-size:12px;"><? echo $team_home->vars["team_name"] ?><? $line .= $team_home->vars["team_name"]."\t "; ?></td> 
             <td class="table_td<? echo $style ?>" style="font-size:12px;"><? echo $umpire["full_name"] ?><? $line .= $umpire["full_name"]." \t "; ?></td> 
             <td class="table_td<? echo $style ?>" style="font-size:12px;"><? echo $pitcher_away->vars["player"] ?><? $line .=  "a".$p_away." \t "; ?></td> 
             <td class="table_td<? echo $style ?>" style="font-size:12px;"><? echo $pitcher_home->vars["player"] ?><? $line .=  "a ".$p_home." \t "; ?></td> 
     		 <td class="table_td<? echo $style ?>" style="font-size:12px;"><? echo $game->vars["pk"] ?><? $line .= $game->vars["pk"]."\t "; ?></td> 
			 <td class="table_td<? echo $style ?>" style="font-size:12px;"><? echo $weather->vars["temp"] ?><? $line .= $weather->vars["temp"]." \t "; ?></td>
     		 <td class="table_td<? echo $style ?>" style="font-size:12px;"><? echo $weather->vars["condition"] ?><? $line .= $weather->vars["condition"]."\t "; ?></td> 
			 <td class="table_td<? echo $style ?>" style="font-size:12px;"><? echo $weather->vars["humidity"] ?><? $line .= $weather->vars["humidity"]."\t "; ?></td>             
     		 <td class="table_td<? echo $style ?>" style="font-size:12px;"><? echo $game->vars["dry_air"] ?><? $line .= $game->vars["dry_air"]."\t "; ?></td> 
			 <td class="table_td<? echo $style ?>" style="font-size:12px;"><? echo $game->vars["vapour_pressure"] ?><? $line .= $game->vars["vapour_pressure"]."\t "; ?></td>             
     		 <td class="table_td<? echo $style ?>" style="font-size:12px;"><? echo $game->vars["moist_air"] ?><? $line .= $game->vars["moist_air"]."\t "; ?></td> 
			 <td class="table_td<? echo $style ?>" style="font-size:12px;"><? echo $weather->vars["wind_direction"] ?><? $line .= $weather->vars["wind_direction"]."\t "; ?></td>             
     		 <td class="table_td<? echo $style ?>" style="font-size:12px;"><? echo $weather->vars["wind_speed"] ?><? $line .= $weather->vars["wind_speed"]."\t "; ?></td> 
			 <td class="table_td<? echo $style ?>" style="font-size:12px;"><? echo $weather->vars["wind_degrees"] ?><? $line .= $weather->vars["wind_degrees"]."\t "; ?></td>             
     		 <td class="table_td<? echo $style ?>" style="font-size:12px;"><? echo $weather->vars["dewpoint"] ?><? $line .= $weather->vars["dewpoint"] ."\t "; ?></td> 
            
                          
			 <td class="table_td<? echo $style ?>" style="font-size:12px;"><? echo $game->vars["score"] ?><? $line .=  $game->vars["score"]."\t "; ?></td> 
			 <td class="table_td<? echo $style ?>" style="font-size:12px;"><? echo $game->vars["line"]['away_total'] ?><? $line .=  $game->vars["line"]['away_total']."\t "; ?></td> 
			 <td   class="table_td<? echo $style ?>" style="font-size:12px;" id="espn_<? echo $game->vars["id"]?>"><a href="http://scores.espn.go.com/mlb/boxscore?gameId=<? echo $game->vars["espn_game"] ?>" class="normal_link" target="_blank">Box Score
</td>  
			 
			  <?
			
			$line = preg_replace("/[\r\n|\n|\r]+/", PHP_EOL, $line); 	 
			 $line = str_replace(str_split($charlist), ' ', $line);
 			 $line = preg_replace("/\r?\n/", "\\n", $line);
 			  $report_line .= $line."\n ";


 ?>
 			<? } ?>
		
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
     <? } ?>
   <? } ?>
<? } ?>
</div>
<form method="post" action="../process/actions/excel.php" id="xml_form">
<input name="name" type="hidden" id="name" value="Highest Runs Report_<? echo $_POST["runs"] ?>_Runs">
<input name="content" type="hidden" id="content" value="<? echo $report_line ?>">
</form>

</body>
<? include "../../includes/footer.php" ?>
<? } else { echo "ACCESS DENIED"; }



?>


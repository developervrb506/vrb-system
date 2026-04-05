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
function hide_link(id,id2){

  if(document.getElementById(id).style.display == "none"){
	 document.getElementById(id).style.display = "block";
	 document.getElementById(id2).style.display = "none";
	 document.getElementById(id+'_div').style.display = "none";
	 document.getElementById(id2+'_div').style.display = "block";
	 document.getElementById('hide').value = "dates";
  } else if(document.getElementById(id).style.display == "block"){
	 document.getElementById(id).style.display = "none";
	 document.getElementById(id2).style.display = "block";
	 document.getElementById(id+'_div').style.display = "block";
	 document.getElementById(id2+'_div').style.display = "none";
	 document.getElementById('hide').value = "season";
  }

}
</script>

</head>
<body>

<? include "../../includes/header.php"  ?>
<? include "../../includes/menu_ck.php"  ?>

<? 
$season_year = substr($_POST['year'],0,-2);
$control= true;
$from = clean_get("from");
$to =  clean_get("to");
$dates=false;

if($from != "" && $to != ""){

   $year = date('Y',strtotime($from));
   if ($_POST["hide"] != "season"){ $season_year = $year;}    
   $dates = true;
  
}
else{
 
  if (isset($_POST['year'])){
	 $year = $season_year;
	 $_POST["from"]="";	 		
   }
   else{
   $year = date('Y');	 	
   }
}

if ($_POST["hide"] == "season"){ $year = $season_year; $dates=false;}

$season =  get_baseball_season($year);
$all_seasons = get_all_baseball_seasons();

   
if (!$dates){
   $from = $season['start'];
   if ($season['season'] == date('Y')) {
   $to = date( "Y-m-d", strtotime( "-1 day", strtotime(date( "Y-m-d")))); 
   $from = "2013-07-29";
   }
   else {
	   $to = $season['end'] ; 
    }
  }


?>
<div class="page_content" style="padding-left:10px;">
<div align="right"><span ><a href="./baseball_reports.php">Back to Reports</a></span></div>
<span class="page_title">Team Lose Report
</span><br /><br />

<table >
<tr>
 <td>
<form method="post" onsubmit="return validate(validations)">
<input name="hide" type="hidden" id="hide" value="x" /> 
    <a  id="by_season" href="javascript:hide_link('by_season','by_dates')" class="normal_link" title="Click to change the Date Search" style="display:block" >Search by Season</a> 	
    <a  id="by_dates" href="javascript:hide_link('by_season','by_dates')" class="normal_link" title="Click to change the Date Search"  style="display:none" >Search by Date</a> 	
  <BR/> 
  <div id="by_season_div"  style="display:none">
  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
  Season: 
   <select name="year" id="year" onchange="change_active_years(this.value,<? echo count($all_seasons)?>)" >
   <? $j=1; ?>
   <?  foreach ( $all_seasons as $_year){ ?> 
       
        <? if ($_year["season"] > 2010){ ?>
        <option value="<? echo $_year["season"] ?>_<? echo $j ?>" <? if ($season_year == $_year["season"]) { echo "selected"; } ?>><? echo $_year["season"] ?></option>
        <? $j++; } ?>
      
     <? } ?>
   </select>
   <BR/><BR/>  
   </div>  
   <div id="by_dates_div">
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
      From: 
      <input name="from" type="text" id="from" value="<? echo $from ?>" />
      To: 
      <input name="to" type="text" id="to" value="<? echo $to ?>" /> 
     <BR/> <BR/>  &nbsp;&nbsp &nbsp;&nbsp &nbsp;&nbsp &nbsp; 
   </div>
     &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
    Number Runs Lose the last game : &nbsp;&nbsp;  <select name="days" id="days">
       <option value="10" <? if ($_POST['days'] == '10') { echo "selected"; } ?>>+10</option>
       <option value="15" <? if ($_POST['days'] == '15') { echo "selected"; } ?>>+15</option>
     </select> 
  
     &nbsp;&nbsp;&nbsp;&nbsp;  
     <select name="condition" id="condition">
       <option value=">" <? if ($_POST['condition'] == '>') { echo "selected"; } ?>>Over</option>
       <option value="<" <? if ($_POST['condition'] == '<') { echo "selected"; } ?>>Under</option>
     </select>
   <BR><BR>
   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <input type="submit" value="Search" />
  </td>
 
 </form>
 </tr>
</table>
<BR />


<?
if ($_POST["hide"]=="season"){
	?>
	<script>	
      hide_link('by_season','by_dates');
    </script>
   <? } ?>

<? if (isset($_POST["days"])){

     if ($_POST['condition'] == '>'){
	     $higher = true;	 
	  }
	  else{
	     $higher = false;	 	 
	  }
	 $lines_game = get_sport_lines_by_dates($from,$to, 'MLB', 'Game');
	 $lines_team = get_sport_team_lines_by_dates($from,$to, 'MLB'); 
	 $error_message = true;
	 $games = get_baseball_games_lose_by_runs($_POST['days'],$from,$to);
	 
	 	 
	 if (empty($games)){
		echo "<font color='#CC0000'>There are not games with the Selected Conditions</font><BR><BR>";  
  	 }
	 $team_lose = array();
	 
	 foreach ($games as $game){
	    
		if ($game->vars["run_away"] > $game->vars["run_home"]){
		   $loser = $game->vars["team_home"]; 	
		}else {$loser = $game->vars["team_away"]; }
		$team_lose[date("Y-m-d", strtotime($game->vars["startdate"]))."/".$loser]= date("Y-m-d", strtotime($game->vars["startdate"]))."/".$loser;
	 }
	 
	 ?>
         <table id="baseball" width="100%" border="0" cellspacing="0" cellpadding="0">
		  <tr>
			<td width="120"  class="table_header" >Date</td>
			<td  name ="game_info_" width="120"  class="table_header">Away</td>
			<td  name ="game_info_" width="120"  class="table_header">Home</td>
   			<td  name ="game_info_" width="60"  class="table_header">Game Line</td>
   			<td  name ="game_info_" width="60"  class="table_header">Total Runs</td>
   			<td  name ="game_info_" width="60"  class="table_header">Status</td>
         	<td  name ="game_info_" width="60"  class="table_header">Balance</td>
        	<td  name ="game_info_" width="60" class="table_header"> Team Line</td>
			<td  name ="game_info_" width="60" class="table_header">Team Runs </td>
			<td  name ="game_info_" width="60" class="table_header">Status</td>
			<td  name ="game_info_" width="60" class="table_header">Balance</td>
		 </tr>  
	 
	 <?
	 
     $_next_games= array();
	 $j=0; 
	 foreach ($team_lose as $_team_lose){
	   $part = explode("/",$_team_lose);
	   $tomorrow = date( "Y-m-d", strtotime( "1 day", strtotime($part[0])));  
       $next_game = get_baseball_next_game_by_team($tomorrow,$part[1]);	   
	   
	   if (!is_null($next_game)){;
	   $next_game->vars["loser_team"] =$part[1] ;
	   $_next_games[$j] =  $next_game;
	   $j++;
	   }
	 }
     $h = 0;
	 $total_wins1 = 0;
	 $total_wins2 = 0;
    foreach ($_next_games as $game){
		
	      if($h % 2){$style = "1";}else{$style = "2";} $h++;		
	      $startdate =  date('Y-m-d',strtotime($game->vars["startdate"]));   
		  $_date=$startdate;
   	      $error_message = false;
		  $valid_line = false;
		  $day= date('M-d',strtotime($game->vars["startdate"]));
		  $hour= date('H:i',strtotime($game->vars["startdate"]));
		  $game_year = date('Y',strtotime($game->vars["startdate"]));
		  $date = date('Y-m-d',strtotime($game->vars["startdate"]));
		  $team_away = get_baseball_team($game->vars["team_away"]);
		  $team_home = get_baseball_team($game->vars["team_home"]);
		 			 
		  if ($game->vars["team_away"] == $game->vars["loser_team"]){
		    $away_lose = true;	  
		    $runs =  $game->vars["runs_away"];
		  }
		  else {
			$away_lose = false;
	        $runs =  $game->vars["runs_home"];
		    
		  }
		  
		  
		  if ($higher){
			 $line = 	$lines_team[$date." / ".$game->vars["away_rotation"]." / ".$game->vars["loser_team"]]->vars["away_total"];  
		 
		     $game_line = $lines_game[$date." / ".$game->vars["away_rotation"]]->vars["away_total"];  
		 
		  }
		 else{
			  $line = 	$lines_team[$date." / ".$game->vars["away_rotation"]." / ".$game->vars["loser_team"]]->vars["home_total"];    
			  
			  $game_line = $lines_game[$date." / ".$game->vars["away_rotation"]]->vars["home_total"];  
			  
			  	  }
		 
		  // As the Juice for total team does not have sign + for positives this parche is needed.
		  if($line){
		    $sign = substr($line,-4,1);
		    if ($sign != "-"){
		      $juice= substr($line,-3,3);
		      $pre_line = str_replace($juice,"",$line);
		      $line= $pre_line."+".$juice;
   		    }
		  }
		  
		  $cleaned_team_line = prepare_line($line);
		  $cleaned_line = prepare_line($game_line);
			  
				 ?>  
		         <tr>
				 <td class="table_td<? echo $style ?>" style="font-size:12px;"><? echo $day."-".substr($game_year,2,2)."  at   ".$hour ?></td> 
				 <td class="table_td<? echo $style ?>" style="font-size:12px;"><? if($away_lose){echo "<strong>"; } echo $team_away->vars["team_name"]; if($away_lose){echo "</strong>"; } ?></td> 
               	 <td class="table_td<? echo $style ?>" style="font-size:12px;"><? if(!$away_lose){echo "<strong>"; } echo $team_home->vars["team_name"]; if(!$away_lose){echo "</strong>"; } ?></td> 
                 <td class="table_td<? echo $style ?>" style="font-size:12px;"><? echo $game_line ?></td> 
                 <td class="table_td<? echo $style ?>" style="font-size:12px;"><? echo $game->vars["score"] ?></td> 
                 <td class="table_td<? echo $style ?>" style="font-size:12px;">
                  <? $data_game = get_baseball_line_process($higher,$line,$cleaned_line,$game->vars["score"]);
				   
				  $pre_balance_game = $data_game["pre_balance"];
				  $status_game = $data_game["status"];
				  if ($status_game == "WIN") { $total_wins1++;}
				  echo $status_game;
				
				  ?>
                 </td> 
                 <td class="table_td<? echo $style ?>" style="font-size:12px;"><? echo number_format($pre_balance_game,2) ?></td> 
                 <td class="table_td<? echo $style ?>" style="font-size:12px;"><? echo $line ?></td> 
			     <td class="table_td<? echo $style ?>" style="font-size:12px;"><? echo  $runs ?></td> 
                 <td class="table_td<? echo $style ?>" style="font-size:12px;">
			    <? $data = get_baseball_line_process($higher,$line,$cleaned_team_line,$runs);
				   
				  $pre_balance = $data["pre_balance"];
				  $status = $data["status"];
				  if ($status == "WIN") { $total_wins2++;}
				  echo $status;
				
				?>
                </td>  
				<td class="table_td<? echo $style ?>" style="font-size:12px;"><? echo  number_format($pre_balance,2) ?></td>  
			   </tr>
			  <? $balance = ($balance + $pre_balance) ;
			     $balance_game = ($balance_game + $pre_balance_game) 
			    
			  ?>      
     	  
  <? } ?>
          <tr>
			  <td class="table_header"></td>
              <td class="table_header"></td>
              <td class="table_header"></td>
              <td class="table_header"></td>
              <td class="table_header"></td>
              <? if ($h ==0){ $h=1;} ?>
              <td class="table_header"><? echo number_format(($total_wins1 * 100 / $h ),2); ?><strong>% WIN</strong></td> 
			  <td class="table_header"><? echo  number_format($balance_game,2) ?></td>  
              <td class="table_header"></td>
              <td class="table_header"></td> 
			  <td class="table_header"><? echo number_format(($total_wins2 * 100 / $h ),2); ?><strong>% WIN</strong></td> 
			 <td class="table_header"><? echo  number_format($balance,2) ?></td>  
			 </tr>
			<tr>
			  <td class="table_last" colspan="100"></td>
			</tr>
		
		</table>
	
   <?  if($error_message){
	   echo "<BR>";
	   echo "<font color='#CC0000'>There are not games  </font><BR><BR>"; ?>
	 <script>  
	     document.getElementById("baseball").style.display = "none";
 	 </script>  
	   
   <? }?>
   
<? } //post ?>
</div>
</body>
<? include "../../includes/footer.php" ?>
<? } else { echo "ACCESS DENIED"; }


?>


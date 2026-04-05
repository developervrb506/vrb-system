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
validations.push({id:"days",type:"numeric", msg:"Please use only Numbers"});
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
   }
   else {
	   $to = $season['end'] ; 
    }
  }


?>
<div class="page_content" style="padding-left:10px;">
<div align="right"><span ><a href="./baseball_reports.php">Back to Reports</a></span></div>
<span class="page_title">Pitchers Face-Off Report
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
    Number Days in : &nbsp;&nbsp; <input name="days" type="text" id="days" value="<? echo $_POST["days"] ?>" style="width:40px"  align="middle" />  &nbsp;&nbsp; 
  
     &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  
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
	  
	 $error_message = true;
	 $lines_game = get_sport_lines_by_dates($from,$to, 'MLB', 'Game');
	 $games = get_baseball_games_runs_by_date($from,$to);
	 
	 if (empty($games)){
		echo "<font color='#CC0000'>There are not games with the Selected Conditions</font><BR><BR>";  
  	 }
	 $pitchers = array();
	 
	 foreach ($games as $game){
	    $pitchers[$game->vars["pitcher_away"]."/".$game->vars["pitcher_home"]]=$game->vars["pitcher_away"]."/".$game->vars["pitcher_home"];
		$pitchers[$game->vars["pitcher_home"]."/".$game->vars["pitcher_away"]]=$game->vars["pitcher_home"]."/".$game->vars["pitcher_away"];
	 }

	 $j=0;
	 
	 ?>
         <table id="baseball" width="100%" border="0" cellspacing="0" cellpadding="0">
		  <tr>
			<td width="120"  class="table_header" >Date</td>
			<td  name ="game_info_" width="120"  class="table_header">Away</td>
			<td  name ="game_info_" width="120"  class="table_header">Home</td>
            <td  name ="game_info_" width="120"  class="table_header">Pitcher A</td>
            <td  name ="game_info_" width="120"  class="table_header">Pitcher H</td>
           <td  name ="game_info_" width="120"  class="table_header">Days</td>
   			<td  name ="game_info_" width="60" class="table_header">Line</td>
			<td  name ="game_info_" width="60" class="table_header">Runs</td>
			<td  name ="game_info_" width="60" class="table_header">Status</td>
			<td  name ="game_info_" width="60" class="table_header">Balance</td>
		 </tr>  
	 
	 <?
	       $h = 0;
	       $total_wins = 0;
	foreach ($pitchers as $_pitcher){
	 	
		if($j % 2){
	  
	    $part = explode("/",$_pitcher);
     	$face_off = get_baseball_pitchers_faceoff_by_date($part[0],$part[1],$from,$to); 
	    
	     if (count($face_off) > 1){
			 
		   $k=1;
		   $valid_line = true;
		   
		   
		   foreach ($face_off as $game){
		
		  	  if ($k==1){
		        $startdate =  date('Y-m-d',strtotime($game->vars["startdate"]));   
			    $nextdate = date( "Y-m-d", strtotime( $_POST["days"]." day", strtotime($startdate)));  	
			    $_date=$startdate;
                $seconds= strtotime($game->vars["startdate"])-strtotime($_date) ;
                $diff_day=intval($seconds/60/60/24);
			  }
			  else{
				 
			    $nextdate = date( "Y-m-d", strtotime( $_POST["days"]." day", strtotime($startdate)));  	
		        $_date=$startdate;
                $seconds= strtotime($game->vars["startdate"])-strtotime($_date) ;
                $diff_day=intval($seconds/60/60/24);
			  
			    if ($nextdate >= date('Y-m-d',strtotime($game->vars["startdate"]))){
			       $startdate =  date('Y-m-d',strtotime($game->vars["startdate"]));   
			       $valid_line=true;
				 }
			     else{
			     $valid_line = false;
		         //break;
				 }
			
		      }
			   if ($diff_day==0){
				 $valid_line = false;
		       }
			
		      if ($valid_line){
			    
			     $error_message = false;
				 $valid_line = false;
			     $day= date('M-d',strtotime($game->vars["startdate"]));
			     $hour= date('H:i',strtotime($game->vars["startdate"]));
			     $game_year = date('Y',strtotime($game->vars["startdate"]));
			     $date = date('Y-m-d',strtotime($game->vars["startdate"]));
			     $team_away = get_baseball_team($game->vars["team_away"]);
			     $team_home = get_baseball_team($game->vars["team_home"]);
		         $player_a = get_baseball_player_by_id("fangraphs_player",$game->vars["pitcher_away"]);
	             $player_h = get_baseball_player_by_id("fangraphs_player",$game->vars["pitcher_home"]);
				 
		         if ($higher){
				  $line = 	$lines_game[$date." / ".$game->vars["away_rotation"]]->vars["away_total"];  
				 }
				 else{
				  $line = 	$lines_game[$date." / ".$game->vars["away_rotation"]]->vars["home_total"];    
				 }
				 $cleaned_line = prepare_line($line);
			  
			     if($h % 2){$style = "1";}else{$style = "2";} $h++;		
				
				 ?>  
		         <tr>
				 <td class="table_td<? echo $style ?>" style="font-size:12px;"><? echo $day."-".substr($game_year,2,2)."  at   ".$hour ?></td> 
				 <td class="table_td<? echo $style ?>" style="font-size:12px;"><? echo $team_away->vars["team_name"] ?></td> 
               	 <td class="table_td<? echo $style ?>" style="font-size:12px;"><? echo $team_home->vars["team_name"] ?></td> 
                 <td class="table_td<? echo $style ?>" style="font-size:12px;"><? echo $player_a->vars["player"] ?></td>                
                 <td class="table_td<? echo $style ?>" style="font-size:12px;"><? echo $player_h->vars["player"] ?></td>          
                 <td class="table_td<? echo $style ?>" style="font-size:12px;"><? echo $diff_day ?></td>         
                 <td class="table_td<? echo $style ?>" style="font-size:12px;"><? echo $line ?></td> 
			     <td class="table_td<? echo $style ?>" style="font-size:12px;"><? echo $game->vars["score"] ?></td> 			 <td class="table_td<? echo $style ?>" style="font-size:12px;">
			    <? $data = get_baseball_line_process($higher,$line,$cleaned_line,$game->vars["score"]);
				   
				  $pre_balance = $data["pre_balance"];
				  $status = $data["status"];
				  if ($status == "WIN") { $total_wins++;}
				  echo $status;
				
				?>
                </td>  
				<td class="table_td<? echo $style ?>" style="font-size:12px;"><? echo number_format($pre_balance,2) ?></td>  
			   </tr>
			  <? $balance = ($balance + $pre_balance) ?>      
                  
		  
		  <?
		 
	 
		    }// Valid Line
		  $k++;
		  } //For Fac		  	  
		 } // Count
	   }//Pair
	   $j++;
	 } // Pitchers
 	 ?>
          <tr>
			  <td class="table_header"></td>
			  <td class="table_header"></td>
			  <td class="table_header"></td>
              <td class="table_header"></td>
              <td class="table_header"></td>
              <td class="table_header"></td>
              <td class="table_header"></td>
              <td class="table_header"><strong>Total:</strong></td> 
			  <? if($h==0) $h=1;?>
              <td class="table_header"><? echo number_format(($total_wins * 100 / $h ),2); ?><strong>% WIN</strong></td> 
              <td class="table_header"><? echo number_format($balance,2) ?></td>  
			 </tr>
			<tr>
			  <td class="table_last" colspan="100"></td>
			</tr>
		
		</table>
	
   <?  if($error_message){
	   echo "<BR>";
	   echo "<font color='#CC0000'>There are not games with Pitchers Face-Off between that range selected </font><BR><BR>"; ?>
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


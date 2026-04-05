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
<script type="text/javascript" src="http://localhost:8080/process/js/ajax.js"></script>
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
function Pitcher_id(){
  var a = document.getElementById('pitcher').value;
 if (a){
	 document.getElementById('pit').value = a;
	 }
}



var validations = new Array();
validations.push({id:"range1",type:"numeric", msg:"Please use only Numbers"});
validations.push({id:"range2",type:"numeric", msg:"Please use only Numbers"});
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
echo "<pre>";
//print_r($_POST);
echo "</pre>";

if ($_POST["pit"]){
	$str_pitcher = $_POST["pit"];
	$_POST["pitcher"] = $_POST["pit"];
	
}

$season_year = substr($_POST['year'],0,-2);
$control= true;
$from = clean_get("from");
$to =  clean_get("to");
$dates=false;

$dat = substr($from,0,-6); 


if ($_POST["hide"] == "season"){
	 $season_year = substr($_POST['year'],0,-2);
	 $dates=false;
}
else {
	 if ($from != "" && $to != ""){
	   $season_year = substr($_POST['year'],0,-2);
	 }else { $season_year = date("Y");}
	 $dates = true;
} 

if ($dates) {
  
  if ($from == "" && $to == ""){
	    
    $dates = false;
  }

 
}
 
 $year = $season_year;
	
	

$season =  get_baseball_season($year);
$all_seasons = get_all_baseball_seasons();
$stadiums = get_all_baseball_stadiums();
//$teams = get_all_baseball_team();



   
 if (!$dates){
   
   $from = $season['start'];
   if ($season['season'] == date('Y')) {
   $to = date( "Y-m-d"); //, strtotime( "-1 day", strtotime(date( "Y-m-d")))); 
   }
   else {
	   $to = $season['end'] ; 
    }
  }

$control = false;
if ($_POST["bullepen1"]!=""){
	
$bullpen = get_all_bullpen_team_by_dates($from, $to);
echo "<pre>";
//print_r($bullpen);
echo "</pre>";
$control = true;
}
?>

<div class="page_content" style="padding-left:10px;">
<div align="right"><span ><a href="./baseball_reports.php">Back to Reports</a></span></div>
<span class="page_title">Umpire Line Player Report
</span><br /><br />

<table>
<tr>
 <td>
 <form method="post" onsubmit="return validate(validations)">
   <input name="hide" type="hidden" id="hide" value="x" /> 
    <input name="pit" type="hidden" id="pit" value="0" /> 
  
   
    
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
    KBB (range): &nbsp;&nbsp; <input name="range1" type="text" id="range1" value="<? echo $_POST["range1"] ?>" style="width:40px"  align="middle" />  &nbsp;&nbsp;  to &nbsp;<input name="range2" type="text" id="range2" value="<? echo $_POST["range2"] ?>" style="width:40px"  align="middle" /> 
  
     &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  
     <select name="condition" id="condition">
       <option value=">" <? if ($_POST['condition'] == '>') { echo "selected"; } ?>>Over</option>
       <option value="<" <? if ($_POST['condition'] == '<') { echo "selected"; } ?>>Under</option>
     </select>
   <BR><BR>
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
   <a  id="filter" href="javascript:display_filter('pk','PK Filter','filter','pk1','pk2')" class="normal_link" title="Click to Filter by PK" >Show PK Filter</a> 	
   <div id="pk" style="display:none"><BR>
     &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
     PK (range): &nbsp;&nbsp; <input name="pk1" type="text" id="pk1" value="<? echo $_POST["pk1"] ?>" style="width:40px"  align="middle" />  &nbsp;&nbsp;  to &nbsp;<input name="pk2" type="text" id="pk2" value="<? echo $_POST["pk2"] ?>" style="width:40px"  align="middle" /> 
        
   </div>
   <BR><BR>

    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
   <a  id="temp_filter" href="javascript:display_filter('temp','Temp Filter','temp_filter','temp1','temp2')" class="normal_link" title="Click to Filter by Temperature" >Show Temp Filter</a> 	
   <div id="temp" style="display:none"><BR>
     &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
     Temp (range): &nbsp;&nbsp; <input name="temp1" type="text" id="temp1" value="<? echo $_POST["temp1"] ?>" style="width:40px"  align="middle" />  &nbsp;&nbsp;  to &nbsp;<input name="temp2" type="text" id="temp2" value="<? echo $_POST["temp2"] ?>" style="width:40px"  align="middle" /> 
        
   </div>
   <BR><BR>
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
   <a  id="hum_filter" href="javascript:display_filter('hum','Humedity Filter','hum_filter','hum1','hum2')" class="normal_link" title="Click to Filter by Humedity" >Show Humedity Filter</a> 	
   <div id="hum" style="display:none"><BR>
     &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
     Humedity (range): &nbsp;&nbsp; <input name="hum1" type="text" id="hum1" value="<? echo $_POST["hum1"] ?>" style="width:40px"  align="middle" />  &nbsp;&nbsp;  to &nbsp;<input name="hum2" type="text" id="hum2" value="<? echo $_POST["hum2"] ?>" style="width:40px"  align="middle" /> 
        
   </div>
   <BR><BR> &nbsp;&nbsp; &nbsp;&nbsp;&nbsp;
   <a  id="vp_filter" href="javascript:display_filter('vp','Vapour Pressure Filter','vp_filter','vp1','vp2')" class="normal_link" title="Click to Filter by Vapour Pressure" >Show Vapor Pressure Filter</a> 	
   <div id="vp" style="display:none"><BR>
     &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
     Vapor Pressure (range): &nbsp;&nbsp; <input name="vp1" type="text" id="vp1" value="<? echo $_POST["vp1"] ?>" style="width:40px"  align="middle" />  &nbsp;&nbsp;  to &nbsp;<input name="vp2" type="text" id="vp2" value="<? echo $_POST["vp2"] ?>" style="width:40px"  align="middle" /> 
        
   </div>
    <BR><BR> &nbsp;&nbsp; &nbsp;&nbsp;&nbsp;
   <a  id="dp_filter" href="javascript:display_filter('dp','Dewpoint Filter','dp_filter','dp1','dp2')" class="normal_link" title="Click to Filter by Dewpoint" >Show Dewpoint Filter</a> 	
   <div id="dp" style="display:none"><BR>
     &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
     Dewpoint(range): &nbsp;&nbsp; <input name="dp1" type="text" id="dp1" value="<? echo $_POST["dp1"] ?>" style="width:40px"  align="middle" />  &nbsp;&nbsp;  to &nbsp;<input name="dp2" type="text" id="dp2" value="<? echo $_POST["dp2"] ?>" style="width:40px"  align="middle" /> 
        
   </div>
   
   <BR><BR>
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
   <a  id="filter_moist" href="javascript:display_filter('moist','Moist Air Filter','filter_moist','moist1','moist2')" class="normal_link" title="Click to Filter by PK" >Show Moist Air Filter</a> 	
   <div id="moist" style="display:none"><BR>
     &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
     Moist Air (range): &nbsp;&nbsp; <input name="moist1" type="text" id="moist1" value="<? echo $_POST["moist1"] ?>" style="width:40px"  align="middle" />  &nbsp;&nbsp;  to &nbsp;<input name="moist2" type="text" id="moist2" value="<? echo $_POST["moist2"] ?>" style="width:40px"  align="middle" /> 
        
   </div>
   <BR><BR>
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
   <a  id="filter_bullepen" href="javascript:display_filter('bullepen','Bullpen Filter','filter_bullepen','bullepen1','bullepen2')" class="normal_link" title="Click to Filter by PK" >Show Bullpen Filter</a> 	
   <div id="bullepen" style="display:none"><BR>
     Type:
     <select name="b_type">
      <option <? if ($_POST["b_type"] == "ip") { echo 'selected'; } ?> value="ip">IP Total</option>
      <option <? if ($_POST["b_type"] == "pc") { echo 'selected'; } ?> value="pc">PC Total</option>
     </select>
     &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
     range: &nbsp;&nbsp; <input name="bullepen1" type="text" id="bullepen1" value="<? echo $_POST["bullepen1"] ?>" style="width:40px"  align="middle" />  &nbsp;&nbsp;  to &nbsp;<input name="bullepen2" type="text" id="bullepen2" value="<? echo $_POST["bullepen2"] ?>" style="width:40px"  align="middle" /> 
        
   </div>
   <BR><BR> &nbsp;&nbsp; &nbsp;&nbsp;&nbsp;
   
   
   
   
   <input type="submit" value="Search" onclick="Pitcher_id();" />
  </td>
  <td style.display:none > 
    <table style="font-size:9pt;font-family:Helvetica" border="0" >
     <tr ></tr>
     <?
     $j =1;
	 $str_season = "";
	 foreach ($all_seasons as $_season){
    ?> 
     <tr>
       <td id="td_season_<? echo $j?>" 
        <? /* // YEARS WAS REMOVED BY MIKE REQUEST
		 if (!isset($_POST["range1"])) {
	   	     if ( $j > 5){
		  	   echo 'style="display:none;" '; // Only 5 years 
			  }
  	     }else{
		     if ($season_year < $_season["season"]){echo 'style="display:none;" '; }
			 if ($_season["season"] <=($season_year-5)){ echo 'style="display:none;" ';}
		 }
		?> >
              
        &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp;
        <input id="season_<? echo $j ?>" type="checkbox"  <?
		  
		if ($_season["season"] == date("Y") || $_season["season"] == $season_year){
		   echo 'checked="checked"';
		   echo 'disabled="disabled"';
		}
		else{
		  if (isset($_POST["season_".$j])) {
		      echo 'checked="checked"';
		      $str_season .= $_season["season"]."/";
		   } 
		   //if (!isset($_POST["range1"])) {	}
		}
		?>
        name="season_<? echo $j?>"   value="<? echo $_season["season"] ?>" >
        &nbsp;&nbsp;<? echo $_season["season"] */?> 
       
       </td>
    <? $j++; ?>
     </tr>
    <? }
	  $str_season =   substr($str_season,0,-1); ?>
	 </tr>
     </table>
    <? 
	 $years = explode("/",$str_season);
    ?>   
</td>
<td align="center">
   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
   <?
  	$on_change = "from_ajax(this.value,'team_pitcher','process/actions/pitcher_team.php')";
   ?>
    Team:
     <? 
       create_objects_list("team_id", "team_id", $stadiums, "fangraphs_team", "team_name", "Select Team",$_POST["team_id"],$on_change,"_baseball_stadium");  ?>
   
   
   <div name="team_pitcher" id="team_pitcher">
        Pitcher: 
        <select onchange="" name="pitcher" id="pitcher"  class="">
 
        <option value="" id="select"  selected="selected">Select Team First</option>
    
        </select>
    </div>
   
   <?  if ($_POST["team_id"] != ""){ ?>
     <script>
	
	  from_ajax('<? echo $_POST["team_id"]."_".$_POST["pitcher"] ?>','team_pitcher','process/actions/pitcher_team.php');
	 
	 </script>
   <? } ?> 
 
  </td>
 </form>
 </tr>
</table>
<BR />


<?
// Control Used Filters
if ($_POST["hide"]=="season"){
	?>
	<script>	
      hide_link('by_season','by_dates');
    </script>
   <? }
if ($_POST["pk1"]!=""){
  ?>
   <script>	
      display_filter('pk','PK Filter','filter','pk1','pk2');
    </script>

<? } ?>
<?
if ($_POST["vp1"]!=""){
  ?>
   <script>	
      display_filter('vp','Vapour Pressure Filter','vp_filter','vp1','vp2');
    </script>

<? } ?>
<?
if ($_POST["dp1"]!=""){
  ?>
   <script>	
      display_filter('dp','Dewpoint Filter','dp_filter','dp1','dp2');
    </script>

<? } ?>

<? if ($_POST["temp1"]!=""){
  ?>
   <script>	
      display_filter('temp','Temp Filter','temp_filter','temp1','temp2');
    </script>

<? } ?>
<? if ($_POST["hum1"]!=""){
  ?>
   <script>	
      display_filter('hum','Humedity Filter','hum_filter','hum1','hum2');
    </script>

<? } ?>


<? if ($_POST["moist1"]!=""){
  ?>
   <script>	
      display_filter('moist','Moist Air Filter','filter_moist','moist1','moist2');
    </script>

<? } ?>
<? if ($_POST["bullepen1"]!=""){
  ?>
   <script>	
      display_filter('bullepen','Bullpen Filter','filter_bullepen','bullepen1','bullepen2');
    </script>

<? } ?>

<? 
   $str_stadiums =""; ?>

<? if (isset($_POST["range1"]) ){
   
     if ($_POST['condition'] == '>'){
	     $higher = true;	 
	  }
	  else{
	  $higher = false;	 	 
	  }
	 $error_message = true;
	 $lines_game = get_sport_lines_by_dates($from,$to, 'MLB', 'Game');
	 $games = get_baseball_games_kbb_by_date($from,$to,$_POST['range1'],$_POST['range2'],$years,$_POST['pk1'],$_POST['pk2'],$_POST['moist1'],$_POST['moist2'],$_POST['temp1'],$_POST['temp2'],$_POST['hum1'],$_POST['hum2'],$_POST['vp1'],$_POST['vp2'],$_POST['dp1'],$_POST['dp2'],$str_stadiums,$str_pitcher);
	 
	 if (empty($games)){
		echo "<font color='#CC0000'>There are not games with the Selected Conditions</font><BR><BR>";  
  	  }

	  ?>
		<table id="baseball" width="100%" border="0" cellspacing="0" cellpadding="0">
		  <tr>
			<td width="120"  class="table_header" >Date</td>
			<td  name ="game_info_" width="120"  class="table_header">Away</td>
			<td  name ="game_info_" width="120"  class="table_header">Home</td>
            <td  name ="game_info_" width="120"  class="table_header">Umpire</td>
   			<td  name ="data_away" width="60"  class="table_header">Weighted Avg</td>
 			<? if ($_POST['pk1'] != ""){ ?>
			 <td  name ="game_info_" width="60" class="table_header">PK</td>
            <? } ?>
            <? if ($_POST['vp1'] != ""){ ?>
			 <td  name ="game_info_" width="60" class="table_header">Vapour Pressure</td>
            <? } ?>
            <? if ($_POST['dp1'] != ""){ ?>
			 <td  name ="game_info_" width="60" class="table_header">Dewpoint</td>
            <? } ?>
        	<? if ($_POST['temp1'] != ""){ ?>
			 <td  name ="game_info_" width="60" class="table_header">Temp</td>
            <? } ?>
      		<? if ($_POST['hum1'] != ""){ ?>
			 <td  name ="game_info_" width="60" class="table_header">Hum</td>
            <? } ?>
            <? if ($_POST['moist1'] != ""){ ?>
			 <td  name ="game_info_" width="60" class="table_header">Moist Air</td>
            <? } ?>
           <? if ($_POST['bullepen1'] != ""){ ?>
			 <td  name ="game_info_" width="60" class="table_header">T <? echo $_POST["b_type"] ?> </td>
            <? } ?>

			<td  name ="game_info_" width="60" class="table_header">Line</td>
			<td  name ="game_info_" width="60" class="table_header">Runs</td>
			<td  name ="game_info_" width="60" class="table_header">Status</td>
			<td  name ="game_info_" width="60" class="table_header">Balance</td>
		 </tr>  
		  <?
          $total_wins =0;
		  $i=0;
		  ?>
		  <? foreach ($games as $game) { 
			  
			//
			$print_line = true;  // to bullpen control
			$valid_line = false; // to years control
			$day= date('M-d',strtotime($game->vars["startdate"]));
			$hour= date('H:i',strtotime($game->vars["startdate"]));
			$game_year = date('Y',strtotime($game->vars["startdate"]));
			$date = date('Y-m-d',strtotime($game->vars["startdate"]));
			
			if ($control){
				
			   $print_line = false;
			   $data1 = $bullpen[$date."_".$game->vars["team_away"]][$_POST["b_type"]] ;
			   $data2 = $bullpen[$date."_".$game->vars["team_home"]][$_POST["b_type"]];
			   $t_data = number_format($data1 + $data2,1);
			  	 if ($t_data >= $_POST["bullepen1"] && $t_data <= $_POST["bullepen2"]){
				  $print_line = true;  
				}
			
			}
			
		 if ($print_line){
			  
			  $team_away = get_baseball_team($game->vars["team_away"]);
			  $team_home = get_baseball_team($game->vars["team_home"]);
			 
		 
		  	 
			
		   if ($years[0] != ""){ 
			
			  foreach ($years as $_year){ 
			  
			    if( $game->vars[$_year] >= $_POST["range1"] && $game->vars[$_year] <= $_POST["range2"]){
				$valid_line=true;	
				}
				else {$valid_line=false; break; }
              }
		   
		   }
		   else {  $valid_line=true; }
			  
			  
			 if ($valid_line){ 
				$error_message = false;
				
				if ($higher){
				 $line = 	$lines_game[$date." / ".$game->vars["away_rotation"]]->vars["away_total"];  
				}
				else{
				 $line = 	$lines_game[$date." / ".$game->vars["away_rotation"]]->vars["home_total"];    
				}
				$cleaned_line = prepare_line($line);
			   
				
				if($i % 2){$style = "1";}else{$style = "2";} $i++;
				?>
				<tr>
				<td class="table_td<? echo $style ?>" style="font-size:12px;"><? echo $day."-".substr($game_year,2,2)."  at   ".$hour ?></td> 
				<td class="table_td<? echo $style ?>" style="font-size:12px;"><? echo $team_away->vars["team_name"] ?></td> 
               	<td class="table_td<? echo $style ?>" style="font-size:12px;"><? echo $team_home->vars["team_name"] ?></td> 
                <td class="table_td<? echo $style ?>" style="font-size:12px;"><? echo $game->vars["name"] ?></td>                
                <td class="table_td<? echo $style ?>" style="font-size:12px;"><? echo $game->vars["actual"] ?></td>               
               <? if ($years[0] != ""){ 
			      foreach ($years as $_year){ ?>
                   <td  class="table_td<? echo $style ?>" style="font-size:12px;"><? echo $game->vars[$_year] ?></td>
			     <? } } ?>
                
			   <? if ($_POST['pk1'] != ""){ ?>
               <td class="table_td<? echo $style ?>" style="font-size:12px;"><? echo $game->vars["pk"] ?></td> 
               <? } ?>
                <? if ($_POST['vp1'] != ""){ ?>
               <td class="table_td<? echo $style ?>" style="font-size:12px;"><? echo $game->vars["vapour_pressure"] ?></td> 
               <? } ?>
               <? if ($_POST['dp1'] != ""){ ?>
               <td class="table_td<? echo $style ?>" style="font-size:12px;"><? echo $game->vars["dewpoint"] ?></td> 
               <? } ?>
           	   <? if ($_POST['temp1'] != ""){ ?>
               <td class="table_td<? echo $style ?>" style="font-size:12px;"><? echo $game->vars["temp"] ?></td> 
               <? } ?>
               <? if ($_POST['hum1'] != ""){ ?>
               <td class="table_td<? echo $style ?>" style="font-size:12px;"><? echo $game->vars["humidity"] ?></td> 
               <? } ?>
                <? if ($_POST['moist1'] != ""){ ?>
               <td class="table_td<? echo $style ?>" style="font-size:12px;"><? echo $game->vars["moist_air"] ?></td> 
               <? } ?>
                 <? if ($_POST['bullepen1'] != ""){ ?>
               <td class="table_td<? echo $style ?>" style="font-size:12px;"><? echo $t_data ?></td> 
               <? } ?>
               <td class="table_td<? echo $style ?>" style="font-size:12px;"><? echo $line ?></td> 
			   <td class="table_td<? echo $style ?>" style="font-size:12px;"><? echo $game->vars["score"] ?></td> 
			   <td class="table_td<? echo $style ?>" style="font-size:12px;">
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
		 	 <? } ?>
           <? } // printLine ?>
        <?  } ?>
		
			<tr>
			  <td class="table_header"></td>
			  <td class="table_header"></td>
			  <td class="table_header"></td>
              <td class="table_header"></td>
              <td class="table_header"></td>
          <? if ($_POST['pk1'] != ""){ ?>
             <td class="table_header"></td>
          <? } ?>
          <? if ($_POST['vp1'] != ""){ ?>
             <td class="table_header"></td>
          <? } ?>
         <? if ($_POST['dp1'] != ""){ ?>
             <td class="table_header"></td>
          <? } ?>
           <? if ($_POST['moist1'] != ""){ ?>
             <td class="table_header"></td>
          <? } ?>
            <? if ($_POST['bullepen1'] != ""){ ?>
             <td class="table_header"></td>
          <? } ?>
              <td class="table_header"></td>
           <? if ($years[0] != ""){ 
			    foreach ($years as $_year){ ?>
                  <td class="table_header"></td> 
			  <? } } ?>
              <? if ($i ==0){ $i =1;} ?>
              <td class="table_header"><strong>Total:</strong></td> 
              <td class="table_header"><? echo number_format(($total_wins * 100 / $i ),2); ?><strong>% WIN</strong></td> 
			  
			 <td class="table_header"><? echo number_format($balance,2) ?></td>  
			 </tr>
			<tr>
			  <td class="table_last" colspan="100"></td>
			</tr>
		
		</table>
    
   <? if($error_message){
	   echo "<BR>";
	   echo "<font color='#CC0000'>There are not games between that range for the selected data</font><BR><BR>"; ?>
	 <script>  
	     document.getElementById("baseball").style.display = "none";
 	 </script>  
	   
   <? }?>
   
<? } ?>
</div>
</body>
<? include "../../includes/footer.php" ?>
<? } else { echo "ACCESS DENIED"; }

?>


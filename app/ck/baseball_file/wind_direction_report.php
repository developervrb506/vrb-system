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
validations.push({id:"range1",type:"numeric", msg:"Please use only Numbers"});
validations.push({id:"range2",type:"numeric", msg:"Please use only Numbers"});
</script>

</head>
<body>
<? include "../../includes/header.php"  ?>
<? include "../../includes/menu_ck.php"  ?>

<? /*
echo "<pre>";
print_r($_POST);
echo "</pre>";*/
$from = clean_get("from");
$to =  clean_get("to");
$runs =  clean_get("runs");
if($from == ""){
  $year = date("Y"); 
 }
 else{
 $year = date('Y',strtotime($from));	 
 }

$season =  get_baseball_season($year);

if($from == ""){ 
  $from = "2011-03-31";
  // $season['start'];
   if ($season['season'] == date('Y')) {
	$to = date( "Y-m-d", strtotime( "-1 day", strtotime(date( "Y-m-d")))); 
   }
   else {$to = $season['end'] ; }
}

 if (isset($_POST["stadium"])) { $_GET["stadium"] = $_POST["stadium"];}
 if (isset($_POST["wind"])) { $_GET["wind"] = $_POST["wind"];} 
 if (param("stadium") != "" ){ $_POST["stadium"] = param("stadium"); }

$stadiums = get_all_baseball_stadiums();
$wind = get_baseball_wind_direction();
echo "<pre>";//
//print_r($wind);
echo "</pre>";
?>

<div class="page_content" style="padding-left:10px;">
<div align="right"><span ><a href="./baseball_reports.php">Back to Reports</a></span></div>
<span class="page_title">Wind Direction Report
</span><br /><br />
<form method="post" onsubmit="return validate(validations)">
<table>

<tr>
 <td>

    From: 
    <input name="from" type="text" id="from" value="<? echo $from ?>" />
    To: 
     <input name="to" type="text" id="to" value="<? echo $to ?>" /> 
   <BR/> 

      Stadium:  
      <? create_objects_list("stadium", "stadium", $stadiums, "team_id", "name", "All",param("stadium"),"","_baseball_stadium");  ?>
       &nbsp;&nbsp;&nbsp;&nbsp;
     <input  type="checkbox" <? if (!isset($_POST['factor'])){ echo 'checked="checked"'; } if ($_POST['indoors']){ echo 'checked="checked"'; } ?>  value="1"  name="indoors" />
     Exclude Indoors Games
     
   <Br/ >
     Wind :
    <select name="wind" id="wind">
    <option value= "">Select One to Filter </option>
     <? foreach ($wind as $_wind) { ?>
       <option <? if (param("wind") == $_wind["id"] || param("wind") == $_wind["direction"] ) { echo ' selected ';} ?> value= "<? echo $_wind["id"] ?>"><? echo $_wind["description"]?> ( <? echo $_wind["direction"] ?>)</option>
     <? } ?>
     </select>
    <BR><BR>
    Runs:
    <input type="text" id="runs" name="runs" value="<? echo $runs ?>" style="width:50px" /> 

    &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;
   <input name="search" type="submit" value="Search" />
 
 </td>

</tr>

</table>
</form>
<BR />

 <? if (isset($_POST["search"])){ ?>
    <? 
      if (isset($_POST["indoors"]))  { $indoors = true; } else { $indoors = false; } 
	 
	
   
      if ($_POST["stadium"] > 0) { ?>
      <? print_wind_direction($from,$to,param("stadium"),$indoors,param("wind"),$runs); ?>
      
      <? } 
	  else {
	    $_total_runs = 0;
		$_total_homeruns = 0; 
		$_total_games = 0; 
		foreach ($stadiums as $_stadium){?>
            
        <span><strong>Stadium:  </strong> <? echo strtoupper($_stadium->vars["name"]) ?></span><BR><BR>
				  <?  
 		 $data = print_wind_direction($from,$to,$_stadium->vars["team_id"],$indoors,param("wind"),$runs);
         
		 $_total_runs = $data[0]["runs"] + $_total_runs;
         $_total_homeruns = $data[0]["homeruns"] + $_total_homeruns;   	
		 $_total_games = $data[0]["games"] + $_total_games;   
		 }	  
		?>
		<br /><br />


      <? } ?> 

<? } ?>
	  
	 
	   
	  
  

</div>
</body>
</html>
<? include "../../includes/footer.php" ?>
<? } else { echo "ACCESS DENIED"; }

 function print_wind_direction($from,$to,$stadium,$indoors,$wind,$runs){
 
       $t_runs = 0;
	   $t_homeruns = 0;
	   $games = get_baseball_games_by_wind_stadium($from,$to,$stadium,$indoors,$wind);
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
            <td  name ="game_info_" width="120"  class="table_header">Wind Direction</td>
            <td  name ="game_info_" width="120"  class="table_header">Position</td>
			<td  name ="game_info_" width="120" class="table_header">Total HomeRuns</td>
            <td  name ="game_info_" width="120" class="table_header">Total Runs</td>
			
		 </tr>  
		
		  <? $i=0; $t_over = 0; $t_under = 0;
		    foreach ($games as $game) { 
			  
			  $day= date('M-d',strtotime($game->vars["startdate"]));
			  $hour= date('H:i',strtotime($game->vars["startdate"]));
			  $game_year = date('Y',strtotime($game->vars["startdate"]));
			  $date = date('Y-m-d',strtotime($game->vars["startdate"]));
			  $team_away = get_baseball_team($game->vars["team_away"]);
			  $team_home = get_baseball_team($game->vars["team_home"]);
			  
			  
			 
			  
			  if($i % 2){$style = "1";}else{$style = "2";} $i++;
			  ?>
			  <tr>
			  <td class="table_td<? echo $style ?>" style="font-size:12px;"><? echo $day."-".substr($game_year,2,2)."  at   ".$hour ?></td> 
			  <td class="table_td<? echo $style ?>" style="font-size:12px;"><? echo $team_away->vars["team_name"] ?></td> 
			  <td class="table_td<? echo $style ?>" style="font-size:12px;"><? echo $team_home->vars["team_name"] ?></td> 
			 <td class="table_td<? echo $style ?>" style="font-size:12px;"><? echo $game->vars["wind_direction"] ?></td> 
			  <td class="table_td<? echo $style ?>" style="font-size:12px;"><? echo $game->vars["position"] ?></td> 
			  <td class="table_td<? echo $style ?>" style="font-size:12px;"><? echo $game->vars["homeruns"] ?></td>  
             <td class="table_td<? echo $style ?>" style="font-size:12px;"><? echo $game->vars["score"] ?></td> 
			
			<? 
			   $t_runs = $t_runs + $game->vars["score"];
			   $t_homeruns = $t_homeruns + $game->vars["homeruns"];
			   if ($game->vars["score"] > $runs){ $t_over++;}
   			   if ($game->vars["score"] < $runs){ $t_under++;}
			?>
			 
              <? } ?>
		
			<tr>
			  <td class="table_header"></td>
			  <td class="table_header"></td>
			  <td class="table_header"></td> 
			  <td class="table_header"></td> 
			  <td class="table_header">TOTAL</td>  
              <? if ($i == 0){ $i=1;}?>
              <td class="table_header"><strong><? echo $t_homeruns ?></strong> / Avg: <strong><? echo number_format(($t_homeruns  /$i),1)?></strong></td> 
			  <td class="table_header"><strong><? echo $t_runs ?></strong> / Avg: <strong><? echo number_format(($t_runs /$i),1)?></strong><BR>
                <BR>
               <strong>Over</strong> <? echo $runs ?> : <? echo $t_over ?><BR>
               <strong>Under</strong> <? echo $runs ?> : <? echo $t_under ?> 
              </td> 
			 </tr>
			<tr>
			  <td class="table_last" colspan="100"></td>
			</tr>
		
		</table>
        <br>
        <? $data[0]["runs"]= $t_runs;
		   $data[0]["homeruns"]= $t_homeruns; 
		   $data[0]["games"] = count($games);
		 return $data; ?>
     <? } ?>
 <? } ?>





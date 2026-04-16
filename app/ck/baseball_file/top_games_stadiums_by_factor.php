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
<link rel="stylesheet" href="<?= BASE_URL ?>/includes/shadowbox/shadowbox.css" type="text/css" media="screen" />

<script type="text/javascript" src="<?= BASE_URL ?>/process/js/functions.js?v=2"> </script>
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
<script type="text/javascript">
var validations = new Array();
validations.push({id:"pk",type:"numeric", msg:"Please use only Numbers"});
</script>

</head>
<body>
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

//$stadiums = get_all_baseball_stadiums();

?>

<div class="page_content" style="padding-left:10px;">
<div align="right"><span ><a href="./baseball_reports.php">Back to Reports</a></span></div>
<span class="page_title">Temp Factor Report.  (Top 10 Games)
</span><br /><br />


<form method="post" onsubmit="return validate(validations)">
    From: 
    <input name="from" type="text" id="from" value="<? echo $from ?>" />
    To: 
    <input name="to" type="text" id="to" value="<? echo $to ?>" /> 
    <BR/> <BR/>  &nbsp;&nbsp &nbsp;&nbsp &nbsp;&nbsp &nbsp;
     <select name="condition" id="condition">
       <option value=">" <? if ($_POST['condition'] == '>') { echo "selected"; } ?>>Over</option>
       <option value="<" <? if ($_POST['condition'] == '<') { echo "selected"; } ?>>Under</option>
     </select>
      &nbsp;&nbsp;
         Factor: 
       <select name="factor">
        <option  <? if ($_POST["factor"] == "humidity"){ echo 'selected="selected"'; }?> value="humidity" >Humedity</option>
        <option <? if ($_POST["factor"] == "temp"){ echo 'selected="selected"' ; }?>value="temp" >Temperature</option>
        <option <? if ($_POST["factor"] == "air_pressure"){ echo 'selected="selected"' ; }?> value="air_pressure" >Air Pressure</option>
        <option <? if ($_POST["factor"] == "dewpoint"){ echo 'selected="selected"' ; }?> value="dewpoint" >Dew Point</option>
        <option <? if ($_POST["factor"] == "moist_air"){ echo 'selected="selected"' ; }?> value="moist_air" >Moist Air</option>
          <option <? if ($_POST["factor"] == "dry_air"){ echo 'selected="selected"' ; }?> value="dry_air" >Dry Air</option>
           <option <? if ($_POST["factor"] == "vapour_pressure"){ echo 'selected="selected"' ; }?> value="vapour_pressure" >Vapour Pressure</option>
       </select>
       &nbsp;&nbsp;&nbsp;&nbsp;
     <select name="hi_low" id="hi_low">
       <option value="hi" <? if ($_POST['hi_low'] == 'hi') { echo "selected"; } ?>>Highest</option>
       <option value="low" <? if ($_POST['hi_low'] == 'low') { echo "selected"; } ?>>Lowest</option>
     </select>
      &nbsp;&nbsp;
     Pk: &nbsp;&nbsp; <input title="Use (-) for negative values" name="pk" type="text" id="pk" value="<? echo $_POST["pk"] ?>" style="width:40px"  align="middle" /> 
   
     &nbsp;&nbsp;&nbsp;&nbsp;
      <input  type="checkbox" <? if (!isset($_POST['factor'])){ echo 'checked="checked"'; } if ($_POST['indoors']){ echo 'checked="checked"'; } ?>  value="1"  name="indoors" />
     Exclude Indoors Games
   
   <Br/ ><Br/ >
    &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;
   <input type="submit" value="Search" />
   <Br/ ><Br/ >
 
<BR />



<? if (isset($_POST["hi_low"])){

     if ($_POST['condition'] == '>'){
	     $higher = true;	 
	  }
	  else{
	  $higher = false;	 	 
	  }
	  
	 $error_message = true;
	 $show_both = false;
	 $show_one = false;

	 
	  if ($_POST['hi_low'] == 'hi'){
	     $order = "DESC";	 
	  } else { $order = "ASC"; }
    
	
	 
	  
	  $stadiums = get_baseball_stadium_by_dates($from,$to,$_POST["indoors"]);
	  $lines_game = get_sport_lines_by_dates($from,$to, 'MLB', 'Game');
	  
	  $show_table = true;
	  if (empty($stadiums)){
		echo "<font color='#CC0000'>There are not games with the Selected Conditions</font><BR><BR>";  
	    $show_table = false;
	  }
	  
	  if ($show_table) {
	  
		?>
		
        <? foreach ($stadiums as $stadium) { ?>
        
        <?
          $games = get_baseball_games_temp_facts_stadium($_POST["factor"],$stadium->vars["team_home"],$from,$to,$order,$_POST['indoors']);
		echo "<strong>".$stadium->vars["name"]." ( ".$stadium->vars["team_name"]." )  </strong><BR><BR>";
		//print_r($games);
		?>
               
        <table id="baseball" width="100%" border="0" cellspacing="0" cellpadding="0">
		  <tr>
			<td width="120"  class="table_header" >Date</td>
			<td  name ="game_info_" width="120"  class="table_header">Away</td>
            <td  name ="game_info_" width="60" class="table_header"><? echo $_POST["factor"] ?></td>
			<td  name ="game_info_" width="60" class="table_header">Pk</td>
            <td  name ="game_info_" width="60" class="table_header">Line</td>
			<td  name ="game_info_" width="60" class="table_header">Runs</td>
			<td  name ="game_info_" width="60" class="table_header">Status</td>
			<td  name ="game_info_" width="60" class="table_header">Balance</td>
		 </tr>  
		
		  <? 
		   $total_wins += $wins;
		   $total_balance += $balance;
		   $i = 0;
	       $total_wins = 0;
		   $balance = 0;
		   
		   foreach ($games as $game) { 
			  
			  $valid_line = true;
			  $day= date('M-d',strtotime($game->vars["startdate"]));
			  $hour= date('H:i',strtotime($game->vars["startdate"]));
			  $game_year = date('Y',strtotime($game->vars["startdate"]));
			  $date = date('Y-m-d',strtotime($game->vars["startdate"]));
			  $team_away = get_baseball_team($game->vars["team_away"]);
			  $team_home = get_baseball_team($game->vars["team_home"]);
			 
			 
			  
			 if ($valid_line){ 
			
			  
				$error_message = false;
				
				if ($higher){
				 $line = 	$lines_game[$date." / ".$game->vars["away_rotation"]]->vars["away_total"];  
				}
				else{
				 $line = 	$lines_game[$date." / ".$game->vars["away_rotation"]]->vars["home_total"];    
				}
				$cleaned_line = prepare_line($line);
			   
		   		
			$print_line = false;
			if ($_POST["pk"] >= 0) {
				
			  if ($_POST["pk"] <= $game->vars["pk"]  ) { $print_line = true; }	
				
			} else {
				
			  if ($_POST["pk"] >= $game->vars["pk"]  ) { $print_line = true; }	
			  }
			
			
			
			
			
			
			if ($print_line) {	
			
				if($i % 2){$style = "1";}else{$style = "2";} $i++;
				?>
				<tr>
				<td class="table_td<? echo $style ?>" style="font-size:12px;"><? echo $day."-".substr($game_year,2,2)."  at   ".$hour ?></td> 
				<td class="table_td<? echo $style ?>" style="font-size:12px;"><? echo $team_away->vars["team_name"] ?></td> 
                <td class="table_td<? echo $style ?>" style="font-size:12px;"><? echo $game->vars[$_POST["factor"]]; ?></td> 
                <td class="table_td<? echo $style ?>" style="font-size:12px;"><? echo $game->vars["pk"]; ?></td> 
			   <td class="table_td<? echo $style ?>" style="font-size:12px;"><? echo $line ?></td> 
			   <td class="table_td<? echo $style ?>" style="font-size:12px;"><? echo $game->vars["runs"] ?></td> 
			   <td class="table_td<? echo $style ?>" style="font-size:12px;">
			   <? $data = get_baseball_line_process($higher,$line,$cleaned_line,$game->vars["runs"]);
				   
				  $pre_balance = $data["pre_balance"];
				  $status = $data["status"];
				  echo $status;
				  if ($status == "WIN") { $total_wins++;}
				
				?>
			   </td>  
				<td class="table_td<? echo $style ?>" style="font-size:12px;"><? echo number_format($pre_balance,2) ?></td>  
			   </tr>
			  <? $balance = ($balance + $pre_balance) ?>
              <? } ?>
		  <? } ?>
             
             
             
        <?  } ?>
		
			<tr>
			  <td class="table_header"></td>
              <td class="table_header"></td>
              <td class="table_header"></td>
              <td class="table_header"></td>                        
              <td class="table_header"></td> 
              <td class="table_header"></td> 
              <? if ($i==0) $i=1 ?>
			  <td class="table_header"><? echo number_format(($total_wins * 100 / $i ),2); ?><strong>% WIN</strong></td> 
			 <td class="table_header"><strong>Total: </strong> <? echo number_format($balance,2) ?></td>  
			 </tr>
			<tr>
			  <td class="table_last" colspan="100"></td>
			</tr>
		
		</table>
        <BR><BR>
     <?   } ?>
   <?   } ?>
   <?
   
    echo "<strong>Global Balance</strong>: ".number_format($total_balance,2)."   <strong>Total Wins</strong> :".$total_wins;
   
   ?>
      
   <? if($error_message){
	   echo "<BR>";
	   echo "<font color='#CC0000'><BR>"; ?>
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


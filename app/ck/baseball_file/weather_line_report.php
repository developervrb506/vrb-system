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
validations.push({id:"range1",type:"numeric", msg:"Please use only Numbers"});
validations.push({id:"range2",type:"numeric", msg:"Please use only Numbers"});
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

$stadiums = get_all_baseball_stadiums();
?>

<div class="page_content" style="padding-left:10px;">
<div align="right"><span ><a href="./baseball_reports.php">Back to Reports</a></span></div>
<span class="page_title">Weather Line Report
</span><br /><br />

<table >
<tr>
 <td >
<form method="post" onsubmit="return validate(validations)">
    From: 
    <input name="from" type="text" id="from" value="<? echo $from ?>" />
    To: 
    <input name="to" type="text" id="to" value="<? echo $to ?>" /> 
    <BR/>
     
     Factor: 
       <select name="factor">
        <option  <? if ($_POST["factor"] == "moist_air"){ echo 'selected="selected"'; }?> value="moist_air" >Moist Air</option>
        <option <? if ($_POST["factor"] == "dry_air"){ echo 'selected="selected"' ; }?>value="dry_air" >Dry Air</option>
        <option <? if ($_POST["factor"] == "vapour_pressure"){ echo 'selected="selected"' ; }?> value="vapour_pressure" >Vapour Pressure</option>
        <option <? if ($_POST["factor"] == "pk"){ echo 'selected="selected"' ; }?> value="pk" >PK</option>
       </select>
       
       
     &nbsp;&nbsp;&nbsp;
    Range: &nbsp;&nbsp; <input name="range1" type="text" id="range1" value="<? echo $_POST["range1"] ?>" style="width:40px"  align="middle" />  &nbsp;&nbsp;  to &nbsp;<input name="range2" type="text" id="range2" value="<? echo $_POST["range2"] ?>" style="width:40px"  align="middle" /><BR/> 

      Stadium:  
      <? create_objects_list("stadium", "stadium", $stadiums, "team_id", "name", "All",$_POST["stadium"],"","_baseball_stadium");  ?>
       &nbsp;&nbsp;&nbsp;&nbsp;
     <input  type="checkbox" <? if (!isset($_POST['factor'])){ echo 'checked="checked"'; } if ($_POST['indoors']){ echo 'checked="checked"'; } ?>  value="1"  name="indoors" />
     Exclude Indoors Games
     
   <Br/ >
   Conditions:
   <select name="condition" id="condition">
       <option value=">" <? if ($_POST['condition'] == '>') { echo "selected"; } ?>>Over</option>
       <option value="<" <? if ($_POST['condition'] == '<') { echo "selected"; } ?>>Under</option>
     </select>
    &nbsp;&nbsp;&nbsp;&nbsp;
    &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;
   <input type="submit" value="Search" />
 </td>
 <td>
  
</td>
</form>
</tr>
</table>
<BR />


 <? if (isset($_POST["stadium"])){ ?>
    <? 
     
	  if (isset($_POST["indoors"]))
	      { $indoors = true; } else { $indoors = false; } 
	 
	 if ($_POST['condition'] == '>'){
	     $higher = true;	 
	   }
	   else{
	     $higher = false;	 	 
	   }
	  
	   $lines_game = get_sport_lines_by_dates($from,$to, 'MLB', 'Game');
     ?>
   
      <? if ($_POST["stadium"] > 0) { ?>
      <?  print_wheater_line($from,$to,$_POST["stadium"],$_POST["factor"],$indoors,$_POST["range1"],$_POST["range2"],$lines_game,$higher); ?>
      <? //print_game_info_stadium("homeruns",$_POST["stadium"],$from,$to) ?>
      <? } 
	  else {
	    $_total_runs = 0;
		$_total_homeruns = 0; 
		$_total_games = 0; 
		foreach ($stadiums as $_stadium){?>
            
        <span><strong>Stadium:  </strong> <? echo strtoupper($_stadium->vars["name"]) ?></span><BR><BR>
				  <?  
 		 $data = print_wheater_line($from,$to,$_stadium->vars["team_id"],$_POST["factor"],$indoors,$_POST["range1"],$_POST["range2"],$lines_game,$higher);
         
		 $_total_runs = $data[0]["runs"] + $_total_runs;
         $_total_homeruns = $data[0]["homeruns"] + $_total_homeruns;   	
		 $_total_games = $data[0]["games"] + $_total_games;   
		 }	  
		?>
		<br /><br />
        <? if ( $_total_games > 0) { ?> 
         <span><strong>Total</strong> </span><br /><br />
         <table id="baseball" width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="120"  class="table_header" align="center" > Games</td>
            <td width="120"  class="table_header" align="center" > Runs</td>
            <td width="120"  class="table_header" align="center" > HomeRuns</td>
            <td  name ="game_info_" width="120"  class="table_header" align="center">Avg Runs</td>
            <td  name ="game_info_" width="120" class="table_header" align="center">Avg HomeRuns</td> 
          </tr>  
            <tr>
              <td align="center" class="table_td<? echo $style ?>" style="font-size:12px;"><? echo $_total_games ?> </td> 
               <td align="center" class="table_td<? echo $style ?>" style="font-size:12px;"><? echo $_total_runs ?> </td> 
               <td align="center"class="table_td<? echo $style ?>" style="font-size:12px;"><? echo  $_total_homeruns ?> </td> 
               <td align="center"class="table_td<? echo $style ?>" style="font-size:12px;"><? echo number_format($_total_runs/$_total_games,2) ?></td> 
                <td align="center"class="table_td<? echo $style ?>" style="font-size:12px;"><? echo number_format($_total_homeruns/$_total_games,2) ?></td>  
            
              </tr>
         
        
          <tr>
             <td class="table_last" colspan="100"></td>
          </tr>
        </table> <?
		}
		  
	   } 
	   
	   
    } ?>

</div>
</body>
<? include "../../includes/footer.php" ?>
<? } else { echo "ACCESS DENIED"; }


 function print_wheater_line($from,$to,$stadium,$factor,$indoors,$range1,$range2,$lines_game,$higher){
 
       $t_runs = 0;
	   $t_homeruns = 0;
	   $games = get_baseball_games_by_wheater_factor($from,$to,$stadium,$factor,$indoors,$range1,$range2);
	   $show_table = true;
	   $i = 0;
	   $total_wins = 0;
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
			<td  name ="game_info_" width="90"  class="table_header"><? echo $factor ?></td>
			<td  name ="game_info_" width="120" class="table_header">Line</td>
			<td  name ="game_info_" width="120" class="table_header">Total Runs</td>
            <td  name ="game_info_" width="120" class="table_header">Total HomeRuns</td>
			<td  name ="game_info_" width="120" class="table_header">Status</td>
			<td  name ="game_info_" width="120" class="table_header">Balance</td>
		 </tr>  
		
		  <? foreach ($games as $game) { 
			  
			  $day= date('M-d',strtotime($game->vars["startdate"]));
			  $hour= date('H:i',strtotime($game->vars["startdate"]));
			  $game_year = date('Y',strtotime($game->vars["startdate"]));
			  $date = date('Y-m-d',strtotime($game->vars["startdate"]));
			  $team_away = get_baseball_team($game->vars["team_away"]);
			  $team_home = get_baseball_team($game->vars["team_home"]);
			  
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
			 <td class="table_td<? echo $style ?>" style="font-size:12px;"><? echo $game->vars[$factor] ?></td> 
			  <td class="table_td<? echo $style ?>" style="font-size:12px;"><? echo $line ?></td> 
			 <td class="table_td<? echo $style ?>" style="font-size:12px;"><? echo $game->vars["score"] ?></td> 
			 <td class="table_td<? echo $style ?>" style="font-size:12px;"><? echo $game->vars["homeruns"] ?></td>              
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
			<? $balance = ($balance + $pre_balance) ;
			   $t_runs = $t_runs + $game->vars["score"];
			   $t_homeruns = $t_homeruns + $game->vars["homeruns"];
			?>
			 
              <? } ?>
		
			<tr>
			  <td class="table_header"></td>
			  <td class="table_header"></td>
			  <td class="table_header"></td>
			  <td class="table_header"></td>
			  <td class="table_header"></td> 
			   <td class="table_header"><strong><? echo $t_runs ?></strong></td> 
               <td class="table_header"><strong><? echo $t_homeruns ?></strong></td> 
			  <td class="table_header"><? echo number_format(($total_wins * 100 / $i ),2); ?><strong>% WIN</strong></td> 
			 <td class="table_header"><? echo number_format($balance,2) ?></td>  
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





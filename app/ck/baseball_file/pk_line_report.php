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
validations.push({id:"pk1",type:"numeric", msg:"Please use only Numbers"});
validations.push({id:"pk2",type:"numeric", msg:"Please use only Numbers"});
</script>

</head>
<body>
<? include "../../includes/header.php"  ?>
<? include "../../includes/menu_ck.php"  ?>

<? 

$from = clean_get("from");
$to =  clean_get("to");
$runs = clean_get("runs");
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

/*echo "<pre>";
print_r($_POST);
echo "</pre>";*/

?>

<div class="page_content" style="padding-left:10px;">
<div align="right"><span ><a href="./baseball_reports.php">Back to Reports</a></span></div>
<span class="page_title">PK Line Report
</span><br /><br />

<table >
<tr>
 <td align="center">
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
    PK (range): &nbsp;&nbsp; <input  title="Use here the lower value" name="pk1" type="text" id="pk1" value="<? echo $_POST["pk1"] ?>" style="width:40px"  align="middle" />  &nbsp;&nbsp;  to &nbsp;<input title="Use here the greater value" name="pk2" type="text" id="pk2" value="<? echo $_POST["pk2"] ?>" style="width:40px"  align="middle" /> 
    <BR><BR>
    Runs:
    <input type="text" id="runs" name="runs" value="<? echo $runs ?>" style="width:50px" /> 

   <Br/ ><Br/ ><Br/ >
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
		 if ((!isset($_POST["pk1"])) && $stadium->vars["team_id"]!=37)  {
			  echo 'checked="checked"';
			  //echo ' id="stadium_'.$j.'"';
  		      $str_stadiums .=  $stadium->vars["team_id"].", ";
		  } 
		  else{
		      if (isset($_POST["stadium_".$j])){
			   $str_stadiums .=  $stadium->vars["team_id"].", ";	  
		      
			  }
			  
		  }
  	     if ($stadium->vars["team_id"]==37) { echo 'disabled="disabled"';} 
		 else {echo ' id="stadium_'.$j.'"';}
		
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
<BR />

<? if (isset($_POST["pk1"])){
 
     if ($str_stadiums == ""){?>
		<script>   
          alert("Please select almost 1 stadium");
        </script>   
   <? }
     else {
	   if ($_POST['condition'] == '>'){
	     $higher = true;	 
	   }
	   else{
	     $higher = false;	 	 
	   }
	  
	   echo $str_stadiums;
	   $lines_game = get_sport_lines_by_dates($from,$to, 'MLB', 'Game');
	   $games = get_baseball_games_by_pk($from,$to,$_POST['condition'],$_POST['pk1'],$_POST['pk2'],$str_stadiums);
	   $show_table = true;
	  if (empty($games)){
		echo "<font color='#CC0000'>There are not games with the Selected Conditions</font><BR><BR>";  
	    $show_table = false;
	  }
	  
	  if ($show_table) {
	    $i = 0;
	    $total_wins = 0;
		$t_over = 0;
		$t_under = 0;		
		?>
		<table id="baseball" width="100%" border="0" cellspacing="0" cellpadding="0">
		  <tr>
			<td width="120"  class="table_header" >Date</td>
			<td  name ="game_info_" width="120"  class="table_header">Away</td>
			<td  name ="game_info_" width="120"  class="table_header">Home</td>
			<td  name ="game_info_" width="90"  class="table_header">PK</td>
			<td  name ="game_info_" width="120" class="table_header">Line</td>
			<td  name ="game_info_" width="120" class="table_header">Total Runs</td>
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
			 <td class="table_td<? echo $style ?>" style="font-size:12px;"><? echo $game->vars["pk"] ?></td> 
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
            <?  if ($game->vars["score"] > $runs){ $t_over++;}
   			   if ($game->vars["score"] < $runs){ $t_under++;} ?>
			  <? } ?>
		
			<tr>
			  <td class="table_header"></td>
			  <td class="table_header"></td>
			  <td class="table_header"></td>
			  <td class="table_header"></td>
			  <td class="table_header"></td> 
			  <td class="table_header"><strong>Total:</strong>
                <BR>
               <strong>Over</strong> <? echo $runs ?> : <? echo $t_over ?><BR>
               <strong>Under</strong> <? echo $runs ?> : <? echo $t_under ?> </td> 
              <td class="table_header"><? echo number_format(($total_wins * 100 / $i ),2); ?><strong>% WIN</strong></td> 
			 <td class="table_header"><? echo number_format($balance,2) ?></td>  
			 </tr>
			<tr>
			  <td class="table_last" colspan="100"></td>
			</tr>
		
		</table>
     <? } ?>
   <? } ?>
<? } ?>
</div>
</body>
<? include "../../includes/footer.php" ?>
<? } else { echo "ACCESS DENIED"; }

?>


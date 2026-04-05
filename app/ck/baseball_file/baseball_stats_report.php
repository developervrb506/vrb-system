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
validations.push({id:"ump1",type:"numeric", msg:"Please use only Numbers"});
validations.push({id:"ump2",type:"numeric", msg:"Please use only Numbers"});
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

?>

<div class="page_content" style="padding-left:10px;">
<div align="right"><span ><a href="./baseball_reports.php">Back to Reports</a></span></div>
<span class="page_title">Salami Report
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
    PK Avg (range): &nbsp;&nbsp; <input  title="Use here the lower value" name="pk1" type="text" id="pk1" value="<? echo $_POST["pk1"] ?>" style="width:40px"  align="middle" />  &nbsp;&nbsp;  to &nbsp;<input title="Use here the greater value" name="pk2" type="text" id="pk2" value="<? echo $_POST["pk2"] ?>" style="width:40px"  align="middle" />    <BR><BR>
     &nbsp;&nbsp;
     Umpire weighted Avg (range): &nbsp;&nbsp; <input  title="Use here the lower value" name="ump1" type="text" id="ump1" value="<? echo $_POST["ump1"] ?>" style="width:40px"  align="middle" />  &nbsp;&nbsp;
    to &nbsp;<input title="Use here the greater value" name="ump2" type="text" id="ump2" value="<? echo $_POST["ump2"] ?>" style="width:40px"  align="middle" />
    
      &nbsp; &nbsp;&nbsp;&nbsp;&nbsp;
   <input type="submit" value="Search" />
 </td>
 <td>
    
</td>
</form>
</tr>
</table>
<BR />

<? if (isset($_POST["pk1"])){
      echo "<pre>";
	  $stats =  get_all_baseball_stats($from, $to,$_POST["pk1"],$_POST["pk2"],$_POST["ump1"],$_POST["ump2"]);
	  
	
      
	   if ($_POST['condition'] == '>'){
	     $higher = true;	 
	   }
	   else{
	     $higher = false;	 	 
	   }
	  
	   $lines_game = get_sport_lines_by_dates($from,$to, 'MLB', 'Game');
	   //echo "<pre>";
	  // print_r($lines_game);
	   echo "</pre>";
	   
	  // $games = get_baseball_games_by_pk($from,$to,$_POST['condition'],$_POST['pk1'],$_POST['pk2'],$str_stadiums);
	   $show_table = true;
	  if (empty($stats)){
		echo "<font color='#CC0000'>There are not games with the Selected Conditions</font><BR><BR>";  
	    $show_table = false;
	  }
	  
	  if ($show_table) {
	    $i = 0;
	    $total_wins = 0;
		?>
		<table id="baseball" width="100%" border="0" cellspacing="0" cellpadding="0">
		  <tr>
			<td width="120"  class="table_header" >Date</td>
			<td  name ="game_info_" width="90"  class="table_header">PK</td>
            <td  name ="game_info_" width="90"  class="table_header">Umpire W Avg</td>
			<td  name ="game_info_" width="120" class="table_header">Grand Salami</td>
			<td  name ="game_info_" width="120" class="table_header">Total Runs</td>
			<td  name ="game_info_" width="120" class="table_header">Status</td>
			<td  name ="game_info_" width="120" class="table_header">Balance</td>
		 </tr>  
		
		  <? foreach ($stats as $game) { 
			  
			  
			  $date = $game->vars["date"];
			   $game->vars["score"] = $game->vars["total_runs"] ;
			  if ($higher){
			   $line = 	$stats[$date]->vars["grand_salami_over"];  
			  }
			  else{
			   $line = 	$stats[$date]->vars["grand_salami_under"];    
			  }
			  $cleaned_line = prepare_line($line);
			 
			  
			  if($i % 2){$style = "1";}else{$style = "2";} $i++;
			  ?>
			  <tr>
			  <td class="table_td<? echo $style ?>" style="font-size:12px;"><? echo $date ?></td> 
			  <td class="table_td<? echo $style ?>" style="font-size:12px;"><? echo $stats[$date]->vars["pk_avg"] ?></td> 
             <td class="table_td<? echo $style ?>" style="font-size:12px;"><? echo $stats[$date]->vars["ump_weighted_avg"] ?></td> 
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
		
			<tr>
			  <td class="table_header"></td>
              <td class="table_header"></td>
			  <td class="table_header"></td>
			  <td class="table_header"></td> 
			  <td class="table_header"><strong>Total:</strong></td> 
              <td class="table_header"><? echo number_format(($total_wins * 100 / $i ),2); ?><strong>% WIN</strong></td> 
			 <td class="table_header"><? echo number_format($balance,2) ?></td>  
			 </tr>
			<tr>
			  <td class="table_last" colspan="100"></td>
			</tr>
		
		</table>
   
   <? } ?>
<? } ?>
</div>
</body>
<? include "../../includes/footer.php" ?>
<? } else { echo "ACCESS DENIED"; }

?>


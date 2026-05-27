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
<link rel="stylesheet" type="text/css" media="all" href="<?= BASE_URL ?>/includes/calendar/jsDatePick_ltr.min.css" />
<script type="text/javascript" src="<?= BASE_URL ?>/process/js/functions.js?v=2"> </script>
<script type="text/javascript" src="js/functions.js"> </script>
<script type="text/javascript" src="<?= BASE_URL ?>/includes/calendar/jsDatePick.min.1.3.js"></script>
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
validations.push({id:"pitches",type:"numeric", msg:"Please use only Numbers"});
validations.push({id:"games",type:"numeric", msg:"Please use only Numbers"});
</script>

<script type="text/javascript">

function check_domed(){
	
  if (document.getElementById("stadium").value == "37"){ // Tropicana Field Always is closed	
     document.getElementById("condition").style.display = "none";
	 document.getElementById("trop").style.display = "block";
  } else { 
      document.getElementById("condition").style.display = "block"; 
      document.getElementById("trop").style.display = "none"; 
  }
}

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

$stadiums = get_all_baseball_stadiums(true);
$stadium = $_POST["stadium"];
$condition = $_POST["condition"];



?>

<div class="page_content" style="padding-left:10px;">
<div align="right"><span ><a href="./baseball_reports.php">Back to Reports</a></span></div>
<span class="page_title">Domed Stadiums report  
</span><br /><br />


<form method="post" onsubmit="return validate(validations)">
<table border ="0">

 <tr>  
    <td>
    From: 
      <input name="from" type="text" id="from" value="<? echo $from ?>" />
    </td>
    <td>
      To: 
      <input name="to" type="text" id="to" value="<? echo $to ?>" /> 
   </td>
   
 </tr>
  <tr>  
     <td>   
      
      Stadium:  
      <? create_objects_list("stadium", "stadium", $stadiums, "team_id", "name", "",$_POST["stadium"],"check_domed()","_baseball_stadium");  ?>
      </td>
      <td>
       <select name="condition" id="condition">
       <option  <? if ($condition){ echo ' selected '; }?>  value="1">Open</option>
       <option  <? if (!$condition){ echo ' selected '; }?>value="0">Closed</option>
       </select>
       <span id ="trop" style="display:none">Closed</span>
      </td>
     <tr>  
  
    <td></td>
 
   <td><input type="submit" value="Search" /></td>
      </tr>
 
 </table>
 </form>
<BR />



<? if (isset($_POST["stadium"])){
	
	$games = get_baseball_games_dommed_stadium($stadium,$from,$to,$condition);
 
     echo "<pre>";
	 //print_r($games);
	 echo "</pre>";
   ?>
     <table id="baseball" width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="120"  class="table_header" >Date</td>
            <td  name ="game_info_" width="120"  class="table_header">Away</td>
			<td  name ="game_info_" width="120" class="table_header">HomeRuns</td>
            <td  name ="game_info_" width="120" class="table_header">Runs</td>                      
            
         </tr>  
          <? foreach ($games as $game) { 
          
                $day= date('M-d',strtotime($game->vars["startdate"]));
                $hour= date('H:i',strtotime($game->vars["startdate"]));
                $date = date('Y-m-d',strtotime($game->vars["startdate"]));
                $team_away = get_baseball_team($game->vars["team_away"]);
               	if ($game->vars["pk"]== "-99"){ $game->vars["pk"] = 0;}
						  
                if($i % 2){$style = "1";}else{$style = "2";} $i++;
                ?>
                <tr>
                <td class="table_td<? echo $style ?>" style="font-size:12px;"><? echo $date."   at   ".$hour ?></td> 
                <td class="table_td<? echo $style ?>" style="font-size:12px;"><? echo $team_away->vars["team_name"] ?></td> 
                <td class="table_td<? echo $style ?>" style="font-size:12px;"><? echo $game->vars["homeruns"] ?></td> 
                <td class="table_td<? echo $style ?>" style="font-size:12px;"><? echo $game->vars["runs"] ?></td>  
               
               </tr>
               <? 
                 $total_runs = $total_runs + $game->vars["runs"];
                 $total_homeruns = $total_homeruns + $game->vars["homeruns"];
               ?>
          
        
        <? } ?>
		
			<tr>
			               
             
              <td class="table_header"></td> 
			  <td class="table_header"><strong>Total:</strong></td> 
			  <td class="table_header"><? echo  $total_homeruns ?></td>               
			  <td class="table_header"><? echo  $total_runs ?></td> 

			 </tr>
			<tr>
			  <td class="table_last" colspan="100"></td>
			</tr>
		
		</table>
        
        <? 
         $total_games = count($games);
		 $avg_runs = $total_runs / $total_games;
		 $avg_homeruns = $total_homeruns / $total_games;		  
		 $avg_data = get_baseball_avg_data_stadium("pk",$_POST["stadium"],$from,$to,$date_end);
         ?>
         <br /><br />
         <span><strong>Statistics for this Stadium</strong> </span><br /><br />
         <table id="baseball" width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="120"  class="table_header" align="center" >Avg  Runs ( <? if ($condition){ echo "Open"; } else {echo "Closed"; } ?> )</td>
            <td width="120"  class="table_header" align="center" >Avg  HomeRuns ( <? if ($condition){ echo "Open"; } else {echo "Closed"; } ?> )</td>            
           
            <td  name ="game_info_" width="120" class="table_header" align="center">Avg Runs</td> 
             <td  name ="game_info_" width="120"  class="table_header" align="center">Avg Homeruns</td>
          </tr>  
        
          <? foreach ($avg_data as $_avg_data) { 
          
             
              
              ?>
              <tr>
               <td align="center" class="table_td<? echo $style ?>" style="font-size:12px;"><? echo number_format($avg_runs,2)  ?></td> 
               <td align="center" class="table_td<? echo $style ?>" style="font-size:12px;"><? echo number_format($avg_homeruns,2) ?></td> 
             
               <td align="center"class="table_td<? echo $style ?>" style="font-size:12px;"><? echo number_format($_avg_data->vars["avg_runs"],2) ?></td> 
                 <td align="center"class="table_td<? echo $style ?>" style="font-size:12px;"><? echo number_format($_avg_data->vars["avg_homeruns"],2) ?></td> 
            
              </tr>
          <? } ?>
        
          <tr>
             <td class="table_last" colspan="100"></td>
          </tr>
        </table>
        <br /><br />
    
   
  
   
   
<? } ?>
</div>
</body>
<? include "../../includes/footer.php" ?>
<? } else { echo "ACCESS DENIED"; }

?>


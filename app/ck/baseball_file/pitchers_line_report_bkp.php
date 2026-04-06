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

<script type="text/javascript" src="<?= BASE_URL ?>/process/js/functions.js"> </script>
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
validations.push({id:"pitches",type:"numeric", msg:"Please use only Numbers"});
validations.push({id:"games",type:"numeric", msg:"Please use only Numbers"});
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
<span class="page_title">Pitchers Line Report  
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
     &nbsp;&nbsp &nbsp; Pitchers: &nbsp; 
     <select name="team" id="team">
       <option value="both" <? if ($_POST['team'] == 'both') { echo "selected"; } ?>>Both</option>
       <option value="one" <? if ($_POST['team'] == 'one') { echo "selected"; } ?>>One</option>
     </select>
    &nbsp;&nbsp;
    Pitches: &nbsp;&nbsp; <input name="pitches" type="text" id="pitches" value="<? echo $_POST["pitches"] ?>" style="width:40px"  align="middle" /> 
     &nbsp;&nbsp;
    Games: &nbsp;&nbsp; <input name="games" type="text" id="games" value="<? echo $_POST["games"] ?>" style="width:40px"  align="middle" /> 
   <Br/ ><Br/ >
    &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;
   <input type="submit" value="Search" />
   <Br/ ><Br/ >
 
<BR />



<? if (isset($_POST["pitches"])){

     if ($_POST['condition'] == '>'){
	     $higher = true;	 
	  }
	  else{
	  $higher = false;	 	 
	  }
	  
	 $error_message = true;
	 $show_both = false;
	 $show_one = false;

	 
	 if ($_POST['team'] == 'both'){
	  $show_both = true;
	 }
	 else if ($_POST['team'] == 'one'){
	   $show_one = true;  
	 }
	 

     $t_games = $_POST["games"];
	  
	  $lines_game = get_sport_lines_by_dates($from,$to, 'MLB', 'Game');
	  $games = get_baseball_games_runs_by_date($from,$to);
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
			<? if ($show_both) { ?>
            <td  name ="data_away" width="120"  class="table_header">Pitcher</td>
            <td  name ="data_away" width="60"  class="table_header">Pitches</td>
			<? } ?>
            <td  name ="game_info_" width="120"  class="table_header">Home</td>
   			<? if ($show_both) { ?>
            <td  name ="game_info_" width="120"  class="table_header">Pitcher</td>
            <td  name ="game_info_" width="60"  class="table_header">Pitches </td>
            <? } ?>
            <? if ($show_one) { ?>
            <td  name ="game_info_" width="140"  class="table_header">Pitcher </td>
            <td  name ="game_info_" width="60"  class="table_header">Pitches </td>
            <? } ?>
			<td  name ="game_info_" width="60" class="table_header">Line</td>
			<td  name ="game_info_" width="60" class="table_header">Runs</td>
			<td  name ="game_info_" width="60" class="table_header">Status</td>
			<td  name ="game_info_" width="60" class="table_header">Balance</td>
		 </tr>  
		
		  <? 
		    $i = 0;
			$total_wins = 0;
		    foreach ($games as $game) { 
			  
			  $valid_line = false;
			  $day= date('M-d',strtotime($game->vars["startdate"]));
			  $hour= date('H:i',strtotime($game->vars["startdate"]));
			  $game_year = date('Y',strtotime($game->vars["startdate"]));
			  $date = date('Y-m-d',strtotime($game->vars["startdate"]));
			  $team_away = get_baseball_team($game->vars["team_away"]);
			  $team_home = get_baseball_team($game->vars["team_home"]);
			 
			  $pitcher_away = get_player_pitches_by_game($game->vars["id"],$game->vars["pitcher_away"],"away");
              $games_pitcher = get_last_games_by_pitcher($game->vars["pitcher_away"],$t_games,$game->vars["id"]); 
              $str_games = "";
			   foreach ($games_pitcher as $game_pitcher){
				   $str_games .= "'".$game_pitcher["game"]."',";
				}
			   $str_games = substr($str_games,0,-1);
			   $total_games = get_last_pitches_by_game_list($str_games,$game->vars["pitcher_away"]);
			   if  (isset($total_games["total"])){ 
			     $pitcher_away->vars["sum_last_games"] = $total_games["total"];
			    } else {$pitcher_away->vars["sum_last_games"]= 0; }

			 $pitcher_home = get_player_pitches_by_game($game->vars["id"],$game->vars["pitcher_home"],"home");
			 
			 $games_pitcher = get_last_games_by_pitcher($game->vars["pitcher_home"],$t_games,$game->vars["id"]); 
              $str_games = "";
			   foreach ($games_pitcher as $game_pitcher){
				   $str_games .= "'".$game_pitcher["game"]."',";
				}
			   $str_games = substr($str_games,0,-1);
			   $total_games = get_last_pitches_by_game_list($str_games,$game->vars["pitcher_home"]);
			 
			   
			   if  (isset($total_games["total"])){ 
			     $pitcher_home->vars["sum_last_games"] = $total_games["total"];
			   } else {$pitcher_home->vars["sum_last_games"]= 0; }
			  
			
		      //echo $pitcher_away->vars["player"]." -- ".$game->vars["pitcher_away"]." - ".$pitcher_away->vars["sum_last_games"]."";
			 
		  if ($show_both){
			    
			 // echo "BOTH"; 
			 if (($pitcher_away->vars["sum_last_games"] >= $_POST["pitches"]) && ($pitcher_home->vars["sum_last_games"] >= $_POST["pitches"] )){
				
				$valid_line = true;	 
			  }
			  else {
				 $valid_line = false;	 
			   }
		 
		   }
		   else if ($show_one){
				
				//echo " ONE ";
				$show_away=false;
				$valid_line = false;
				$pitcher ="";
				$away_home="";
				
			  if (($pitcher_away->vars["sum_last_games"] >= $_POST["pitches"]) && ($pitcher_home->vars["sum_last_games"] >= $_POST["pitches"] )){
			   $valid_line = false;
			    //echo "False1";
			  }
			  else  if ($pitcher_away->vars["sum_last_games"] >= $_POST["pitches"]){
				$show_away = true;  
                $valid_line = true;
				$away_home = "A"; 
				$pitcher =	$pitcher_away->vars["player"]; 
				$pitches =  $pitcher_away->vars["sum_last_games"]; 
			   //echo "True1";
			  }
			  else  if ( $pitcher_home->vars["sum_last_games"] >= $_POST["pitches"]){
				$show_home = true;  
                $valid_line = true; 
				$away_home = "H"; 
				$pitcher = $pitcher_home->vars["player"] ;
				$pitches = $pitcher_home->vars["sum_last_games"] ;
			    //echo "True2<BR>";
			  }
			 
		   }
			  
			 //echo "<BR>"; echo "<BR>"; 
			 if ($valid_line){ 
			 
			 /* echo "<pre>";
			 print_r($pitcher_away);
			 echo "<br>---------<br>";
   			 print_r($pitcher_home); 
			 echo "</pre>";*/
			 
			  
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
                <? if ($show_both) { ?>      
                <td class="table_td<? echo $style ?>" style="font-size:12px;"><? echo $pitcher_away->vars["player"] ?></td> 
                <td class="table_td<? echo $style ?>" style="font-size:12px;"><? echo $pitcher_away->vars["sum_last_games"] ?></td> 
                <? } ?>
 
				<td class="table_td<? echo $style ?>" style="font-size:12px;"><? echo $team_home->vars["team_name"] ?></td> 
                  <? if ($show_both) { ?>  
                        <td class="table_td<? echo $style ?>" style="font-size:12px;"><? echo $pitcher_home->vars["player"] ?></td> 
                        <td class="table_td<? echo $style ?>" style="font-size:12px;"><? echo $pitcher_home->vars["sum_last_games"] ?></td> 
                <? } ?>
                 <? if ($show_one) { ?>       
                        <td class="table_td<? echo $style ?>" style="font-size:12px;"><? echo $pitcher." (".$away_home.")" ?></td> 
                        <td class="table_td<? echo $style ?>" style="font-size:12px;"><? echo $pitches  ?></td> 
                
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
             
             
        <?  } ?>
		
			<tr>
			  <td class="table_header"></td>
			  <td class="table_header"></td>
			  <td class="table_header"></td>
              <td class="table_header"></td>
              <td class="table_header"></td>
              <td class="table_header"></td>
              <? if ($show_both) {?>
              <td class="table_header"></td> 
              <td class="table_header"></td> 
			  <? } ?>
              <? if ($i== 0){$i=1;}?>
              <td class="table_header"><strong>Total:</strong></td> 
			  <td class="table_header"><? echo number_format(($total_wins * 100 / $i ),2); ?><strong>% WIN</strong></td> 
			 <td class="table_header"><? echo number_format($balance,2); ?></td>  
			 </tr>
			<tr>
			  <td class="table_last" colspan="100"></td>
			</tr>
		
		</table>
    
   <?   } ?>
   <? if($error_message){
	   echo "<BR>";
	   echo "<font color='#CC0000'>There are not games with pitches bigger than ".$_POST["pitches"]." for ".$_POST["team"]." Pitcher</font><BR><BR>"; ?>
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


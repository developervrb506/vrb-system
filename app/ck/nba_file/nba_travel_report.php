<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? require_once(ROOT_PATH . '/includes/html_dom_parser.php');  ?>
<? require_once(ROOT_PATH . '/ck/nba_file/process/functions.php'); ?>
<? $width = 120; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../../css/style.css" rel="stylesheet" type="text/css" />
<title>NBA SYSTEM</title>
<link rel="stylesheet" href="<?= BASE_URL ?>/includes/shadowbox/shadowbox.css" type="text/css" media="screen" />
<script type="text/javascript" src="<?= BASE_URL ?>/includes/shadowbox/shadowbox.js"></script>
<script type="text/javascript" src="<?= BASE_URL ?>/process/js/functions.js?v=2"> </script>
<script type="text/javascript" src="<?= BASE_URL ?>/process/js/FileSaver.js"> </script>
<script type="text/javascript" src="<?= BASE_URL ?>/ck/nba_file/js/functions.js"> </script>
<script type="text/javascript" src="<?= BASE_URL ?>/ck/includes/js/jquery-1.8.0.min.js"></script>
<script type="text/javascript">
Shadowbox.init();


function hide_img(){
	//$("img").hide();
	var images = document.getElementsByTagName('img');
   while(images.length > 0) {
    images[0].parentNode.removeChild(images[0]);
   }
}

function send_form(){
	
document.getElementById('frm_dist').submit();
}



function color_row(id,ind,style){
	for (x=1;x<=3;x++){
    	
		if(style == 1){
		document.getElementById(id+x+"_"+ind).style.backgroundColor = '#379819';
		} else{
		document.getElementById(id+x+"_"+ind).style.backgroundColor = '#acd2a0';	
		}
	}

}

 function show_hide_column(table,id, do_show,columns) {
  var stl;
  var new_width;
  var check = document.getElementById(id);
  if(!check.checked) {
      $(document).ready(function() {
     $("."+id).hide();
   });
  } else {
	    $(document).ready(function() {
     $("."+id).show();
   });  
  }
    
  }
  
 function hide_div_team(id){
	 
   // document.getElementById("div_team_"+id).style.display = "none";
	 document.getElementById("div_team_"+id).outerHTML= '';
 } 

</script>
</head>
<body>
<? $page_style = " width:3500px;"; ?>
<? include "../../includes/header.php" ?>
<? include "../../includes/menu_ck.php" ?>
<div class="page_content" style="padding-left:50px;">
<img src="images/NBA.png" style="width:60px; margin-bottom:-20px"><span class="page_title">TEAMS TRAVEL REPORT</span><br /><br /><br />
<?	

if($current_clerk->vars['id'] != 86 ){
	$subject = 'NBA REPORT ACCESS';
	$content = "User: ".$current_clerk->vars['name']." IP: ".get_ip()." Date checked. ".$from;
	
	send_email_ck('aandrade@inspin.com', $subject, $content, true, $current_clerk->vars["fake_email"]);
}

//Params

$other = param("other");
$game = param("game");
$first = param("first");
$second = param("second");
$season = $_POST["season"];
$p_days = param("days");
$p_away = param("away");
$teams = get_nba_teams("id");
$p_rest = param("rest");



$i=0;

if($other != ""){
  $dist_team = get_nba_all_teams_distance();	
} else{
  $game = $first = $second = 1;	
}

?>

<table cellspacing="10">
<tr>
 <td >
<form id="frm_dist" method="post">
 Season:&nbsp;
  <select name="season">
  <option <? if ($season == '21-22'){ echo ' selected="selected" ';}?>  value="21-22" >21-22</option>    
  <option <? if ($season == '19-20'){ echo ' selected="selected" ';}?>  value="19-20" >19-20</option>    
  <option <? if ($season == '18-19'){ echo ' selected="selected" ';}?>  value="18-19" >18-19</option>     
  <option <? if ($season == '17-18'){ echo ' selected="selected" ';}?>  value="17-18" >17-18</option>   
  <option <? if ($season == '16-17'){ echo ' selected="selected" ';}?>  value="16-17" >16-17</option>
  <option <? if ($season == '15-16'){ echo ' selected="selected" ';}?>  value="15-16" >15-16</option>

 </select>
<BR><BR>
 #Games: <input required="required" style="width:35px" type="number" name="other" id="other" value="<? echo $other ?>">&nbsp;&nbsp;&nbsp;
  #Days: &nbsp;  <input required="required"  style="width:35px" type="number" name="days" id="days" value="<? echo $p_days ?>">
 <BR><BR>
 #Away: &nbsp;&nbsp;  <input  style="width:35px" type="number" name="away" id="away" value="<? echo $p_away?>">&nbsp;(Optional)
 <BR><BR>
 #Vs Rest Days : &nbsp;&nbsp;  <input  style="width:35px" type="number" name="rest" id="rest" value="<? echo $p_rest?>">&nbsp;(Optional)

 <BR><BR><BR>
 <input  style="width:230px"  type="submit" value="SEARCH">
 
</td>
<td>
 <table >
 <tr>
 <td> <input name="game" id="game" type="checkbox" <? if($game) { echo ' checked="checked" ' ;}?> value="1" onchange=" show_hide_column( 'tbl_sch', 'game');"> Game </td>
 </tr>
 <tr>
 <td>  <input name="first" id="first" type="checkbox" <? if($first) { echo ' checked="checked" ' ;}?>  value="1" onchange="show_hide_column( 'tbl_sch', 'first');"> 1st Halft </td>
 </tr>
 <tr>
<td>  <input name="second"  id="second" type="checkbox" <? if($second) { echo ' checked="checked" ' ;}?> value="1" onchange="show_hide_column( 'tbl_sch', 'second');"> 2nd Halft </td>
 </tr>
</table>
</td>
 <td>
  <table  >
  <tr >Teams :</tr>
   <?
     $j =1;
	 $row=1;
	 $str_teams = "";
	 foreach ($teams as $t){
    ?> 
     <? if ($row == 1) { ?>
      <tr>
     <? } ?> 
       <td >
        <input  type="checkbox"  onmouseover="javascript:showtooltip('team_<? echo $j ?>','<? echo $t->vars["team"]?>')" 
        <?
		 
		 if (isset($_POST["team_".$j])) { echo 'checked="checked"'; 
		
			   $str_teams .=  $t->vars["id"].", ";	  
		      
	 }
	
  	     echo ' id="team_'.$j.'"';
		
		?>
         name="team_<? echo $j?>"   value="<? echo $t->vars["id"] ?>" >
         &nbsp;&nbsp;<? echo $t->vars["team"] ?> 
       </td>
      <? if ($row == 3){ ?>
         </tr>
        <? $row = 0;
	    }
	 $row++;
	 $j++;
	 }
	 $str_teams =   substr($str_teams,0,-2); ?>
	 </tr>
     </table>
     <div id="uncheck" >      
      <a id="uncheck" href="javascript:unckeck_all('team_',<? echo count($teams)?>)" style="font-size:9pt;font-family:Helvetica" class="normal_link">Uncheck all</a> 
     </div>  
     <div id="check" style="display:none" >
      <a  href="javascript:ckeck_all('team_',<? echo count($teams)?>)" style="font-size:9pt;font-family:Helvetica" class="normal_link" >Check all</a> 
      </div> 
</td>



</table>
</form>
<BR><BR>
<div align="left">
	<a href="javascript:;" onclick="hide_img();create_excel('div_report');" class="normal_link">
		Export
	</a>
</div>
<BR><BR>

<div id="div_report">
<?
if ($str_teams == "" && $other != "" ){?>
		<script>   
          alert("Please select almost 1 Team");
        </script>   
   <? }
else if ($other != ""){

 $selected_teams = explode(",",$str_teams);

 foreach($selected_teams as $steam){
	 $st = trim($steam);
	 $i=0;
	 $schedule =  get_nba_schedule_by_team($st,$season);
	 $total_sch = count($schedule);
	 $rotations = get_awayrotations_between_dates('nba',$schedule[0]->vars["date"],$schedule[$total_sch-1]->vars["date"]);
	 $lines =  get_league_lines_between_dates('NBA',$schedule[0]->vars["date"],$schedule[$total_sch-1]->vars["date"]);
	 $valid = 0;
	 //win
	 $g_result = $f_result = $s_result = 0;
	 $g_spread = $f_spread = $s_spread = 0;
	 $g_money = $f_money = $s_money = 0;
	 $g_total = $f_total = $s_total = 0;
	 //Loss
	 $g_l_result = $f_l_result = $s_l_result = 0;
	 $g_l_spread = $f_l_spread = $s_l_spread = 0;
	 $g_l_money = $f_l_money = $s_l_money = 0;
	 $g_l_total = $f_l_total = $s_l_total = 0;
	 //Push
	 $g_p_result = $f_p_result = $s_p_result = 0;
	 $g_p_spread = $f_p_spread = $s_p_spread = 0;
	 $g_p_money = $f_p_money = $s_p_money = 0;
	 $g_p_total = $f_p_total = $s_p_total = 0;
	 
	?>
    
  <div id="div_team_<? echo $teams[$st]->vars["id"] ?>">
    <div>
       <img style="width:35px" src="<?= BASE_URL ?>/ck/nba_file/images/<? echo $teams[$st]->vars["logo"]?>.png">
      <span> <strong><? echo $teams[$st]->vars["team"]?>  </strong> </span> 
      
    </div>	
    	
      
	<table id="tbl_sch" border="0" cellspacing="0" cellpadding="0">
	  <tr>
		<td class="table_header" align="center" width="80px">Date</td>
		<td class="table_header" align="center" width="120px">Team 1</td>
		<td class="table_header" align="center" width="25px"></td>    
		<td class="table_header" align="center" width="172px">Team 2</td> 
		<td class="table_header" align="center" width="25px">Vs Rest Days</td> 
		<td class="table_header" align="center" width="25px"></td>     
	
		<td name="lines" class="table_header game" align="center" width="80px">GAME Result</td> 
		<td name="lines" class="table_header game" align="center" width="80px">GAME Spread</td>     
		<td name="lines" class="table_header game" align="center" width="25px"></td>     
		<td name="lines" class="table_header game" align="center" width="80px">GAME MONEY</td>     
		<td name="lines" class="table_header game" align="center" width="25px"></td>         
		<td name="lines" class="table_header game" align="center" width="80px">GAME TOTAL</td>     
		<td name="lines" class="table_header game" align="center" width="25px"></td>   
		
		<td name="lines" class="table_header first" align="center" width="80px">1st H Result</td> 
		<td name="lines" class="table_header first" align="center" width="80px">1st H Spread</td>     
		<td name="lines" class="table_header first" align="center" width="25px"></td>     
		<td name="lines" class="table_header first" align="center" width="80px">1st H MONEY</td>     
		<td name="lines" class="table_header first" align="center" width="25px"></td>         
		<td name="lines" class="table_header first" align="center" width="80px">1st H TOTAL</td>     
		<td name="lines" class="table_header first" align="center" width="25px"></td>     
		
		 <td name="lines" class="table_header second" align="center" width="80px">2nd H Result</td> 
		<td name="lines" class="table_header second" align="center" width="80px">2nd H Spread</td>     
		<td name="lines" class="table_header second" align="center" width="25px"></td>     
		<td name="lines" class="table_header second" align="center" width="80px">2nd H MONEY</td>     
		<td name="lines" class="table_header second" align="center" width="25px"></td>         
		<td name="lines" class="table_header second" align="center" width="80px">2nd H TOTAL</td>     
		<td name="lines" class="table_header second" align="center" width="25px"></td>     
		
		<? if ($other) {?>    
		<td class="table_header other" align="center"  title="Rest Days" width="40px">(<? echo $other ?>G)  Days</td>  
		<td class="table_header other" align="center"  title="Games as Away" width="40px">(<? echo $other ?>G) AWAY</td>
		<td class="table_header other" align="center"  title="Total Miles RoadTrip" width="40px">(<? echo $other ?>G) MILES</td>   
		<? } ?>
	
	  </tr>
	 <? $away = false; $away_total = 0;$team2=0;
	
		
	 foreach ($schedule as $sc){  if($i % 2){
		  $style = "1";}else{$style = "2";} 
	      $print_line = false; 
		  $days = $other ;  
		  $rest_days = get_nba_team_travel_info($schedule,$dist_team,$st,$i,$days,'restdays');
		  $away_days = get_nba_team_travel_info($schedule,$dist_team,$st,$i,$days,'away') ;
		  $vs_rests_days = get_day_diff(get_vs_rest_days($teams[$sc->vars["team_away"]]->vars["id"],$sc->vars["date"]),$sc->vars["date"]);
		
		  if(!$p_away){
		     if($rest_days == $p_days && $i>=$other ){ $print_line = true; }  
		  }else{
		    if(($rest_days == $p_days) && ($p_away == $away_days) && ( $i>=$other) ){ $print_line = true; }  
	      } 
		 if($p_rest && $p_away && !$p_rest){
     		 $print_line = false;
			 if($vs_rests_days >= $p_rest && $rest_days == $p_days && $i>=$other && ($p_away == $away_days)) { $print_line = true;}
			 
		 }
          if($p_rest && $p_away ){
				$print_line = false;
			 if($vs_rests_days >= $p_rest && $rest_days == $p_days && $i>=$other && ($p_away == $away_days) ) { $print_line = true;} 
			 
		 }
		   if($p_rest && !$p_away ){
						$print_line = false;
			 if($vs_rests_days >= $p_rest && $rest_days == $p_days && $i>=$other ) { $print_line = true;} 
			 
		 }
		  
	  if($print_line){
		 
		  if ($sc->vars["date"] < date("Y-m-d")){ $valid++; }
		 
	    ?>
	
	   <tr>
         <td class="table_td<? echo $style ?>" align="center"><? echo $sc->vars["date"]." - ".$sc->vars["id"]?></td>
		 <td class="table_td<? echo $style ?>" align="center"><? echo $teams[$st]->vars["team"]?></td>
		 <td class="table_td<? echo $style ?>" align="center"><? if($sc->vars["team_home"] == $st){ echo 'VS'; $away = false;  $team2 = $sc->vars["team_away"]; $str_team = "home"; }else { echo '@'; $away = true; $away_total++; $team2 = $sc->vars["team_home"]; $str_team = 'away'; } ?></td>  
		 <td class="table_td<? echo $style ?>" ><img style="width:25px" src="<?= BASE_URL ?>/ck/nba_file/images/<? echo $teams[$team2]->vars["logo"]?>.png">
		  &nbsp;&nbsp; <?  echo $teams[$team2]->vars["team"] ?></td>   
           <td class="table_td<? echo $style ?>" align="center"><? echo  $vs_rests_days ?></td>
		 <td class="table_td<? echo $style ?>" align="center"><? if($sc->vars["team_winner"]) { if($sc->vars["team_winner"] == $st  ){ echo '<span style="font-size:16px;color:Green"><strong>W</strong></span>'; $g_result++;} else { echo '<span style="font-size:16px;color:Red"><strong>L</strong></span>'; $g_l_result++;} }  ?></td>          
		 <td  name ="lines" class="table_td<? echo $style ?>_blue game" align="center"><? echo $sc->vars["away_points"]." - ".$sc->vars["home_points"] ?></td>     
	 
		 <? $rot_key = $sc->vars["date"]."_".$teams[$sc->vars["team_away"]]->vars["team_id"];?>
		 <? $rot = $rotations[$rot_key]["awayrotationnumber"]; ?>
		 <? $line_key = $sc->vars["date"]."_Game_".$rot;?>
		 <? $spread = ""; $spread = $lines[$line_key][$str_team."_spread"]; ?>
		 <? $money = ""; $money = $lines[$line_key][$str_team."_money"]; ?>
		 <? $total = ""; $total = $lines[$line_key][$str_team."_total"]; ?>          
		 <td name ="lines"class="table_td<? echo $style ?>_blue game" align="center"><? echo $spread ?></td>   
		 <td name ="lines"class="table_td<? echo $style ?>_blue game" align="center"><? if($spread) { $result =  check_line($str_team, $sc->vars["away_points"],$sc->vars["home_points"],$spread,'spread'); $status = $result[0]; $result[0] = ""; if($status == '+'){ $g_spread++; }  if($status == '-'){ $g_l_spread++; } if($status == '='){ $g_p_spread++; } echo $result; } ?></td>   
		 <td name ="lines"class="table_td<? echo $style ?>_blue game" align="center"><? echo $money ?></td>
            
		 <td name ="lines"class="table_td<? echo $style ?>_blue game" align="center"><? if($money) {  $result =  check_line($str_team, $sc->vars["away_points"],$sc->vars["home_points"],$spread,'money');  $status = $result[0]; $result[0] = ""; if($status == '+'){ $g_money++; } if($status == '-'){ $g_l_money++; } if($status == '='){ $g_p_money++; } echo $result; } ?></td>   
		 <td name ="lines"class="table_td<? echo $style ?>_blue game" align="center"><? echo $total ?></td>   
		 <td name ="lines"class="table_td<? echo $style ?>_blue game" align="center"><? if($total) { $result =  check_line($str_team, $sc->vars["away_points"],$sc->vars["home_points"],$total,'total');  $status = $result[0]; $result[0] = ""; if($status == '+'){ $g_total++; }if($status == '-'){ $g_l_total++; } if($status == '='){ $g_p_total++; }  echo $result; } ?></td>    
		 
		 <td  name ="lines" class="table_td<? echo $style ?>_yellow first" align="center"><? echo $sc->vars["first_away_points"]." - ".$sc->vars["first_home_points"] ?></td>     
		 <? $rot_key = $sc->vars["date"]."_".$teams[$sc->vars["team_away"]]->vars["team_id"];?>
		 <? $rot = $rotations[$rot_key]["awayrotationnumber"]; ?>
		 <? $line_key = $sc->vars["date"]."_1st Half_".$rot;?>
		 <? $spread = ""; $spread = $lines[$line_key][$str_team."_spread"]; ?>
		 <? $money = ""; $money = $lines[$line_key][$str_team."_money"]; ?>
		 <? $total = ""; $total = $lines[$line_key][$str_team."_total"]; ?>          
		 <td name ="lines"class="table_td<? echo $style ?>_yellow first" align="center"><? echo $spread ?></td>   
		 <td name ="lines"class="table_td<? echo $style ?>_yellow first" align="center"><? if($spread) { $result = check_line($str_team, $sc->vars["first_away_points"],$sc->vars["first_home_points"],$spread,'spread'); $status = $result[0]; $result[0] = ""; if($status == '+'){ $f_spread++; } if($status == '-'){ $f_l_spread++; } if($status == '='){ $f_p_spread++; }  echo $result;  } ?></td>   
		 <td name ="lines"class="table_td<? echo $style ?>_yellow first" align="center"><? echo $money ?></td>   
		 <td name ="lines"class="table_td<? echo $style ?>_yellow first" align="center"><? if($money) {$result = check_line($str_team, $sc->vars["first_away_points"],$sc->vars["first_home_points"],$spread,'money'); $status = $result[0]; $result[0] = ""; if($status == '+'){ $f_money++; } if($status == '-'){ $f_l_money++; } if($status == '='){ $f_p_money++;  } echo $result;  } ?></td>   
		 <td name ="lines"class="table_td<? echo $style ?>_yellow first" align="center"><? echo $total ?></td>   
		 <td name ="lines"class="table_td<? echo $style ?>_yellow first" align="center"><? if($total) { $result = check_line($str_team, $sc->vars["first_away_points"],$sc->vars["first_home_points"],$total,'total'); $status = $result[0]; $result[0] = ""; if($status == '+'){ $f_total++; } if($status == '-'){ $f_l_total++; } if($status == '='){ $f_p_total++; }  echo $result;  } ?></td>    
		 
		  <td  name ="lines" class="table_td<? echo $style ?>_blue second" align="center"><? echo $sc->vars["second_away_points"]." - ".$sc->vars["second_home_points"] ?></td>     
		 <? $rot_key = $sc->vars["date"]."_".$teams[$sc->vars["team_away"]]->vars["team_id"];?>
		 <? $rot = $rotations[$rot_key]["awayrotationnumber"]; ?>
		 <? $line_key = $sc->vars["date"]."_2nd Half_".$rot;?>
		 <? $spread = ""; $spread = $lines[$line_key][$str_team."_spread"]; ?>
		 <? $money = ""; $money = $lines[$line_key][$str_team."_money"]; ?>
		 <? $total = ""; $total = $lines[$line_key][$str_team."_total"]; ?>          
		 <td name ="lines"class="table_td<? echo $style ?>_blue second" align="center"><? echo $spread ?></td>   
		 <td name ="lines"class="table_td<? echo $style ?>_blue second" align="center"><? if($spread) { $result =check_line($str_team, $sc->vars["second_away_points"],$sc->vars["second_home_points"],$spread,'spread'); $status = $result[0]; $result[0] = ""; if($status == '+'){ $s_spread++; } if($status == '-'){ $s_l_spread++; } if($status == '='){ $s_p_spread++; } echo $result; } ?></td>   
		 <td name ="lines"class="table_td<? echo $style ?>_blue second" align="center"><? echo $money ?></td>   
		 <td name ="lines"class="table_td<? echo $style ?>_blue second" align="center"><? if($money) { $result = check_line($str_team, $sc->vars["second_away_points"],$sc->vars["second_home_points"],$spread,'money'); $status = $result[0]; $result[0] = ""; if($status == '+'){ $s_money++; } if($status == '-'){ $s_l_money++; } if($status == '='){ $s_p_money++;  }  echo $result;  } ?></td>   
		 <td name ="lines"class="table_td<? echo $style ?>_blue second" align="center"><? echo $total ?></td>   
		 <td name ="lines"class="table_td<? echo $style ?>_blue second" align="center"><? if($total) { $result = check_line($str_team, $sc->vars["second_away_points"],$sc->vars["second_home_points"],$total,'total'); $status = $result[0]; $result[0] = ""; if($status == '+'){ $s_total++; }if($status == '-'){ $s_l_total++; } if($status == '='){ $s_p_total++; }  echo $result;  } ?></td>  
		 
		 
		
		 <? /// Other GAMES ?>
		  
		 <td class="table_td<? echo $style ?> other" align="center" id="other1_<? echo $i ?>"><? if($i<$days-1){ echo "-";} else {echo $rest_days; }?></td>  
		
		 <td class="table_td<? echo $style ?> other" align="center" id="other2_<? echo $i ?>"><? if($i<$days-1){ echo "-";} else {echo $away_days;}?></td>               
		 <td class="table_td<? echo $style ?> other" align="center" id="other3_<? echo $i ?>"><? if($i<$days-1){ echo "-";} else {echo get_nba_team_travel_info($schedule,$dist_team,$st,$i,$days,'miles');}?></td>               
		 <? /* if ($away_days >= $days){?><script>color_row('other','<? echo $i?>','<? echo $style ?>');</script><? } */ ?>        					   
	 
	
	   </tr> 
	  <?  } 
	  $i++;
	   } ?>
      <tr>
		<td class="table_td<? echo $style ?> other" align="center"></td>
		<td class="table_td<? echo $style ?> other" align="center"></td>
		<td class="table_td<? echo $style ?> other" align="center"></td>
		<td class="table_td<? echo $style ?> other" align="center"> <strong># Games: </strong><? echo $valid ?>
         <? if($valid == 0){ ?>
		<script>
		  hide_div_team('<? echo $teams[$st]->vars["id"]?>');
		</script>
        <? } ?>
        </td>
        <td class="table_td<? echo $style ?> other" align="center"></td>
        <td class="table_td<? echo $style ?> other" align="center"><? echo $g_result ?><span style="font-size:12px;color:Green"><strong>W</strong></span>/<? echo $g_l_result ?><span style="font-size:12px;color:red"><strong>L</strong></span></td>
		<td class="table_td<? echo $style ?>_blue game " align="center"><? if($valid){ echo number_format((100*$g_result/$valid),2); } ?>%<span style="font-size:14px;color:Green"><strong>W</strong></span></td>
		<td class="table_td<? echo $style ?>_blue game " align="center"><? echo $g_spread ?><span style="font-size:12px;color:Green"><strong>W</strong></span>/<? echo $g_l_spread ?><span style="font-size:12px;color:red"><strong>L</strong></span>/<? echo $g_p_spread ?><span style="font-size:12px;color:Gray"><strong>P</strong></span></td> 
		<td class="table_td<? echo $style ?>_blue game " align="center"><? if($valid){ echo number_format((100*$g_spread/$valid),2); } ?>%<span style="font-size:14px;color:Green"><strong>W</strong></span></td>
		<td class="table_td<? echo $style ?>_blue game " align="center"><? echo $g_money ?><span style="font-size:12px;color:Green"><strong>W</strong></span>/<? echo $g_l_money ?><span style="font-size:12px;color:red"><strong>L</strong></span>/<? echo $g_p_money ?><span style="font-size:12px;color:Gray"><strong>P</strong></span></td> 
		<td class="table_td<? echo $style ?>_blue game " align="center"><? if($valid){ echo number_format((100*$g_money/$valid),2); } ?>%<span style="font-size:14px;color:Green"><strong>W</strong></span></td>
		<td class="table_td<? echo $style ?>_blue game " align="center"><? echo $g_total ?><span style="font-size:12px;color:Green"><strong>W</strong></span>/<? echo $g_l_total ?><span style="font-size:12px;color:red"><strong>L</strong></span>/<? echo $g_p_total ?><span style="font-size:12px;color:Gray"><strong>P</strong></span></td> 
		<td class="table_td<? echo $style ?>_blue game " align="center"><? if($valid){ echo number_format((100*$g_total/$valid),2); } ?>%<span style="font-size:14px;color:Green"><strong>W</strong></span></td>                        
		<td class="table_td<? echo $style ?>_yellow first " align="center"></td>        
		<td class="table_td<? echo $style ?>_blue game " align="center"><? echo $f_spread ?><span style="font-size:12px;color:Green"><strong>W</strong></span>/<? echo $f_l_spread ?><span style="font-size:12px;color:red"><strong>L</strong></span>/<? echo $f_p_spread ?><span style="font-size:12px;color:Gray"><strong>P</strong></span></td>      
		<td class="table_td<? echo $style ?>_yellow first " align="center"><? if($valid){ echo number_format((100*$f_spread/$valid),2); } ?>%<span style="font-size:14px;color:Green"><strong>W</strong></span></td>        
		<td class="table_td<? echo $style ?>_blue game " align="center"><? echo $f_money ?><span style="font-size:12px;color:Green"><strong>W</strong></span>/<? echo $f_l_money ?><span style="font-size:12px;color:red"><strong>L</strong></span>/<? echo $f_p_money ?><span style="font-size:12px;color:Gray"><strong>P</strong></span></td>                                
		<td class="table_td<? echo $style ?>_yellow first " align="center"><? if($valid){ echo number_format((100*$f_money/$valid),2); } ?>%<span style="font-size:14px;color:Green"><strong>W</strong></span></td>                                
			<td class="table_td<? echo $style ?>_blue game " align="center"><? echo $f_total ?><span style="font-size:12px;color:Green"><strong>W</strong></span>/<? echo $f_l_total ?><span style="font-size:12px;color:red"><strong>L</strong></span>/<? echo $f_p_total ?><span style="font-size:12px;color:Gray"><strong>P</strong></span></td>                               
		<td class="table_td<? echo $style ?>_yellow first " align="center"><? if($valid){ echo number_format((100*$f_total/$valid),2); } ?>%<span style="font-size:14px;color:Green"><strong>W</strong></span></td>                                                        
		<td class="table_td<? echo $style ?>_blue second " align="center"></td>
		<td class="table_td<? echo $style ?>_blue game " align="center"><? echo $s_spread ?><span style="font-size:12px;color:Green"><strong>W</strong></span>/<? echo $s_l_spread ?><span style="font-size:12px;color:red"><strong>L</strong></span>/<? echo $s_p_spread ?><span style="font-size:12px;color:Gray"><strong>P</strong></span></td>      
		<td class="table_td<? echo $style ?>_blue second " align="center"><? if($valid){ echo number_format((100*$s_spread/$valid),2); } ?>%<span style="font-size:14px;color:Green"><strong>W</strong></span></td>
		<td class="table_td<? echo $style ?>_blue game " align="center"><? echo $s_money ?><span style="font-size:12px;color:Green"><strong>W</strong></span>/<? echo $s_l_money ?><span style="font-size:12px;color:red"><strong>L</strong></span>/<? echo $s_p_money ?><span style="font-size:12px;color:Gray"><strong>P</strong></span></td>     
		<td class="table_td<? echo $style ?>_blue second " align="center"><? if($valid){ echo number_format((100*$s_money/$valid),2); } ?>%<span style="font-size:14px;color:Green"><strong>W</strong></span></td>
			<td class="table_td<? echo $style ?>_blue game " align="center"><? echo $s_total ?><span style="font-size:12px;color:Green"><strong>W</strong></span>/<? echo $s_l_total ?><span style="font-size:12px;color:red"><strong>L</strong></span>/<? echo $s_p_total ?><span style="font-size:12px;color:Gray"><strong>P</strong></span></td>     
		<td class="table_td<? echo $style ?>_blue second " align="center"><? if($valid){ echo number_format((100*$s_total/$valid),2); } ?>%<span style="font-size:14px;color:Green"><strong>W</strong></span></td>                        

		<td class="table_td<? echo $style ?> other" align="center"></td>
		<td class="table_td<? echo $style ?> other" align="center"></td>
		<td class="table_td<? echo $style ?> other" align="center"></td>
	  </tr> 
	  
	  <tr>
		<td class="table_last"></td>
		<td class="table_last"></td>
		<td class="table_last"></td>
		<td class="table_last"></td>
        <td class="table_last"></td>
		<td class="table_last"></td>
		<td class="table_last"></td>
		<td class="table_last"></td>        
	  </tr>
	 
	 </table>
	 <BR><BR>
	</div>
	
    
   <? } ?> 

<? } ?>


</div>
</div>
<? include "../../includes/footer.php" ?>

 
 
<?

if(!$game){?><script>show_hide_column( 'tbl_sch', 'game')</script> <? }
if(!$first){?><script>show_hide_column( 'tbl_sch', 'first')</script> <? }
if(!$second){?><script>show_hide_column( 'tbl_sch', 'second')</script> <? }

?>
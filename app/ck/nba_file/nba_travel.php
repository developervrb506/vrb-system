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
<script type="text/javascript" src="<?= BASE_URL ?>/ck/includes/js/jquery-1.8.0.min.js"></script>
<script type="text/javascript">
Shadowbox.init();

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

</script>
</head>
<body>
<? $page_style = " width:3500px;"; ?>
<? include "../../includes/header.php" ?>
<? include "../../includes/menu_ck.php" ?>
<div class="page_content" style="padding-left:50px;">
<img src="images/NBA.png" style="width:60px; margin-bottom:-20px"><span class="page_title">TEAMS TRAVEL INFO</span><br /><br /><br />
<?	

if($current_clerk->vars['id'] != 86 ){
	$subject = 'NBA FILE ACCESS';
	$content = "User: ".$current_clerk->vars['name']." IP: ".get_ip()." Date checked. ".$from;
	
	send_email_ck('aandrade@inspin.com', $subject, $content, true, $current_clerk->vars["fake_email"]);
}

$team = param("team");

$four = param("four");
$five = param("five");
$six = param("six");
$seven = param("seven");
$eigth = param("eigth");
$nine = param("nine");
$ten = param("ten");
$other = param("other");
$game = param("game");
$first = param("first");
$second = param("second");

$season = $_POST["season"];
$teams = get_nba_teams("id");
$i=0;

if($team != ""){
  $dist_team = get_nba_all_teams_distance();	
} else{
  $four = $five = $six = $seven = $eigth = $nine = $ten = $game = $first = $second = 1;	
}

?>
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
  &nbsp;&nbsp;

 Team:&nbsp;
 <select name="team" onchange="send_form();">
  <option value="" >Choose a Team</option>
  <? foreach($teams as $t){ ?>
  <option <? if ($t->vars["id"]== $team){ echo ' selected="selected" ';}?>  value="<? echo $t->vars["id"]?>"><? echo $t->vars["team"]?></option>
  <? } ?>
 </select>
 &nbsp;&nbsp;<input type="submit" value="Search">&nbsp;&nbsp;&nbsp;&nbsp;
 GAMES:
 <table style="float:right; margin-right:2800px; margin-top:-40px">
 <tr>
 <td> <input name="four" id="four" type="checkbox" <? if($four) { echo ' checked="checked" ' ;}?> value="1" onchange=" show_hide_column( 'tbl_sch', 'four');"> 4 </td>
 <td> <input name="five" id="five"  type="checkbox" <? if($five) { echo ' checked="checked" ' ;}?> value="1" onchange="show_hide_column( 'tbl_sch', 'five');"> 5 </td>
 </tr>
 <tr>
<td>  <input name="six" id="six" type="checkbox" <? if($six) { echo ' checked="checked" ' ;}?> value="1" onchange="show_hide_column( 'tbl_sch', 'six');"> 6 </td>
<td>  <input name="seven" id="seven" type="checkbox" <? if($seven) { echo ' checked="checked" ' ;}?>  value="1" onchange="show_hide_column( 'tbl_sch', 'seven');"> 7 </td>
 </tr>
 <tr>
<td>  <input name="eigth" id="eigth" type="checkbox" <? if($eigth) { echo ' checked="checked" ' ;}?> value="1" onchange="show_hide_column( 'tbl_sch', 'eigth');"> 8 </td>
<td>  <input name="nine"  id="nine" type="checkbox" <? if($nine) { echo ' checked="checked" ' ;}?> value="1" onchange="show_hide_column( 'tbl_sch', 'nine');"> 9 </td>
 </tr>
 <tr>
<td>  <input name="ten" id="ten" type="checkbox" <? if($ten) { echo ' checked="checked" ' ;}?> value="1"onchange="show_hide_column( 'tbl_sch', 'ten');"> 10 </td>

<td>    <input name="other" name="id" type="number" style="width:30px" value="<? echo $other ?>" onchange="send_form();"> # </td>
 </tr>
</table>

&nbsp;&nbsp;&nbsp;&nbsp;

 <table style="float:right; margin-right:2650px; margin-top:-90px">
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
</form>
<BR><BR>

<? if($team != "") { ?>
<?
 $schedule =  get_nba_schedule_by_team($team,$season);
 $total_sch = count($schedule);
 $rotations = get_awayrotations_between_dates('nba',$schedule[0]->vars["date"],$schedule[$total_sch-1]->vars["date"]);
 $lines =  get_league_lines_between_dates('NBA',$schedule[0]->vars["date"],$schedule[$total_sch-1]->vars["date"]);
echo "<pre>";
//  print_r($rotations);
// print_r($lines);
echo "</pre>";
 

?>


<table id="tbl_sch" border="0" cellspacing="0" cellpadding="0">
  <tr>
  	<td class="table_header" align="center" width="80px">Date</td>
    <td class="table_header" align="center" width="120px">Team 1</td>
    <td class="table_header" align="center" width="25px"></td>    
    <td class="table_header" align="center" width="172px">Team 2</td> 
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
    
         
    <td class="table_header" align="center"   title="Rest Days" width="40px">(3G)  Days</td>  
    <td class="table_header" align="center"   title="Games as Away" width="40px">(3G) AWAY</td>
    <td class="table_header " align="center"  title="Total Miles RoadTrip" width="40px">(3G) MILES</td>             

    <td class="table_header four" align="center"  title="Rest Days" width="40px">(4G)  Days</td>  
    <td class="table_header four" align="center"  title="Games as Away" width="40px">(4G) AWAY</td>
    <td class="table_header four" align="center"  title="Total Miles RoadTrip" width="40px">(4G) MILES</td>                 

    <td class="table_header five" align="center"  title="Rest Days" width="40px">(5G)  Days</td>  
    <td class="table_header five" align="center"  title="Games as Away" width="40px">(5G) AWAY</td>
    <td class="table_header five" align="center"  title="Total Miles RoadTrip" width="40px">(5G) MILES</td>   
    
    <td class="table_header six" align="center"  title="Rest Days" width="40px">(6G)  Days</td>  
    <td class="table_header six" align="center"  title="Games as Away" width="40px">(6G) AWAY</td>
    <td class="table_header six" align="center"  title="Total Miles RoadTrip" width="40px">(6G) MILES</td>                 
    
    <td class="table_header seven" align="center"  title="Rest Days" width="40px">(7G)  Days</td>  
    <td class="table_header seven" align="center"  title="Games as Away" width="40px">(7G) AWAY</td>
    <td class="table_header seven" align="center"  title="Total Miles RoadTrip" width="40px">(7G) MILES</td>   
    
    <td class="table_header eigth" align="center"  title="Rest Days" width="40px">(8G)  Days</td>  
    <td class="table_header eigth" align="center"  title="Games as Away" width="40px">(8G) AWAY</td>
    <td class="table_header eigth" align="center"  title="Total Miles RoadTrip" width="40px">(8G) MILES</td>   

    <td class="table_header nine" align="center"  title="Rest Days" width="40px">(9G)  Days</td>  
    <td class="table_header nine" align="center"  title="Games as Away" width="40px">(9G) AWAY</td>
    <td class="table_header nine" align="center"  title="Total Miles RoadTrip" width="40px">(9G) MILES</td>   
    
    <td class="table_header ten" align="center"  title="Rest Days" width="40px">(10G)  Days</td>  
    <td class="table_header ten" align="center"  title="Games as Away" width="40px">(10G) AWAY</td>
    <td class="table_header ten" align="center"  title="Total Miles RoadTrip" width="40px">(10G) MILES</td>   
    
    <? if ($other) {?>    
    <td class="table_header other" align="center"  title="Rest Days" width="40px">(<? echo $other ?>G)  Days</td>  
    <td class="table_header other" align="center"  title="Games as Away" width="40px">(<? echo $other ?>G) AWAY</td>
    <td class="table_header other" align="center"  title="Total Miles RoadTrip" width="40px">(<? echo $other ?>G) MILES</td>   
    <? } ?>
    
    


  </tr>
 <? $away = false; $away_total = 0;$team2=0;
    
 foreach ($schedule as $sc){  if($i % 2){
	  $style = "1";}else{$style = "2";} ?>

   <tr>
     <td class="table_td<? echo $style ?>" align="center"><? echo $sc->vars["date"]?></td>
     <td class="table_td<? echo $style ?>" align="center"><? echo $teams[$team]->vars["team"]?></td>
     <td class="table_td<? echo $style ?>" align="center"><? if($sc->vars["team_home"] == $team){ echo 'VS'; $away = false;  $team2 = $sc->vars["team_away"]; $str_team = "home"; }else { echo '@'; $away = true; $away_total++; $team2 = $sc->vars["team_home"]; $str_team = 'away'; } ?></td>  
     <td class="table_td<? echo $style ?>" ><img style="width:25px" src="<?= BASE_URL ?>/ck/nba_file/images/<? echo $teams[$team2]->vars["logo"]?>.png">
	  &nbsp;&nbsp; <?  echo $teams[$team2]->vars["team"] ?></td>   
     <td class="table_td<? echo $style ?>" align="center"><? if($sc->vars["team_winner"]) { if($sc->vars["team_winner"] == $team  ){ echo '<span style="font-size:16px;color:Green"><strong>W</strong></span>'; } else { echo '<span style="font-size:16px;color:Red"><strong>L</strong></span>';} }  ?></td>          
     <td  name ="lines" class="table_td<? echo $style ?>_blue game" align="center"><? echo $sc->vars["away_points"]." - ".$sc->vars["home_points"] ?></td>     
 
     <? $rot_key = $sc->vars["date"]."_".$teams[$sc->vars["team_away"]]->vars["team_id"];?>
     <? $rot = $rotations[$rot_key]["awayrotationnumber"]; ?>
     <? $line_key = $sc->vars["date"]."_Game_".$rot;?>
     <? $spread = ""; $spread = $lines[$line_key][$str_team."_spread"]; ?>
     <? $money = ""; $money = $lines[$line_key][$str_team."_money"]; ?>
     <? $total = ""; $total = $lines[$line_key][$str_team."_total"]; ?>          
     <td name ="lines"class="table_td<? echo $style ?>_blue game" align="center"><? echo $spread ?></td>   
     <td name ="lines"class="table_td<? echo $style ?>_blue game" align="center"><? if($spread) { echo check_line($str_team, $sc->vars["away_points"],$sc->vars["home_points"],$spread,'spread'); } ?></td>   
     <td name ="lines"class="table_td<? echo $style ?>_blue game" align="center"><? echo $money ?></td>   
     <td name ="lines"class="table_td<? echo $style ?>_blue game" align="center"><? if($money) { echo check_line($str_team, $sc->vars["away_points"],$sc->vars["home_points"],$spread,'money'); } ?></td>   
     <td name ="lines"class="table_td<? echo $style ?>_blue game" align="center"><? echo $total ?></td>   
     <td name ="lines"class="table_td<? echo $style ?>_blue game" align="center"><? if($total) { echo check_line($str_team, $sc->vars["away_points"],$sc->vars["home_points"],$total,'total'); } ?></td>    
     
     <td  name ="lines" class="table_td<? echo $style ?>_yellow first" align="center"><? echo $sc->vars["first_away_points"]." - ".$sc->vars["first_home_points"] ?></td>     
     <? $rot_key = $sc->vars["date"]."_".$teams[$sc->vars["team_away"]]->vars["team_id"];?>
     <? $rot = $rotations[$rot_key]["awayrotationnumber"]; ?>
     <? $line_key = $sc->vars["date"]."_1st Half_".$rot;?>
     <? $spread = ""; $spread = $lines[$line_key][$str_team."_spread"]; ?>
     <? $money = ""; $money = $lines[$line_key][$str_team."_money"]; ?>
     <? $total = ""; $total = $lines[$line_key][$str_team."_total"]; ?>          
     <td name ="lines"class="table_td<? echo $style ?>_yellow first" align="center"><? echo $spread ?></td>   
     <td name ="lines"class="table_td<? echo $style ?>_yellow first" align="center"><? if($spread) { echo check_line($str_team, $sc->vars["first_away_points"],$sc->vars["first_home_points"],$spread,'spread'); } ?></td>   
     <td name ="lines"class="table_td<? echo $style ?>_yellow first" align="center"><? echo $money ?></td>   
     <td name ="lines"class="table_td<? echo $style ?>_yellow first" align="center"><? if($money) { echo check_line($str_team, $sc->vars["first_away_points"],$sc->vars["first_home_points"],$spread,'money'); } ?></td>   
     <td name ="lines"class="table_td<? echo $style ?>_yellow first" align="center"><? echo $total ?></td>   
     <td name ="lines"class="table_td<? echo $style ?>_yellow first" align="center"><? if($total) { echo check_line($str_team, $sc->vars["first_away_points"],$sc->vars["first_home_points"],$total,'total'); } ?></td>    
     
      <td  name ="lines" class="table_td<? echo $style ?>_blue second" align="center"><? echo $sc->vars["second_away_points"]." - ".$sc->vars["second_home_points"] ?></td>     
     <? $rot_key = $sc->vars["date"]."_".$teams[$sc->vars["team_away"]]->vars["team_id"];?>
     <? $rot = $rotations[$rot_key]["awayrotationnumber"]; ?>
     <? $line_key = $sc->vars["date"]."_2nd Half_".$rot;?>
     <? $spread = ""; $spread = $lines[$line_key][$str_team."_spread"]; ?>
     <? $money = ""; $money = $lines[$line_key][$str_team."_money"]; ?>
     <? $total = ""; $total = $lines[$line_key][$str_team."_total"]; ?>          
     <td name ="lines"class="table_td<? echo $style ?>_blue second" align="center"><? echo $spread ?></td>   
     <td name ="lines"class="table_td<? echo $style ?>_blue second" align="center"><? if($spread) { echo check_line($str_team, $sc->vars["second_away_points"],$sc->vars["second_home_points"],$spread,'spread'); } ?></td>   
     <td name ="lines"class="table_td<? echo $style ?>_blue second" align="center"><? echo $money ?></td>   
     <td name ="lines"class="table_td<? echo $style ?>_blue second" align="center"><? if($money) { echo check_line($str_team, $sc->vars["second_away_points"],$sc->vars["second_home_points"],$spread,'money'); } ?></td>   
     <td name ="lines"class="table_td<? echo $style ?>_blue second" align="center"><? echo $total ?></td>   
     <td name ="lines"class="table_td<? echo $style ?>_blue second" align="center"><? if($total) { echo check_line($str_team, $sc->vars["second_away_points"],$sc->vars["second_home_points"],$total,'total'); } ?></td>  
     
     
     
     
     
     <? /// 3 GAMES ?>
	 <? $days = 3 ; ?>  
     <td class="table_td<? echo $style ?>" align="center" id="three1_<? echo $i ?>"><? if($i<$days-1){ echo "-";} else {echo get_nba_team_travel_info($schedule,$dist_team,$team,$i,$days,'restdays');}?></td>  
     <? $away_days = get_nba_team_travel_info($schedule,$dist_team,$team,$i,$days,'away') ?> 
     <td class="table_td<? echo $style ?>" align="center" id="three2_<? echo $i ?>"><? if($i<$days-1){ echo "-";} else {echo $away_days;}?></td>               
   	 <td class="table_td<? echo $style ?>" align="center" id="three3_<? echo $i ?>"><? if($i<$days-1){ echo "-";} else {echo get_nba_team_travel_info($schedule,$dist_team,$team,$i,$days,'miles');}?></td>               
     <? if ($away_days >= $days){?><script>color_row('three','<? echo $i?>','<? echo $style ?>');</script><? } ?>        					   

    <? /// 4 GAMES ?>
  
	 <? $days = 4 ;  ?>  
     <td  class="table_td<? echo $style ?> four" align="center" id="four1_<? echo $i ?>"><? if($i<$days-1){ echo "-";} else {echo get_nba_team_travel_info($schedule,$dist_team,$team,$i,$days,'restdays');}?></td>  
     <? $away_days = get_nba_team_travel_info($schedule,$dist_team,$team,$i,$days,'away') ?> 
     <td  class="table_td<? echo $style ?> four" align="center" id="four2_<? echo $i ?>"><? if($i<$days-1){ echo "-";} else {echo $away_days;}?></td>               
   	 <td  class="table_td<? echo $style ?> four" align="center" id="four3_<? echo $i ?>"><? if($i<$days-1){ echo "-";} else {echo get_nba_team_travel_info($schedule,$dist_team,$team,$i,$days,'miles');}?></td>               
     <? if ($away_days >= $days){?><script>color_row('four','<? echo $i?>','<? echo $style ?>');</script><? } ?>        					   
  
     
     <? /// 5 GAMES ?>
	 <? $days = 5 ; ?>  
     <td class="table_td<? echo $style ?> five" align="center" id="five1_<? echo $i ?>"><? if($i<$days-1){ echo "-";} else {echo get_nba_team_travel_info($schedule,$dist_team,$team,$i,$days,'restdays');}?></td>  
     <? $away_days = get_nba_team_travel_info($schedule,$dist_team,$team,$i,$days,'away') ?> 
     <td class="table_td<? echo $style ?> five" align="center" id="five2_<? echo $i ?>"><? if($i<$days-1){ echo "-";} else {echo $away_days;}?></td>               
   	 <td class="table_td<? echo $style ?> five" align="center" id="five3_<? echo $i ?>"><? if($i<$days-1){ echo "-";} else {echo get_nba_team_travel_info($schedule,$dist_team,$team,$i,$days,'miles');}?></td>               
     <? if ($away_days >= $days){?><script>color_row('five','<? echo $i?>','<? echo $style ?>');</script><? } ?>        					   

     <? /// 6 GAMES ?>
	 <? $days = 6 ; ?>  
     <td class="table_td<? echo $style ?> six" align="center" id="six1_<? echo $i ?>"><? if($i<$days-1){ echo "-";} else {echo get_nba_team_travel_info($schedule,$dist_team,$team,$i,$days,'restdays');}?></td>  
     <? $away_days = get_nba_team_travel_info($schedule,$dist_team,$team,$i,$days,'away') ?> 
     <td class="table_td<? echo $style ?> six" align="center" id="six2_<? echo $i ?>"><? if($i<$days-1){ echo "-";} else {echo $away_days;}?></td>               
   	 <td class="table_td<? echo $style ?> six" align="center" id="six3_<? echo $i ?>"><? if($i<$days-1){ echo "-";} else {echo get_nba_team_travel_info($schedule,$dist_team,$team,$i,$days,'miles');}?></td>               
     <? if ($away_days >= $days){?><script>color_row('six','<? echo $i?>','<? echo $style ?>');</script><? } ?>        					   

     <? /// 7 GAMES ?>
	 <? $days = 7 ; ?>  
     <td class="table_td<? echo $style ?> seven" align="center" id="seven1_<? echo $i ?>"><? if($i<$days-1){ echo "-";} else {echo get_nba_team_travel_info($schedule,$dist_team,$team,$i,$days,'restdays');}?></td>  
     <? $away_days = get_nba_team_travel_info($schedule,$dist_team,$team,$i,$days,'away') ?> 
     <td class="table_td<? echo $style ?> seven" align="center" id="seven2_<? echo $i ?>"><? if($i<$days-1){ echo "-";} else {echo $away_days;}?></td>               
   	 <td class="table_td<? echo $style ?> seven" align="center" id="seven3_<? echo $i ?>"><? if($i<$days-1){ echo "-";} else {echo get_nba_team_travel_info($schedule,$dist_team,$team,$i,$days,'miles');}?></td>               
     <? if ($away_days >= $days){?><script>color_row('seven','<? echo $i?>','<? echo $style ?>');</script><? } ?>        					   

     <? /// 8 GAMES ?>
	 <? $days = 8 ; ?>  
     <td class="table_td<? echo $style ?> eigth" align="center" id="eigth1_<? echo $i ?>"><? if($i<$days-1){ echo "-";} else {echo get_nba_team_travel_info($schedule,$dist_team,$team,$i,$days,'restdays');}?></td>  
     <? $away_days = get_nba_team_travel_info($schedule,$dist_team,$team,$i,$days,'away') ?> 
     <td class="table_td<? echo $style ?> eigth" align="center" id="eigth2_<? echo $i ?>"><? if($i<$days-1){ echo "-";} else {echo $away_days;}?></td>               
   	 <td class="table_td<? echo $style ?> eigth" align="center" id="eigth3_<? echo $i ?>"><? if($i<$days-1){ echo "-";} else {echo get_nba_team_travel_info($schedule,$dist_team,$team,$i,$days,'miles');}?></td>               
     <? if ($away_days >= $days){?><script>color_row('eigth','<? echo $i?>','<? echo $style ?>');</script><? } ?>        					   

     <? /// 9 GAMES ?>
	 <? $days = 9 ; ?>  
     <td class="table_td<? echo $style ?> nine" align="center" id="nine1_<? echo $i ?>"><? if($i<$days-1){ echo "-";} else {echo get_nba_team_travel_info($schedule,$dist_team,$team,$i,$days,'restdays');}?></td>  
     <? $away_days = get_nba_team_travel_info($schedule,$dist_team,$team,$i,$days,'away') ?> 
     <td class="table_td<? echo $style ?> nine" align="center" id="nine2_<? echo $i ?>"><? if($i<$days-1){ echo "-";} else {echo $away_days;}?></td>               
   	 <td class="table_td<? echo $style ?> nine" align="center" id="nine3_<? echo $i ?>"><? if($i<$days-1){ echo "-";} else {echo get_nba_team_travel_info($schedule,$dist_team,$team,$i,$days,'miles');}?></td>               
     <? if ($away_days >= $days){?><script>color_row('nine','<? echo $i?>','<? echo $style ?>');</script><? } ?>        					   
     
     <? /// 10 GAMES ?>
	 <? $days = 10 ; ?>  
     <td class="table_td<? echo $style ?> ten" align="center" id="ten1_<? echo $i ?>"><? if($i<$days-1){ echo "-";} else {echo get_nba_team_travel_info($schedule,$dist_team,$team,$i,$days,'restdays');}?></td>  
     <? $away_days = get_nba_team_travel_info($schedule,$dist_team,$team,$i,$days,'away') ?> 
     <td class="table_td<? echo $style ?> ten" align="center" id="ten2_<? echo $i ?>"><? if($i<$days-1){ echo "-";} else {echo $away_days;}?></td>               
   	 <td class="table_td<? echo $style ?> ten" align="center" id="ten3_<? echo $i ?>"><? if($i<$days-1){ echo "-";} else {echo get_nba_team_travel_info($schedule,$dist_team,$team,$i,$days,'miles');}?></td>               
     <? if ($away_days >= $days){?><script>color_row('ten','<? echo $i?>','<? echo $style ?>');</script><? } ?>        					   
     
     <? if($other) { ?>
     <? /// Other GAMES ?>
	 <? $days = $other ; ?>  
     <td class="table_td<? echo $style ?> other" align="center" id="other1_<? echo $i ?>"><? if($i<$days-1){ echo "-";} else {echo get_nba_team_travel_info($schedule,$dist_team,$team,$i,$days,'restdays');}?></td>  
     <? $away_days = get_nba_team_travel_info($schedule,$dist_team,$team,$i,$days,'away') ?> 
     <td class="table_td<? echo $style ?> other" align="center" id="other2_<? echo $i ?>"><? if($i<$days-1){ echo "-";} else {echo $away_days;}?></td>               
   	 <td class="table_td<? echo $style ?> other" align="center" id="other3_<? echo $i ?>"><? if($i<$days-1){ echo "-";} else {echo get_nba_team_travel_info($schedule,$dist_team,$team,$i,$days,'miles');}?></td>               
     <? if ($away_days >= $days){?><script>color_row('other','<? echo $i?>','<? echo $style ?>');</script><? } ?>        					   

     
     <? } ?>
     

   </tr> 
  <? $i++; } ?>
  <tr>
    <td class="table_last"></td>
    <td class="table_last"></td>
    <td class="table_last"></td>
    <td class="table_last"></td>
  </tr>
 
 </table>


<? } ?>

</div>
<? include "../../includes/footer.php" ?>

 
 
<?
 
if(!$four){?><script>show_hide_column( 'tbl_sch', 'four')</script> <? }
if(!$five){?><script>show_hide_column( 'tbl_sch', 'five')</script> <? }
if(!$six){?><script>show_hide_column( 'tbl_sch', 'six')</script> <? }
if(!$seven){?><script>show_hide_column( 'tbl_sch', 'seven')</script> <? }
if(!$eigth){?><script>show_hide_column( 'tbl_sch', 'eigth')</script> <? }
if(!$nine){?><script>show_hide_column( 'tbl_sch', 'nine')</script> <? }
if(!$ten){?><script>show_hide_column( 'tbl_sch', 'ten')</script> <? }
if(!$game){?><script>show_hide_column( 'tbl_sch', 'game')</script> <? }
if(!$first){?><script>show_hide_column( 'tbl_sch', 'first')</script> <? }
if(!$second){?><script>show_hide_column( 'tbl_sch', 'second')</script> <? }

?>
<? include(ROOT_PATH . "/ck/process/security.php"); ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../../css/style.css" rel="stylesheet" type="text/css" />
<title>Jobs Manager</title>
<script type="text/javascript" src="http://localhost:8080/process/js/functions.js"> </script>
</head>
<body>
<?
  $leagues = array("mlb","nfl","nba","nhl","ncaaf","ncaab");
  $url1 = "http://espn.go.com/";
  $url2 = "/schedule?date="; // date=20150723
  $books = get_all_events_books(0,1);
  
  if (isset($_POST["gameid"])){

   	$gameid = $_POST["gameid"];
	$hour = $_POST["hour"];
	$min = $_POST["minute"];
	$date = $_POST["date"];
	
	if (strlen($hour) == 1){ $hour = "0".$hour; }
	if (strlen($min) == 1){ $min = "0".$min; }
	$new = $date." ".$hour.":".$min.":00";
	$game = get_sbo_game($gameid);
	
	if (!is_null($game)){
	  $game->vars["startdate"] = $new;	
	  $game->update(array("startdate"));
	  $run = file_get_contents("http://www.sportsbettingonline.ag/utilities/jobs/espn_games/index.php");	
	}
	
	
	  
  }
  
  if (isset($_POST["id"])){

   	$id = $_POST["id"];
	$espn = $_POST["espn_id"];
	
	$game = get_espn_game($id);
		if (!is_null($game)){
		  $game->vars["espn_id"] = $espn;	
		  $game->update(array("espn_id"));
		  
		}
	
  }

?>
<? include "../../includes/header.php" ?>
<? include "../../includes/menu_ck.php" ?>
<div class="page_content" style="padding-left:50px;">
<span class="page_title">ESPN GAME ID <? echo $league ?></span><br /><br />

 <? foreach($leagues as $league) {?>
 
  <br /><br /><span class="page_title"> <? echo strtoupper($league) ?></span>&nbsp;&nbsp;&nbsp;<a  class="normal_link" target="_blank" href="<? echo $url1.$league.$url2.date("Ymd") ?>"> Check here the Schedule</a>
 
   <?
    $games = get_espn_games_pending($league);
   
   if(!empty($games)){
   ?>
   <table width="100%" border="0" cellspacing="0" cellpadding="0">

  <tr>
    <td class="table_header" align="center" ><strong>Game ID </strong></th>
    <td class="table_header" align="center" ><strong>Away Team</strong></th>
    <td class="table_header" align="center" ><strong>Home Team</strong></th>
    <td class="table_header" align="center" ><strong>Game Date</strong></th>
    <td class="table_header" align="center">Option 1. Adjust Time in ET</th> 
    <td class="table_header" align="center">Option 2. Add the Espn ID</th>   
  </tr>


   <?
  
   foreach( $games as $game){ 
   if($i % 2){$style = "1";}else{$style = "2";} $i++; 
   
   ?>
   <tr id="tr_<? echo $game->vars["id"] ?>">   	
        <th class="table_td<? echo $style ?>"><? echo $game->vars["gameid"]; ?></th>
		<th class="table_td<? echo $style ?>"><? echo $game->vars["away"]; ?></th>
        <th class="table_td<? echo $style ?>"><? echo $game->vars["home"]; ?></th>
        <th class="table_td<? echo $style ?>"><? echo $game->vars["game_date"]; ?></th>
        <th class="table_td<? echo $style ?>">
        <form method="post">
        <input type="hidden" name="gameid" value="<? echo $game->vars["gameid"] ?>">
         <input type="hidden" name="date" value="<? echo $game->vars["game_date"] ?>">
        H:<input style="width:40px" type="number" min="00" max="24" step="1" 
        value="<? echo  date('H',strtotime($game->vars["startdate"])); ?>" name="hour"> M:<input name="minute" type="number" value="<? echo  date('i',strtotime($game->vars["startdate"])); ?>" min="00" max="59" step="1" style="width:40px" >&nbsp;&nbsp;
        <input type="submit" value="Save">
        </form>
        </th>  
        <th class="table_td<? echo $style ?>">
         <form method="post">
         <input type="hidden" name="id" value="<? echo $game->vars["id"] ?>">
         <input style="width:100px" type="number" min="00"  name="espn_id">
        <input type="submit" value="Save">
        </form>
        </th> 
  </tr>
<? } ?>
 <tr>
    <td class="table_last"></td>
    <td class="table_last"></td>
    <td class="table_last"></td>
    <td class="table_last"></td>
    <td class="table_last"></td>
    <td class="table_last"></td>
    <td class="table_last"></td>

  </tr>
</table>
	
  <? } else { ?>
   
   <table width="100%" border="0" cellspacing="0" cellpadding="0">

  <tr>
    <td  colspan="5"class="table_header" align="center" ><strong>NO PENDINGS GAMES </strong></th>
    
  </tr> 
  </table>
   <? } ?>
 <? } ?>
</div>
<? include "../../includes/footer.php" ?>
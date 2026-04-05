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
  </head>
  <body>
  <? $page_style = " width:100%;"; ?>
  <? include "../../includes/header.php"  ?>
  <? include "../../includes/menu_ck.php"  ?>
  <? 
  
  //Post params
  $from = clean_get("from");
  $to =   clean_get("to");
   
  if($from == ""){ 
      $from = "2011-01-13";  // Database had this information.
	  $to = date( "Y-m-d", strtotime( "-1 day", strtotime(date( "Y-m-d")))); 
  }
  
  
  $stadiums = get_all_baseball_stadiums();
  
  ?>
  
  <div class="page_content" style="padding-left:10px;">
  <div align="right"><span ><a href="./baseball_reports.php">Back to Reports</a></span></div>
  <span class="page_title">First Time Pitcher by Stadium
  </span><br /><br />
  
  
  <form method="post">
      From: 
      <input name="from" type="text" id="from" value="<? echo $from ?>" />
      To: 
      <input name="to" type="text" id="to" value="<? echo $to ?>" /> 
      &nbsp;&nbsp;&nbsp;&nbsp;
      <br /><br />
      Stadium:  
      <? create_objects_list("stadium", "stadium", $stadiums, "team_id", "name", $default_name = "",$_POST["stadium"],"","_baseball_stadium");  ?>
       &nbsp;&nbsp;&nbsp;&nbsp;
     <select name="condition" id="condition">
       <option value=">" <? if ($_POST['condition'] == '>') { echo "selected"; } ?>>Over</option>
       <option value="<" <? if ($_POST['condition'] == '<') { echo "selected"; } ?>>Under</option>
     </select>
   <BR><BR>
       &nbsp;&nbsp;&nbsp;&nbsp;
     <input type="submit" value="Search" />
      
  <br /><br />
  </form>
<?
if (isset($_POST["stadium"])){ 
   
  $games_home = get_baseball_games_home_team($from,$to,$_POST["stadium"]);
  $lines_game = get_sport_lines_by_dates($from,$to, 'MLB', 'Game');
  $lines_innings = get_sport_lines_by_dates($from,$to, 'MLB', '1st 5 Innings');
  $lines_team = get_sport_team_lines_by_dates($from,$to, 'MLB'); 
  
  
  if ($_POST['condition'] == '>'){
    $higher = true;	 
  }
  else{
    $higher = false;	 	 
  }
  
   
   
  $pitchers = array();
  foreach ($games_home as $_game_home){
    if (!isset($pitchers[$_game_home->vars["pitcher_away"]])){
     $pitchers[$_game_home->vars["pitcher_away"]] = $_game_home->vars["id"];
    }	    
  }
?>
  <table id="baseball" width="100%" border="0" cellspacing="0" cellpadding="0">
   <tr>
	<td width="120"  class="table_header" >Date</td>
	<td  name ="game_info_" width="120"  class="table_header">Away</td>
	<td  name ="game_info_" width="60"  class="table_header">Pitcher</td>
  	<td  name ="game_info_" width="60"  class="table_header">Total Home 5st Inning</td>
  	<td  name ="game_info_" width="60"  class="table_header">Total Runs Inning</td>    
    <td  name ="game_info_" width="60"  class="table_header">Money Home Innings</td> 
    <td  name ="game_info_" width="60"  class="table_header">Result Game Innings</td>
    <td  name ="game_info_" width="60"  class="table_header">Balance</td>
    <td  name ="game_info_" width="60"  class="table_header">Innnings Line</td>
    <td  name ="game_info_" width="60"  class="table_header">Status</td>
    <td  name ="game_info_" width="60"  class="table_header">Balance</td>
    <td  name ="game_info_" width="60"  class="table_header">Total Home Runs</td>
	<td  name ="game_info_" width="60"  class="table_header">Total Game Runs</td>
   	<td  name ="game_info_" width="60"  class="table_header">Money Home Game</td>
    <td  name ="game_info_" width="60"  class="table_header">Result Game</td>
    <td  name ="game_info_" width="60"  class="table_header">Balance</td>
    <td  name ="game_info_" width="60"  class="table_header">Game Line</td>
    <td  name ="game_info_" width="60"  class="table_header">Status</td>
    <td  name ="game_info_" width="60"  class="table_header">Balance</td>
    <td  name ="game_info_" width="60"  class="table_header">Team Line</td>
    <td  name ="game_info_" width="60"  class="table_header">Status</td>
    <td  name ="game_info_" width="60"  class="table_header">Balance</td>

 
  	
   </tr>  
	
<?
  $h=0;
  $total_wins1 = 0;
  $total_wins2 = 0;
  $total_wins3 = 0;
  $total_wins4 = 0;
  $total_wins5 = 0;        
  foreach($pitchers as $_game ){
	
   	if($h % 2){$style = "1";}else{$style = "2";} $h++;		
    $game = get_baseball_game($_game); 

    $startdate =  date('Y-m-d',strtotime($game->vars["startdate"]));   
	$_date=$startdate;
   	$error_message = false;
	$valid_line = false;
	$day= date('M-d',strtotime($game->vars["startdate"]));
	$hour= date('H:i',strtotime($game->vars["startdate"]));
	$game_year = date('Y',strtotime($game->vars["startdate"]));
	$date = date('Y-m-d',strtotime($game->vars["startdate"]));
	$team_away = get_baseball_team($game->vars["team_away"]);
	$team_home = get_baseball_team($game->vars["team_home"]);
	$pitcher_away = get_player_pitches_by_game($game->vars["id"],$game->vars["pitcher_away"],"away");
	$pitcher_home = get_player_pitches_by_game($game->vars["id"],$game->vars["pitcher_home"],"home");
	$score = $game->vars["runs_away"] + $game->vars["runs_home"];
    $score_innings = get_score_by_inings($game->vars["id"],"5");
	//get_score($game->vars["id"],"5"); // % to obtaing the 5 Inning score
	//print_r($score_innings);
	$total_score_inning = $score_innings["away_score"] + $score_innings["home_score"];
	
	
  //Preparing Lines info.
  if ($higher){
	
   $team_line = $lines_team[$date." / ".$game->vars["away_rotation"]." / ".$game->vars["team_home"]]->vars["away_total"];
   $game_line = $lines_game[$date." / ".$game->vars["away_rotation"]]->vars["away_total"]; 
   $innning_line = $lines_innings[$date." / ".$game->vars["away_rotation"]]->vars["away_total"]; 
   $home_money_inning = $lines_innings[$date." / ".$game->vars["away_rotation"]]->vars["home_money"]; 
   $home_money_game = $lines_game[$date." / ".$game->vars["away_rotation"]]->vars["home_money"];
  }
  else{
  $team_line = $lines_team[$date." / ".$game->vars["away_rotation"]." / ".$game->vars["team_home"]]->vars["home_total"]; 
  $game_line = $lines_game[$date." / ".$game->vars["away_rotation"]]->vars["home_total"];  
  $innning_line = $lines_innings[$date." / ".$game->vars["away_rotation"]]->vars["home_total"]; 
  $home_money_inning = $lines_innings[$date." / ".$game->vars["away_rotation"]]->vars["home_money"]; 
  $home_money_game = $lines_game[$date." / ".$game->vars["away_rotation"]]->vars["home_money"];
  }

  // As the Juice for total team does not have sign + for positives this parche is needed.
  if($team_line){
    $sign = substr($team_line,-4,1);
    if ($sign != "-"){
      $juice= substr($team_line,-3,3);
      $pre_line = str_replace($juice,"",$team_line);
      $team_line= $pre_line."+".$juice;
    }
  }
 
   if ($home_money_game){	
   	$home_win_game = 0;  // 1 = WIN   2 = LOSE   3 = PUSH
    if ($game->vars["runs_away"] < $game->vars["runs_home"]){
     $home_win_game ="1_WIN";
	  $total_wins3++;
    } else if ($game->vars["runs_away"] == $game->vars["runs_home"]){
	  $home_win = "3_PUSH";
     } else { $home_win_game = "2_LOSE"; }
   }
   else { $home_win_inning = "3_NO LINE";}	 
	
  if ($home_money_inning){	
	$home_win_inning = 0;  // 1 = WIN   2 = LOSE   3 = PUSH
	  if ($score_innings["away_score"] < $score_innings["home_score"]){
     $home_win_inning ="1_WIN";
	 $total_wins1++;
      } else if ($score_innings["away_score"] == $score_innings["home_score"]){
	   $home_win_inning = "3_PUSH";
     } else { $home_win_inning = "2_LOSE"; }
  }
  else { $home_win_inning = "3_NO LINE";}
  
  
  
  
  
  $cleaned_team_line = prepare_line($team_line);
  $cleaned_line = prepare_line($game_line);
  $cleaned_inning_line = prepare_line($innning_line);
	
?>


	<tr>
	 <td class="table_td<? echo $style ?>" style="font-size:12px;"><? echo $day."-".substr($game_year,2,2)."  at   ".$hour ?></td> 
	 <td class="table_td<? echo $style ?>" style="font-size:12px;"><? echo $team_away->vars["team_name"];  ?></td> 
     <td class="table_td<? echo $style ?>" style="font-size:12px;"><? echo $pitcher_away->vars["player"] ?></td> 
     <td class="table_td<? echo $style ?>" style="font-size:12px;"><? echo $score_innings["home_score"] ?></td> 
     <td class="table_td<? echo $style ?>" style="font-size:12px;"><? echo $total_score_inning ?></td> 
     <td class="table_td<? echo $style ?>" style="font-size:12px;"><? echo $home_money_inning ?></td> 
     <td class="table_td<? echo $style ?>" style="font-size:12px;"><? echo substr($home_win_inning,2,8) ?></td> 
     <td class="table_td<? echo $style ?>" style="font-size:12px;">
      <?
	  $inning_money_balance =  get_baseball_money_balance($home_money_inning,$home_win_inning,$higher);
      echo number_format($inning_money_balance,2);
	  ?>
     </td> 
     <td class="table_td<? echo $style ?>" style="font-size:12px;"><? echo $innning_line ?></td> 
     <td class="table_td<? echo $style ?>" style="font-size:12px;">
     <?   $data_inning = get_baseball_line_process($higher,$innning_line,$cleaned_inning_line,$total_score_inning);
	         $pre_balance_inning = $data_inning["pre_balance"];
			 $status_inning = $data_inning["status"];
			  if ($status_inning == "WIN") { $total_wins2++;}
			 echo $status_inning;
				
	 ?> 
     </td> 
     <td class="table_td<? echo $style ?>" style="font-size:12px;"><?  echo number_format($pre_balance_inning,2)  ?></td> 
     <td class="table_td<? echo $style ?>" style="font-size:12px;"><? echo $game->vars["runs_home"] ?></td> 
     <td class="table_td<? echo $style ?>" style="font-size:12px;"><? echo $score ?></td> 
     <td class="table_td<? echo $style ?>" style="font-size:12px;"><? echo $home_money_game ?></td> 
     <td class="table_td<? echo $style ?>" style="font-size:12px;"><? echo substr($home_win_game,2,8) ?></td> 
     <td class="table_td<? echo $style ?>" style="font-size:12px;">
      <?
	  $game_money_balance =  get_baseball_money_balance($home_money_game,$home_win_game,$higher);
      echo number_format($game_money_balance,2);
	  ?>
     
     </td> 
      <td class="table_td<? echo $style ?>" style="font-size:12px;"><? echo $game_line ?></td> 
      <td class="table_td<? echo $style ?>" style="font-size:12px;">
       <? $data_game = get_baseball_line_process($higher,$game_line,$cleaned_line,$score);
	         $pre_balance_game = $data_game["pre_balance"];
			 $status_game = $data_game["status"];
			 if ($status_game == "WIN") { $total_wins4++;}
			 echo $status_game;
				
	   ?> 
      </td> 
     <td class="table_td<? echo $style ?>" style="font-size:12px;"><? echo number_format($pre_balance_game,2) ?></td> 
      <td class="table_td<? echo $style ?>" style="font-size:12px;"><? echo $team_line ?></td> 
     <td class="table_td<? echo $style ?>" style="font-size:12px;">
      <? $data_team = get_baseball_line_process($higher,$team_line,$cleaned_team_line,$game->vars["runs_home"]);
	         $pre_balance_team = $data_team["pre_balance"];
			 $status_team = $data_team["status"];
			 if ($status_team == "WIN") { $total_wins5++;}
			 echo $status_team;
				
     ?> 
     
     
     </td> 
     <td class="table_td<? echo $style ?>" style="font-size:12px;"><? echo number_format($pre_balance_team,2) ?></td> 
     
    
    
    </tr> 
    
    
    
		          
<?
  $total_line_inning = $total_line_inning + $pre_balance_inning; 
  $total_line_game = $total_line_game + $pre_balance_game; 
  $total_line_team = $total_line_team + $pre_balance_team; 
  $total_money_inning = $total_money_inning + $inning_money_balance;
  $total_money_game = $total_money_game + $game_money_balance;
  
  // break;
  } // Pitchers as game

 ?>
     
   <tr>
			  <td class="table_header"></td>
              <td class="table_header"></td>
			  <td class="table_header"></td>
			  <td class="table_header"></td>
              <td class="table_header"></td>
              <td class="table_header"></td>
			  <td class="table_header"><? echo number_format(($total_wins1 * 100 / $h ),2); ?><strong>% WIN</strong></td> 
              <td class="table_header"><? echo number_format($total_money_inning,2) ?></td>
              <td class="table_header"></td> 
			  <td class="table_header"><? echo number_format(($total_wins2 * 100 / $h ),2); ?><strong>% WIN</strong></td> 
              <td class="table_header"><? echo number_format($total_line_inning,2) ?></td> 
              <td class="table_header"></td> 
              <td class="table_header"></td> 
              <td class="table_header"></td> 
			  <td class="table_header"><? echo number_format(($total_wins3 * 100 / $h ),2); ?><strong>% WIN</strong></td> 
              <td class="table_header"><? echo number_format($total_money_game,2) ?></td> 
              <td class="table_header"></td> 
              <td class="table_header"><? echo number_format(($total_wins4 * 100 / $h ),2); ?><strong>% WIN</strong></td> 
              <td class="table_header"><? echo number_format($total_line_game,2) ?></td> 
              <td class="table_header"></td> 
              <td class="table_header"><? echo number_format(($total_wins5 * 100 / $h ),2); ?><strong>% WIN</strong></td> 
              <td class="table_header"><? echo number_format($total_line_team,2) ?></td> 
              
			 </tr>
			<tr>
			  <td class="table_last" colspan="100"></td>
			</tr>
  </table>
<?
 } // If POST.
?>
   
</div>
</body>

<? include "../../includes/footer.php" ?>
<? } else { echo "ACCESS DENIED"; }
?>


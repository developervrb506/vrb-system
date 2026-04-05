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
   <? $page_style = " width:1680px;"; ?>
  <? include "../../includes/header.php"  ?>
  <? include "../../includes/menu_ck.php"  ?>
  <? 
  
  //Post params
  $from = clean_get("from");
  $to =   clean_get("to");
   
  if($from == ""){ 
      $from = "2014-04-01";  
	  $to = date( "Y-m-d", strtotime( "-1 day", strtotime(date( "Y-m-d")))); 
  }
  
  
  
  ?>
  
  <div class="page_content" style="padding-left:10px;">
  <div align="right"><span ><a href="./baseball_reports.php">Back to Reports</a></span></div>
  <span class="page_title">Post Colorado Pitcher Report
  </span><br /><br />
  
  
  <form method="post">
      From: 
      <input name="from" type="text" id="from" value="<? echo $from ?>" />
      To: 
      <input name="to" type="text" id="to" value="<? echo $to ?>" /> 
     &nbsp;&nbsp;&nbsp;&nbsp;
     <select name="condition" id="condition">
       <option value=">" <? if ($_POST['condition'] == '>') { echo "selected"; } ?>>Over</option>
       <option value="<" <? if ($_POST['condition'] == '<') { echo "selected"; } ?>>Under</option>
     </select>
   <BR><BR>
    Less Than  : 
      <input  style="width:50px" name="rest" type="text" id="test" value="<? echo $_POST["rest"] ?>" /> Rest Days. 
     
       &nbsp;&nbsp;&nbsp;&nbsp;
     <input type="submit" value="Search" />
      
  <br /><br />
  </form>
<?
if (isset($_POST["from"])){ 
   
  $next_to = date( "Y-m-d", strtotime( "7 day", strtotime(date($to)))); 
  $games_home = get_baseball_games_home_team($from,$to,58);
  $lines_game = get_sport_lines_by_dates($from,$next_to, 'MLB', 'Game');
  $lines_innings = get_sport_lines_by_dates($from,$next_to, 'MLB', '1st 5 Innings');
  $lines_team = get_sport_team_lines_by_dates($from,$next_to, 'MLB'); 
  echo "<pre>";
  //print_r($games_home);
  echo "</pre>" ; 
  if ($_POST['condition'] == '>'){
    $higher = true;	 
  }
  else{
    $higher = false;	 	 
  }
  
   
   
  $pitchers = array();
  foreach ($games_home as $_game_home){
    //if (!isset($pitchers[$_game_home->vars["pitcher_away"]])){
     $pitchers[$_game_home->vars["pitcher_away"]]["game"] = $_game_home->vars["id"];
	  $pitchers[$_game_home->vars["pitcher_away"]]["pitcher"] = $_game_home->vars["pitcher_away"];
	   $pitchers[$_game_home->vars["pitcher_away"]]["startdate"] = $_game_home->vars["startdate"];
   // }	    
  }
  
  echo "<pre>";
  //print_r($pitchers); 
 $j=0;
  foreach ($pitchers as $_pitchers){
   $game =  get_baseball_games_next_game_player($_pitchers["pitcher"],$_pitchers["startdate"]);	  
   if (!is_null($game)){
    $game->vars["pitcher"] = $_pitchers["pitcher"];
	$all_games[$j] = $game; 
	  
    $j++;
   }
  } 
  
 
//print_r($all_games);
echo "</pre>"; 
  
  
  
?>
  <table id="baseball" width="100%" border="0" cellspacing="0" cellpadding="0">
   <tr>
	<td width="120"  class="table_header" >Date</td>
	<td  name ="game_info_" width="120"  class="table_header">Team A</td>
    <td  name ="game_info_" width="120"  class="table_header">Team H</td>
 	<td  name ="game_info_" width="80"  class="table_header">Pitcher A</td>
	<td  name ="game_info_" width="80"  class="table_header">Pitcher H</td>       
    <td  name ="game_info_" width="60"  class="table_header">Rest Days</td> 
    <td  name ="game_info_" width="60"  class="table_header" title="Other team">1st 5 innings Moneyline</td> 
    <td  name ="game_info_" width="80"  class="table_header">Result 1</td>
    <td  name ="game_info_" width="60"  class="table_header">Balance</td>
    <td  name ="game_info_" width="60"  class="table_header" title="Both Teams">1st 5 Innnings Total</td>
    <td  name ="game_info_" width="80"  class="table_header">Result 2</td>
    <td  name ="game_info_" width="60"  class="table_header">Balance</td>
   	<td  name ="game_info_" width="60"  class="table_header" title="Other Team">Game Money Line </td>
    <td  name ="game_info_" width="80"  class="table_header">Result 3</td>
    <td  name ="game_info_" width="60"  class="table_header">Balance</td>
    <td  name ="game_info_" width="60"  class="table_header" title="Both Teams" >Game Total</td>
    <td  name ="game_info_" width="80"  class="table_header">Result 4</td>
    <td  name ="game_info_" width="60"  class="table_header">Balance</td>
    <td  name ="game_info_" width="60"  class="table_header" title="Other Team">TeamTotal</td>
    <td  name ="game_info_" width="80"  class="table_header">Result 5</td>
    <td  name ="game_info_" width="60"  class="table_header">Balance</td>

 
  	
   </tr>  
	
<?
  $h=0;
  $total_wins1 = 0;
  $total_wins2 = 0;
  $total_wins3 = 0;
  $total_wins4 = 0;
  $total_wins5 = 0;  
  foreach($all_games as $game ){
	
   
    if (!isset($_POST["rest"]) || $_POST["rest"] == "" ){
	    $_POST["rest"] = 1000; 
	}
   $days = explode(" ",$game->vars["rest_time"]);
   $rest_days = $days[1];
   	
  if ($rest_days < $_POST["rest"] ){	
	
	if($h % 2){$style = "1";}else{$style = "2";} $h++;		
   

    if ($game->vars["pitcher"] == $game->vars["pitcher_away"] ){
	$this_team = "away";
	$other_team = "home";	
	}
	else if($game->vars["pitcher"] == $game->vars["pitcher_home"] ) {
	$this_team = "home";
	$other_team = "away";	
	}
	
	//print_r($days);	
	//echo $rest_days;
	//echo "<BR>";
	
	
	$startdate =  date('Y-m-d',strtotime($game->vars["startdate"]));   
	$_date=$startdate;
   	$error_message = false;
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
	
   $team_line = $lines_team[$date." / ".$game->vars["away_rotation"]." / ".$game->vars["team_".$other_team]]->vars["away_total"];
   $game_line = $lines_game[$date." / ".$game->vars["away_rotation"]]->vars["away_total"]; 
   $innning_line = $lines_innings[$date." / ".$game->vars["away_rotation"]]->vars["away_total"]; 
   $home_money_inning = $lines_innings[$date." / ".$game->vars["away_rotation"]]->vars[$other_team."_money"]; 
   $home_money_game = $lines_game[$date." / ".$game->vars["away_rotation"]]->vars[$other_team."_money"];
  }
  else{
  $team_line = $lines_team[$date." / ".$game->vars["away_rotation"]." / ".$game->vars["team_".$other_team]]->vars["home_total"]; 
  $game_line = $lines_game[$date." / ".$game->vars["away_rotation"]]->vars["home_total"];  
  $innning_line = $lines_innings[$date." / ".$game->vars["away_rotation"]]->vars["home_total"]; 
  $home_money_inning = $lines_innings[$date." / ".$game->vars["away_rotation"]]->vars[$other_team."_money"]; 
  $home_money_game = $lines_game[$date." / ".$game->vars["away_rotation"]]->vars[$other_team."_money"];
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
    if ($game->vars["runs_".$this_team] < $game->vars["runs_".$other_team]){
     $home_win_game ="1_WIN";
	 $total_wins3++;
    } else if ($game->vars["runs_".$this_team] == $game->vars["runs_".$other_team]){
	  $home_win = "3_PUSH";
     } else { $home_win_game = "2_LOSE"; }
   }
   else { $home_win_inning = "3_NO LINE";}	 
	
  if ($home_money_inning){	
	$home_win_inning = 0;  // 1 = WIN   2 = LOSE   3 = PUSH
	  if ($score_innings[$this_team."_score"] < $score_innings[$other_team."_score"]){
     $home_win_inning ="1_WIN";
	  $total_wins1++;
      } else if ($score_innings[$this_team."_score"] == $score_innings[$other_team."_score"]){
	   $home_win_inning = "3_PUSH";
     } else { $home_win_inning = "2_LOSE"; }
  }
  else { $home_win_inning = "3_NO LINE";}
  
  
  
  
  
  $cleaned_team_line = prepare_line($team_line);
  $cleaned_line = prepare_line($game_line);
  $cleaned_inning_line = prepare_line($innning_line);
  
  if ($this_team == "away"){
	$pitcher_name =  $pitcher_away->vars["player"] ; 
	$bgk_a = "background-color:#C30";
	$bgk_h = "";	 
  } else {
	 $pitcher_name =  $pitcher_home->vars["player"] ;
	 $bgk_a = "";
	 $bgk_h = "background-color:#C30";	   
  }

	
?>


	<tr>
	 <td class="table_td<? echo $style ?>" style="font-size:12px;"><? echo $day."-".substr($game_year,2,2)."  at   ".$hour ?></td> 
	 <td class="table_td<? echo $style ?>" style="font-size:12px;"><? echo $team_away->vars["team_name"];  ?></td> 
     <td class="table_td<? echo $style ?>" style="font-size:12px;"><? echo $team_home->vars["team_name"];  ?></td> 
     <td class="table_td<? echo $style ?>" style="font-size:12px; <? echo $bgk_a ?>"><? echo $pitcher_away->vars["player"] ?></td> 
	 <td class="table_td<? echo $style ?>" style="font-size:12px; <? echo $bgk_h ?>"><? echo $pitcher_home->vars["player"] ?></td>     <td class="table_td<? echo $style ?>" style="font-size:12px;"><? echo $game->vars["rest_time"] ?></td>        
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
      <? $data_team = get_baseball_line_process($higher,$team_line,$cleaned_team_line,$game->vars["runs_".$other_team]);
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
  
  } // if rest days
 } // Pitchers as game

 ?>
     
   <tr>
			  <td class="table_header"></td>
              <td class="table_header"></td>
              <td class="table_header"></td>
			  <td class="table_header"></td>
			  <td class="table_header"></td>
              <td class="table_header"></td>
              <td class="table_header"></td>
              <? if ($h==0){ $h=1; }?>
              <td class="table_header"><? echo number_format(($total_wins1 * 100 / $h ),2); ?><strong>% WIN</strong></td> 
              <td class="table_header"><? echo number_format($total_money_inning,2) ?></td>
              <td class="table_header"></td> 
			  <td class="table_header"><? echo number_format(($total_wins2 * 100 / $h ),2); ?><strong>% WIN</strong></td> 
              <td class="table_header"><? echo number_format($total_line_inning,2) ?></td> 
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


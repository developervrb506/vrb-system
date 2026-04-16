<? include(ROOT_PATH . "/ck/process/security.php"); 
if($current_clerk->im_allow("baseball_file")){ ?>
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
  </head>
  <body>
  <? include "../../includes/header.php"  ?>
  <? include "../../includes/menu_ck.php"  ?>
  <? 
  
  //Post params
  
  
  if (isset($_POST["year"])){
	$season_year = substr($_POST['year'],0,-2);
	$year = $season_year;   
  }
  else { $year = date("Y");  }
  
 
  $season =  get_baseball_season($year);
  
     $from = $season['start'];
     if ($season['season'] == date('Y')) {
      $to = date( "Y-m-d", strtotime( "-1 day", strtotime(date( "Y-m-d")))); 
     }
     else {$to = $season['end'] ; }
  
  $all_seasons = get_all_baseball_seasons();
  $stadiums = get_all_baseball_stadiums();
  
  ?>
  
  <div class="page_content" style="padding-left:10px;">
  <div align="right"><span ><a href="./baseball_reports.php">Back to Reports</a></span></div>
  <span class="page_title">Highest Runs by Stadium
  </span><br /><br />
  
  
  <form method="post">
     Season: 
    <select name="year" id="year" onchange="change_active_years(this.value,<? echo count($all_seasons)?>)" >
       
      <? $j=1; ?>
	  <?  foreach ( $all_seasons as $_year){ ?> 
       
        <? if ($_year["season"] > 2010){ ?>
        <option value="<? echo $_year["season"] ?>_<? echo $j ?>" <? if ($season_year == $_year["season"]) { echo "selected"; } ?>><? echo $_year["season"] ?></option>
        <? $j++; } ?>
      
     <? } ?>
     </select>
      &nbsp;&nbsp;&nbsp;&nbsp;
      <br /><br />
      Stadium:  
      <? create_objects_list("stadium", "stadium", $stadiums, "team_id", "name", $default_name = "",$_POST["stadium"],"","_baseball_stadium");  ?>
       &nbsp;&nbsp;&nbsp;&nbsp;
     <input type="submit" value="Search" />
      
  <br /><br />
  
  
  </form>
  
  <? if (isset($_POST["stadium"])){ ?>
   
         
        <?
         $max_games = get_baseball_highest_runs_by_stadium("runs",$_POST["stadium"],$from,$to,"DESC");
         $total_runs = 0;
         $total_homeruns = 0;
        ?>
        <span><strong>Team Home:  </strong> <? echo $max_games[0]->vars["team_name"] ?></span><br /><br /><br />
        
        <span><strong>Games with the highest Runs</strong> </span><br /><br />
        <table id="baseball" width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="120"  class="table_header" >Date</td>
            <td  name ="game_info_" width="120"  class="table_header">Away</td>
            <td  name ="game_info_" width="120"  class="table_header">Umpire</td>
			<td  name ="game_info_" width="120"  class="table_header">Pitcher A</td>
            <td  name ="game_info_" width="120"  class="table_header">Pitcher H</td>
            <td  name ="game_info_" width="120" class="table_header">Homeruns</td>
            <td  name ="game_info_" width="120" class="table_header">Runs</td>
            <td  name ="game_info_" width="60" class="table_header">Espn</td>
         </tr>  
          <? foreach ($max_games as $game) { 
          
                $day= date('M-d',strtotime($game->vars["startdate"]));
                $hour= date('H:i',strtotime($game->vars["startdate"]));
                $date = date('Y-m-d',strtotime($game->vars["startdate"]));
                $team_away = get_baseball_team($game->vars["team_away"]);
                $umpire = get_umpire_name_by_id($game->vars["umpire"]);	
			    $pitcher_away = get_player_pitches_by_game($game->vars["id"],$game->vars["pitcher_away"],"away");
			    $pitcher_home = get_player_pitches_by_game($game->vars["id"],$game->vars["pitcher_home"],"home");	
			  
                if($i % 2){$style = "1";}else{$style = "2";} $i++;
                ?>
                <tr>
                <td class="table_td<? echo $style ?>" style="font-size:12px;"><? echo $day."   at   ".$hour ?></td> 
                <td class="table_td<? echo $style ?>" style="font-size:12px;"><? echo $team_away->vars["team_name"] ?></td> 
                <td class="table_td<? echo $style ?>" style="font-size:12px;"><? echo $umpire["full_name"] ?></td> 
                <td class="table_td<? echo $style ?>" style="font-size:12px;"><? echo $pitcher_away->vars["player"] ?></td> 
                <td class="table_td<? echo $style ?>" style="font-size:12px;"><? echo $pitcher_home->vars["player"] ?></td> 
              
               <td class="table_td<? echo $style ?>" style="font-size:12px;"><? echo $game->vars["homeruns"] ?></td> 
               <td class="table_td<? echo $style ?>" style="font-size:12px;"><? echo $game->vars["runs"] ?></td>  
               <td   class="table_td<? echo $style ?>" style="font-size:12px;" id="espn_<? echo $game->vars["id"]?>"><a href="http://scores.espn.go.com/mlb/boxscore?gameId=<? echo $game->vars["espn_game"] ?>" class="normal_link" target="_blank">Box Score
</td>  
               </tr>
               <? 
                 $total_runs = $total_runs + $game->vars["runs"];
                 $total_homeruns = $total_homeruns + $game->vars["homeruns"];
               ?>
          
        
        <? } ?>
          
          <tr>
             <td class="table_header"></td>
             <td class="table_header"></td>
             <td class="table_header"></td>
             <td class="table_header"></td>
              <td class="table_header"><strong>Total : </strong></td> 
              <td class="table_header"><strong><? echo $total_homeruns ?></strong></td>  
              <td class="table_header"><strong><? echo $total_runs ?></strong></td>  
             <td class="table_header"></td>
            </tr>
            <tr>
              <td class="table_header"></td>
              <td class="table_header"></td>
              <td class="table_header"></td>
              <td class="table_header"></td>
              <td class="table_header"><strong>Average : </strong></td> 
              <td class="table_header"><strong><? echo ($total_homeruns/10);?></strong></td>  
              <td class="table_header"><strong><? echo ($total_runs/10);  ?></strong></td>  
              <td class="table_header"></td>
            </tr>
         <tr>
           <td class="table_last" colspan="100"></td>
         </tr>
        </table>
        <br /><br />
               
        <? 
         $avg_data = get_baseball_avg_data_stadium("pk",$_POST["stadium"],$from,$to,$date_end);
         ?>
         <br /><br />
         <span><strong>Statistics for this Stadium</strong> </span><br /><br />
         <table id="baseball" width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="120"  class="table_header" align="center" >Avg PK</td>
            <td  name ="game_info_" width="120"  class="table_header" align="center">Avg Homeruns</td>
            <td  name ="game_info_" width="120" class="table_header" align="center">Avg Runs</td> 
          </tr>  
        
          <? foreach ($avg_data as $_avg_data) { 
          
              $day= date('M-d',strtotime($game->vars["startdate"]));
              $hour= date('H:i',strtotime($game->vars["startdate"]));
              $date = date('Y-m-d',strtotime($game->vars["startdate"]));
              $team_away = get_baseball_team($game->vars["team_away"]);
              
              ?>
              <tr>
               <td align="center" class="table_td<? echo $style ?>" style="font-size:12px;"><? echo $_avg_data->vars["avg_pk"] ?></td> 
               <td align="center"class="table_td<? echo $style ?>" style="font-size:12px;"><? echo $_avg_data->vars["avg_homeruns"] ?></td> 
               <td align="center"class="table_td<? echo $style ?>" style="font-size:12px;"><? echo $_avg_data->vars["avg_runs"] ?></td> 
            
              </tr>
          <? } ?>
        
          <tr>
             <td class="table_last" colspan="100"></td>
          </tr>
        </table>
        <br /><br />
       
       
        <?
		 $min_games = get_baseball_highest_runs_by_stadium("runs",$_POST["stadium"],$from,$to,"ASC");
         $total_runs = 0 ;
         $total_homeruns = 0 ;
          ?>
        
        
        <span><strong>Games with the lowest Runs</strong> </span><br /><br />
        <table id="baseball" width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="120"  class="table_header" >Date</td>
            <td  name ="game_info_" width="120"  class="table_header">Away</td>
            <td  name ="game_info_" width="120"  class="table_header">Umpire</td>
			<td  name ="game_info_" width="120"  class="table_header">Pitcher A</td>
            <td  name ="game_info_" width="120"  class="table_header">Pitcher H</td>
            <td  name ="game_info_" width="120" class="table_header">Homeruns</td>
            <td  name ="game_info_" width="120" class="table_header">Runs</td>
            <td  name ="game_info_" width="60" class="table_header">Espn</td>
         </tr>  
        
          <? foreach ($min_games as $game) { 
          
                $day= date('M-d',strtotime($game->vars["startdate"]));
                $hour= date('H:i',strtotime($game->vars["startdate"]));
                $date = date('Y-m-d',strtotime($game->vars["startdate"]));
                $team_away = get_baseball_team($game->vars["team_away"]);
				$umpire = get_umpire_name_by_id($game->vars["umpire"]);	
			    $pitcher_away = get_player_pitches_by_game($game->vars["id"],$game->vars["pitcher_away"],"away");
			    $pitcher_home = get_player_pitches_by_game($game->vars["id"],$game->vars["pitcher_home"],"home");	
                
                if($i % 2){$style = "1";}else{$style = "2";} $i++;
                ?>
                <tr>
                <td class="table_td<? echo $style ?>" style="font-size:12px;"><? echo $day."  at   ".$hour ?></td>   <td class="table_td<? echo $style ?>" style="font-size:12px;"><? echo $team_away->vars["team_name"] ?></td> 
               <td class="table_td<? echo $style ?>" style="font-size:12px;"><? echo $umpire["full_name"] ?></td> 
               <td class="table_td<? echo $style ?>" style="font-size:12px;"><? echo $pitcher_away->vars["player"] ?></td> 
               <td class="table_td<? echo $style ?>" style="font-size:12px;"><? echo $pitcher_home->vars["player"] ?></td> 
                <td class="table_td<? echo $style ?>" style="font-size:12px;"><? echo $game->vars["homeruns"] ?></td> 
               <td class="table_td<? echo $style ?>" style="font-size:12px;"><? echo $game->vars["runs"] ?></td>  
               <td   class="table_td<? echo $style ?>" style="font-size:12px;" id="espn_<? echo $game->vars["id"]?>"><a href="http://scores.espn.go.com/mlb/boxscore?gameId=<? echo $game->vars["espn_game"] ?>" class="normal_link" target="_blank">Box Score
</td>  
               </tr>
               <?
                $total_runs = $total_runs + $game->vars["runs"];
                $total_homeruns = $total_homeruns + $game->vars["homeruns"];
               ?>
          <? } ?>
           <tr>
              <td class="table_header"></td>
             <td class="table_header"></td>
             <td class="table_header"></td>
              <td class="table_header"></td>
              <td class="table_header"><strong>Total : </strong></td> 
              <td class="table_header"><strong><? echo $total_homeruns ?></strong></td>  
              <td class="table_header"><strong><? echo $total_runs ?></strong></td>  
              <td class="table_header"></td>
            </tr>
            <tr>
              <td class="table_header"></td>
              <td class="table_header"></td>
              <td class="table_header"></td>
              <td class="table_header"></td>
              <td class="table_header"><strong>Average : </strong></td> 
              <td class="table_header"><strong><? echo ($total_homeruns/10);?></strong></td>  
              <td class="table_header"><strong><? echo ($total_runs/10);  ?></strong></td>  
              <td class="table_header"></td>
            </tr>
         
          <tr>
           <td class="table_last" colspan="100"></td>
          </tr> 
          </table>
  
  <? } ?>
  </div>
  </body>
  <? include "../../includes/footer.php" ?>
<? } else { echo "ACCESS DENIED"; }





?>


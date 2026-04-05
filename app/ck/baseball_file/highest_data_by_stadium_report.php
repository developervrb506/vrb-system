<? include(ROOT_PATH . "/ck/process/security.php"); 
if($current_clerk->im_allow("baseball_file")){ ?>
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
  <? $page_style = " width:2000px;"; ?> 
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
      <? create_objects_list("stadium", "stadium", $stadiums, "team_id", "name", "All",$_POST["stadium"],"","_baseball_stadium");  ?>
       &nbsp;&nbsp;&nbsp;&nbsp;
     <input type="submit" value="Search" />
      
  <br /><br />
  
  
  </form>
  
  <? if (isset($_POST["stadium"])){ ?>
   
      <? if ($_POST["stadium"] > 0) { ?>
      <? print_game_info_stadium("runs",$_POST["stadium"],$from,$to) ?>
      <? print_game_info_stadium("homeruns",$_POST["stadium"],$from,$to) ?>
      <? } 
	  else {
	    foreach ($stadiums as $_stadium){?>
            
        <span><strong>Stadium:  </strong> <? echo strtoupper($_stadium->vars["name"]) ?></span><BR><BR>
				  <?  
			 print_game_info_stadium("runs",$_stadium->vars["team_id"],$from,$to);

             print_game_info_stadium("homeruns",$_stadium->vars["team_id"],$from,$to); 			
		 }	  
		  
	   }
	  ?>
      
        
        
        
                
       
       
  
  <? } ?>
  </div>
  </body>
  <? include "../../includes/footer.php" ?>
<? } else { echo "ACCESS DENIED"; } ?>

<?

function print_game_info_stadium($field,$stadium,$from,$to){
	
  $max_games = get_baseball_highest_runs_weather_by_stadium($field,$stadium,$from,$to,"DESC");
         $total_runs = 0;
		 $total_homeruns = 0;
        ?>
        <span><strong>Team Home:  </strong> <? echo $max_games[0]->vars["team_name"] ?></span><BR><BR>
        
        <span style="font-size:14px"><strong>Games with the Highest <? echo ucwords($field) ?></strong> </span>
        <table id="baseball" width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="120"  class="table_header" >Date</td>
            <td  name ="game_info_" width="120"  class="table_header">Away</td>
            <td  name ="game_info_" width="120"  class="table_header">Temp</td>
			<td  name ="game_info_" width="120"  class="table_header">Condition</td>
            <td  name ="game_info_" width="120"  class="table_header">w. speed</td>
            <td  name ="game_info_" width="120" class="table_header">W. degrees</td>
            <td  name ="game_info_" width="120" class="table_header">W. Direction</td>
            <td  name ="game_info_" width="120" class="table_header">W. Gust</td> 
	        <td  name ="game_info_" width="120" class="table_header">Humidity</td>            					            <td  name ="game_info_" width="120" class="table_header">A. Pressure</td>            <td  name ="game_info_" width="120" class="table_header">Dewpoint</td>            	            <td  name ="game_info_" width="120" class="table_header">Pk</td>
            <td  name ="game_info_" width="120" class="table_header">Dry Air</td>
            <td  name ="game_info_" width="120" class="table_header">Vapour Press.</td>
            <td  name ="game_info_" width="120" class="table_header">Moist Air</td>       					            <td  name ="game_info_" width="120" class="table_header">HomeRuns</td>
            <td  name ="game_info_" width="120" class="table_header">Runs</td>                      
            
         </tr>  
          <? foreach ($max_games as $game) { 
          
                $day= date('M-d',strtotime($game->vars["startdate"]));
                $hour= date('H:i',strtotime($game->vars["startdate"]));
                $date = date('Y-m-d',strtotime($game->vars["startdate"]));
                $team_away = get_baseball_team($game->vars["team_away"]);
               	if ($game->vars["pk"]== "-99"){ $game->vars["pk"] = 0;}
						  
                if($i % 2){$style = "1";}else{$style = "2";} $i++;
                ?>
                <tr>
                <td class="table_td<? echo $style ?>" style="font-size:12px;"><? echo $day."   at   ".$hour ?></td> 
                <td class="table_td<? echo $style ?>" style="font-size:12px;"><? echo $team_away->vars["team_name"] ?></td> 
                <td class="table_td<? echo $style ?>" style="font-size:12px;"><? echo $game->vars["temp"] ?></td> 
                <td class="table_td<? echo $style ?>" style="font-size:12px;"><? echo $game->vars["condition"] ?></td>             
                <td class="table_td<? echo $style ?>" style="font-size:12px;"><? echo $game->vars["wind_speed"] ?></td>                   
                <td class="table_td<? echo $style ?>" style="font-size:12px;"><? echo $game->vars["wind_degrees"] ?></td>                   
                <td class="table_td<? echo $style ?>" style="font-size:12px;"><? echo $game->vars["wind_direction"] ?></td>                   
                <td class="table_td<? echo $style ?>" style="font-size:12px;"><? echo $game->vars["wind_gust"] ?></td>                   
                <td class="table_td<? echo $style ?>" style="font-size:12px;"><? echo $game->vars["humidity"] ?></td>                   
                <td class="table_td<? echo $style ?>" style="font-size:12px;"><? echo $game->vars["air_pressure"] ?></td>                   
                <td class="table_td<? echo $style ?>" style="font-size:12px;"><? echo $game->vars["dewpoint"] ?></td>                   
                <td class="table_td<? echo $style ?>" style="font-size:12px;"><? echo $game->vars["pk"] ?></td>  
                <td class="table_td<? echo $style ?>" style="font-size:12px;"><? echo $game->vars["dry_air"] ?></td>  
                <td class="table_td<? echo $style ?>" style="font-size:12px;"><? echo $game->vars["vapour_pressure"] ?></td>  
                <td class="table_td<? echo $style ?>" style="font-size:12px;"><? echo $game->vars["moist_air"] ?></td>                   
                
                
                
                
                
                
                
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
             <td class="table_header"></td>
             <td class="table_header"></td>
             <td class="table_header"></td>
             <td class="table_header"></td>
             <td class="table_header"></td>
             <td class="table_header"></td>
             <td class="table_header"></td>
             <td class="table_header"></td>
             <td class="table_header"></td>
             <td class="table_header"></td>
             <td class="table_header"></td>
             <td class="table_header"></td>
             <td class="table_header"></td>             
             <td class="table_header"><strong>Total : </strong></td> 
             <td class="table_header"><strong><? echo $total_homeruns ?></strong></td>  
             <td class="table_header"><strong><? echo $total_runs ?></strong></td>  
            
            </tr>
            <tr>
             <td class="table_header"></td>
             <td class="table_header"></td>
             <td class="table_header"></td>
             <td class="table_header"></td>
             <td class="table_header"></td>
             <td class="table_header"></td>
             <td class="table_header"></td>
             <td class="table_header"></td>
             <td class="table_header"></td>
             <td class="table_header"></td>
             <td class="table_header"></td>
             <td class="table_header"></td>
             <td class="table_header"></td>
             <td class="table_header"></td>
             <td class="table_header"><strong>Average : </strong></td> 
             <td class="table_header"><strong><? echo number_format(($total_homeruns/count($max_games)),2);?></strong></td>  
              <td class="table_header"><strong><? echo number_format(($total_runs/count($max_games)),2);  ?></strong></td>  
             
            </tr>
         <tr>
           <td class="table_last" colspan="100"></td>
         </tr>
        </table>
        <BR><BR>	
<?



}



?>



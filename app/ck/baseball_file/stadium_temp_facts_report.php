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
  </head>
  <body>
  <? include "../../includes/header.php"  ?>
  <? include "../../includes/menu_ck.php"  ?>
  <? 
  
  //Post params
  
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
  <span class="page_title">Temp Factors Report
  </span><br /><br />
  
  
  <form method="post">
      From: 
      <input name="from" type="text" id="from" value="<? echo $from ?>" />&nbsp;&nbsp;
      To: 
      <input name="to" type="text" id="to" value="<? echo $to ?>" /> 
      &nbsp;&nbsp;&nbsp;&nbsp;
      <br /><br />
      Stadium:  
      <? create_objects_list("stadium", "stadium", $stadiums, "team_id", "name", $default_name = "",$_POST["stadium"],"","_baseball_stadium");  ?>
       &nbsp;&nbsp;&nbsp;&nbsp;
       Factor: 
       <select name="factor">
        <option  <? if ($_POST["factor"] == "humidity"){ echo 'selected="selected"'; }?> value="humidity" >Humedity</option>
        <option <? if ($_POST["factor"] == "temp"){ echo 'selected="selected"' ; }?>value="temp" >Temperature</option>
        <option <? if ($_POST["factor"] == "air_pressure"){ echo 'selected="selected"' ; }?> value="air_pressure" >Air Pressure</option>
        <option <? if ($_POST["factor"] == "dewpoint"){ echo 'selected="selected"' ; }?> value="dewpoint" >Dew Point</option>
        
       </select>
      &nbsp;&nbsp;&nbsp;
      <? /* <input  type="checkbox" <? if (!isset($_POST['factor'])){ echo 'checked="checked"'; } if ($_POST['indoors']){ echo 'checked="checked"'; } ?>  value="1"  name="indoors" />
     Exclude Indoors Games */ ?>
       
       <br /><br />
     <input type="submit" value="Search" />
      
  <br /><br />
  
  
  </form>
  
  <? if (isset($_POST["stadium"])){ ?>
   
         <?
         $min_games = get_baseball_games_temp_facts_stadium($_POST["factor"],$_POST["stadium"],$from,$to,"ASC",$_POST['indoors']);
         $total_runs = 0 ;
         $total_homeruns = 0 ;
          ?>
        <span><strong>Team Home:  </strong> <? echo $min_games[0]->vars["team_name"] ?></span><br /><br /><br />
        
        <span><strong>Games with the lowest <? echo ucwords(strtolower($_POST["factor"])) ?></strong> </span><br /><br />
        <table id="baseball" width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="120"  class="table_header" >Date</td>
            <td  name ="game_info_" width="120"  class="table_header">Away</td>
            <td  name ="game_info_" width="120" class="table_header"><? echo $_POST["factor"] ?></td>
            <td  name ="game_info_" width="120" class="table_header">Homeruns</td>
            <td  name ="game_info_" width="120" class="table_header">Runs</td>
         </tr>  
        
          <? foreach ($min_games as $game) { 
          
                $day= date('M-d',strtotime($game->vars["startdate"]));
                $hour= date('H:i',strtotime($game->vars["startdate"]));
                $date = date('Y-m-d',strtotime($game->vars["startdate"]));
                $team_away = get_baseball_team($game->vars["team_away"]);
                
                if($i % 2){$style = "1";}else{$style = "2";} $i++;
                ?>
                <tr>
                <td class="table_td<? echo $style ?>" style="font-size:12px;"><? echo $day."  at   ".$hour ?></td>   <td class="table_td<? echo $style ?>" style="font-size:12px;"><? echo $team_away->vars["team_name"] ?></td> 
                <td class="table_td<? echo $style ?>" style="font-size:12px;"><? echo $game->vars[$_POST["factor"]] ?></td> 
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
              <td class="table_header"><strong>Total : </strong></td> 
              <td class="table_header"><strong><? echo $total_homeruns ?></strong></td>  
              <td class="table_header"><strong><? echo $total_runs ?></strong></td>  
            </tr>
            <tr>
              <td class="table_header"></td>
              <td class="table_header"></td>
              <td class="table_header"><strong>Average : </strong></td> 
              <td class="table_header"><strong><? echo ($total_homeruns/10);?></strong></td>  
              <td class="table_header"><strong><? echo ($total_runs/10);  ?></strong></td>  
            </tr>
         
          <tr>
           <td class="table_last" colspan="100"></td>
          </tr> 
          </table>
         <? 
         $avg_data = get_baseball_avg_temp_facts_data_stadium($_POST["factor"],$_POST["stadium"],$from,$to,$date_end,$_POST['indoors']);
         ?>
         <br /><br />
         <span><strong><? echo  ucwords(strtolower($_POST["factor"])) ?> statistics for this Stadium</strong> </span><br /><br />
         <table id="baseball" width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="120"  class="table_header" align="center" >Avg <? echo $_POST["factor"] ?></td>
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
               <td align="center" class="table_td<? echo $style ?>" style="font-size:12px;"><? echo $_avg_data->vars["avg_".$_POST["factor"]] ?></td> 
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
         $max_games = get_baseball_games_temp_facts_stadium($_POST["factor"],$_POST["stadium"],$from,$to,"DESC",$_POST['indoors']);
         $total_runs = 0;
         $total_homeruns = 0;
        ?>
        
        
        <span><strong>Games with the highest <? echo ucwords(strtolower($_POST["factor"])) ?></strong> </span><br /><br />
        <table id="baseball" width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="120"  class="table_header" >Date</td>
            <td  name ="game_info_" width="120"  class="table_header">Away</td>
            <td  name ="game_info_" width="120" class="table_header"><? echo $_POST["factor"] ?></td>
            <td  name ="game_info_" width="120" class="table_header">Homeruns</td>
            <td  name ="game_info_" width="120" class="table_header">Runs</td>
         </tr>  
          <? foreach ($max_games as $game) { 
          
                $day= date('M-d',strtotime($game->vars["startdate"]));
                $hour= date('H:i',strtotime($game->vars["startdate"]));
                $date = date('Y-m-d',strtotime($game->vars["startdate"]));
                $team_away = get_baseball_team($game->vars["team_away"]);
                
                if($i % 2){$style = "1";}else{$style = "2";} $i++;
                ?>
                <tr>
                <td class="table_td<? echo $style ?>" style="font-size:12px;"><? echo $day."   at   ".$hour ?></td> 
                <td class="table_td<? echo $style ?>" style="font-size:12px;"><? echo $team_away->vars["team_name"] ?></td> 
                <td class="table_td<? echo $style ?>" style="font-size:12px;"><? echo $game->vars[$_POST["factor"]] ?></td> 
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
              <td class="table_header"><strong>Total : </strong></td> 
              <td class="table_header"><strong><? echo $total_homeruns ?></strong></td>  
              <td class="table_header"><strong><? echo $total_runs ?></strong></td>  
            </tr>
            <tr>
              <td class="table_header"></td>
              <td class="table_header"></td>
              <td class="table_header"><strong>Average : </strong></td> 
              <td class="table_header"><strong><? echo ($total_homeruns/10);?></strong></td>  
              <td class="table_header"><strong><? echo ($total_runs/10);  ?></strong></td>  
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


<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../../css/style.css" rel="stylesheet" type="text/css" />
<link href="./css/style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../../process/js/functions.js?v=2"></script>

</head>


<? 
require_once(ROOT_PATH . "/ck/db/handler.php"); 
require_once(ROOT_PATH . '/includes/html_dom_parser.php'); 
require_once(ROOT_PATH . '/ck/baseball_file/process/functions.php');
  
set_time_limit(0);


if(isset($_GET["player"])){
	
	
	$pl = $_GET["player"];
	$img = $_GET["img"];
    $name = $_GET["name"];	
	$std = $_GET["std"];
	$std_name = $_GET["std_name"];	
	$vs_team = $_GET["vs"];
	$vs_team_name = $_GET["vs_name"];
	
	$player =  get_baseball_espn_player_data($pl);
    
}

?>
<body style="background:#CCC; padding:0px;">
<div   style="background-color:#696" id="pitcher">

<table width="100%" border="0" cellspacing="" >
<tr>
<td width="200px">
<img width="200" height="170" src="<? echo $img ?>&h=170&w=200"></td>
<td>
<span style="font-size:24px">&nbsp;&nbsp; &nbsp;<strong><? echo $name ?></strong></span>
<? if ((!isset($_GET["n"])) && (!isset($_GET["b"]))){ ?>
<a title="Open in a New Window" style="margin-left:50px" href="player_fantasy_data.php?player=<? echo $pl ?>&img=<? echo $img ?>&name=<? echo $name ?>&std=<? echo $std ?>&std_name=<? echo $std_name ?>&vs=<? echo $vs_team ?>&vs_name=<? echo $vs_team_name ?>&n" onclick="window.open (this.href, 'child', 'height=500px,width=630px'); return false"><img width="40px" height="40px" alt="Open in New Window" src="../../images/open_in_new_window.png"></a> <? }  else { ?>
<BR>
<span style="font-size:16px">&nbsp;&nbsp; &nbsp;<strong><? echo $player->vars["actual_team"] ?></strong></span>	
<? }?>
<ul style="margin-left:12px; color:#FFF">
  <li> <strong>Birth Date:</strong>&nbsp;&nbsp; &nbsp; <? echo $player->vars["birth_date"] ?> </li>
  <li> <strong>Birthplace:</strong>&nbsp;&nbsp;<? echo $player->vars["birth_place"] ?></li>
  <li> <strong>Experience:</strong>&nbsp;&nbsp;<? echo $player->vars["experience"] ?></li>  
  <li> <strong>College:</strong>&nbsp;&nbsp;<? echo $player->vars["college"] ?></li>    
  <li> <strong>Ht/Wt:</strong>&nbsp;&nbsp;<? echo $player->vars["heigth_weigth"] ?></li>      
</ul>
</td>
</tr>
</table>
</div>

<? if($player->vars["news"] != "" || $player->vars["spin"] != "" || $player->vars["projection"] != "") {?>
<div id="news" style="background-color:#4B5F45; margin-top:-16px; color:#FFF">
 <ul style="margin-left:8px">
 
  <? if($player->vars["news"] != "") { ?>
  <BR>
  <li> <span style="color:#F90"><strong>News:</strong></span>
    <? echo $player->vars["news"] ?>
    
  </li>
  <BR>
  <? } ?>
  <? if($player->vars["spin"] != "") { ?>
  <li><span style="color:#F90"><strong>Spin:</strong></span>
     <? echo $player->vars["spin"] ?>
     
  </li>
  <BR>
  <? } ?>
  
  <?  if($player->vars["projection"] != "") { ?>
  <li><span style="color:#F90"><strong>Projection:</strong></span>
    <? echo $player->vars["projection"] ?>
  </li>
  <BR><BR>
  <? } ?>
 
 </ul>
</div>
<? } ?>
<div id="fantasy-stats"  style="background-color:#696; margin-top:-17px">
<BR>
<h5 style="color:#F90; text-decoration:underline;float:left; margin-top:-2px; margin-left:18px">PLAYER RATING</h5>
<h5 style="color:#F90; text-decoration:underline;margin-left:200px; margin-top:-2px;float:left;">RANKINGS</h5>
<BR>
<ul style="margin-left:6px" >  
<li >
  <ul>
  <li style="margin-top:-20px; margin-left:-385px; float:left"><strong>Season:</strong><span style="color:#FFF">&nbsp;&nbsp;<? echo $player->vars["rate_actual_season"] ?></span></li>
  <li style="margin-top:-20px; margin-left:-270px;float:left" ><strong>7 Days:</strong><span style="color:#FFF">&nbsp;&nbsp;<? echo $player->vars["rate_7"] ?></span></li>
  </ul></li>
  <li><ul>
  <li ><span style="margin-left:-270px"><strong>15 Days:</strong></span><span style="color:#FFF">&nbsp;&nbsp;<? echo $player->vars["rate_15"] ?></span></li>
  <li style="margin-top:-20px; margin-left:7px;float:left" ><strong>30 Days:</strong><span style="color:#FFF">&nbsp;&nbsp;<? echo $player->vars["rate_30"] ?></span> </li></ul></li></ul>
  
  
  <ul class="">
   <li><ul style="float:left; margin-left:235px;margin-top:-50px">
   <li style="font-size:12px;"><strong>POSITION RK</strong></li>
   <div style="margin-top:2px; font-size:16px">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<? echo $player->vars["espn_rank"] ?></div>
   <li style="font-size:12px;margin-top:-35px; margin-left:110px;float:left"><strong>% OWNED</strong><div style="margin-top:2px; font-size:16px">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<? echo $player->vars["perc_own"] ?></div></li>
   <li style="font-size:12px;margin-top:-35px; margin-left:190px;float:left"><strong>AVG DRAFTED</strong><div style="margin-top:2px; font-size:16px">&nbsp;&nbsp;&nbsp;&nbsp;<? echo $player->vars["avg_draf"] ?></div></li>
   </ul></li></ul>
   <BR>
   </div>
<? if (!isset($_GET["b"])){  ?> 
   <? if ($player->vars["day_splits"] != "" ) {?>
  
   <div style="background-color:#D3D08F">
    <?  // print_r($today_stadium) ?>
     <table cellspacing="20px">
       <tr>
          <td > <strong>Day Splits: </strong>&nbsp;&nbsp; <? echo $player->vars["day_splits"]  ?></td><td  > <strong>Nigth Splits: </strong>&nbsp;&nbsp;<? echo $player->vars["nigth_splits"]  ?></td><td  > <strong>Era Month:</strong>  &nbsp;&nbsp;<? echo $player->vars["month_era_splits"]  ?></td>
       </tr>
        
     </table>
   
   </div> 
    <? } ?>
    <? $today_stadium = get_baseball_espn_player_stadium($pl,$std); ?>
    <? if (!is_null($today_stadium)) { ?>
    <div>
    <BR>
    
     &nbsp;&nbsp;&nbsp;&nbsp;<strong>Today Stadium:</strong> <? echo $std_name; ?>
     <table cellspacing="10px">
       <tr>
       <td > &nbsp;&nbsp; <strong>Era Splits: </strong>&nbsp;&nbsp; <? echo $today_stadium->vars["splits_era"]  ?></td><td  > <strong>IP Splits: </strong>&nbsp;&nbsp;<? echo $today_stadium->vars["splits_ip"]  ?></td><td  > <strong>AVG:</strong>  &nbsp;&nbsp;<? echo $today_stadium->vars["splits_avg"]  ?></td>
       </tr>
        
     </table>
     <BR>
    </div>
    <? } ?>
    <? $player_stats = get_all_baseball_espn_player_year_data($pl,3); ?>
     <? if (!is_null($player_stats)) { ?>
    <div id="news" style="background-color:#4B5F45; margin-top:-16px; color:#FFF">
      <br>
      &nbsp;&nbsp;<strong>Inner Pitches Stats:</strong><br>
       <table style="margin-left:160px" cellspacing="10px" border="1">
          <tr>
          <? foreach ($player_stats as $ps ){ ?>
          <td style="color:#F90"><strong><? echo $ps["year"] ?></strong></td>
          <? } ?> 
        </tr>
        <tr>
         <? foreach ($player_stats as $ps ){ ?>
         <td><? echo $ps["stats_ip"] ?></td>
          <? } ?> 
        </tr>        
        
     </table>
	 
     </div>
    <? } ?>
    <? $vs_player = get_baseball_espn_pitcher_batter_vs($pl,$vs_team) ?>
     <? if (!is_null($vs_player)) { ?>
    <div>
       <BR>
      <table  width="50%"  class="tablehead" >
	  <tbody>
        <tr  class="stathead" style="color: #fff!important; font-size: 16px;">
           <td colspan="13"> <? echo $vs_team_name ?> vs. <? echo $name ?></td>
        </tr>
      
      <tr class="colhead" style=" font-weight:bold">
       <td><? echo $vs_player[0]->vars["type_vs"]; ?></td>
       <td class="colhead" title="At Bats">AB</td>
       <td class="colhead" title="Hits">H</td>
       <td class="colhead" title="Doubles">2B</td>
       <td class="colhead" title="Triples">3B</td>
       <td class="colhead" title="Home Runs">HR</td>
       <td class="colhead" title="Runs Batted In">RBI</td>
       <td class="colhead" title="Walks">BB</td>
       <td class="colhead" title="Strikeouts">SO</td>
       <td class="colhead" title="Batting Average">AVG</td>
       <td class="colhead" title="On Base Percentage">OBP</td>
       <td class="colhead" title="Slugging Percentage">SLG</td>
       <td class="colhead" title="OPS = OBP + SLG">OPS</td>
       </tr>
       <?
	         $totals["ab"] = 0;
			 $totals["h"] = 0;
             $totals["2b"] = 0;
             $totals["3b"] = 0;
             $totals["hr"] = 0;  
             $totals["rbi"] = 0;
             $totals["bb"] = 0;
             $totals["so"] = 0;                                                                      
             $totals["avg"] = 0;
             $totals["obp"] = 0;                        
             $totals["slg"] = 0; 
             $totals["ops"] = 0;  
		 
	   
	    ?>
       <? foreach( $vs_player as $vs ){ ?>
       <? if($i % 2){$style = "1";}else{$style = "2";} $i++; ?>
       <tr >
            <td class="table_td<? echo $style ?>">
            <a title="Open in a New Window" style="" href="player_fantasy_data.php?player=<? echo $vs->vars["espn_player2"] ?>&img=<? echo $vs->vars["image"] ?>&name=<? echo $vs->vars["player"] ?>&b" onclick="window.open (this.href, 'blank', 'height=500px,width=630px'); return false"><? echo $vs->vars["player"] ?></a>
             </td>
            <td class="table_td<? echo $style ?>"><? echo $vs->vars["ab"]; $totals["ab"] += $vs->vars["ab"]; ?></td>
            <td class="table_td<? echo $style ?>"><? echo $vs->vars["h"];  $totals["h"] += $vs->vars["h"] ?></td>
            <td class="table_td<? echo $style ?>"><? echo $vs->vars["2b"]; $totals["2b"] += $vs->vars["2b"] ?></td>
            <td class="table_td<? echo $style ?>"><? echo $vs->vars["3b"]; $totals["3b"] += $vs->vars["3b"] ?></td>
            <td class="table_td<? echo $style ?>"><? echo $vs->vars["hr"]; $totals["hr"] += $vs->vars["hr"] ?></td>  
            <td class="table_td<? echo $style ?>"><? echo $vs->vars["rbi"]; $totals["rbi"] += $vs->vars["rbi"] ?></td>
            <td class="table_td<? echo $style ?>"><? echo $vs->vars["bb"]; $totals["bb"] += $vs->vars["bb"] ?></td>
            <td class="table_td<? echo $style ?>"><? echo $vs->vars["so"]; $totals["so"] += $vs->vars["so"] ?></td>                                                                      
            <td class="table_td<? echo $style ?>"><? echo $vs->vars["avg"]; $totals["avg"] += $vs->vars["avg"] ?></td>
            <td class="table_td<? echo $style ?>"><? echo $vs->vars["obp"]; $totals["obp"] += $vs->vars["obp"] ?></td>                        
            <td class="table_td<? echo $style ?>"><? echo $vs->vars["slg"]; $totals["slg"] += $vs->vars["slg"] ?></td> 
            <td class="table_td<? echo $style ?>"><? echo $vs->vars["ops"]; $totals["ops"] += $vs->vars["ops"] ?></td>                       
	 </tr>
      <? }?>
      <tr style="font-weight:bold">
         <td class="table_td<? echo $style ?>">Totals</td> 
         <?
         if (count($vs_player) > 0 ){ 
			 $totals["avg"] = number_format(($totals["avg"] / count($vs_player)),3);
			 $totals["obp"] = number_format(($totals["obp"] / count($vs_player)),3);
			 $totals["slg"] = number_format(($totals["slg"] / count($vs_player)),3);
			 $totals["ops"] = number_format(($totals["ops"] / count($vs_player)),3);
		 }
		 ?>
        
        
        
         <? foreach($totals as $t){?>
           <td >
		      
               <? echo $t ?>
               
           </td> 
         <? } ?>
      
      </tr>
       <tr>
           <td class="table_last" colspan="100"></td>
         </tr>
    </tbody></table>

    </div>
    <? } ?>
<? } ?>     
<? // print_r($player); ?>


   <br />
   <?php /*?> <script type="text/javascript">
	load_url_content_in_div('<?= BASE_URL ?>/ck/baseball_file/jobs/pitchers_game_fix_data.php<? echo $data ?>',"pitcher");
    </script><?php */?>
</div>

</body>
</html>


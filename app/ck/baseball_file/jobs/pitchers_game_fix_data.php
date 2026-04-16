<? require_once(ROOT_PATH . "/ck/process/security.php"); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../../../css/style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../../process/js/functions.js?v=2"></script>
</head>
<body style="background:#fff; padding:20px;">

<? 
require_once(ROOT_PATH . "/ck/db/handler.php"); 
require_once(ROOT_PATH . '/includes/html_dom_parser.php'); 
require_once(ROOT_PATH . '/ck/baseball_file/process/functions.php');
  
set_time_limit(0);


if(isset($_GET["player"])){
	$player_team =  new _baseball_player_teams();
	$player_team->vars["player"]=$_GET["player"];  
	$player_team->vars["team"]=$_GET["team"]; 
    $player_team->vars["season"]=date("Y");  
	$player_team->insert();
	header("Location: pitchers_game_fix.php");
}
?>
<div style="display:none">
<?
$date = $_GET["date"];
$date = "2020-08-17";
	
$year= date("Y");
$games = get_basic_baseball_games_by_date($date);

$i=1;
$missed = array();
$r=0;
foreach ($games as $game ){


if ($game->vars["espn_game"]){  
	  if ($game->started()){
	    $link = "http://www.espn.com/mlb/boxscore?gameId=";
		$pr= false;
		
	  }
	  else{
		 $link = "http://www.espn.com/mlb/game?gameId=";
		 $pr = true;
	  }
	
	$html = file_get_html($link.$game->vars["espn_game"].""); 
	//echo $link.$game->vars["espn_game"];
	if($pr){
	  
        
		$j=0;
		foreach($html->find('div[id="gamepackage-probables"]') as $elementa) { 
	
			foreach($elementa->find('a') as $element) { 
	  			// echo $element->href;
				if (contains_ck($element->href,"/mlb/player/_/id/")){
						  
					   if ($j==1) {
						 
						$pitcher_away = "**";
						$pitcherid_away =  str_center("id","/",$element->href);	 
						$pitcherid_away =  str_center("/","/".$pitcher_away,$pitcherid_away);
						$a = get_baseball_player_espn_nick($pitcherid_away);
						 if(!empty($a)){$pitcher_away  =  $a["espn_nick"]; }
						
					   }
					   
					   if($j==2){
						 $pitcher_home = "**";
						 $pitcherid_home =  str_center("id","/",$element->href);	 
						 $pitcherid_home =  str_center("/","/".$pitcher_home,$pitcherid_home);	 
						 $h = get_baseball_player_espn_nick($pitcherid_home);
						 if(!empty($h)){$pitcher_home  =  $h["espn_nick"]; }
						
						}
						
					  $j++; 
					}
			}
     
				
	
   		//}//a
    
	
  
     } //div
    
   
   }
   else{
		 
		    $j=0; 
		   foreach($html->find('div[id="gamepackage-box-score"]') as $elementa) { 
		   
		     
			 foreach ($elementa->find("table tr") as $tr){
				  foreach ($tr->find("th") as $th){
					 // echo $th->plaintext." * ";
					  if($th->plaintext == "Pitchers" ){ $line = true;}
				  }
				
				 if($line){
					
				  foreach($tr->find("td") as $td){
				      foreach($td->find('a') as $element) { 
				    //  echo $element->href;
				   if (contains_ck($element->href,"/mlb/player/_/id/")){
						 //  echo $j.")".$element->href;
					    if ($j==0) {
						    $pitcher_away = "**"; 
							$pitcherid_away =  str_center("id","/",$element->href);	 
							$pitcherid_away =  str_center("/","/".$pitcher_away,$pitcherid_away);
							$a = get_baseball_player_espn_nick($pitcherid_away);
							 if(!empty($a)){$pitcher_away  =  $a["espn_nick"]; }
					   }
					   
					   if($j==1){
					     $pitcher_home = "**"; 
						 $pitcherid_home =  str_center("id","/",$element->href);	 
						 $pitcherid_home =  str_center("/","/".$pitcher_home,$pitcherid_home);	 
						 $h = get_baseball_player_espn_nick($pitcherid_home);
						 if(!empty($h)){$pitcher_home  =  $h["espn_nick"]; }
						}
						
					  $j++; 
					 }
				    }
				    //echo $td->plaintext." - ";	 
				    $line = false;
				    break;
				  }
				 }
				 
				 
			// echo "<BR>";
			 }
			 
		   }
     }  
	
	 			 $home_team = get_baseball_team($game->vars["team_home"]); 
				  $away_team = get_baseball_team($game->vars["team_away"]); 
				  $player_a = get_baseball_player_by_team("espn_nick",$pitcher_away,$away_team->vars["fangraphs_team"],$year, "pitcher"); 
				  $player_h = get_baseball_player_by_team("espn_nick",$pitcher_home,$home_team->vars["fangraphs_team"],$year, "pitcher"); 	

				  //echo "AWAY<BR>";  
				  //print_r($player_a);
				  if (is_null($player_a)){
					
					$missed[$r]["team_nam"] = $away_team->vars["team_name"];
					$missed[$r]["team_id"] = $away_team->vars["fangraphs_team"];
					$missed[$r]["player"] = $pitcher_away;
					$r++;		 
				  }  
				 //echo "<BR>HOME<BR>"; 
				//  print_r($player_h);  
				  if (is_null($player_h)){
					//echo "MIssed Home ".$pitcher_home; 
					$missed[$r]["team_nam"] = $home_team->vars["team_name"];
					$missed[$r]["team_id"] = $home_team->vars["fangraphs_team"];
					$missed[$r]["player"] = $pitcher_home;
					$r++;
					
					
				  }
				  //echo"<BR><BR>";

			  if (!is_null($player_a)){ 
				
				 if ($game->vars["pitcher_away"] != $player_a->vars["fangraphs_player"] ){
					 $game->vars["pitcher_away"] = $player_a->vars["fangraphs_player"];
					 echo "<BR>Changed Away ".$game->vars["id"]."<BR>";
					 $game->update(array("pitcher_away")); 
					// include("pitchers_away_changes.php");
				  
				 }
			  }
				
			if(!is_null($player_h)){ 
				
				
			 if ($game->vars["pitcher_home"] != $player_h->vars["fangraphs_player"] ){
				  $game->vars["pitcher_home"] = $player_h->vars["fangraphs_player"];
				   echo "<BR>changed home ".$game->vars["id"];
				   $game->update(array("pitcher_home"));          
				   //include("pitchers_home_changes.php");
			 }
			}	
		  
		
 } //espn
//break;
$i++; 
$html->clear();  

} //games
echo "<pre>";

//print_r($missed);

echo "</pre>";


?>
</div>
<div class="form_box">
  
    <table width="100%" border="0" cellspacing="0" cellpadding="10">
      <tr>
        <td  name ="game_info_" width="120"  class="table_header">Player</td>
        <td  name ="game_info_" width="120"  class="table_header">Team</td>
        <td  name ="game_info_" width="120"  class="table_header">Espn</td>
        <td  name ="game_info_" width="120"  class="table_header"></td>
      </tr>
      
      <? $i=0;
	   foreach ($missed as $miss){?>
      <?
         $espn = get_baseball_player_by_espn_nick($miss["player"]);
		 $team = get_baseball_player_by_team("fangraphs_player",$espn->vars["fangraphs_player"],$miss["team_id"],date("Y"));
		 echo "<pre>";

//print_r($team);

echo "</pre>";
      ?>  
         <? if($i % 2){$style = "1";}else{$style = "2";} $i++; ?>
	  <tr>
		<td class="table_td<? echo $style ?>" style="font-size:12px;"><? echo $miss["player"] ?></td> 
        <td class="table_td<? echo $style ?>" style="font-size:12px;"><? echo $miss["team_nam"] ?></td>
        <td class="table_td<? echo $style ?>" style="font-size:12px;"> 
        <?
          if (!is_null($espn)){ echo "Yes"; } else { echo "No Added "; }
		?>
        </td> 
         <td class="table_td<? echo $style ?>" style="font-size:12px;">
           <? if ((!is_null($espn)) && (is_null($team))){?>
			  
              <a href="pitchers_game_fix.php?player=<? echo $espn->vars["fangraphs_player"]; ?>&team=<? echo $miss["team_id"]; ?>" class="normal_link">Add to this Team
             <? } 
		     else {
				  if (!is_null($team) && (!is_null($espn)) )
				   echo "Ready";
				  }  ?>        
         </td>  
      </tr>
      <? } ?> 
      
    </table>
  
</div>
<? if($_GET["in"]){ ?><script type="text/javascript">alert("StartDate has been Updated, Please Refresh");</script><? } ?>
</body>
</html>


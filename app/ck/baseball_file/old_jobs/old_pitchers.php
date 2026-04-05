<?
require_once(ROOT_PATH . "/ck/db/handler.php"); 
require_once('../../../includes/html_dom_parser.php'); 
   
echo "-------------------------<BR>";
echo "      PITCHERS BY TEAM<br>";
echo "--------------------------";
 
$team = get_all_baseball_team();
$players = get_all_baseball_players("fangraphs_player");
 
foreach ($team as $_team){
	 
   $html = file_get_html("http://www.fangraphs.com/leaders.aspx?pos=all&stats=pit&lg=all&qual=0&type=8&season=2011&month=0&season1=2011&ind=0&team=".$_team["fangraphs_team"]."&rost=0&age=0&filter=&players=0"); 
   echo "http://www.fangraphs.com/leaders.aspx?pos=all&stats=pit&lg=all&qual=0&type=8&season=2011&month=0&season1=2011&ind=0&team=".$_team["fangraphs_team"]."&rost=0&age=0&filter=&players=0";  
 ?>
  <BR> <BR>
  <table width="25%" border="1" cellspacing="0" cellpadding="0">
  
    <tr> 
     <? echo $_team["team_name"];?>
    </tr>
    <tr>
     <td class="table_header">ID </td>
     <td class="table_header">Pos</td>
     <td class="table_header">Player</td>
 
   <?
   $line = false;
   foreach($html->find('a') as $element) {    
    
     if (contains_ck($element->plaintext,"Export Data")) { $line = true;}
	
	 if (contains_ck($element->href,"statss.aspx?playerid") && $line == true){
       ?>
      <tr>
       <?
	   $player_id =  str_center("playerid=","&position",$element->href);	
	   $player_pos = str_center("position="," ",$element->href);	
	   $player_name = str_replace("-"," ",$element->plaintext);
	   $player_name = str_replace("'"," ",$player_name);	 
	   
	   if ($player_id != $players[$player_id]->vars["fangraphs_player"]){
		 echo "NEW: ".$player_id;
		 $new_player =  new _baseball_player();
		 $new_player->vars["fangraphs_player"] = $player_id;
		 $new_player->vars["player"] = $player_name;
 		 $new_player->vars["espn_nick"] = $player_name;
		 $new_player->vars["position"] = $player_pos;
		 $new_player->vars["fangraphs_team"] = $_team["fangraphs_team"];
		 $new_player->vars["type"] = "pitcher";
		 //$new_player->insert();   
		
		  $team_player = new _baseball_player_teams();
		  $team_player->vars["player"]=$player_id;
		  $team_player->vars["team"]=$_team["fangraphs_team"];
		  $team_player->vars["season"]= '2011';
		  //$team_player->insert();
		
		 
	   }
	   else{
		  
		  $team_player = new _baseball_player_teams();
		  $team_player->vars["player"]=$player_id;
		  $team_player->vars["team"]=$_team["fangraphs_team"];
		  $team_player->vars["season"]= '2011';
		  //$team_player->insert();
		   
		  
	  
	   }
      ?>
      <td style="font-size:12px;"><? echo $player_id ?></td>
      <td style="font-size:12px;"><? echo $player_pos ?></td>
      <td style="font-size:12px;"><? echo $player_name ?></td>
      </tr>
      <?
	 }
  }
   ?></table> <?
    $html->clear(); 
}

?>
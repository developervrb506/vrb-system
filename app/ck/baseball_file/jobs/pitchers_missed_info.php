<? 
require_once(ROOT_PATH . "/ck/db/handler.php"); 
require_once(ROOT_PATH . '/includes/html_dom_parser.php'); 
require_once(ROOT_PATH . '/ck/baseball_file/process/functions.php');
set_time_limit(0);


$year = date('Y');
$season =  get_baseball_season($year);
$start = date('Y-m-d',strtotime($season['start']));
$today = date('Y-m-d');

//$start = "2014-10-04";
//$today = "2014-10-16";
echo "------------------------------------<BR>";
echo "     PATCH FOR MISSED PITCHERS       <br>";
echo "----------------------------------<BR><BR>";


$games = get_baseball_games_without_pitcher($start,$today);

echo count($games)."<BR>";

$i=1;
foreach ($games as $game ){
	
$game_date = date('Y-m-d',strtotime($game->vars["startdate"]));	
$year = date('Y',strtotime($game->vars["startdate"]));

	
// PITCHERS
 	
	
    echo $i.") http://scores.espn.go.com/mlb/boxscore?gameId=".$game->vars["espn_game"]."<BR>";
    $html = file_get_html("http://scores.espn.go.com/mlb/boxscore?gameId=".$game->vars["espn_game"]."");
    $next_line_roof = false;
    $next_line_umpire = false;
    $new_line=false;
    $new_pitcher = false;
    $j=0;
 
    foreach($html->find("table") as $tr) { 
	
	  //echo $tr->plaintext."<BR>";
	  if (contains_ck($tr->plaintext,'Pitchers')){
		  $new_line = true;
	  }
		 
	  if ($new_line){
	
	    foreach($tr->find('a') as $element) { 
	    
		   $new_line = false;
	    if (contains_ck($element->href,"/mlb/player/_/id/")){
				  
			   if ($j==0) {
				$pitcher_away = str_center("id/","/",$element->href);	 
				$pitcherid_away =  str_center("id","/",$element->href);	 
				$pitcher_away =  str_center("/"," ",$pitcher_away);	 	 
				$pitcherid_away =  str_center("/","/".$pitcher_away,$pitcherid_away);
				$pitcher_away = str_replace("-"," ",$pitcher_away);	 
  		        $pitcher_away = str_replace("'"," ",$pitcher_away);	
			   }
			   
			   if($j==1){
						
				$pitcher_home = str_center("id/","/",$element->href);	 
				$pitcherid_home =  str_center("id","/",$element->href);	 
				$pitcher_home =  str_center("/"," ",$pitcher_home);	 	 
				$pitcherid_home =  str_center("/","/".$pitcher_home,$pitcherid_home);	 
				$pitcher_home = str_replace("-"," ",$pitcher_home);
 		        $pitcher_home = str_replace("'"," ",$pitcher_home);				
				}
				
			  $j++; 	  
		}
	  
	   $home_team = get_baseball_team($game->vars["team_home"]); 
	   $away_team = get_baseball_team($game->vars["team_away"]); 
  	   $player_a = get_baseball_player_by_team("espn_nick",$pitcher_away,$away_team->vars["fangraphs_team"],$year);       $player_h = get_baseball_player_by_team("espn_nick",$pitcher_home,$home_team->vars["fangraphs_team"],$year); 	

	  echo "AWAY<BR>";  
	  print_r($player_a); 
	  if (is_null($player_a)){
	  echo "MISSED A ".$pitcher_away; 
	  }
	   
	  echo "<BR>HOME<BR>"; 
	  print_r($player_h);  
	  if (is_null($player_h)){
		echo "MISSED H ".$pitcher_home; 
	  }
	  
	  echo"<BR><BR>";

	  if (!is_null($player_h) && !is_null($player_a)){ 
		$game->vars["pitcher_away"] = $player_a->vars["fangraphs_player"];
		$game->vars["pitcher_home"] = $player_h->vars["fangraphs_player"];
		$game->update(array("pitcher_away","pitcher_home"));          
	   //Update the espn # for away
	       if ($player_a->vars["espn_player"]==0){
		      $player_a->vars["espn_player"] = $pitcherid_away;
		      $player_a->update(array("espn_player"));
	       }
	   //Update the espn # for Home
	       if ($player_h->vars["espn_player"]==0){
		       $player_h->vars["espn_player"] = $pitcherid_home;
		       $player_h->update(array("espn_player"));
	       }     
      // STADISTICS      
	      
	       echo "Pitcher AWAY <BR>";
	  	   $player_a = get_baseball_player_by_id("fangraphs_player",$game->vars["pitcher_away"]);
	  	   echo "http://www.fangraphs.com/statss.aspx?playerid=".$player_a->vars["fangraphs_player"]."&position=".$player_a->vars["position"]." -->".$player_a->vars["player"]."<BR>";
	  		get_player_statistics($player_a->vars["fangraphs_player"],$player_a->vars["position"],$player_a->vars["player"],$game->vars["id"],$year);
	  		echo "Pitcher HOME<BR>";
	  		$player_h = get_baseball_player_by_id("fangraphs_player",$game->vars["pitcher_home"]);
  	  		echo "http://www.fangraphs.com/statss.aspx?playerid=".$player_h->vars["fangraphs_player"]."&position=".$player_h->vars["position"]." -->".$player_h->vars["player"]."<BR>";
			get_player_statistics($player_h->vars["fangraphs_player"],$player_h->vars["position"],$player_h->vars["player"],$game->vars["id"],$year);
	  echo "<BR>--<BR>"; 
	  
	  // DATA AWAY
	  
	        echo "Pitcher AWAY <BR>";
			if ($game->vars["pitcher_away"]){
		  		$player_a = get_baseball_player_by_id("fangraphs_player",$game->vars["pitcher_away"]);
			   get_player_pitches($player_a->vars["fangraphs_player"],$player_a->vars["player"],$year,false,$game->vars["id"],$game_date);
		    }
	  // DATA HOME 	 
	  
	     	echo "Pitcher HOME<BR>";
		    if ($game->vars["pitcher_home"]){
	   			$player_h = get_baseball_player_by_id("fangraphs_player",$game->vars["pitcher_home"]);
			   get_player_pitches($player_h->vars["fangraphs_player"],$player_h->vars["player"],$year,false,$game->vars["id"],$game_date);
			} 
			
	  // DATA  VELOCITY AWAY
	  
	        echo "Pitcher AWAY <BR>";
			if ($game->vars["pitcher_away"]){
		  		$player_a = get_baseball_player_by_id("fangraphs_player",$game->vars["pitcher_away"]);
			   get_player_pitches_velocity($player_a->vars["fangraphs_player"],$player_a->vars["player"],$year,false,$game->vars["id"],$game_date);
		    }
	  // DATA  VELOCITY HOME 	 
	  
	     	echo "Pitcher HOME<BR>";
		    if ($game->vars["pitcher_home"]){
	   			$player_h = get_baseball_player_by_id("fangraphs_player",$game->vars["pitcher_home"]);
			   get_player_pitches_velocity($player_h->vars["fangraphs_player"],$player_h->vars["player"],$year,false,$game->vars["id"],$game_date);
			} 
			
			
			
			
	   // GROUNDBALL	  
	  
	  	   echo "Pitcher AWAY <BR>";
		  if ($game->vars["pitcher_away"]){
			$player_a = get_baseball_player_by_id("fangraphs_player",$game->vars["pitcher_away"]);
			get_player_ground_ball($player_a->vars["fangraphs_player"],$player_a->vars["position"],$player_a->vars["player"],$game->vars["id"],$year);
		  }
	  
		  echo "Pitcher HOME<BR>";
	  	if ($game->vars["pitcher_home"]){
			$player_h = get_baseball_player_by_id("fangraphs_player",$game->vars["pitcher_home"]);
			get_player_ground_ball($player_h->vars["fangraphs_player"],$player_h->vars["position"],$player_h->vars["player"],$game->vars["id"],$year);
	  	}
	  	   echo "<BR<BR>";
	  
	  
	   } //added pitcher.
	
$i++; 
$html->clear();  
     }
    }
  }
  
// break; 
}


?>
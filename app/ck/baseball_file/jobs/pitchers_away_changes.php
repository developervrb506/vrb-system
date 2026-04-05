<? 
		 
		    // Staditics  
		    echo "Stadistics<BR>";
	        $player_st_a = get_baseball_player_by_id("fangraphs_player",$game->vars["pitcher_away"]);
	        echo "http://www.fangraphs.com/statss.aspx?playerid=".$player_st_a->vars["fangraphs_player"]."&position=".$player_st_a->vars["position"]." -->".$player_st_a->vars["player"]."<BR>";
	  get_player_statistics($player_st_a->vars["fangraphs_player"],$player_st_a->vars["position"],$player_st_a->vars["player"],$game->vars["id"]);             
		
		   //Data stadistics
		   echo "Pitcher Away Data<BR>";
		   get_player_pitches($player_st_a->vars["fangraphs_player"],$player_st_a->vars["player"],$year,false,$game->vars["id"]);
		   
		    //Velocity stadistics
		   echo "Pitcher Away Data<BR>";
		   get_player_pitches_velocity($player_st_a->vars["fangraphs_player"],$player_st_a->vars["player"],$year,false,$game->vars["id"]);
		   
  	       //Groudball Away
   		   echo "Groundball Away<BR>";
	 	  get_player_ground_ball($player_st_a->vars["fangraphs_player"],$player_st_a->vars["position"],$player_st_a->vars["player"],$game->vars["id"]);  
	 
		
	   //Update the espn # for away
	   if (!$player_a->vars["espn_player"]){
		   $player_a->vars["espn_player"] = $pitcherid_away;
		   $player_a->update(array("espn_player"));
	   }
	   
   
	
?>
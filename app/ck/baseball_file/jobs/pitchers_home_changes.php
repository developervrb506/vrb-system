<? 
		 
		 //Stadistics
	    echo "Stadistics<BR>";
	    $player_st_h = get_baseball_player_by_id("fangraphs_player",$game->vars["pitcher_home"]);
  	    echo "http://www.fangraphs.com/statss.aspx?playerid=".$player_st_h->vars["fangraphs_player"]."&position=".$player_st_h->vars["position"]." -->".$player_st_h->vars["player"]."<BR>";
        get_player_statistics($player_st_h->vars["fangraphs_player"],$player_st_h->vars["position"],$player_st_h->vars["player"],$game->vars["id"]);
	    echo "<BR>--<BR>";
	    
		//Data stadistics
		echo "Pitcher Home Data<BR>";
		get_player_pitches($player_st_h->vars["fangraphs_player"],$player_st_h->vars["player"],$year,false,$game->vars["id"]);
	   
	   //Velocity stadistics
		echo "Pitcher Home Data<BR>";
		get_player_pitches_velocity($player_st_h->vars["fangraphs_player"],$player_st_h->vars["player"],$year,false,$game->vars["id"]);
	   
	   
	   
	    //Groundball
		echo "Groundball Home<BR>";
		get_player_ground_ball($player_st_h->vars["fangraphs_player"],$player_st_h->vars["position"],$player_st_h->vars["player"],$game->vars["id"]);
	   
	   //Update the espn # for Home
	   if (!$player_h->vars["espn_player"]){
		  $player_h->vars["espn_player"] = $pitcherid_home;
		  $player_h->update(array("espn_player"));
	   }     
   
?>
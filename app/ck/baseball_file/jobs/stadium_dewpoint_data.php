<?
require_once(ROOT_PATH . "/ck/db/handler.php"); 

set_time_limit(0);  
echo "-------------------------<BR>";
echo "     DEWPOINT  BY STADIUM  <br>";
echo "--------------------------<BR>";
 
$stadiums = get_all_baseball_stadiums();
$stadiums_dewpoint = get_all_stadium_dewpoint_avg();

$start_date = "2013-03-31";
$today = date("Y-m-d");
$indoors = false;

foreach($stadiums as $st){

 
  $data = dewpoint_avg_by_stadium($start_date,$today,$st->vars["team_id"]);
  
  echo "<pre>";
  print_r($data);
    echo "</pre>";

    if (!empty($data)){

		if($data["games"] > 0){

			 if(isset($stadiums_dewpoint[$st->vars["team_id"]])){
				   $stadiums_dewpoint[$st->vars["team_id"]]->vars["stadium"] = $st->vars["team_id"];
   				   $stadiums_dewpoint[$st->vars["team_id"]]->vars["avg_dewpoint"] = $data["avg_dewpoint"];
   				   $stadiums_dewpoint[$st->vars["team_id"]]->vars["avg_runs"] = $data["avg_runs"];				   
   				   $stadiums_dewpoint[$st->vars["team_id"]]->vars["avg_homeruns"] = $data["avg_homeruns"];				   
   				   $stadiums_dewpoint[$st->vars["team_id"]]->vars["games"] = $data["games"];
				   $stadiums_dewpoint[$st->vars["team_id"]]->update(array("avg_dewpoint","avg_runs","avg_homeruns","games"));				   				   
			  
			  }
			  else {
				 
				     $new_stadium_dewpoint = new _stadium_dewpoint_avg();
					 $new_stadium_dewpoint->vars["stadium"] = $st->vars["team_id"];
   				   	 $new_stadium_dewpoint->vars["avg_dewpoint"] = $data["avg_dewpoint"];
   				   	 $new_stadium_dewpoint->vars["avg_runs"] = $data["avg_runs"];				   
   				     $new_stadium_dewpoint->vars["avg_homeruns"] = $data["avg_homeruns"];				   
   				     $new_stadium_dewpoint->vars["games"] = $data["games"];
					 $new_stadium_dewpoint->insert();
				     
			  
			  
			  }

	  }
	
	}
 


} 


function dewpoint_avg_by_stadium($from,$to,$stadium){

       $t_runs = 0;
	   $t_homeruns = 0;
	   $t_dewpoint = 0;
	   $games = get_baseball_games_dewpoint_stadium($from,$to,$stadium);
	   if (empty($games)){
		 $data["avg_dewpoint"] = 0;  
		 $data["avg_runs"] = 0;
		 $data["avg_homeruns"] = 0;  		   		 
		 $data["games"] = 0;
		 $data["stadium"] = $stadium;	
	   }
	   else {
		   $i=0; 
		    $total_games = count($games);
		    foreach ($games as $game) { 
		
			$i++;
			
			   $t_runs = $t_runs + $game->vars["score"];
			   $t_homeruns = $t_homeruns + $game->vars["homeruns"];
			   $t_dewpoint = $t_dewpoint + $game->vars["dewpoint"];
			
			
			 
              } 
		    $avg_runs = number_format(($t_runs /$i),1);
            $avg_homeruns = number_format(($t_homeruns  /$i),1);
			$avg_dewpoints = number_format(($t_dewpoint  /$i),2);				
			
		  	$data["avg_dewpoint"]= $avg_dewpoints; 	
		   $data["avg_runs"]= $avg_runs;
		   $data["avg_homeruns"]= $avg_homeruns; 
   		   $data["games"] = $i;
		   $data["stadium"] = $stadium;			   
		}
		 return $data; 
     
}

?>
<?
require_once(ROOT_PATH . "/ck/db/handler.php"); 

set_time_limit(0);  
echo "-------------------------<BR>";
echo "     WINDS BY STADIUM  <br>";
echo "--------------------------<BR>";
 


$stadiums = get_all_baseball_stadiums();
$winds = get_baseball_wind_direction();
$stadiums_wind = get_all_stadium_wind_avg();

$start_date = "2011-03-31";
$today = date("Y-m-d");
$indoors = false;

foreach($stadiums as $st){

  foreach ($winds as $w){
  $data = wind_direction_by_stadium($start_date,$today,$st->vars["team_id"],$indoors,$w["id"],$w["direction"],$st->vars["name"]);
  

    if (!empty($data)){
      
	   foreach ($data as $d){
		   
		if($d["games"] > 0){
			 if ($d["max_runs"] >= $st->vars["max_runs"]){
				 $st->vars["max_runs"] = $d["max_runs"];
				 $st->vars["wind_runs"] = $d["wind"];
				 $st->update(array("max_runs","wind_runs"));
			 }   
			  if ($d["max_homeruns"] >= $st->vars["max_homeruns"]){
				 $st->vars["max_homeruns"] = $d["max_homeruns"];
				 $st->vars["wind_homeruns"] = $d["wind"];
				 $st->update(array("max_homeruns","wind_homeruns"));
			 }  
			 
			 if(isset($stadiums_wind[$st->vars["team_id"]."_".$d["wind"]])){
				   $stadiums_wind[$st->vars["team_id"]."_".$d["wind"]]->vars["stadium"] = $st->vars["team_id"];
   				   $stadiums_wind[$st->vars["team_id"]."_".$d["wind"]]->vars["wind"] = $d["wind"];
   				   $stadiums_wind[$st->vars["team_id"]."_".$d["wind"]]->vars["avg_runs"] = $d["avg_runs"];				   
   				   $stadiums_wind[$st->vars["team_id"]."_".$d["wind"]]->vars["avg_homeruns"] = $d["avg_homeruns"];				   
   				   $stadiums_wind[$st->vars["team_id"]."_".$d["wind"]]->vars["games"] = $d["games"];
				   $stadiums_wind[$st->vars["team_id"]."_".$d["wind"]]->update(array("avg_runs","avg_homeruns","games"));				   				   
			  
			  }
			  else {
				 
				     $new_stadium_wind = new _stadium_wind_avg();
					 $new_stadium_wind->vars["stadium"] = $st->vars["team_id"];
   				   	 $new_stadium_wind->vars["wind"] = $d["wind"];
   				   	 $new_stadium_wind->vars["avg_runs"] = $d["avg_runs"];				   
   				     $new_stadium_wind->vars["avg_homeruns"] = $d["avg_homeruns"];				   
   				     $new_stadium_wind->vars["games"] = $d["games"];
					 $new_stadium_wind->insert();
				     
			  
			  
			  }
			 
			 
			  
		}
	  }
	
	}
  
  
  
 //break;
  }
 
 
 //break;
} 


function wind_direction_by_stadium($from,$to,$stadium,$indoors,$wind,$wind_name){

       $t_runs = 0;
	   $t_homeruns = 0;
	   $games = get_baseball_games_by_wind_stadium($from,$to,$stadium,$indoors,$wind);

	   if (empty($games)){
		 $data[0]["wind"] = $wind_name;  
		 $data[0]["games"] = 0;
		 $data[0]["stadium"] = $stadium;	
	   }
	   else {
		   $i=0; 
		    foreach ($games as $game) { 
		
			$i++;
			
			   $t_runs =   $t_runs + $game->vars["score"];
			   $t_homeruns =  $t_homeruns + $game->vars["homeruns"];
			   
			    if($game->vars["score"] >= $max_runs){
				$max_runs = $game->vars["score"];
				}
				if($game->vars["homeruns"] >= $max_homeruns){
				$max_homeruns = $game->vars["homeruns"];
				}
			 
              } 
		    $avg_runs = number_format(($t_runs /$i),1);
            $avg_homeruns = number_format(($t_homeruns  /$i),1);
			
		   $data[0]["avg_runs"]= $avg_runs;
		   $data[0]["avg_homeruns"]= $avg_homeruns; 
   		   $data[0]["games"] = $i;
		   $data[0]["wind"] = $wind_name;
		   $data[0]["max_runs"] = $max_runs;
		   $data[0]["max_homeruns"] = $max_homeruns;		   		   
		   $data[0]["stadium"] = $stadium;	
		   //print_r($data);		   
		}
		 return $data; 
     
}

?>
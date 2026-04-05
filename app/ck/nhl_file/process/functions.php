




<?

function get_nhl_schedule($team1,$teams) { ;

$link = "http://www.espn.com/nhl/team/schedule/_/name/".$teams[$team1]->vars["espn_short"]."/";
echo $link."<BR>";
$html = file_get_html($link);
$year = date("Y");
$months = array("JANUARY","FEBRUARY","MARCH","APRIL","MAY","JUNE","JULY","AUGUST","SEPTEMBER","OCTOBER","NOVEMBER","DECEMBER");
$month_year = array();  // NOTE CHANGE THE - 1 or  +1 Acording the season
$month_year["JANUARY"] = $year    ;
$month_year["FEBRUARY"] = $year   ;
$month_year["MARCH"] = $year   ;
$month_year["APRIL"] = $year  ;
$month_year["MAY"] = $year  ;
$month_year["JUNE"] = $year   ;
$month_year["JULY"] = $year   ;
$month_year["AUGUST"] = $year  ;
$month_year["SEPTEMBER"] = $year   ;
$month_year["OCTOBER"] = $year -1 ;
$month_year["NOVEMBER"] = $year -1 ;
$month_year["DECEMBER"] = $year - 1 ;


$month_year["JAN"] = $year   ;
$month_year["FEB"] = $year  ;
$month_year["MAR"] = $year   ;
$month_year["APR"] = $year   ;
$month_year["MAY"] = $year   ;
$month_year["JUN"] = $year  ;
$month_year["JUL"] = $year  ;
$month_year["AUG"] = $year  ;
$month_year["SEP"] = $year  ;
$month_year["OCT"] = $year - 1;
$month_year["NOV"] = $year - 1 ;
$month_year["DEC"] = $year - 1 ;


$schedule = array();


	
 foreach ($html->find('div[class="Table__Scroller"]') as $div){ // Div 

         $k=0;
		 $valid = false;
		// print_r($div);
		 foreach($div->find("table tr") as $tr) { // tr    
 		   
		 $valid = true;
		   /*  if(!$valid){
		        if (contains_ck($tr->plaintext,"Regular")){ $valid = true;} 
			 }*/
		    if($valid){ 
			  if (contains_ck($tr->plaintext,"Date")){ $valid = false; } 
			}
			//echo $tr->plaintext."<BR>";
		   if($valid){
			// echo $tr->plaintext."<BR>";
			if($k>=0){ // k
			    $line = true;
				$j=0;

			
				
				foreach ($tr->find("td") as $td){  //td
				  $j++;
				   if(in_array($td->plaintext,$months)){ $line = false; $month = $td->plaintext;}
					if($line){ //line
					   //DATE
					   if($j==1){ // 1
						    $small_month = trim(strtoupper(substr($td->plaintext,5,3)));
						   $date = $td->plaintext." ".$month_year[$small_month];
						   //$date = $td->plaintext." ".$month_year[$month];
						   $schedule[$k]["date"]=  date("Y-m-d",strtotime($date)); // I put -5 to patch the date no idea why.
						  //echo date("Y-m-d",strtotime( "-5 day",strtotime($date))). " - ";
					   } // 1
					   //VS
					   	if($j==2){ //2
						   $home = false;
						   if (contains_ck($td->plaintext,"vs")){  $home = true; }
						  
						    foreach($td->find('a') as $a){  //a
							  
							  $team2 = str_center('name/','/', $a->href);
							  $team2 = explode("/",$team2);
							  
							 
							 
							  if($home){
								  $schedule[$k]["home"]=  $teams[$team1]->vars["id"];	
								  $schedule[$k]["away"]=  $teams[$team2[0]]->vars["id"];
								  $schedule[$k]["away_name"]=  $teams[$team2[0]]->vars["team"];
								  $schedule[$k]["home_name"]=  $teams[$team1]->vars["team"];								  
								   								  	
							  }
							  else {
							      $schedule[$k]["away"]=  $teams[$team1]->vars["id"];	
								  $schedule[$k]["home"]=  $teams[$team2[0]]->vars["id"];
								   $schedule[$k]["home_name"]= $teams[$team2[0]]->vars["team"];
								  $schedule[$k]["away_name"]=  $teams[$team1]->vars["team"];	 

							   }
							 // echo $schedule[$k]["home_name"]. " - ".$schedule[$k]["away_name"]." - ";
							   
							} //a
						  
					    } // 2
					   if($j==3){ // 3
						   
						   $row = str_replace(" OT","",$td->plaintext);

						   if (!contains_ck($row,"Post") && !contains_ck($row,"PM")){
							   
							   
							   //Getting ESPN ID
							    foreach($td->find('a') as $a2){  //a
							      $espn_id = str_center('gameId/','--', $a2->href."--");
  							      $espn_id = str_replace("cap?id=","",$espn_id);
  							      $espn_id = str_replace("xscore?id=","",$espn_id);								  
 								  
								  $schedule[$k]["espn_id"] = $espn_id;
								  
								}
							
							   if (contains_ck($row,"L")){ 
								 $schedule[$k]["win_team"] = $teams[$team2[0]]->vars["id"];
								 $row = str_replace("L ","",$row);
							   }
							   if (contains_ck($row,"W")){ 
								$schedule[$k]["win_team"] = $teams[$team1]->vars["id"];;	
								$row = str_replace("W ","",$row);
							   }
							   $result = explode("-",$row);
							   if($schedule[$k]["win_team"]== $teams[$team1]->vars["id"]){
								$schedule[$k]["points_home"] = $result[0];
								$schedule[$k]["points_away"] = $result[1];
							   } 
							   if($schedule[$k]["win_team"]== $teams[$team2[0]]->vars["id"]){
								$schedule[$k]["points_home"] = $result[1];
								$schedule[$k]["points_away"] = $result[0];
							   }
						   }
						   else {
							  $schedule[$k]["win_team"] = 0;
							  $schedule[$k]["points_home"] = 0;
							  $schedule[$k]["points_away"] = 0;
							   $schedule[$k]["espn_id"] = 0;
						    }
						    // echo $schedule[$k]["espn_id"]."<BR>";
					   } //3
					
					
					
					  if($j>=3){break;}
					} // Line
				} //Td
				//echo "<BR>";
				
			} // k
			 
			 
			
			$k++;
			
		   }//Valid
		} // tr
break;
	} //div
	
return $schedule;
}


function get_nhl_team_distance($link,$teams){
$distance = array();
//echo "<pre>";


$html = file_get_html($link);
 foreach ($html->find('div[id="main"]') as $div){ // Div 
 
   $j=0;
   $line = false;
   foreach ($div->find('table') as $table){ 
 
	   	 foreach($table->find("tr") as $tr) { 
		     // echo $tr->plaintext.'<BR>';
			if(contains_ck($tr->plaintext,"Total")){break;}	
		  	if($line){
			 $i=0;	
			   foreach($tr->find("td") as $td) { $i++;
			       if($i==1){
					 foreach($td->find("a") as $a){
						 $team_name = $a->plaintext;
					  break;
					 }
					 
					 $team_id = $teams[trim($team_name)]->vars["id"];  
				     $distance[$team_id]["team"] = $team_name;
 				     $distance[$team_id]["id"] = $team_id; 					 
				   }
				   if($i==3){
					   $distance[$team_id]["distance"] = str_replace(" ","",$td->plaintext);
					 }
			   // echo $i.") ".$td->plaintext."  -  ";
			   }
			}
		  if(contains_ck($tr->plaintext,"Distance")){$line = true;}	
		 // echo "<BR>";
		 }
		 
	
   }
   // Div 
 }
  
  //print_r($distance);
  //echo "</pre>";
  return $distance;
}


function get_nhl_scores($espn_id) { ;

$link = "http://www.espn.com/nhl/boxscore?gameId=".$espn_id;
$html = file_get_html_parts(0,250,$link);

//echo $link;

$data = array();


	
// foreach ($html->find('table[class="Table2__table__wrapper"]') as $div){ // Div 
 foreach ($html->find('div[class="Table__Scroller"]') as $div){ // Div 
      // print_r($div);
	    $j=0;
		 foreach($div->find("table tr") as $tr) { // tr    
 		  
				
				//echo $j.")".$tr->plaintext."<BR>";
				$k=0;
				$tds = $tr->find("td"); 
				foreach ($tds as $td){  //td
				  $rows = count($tds);
					  if($j==1){//away
							 if($k==1){
							   $data["away"]["1"] = $td->plaintext;
							 }
							 if($k==2){
							   $data["away"]["2"] = $td->plaintext;
							 }
							 if($k==3){
							   $data["away"]["3"] = $td->plaintext;
							 }
							/* if($k==4){
							   $data["away"]["4"] = $td->plaintext;
							 }*/
							 if ($rows > 5){
							   if($k==4){
								 $data["away"]["ot"] = $td->plaintext;
							   }	
							   if($k==5){
								 $data["away"]["t"] = $td->plaintext;
							   }	 
		 
							}else {
							  if($k==4){
								 $data["away"]["ot"] = 0; 
								 $data["away"]["t"] = $td->plaintext;
							  }
							} 	 
					   }
					   if($j==2){//Home
					         //echo $k.")".$td->plaintext." - ";
							 if($k==1){
							   $data["home"]["1"] = $td->plaintext;
							 }
							 if($k==2){
							   $data["home"]["2"] = $td->plaintext;
							 }
							 if($k==3){
							   $data["home"]["3"] = $td->plaintext;
							 }
							/* if($k==4){
							   $data["home"]["4"] = $td->plaintext;
							 }*/
							 if ($rows > 5){
							   if($k==4){
								 $data["home"]["ot"] = $td->plaintext;
							   }	
							   if($k==5){
								 $data["home"]["t"] = $td->plaintext;
							   }	 
		 
							}else {
							  if($k==4){
								 $data["home"]["ot"] = 0; 
								 $data["home"]["t"] = $td->plaintext;
							 }	 
					        }
				      }
				 
				 
				  $k++; 
				  
				} //Td
				$j++;
				echo "<BR>";
			
		} // tr
break;
	} //div
	
	
return $data;
}

function get_nhl_team_travel_info($schedule,$distance,$team,$index,$days,$action){
	//$schedule =  geb_nhl_schedule_by_team($team,$season);
	
	switch ($action){
		case  'restdays':
		       $result = get_day_diff($schedule[$index]->vars["date"],$schedule[($index-$days)+1]->vars["date"]) + 1;
			   
			   break;
       case  'away':
		       $result = 0;
			   $index = ($index-$days)+1;
			   for ($i=0;$i<$days;$i++){
				 if($schedule[$index]->vars["team_away"] == $team){$result++;} 
				 $index++;  
			   }
			   break; 
	   case  'miles':
		       $result = 0;
			   $index = ($index-$days)+1;
			   $prev = $index - 1 ;
			   $past = false; // check if the past game is away.
			   // Here Check if came from a Route
			   if($schedule[$prev]->vars["team_away"] == $team) {
				  if($schedule[$index]->vars["team_away"] == $team) { 
				    $past = true;$result = $distance[$schedule[$prev]->vars["team_home"]."_".$schedule[$index]->vars["team_home"]]->vars["distance"]; 
				  //  echo "*";
				  }else {
 				  //  echo "--"; 
					  $past = true;
					$result = $distance[$team."_".$schedule[$prev]->vars["team_home"]]->vars["distance"];   
					  }
				}
				if($past){
				// echo $result." : ".$schedule[$prev]->vars["team_home"]." a ".$schedule[$index]->vars["team_home"]." / <BR>"; 	
				}
			   for ($i=0;$i<$days;$i++){
				
				if($i==0){
					//echo $schedule[$index]->vars["date"]."<BR>";
				   if($schedule[$index]->vars["team_home"] == $team) { $result = $result + 0;  }
				   if($schedule[$index]->vars["team_away"] == $team) {
			         if($schedule[$prev]->vars["team_away"] == $team && !$past) { 
					   $result = $result + $distance[$schedule[$prev]->vars["team_home"]."_".$schedule[$index]->vars["team_home"]]->vars["distance"]; 
					 }/* else  if($schedule[$i]->vars["team_away"] == $team && $past) { 
					   $result = $result + $distance[$schedule[$prev]->vars["team_home"]."_".$schedule[$index]->vars["team_home"]]->vars["distance"]; 					    
					 }*/
					 else {
					  if($schedule[$prev]->vars["team_away"] != $team){
					   $result = $result + $distance[$team."_".$schedule[$index]->vars["team_home"]]->vars["distance"]; 	
					  } else {
						//$result = $result + $distance[$schedule[$index]->vars["team_home"]."_".$schedule[$index+1]->vars["team_home"]]->vars["distance"];
						 	  
						  }
					//  }else{
					//	$result = $result + $distance[$schedule[$prev]->vars["team_home"]."_".$schedule[$index+1]->vars["team_home"]]->vars["distance"];   
					 // }
					}
					 
					 
				 }
				 //if($past){echo "0) ".$result."<BR>";}
				}else{
					//echo "##".$schedule[$index]->vars["date"]."<BR>";
				 
				 /*
				  //Flying Home	
				  if(!$past ){
				   if($schedule[$index]->vars["team_home"] == $team && $schedule[$index-1]->vars["team_away"] == $team) { $result = $result + $distance[$schedule[$index]->vars["team_home"]."_".$schedule[$index-1]->vars["team_home"]]->vars["distance"];}
				  echo "a/";
				  }
				  if($past && $i!= 1 ){
				  if($schedule[$index]->vars["team_home"] == $team && $schedule[$index-1]->vars["team_away"] == $team) { $result = $result + $distance[$schedule[$index]->vars["team_home"]."_".$schedule[$index-1]->vars["team_home"]]->vars["distance"];
 				  echo "b/";
				  }
				  }
				  
				  if($schedule[$index]->vars["team_away"] == $team && $schedule[$index-1]->vars["team_away"] == $team && $schedule[$index+1]->vars["team_away"] == $team  ){
					 $result = $result + $distance[$schedule[$index]->vars["team_home"]."_".$schedule[$index+1]->vars["team_home"]]->vars["distance"]; 
				   echo "c/";
				   } else  if($schedule[$index]->vars["team_away"] == $team && $schedule[$index-1]->vars["team_away"] == $team ){
					 $result = $result + $distance[$schedule[$index]->vars["team_home"]."_".$schedule[$index-1]->vars["team_home"]]->vars["distance"]; 
				   echo "f/";
				   }
				   
				   
				  if($schedule[$index]->vars["team_away"] == $team && $schedule[$index-1]->vars["team_away"] != $team) { $result = $result + $distance[$team."_".$schedule[$index]->vars["team_home"]]->vars["distance"]; 				  echo "d/";}	
  				  */
				  //Check Before
				   // Coming Away to Home
				  if($schedule[$index-1]->vars["team_away"] == $team && $schedule[$index]->vars["team_home"] == $team){
					 $result = $result + $distance[$schedule[$index]->vars["team_home"]."_".$schedule[$index-1]->vars["team_home"]]->vars["distance"];   
					// echo "a/";
				  }
				  // Coming Away to Away
				 if($schedule[$index-1]->vars["team_away"] == $team && $schedule[$index]->vars["team_away"] == $team){
					 $result = $result + $distance[$schedule[$index-1]->vars["team_home"]."_".$schedule[$index]->vars["team_home"]]->vars["distance"];   
				  // echo "b/";
				  }
				    // Coming Home to Away
				 if($schedule[$index-1]->vars["team_home"] == $team && $schedule[$index]->vars["team_away"] == $team ){
					 $result = $result + $distance[$schedule[$index-1]->vars["team_home"]."_".$schedule[$index]->vars["team_home"]]->vars["distance"];   
				 // echo "c/";
				  }
				  
				
				  
				
				// if($past){echo "$i) ".$result."<BR>";}
				  
			    }
				 
			   $index++; 	   
			   }
			   break; 			   
		default:
		        break;
		
		
		
	}
	return $result;
	
 }
 
 function check_line($team,$p_away,$p_home,$line,$type){
	 
   
  if($line != ""){
   $line=str_replace("EV","+100",$line);	 
   $sign = $line[0];
   $line[0] = " ";
   $preline = $line;
   $preline = str_replace("-","/",$preline);
   $preline = str_replace("+","/",$preline);			 
   $points = explode("/",$preline);
   $points = trim($points[0]); 
 }
   
   switch($type){
	   
    case 'spread':
			 
			 
			 // echo $line[0];
			if($team == 'away'){
			 
			     if($sign == "+"){
				    $result = (int)$p_away + $points;
				 }  
				 if($sign == "-"){
			        $result = (int)$p_away - $points; 
				 }
				if($result > $p_home) {$data = '+<span style="font-size:16px;color:Green"><strong>W</strong></span>'; }  
				if($result < $p_home) {$data = '-<span style="font-size:16px;color:red"><strong>L</strong></span>'; }  					
				if($result == $p_home) {$data = '=<span style="font-size:16px;color:Gray"><strong>P</strong></span>'; }  					
					
			}else{
   		        if($sign == "+"){
				    $result = (int)$p_home + $points;
				 }  
				 if($sign == "-"){
					//echo $p_home
				    $result = (int)$p_home - $points; 
				 }
				if($result > $p_away) {$data = '+<span style="font-size:16px;color:Green"><strong>W</strong></span>'; }  
				if($result < $p_away) {$data = '-<span style="font-size:16px;color:red"><strong>L</strong></span>'; }  					
				if($result == $p_away) {$data = '=<span style="font-size:16px;color:Gray"><strong>P</strong></span>'; }  					
				
			
			}
			
      	  
		  break;
		  case "total":
		    $result = (int)$p_away + (int)$p_home;
			$points = (int)$points;
			if($sign == "u"){
				if($result < $points) {$data = '+<span style="font-size:16px;color:Green"><strong>W</strong></span>'; }  
				if($result > $points) {$data = '-<span style="font-size:16px;color:red"><strong>L</strong></span>'; }  					
				if($result == $points) {$data = '=<span style="font-size:16px;color:Gray"><strong>P</strong></span>'; }  					
			}
    	   
		   if($sign == "o"){
				if($result > $points) {$data = '+<span style="font-size:16px;color:Green"><strong>W</strong></span>'; }  
				if($result < $points) {$data = '-<span style="font-size:16px;color:red"><strong>L</strong></span>'; }  					
				if($result == $points) {$data = '=<span style="font-size:16px;color:Gray"><strong>P</strong></span>'; }  					
			}
	  
		  
		  break;	
		  
		  case "money":
		  
			if($team == 'away'){
				if($p_away > $p_home) {$data = '+<span style="font-size:16px;color:Green"><strong>W</strong></span>'; }  
				if($p_home > $p_away) {$data = '-<span style="font-size:16px;color:red"><strong>L</strong></span>'; }  					
				if($p_home == $p_away) {$data = '=<span style="font-size:16px;color:Gray"><strong>P</strong></span>'; }  					
			} else {
				if($p_away < $p_home) {$data = '+<span style="font-size:16px;color:Green"><strong>W</strong></span>'; }  
				if($p_home < $p_away) {$data = '-<span style="font-size:16px;color:red"><strong>L</strong></span>'; }  					
				if($p_home == $p_away) {$data = '=<span style="font-size:16px;color:Gray"><strong>P</strong></span>'; }  					
				
		   }
	  
		  
		  break;	   
  
  
     }	 
	 return($data);

 }


function get_vs_rest_days($team,$date){

	$date_away = get_nhl_last_team_game ($team,$date,"away");
	$date_home =  get_nhl_last_team_game ($team,$date,"home");

	if($date_away["date"]>$date_home["date"]){
	  return $date_away["date"];	
	} else { 	 return $date_home["date"];}

}




?>
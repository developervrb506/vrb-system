<?

//Baseball

function get_parkfactor($stadiumid,$gameid,$year){
	
 $html = file_get_html("http://espn.go.com/mlb/stats/parkfactor");
 $print_line = false;
 $data = array();
	  
	  ?>
	   <table width="25%" border="1" cellspacing="0" cellpadding="0"> 
		  <tr>
		   <td class="table_header">Park Name</td>
		   <td class="table_header">Runs</td>
		   <td class="table_header">HR</td>
		   <td class="table_header">H</td>
		   <td class="table_header">2b</td>        
   		   <td class="table_header">3b</td>
		   <td class="table_header">BB</td>
		   </tr>
		  <?

	  foreach($html->find("table tr") as $element) {     

 		  
		    foreach ($element->find("td") as $td){
	           
			   if ($print_line){
			   $line++;   
			   //echo $td->plaintext."   ----  ".$td->a."<BR>";    
			   }
			   
			   if (contains_ck($td->plaintext,"BB")){
			   $print_line = true;
			   $line=-1;
			   }
			   
			   if ( $line == 1 && $print_line == true){
				   
				    $park = myStrstrTrue($td->plaintext," (",true);
					$data['stadium'] = $park;
			    ?><tr>
			        <td style="font-size:12px;"><? echo $park ?></td>
			    <? 
		 	   }
			   if ( $line == 2 && $print_line == true){
				    $data['runs'] = $td->plaintext;				  
				?>
			        <td style="font-size:12px;"><? echo $td->plaintext ?></td>
			    <? 
		 	   }
   			   if ( $line == 3 && $print_line == true){
				    $data['hr'] = $td->plaintext;
				?>
			        <td style="font-size:12px;"><? echo $td->plaintext ?></td>
			    <? 
		 	   }
   			   if ( $line == 4 && $print_line == true){
				    $data['h'] = $td->plaintext; 
				?>
			        <td style="font-size:12px;"><? echo $td->plaintext ?></td>
			    <? 
		 	   }
   			   if ( $line == 5 && $print_line == true){
				   $data['2b'] = $td->plaintext;
				?>
			        <td style="font-size:12px;"><? echo $td->plaintext ?></td>
			    <? 
		 	   }
   			   if ( $line == 6 && $print_line == true){
				   $data['3b'] = $td->plaintext;
				?>
			        <td style="font-size:12px;"><? echo $td->plaintext ?></td>
			    <? 
		 	   }
   			   if ( $line == 7 && $print_line == true){
				   $data['bb'] = $td->plaintext;
				?>
			        <td style="font-size:12px;"><? echo $td->plaintext ?></td>
			        </tr>
                <? 
				 print_r($data['stadium']);
				 $stadium_data = get_baseball_stadium_by_name($data['stadium']);
				 
				
   				 $line=-1; 
				 if ($stadium_data->vars['id'] == $stadiumid){

			     
				 	$stadium_stadistics =  get_baseball_stadium_stadistics($stadiumid,$gameid);
				 
				 
				   if (is_null($stadium_stadistics)){
					   $stadium_stadistics = new _baseball_stadium_stadistics_by_game();
					   $stadium_stadistics->vars["stadium"] = $stadium_data->vars["id"];
					   $stadium_stadistics->vars["game"] = $gameid;
					   $stadium_stadistics->vars["runs"] = $data["runs"];
					   $stadium_stadistics->vars["homeruns"] = $data["hr"];
					   $stadium_stadistics->vars["hits"] = $data["h"];				 
					   $stadium_stadistics->vars["doubles"] = $data["2b"];				 
					   $stadium_stadistics->vars["triples"] = $data["3b"];				 
					   $stadium_stadistics->vars["walks"] = $data["bb"];
					   $stadium_stadistics->vars["season"] = $year;
					   $stadium_stadistics->insert();
					   echo "inserted";					 				 
				   }
				 }
		        
			   }
			  	
    	 }
	
  }?></table><BR><BR><?
	  

   	 $html->clear(); 
	 
}

function get_player_pitches($playerid,$player_name,$year,$last_season=false,$gameid){

	 if (!$last_season){
	    
	   $statistics = get_player_basic_stadistics($playerid,($year-1),true,0);
	   
	    
	    if (is_null($statistics)){
	      echo "Last Season<BR>";
	      get_player_pitches($playerid,$player_name,($year-1),true,"");
	      $last_season=false;
		  
	   }
	  }

 	 echo "---------------->".$link."<BR>";
 	 echo $player_name;
     $link_name = strtolower(str_replace(" ", "-", $player_name)) ;
     $link = "https://www.fangraphs.com/players/".$link_name."/".$playerid."/game-log?position=P&type=4&gds=&gde=&season=".$year."";
     echo $link."<BR>";
 	 echo $player_name;
 	  exit;
	 echo file_get_contents("http://www.oddessa.com/fansgraphs_bridge.php?v1=".$playerid."&v2=".$year."&v3=".$last_season."&action=pitches&link=".$link);
	 echo "http://www.oddessa.com/fansgraphs_bridge.php?v1=".$playerid."&v2=".$year."&v3=".$last_season."&action=pitches&link=".$link;
	 exit;
	 //$data = file_get_contents("http://www.oddessa.com/fansgraphs_bridge.php?v1=".$playerid."&v2=".$year."&v3=".$last_season."&action=pitches&link=".$link);
	 $data =  json_decode($data, true);
	 
	     echo "<pre>";
		// print_r($data);
		 echo "</pre>";
		 
	  if (!empty($data)){	
    
		   if ($last_season){
			   echo "LAST**";
				 $statistics = new _baseball_player_stadistics_by_game();  
				 $statistics->vars["fangraphs_player"] = $playerid;
				 $statistics->vars["season"] = $year;
				 $statistics->vars["game"] = 0;
	 			 $rest_time="0"; 
				
		   }
		   else {	 
		   
			 $diff = abs(strtotime(date('Y-m-d')) - strtotime($data["date"]));
			 $years = floor($diff / (365*60*60*24));
			 $months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
			 $days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));
			 $rest_time=" "; 
	
			 if ($years){
			   $rest_time = $years." years, ";   
			 }
			 if ($months){   
			   $rest_time.= $months. " months, ";	 
			 }
			 if ($days){   
			   $rest_time.= $days. " days";	 
			 }
			 
			 $statistics = get_player_basic_stadistics($playerid,$year,false,$gameid);
			 //print_r($statistics);
			 
			 if (is_null($statistics)){
				$last_season = true; 
			    $statistics = new _baseball_player_stadistics_by_game();  
			    $statistics->vars["fangraphs_player"] = $playerid;
			 }
		  
		  }
		 
		    if ($data["j"]==1){
		      $rest_time ='0'; // To control that players that does not have any game this season
			} 
	
	 
		 $statistics->vars["season"] = $year;
		 $statistics->vars["game"] = $gameid;
		 $statistics->vars["rest_time"] = $rest_time;
		 $statistics->vars["total_last_game"] = $data["total_last_game"];
		 $statistics->vars["avg_last_games"] = $data["avg_last_games"];
		 $statistics->vars["sum_last_games"] =  $data["sum_last_games"];
		 $statistics->vars["avg_season"] = $data["avg_season"];
		 $statistics->vars["avg_last_four_games"] = $data["avg_last_four_games"];
		 $statistics->vars["sum_last_four_games"] =  $data["sum_last_four_games"];
	     $statistics->vars["avg_last_five_games"] = $data["avg_last_five_games"];
		 $statistics->vars["sum_last_five_games"] =  $data["sum_last_five_games"];
		 
		   if (!$last_season){
      		  $statistics->update(array("season","rest_time","total_last_game","avg_last_games","sum_last_games","avg_season","avg_last_four_games","sum_last_four_games","avg_last_five_games","sum_last_five_games")); 
		  echo "UPDATE NOW";
		  }
		  else{
			 if(!is_null($statistics)){
			  $statistics->insert(); 
			  		  echo "INSERT NOW";
			 }
		  }

		 echo "<pre>";
		 print_r($data);
		 echo "</pre>";
		 echo $rest_time;
		 echo "<BR>";
	   //  $html->clear();
	 }//empty html
	 else{ 
	    $data = array();
	    echo "Error: ".$link."<BR>";
	 }	 
	
  return $data;	
	
}

/*
function get_player_pitches($playerid,$player_name,$year,$last_season=false,$gameid){

	 if (!$last_season){
	    
	   $statistics = get_player_basic_stadistics($playerid,($year-1),true,0);
	
	    if (is_null($statistics)){
	      echo "Last Season<BR>";
	      get_player_pitches($playerid,$player_name,($year-1),true,"");
	      $last_season=false;
	   }
	  }
	
	$html = file_get_html_parts(80000,0,"http://www.fangraphs.com/statsd.aspx?playerid=".$playerid."&position=P&type=4&season=".$year."");
	
	echo "http://www.fangraphs.com/statsd.aspx?playerid=".$playerid."&position=P&type=4&season=".$year."";
		  
	  ?>
	  <table width="25%" border="1" cellspacing="0" cellpadding="0">
			
	  <tr> 
	    <? echo $_team["team_name"];?>
	  </tr>
	  <tr>
	    <td class="table_header">Date</td>
	    <td class="table_header">Team</td>
	    <td class="table_header">Opp</td>
	    <td class="table_header">Pitches</td>
	  </tr>
	  <tr> 
	    <? echo $player_name ?><BR>
	  </tr>
 	  <tr>
	  <?
		  
		  $data = array();
		  $data["date"] = 0;
		  $data["total_last_game"] = 0;
		  $data["avg_last_games"] = 0;
		  $data["avg_season"] = 0;
		  $data["total_season"] = 0;
		  $data["sum_last_games"]=0;
		  $last_games = 3; // Only the info for the last 3 games is required
		 
		  // 2014-21-5 Information for  4G and 5G were requested
		  $data["avg_last_four_games"] = 0;
		  $data["sum_last_four_games"] =0;
		  $four_games = 4;
		  
		  $data["avg_last_five_games"] = 0;
		  $data["sum_last_five_games"] =0;
		  $five_games = 5;
		  
		  $cant_columns = 15; // the table has 15 colums
		  $i=1;
		  $j=1;
		  $break = false;
		  $m = 0;
		  
		  foreach($html->find("Table.rgMasterTable td") as $element) { 
		 
	       if ($i == 1 && $element->plaintext == "Total") { // We need to jump 30 columns beacause the total was changed up
		    $break = true;
		   }
		   
	      if ($break){
			$m++;
			if ($m >= 30){
				 //echo $element->plaintext."-s--s<BR>";
				 $break = false;}   
		  } 
		  else {
		   
	    	if ($i==1){ 
			   if ($j==1){
				$data["date"] = $element->plaintext;
			   }
			 ?> <td style="font-size:12px;"><? echo $element->plaintext ?></td><?
			}
			 if ($i==2){
			 ?> <td style="font-size:12px;"><? echo $element->plaintext ?></td><?
			 }
			 if ($i==3){
			 ?> <td style="font-size:12px;"><? echo $element->plaintext ?></td><?
			 }
	     	
			if ($i == $cant_columns){
			  $i=0;
			  
			  if ($j <= $last_games){  
				if ($j==1){
				  $data["total_last_game"] = $element->plaintext;
				 }
				$data["sum_last_games"] = ($data["sum_last_games"] + $element->plaintext);
			  }
			  
			  if ($j <= $four_games){  
				
				$data["sum_last_four_games"] = ($data["sum_last_four_games"] + $element->plaintext);
			  }
			  if ($j <= $five_games){  
				
				$data["sum_last_five_games"] = ($data["sum_last_five_games"] + $element->plaintext);
			  }
			  
			  
			  
			  
			  $data["total_season"]= ($data["total_season"] + $element->plaintext);
			  $j++;
			  ?>
			  <td style="font-size:12px;"><? echo $element->plaintext ?></td>
			  </tr><tr><?	  
			}
		    $i++;
			
		  } //control break false
		  } ?></tr></table><BR><?
		 
		   $j--;
		   if (is_null($element) && $last_season == false ){
			echo "NO DATA";
			$data["date"]= date("Y-m-d");   
			$j=1;
		   }
		   else{
		      if ($j<=0){ //To avoid Division by Zero
			  $j=1;
			  }
		   }
		  
		   $data["avg_last_games"] = round($data["sum_last_games"] / $last_games);
		   $data["avg_last_four_games"] = round($data["sum_last_four_games"] / $four_games);
		   $data["avg_last_five_games"] = round($data["sum_last_five_games"] / $five_games);
		   $data["avg_season"] = round($data["total_season"] / $j);
		  
		   if ($last_season){
			 $statistics = new _baseball_player_stadistics_by_game();  
			 $statistics->vars["fangraphs_player"] = $playerid;
			 $rest_time="0"; 
		   }
		   else {	 
		   
			 $diff = abs(strtotime(date('Y-m-d')) - strtotime($data["date"]));
			 $years = floor($diff / (365*60*60*24));
			 $months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
			 $days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));
			 $rest_time=" "; 
	
			 if ($years){
			   $rest_time = $years." years, ";   
			 }
			 if ($months){   
			   $rest_time.= $months. " months, ";	 
			 }
			 if ($days){   
			   $rest_time.= $days. " days";	 
			 }
			 
			 $statistics = get_player_basic_stadistics($playerid,$year,false,$gameid);
			 if (is_null($statistics)){
				$last_season = true; 
			    $statistics = new _baseball_player_stadistics_by_game();  
			    $statistics->vars["fangraphs_player"] = $playerid;
			 }
		  
		  }
		 
		 if ($j==1){
		    $rest_time ='0'; // To control that players that does not have any game this season
	     } 
		  
		 $statistics->vars["season"] = $year;
		 $statistics->vars["game"] = $gameid;
		 $statistics->vars["rest_time"] = $rest_time;
		 $statistics->vars["total_last_game"] = $data["total_last_game"];
		 $statistics->vars["avg_last_games"] = $data["avg_last_games"];
		 $statistics->vars["sum_last_games"] =  $data["sum_last_games"];
		 $statistics->vars["avg_season"] = $data["avg_season"];
		 $statistics->vars["avg_last_four_games"] = $data["avg_last_four_games"];
		 $statistics->vars["sum_last_four_games"] =  $data["sum_last_four_games"];
	     $statistics->vars["avg_last_five_games"] = $data["avg_last_five_games"];
		 $statistics->vars["sum_last_five_games"] =  $data["sum_last_five_games"];
		 
		   if (!$last_season){
      		   $statistics->update(array("season","rest_time","total_last_game","avg_last_games","sum_last_games","avg_season","avg_last_four_games","sum_last_four_games","avg_last_five_games","sum_last_five_games")); 
		  }
		  else{
			 $statistics->insert(); 	    
		  }

		 echo "<pre>";
		 print_r($data);
		 echo "</pre>";
		 echo "<BR>";
	     $html->clear();
	
}
*/

function get_player_ground_ball($playerid,$position,$player_name,$gameid){
	
 $link = "http://www.fangraphs.com/statss.aspx?playerid=".$playerid."&position=".$position."";
   $link = "http://www.oddessa.com/fansgraphs_bridge.php?link=".$link;
    echo $link;
 $html = file_get_html_parts(0,2,$link);
 
 echo "http://www.fangraphs.com/statss.aspx?playerid=".$playerid."&position=".$position."";
	  
	  $year = date("Y");
	  $new_line = false;
	  $total = false;
	  $lines=0;
	  $cant_columns = 19; 
	  $td = 0; // to control Cant of td to be displayed 

	  
	  //table colums
	  $colums = array();
	  $colums["season"] = "";
	  $colums["gb"] = 0;
	  $colums["gb_total"] = 0;
	  
	  
	  ?>
	   <table width="25%" border="1" cellspacing="0" cellpadding="0">
		
		  <tr> 
		   <? echo $_team["team_name"];?>
		  </tr>
		  <tr>
		   <td class="table_header">Season</td>
		   <td class="table_header">Team</td>
		   <td class="table_header">k9</td>           
		   <td class="table_header">GB%</td>
		   </tr>
		  <tr> 
		   <? echo $player_name ?><BR>
		  </tr>  
		  <?
	
	  
	  $x = substr($year,0,2);
	  $season = $x + 8; // That is because 2013 start with season11 in the table class
	 	  
	  foreach($html->find("Table.SeasonStats1_dgSeason".$season."_ctl00] td") as $element) {     

			 if ($element->plaintext == $year){
			  ?><tr><?
			  $new_line = true;  
			  $lines = 0;
 			 }
			
			if ($new_line){ 
			  $lines++;
			 
			  if($lines == 1 ) {
			    ?>
			      <td style="font-size:12px;"><? echo $element->plaintext ?></td>
			    <? 
			  }
			  if($lines == 2) {
			    ?>
			    <td style="font-size:12px;"><? echo $element->plaintext ?></td>
			    <? 
	  		  }
			  
			  //
			  if($lines == 9) {
			    			   
			    $colums["k9_total"] = $element->plaintext;  
				
				?>
			    <td style="font-size:12px;"><? echo $element->plaintext." - ".$td ?></td>
			    <? 
	  		     
				if($total) {
				  
				  if ($td==1){
					  ?></tr><?	
					  $colums["k9_total"] = $lines."".$element->plaintext;  
				  }
				}
				else {
					
				  if ($td==1){
				   ?></tr><?

				   }
					 
				  if ($element->plaintext!="&nbsp;"){
				   if (!$colums["gb"]){
				     $colums["k9"] = 	$element->plaintext;  
				   }
				  }
					
				}
		   	  }
			  
			  //
			  
			  if($lines == 14) {
			    			   
			    $colums["gb_total"] = $element->plaintext;  
				
				?>
			    <td style="font-size:12px;"><? echo $element->plaintext ?></td>
			    <? 
	  		     
				if($total) {
				  
				  if ($td==1){
					  ?></tr><?	
					  $colums["gb_total"] = $lines."".$element->plaintext;  
					  break;
					 echo "Si es total ".$element->plaintext. "<BR>" ;
				  }
				}
				else {
					
				  if ($td==1){
				   ?></tr><?
				   break;
				   }
					 
				  if ($element->plaintext!="&nbsp;"){
				   $colums["gb"] = 	$element->plaintext;  
				  }
					
				}
		   	  }
		  
			 }			
			if ($lines == $cant_columns){
			 $lines=0;
			 ?></tr><?	  
			}
			
			if ($element->plaintext == 'Total'){
             $total=true;
			 $td++;
			}
			else{
		      $total= false;	  		 
            }
			 

		    				
	  }?></table><BR><BR><?
	  
	  $colums["season"] = 	$year;
	  
	  echo "<pre>";
      print_r($colums);	  
 	  echo "</pre>";
	
	 $statistics = get_player_basic_stadistics($playerid,$year,false,$gameid);	
	 print_r($statistics);
	 $statistics->vars["gb"] = str_replace("&nbsp;"," ",$colums["gb"]);
 	 $statistics->vars["gb_total"] = str_replace("&nbsp;"," ",$colums["gb_total"]);
     $statistics->vars["k9"] = str_replace("&nbsp;"," ",$colums["k9"]);
 	 $statistics->vars["k9_total"] = str_replace("&nbsp;"," ",$colums["k9_total"]);	 
   //  $statistics->update(array("k9","k9_total","gb","gb_total")); 
   	 $html->clear(); 
	 
	 return $colums;

}


/*
function get_player_ground_ball($playerid,$position,$player_name,$gameid){
	
 $html = file_get_html_parts(0,2,"http://www.fangraphs.com/statss.aspx?playerid=".$playerid."&position=".$position."");
 
 echo "http://www.fangraphs.com/statss.aspx?playerid=".$playerid."&position=".$position."";
	  
	  $year = date("Y");
	  $new_line = false;
	  $total = false;
	  $lines=0;
	  $cant_columns = 19; 
	  $td = 0; // to control Cant of td to be displayed 

	  
	  //table colums
	  $colums = array();
	  $colums["season"] = "";
	  $colums["gb"] = 0;
	  $colums["gb_total"] = 0;
	  
	  
	  ?>
	   <table width="25%" border="1" cellspacing="0" cellpadding="0">
		
		  <tr> 
		   <? echo $_team["team_name"];?>
		  </tr>
		  <tr>
		   <td class="table_header">Season</td>
		   <td class="table_header">Team</td>
		   <td class="table_header">GB%</td>
		   </tr>
		  <tr> 
		   <? echo $player_name ?><BR>
		  </tr>  
		  <?
	
	  
	  $x = substr($year,0,2);
	  $season = $x + 8; // That is because 2013 start with season11 in the table class
	 	  
	  foreach($html->find("Table.SeasonStats1_dgSeason".$season."_ctl00] td") as $element) {     

			 if ($element->plaintext == $year){
			  ?><tr><?
			  $new_line = true;  
			  $lines = 0;
 			 }
			
			if ($new_line){ 
			  $lines++;
			 
			  if($lines == 1) {
			    ?><tr>
			      <td style="font-size:12px;"><? echo $element->plaintext ?></td>
			    <? 
			  }
			  if($lines == 2) {
			    ?>
			    <td style="font-size:12px;"><? echo $element->plaintext ?></td>
			    <? 
	  		  }
			  
			  if($lines == 14) {
			    			   
			    $colums["gb_total"] = $element->plaintext;  
				
				?>
			    <td style="font-size:12px;"><? echo $element->plaintext ?></td>
			    <? 
	  		     
				if($total) {
				  
				  if ($td==1){
					  ?></tr><?	
					  $colums["gb_total"] = $lines."".$element->plaintext;  
					  break;
					 echo "Si es total ".$element->plaintext. "<BR>" ;
				  }
				}
				else {
					
				  if ($td==1){
				   ?></tr><?
				   break;
				   }
					 
				  if ($element->plaintext!="&nbsp;"){
				   $colums["gb"] = 	$element->plaintext;  
				  }
					
				}
		   	  }
		  
			 }			
			if ($lines == $cant_columns){
			 $lines=0;
			 ?></tr><?	  
			}
			
			if ($element->plaintext == 'Total'){
             $total=true;
			 $td++;
			}
			else{
		      $total= false;	  		 
            }
			 

		    				
	  }?></table><BR><BR><?
	  
	  $colums["season"] = 	$year;
	  
	  echo "<pre>";
      print_r($colums);	  
 	  echo "</pre>";
	
	 $statistics = get_player_basic_stadistics($playerid,$year,false,$gameid);	
	 $statistics->vars["gb"] = str_replace("&nbsp;"," ",$colums["gb"]);
 	 $statistics->vars["gb_total"] = str_replace("&nbsp;"," ",$colums["gb_total"]);
     $statistics->update(array("gb","gb_total")); 
   	 $html->clear(); 

}
*/



function get_player_statistics($playerid,$position,$player_name,$gameid){
	
 $link = "http://www.fangraphs.com/statss.aspx?playerid=".$playerid."&position=".$position.""; 
 $link = "http://www.oddessa.com/fansgraphs_bridge.php?link=".$link;
 $html = file_get_html_parts(250,3,$link);
	  
	  $year = date("Y");
	  $espn = array();
	  $new_line = false;
	  $total = false;
	  $cont_lines =0;
	  $lines=0;
	  $cant_columns = 10; 
	  $td = 0; // to control Cant of td to be displayed 
	  $lines_after_last_total = 31; // Cant of lines that has the total for the before table.
	  $cant_totals = 6; // Cant of totals requiered before the requested table
	  $post_season_line=14 ;// new pitchers does not have postseason
	  $lines_before_Postseason =15; 
	  $i=0;
	  
	  //table colums
	  $colums = array();
	  $colums["season"] = "";
	  $colums["fb"] = 0;
	  $colums["fb_total"] = 0;
	  $colums["sl"] = 0;
	  $colums["sl_total"] = 0;
	  $colums["ct"] = 0;
	  $colums["ct_total"] = 0;
	  $colums["cb"] = 0;
	  $colums["cb_total"] = 0;
	  $colums["ch"] = 0;
	  $colums["ch_total"] = 0;
	  $colums["sf"] = 0;
	  $colums["sf_total"] = 0;
	  $colums["kn"] = 0;
	  $colums["kn_total"] = 0;
	  $colums["xx"] = 0;
	  $colums["xx_total"] = 0;
	  
	  
	  ?>
	   <table width="25%" border="1" cellspacing="0" cellpadding="0">
		
		  <tr> 
		   <? echo $_team["team_name"];?>
		  </tr>
		  <tr>
		   <td class="table_header">Season</td>
		   <td class="table_header">Team</td>
		   <td class="table_header">FB%</td>
		   <td class="table_header">SL%</td>
		   <td class="table_header">CT%</td>
		   <td class="table_header">CB%</td>
		   <td class="table_header">CH%</td>
		   <td class="table_header">SF%</td>
		   <td class="table_header">KN%</td>
		   <td class="table_header">XX%</td>
		   </tr>
		  <tr> 
		   <? echo $player_name ?><BR>
		  </tr>  
		  <?
	
	  $x = substr($year,0,2);
	  $season = $x + 3; // That is because 2013 start with season6 in the table class
	  
	  foreach($html->find("Table.SeasonStats1_dgSeason".$season."_ctl00] td") as $element) {     

		 if ($i == $cant_totals){
			 if ($element->plaintext == $year){
			  ?><tr><?
			  $new_line = true;  
			  $lines = 0;
     	    }
			if($cont_lines == $post_season_line){
			  if ($element->plaintext != "Postseason"){
				$lines_after_last_total= $lines_before_Postseason; 
			  
			  }
			}
			
			
			
			 if (str_replace('&nbsp;','',$element->plaintext) == $year && $lines == $cant_columns){
			  $td = ($td/2);
			  $total = false;
			  $new_line = false;
			  
			 }
			
			 if ($total==true && $lines == $cant_columns){
				$i=-1; // Exit the cicle 
			    $new_line =false;
			 }
			
			 if ($lines == $cant_columns){
				$lines = 0; 
			 }
			 
			 
			 if (str_replace('&nbsp;','',$element->plaintext) == 'Total'){
				$new_line = true; 
				$lines = 0; 
				$total = true;
			 }
			
			
			if ($cont_lines >= $lines_after_last_total && $new_line == true){ 
			  $lines++;
			 
			  if($lines == 1) {
			    ?><tr><?
			    ?>
			    <td style="font-size:12px;"><? echo str_replace("&nbsp;","",$element->plaintext)  ?></td>
			    <? 
 			    $colums["season"] = $year;
			  }
			  if($lines == 2) {
			    ?>
			    <td style="font-size:12px;"><? echo $element->plaintext ?></td>
			    <? 
	  		  }
			  
			  if($lines == 3) {
			    ?>
			    <td style="font-size:12px;"><? echo $element->plaintext ?></td>
			    <? 
	  		     if (!$total){
				  $colums["fb"] = $element->plaintext; 	 
				 }
				 else{
				  $colums["fb_total"] = $element->plaintext;	 
				 }
			  }
 			  if($lines == 4) {
    		    ?>
			    <td style="font-size:12px;"><? echo $element->plaintext ?></td>
			    <? 
	  		     if (!$total){
				  $colums["sl"] = $element->plaintext; 	 
				 }
				 else{
				  $colums["sl_total"] = $element->plaintext;	 
				 }
			  }
   			  if($lines == 5) {
			    ?>
			    <td style="font-size:12px;"><? echo $element->plaintext ?></td>
			    <? 
	  		     if (!$total){
				  $colums["ct"] = $element->plaintext; 	 
				 }
				 else{
				  $colums["ct_total"] = $element->plaintext;	 
				 }
			  }
			  if($lines == 6) {
			    ?>
			    <td style="font-size:12px;"><? echo $element->plaintext ?></td>
			    <? 
	  		     if (!$total){
				  $colums["cb"] = $element->plaintext; 	 
				 }
				 else{
				  $colums["cb_total"] = $element->plaintext;	 
				 }
			  }
			  if($lines == 7) {
			    ?>
			    <td style="font-size:12px;"><? echo $element->plaintext ?></td>
			    <? 
	  		     if (!$total){
				  $colums["ch"] = $element->plaintext; 	 
				 }
				 else{
				  $colums["ch_total"] = $element->plaintext;	 
				 }
			  }
			  if($lines == 8) {
			    ?>
			    <td style="font-size:12px;"><? echo $element->plaintext ?></td>
			    <? 
	  		     if (!$total){
				  $colums["sf"] = $element->plaintext; 	 
				 }
				 else{
				  $colums["sf_total"] = $element->plaintext;	 
				 }
			  }
  			  if($lines == 9) {
			    ?>
			    <td style="font-size:12px;"><? echo $element->plaintext ?></td>
			    <? 
	  		     if (!$total){
				  $colums["kn"] = $element->plaintext; 	 
				 }
				 else{
				  $colums["kn_total"] = $element->plaintext;	 
				 }
			  }
			  if($lines == 10) {
			    ?>
			    <td style="font-size:12px;"><? echo $element->plaintext ?></td>
			    <? 
	  		     if (!$total){
				  $colums["xx"] = $element->plaintext; 	 
				 }
				 else{
				  $colums["xx_total"] = $element->plaintext;	 
				 }
			  }
			  $td++;
			  
			}
			if ($lines == $cant_columns){
			 //$lines=0;
			 //$total= true;	  
			 ?></tr><?	  
			   /* if ($td == ($cant_columns*2)){
			    $i=-1;
			    }*/
			  
			}		 
			$cont_lines++;	 
		    }
		if ($element->plaintext == "Total" && $new_line == false){ $i++; }
		
	  }?></table><BR><BR><?
	
	 //if TD = 0 means that no info was found for this player	 
	 if ($td){
		
	   $statistics = get_player_basic_stadistics($playerid,$year,false,$gameid);
		  
	 
		  
	   if (is_null($statistics)){
		   
		 $statistics = new _baseball_player_stadistics_by_game();
		 $insert = true;
		 }
		 else{
		 $insert = false;		 
		 }
		 
		 $statistics->vars["season"] = str_replace("&nbsp;"," ",$colums["season"]);
		 $statistics->vars["game"] = $gameid;
		 $statistics->vars["fb"] = str_replace("&nbsp;"," ",$colums["fb"]);
		 $statistics->vars["fb_total"] = str_replace("&nbsp;"," ",$colums["fb_total"]);
		 $statistics->vars["sl"] = str_replace("&nbsp;"," ",$colums["sl"]);
		 $statistics->vars["sl_total"] = str_replace("&nbsp;"," ",$colums["sl_total"]);
		 $statistics->vars["ct"] = str_replace("&nbsp;"," ",$colums["ct"]);
		 $statistics->vars["ct_total"] = str_replace("&nbsp;"," ",$colums["ct_total"]); 
		 $statistics->vars["cb"] = str_replace("&nbsp;"," ",$colums["cb"]);
		 $statistics->vars["cb_total"] = str_replace("&nbsp;"," ",$colums["cb_total"]);
		 $statistics->vars["ch"] = str_replace("&nbsp;"," ",$colums["ch"]);
		 $statistics->vars["ch_total"] = str_replace("&nbsp;"," ",$colums["ch_total"]);	  
		 $statistics->vars["sf"] = str_replace("&nbsp;"," ",$colums["sf"]);
		 $statistics->vars["sf_total"] = str_replace("&nbsp;"," ",$colums["sf_total"]);	  
		 $statistics->vars["kn"] = str_replace("&nbsp;"," ",$colums["kn"]);
		 $statistics->vars["kn_total"] = str_replace("&nbsp;"," ",$colums["kn_total"]);	  
		 $statistics->vars["xx"] = str_replace("&nbsp;"," ",$colums["xx"]);
		 $statistics->vars["xx_total"] = str_replace("&nbsp;"," ",$colums["xx_total"]);
		 
		 if ($insert){
		 	
			$statistics->vars["fangraphs_player"] = $playerid;
			$statistics->insert();	 
		 }
		 else{
	
		 	$statistics->update(array("season","fb","fb_total","sl","sl_total","ct","ct_total","cb","cb_total","ch","ch_total","sf","sf_total","kn","kn_total","xx","xx_total")); 
		 }
	 }

   	 $html->clear(); 

}

function get_bullepin_away($gameid){


  $html = file_get_html_parts(0,3,"http://scores.espn.go.com/mlb/boxscore?gameId=".$gameid."");

  echo "http://scores.espn.go.com/mlb/boxscore?gameId=".$gameid."";
	  

	  
  ?>
   <table width="25%" border="1" cellspacing="0" cellpadding="0">
	
	  <tr> 
	   <? echo $_team["team_name"];?>
	  </tr>
	  <tr>
	   <td class="table_header">Pitchers</td>
	   <td class="table_header">IP</td>
       <td class="table_header">HR</td>
	   <td class="table_header">PC</td>
	 </tr>
	  <tr> 
	   <? echo $player_name ?><BR>
	  </tr>
	 <tr>
  <?
	  
  //
  $data = array();
  $data["IP"] = 0;
  $data["PC"] = 0;
  $data["HR"] = 0;
  $new_line = false;
  $team="";
  $j=0;
  $omit_pitcher=true;
  
   foreach($html->find('div[id="gamepackage-box-score"]') as $elementa) { 
		   
		     
			 foreach ($elementa->find("table tr") as $tr){
				  foreach ($tr->find("th") as $th){
					 // echo $th->plaintext." * ";
					  if($th->plaintext == "Pitchers" ){ $line = true;}
				  }
				
				 if($line){
					
		          if ((contains_ck($tr->plaintext,'TEAM')) ){
					break;
	 			  }
				  if ($j==0){
						$team = $tr->plaintext;    
						echo $tr->plaintext."<br>";
					}
					if ($j>0 && $team == $tr->plaintext){
						$new_line = true;	   
					}
					  
					
						$i=1;
				  
				  
				  foreach($tr->find("td") as $td){
					 if ($i==1){
               ?> 
               <tr>
               <td style="font-size:12px;"><? echo $td->plaintext ?></td><?   
		   }
		   if ($i==2){
		       ?> <td style="font-size:12px;"><? echo $td->plaintext ?></td><?
		    
			   if (!$omit_pitcher){
		           $data["IP"]= $data["IP"] + $td->plaintext;
		        }
		    }
			
		   if ($i==8){
		     ?> <td style="font-size:12px;"><? echo $td->plaintext; ?></td>
		     <?
			 
			  $data["HR"]= $data["HR"] + $td->plaintext;
		    
		  }		
			
		 if ($i==9){
		     ?> <td style="font-size:12px;"><? echo myStrstrTrue($td->plaintext,"-",true) ?></td>
		     </tr><?
			 
			 if (!$omit_pitcher){
		         $data["PC"]= $data["PC"] + myStrstrTrue($td->plaintext,"-",true);
		     }	
		     $omit_pitcher=false;	
		  }
	     $i++;  
					  
				  }
				 }
				  $j++;	 
     }  ?></tr></table><BR><?
	 }
   
  
	 echo "<pre>";
	 print_r($data);
 	 echo "</pre>";
	 $html->clear();

    return $data;	
}



function get_bullepin_home($gameid){


  $html = file_get_html("http://scores.espn.go.com/mlb/boxscore?gameId=".$gameid."");

  echo "http://scores.espn.go.com/mlb/boxscore?gameId=".$gameid."";
	  

	  
  ?>
   <table width="25%" border="1" cellspacing="0" cellpadding="0">
	
	  <tr> 
	   <? echo $_team["team_name"];?>
	  </tr>
	  <tr>
	   <td class="table_header">Pitchers</td>
	   <td class="table_header">IP</td>
       <td class="table_header">HR</td>
	   <td class="table_header">PC</td>
	 </tr>
	  <tr> 
	   <? echo $player_name ?><BR>
	  </tr>
	 <tr>
  <?
	  
  //
  $data = array();
  $data["IP"] = 0;
  $data["PC"] = 0;
  $data["HR"] = 0;
  $new_line = false;
  $team="";
  $j=0;
  $omit_pitcher=true;
   $m=0;
   foreach($html->find('div[id="gamepackage-box-score"]') as $elementa) { 
		
		   
		     
			 foreach ($elementa->find("table tr") as $tr){
				  foreach ($tr->find("th") as $th){
					 // echo $th->plaintext." * ";
					  if($th->plaintext == "Pitchers" ){ $line = true; $m++;}
				  }
				
				 if($line && $m >1){
					
		          if ((contains_ck($tr->plaintext,'TEAM')) ){
					break;
	 			  }
				  if ($j==0){
						$team = $tr->plaintext;    
						echo $tr->plaintext."<br>";
					}
					if ($j>0 && $team == $tr->plaintext){
						$new_line = true;	   
					}
					  
					
						$i=1;
				  
				  
				  foreach($tr->find("td") as $td){
					 if ($i==1){
               ?> 
               <tr>
               <td style="font-size:12px;"><? echo $td->plaintext ?></td><?   
		   }
		   if ($i==2){
		       ?> <td style="font-size:12px;"><? echo $td->plaintext ?></td><?
		    
			   if (!$omit_pitcher){
		           $data["IP"]= $data["IP"] + $td->plaintext;
		        }
		    }
			
		   if ($i==8){
		     ?> <td style="font-size:12px;"><? echo $td->plaintext; ?></td>
		     <?
			 
			  $data["HR"]= $data["HR"] + $td->plaintext;
		    
		  }		
			
		 if ($i==9){
		     ?> <td style="font-size:12px;"><? echo myStrstrTrue($td->plaintext,"-",true) ?></td>
		     </tr><?
			 
			 if (!$omit_pitcher){
		         $data["PC"]= $data["PC"] + myStrstrTrue($td->plaintext,"-",true);
		     }	
		     $omit_pitcher=false;	
		  }
	     $i++;  
					  
				  }
				 }
				  $j++;	 
     }  ?></tr></table><BR><?
   }
     
	 echo "<pre>";
	 print_r($data);
 	 echo "</pre>";
	 $html->clear();

    return $data;	
}

function get_game_data($gameid){

  $html = file_get_html("http://www.espn.com/mlb/game?gameId=".$gameid."");

  echo "http://scores.espn.go.com/mlb/boxscore?gameId=".$gameid."";
	    
  ?>
   <table width="25%" border="1" cellspacing="0" cellpadding="0">
	
	   <tr>
	   <td class="table_header">TEAM</td>
	   <td class="table_header">R</td>
	   <td class="table_header">H</td>
	 </tr>
	   <tr>
  <?
	  
  //
  $data = array();
  $columns =0;
  $data["runs_away"] = 0;
  $data["runs_home"] = 0;
  $data["hits_away"] = 0;
  $data["hits_home"] = 0;
  $new_line = false;
  $start_run = true;
  $first = 0;
  $first_colum = false;
  $j=0;
  
foreach($html->find('table[class="linescore__table"]') as $table){
	 $i = 0;

       foreach($table->find("tr") as $tr){
		
		//echo $tr->plaintext."<BR>"; 
		
		    $k=0;
						$control = false;			
	foreach($tr->find("td") as $element){
		  
      $columns = $element->plaintext;
	  
	  if ($j==1 &&   $first_colum == false){
		  $first = $columns;
  		 $first_colum = true;   
	  }
		  
  	  if ($columns !='R' && $start_run == true){
	        $real_column = $element->plaintext;
			$real_column = (($real_column - $first)+1);
	  }
	  else{
		 $start_run  = false;
	  }
	  
	  if ($element->plaintext =='E'){
	  $j=0;	 
	  $new_line=true;
	  $i=1;
	 }
	     
	if ($new_line && $j>0){
		   
		  if ($i==1){
               ?> 
               <tr>
               <td style="font-size:12px;"><? echo $element->plaintext ?></td><?   
		   }
		     if ($i==($real_column+2)){
			   ?> <td style="font-size:12px;"><? echo $element->plaintext ?></td><?
		     
			  if($home){
				 $data["runs_home"]=  trim($element->plaintext);
			  }
			  else{
				 $data["runs_away"]= trim($element->plaintext);
			  }
			  
			
			    }
		 if ($i==($real_column+3)){
		     ?> <td style="font-size:12px;"><? echo $element->plaintext ?></td>
		     </tr><?
			 
			 if($home){
				 $data["hits_home"] =  trim($element->plaintext);
			  }
			  else{
				 $data["hits_away"] = trim($element->plaintext);
			  }
			    
		  }
		  if ($i==($real_column+4)){
		   $i=0;
		   $home = true;
		  }
		   
	     $i++;
	   }
    
    $j++;	
   }  ?></table><BR><?
     
	   }
  }
	 echo "<pre>";
	 print_r($data);
 	 echo "</pre>";
	 $html->clear();

    return $data;	
}


function check_postponed_games($gameid){

  $html = file_get_html("http://scores.espn.go.com/mlb/boxscore?gameId=".$gameid."");

      
  
  foreach ($html->find('p[id="gameStatusBarText"]') as $p){
	   
 
		if  (trim($p->plaintext) == 'Postponed' || trim($p->plaintext) =='Cancelled') {
		$_postponed = true;	
		echo "The game ".$gameid. "was cancelled<BR>";
		}
		else{
		$_postponed = false;	
		}
		
   }  
    return $_postponed;	
}

function check_games_note($gameid){

  $html = file_get_html("http://scores.espn.go.com/mlb/boxscore?gameId=".$gameid."");

  foreach ($html->find('tr class="even"t" td') as $p){
	   
       
		if  ( contains_ck($p->plaintext,"RESUMED") || contains_ck($p->plaintext,"DELAY")) {
		$note = $p->plaintext;	
		echo "GAME NOTE ".$p->plaintext."<BR>";
		break;
		}
		else{
		$note = -1;	
		}
		
   }  
    return $note;
}


function get_baseball_line_process($higher,$line,$cleaned_line,$score){

$data = array();
if ($higher) { 
					
				if ($line){
					 
					  $positive=false;
					  if (contains_ck($cleaned_line["juice"],"+")){$positive = true;}
					  
					  
					  if ($score > $cleaned_line["line"]){
						 $status = "WIN";
						 
						 if($positive){
						  $pre_balance = ($cleaned_line["juice"]/100);
						 }
						 else{
						  $pre_balance = 1;   
						 }
					 
					  }
					  else if ($score < $cleaned_line["line"]){
						 $status = "LOSE";   
						 if($positive){
						 $pre_balance = -1;
						 }
						 else{
						 $pre_balance = ($cleaned_line["juice"]/100);
						 }
					  }
					  else if ($score == $cleaned_line["line"]){
						 $status = "PUSH";   
						 $pre_balance = 0;
					  }
					
					
					}
					else{
						 $status = "NO LINE";   
						 $pre_balance = 0;
					}
				 }
				 else{
					 
				   if ($line){ 
                     $positive=false; 
					 if (contains_ck($cleaned_line["juice"],"+")){$positive = true;}
					 
					 if ($score < $cleaned_line["line"]){
						 $status = "WIN";
						 if($positive){
						  $pre_balance = ($cleaned_line["juice"]/100);
						 }
						 else{
						  $pre_balance = 1;   
						 }  
					  
					  
					  }
					  else if ($score > $cleaned_line["line"]){
						 $status = "LOSE";
						 if($positive){
						 $pre_balance = -1;
						 }
						 else{
						 $pre_balance = ($cleaned_line["juice"]/100);
						 }
					  }
					  else if ($score == $cleaned_line["line"]){
						 $status = "PUSH";   
						 $pre_balance = 0;
					  }
					}
					else{
						 $status = "NO LINE";   
						 $pre_balance = 0;
					}	
				}

$data["status"]=$status;
$data["pre_balance"]=$pre_balance;

return $data;

}

function get_baseball_money_balance($money,$status,$higher){

if ($money == "EV"){ $money = "+100" ;}	
$status = substr($status,0,1);

if ($higher) { 
  $positive=false;
   if (contains_ck($money,"+")){$positive = true;}
		  
   	 if ($money){  
		if ($status == "1"){
			 if($positive){
		  	  $pre_balance = ($money/100);
			 }
			 else{
			$pre_balance = 1;   
			 }
					 
	     }
		 else if ($status == "2"){
			 if($positive){
			  $pre_balance = -1;
			 }
			 else{
			  $pre_balance = ($money/100);
			 }
		  }
		 else if ($status == "3"){
			  $pre_balance = 0;
	    }
					
	}
	else{
	   $pre_balance = 0;
    }
}
else{
   if ($money){ 
     $positive=false; 
	 if (contains_ck($money,"+")){$positive = true;}
					 
	 if ($status == "1"){
  	    if($positive){
	      $pre_balance = ($money/100);
  		 }
	    else{
	     $pre_balance = 1;   
		}  
     }
	 else if ($status == "2"){
 	    if($positive){
		$pre_balance = -1;
		}
		else{
		$pre_balance = ($money/100);
		 }
     }
	 else if ($score == $cleaned_line["line"]){
	     $pre_balance = 0;
     }
  }
  else{
    $pre_balance = 0;
	}	
 }
 
return $pre_balance; 
 
}



function get_player_pitches_velocity($playerid,$player_name,$year,$last_season=false,$gameid,$gamedate=""){
   // this function does not work with last_season please ommit that.
	 if (!$last_season){
	    
	   $statistics = get_player_basic_stadistics($playerid,($year-1),true,0);
	
	    if (is_null($statistics)){
	      echo "Last Season<BR>";
	     // get_player_pitches($playerid,$player_name,($year-1),true,"");
	      $last_season=false;
	   }
	  }
	  
	
	//$html = file_get_html_parts(80000,0,"http://www.fangraphs.com/statsd.aspx?playerid=".$playerid."&position=P&type=6&gds=&gde=&season=".$year."");
	 $link = "http://www.fangraphs.com/statsd.aspx?playerid=".$playerid."&position=P&type=6&gds=&gde=&season=".$year."";
	 $link = "http://www.oddessa.com/fansgraphs_bridge.php?link=".$link;
	$html = @file_get_html($link);
	
	echo "http://www.fangraphs.com/statsd.aspx?playerid=".$playerid."&position=P&type=6&gds=&gde=&season=".$year."";
		  
	  ?>
	  <table width="25%" border="1" cellspacing="0" cellpadding="0">
			
	  <tr> 
	    <? echo $_team["team_name"];?>
	  </tr>
	  <tr>
	    <td class="table_header">Date</td>
	    <td class="table_header">Team</td>
	    <td class="table_header">FB%</td>
	    <td class="table_header">FBv</td>
	  </tr>
	  <tr> 
	    <? echo $player_name ?><BR>
	  </tr>
 	  <tr>
	  <?
		  
		  $data = array();
		  $data["date"] = 0;
		  $data["total_last_game"] = 0;
		  $data["total_last_two_games"] = 0;
		  $data["avg_season"] = 0;
		  $data["total_season"] = 0;
		 
		 
		 
		  // 2014-21-5 Information for  4G and 5G were requested
		 
		  
		  $cant_columns = 19; // the table has 15 colums
		  $i=1;
		  $j=1;
		  $break = false;
		  $m = 0;
		  
	 if(!empty($html)){
		  foreach($html->find("Table.rgMasterTable td") as $element) { 
		 
	       if ($i == 1 && $element->plaintext == "Total") { // We need to jump 30 columns beacause the total was changed up
		    $break = true;
		   }
		   
	      if ($break){
			$m++;
			if ($m >= 38){
				 //echo $element->plaintext."-s--s<BR>";
				 $break = false;}   
		  } 
		  else {
		   
	    	if ($i==1){ 
			   if ($j==1){
				$data["date"] = $element->plaintext;
			   }
			 ?> <td style="font-size:12px;"><? echo $element->plaintext ?></td><?
			}
			 if ($i==2){
			 ?> <td style="font-size:12px;"><? echo $element->plaintext ?></td><?
			 }
			 if ($i==5){
			 ?> <td style="font-size:12px;"><? echo $element->plaintext ?></td><?
			 }
			 if ($i==6){
			 ?> <td style="font-size:12px;"><? echo $element->plaintext ?></td><?
			 
			   if ($j==1){
				$data["total_last_game"] = $element->plaintext; 
				}
			   if ($j==2){
				$data["total_last_two_games"] = $element->plaintext; 
				}
			 
			    $data["total_season"] = $data["total_season"] + $element->plaintext;
			 
			 }
	     	
			if ($i == $cant_columns){
			  $i=0;
			  $j++;
			  ?>
			 
			  </tr><tr><?	  
			}
		    $i++;
			
		  } //control break false
		  } ?></tr></table><BR><?
	     }
		   $j--;
		   if (is_null($element) && $last_season == false ){
			echo "NO DATA";
			$data["date"]= date("Y-m-d");   
			$j=1;
		   }
		   else{
		      if ($j<=0){ //To avoid Division by Zero
			  $j=1;
			  }
		   }
		  
		   
		   $data["avg_season"] = round($data["total_season"] / $j);
		  
		   if ($last_season){
			 $statistics = new _baseball_player_stadistics_by_game();  
			 $statistics->vars["fangraphs_player"] = $playerid;
			
		   }
		   else {	 
	 
			 $statistics = get_player_basic_stadistics($playerid,$year,false,$gameid);
			 if (is_null($statistics)){
				$last_season = true; 
			    $statistics = new _baseball_player_stadistics_by_game();  
			    $statistics->vars["fangraphs_player"] = $playerid;
			 }
		  
		  }
		 
		 if ($j==1){
		    $rest_time ='0'; // To control that players that does not have any game this season
	     } 
		  
		 $statistics->vars["season"] = $year;
		 $statistics->vars["game"] = $gameid;
		 $statistics->vars["last_game_velocity"] = $data["total_last_game"];
		 $statistics->vars["last_two_game_velocity"] = $data["total_last_two_games"];
		 $statistics->vars["season_velocity"] =  $data["avg_season"];
		 
		 
		   if (!$last_season){
      		  $statistics->update(array("last_game_velocity","last_two_game_velocity","season_velocity")); 
		  }
		  else{
			// $statistics->insert(); 	    
		  }

		 echo "<pre>";
		 print_r($data);
		 echo "</pre>";
		 echo "<BR>";
	    
		if(!empty($html)){
		 $html->clear();
		}
		 
		 return $data;
	
}

/*
function get_player_pitches_velocity($playerid,$player_name,$year,$last_season=false,$gameid,$gamedate=""){
   // this function does not work with last_season please ommit that.
	 if (!$last_season){
	    
	   $statistics = get_player_basic_stadistics($playerid,($year-1),true,0);
	
	    if (is_null($statistics)){
	      echo "Last Season<BR>";
	     // get_player_pitches($playerid,$player_name,($year-1),true,"");
	      $last_season=false;
	   }
	  }
	  
	
	$html = file_get_html_parts(80000,0,"http://www.fangraphs.com/statsd.aspx?playerid=".$playerid."&position=P&type=6&gds=&gde=&season=".$year."");
	
	echo "http://www.fangraphs.com/statsd.aspx?playerid=".$playerid."&position=P&type=6&gds=&gde=&season=".$year."";
		  
	  ?>
	  <table width="25%" border="1" cellspacing="0" cellpadding="0">
			
	  <tr> 
	    <? echo $_team["team_name"];?>
	  </tr>
	  <tr>
	    <td class="table_header">Date</td>
	    <td class="table_header">Team</td>
	    <td class="table_header">FB%</td>
	    <td class="table_header">FBv</td>
	  </tr>
	  <tr> 
	    <? echo $player_name ?><BR>
	  </tr>
 	  <tr>
	  <?
		  
		  $data = array();
		  $data["date"] = 0;
		  $data["total_last_game"] = 0;
		  $data["total_last_two_games"] = 0;
		  $data["avg_season"] = 0;
		  $data["total_season"] = 0;
		 
		 
		 
		  // 2014-21-5 Information for  4G and 5G were requested
		 
		  
		  $cant_columns = 19; // the table has 15 colums
		  $i=1;
		  $j=1;
		  $break = false;
		  $m = 0;
		  
		  foreach($html->find("Table.rgMasterTable td") as $element) { 
		 
	       if ($i == 1 && $element->plaintext == "Total") { // We need to jump 30 columns beacause the total was changed up
		    $break = true;
		   }
		   
	      if ($break){
			$m++;
			if ($m >= 38){
				 //echo $element->plaintext."-s--s<BR>";
				 $break = false;}   
		  } 
		  else {
		   
	    	if ($i==1){ 
			   if ($j==1){
				$data["date"] = $element->plaintext;
			   }
			 ?> <td style="font-size:12px;"><? echo $element->plaintext ?></td><?
			}
			 if ($i==2){
			 ?> <td style="font-size:12px;"><? echo $element->plaintext ?></td><?
			 }
			 if ($i==5){
			 ?> <td style="font-size:12px;"><? echo $element->plaintext ?></td><?
			 }
			 if ($i==6){
			 ?> <td style="font-size:12px;"><? echo $element->plaintext ?></td><?
			 
			   if ($j==1){
				$data["total_last_game"] = $element->plaintext; 
				}
			   if ($j==2){
				$data["total_last_two_games"] = $element->plaintext; 
				}
			 
			    $data["total_season"] = $data["total_season"] + $element->plaintext;
			 
			 }
	     	
			if ($i == $cant_columns){
			  $i=0;
			  $j++;
			  ?>
			 
			  </tr><tr><?	  
			}
		    $i++;
			
		  } //control break false
		  } ?></tr></table><BR><?
		 
		   $j--;
		   if (is_null($element) && $last_season == false ){
			echo "NO DATA";
			$data["date"]= date("Y-m-d");   
			$j=1;
		   }
		   else{
		      if ($j<=0){ //To avoid Division by Zero
			  $j=1;
			  }
		   }
		  
		   
		   $data["avg_season"] = round($data["total_season"] / $j);
		  
		   if ($last_season){
			 $statistics = new _baseball_player_stadistics_by_game();  
			 $statistics->vars["fangraphs_player"] = $playerid;
			
		   }
		   else {	 
	 
			 $statistics = get_player_basic_stadistics($playerid,$year,false,$gameid);
			 if (is_null($statistics)){
				$last_season = true; 
			    $statistics = new _baseball_player_stadistics_by_game();  
			    $statistics->vars["fangraphs_player"] = $playerid;
			 }
		  
		  }
		 
		 if ($j==1){
		    $rest_time ='0'; // To control that players that does not have any game this season
	     } 
		  
		 $statistics->vars["season"] = $year;
		 $statistics->vars["game"] = $gameid;
		 $statistics->vars["last_game_velocity"] = $data["total_last_game"];
		 $statistics->vars["last_two_game_velocity"] = $data["total_last_two_games"];
		 $statistics->vars["season_velocity"] =  $data["avg_season"];
		 
		 
		   if (!$last_season){
      		  $statistics->update(array("last_game_velocity","last_two_game_velocity","season_velocity")); 
		  }
		  else{
			// $statistics->insert(); 	    
		  }

		 echo "<pre>";
		 print_r($data);
		 echo "</pre>";
		 echo "<BR>";
	     $html->clear();
	
}
*/

function get_player_era($playerid,$player_name,$year,$last_season=false,$gameid){
	
	   $link = "http://www.fangraphs.com/statsd.aspx?playerid=".$playerid."&position=P";
	   $link = "http://www.oddessa.com/fansgraphs_bridge.php?link=".$link;
	  // echo file_get_contents($link);
	  // exit;
	
	$html = file_get_html($link,true);
	
	
	if (!empty($html)){	
	
	  echo $link." ---> ".$player_name."<BR><BR>";	  
	  ?>
	  <table width="25%" border="1" cellspacing="0" cellpadding="0">
			
	  <tr> 
	    <? echo $_team["team_name"];?>
	  </tr>
	  <tr>
	    <td class="table_header">Player</td>
	    <td class="table_header">ERA</td>
	    <td class="table_header">XFIP</td>
	  </tr>
	  <tr> 
	   
	  </tr>
 	  <tr>
      
        <td class="table_header"><? echo $playerid ?></td> 
	  <?
		  
		  $data = array();
		 
		  $data["era"] = 0;
		  $data["fipx"] = 0;
		 
		  /* foreach($html->find('div') as $div) { 
		    echo $j." - ".$div->plaintext."<BR>";
		   }
		 exit;*/
	     foreach($html->find('tr[id="DailyStats1_dgSeason1_ctl00__0"]') as $tr) { 
		// echo $j." - ".$tr->plaintext."<BR>";
		   	$j=0;
			foreach($tr->find('td') as $td){ $j++;
			
			 //  echo $j." - ".$td->plaintext."<BR>";
				    if ($j==24){
					 $data["era"] = $td->plaintext;
					?>  <td class="table_header"><? echo $td->plaintext ?></td> <?
					}
					if ($j==26){
					 $data["xfip"] = $td->plaintext;
					?>  <td class="table_header"><? echo $td->plaintext ?></td> <?					 
					 break;
					}
					
			}
			break;
		 
		  }
		   $statistics = get_player_basic_stadistics($playerid,$year,false,$gameid);
		//  print_r($statistics);
		  
		  if(!is_null($statistics)){
			//   echo "entra";
			  $statistics->vars["era"] = $data["era"];
			  $statistics->vars["xfip"] = $data["xfip"];
			  $statistics->update(array("era","xfip"));
		  }
		  
		  
		  ?>
         </tr>
		 </table> <?  
		 echo "<pre>";
		 print_r($data);
		// print_r($statistics);
		 echo "</pre>";
		
		 echo "<BR>";
	     $html->clear();
	 }//empty html
	 else{ 
	    echo "Error -- : ".$link."<BR>";
	 }	 
	
}
/*
function get_team_speed(){
	
	    $link = "http://www.fangraphs.com/leaders.aspx?pos=all&stats=bat&lg=all&qual=0&type=7&season=".date("Y")."&month=0&season1=".date("Y")."&ind=0&team=0,ts&rost=0&age=0&filter=&players=0&sort=2,d";
	  
	
	
	$html = file_get_html($link,true);
	
	
	if (!empty($html)){	
	
	  echo $link." ---> ".$player_name."<BR><BR>";	  
	  ?>
	  <table width="25%" border="1" cellspacing="0" cellpadding="0">
			
	  <tr> 
	    <? echo $_team["team_name"];?>
	  </tr>
	  <tr>
	    <td class="table_header">Rank</td>
	    <td class="table_header">Team</td>
	    <td class="table_header">WFB</td>
        <td class="table_header">WSL</td>
		<td class="table_header">WCT</td>
		<td class="table_header">WCB</td>
        <td class="table_header">WCH</td>                
        <td class="table_header">WSF</td> 
        <td class="table_header">WKN</td>                                               
	  </tr>
	  <tr> 
	   
	  </tr>
 	  
      
        <td class="table_header"><? echo $playerid ?></td> 
	  <?
		  
		  $data = array();
		 
		 
	     foreach($html->find('table[id="LeaderBoard1_dg1_ctl00"]') as $table) { 
		 
		   	$j=0;$d=0;
			foreach($table->find('tr') as $tr){ $i++;
			
			  if($i>3){
				$j=0;
				
				?> <tr><?
			  	foreach($tr->find('td') as $td){ $j++;
			
			     if ($j<10){ $m++;
				   // echo $m." - ".$td->plaintext."<BR>";
				  ?> 
                   <td class="table_header"><? echo $td->plaintext ?></td> <?
                     if ($m==1){ $data[$d]["rank"] = $td->plaintext; }
                     if ($m==2){ $data[$d]["team"] = $td->plaintext; }
                     if ($m==3){ $data[$d]["wfb"] = $td->plaintext; }	
  				     if ($m==4){ $data[$d]["wsl"] = $td->plaintext; }										 
					 if ($m==5){ $data[$d]["wct"] = $td->plaintext; }										 					 
					 if ($m==6){ $data[$d]["wcb"] = $td->plaintext; }										 
					 if ($m==7){ $data[$d]["wch"] = $td->plaintext; }										 
					 if ($m==8){ $data[$d]["wsf"] = $td->plaintext; }										  
					 if ($m==9){ $data[$d]["wkn"] = $td->plaintext; }										 


				  }else { ?> </tr><? $m=0; $d++; break;}
			     } //td	
			   }//IF
			} //tr
		 
		  } //table
		 
		  
		  ?>
        
		 </table> <?  
		 echo "<pre>";
       //print_r($data);
		
		 echo "</pre>";
		
		 echo "<BR>";
	     $html->clear();
	 }//empty html
	 else{ 
	    echo "Error: ".$link."<BR>";
	 }	 
  
  if(!empty($data)){
	
	$all_teams = get_all_baseball_stadium_custom("espn_small_name");
	foreach ($data as $dt){
		
	  // $team =  get_baseball_stadium_custom($dt["team"],'espn_small_name');	
	   
	  
	    if(isset($all_teams[$dt["team"]]->vars["team_id"])){
			
		$team = new _baseball_team_speed();
		$team->vars["team"]	= $all_teams[$dt["team"]]->vars["team_id"];
		$team->vars["date"]	= date("Y-m-d");		
		$team->vars["rank"]	= $dt["rank"];		
		$team->vars["wfb"]	= str_replace("&nbsp;","",$dt["wfb"]);		
		$team->vars["wsl"]	= str_replace("&nbsp;","",$dt["wsl"]);		
		$team->vars["wct"]	= str_replace("&nbsp;","",$dt["wct"]);		
		$team->vars["wcb"]	= str_replace("&nbsp;","",$dt["wcb"]);		
		$team->vars["wch"]	= str_replace("&nbsp;","",$dt["wch"]);		
		$team->vars["wsf"]	= str_replace("&nbsp;","",$dt["wsf"]);		
		$team->vars["wkn"]	= str_replace("&nbsp;","",$dt["wkn"]);																
		$team->insert();
		
	    
		}else {
			echo $dt["team"];
			}
	  
	 
	   echo "<BR>";
	   
	
	}
	
	}




}
*/

function baseball_tools(){
	
$tools = array();
$tools[1]['id'] = "1";
$tools[1]['tool'] = "History Weather";
$tools[1]['path'] = "jobs/history_weather_fix.php";
$tools[2]['id'] = "2";
$tools[2]['tool'] = "Duplicate Players";
$tools[2]['path'] = "jobs/duplicate_players_fix.php";
$tools[3]['id'] = "3";
$tools[3]['tool'] = "Pitcher Game Changes";
$tools[3]['path'] = "jobs/pitchers_game_changes.php";
$tools[4]['id'] = "4";
$tools[4]['tool'] = "Pitcher Data Away";
$tools[4]['path'] = "old_jobs/old_pitcher_data_away.php";
$tools[5]['id'] = "5";
$tools[5]['tool'] = "Pitcher Data Home";
$tools[5]['path'] = "old_jobs/old_pitcher_data_home.php";
$tools[6]['id'] = "6";
$tools[6]['tool'] = "Pitcher Velocity Away";
$tools[6]['path'] = "old_jobs/old_pitcher_velocity_away.php";
$tools[7]['id'] = "7";
$tools[7]['tool'] = "Pitcher Velocity Home";
$tools[7]['path'] = "old_jobs/old_pitcher_velocity_home.php";
$tools[8]['id'] = "8";
$tools[8]['tool'] = "Grand Salami";
$tools[8]['path'] = "jobs/baseball_stats.php";
$tools[9]['id'] = "9";
$tools[9]['tool'] = "Pitchers Missed";
$tools[9]['path'] = "jobs/pitchers_missed_info.php";
$tools[10]['id'] = "10";
$tools[10]['tool'] = "Parkfactor";
$tools[10]['path'] = "jobs/parkfactor.php";
$tools[11]['id'] = "11";
$tools[11]['tool'] = "Groundball";
$tools[11]['path'] = "old_jobs/old_pitchers_groundball.php";
$tools[12]['id'] = "12";
$tools[12]['tool'] = "Pitcher Statistics";
$tools[12]['path'] = "old_jobs/old_pitchers_stadistics.php";
$tools[13]['id'] = "13";
$tools[13]['tool'] = "Game Results";
$tools[13]['path'] = "jobs/yesterday_game_data.php";
$tools[14]['id'] = "14";
$tools[14]['tool'] = "Weather Statistics";
$tools[14]['path'] = "jobs/weather_stadistics.php";
$tools[15]['id'] = "15";
$tools[15]['tool'] = "Espn Player Data Away";
$tools[15]['path'] = "jobs/pitchers_fantasy_Away.php";
$tools[16]['id'] = "16";
$tools[16]['tool'] = "Espn Player Data Home";
$tools[16]['path'] = "jobs/pitchers_fantasy_Home.php";	

return $tools;
}



function getair_density($elevation,$pressure,$temperature,$humidity){

	$data = array();
	$data["locElevation"] = $elevation;
	$data["locPressure"] = $pressure;
	$data["locTemperature"] = $temperature;
	$data["locHumidity"] = $humidity;
	$data["userData"] = "yes";
	
	$html = do_post_request("https://www.baseballvmi.com/adicalc.php",$data);
	$html = str_replace("class=","id=",$html);
	
	
	$DOM = new DOMDocument;
	@$DOM->loadHTML($html);
	$element = $DOM->getElementById("adilarge");
	
	$air_density = $element->nodeValue;
	
	return $air_density;

}

//echo getair_density("9","30.25","50","38");

 function stadium_data_formula($pk,$airp,$std){
	  
     	$value1 = $value2 = $value3 = $value4 = $result = 0;
        $data = array();
		
		$value1 = max(min($pk,$std->vars["pk_major_range"]),$std->vars["pk_minor_range"]);
		$value2 = (($std->vars["pk_major_range"] - $std->vars["pk_minor_range"])/2) + $std->vars["pk_minor_range"];
		$value3 = $value1-$value2;
		$value4 = ($std->vars["pk_diff"]/($std->vars["pk_major_range"] - $std->vars["pk_minor_range"]));
		$result = $value3 * $value4;
		$data["pk"] = round($result,2);
		
		$value1 = $value2 = $value3 = $value4 = $result = 0;
		$value1 = max(min($airp,$std->vars["airp_major_range"]),$std->vars["airp_minor_range"]);
		$value2 = (($std->vars["airp_major_range"] - $std->vars["airp_minor_range"])/2) + $std->vars["airp_minor_range"];
		$value3 = $value1-$value2;
		$value4 = ($std->vars["airp_diff"]/($std->vars["airp_major_range"] - $std->vars["airp_minor_range"]));
		$result = -($value3 * $value4);
		$data["airp"] = round($result,2);
		
		$total = +($data["airp"]+$data["pk"]);
		$data["total"] = round($total,2);
	
	return $data;
	  
  
  
  }
  
?>
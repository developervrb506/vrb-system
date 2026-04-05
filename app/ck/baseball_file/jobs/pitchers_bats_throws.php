<?
require_once(ROOT_PATH . "/ck/db/handler.php"); 
require_once(ROOT_PATH . '/includes/html_dom_parser.php'); 
//require_once(ROOT_PATH . '/ck/baseball_file/process/functions.php');
  set_time_limit(0);  
echo "-------------------------<BR>";
echo "      PITCHERS BATS/THROWS <br>";
echo "--------------------------<BR>";
 


$players = get_players_test();


function get_players_test(){
	baseball_db();
	$sql = "select * from player where bats = '0' and espn_player > 0 and position = 'P' ORDER BY RAND() LIMIT 100";
	return get($sql,"_baseball_player");
}

 
 foreach ($players as $play){
	 
  $player = $play->vars["fangraphs_player"];	 
   
  $data = fantasy_espn_data($player);
  $play->vars["bats"] = $data["bats"];
  $play->vars["throws"] = $data["throws"];  
  $play->update(array("bats","throws"));
  echo $play->vars["player"]." --->  ";
  print_r($data);
  echo "<BR>";
  
 }
  
 
  
function fantasy_espn_data($player){ 

 //echo   "http://www.fangraphs.com/statss.aspx?playerid=".$player."&position=P";
  $html = file_get_html("http://www.fangraphs.com/statss.aspx?playerid=".$player."&position=P"); 
  $data = array();
  $break = false;
   foreach($html->find("table") as $table) {    
      
	  //$next = false;
	  foreach ($table->find("tr") as $tr ){
		
		
		 foreach ($tr->find("td") as $td ){
		    // echo $td->plaintext."<BR><BR>";
		  
		  if (contains_ck($td->plaintext,"/Throws:")){
			  
			   foreach ($td->find("div") as $div ){
			  
			  // echo $div->plaintext."<BR><BR>";
			     $break=true;
				 if (contains_ck($div->plaintext,"/Throws:")){ 
				 $pos = str_center("Throws:","Height",$div->plaintext);
				 break;
				 }
			   // break;
			   }
			   
		  }
		 }
		  if ($break) {break;}
		
		}
    if ($break) {break;}
	  
   }
  
 // echo $pos."<BR>";
  $pos = explode("/",$pos);
  $data["bats"]= $pos[0];
  $data["throws"]= $pos[1];  
  
  
 return $data;
 } 


//This function is to get only the Day,nigth and Actual Era month
 function player_split_espn_date($player) {  
   $html = file_get_html("http://espn.go.com/mlb/player/splits/_/id/".$player."/type/pitching3/"); 
   $data = array();
  
   foreach($html->find('table[class="tablehead"]') as $table){
      $day = true;
	  $next_month = false;
	  $stadium = false;
	  $close = false;
	  $j = 0;
	   foreach($table->find('tr') as $tr) { 
    
	    if($day){ // boolean to handle the Day Word.
	      if (contains_ck($tr->plaintext,"Day") ){
		    $day = false;
		    $x =0; 
	        foreach($tr->find('td') as $td) {
              $data["day_splits"] = $td->plaintext;
			  $x++;
		     if ($x==2){   break; }
	        }
		  }
		}
	   //Nigth
	   if (contains_ck($tr->plaintext,"Night") ){
		  $x =0; 
	      foreach($tr->find('td') as $td) {
             $data["nigth_splits"] = $td->plaintext;
		   $x++;
		   if ($x==2){   break; }
	       }
	   }
	   // Month Era
	    if ($next_month ){ // this TR contains the Era needed, it is checked before check the tittle. to activate the $next_month
		   $x =0; 
	        $str ="";
			foreach($tr->find('td') as $td) {
            $str .= $td->plaintext." ";
		    
		   $x++;
		   if ($x==2){ 
		   		$data["month_era_splits"] = $str;
		        $next_month = false;
				break; }
	       }
		
		 }
	   
	   
	   //Month Era
	   if (contains_ck($tr->plaintext,"Day/Month") ){
		  $next_month = true; 
	    
	   }
	   
	    
		  
		 if ($stadium){
			 $x = 0; 
		    
	        foreach($tr->find('td') as $td) {
				if (contains_ck($td->plaintext,"By Count") ){
		          $stadium = false;
				  $close = true;
			       break; // End cicle, no more info is required
		        } 
				
               if ($x==0){ $data["by_stadium"][$j]["stadium"] = $td->plaintext;}
			   if ($x==1){ $data["by_stadium"][$j]["era"] = $td->plaintext;}
			   if ($x==9){ $data["by_stadium"][$j]["ip"] = $td->plaintext;}
			   if ($x==16){ $data["by_stadium"][$j]["avg"] = $td->plaintext; $j++;}
		       $x++;
	        } 
	        
		  }
		  
	    if (contains_ck($tr->plaintext,"By Stadium") ){ // Active the Boolean $stadium to catch the next info.
		   $x =0; 
		   $stadium = true;
		 }
		  
		 if ($close) {
		    break; // 
		 } 
	   
	   
	   
	   
      }  //tr
 }// table
   
 return($data);  
 }





?>
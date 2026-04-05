<? require_once(ROOT_PATH . "/ck/db/handler.php"); 
    require_once('../../../includes/html_dom_parser.php');  
	ini_set('memory_limit', '-1');
    set_time_limit(0);
	


//***********************************
// Find the Game weather and Umpire and Scores
//**********************************


$file = fopen("./ck/baseball_file/old_jobs/date_games_start2.txt", "r") or exit("Unable to open file!");
while(!feof($file))
{
$date =  ltrim(fgets($file));
}
fclose($file);


$date='2014-09-16';

for ($k=1;$k<10;$k++) {
	
echo "---------------<BR>";
echo "Stadistics for Yesterday Game<BR>";
echo "---------------<BR><BR>";	

$date = date( "Y-m-d", strtotime( "-1 day", strtotime(date($date)))); 


echo "Fecha: ".$date."<BR>";

$games = get_basic_baseball_games_by_date($date);
$i=0;




foreach ($games as $game ){


if (!$game->vars["postponed"]){ 

/*
if ($game->vars["real_roof_open"] == -1 || $game->vars["umpire"]  == 0 || $game->vars["firstbase"]  == 0){ 
   
   $html = file_get_html("http://scores.espn.go.com/mlb/boxscore?gameId=".$game->vars["espn_game"]."");
   $next_line_roof = false;
   $next_line_umpire = false;
  

  foreach ( $html->find('td style="text-align:left; "') as $element ) {

   if($next_line_roof){

	 if (contains_ck($element->plaintext,"ndoors")){
       $game->vars["real_roof_open"] = 0;  // 0 means Open. 
	 }
	 else {
  	  $game->vars["real_roof_open"] = 1;   // 1 means Closed
	 }
	 $game->update(array("real_roof_open")); 
	 echo " -> ".$element->plaintext." ---> "	;
	 $next_line_roof = false;
   }
	
   if($next_line_umpire){ 
	 $umpire = str_center("Home Plate - ",",",$element->plaintext);	
  	 $umpire = str_replace("  "," ",$umpire);
	 $umpire = str_replace("'"," ",$umpire);
	 echo " -> ".$umpire. " ";
   	 $id_umpire = get_game_umpire_by_name($umpire."");
	 print_r($id_umpire);
     echo"<BR>"; 
	 $firstbase = str_center("First Base - ",", Second Base",$element->plaintext);	
	 $firstbase = str_replace("  "," ",$firstbase);
	 $firstbase = str_replace("'"," ",$firstbase);
	 echo " First Base -> ".$firstbase. " ";
     $id_firstbase = get_game_umpire_by_name($firstbase."");
	 print_r($id_firstbase);
	 
	 
	 echo"<BR>";
	 $game->vars["real_umpire"] = $id_umpire->vars["id"]; 
 	 $game->vars["umpire"] = $id_umpire->vars["id"]; 
	 $game->vars["firstbase"] = $id_firstbase->vars["id"];
  	 $game->update(array("real_umpire","firstbase","umpire")); 
	 
	 
	 
	 $next_line_umpire = false;	
   }

   if (contains_ck($element->plaintext,"Weather")){
    echo ($i+1).") ".$element->plaintext;
	$next_line_roof =true;
   }

   if (contains_ck($element->plaintext,"Umpires")){
    echo $element->plaintext;
	$next_line_umpire =true;
   }
   
  }
  
}else {
echo "The Yesterday data  for game ".$game->vars["id"]." was already kept<BR>";	
}
 */
 
 $data = get_game_data($game->vars["espn_game"]);
 
 $game->vars["runs_away"]= $data["runs_away"];
 $game->vars["runs_home"]= $data["runs_home"];
 $game->vars["hits_away"]= $data["homeruns_away"];
 $game->vars["hits_home"]= $data["homeruns_home"];
 $game->update(array("runs_away","runs_home","hits_away","hits_home")); 

 $i++;
 //break;
 
}

}


} // end FOR


$fp = fopen('./ck/baseball_file/old_jobs/date_games_start2.txt', 'w');
		fwrite($fp, $date);
		fclose($fp);
		
		

function get_game_data($gameid){

  $html = file_get_html("http://scores.espn.go.com/mlb/boxscore?gameId=".$gameid."");

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
  $data["homeruns_away"] = 0;
  $data["homeruns_home"] = 0;
  $new_line = false;
  $start_run = true;
  $first = 0;
  $first_colum = false;
  $j=0;
  
  foreach($html->find("table.linescore td") as $element) { 
		  
	//echo $element->plaintext."<BR>";	  
      
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
				 $data["homeruns_home"] =  trim($element->plaintext);
			  }
			  else{
				 $data["homeruns_away"] = trim($element->plaintext);
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
     
	 echo "<pre>";
	 print_r($data);
 	 echo "</pre>";
	 $html->clear();

    return $data;	
}

function get_game_data2($gameid){

  $html = file_get_html("http://scores.espn.go.com/mlb/boxscore?gameId=".$gameid."");

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
  $data["homeruns_away"] = 0;
  $data["homeruns_home"] = 0;
  $new_line = false;
  $start_run = true;
  $first = 0;
  $first_colum = false;
  $j=0;
  
  foreach($html->find('td') as $element) { 
		  
	echo $element->plaintext."<BR>";	  
      
	  $columns = $element->plaintext;
	  
	  /*
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
				 $data["homeruns_home"] =  trim($element->plaintext);
			  }
			  else{
				 $data["homeruns_away"] = trim($element->plaintext);
			  }
			    
		  }
		  if ($i==($real_column+4)){
		   $i=0;
		   $home = true;
		  }
		   
	     $i++;
	   } 
	   */
    
    $j++;	
   }  ?></table><BR><?
     
	 echo "<pre>";
	 print_r($data);
 	 echo "</pre>";
	 $html->clear();

    return $data;	
}



?>
<? 
require_once(ROOT_PATH . "/ck/db/handler.php"); 
require_once(ROOT_PATH . '/includes/html_dom_parser.php'); 
require_once(ROOT_PATH . '/ck/baseball_file/process/functions.php');

  
set_time_limit(0);

// Find today games and Teams

$date = $_GET['date'];
if($date == ""){
$date = date("Y-m-d");	
}



echo "------------------<BR>";
echo "CATCHER FOR TEAM .$date<br>";
echo "------------------<BR><BR>";

$games = get_basic_baseball_games_by_date($date,true);

foreach ($games as $game){
$j = 0;

//if (!$game->started()){
if( $game->vars["catcher_away"] == "-1" ||  $game->vars["catcher_home"] == "-1"){

	
$data = get_catcher($game->vars["espn_game"]);
//$data = get_catcher(380329115);
 if(!empty($data)){
	 
	 foreach ($data as $d){
		
		$player =   get_baseball_player_by_id("espn_player",$d["id"]) ;
		if(!is_null($player)){
		       $data[$j]["fansgraph_player"] = $player->vars["fangraphs_player"];	          
		    }
	   
	   
	   if($j == 0){//away
	       if($data[$j]["fansgraph_player"] != ""){
  		     $game->vars["catcher_away"] =  $data[$j]["fansgraph_player"];
		   } else { echo "FALTA AWAY";}
			 
		}
		if($j == 1){//away
	       if($data[$j]["fansgraph_player"] != ""){
  		     $game->vars["catcher_home"] =  $data[$j]["fansgraph_player"];
		   }  else { echo "FALTA HOME";}
			 
		}
		$j++; 
	 }
	 
	 $game->update(array("catcher_home","catcher_away"));
	 
   	 echo "<pre>";
	 print_r($data);
 	 echo "</pre>";
	 
 }
 //} //started

  } else { echo "---->Catchers completed<BR>"; }
 //break;

}

function get_catcher($gameid){


  $html = file_get_html("http://scores.espn.go.com/mlb/boxscore?gameId=".$gameid."");

 
  echo "http://scores.espn.go.com/mlb/boxscore?gameId=".$gameid."<BR>";
	  

	
	  
  //
  $data = array();
  $control = false;
		$k=0;  
		
  if(!empty($html)) {		
		
      foreach($html->find('div[id="gamepackage-box-score"]') as $elementa) { 
		   
		     $line = false; 
			 foreach ($elementa->find("table tr") as $tr){
				// echo "<BR>";
				  foreach ($tr->find("th") as $th){
					 
					  if($th->plaintext == "Hitters" ){ $line = true;}
				  }
				
				 if($line){
					//echo "ENTRA";
				  foreach($tr->find("td") as $td){
				      // echo $td->plaintext." -  ";
					  if (substr($td->plaintext, -1) == "C") {
						  $data[$k]["catcher"] =  $td->plaintext;
						  foreach ( $td->find(a) as $a){
							  $pitcher_away = str_center("id/","/",$a->href);	 
							  $pitcherid_away =  str_center("id","/",$a->href);	 
							  $pitcher_away =  str_center("/"," ",$pitcher_away);	 	 
							  $pitcherid_away =  str_center("/","/".$pitcher_away,$pitcherid_away);
							  $pitcher_away = str_replace("-"," ",$pitcher_away);	 
							  $pitcher_away = str_replace("'"," ",$pitcher_away);	
							  
							  $data[$k]["id"] = $pitcherid_away;
							 
						   }
							
						   
							//echo "<BR>BREAK<BR>";
							$line = false;
							
							$k++;
							 break;
						  }
						 // break;
				   }
				 //  break;
				 }
				 
				 
			// echo "<BR>";
			 }		
	  }
  
  /*foreach($html->find("Div.gamepackage-box-score") as $element) { 
		
		 echo $element->plaintext."<BR>";
		 foreach ($element->find('table') as $table) {
			 foreach ($table->find('tr') as $tr){  
				foreach ($tr->find('td') as $td){
					  if (substr($td->plaintext, -1) == "C") {
						  $data[$k]["catcher"] =  $td->plaintext;
						  foreach ( $td->find(a) as $a){
							  $pitcher_away = str_center("id/","/",$a->href);	 
							  $pitcherid_away =  str_center("id","/",$a->href);	 
							  $pitcher_away =  str_center("/"," ",$pitcher_away);	 	 
							  $pitcherid_away =  str_center("/","/".$pitcher_away,$pitcherid_away);
							  $pitcher_away = str_replace("-"," ",$pitcher_away);	 
							  $pitcher_away = str_replace("'"," ",$pitcher_away);	
							  
							  $data[$k]["id"] = $pitcherid_away;
							 
						   }
							$k++;
						  break;
						  }
				 
				}
				if ( contains_ck($tr->plaintext,'Totals')) { $control = true;  break; }
			 }

			if($control){break;}
		 }
    $j++;	 
		}
     */
	 $html->clear();
 
  }// html
 
    return $data;	

}
?>
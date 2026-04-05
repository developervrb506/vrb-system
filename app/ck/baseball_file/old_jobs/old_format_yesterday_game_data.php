<? require_once(ROOT_PATH . "/ck/db/handler.php"); 
    require_once('../../../includes/html_dom_parser.php');  
	ini_set('memory_limit', '-1');
    set_time_limit(0);
	


//***********************************
// Find the Game weather and Umpire and Scores
//**********************************


$file = fopen("./ck/baseball_file/old_jobs/fecha.txt", "r") or exit("Unable to open file!");
while(!feof($file))
{
$date =  ltrim(fgets($file));
}
fclose($file);


//$date='2013-03-13';

//for ($k=1;$k<2;$k++) {
	
echo "---------------<BR>";
echo "Stadistics for Yesterday Game<BR>";
echo "-------".$date."-----<BR><BR>";	

//$date = date( "Y-m-d", strtotime( "-1 day", strtotime(date($date)))); 


$games = get_games_format();
$i=0;




foreach ($games as $game ){
	
$year = date('Y',strtotime($game->vars["startdate"]));	

if ($game->vars["real_roof_open"] == -1 || $game->vars["umpire"]  == 0 || $game->vars["firstbase"]  == 0){ 
   
   $html = file_get_html("http://scores.espn.go.com/mlb/boxscore?gameId=".$game->vars["espn_game"]."");
   $next_line_roof = false;
   $next_line_umpire = false;
  
  
  
  foreach ( @$html->find('td style="text-align:left; "') as $element ) {

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
	 $umpire = str_center("Home - ",",",$element->plaintext);	
  	 $umpire = str_replace("  "," ",$umpire);
	 $umpire = str_replace("'"," ",$umpire);
	 echo " -> ".$umpire. " ";
   	 $id_umpire = get_game_umpire_by_name($umpire."");
	 print_r($id_umpire);
     echo"<BR>"; 
	 $firstbase = str_center(", First Base - ",", ",$element->plaintext);	
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
 
 
 $data = get_game_data($game->vars["espn_game"],$year,$game->vars["team_home"],$game->vars["team_away"],$game);
 
 $game->vars["runs_away"]= $data["runs_away"];
 $game->vars["runs_home"]= $data["runs_home"];
 $game->vars["homeruns_away"]= $data["homeruns_away"];
 $game->vars["homeruns_home"]= $data["homeruns_home"];
 $game->update(array("runs_away","runs_home","homeruns_away","homeruns_home")); 

 $i++;
 //break;
 
}
//} // end FOR

/*
$fp = fopen('./ck/baseball_file/old_jobs/fecha.txt', 'w');
		fwrite($fp, $date);
		fclose($fp);
		
*/		

function get_game_data($gameid,$year,$team_home,$team_away,$game){

  $html = file_get_html("http://scores.espn.go.com/mlb/boxscore?gameId=".$gameid."");

  echo "http://scores.espn.go.com/mlb/boxscore?gameId=".$gameid."<BR>";
	    
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
  $home=false;
  $j=0;
  
  foreach ($html->find('div.game-notes') as $div){
	  
	    $k=0;
		foreach ($div->find('a') as $a){
			//echo "<BR>".$a->href."<BR>";
		  
		    if ($k==1) {
				$pitcher_away = str_center("id/","/",$a->href);	 
				$pitcherid_away =  str_center("id","/",$a->href);	 
				$pitcher_away =  str_center("/"," ",$pitcher_away);	 	 
				$pitcherid_away =  str_center("/","/".$pitcher_away,$pitcherid_away);
				$pitcher_away = str_replace("-"," ",$pitcher_away);	 
  		        $pitcher_away = str_replace("'"," ",$pitcher_away);	
			    //echo $element->href."- ".$pitcher_away." - ".$pitcherid_away."<BR>"; 
			  //echo "TES".$a->href	;
			   }
			   
			   if($k==0){
				//echo "TES".$a->href	;
						
				$pitcher_home = str_center("id/","/",$a->href);	 
				$pitcherid_home =  str_center("id","/",$a->href);	 
				$pitcher_home =  str_center("/"," ",$pitcher_home);	 	 
				$pitcherid_home =  str_center("/","/".$pitcher_home,$pitcherid_home);	 
				$pitcher_home = str_replace("-"," ",$pitcher_home);
 		        $pitcher_home = str_replace("'"," ",$pitcher_home);	
			    //echo $element->href." ".$pitcher_home." - ".$pitcherid_home."<BR>"; 
				
				}
			
		$k++;
		  if ($k==2){
		    break;
		  }
		
		}
	
	  
		
	  $home_team = get_baseball_team($team_home); 
	  //echo $team_home."aa ";
	  //print_r($home_team);
	  $away_team = get_baseball_team($team_away); 
      //echo $teams_away."ss ";
	  //print_r($away_team);
  	  $player_a = get_baseball_player_by_team("espn_nick",$pitcher_away,$away_team->vars["fangraphs_team"],$year); 
	  $player_h = get_baseball_player_by_team("espn_nick",$pitcher_home,$home_team->vars["fangraphs_team"],$year); 	

	  echo "AWAY<BR>";  
	  print_r($player_a); 
	  if (is_null($player_a)){
		echo "FALTA A ".$pitcher_away; 
	  }
	   
	  echo "<BR>HOME<BR>"; 
	  print_r($player_h);  
	  if (is_null($player_h)){
		echo "FALTA H ".$pitcher_home; 
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
		
	  }
		
		
	  
      }
  
  
  
  foreach($html->find("table.linescore td") as $element) { 
		  
	      
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

function get_games_format(){
baseball_db();	

//$sql ="SELECT * FROM `game` WHERE runs_away = 0 and startdate > '2013-01-01 00:00:00' and startdate < '2013-07-14 00:00:00' AND postponed !=1 order by startdate ";

$sql='SELECT * FROM `game` WHERE espn_game IN ("320317116","320317125","320316124","320316123","320316114","320316110","320316121","320316107","320316119","320316116","320316129","320316115",
"320316117","320316111","320315128","320315106","320315120","320315109","320315118","320315102","320315119","320315103","320315105","320315108",
"320315112","320314124","320314101","320314106","320314130","320314122","320314114","320314116","320314104","320314126","320314115","320314112",
"320313128","320313118","320313101","320313121","320313107","320313125","320313105","320313119","320313126","320313129","320313120","320313110",
"320312123","320312130","320312106","320312114","320312102","320312107","320312103","320312105","320312112","320312104","320312116","320312127",
"320312110","320311124","320311101","320311130","320311121","320311119","320311125","320311111","320311126","320310128","320310123","320310122",
"320310115","320310114","320310111","320310107","320310105","320310102","320309130","320309118","320309106","320309109","320309103","320309113",
"320309112","320309108","320309104","320309127","320309128","320309102","320308122","320308120","320308114","320308124","320308101","320308121",
"320308119","320308116","320308105","320308113","320308125","320308108","320308127","320307122","320307120","320307110","320307101","320307106",
"320307111","320307107","320307103","320307104","320307126","320307129","320306123","320306130","320306115","320306114","320306102","320306108",
"320306112","320306103","320306119","320306116","320306129","320305124","320305118","320305106","320305122","320305107","320305104","320305125",
"320305117","320305127","320305121","320305109","320305126","320304106","320304120","320304110","320304123","320304113","320304105","320304116",
"320304112","320303115","320303122","320303114","320303109","320303118","320303117","320303112","320302111") &&  (pitcher_away ="" || pitcher_home ="") and postponed = 0
';	
//echo $sql;
return get($sql, "_baseball_game");	
}


?>
<? require_once(ROOT_PATH . "/ck/db/handler.php"); 
    require_once('../../../includes/html_dom_parser.php');  
	ini_set('memory_limit', '-1');
    set_time_limit(0);
	


//***********************************
// Find the Game weather and Umpire and Scores
//**********************************

/*
$file = fopen("./ck/baseball_file/old_jobs/fecha.txt", "r") or exit("Unable to open file!");
while(!feof($file))
{
$date =  ltrim(fgets($file));
}
fclose($file);
*/

//$date='2013-03-13';

//for ($k=1;$k<2;$k++) {
	
echo "---------------<BR>";
echo "Stadistics for Yesterday Game<BR>";
echo "---------------<BR><BR>";	

//$date = date( "Y-m-d", strtotime( "-1 day", strtotime(date($date)))); 


$games = get_games_format();
$i=0;




foreach ($games as $game ){
	
$umpire_date = date("Y_m_d",strtotime($game->vars["startdate"]));	
$year = date('Y',strtotime($game->vars["startdate"]));	

 $home_team = get_baseball_team($game->vars["team_home"]); 
   $away_team = get_baseball_team($game->vars["team_away"]); 
	
   $html2 = file_get_html("http://mlb.mlb.com/mlb/gameday/index.jsp?gid=".$umpire_date."_".$away_team->vars["mlb_nick"]."_".$home_team->vars["mlb_nick"]."_".$game->vars["game_number"]."&mode=box");
	
    echo $game->vars["id"]." - http://mlb.mlb.com/mlb/gameday/index.jsp?gid=".$umpire_date."_".$away_team->vars["mlb_nick"]."_".$home_team->vars["mlb_nick"]."_".$game->vars["game_number"]."&mode=box";
	
       foreach ( @$html2->find('div [id=game-info-container]') as $element ) {
	       $umpire = str_center("HP: ",". 1B",$element->plaintext);	
           $umpire = str_replace("  "," ",$umpire);
   	       $umpire = str_replace("'"," ",$umpire);
		   $id_umpire = get_game_umpire_by_name($umpire); 
	  	   echo "<BR>".$umpire." ";
	       print_r($id_umpire);	          
		   $game->vars["umpire"] = $id_umpire->vars["id"]; 
		   $game->vars["real_umpire"] = $id_umpire->vars["id"]; 

		   
		    if ($id_umpire->vars["id"]){
			$umpire_stadistics = get_umpire_basic_stadistics($id_umpire->vars["id"],$year);	
			 $game->vars["umpire_kbb"]= $umpire_stadistics->vars["k_bb"];
			 $game->vars["umpire_starts"]= ($umpire_stadistics->vars["hw"] + $umpire_stadistics->vars["rw"]);
   	         $game->update(array("real_umpire","umpire","umpire_kbb","umpire_starts")); 
			
			}
		   
		   
		   
        
	  }
       echo"<BR>";   
	  //  break;
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
  
  foreach (@$html->find('div.game-notes') as $div){
	  
	    $k=0;
		foreach (@$div->find('a') as $a){
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
		 //   break;
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
  
  
  
  foreach(@$html->find("table.linescore td") as $element) { 
		  
	      
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

$sql="SELECT *
FROM `game`
WHERE umpire =0 
AND startdate > '2011-01-01 00:00:00'
AND startdate < '2011-12-14 00:00:00'
and postponed != 1
ORDER BY startdate
limit 100
";	
//echo $sql;
return get($sql, "_baseball_game");	
}


?>
<? require_once(ROOT_PATH . "/ck/db/handler.php"); 
   require_once(ROOT_PATH . '/includes/html_dom_parser.php'); 
   require_once(ROOT_PATH . '/ck/baseball_file/process/functions.php');
	
	ini_set('memory_limit', '-1');
    set_time_limit(0);
	

$page = $_SERVER['PHP_SELF'];
$sec = "60";
?><head>
    <meta http-equiv="refresh" content="<?php echo $sec?>;URL="<? echo $page  ?>"">
    </head>
<? 

//*********************************************
// Find the Game weather and Umpire and Scores
//**********************************************


$file = fopen("./ck/baseball_file/old_jobs/date.txt", "r") or exit("Unable to open file!");
while(!feof($file))
{
$date =  ltrim(fgets($file));
}
fclose($file);


$yesterday = date( "Y-m-d", strtotime( "-1 day", strtotime(date( "Y-m-d")))); 
//$yesterday="2014-09-20";
//$date='2014-09-16';


	
echo "---------------<BR>";
echo "Stadistics for Yesterday Game<BR>";
echo "---------------<BR><BR>";	

$date = date( "Y-m-d", strtotime( "-1 day", strtotime(date($date)))); 


echo "Fecha: ".$date."<BR>";
$bets = get_baseball_bets($date);

$games = get_basic_baseball_games_by_date($date);





$i=0;

$yesterday = $date;

foreach ($games as $game ){

if ($game->vars["real_roof_open"] == -1 || $game->vars["umpire"]  == 0 || $game->vars["firstbase"]  == 0){ 
   
   $link = "http://www.espn.com/mlb/game?gameId=";
   $html = file_get_html($link.$game->vars["espn_game"]."");
   echo $link.$game->vars["espn_game"]."<BR>";
   $next_line_roof = false;
   $next_line_umpire = false;
   
    $j=0;
	
	
   foreach($html->find('div[class="game-status"]') as $div){
	 
	     if ((contains_ck($div->plaintext,"Postponed")) || (contains_ck($div->plaintext,"Cancelled")) ){
			 $game->vars["postponed"]= 1;
    	  	 $game->update(array("postponed"));
		 }
	   
	 }
  

   foreach ($html->find('div[class="game-info-note"]') as $element){
	   
	   
	   if ((contains_ck($element->plaintext,"Umpires")) ){
		   
		 $umpire = str_center("Home Plate Umpire - ",",",$element->plaintext);	
		 $umpire = str_replace("  "," ",$umpire);
		 $umpire = str_replace("'"," ",$umpire);
		 echo " umpire #1 -> ".$umpire. "  #";
		 $id_umpire = get_game_umpire_by_name($umpire."");
		 print_r($id_umpire);
		 echo"<BR>"; 
		 $firstbase = str_center("First Base Umpire - ",", Second Base Umpire",$element->plaintext);	
		 $firstbase = str_replace("  "," ",$firstbase);
		 $firstbase = str_replace("'"," ",$firstbase);
		 echo " First Base -> ".$firstbase. " ";
		 $id_firstbase = get_game_umpire_by_name($firstbase."");
		 print_r($id_firstbase);  
		 
		 $game->vars["real_umpire"] = $id_umpire->vars["id"]; 
		 $game->vars["firstbase"] = $id_firstbase->vars["id"];
		 $game->update(array("real_umpire","firstbase")); 
		 
		 if (!$game->vars["umpire"]){
		
			 $game->vars["umpire"] = $id_umpire->vars["id"]; 
			 $umpire_stadistics = get_umpire_basic_stadistics($id_umpire->vars["id"],$year);	
			 $game->vars["umpire_kbb"]= $umpire_stadistics->vars["k_bb"];
			 $game->vars["umpire_starts"]= ($umpire_stadistics->vars["hw"] + $umpire_stadistics->vars["rw"]);
			 $game->update(array("umpire","umpire_kbb","umpire_starts")); 
				 
	    }
		 
	  }

   }

   // break;
}else {
echo "The Yesterday data  for game ".$game->vars["id"]." was already kept<BR>";	
}
 
 
 // Obtain the Scores and Runs, Homeruns for the game
 $data = get_game_data($game->vars["espn_game"]);
 $game->vars["runs_away"]= $data["runs_away"];
 $game->vars["runs_home"]= $data["runs_home"];
 $game->vars["hits_away"]= $data["hits_away"];
 $game->vars["hits_home"]= $data["hits_home"];
 $game->update(array("runs_away","runs_home","hits_away","hits_home")); 

 $away = get_bullepin_away($game->vars["espn_game"]);
 $home = get_bullepin_home($game->vars["espn_game"]);
 $game->vars["homeruns_away"]= $away["HR"];
 $game->vars["homeruns_home"]= $home["HR"];
 $game->update(array("homeruns_away","homeruns_home")); 

 $i++;
 
 //Update the Bets according the Score
 if (isset($bets[$game->vars["id"]]->vars["game"])){
	 
  	 $total_runs = $data["runs_away"]+ $data["runs_home"];
	 $status = 0;
	 if ($bets[$game->vars["id"]]->vars["bet_type"] == "u" && $bets[$game->vars["id"]]->vars["value"] > $total_runs){$status = 1;}
 	 if ($bets[$game->vars["id"]]->vars["bet_type"] == "u" && $bets[$game->vars["id"]]->vars["value"] == $total_runs){$status = 3;}
	 if ($bets[$game->vars["id"]]->vars["bet_type"] == "o" && $bets[$game->vars["id"]]->vars["value"] < $total_runs){$status = 1;}
 	 if ($bets[$game->vars["id"]]->vars["bet_type"] == "o" && $bets[$game->vars["id"]]->vars["value"] == $total_runs){$status = 3;}	 
	 
	 $bets[$game->vars["id"]]->vars["status"]= $status;
	 $bets[$game->vars["id"]]->update(array("status"));
 
 
 }
 
 
 //Obtain Daily Bullpen for Team
  $days = 1;
  $ip_a=0;
  $pc_a=0;
  $pc_h=0;
  $ip_h=0;
	  
    //Away
    $data = array();
    $data = get_bullepin_away($game->vars["espn_game"]);
	    $ip_a = $ip_a + $data["IP"];
        $pc_a = $pc_a + $data["PC"]; 
		
	 $bullpen_a = get_team_bullpen($game->vars["team_away"],$yesterday,$days);
	     
	  
	   if (is_null($bullpen_a)){
		  $bullpen_a = new _baseball_team_bullpen();
		  $bullpen_a->vars["team"]=$game->vars["team_away"]; 
		  $bullpen_a->vars["ip"]=$ip_a;
		  $bullpen_a->vars["pc"]=$pc_a;
		  $bullpen_a->vars["date"]= $yesterday;
		  $bullpen_a->vars["days"]= $days;
		  $bullpen_a->insert();
		    
	   }
 	   else{   
		  $bullpen_a->vars["ip"]=$ip_a;
		  $bullpen_a->vars["pc"]=$pc_a;
		  $bullpen_a->vars["date"]= $yesterday;
		  $bullpen_a->update(array("ip","pc","date"));
		   
	   }	
		
     //Home
    $data = array();
    $data= get_bullepin_home($game->vars["espn_game"]);
	    $ip_h = $ip_h + $data["IP"];
        $pc_h = $pc_h + $data["PC"]; 	
		
		
	   $bullpen_h = get_team_bullpen($game->vars["team_home"],$yesterday,$days);
	  
	   	  if (is_null($bullpen_h)){
		     $bullpen_h = new _baseball_team_bullpen();
		     $bullpen_h->vars["team"]=$game->vars["team_home"]; 
		     $bullpen_h->vars["ip"]=$ip_h;
		     $bullpen_h->vars["pc"]=$pc_h;
		     $bullpen_h->vars["date"]= $yesterday;
			 $bullpen_h->vars["days"]= $days;
		     $bullpen_h->insert();
		    
	      }
 	      else{   
		    $bullpen_h->vars["ip"]=$ip_h;
		    $bullpen_h->vars["pc"]=$pc_h;
		    $bullpen_h->vars["date"]= $yesterday;
		    $bullpen_h->update(array("ip","pc","date"));
		   
	      }	 
 
}



$fp = fopen('./ck/baseball_file/old_jobs/date.txt', 'w');
		fwrite($fp, $date);
		fclose($fp);
		
		

?>
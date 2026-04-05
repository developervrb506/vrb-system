<? $no_log_page = true; ?>
<? require_once(ROOT_PATH . "/ck/db/handler.php"); 
    require_once(ROOT_PATH . '/includes/html_dom_parser.php');  
	require_once(ROOT_PATH . '/ck/baseball_file/process/functions.php');
    // require_once("../../../includes/html_dom_parser.php");  
	ini_set('memory_limit', '-1');
    set_time_limit(0);

// Find today games and Teams
echo "---------------<BR>";
echo "ESPN GAMES<br>";
echo "---------------<BR><BR>";

//patch
// replace strstr for myStrstrTrue

$games = get_basic_baseball_games_by_date(date('Y-m-d'));
//$games = get_basic_baseball_games_by_date("2025-05-16");
echo "<pre>";
print_r($games);



if (!is_null($games)) {

$schedule=date("Ymd") ;
//$schedule = "20250516";


$link = "http://espn.go.com/mlb/schedule?date=".$schedule."";
$html = file_get_html($link);
echo $link."<BR>";
$umpire_date = date("Y_m_d");
//$umpire_date = "2025_05_16";
$espn = array();
$i=0;
$n=0;
$conversation_link = "http://espn.go.com/mlb/conversation?gameId=";
$gamecast = "http://www.espn.com/mlb/game?gameId=";
$matches = array();



$espn = array();
$i=0;
$n=0;
$conversation_link = "http://espn.go.com/mlb/conversation?gameId=";

//echo $link;

 foreach ($html->find('table[class="Table"]') as $table){

 // foreach ($table->find('tr[class="Table__TR Table__TR--sm Table__even"]') as $tr){
  foreach ($table->find('tr') as $tr){

  	                               // Table--even Table__TR Table__TR--sm Table__even

	//echo "<BR><BR>";

   		$n=0;
   		foreach ($tr->find('a') as $a){

	     if($n<=4){
	      echo $n.") ".$a->plaintext." -- ".$a->href." // <BR>";

             $link =   $a->href; 
	     
              if ($n==0){
				$espn[$i]["away"] =  str_center('_/name/','/',$link); 
			    $espn[$i]["away"] = strtoupper(substr($espn[$i]["away"],0,strpos($espn[$i]["away"], "/")));
			 }
			  if ($n==3){
				$espn[$i]["home"] = str_center('_/name/','/',$link); 
   			    $espn[$i]["home"] = strtoupper(substr($espn[$i]["home"],0,strpos($espn[$i]["home"], "/")));
			 }
			  if ($n==4){
			  	$link .= "@";
				

				$game_array= explode("/", str_center('gameId/','/',$link));
				$espn[$i]["game"]= $game_array[0];
				$espn[$i]["startdate"] = $a->plaintext;
				
				
				$espn[$i]["page"] = $conversation_link.$espn[$i]["game"]; 
				
				 foreach ($espn as $check){
	   			  if  ($check["away"] == $away && $check["home"] == $home){$repeat = true;	}
     			 }
	 			 if ($repeat){ $number = 2;
	 			 	$repeat = false;
	 			 }
	 			 else {$number = 1;}
				$espn[$i]["number"]= $number;
				$espn[$i]["key"]= $i;
				$i++;
				break;
			   
			 }

	     } 
         $n++;
   		}	


   }
   break;
 } 	



		



echo "<pre>";

//print_r($matches);

print_r($espn);
echo "</pre>";





echo "---------------<BR>";
echo "GAMES<br>";
echo "---------------<BR><BR>";


echo "<pre>";
//print_r($games);
//echo "</pre>";

$i=0;
$done = array();
foreach ($games as $game){

   $home_team = get_baseball_team($game->vars["team_home"]); 
   $away_team = get_baseball_team($game->vars["team_away"]); 
  //print_r($home_team);	
 // print_r($away_team);	
    

  foreach ($espn as $espn_game){
		
    if (strtoupper($home_team->vars["espn_id_name"]) == strtoupper($espn_game["home"]) &&  strtoupper($away_team->vars["espn_id_name"]) == strtoupper($espn_game["away"]) ){		
      
   // If the game was already saved it does not save it again.
      // echo " ENTRA ";
	  
	  if(!isset($done[$espn_game["game"]])){
      
	  if (!$game->vars["espn_game"]){
		$game->vars["espn_game"] = $espn_game["game"];  
		$game->vars["game_number"] = $espn_game["number"];
	    $game->update(array("espn_game","game_number")); 
		   //    echo "entra2<BR>";
	  }
	  unset($espn[$espn_game["key"]]);
	 
	  $done[$espn_game["game"]]	= $espn_game["game"];
	  
	  	 echo ($i+1).") ".$game->vars["id"]." ".$game->vars["team_home"]." vs ". $game->vars["team_away"]. " = ".$espn_game["game"]." ".$espn_game["home"]." vs ".$espn_game["away"]."<BR>"; 
	    break;
	  }
   // } 
	

	
	  	
   
    }
  }
 //}
 $i++;	 
}

}

?>
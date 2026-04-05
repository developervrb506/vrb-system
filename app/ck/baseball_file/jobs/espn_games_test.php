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

//$a = json_encode(file_get_contents("http://scores.espn.go.com/mlb/scoreboard?date=".$schedule.""));
echo "<pre>";
// print_r($a);
echo "</pre>";

$games = get_basic_baseball_games_by_date(date('Y-m-d'));
//$games = get_basic_baseball_games_by_date("2018-03-29");


if (!is_null($games)) {

$schedule=date("Ymd") ;
//$schedule = "20180329";


$link = "http://espn.go.com/mlb/schedule?date=".$schedule."";
$html = @file_get_html($link);
echo $link."<BR>";
$umpire_date = date("Y_m_d");
$espn = array();
$i=0;
$n=0;
$conversation_link = "http://espn.go.com/mlb/conversation?gameId=";
$gamecast = "http://www.espn.com/mlb/game?gameId=";



	
 foreach ($html->find('div[class="responsive-table-wrap"]') as $elementa){

    foreach ($elementa->find('a') as $element){
        
		
		if ($old!=$element->href){

			if((contains_ck($element->href,"gameId="))|| (contains_ck($element->href,"mlb/team/_/")) ){ 
			
			    $link = $element->href;	 
			 if($n==4){$n=0; break;}
			 
			 if ($n==3){
			    if ($espn[$i]["game"] != str_center('gameId=','&',$link)){
				
				  $n=0;
				  $i++; 
				}else{
					$espn[$i]["game"]= str_center('gameId=','&',$link);
				     $i++;
				 }
			
			 }
			 
			 if ($n==0){
				$espn[$i]["away"] =  str_center('_/name/','/',$link); 
			//	$espn[$i]["away"] = str_replace("/","",substr($espn[$i]["away"],0,3));
			    $espn[$i]["away"] = substr($espn[$i]["away"],0,strpos($espn[$i]["away"], "/"));
			 }
			  if ($n==1){
				$espn[$i]["home"] = str_center('_/name/','/',$link); 
				 $espn[$i]["home"] = substr($espn[$i]["home"],0,strpos($espn[$i]["home"], "/"));
			 }
			  if ($n==2){
								
				$espn[$i]["game"] = str_center('gameId=','&',$link); 
			   // $espn[$i]["page"] = $conversation_link.$espn[$i]["game"]; 
			    $espn[$i]["page"] = $gamecast.$espn[$i]["game"]; 
				
				 foreach ($espn as $check){
	   			  if  ($check["away"] == $away && $check["home"] == $home){$repeat = true;	}
     			 }
	 			 if ($repeat){ $number = 2;
	 			 	$repeat = false;
	 			 }
	 			 else {$number = 1;}
				$espn[$i]["number"]= $number;
				
			 }
			
			 $n++;
			
			}
		}
	  $old=$element->href;
	
	}
 break; // just the first div is for the today games
 
 }
	
		
		


$j=0; 




//Get the Game hour

foreach ($espn as $_espn){
 $html = file_get_contents($_espn["page"]);
 $html = str_replace('11:05 AM CT',"11:03 AM CT",$html);
  $test = str_center("11", "CT", $html);
 // echo $test;
  //  $html = str_replace('</span>',"",$html);
  
 echo  $html;
//$html2 = file_get_html_parts(0,2,$_espn["page"]);	
  break;
 if(!empty($html2))	{
  foreach ( $html2->find('div[class="game-status"]') as $element ) {
// foreach ( $html2->find('span') as $element ) {	 
     foreach ( $element->find('span') as $element1 ) {
		  echo $element1->plaintext;
		     foreach ( $element1->find('span') as $element2 ) { 
			    echo $element2->plaintext;
			 }
	 }
   


	  foreach ($element as $p){
	    if (contains_ck($p->plaintext,"ET")){
        $espn[$j]["starttime"]= date("H:i:s",strtotime(myStrstrTrue($p->plaintext,'ET')));
		}
	  }
	   
  }
  $j++;
 }
}


echo "<pre>";
print_r($espn);
echo "</pre>";





echo "---------------<BR>";
echo "GAMES<br>";
echo "---------------<BR><BR>";


echo "<pre>";
//print_r($games);
echo "</pre>";





$i=0;
foreach ($games as $game){
// break;
 //if(!$game->started()){
 
   $home_team = get_baseball_team($game->vars["team_home"]); 
   $away_team = get_baseball_team($game->vars["team_away"]); 
	
  foreach ($espn as $espn_game){
	  
	// echo date("H",strtotime($game->vars["startdate"])) .".==.". date("H",strtotime($espn_game["starttime"]))."<BR>";
	//  echo $home_team->vars["espn_id_name"] ."==". $espn_game["home"]."<BR>";
	//  echo $away_team->vars["espn_id_name"] ."==". $espn_game["away"]."<BR>";
  	  
	  
   // if ($home_team->vars["espn_id_name"] == $espn_game["home"] &&  $away_team->vars["espn_id_name"] == $espn_game["away"] && date("H",strtotime($game->vars["startdate"])) == date("H",strtotime($espn_game["starttime"])) ){
		
    if ($home_team->vars["espn_id_name"] == $espn_game["home"] &&  $away_team->vars["espn_id_name"] == $espn_game["away"] ){		
      
   // If the game was already saved it does not save it again.
    if (!$game->vars["espn_game"]){
      $game->vars["espn_game"] = $espn_game["game"];
	  $game->vars["game_number"] = $espn_game["number"];
	  $game->update(array("espn_game","game_number")); 
    } 
	   echo ($i+1).") ".$game->vars["id"]." ".$game->vars["team_home"]." vs ". $game->vars["team_away"]. " = ".$espn_game["game"]." ".$espn_game["home"]." vs ".$espn_game["away"]." at ".$espn_game["starttime"]." ---> <BR>"; 	
   
    }
  }
 //}
 $i++;	 
}

}

?>
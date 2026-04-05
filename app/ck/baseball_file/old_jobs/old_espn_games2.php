<? require_once(ROOT_PATH . "/ck/db/handler.php"); 
    require_once('../../../includes/html_dom_parser.php');  
	ini_set('memory_limit', '-1');
    set_time_limit(0);


/*
$file = fopen("./ck/baseball_file/old_jobs/old_espn_date2.txt", "r") or exit("Unable to open file!");
while(!feof($file))
{
$start =  ltrim(fgets($file));
}
fclose($file);

if ($_GET["date"] == "") {
 $date=$start;
 $schedule=$start;
}
else{
  $date = $_GET["date"];
  $schedule =$date;
}
*/

$_games = get_games_format();

//print_r($_games);

foreach($_games as $_game) {
	
  $date = date('Y-m-d',strtotime($_game->vars["startdate"]));
  $schedule = date('Ymd',strtotime($_game->vars["startdate"]));
  espn_old2($date,$schedule);
  //break;
	
}



function espn_old2($date,$schedule){


//for ($k=0; $k<20; $k++){

//$date = date ('Y-m-d',strtotime ( '-1 day' , strtotime ($date))) ;
//$schedule= date ('Ymd',strtotime ( '-1 day' , strtotime ($schedule))) ;


echo "<BR>".$date." / ".$schedule."<BR>";
// Find today games and Teams
echo "---------------<BR>";
echo "ESPN GAMES<br>";
echo "---------------<BR><BR>";







//$schedule=date("Ymd") ;
$html = file_get_html("http://scores.espn.go.com/mlb/scoreboard?date=".$schedule."");

//$umpire_date = date("Y_m_d");
$espn = array();
$i=0;
foreach($html->find('a') as $element) {     
   if (contains_ck($element->href,"conversation?")){
  
     echo ($i+1).". ". $element->href."<BR>";
	 $gameid = str_center("gameId=","&",$element->href);
	 $espn[$i]["game"]= $gameid;
	 $away =  str_center("&teams=","-vs",$element->href);
	 $home =  str_center("vs-"," ",$element->href);
  
      foreach ($espn as $check){
	    if  ($check["away"] == $away && $check["home"] == $home){$repeat = true;	}
      }
	  if ($repeat){ $number = 2;
	  $repeat = false;
	  }
	  else {$number = 1;}
	
	  $espn[$i]["away"]= $away; 
      $espn[$i]["home"]= $home;
      $espn[$i]["number"]= $number;
	  $espn[$i]["page"]= $element->href;
	  $i++;  
    }
	
}

$j=0; 

//Get the Game hour
foreach ($espn as $_espn){
$html2 = file_get_html("http://scores.espn.go.com/".$_espn["page"]);	
	
  foreach ( $html2->find("div.game-time-location p") as $element ) {

	  foreach ($element as $p){
	    if (contains_ck($p->plaintext,"ET")){
        $espn[$j]["starttime"]=strstr($p->plaintext,'ET',true);
		}
	  }
	   
  }
  $j++;
   	 
}



echo "<pre>";
//print_r($espn);
echo "</pre>";


echo "---------------<BR>";
echo "GAMES<br>";
echo "---------------<BR><BR>";


$games = get_basic_baseball_games_by_date(date($date));

$i=0;
foreach ($games as $game){
 
 //if(!$game->started()){
 
   $home_team = get_baseball_team($game->vars["team_home"]); 
   $away_team = get_baseball_team($game->vars["team_away"]); 
	
  foreach ($espn as $espn_game){
    if ($home_team->vars["espn_nick"] == $espn_game["home"] &&  $away_team->vars["espn_nick"] == $espn_game["away"] && date("H",strtotime($game->vars["startdate"])) == date("H",strtotime($espn_game["starttime"])) ){
      
   // If the game was already saved it does not save it again.
    if ($game->vars["espn_game"]){
        $game->vars["espn_game"] = $game->vars["espn_game"];
	}
	else {
       $game->vars["espn_game"] = $espn_game["game"];
	}
		
	  $game->vars["game_number"] = $espn_game["number"];
	  $game->update(array("espn_game","game_number")); 
   //} 
    echo ($i+1).") ".$game->vars["id"]." ".$game->vars["team_home"]." vs ". $game->vars["team_away"]. " = ".$espn_game["game"]." ".$espn_game["home"]." vs ".$espn_game["away"]." at ".$espn_game["starttime"]." ---> <BR>"; 	
   $i++;	
    }
  }
 //}
  
}

//}
/*
if ($_GET["date"] == "") {
  $fp = fopen('./ck/baseball_file/old_jobs/old_espn_date2.txt', 'w');
		fwrite($fp, $date);
		fclose($fp);
}

*/
}


function get_games_format(){
baseball_db();	

$sql="SELECT *
FROM game
WHERE startdate > '2013-08-01 00:00:00'
AND startdate < '2013-09-09 00:00:00'
AND (espn_game =0 || espn_game = '')
ORDER BY `startdate` ASC 

";


return get($sql, "_baseball_game");	
}



?>
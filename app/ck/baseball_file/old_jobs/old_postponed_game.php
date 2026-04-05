<? require_once(ROOT_PATH . "/ck/db/handler.php"); 
    require_once('../../../includes/html_dom_parser.php');  
	ini_set('memory_limit', '-1');
    set_time_limit(0);
	


//***********************************
// Find the Game weather and Umpire and Scores
//**********************************

$file = fopen("fecha2.txt", "r") or exit("Unable to open file!");
//Output a line of the file until the end is reached

while(!feof($file))
{
$start =  ltrim(fgets($file));
}
fclose($file);


/*$file = fopen("date_games_end.txt", "r") or exit("Unable to open file!");
//Output a line of the file until the end is reached
while(!feof($file))
{
$end =  ltrim(fgets($file));
}
fclose($file);
*/


$end = date ('Y-m-d',strtotime ( '-10 day' , strtotime (trim($start)))) ;	

	
echo "----------------------------------<BR>";
echo "--------Posponed Games-------------<BR>";
echo "--".$start."-----".$end."------<BR><BR>";	


$games = get_old_games_postponed($start,$end);


foreach ($games as $game ){
	
$year = date('Y',strtotime($game->vars["startdate"]));	

$html = file_get_html("http://scores.espn.go.com/mlb/boxscore?gameId=".$game->vars["espn_game"]."");

   $postponed=false;
   $postponed = check_postponed_games($game->vars["espn_game"]);
    if ($postponed){
    $game->vars["postponed"]= 1;
    $game->update(array("postponed"));
   }
}

$start = date ('Y-m-d',strtotime ( '-10 day' , strtotime (trim($start)))) ;	
		$fp = fopen('fecha2.txt', 'w');
		fwrite($fp, $start);
		fclose($fp);
		
/*$end = date ('Y-m-d',strtotime ( '-10 day' , strtotime (trim($end)))) ;	
		$fp = fopen('date_games_end.txt', 'w');
		fwrite($fp, $end);
		fclose($fp);		
	*/	





function check_postponed_games($gameid){

  $html = file_get_html("http://scores.espn.go.com/mlb/boxscore?gameId=".$gameid."");

  echo "http://scores.espn.go.com/mlb/boxscore?gameId=".$gameid."<BR>";
	    
  
  foreach ($html->find('p[id="gameStatusBarText"]') as $p){
	   
	   //print_r($html);
	   echo $p->plaintext."<BR>";
	    
		if  (trim($p->plaintext) == 'Postponed' || trim($p->plaintext) =='Cancelled') {
		$_postponed = true;	
		}
		else{
		$_postponed = false;	
		}
		
   }  
    return $_postponed;	
}



function get_old_games_postponed($start,$end){
baseball_db();	
$sql="SELECT * FROM `game` WHERE pitcher_away =0  and startdate <=  '".$start." 00:00:00' and startdate >=  '".$end." 23:00:00' and postponed = 0";
	
//echo $sql;
return get($sql, "_baseball_game");	
}


?>
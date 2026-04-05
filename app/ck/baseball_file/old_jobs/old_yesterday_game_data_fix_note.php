<?
$page = $_SERVER['PHP_SELF'];
$sec = "15";
?><head>
    <meta http-equiv="refresh" content="<?php echo $sec?>;URL="<? echo $page  ?>"">
</head>

<? require_once(ROOT_PATH . "/ck/db/handler.php"); 
    require_once('../../../includes/html_dom_parser.php'); 
	   require_once(ROOT_PATH . '/ck/baseball_file/process/functions.php'); 
	ini_set('memory_limit', '-1');
    set_time_limit(0);
	


//***********************************
// Find the Game weather and Umpire and Scores
//**********************************


$file = fopen("./ck/baseball_file/old_jobs/date.txt", "r") or exit("Unable to open file!");
while(!feof($file))
{
$date =  ltrim(fgets($file));
}
fclose($file);


//$date='2013-03-13';

	
echo "---------------<BR>";
echo "Stadistics for Yesterday Game<BR>";
echo "---------------<BR><BR>";	

$date = date( "Y-m-d", strtotime( "-1 day", strtotime(date($date)))); 


echo "Fecha: ".$date."<BR>";

$games = get_basic_baseball_games_by_date($date);
$i=0;




foreach ($games as $game ){


  if (!$game->vars["postponed"]){ 

  // Check Games Note
  
   $note = check_games_note_test($game->vars["espn_game"]);
    if ($note != -1){
    $game->vars["game_note"]= $note;
    $game->update(array("game_note"));
   } else { echo "no note ".$game->vars["espn_game"]." <BR>"; }
  
 $i++;
 //break;
 
  }

}

function check_games_note_test($gameid){

  $html = file_get_html("http://scores.espn.go.com/mlb/boxscore?gameId=".$gameid."");

  foreach ($html->find('tr class="even"t" td') as $p){
	   
       
		if  ( contains_ck($p->plaintext,"RESUMED") || contains_ck($p->plaintext,"DELAY")) {
		$note = $p->plaintext;	
		echo "GAME NOTE ".$p->plaintext."<BR>";
		break;
		}
		else{
		$note = -1;	
		}
		
   }  
    return $note;	
}



$fp = fopen('./ck/baseball_file/old_jobs/date.txt', 'w');
		fwrite($fp, $date);
		fclose($fp);
		
	
	




?>
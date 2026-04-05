<p>&nbsp;</p>
<p>&nbsp;</p>
<? require_once(ROOT_PATH . "/ck/db/handler.php"); 
    require_once('../../../includes/html_dom_parser.php');  
	ini_set('memory_limit', '-1');
    set_time_limit(0);
	


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
	
		$year = date('Y',strtotime($game->vars["startdate"]));
		
	   
		  	$umpire_stadistics = get_umpire_basic_stadistics($game->vars["umpire"],$year);	
   		    echo $game->vars["id"]." - " .$game->vars["umpire"];
			print_r($umpire_stadistics);
			echo "<BR><BR>";
			 $game->vars["umpire_kbb"]= $umpire_stadistics->vars["k_bb"];
			 $game->vars["umpire_starts"]= ($umpire_stadistics->vars["hw"] + $umpire_stadistics->vars["rw"]);
   	         $game->update(array("real_umpire","umpire","umpire_kbb","umpire_starts")); 
 
 //break;

}
//} // end FOR

/*
$fp = fopen('./ck/baseball_file/old_jobs/fecha.txt', 'w');
		fwrite($fp, $date);
		fclose($fp);
		
*/		



function get_games_format(){
baseball_db();	

$sql="SELECT *
FROM `game`
WHERE umpire != 0
AND startdate > '2011-01-01 00:00:00'
AND startdate < '2011-12-14 00:00:00'
and postponed != 1
and umpire_starts = 0
limit 300;
";


return get($sql, "_baseball_game");	
}


?>
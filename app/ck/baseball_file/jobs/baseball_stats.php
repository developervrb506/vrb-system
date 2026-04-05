<? 
// JOB FOR GRAND SALMAMI A ND PK AVG


require_once(ROOT_PATH . "/ck/db/handler.php"); 
require_once(ROOT_PATH . '/includes/html_dom_parser.php'); 
require_once(ROOT_PATH . '/ck/baseball_file/process/functions.php');

set_time_limit(0);

echo "---------------<BR>";
echo "PK AVG AND GRAND SALAMI <br>";
echo "---------------<BR><BR>";
//$year = date("Y");	
if (isset($_GET["date"])){
  $date = $_GET["date"];
}
else{
$date = date( "Y-m-d", strtotime( "-1 day", strtotime(date( "Y-m-d")))); 
}
//$date = "2014-10-26";

echo "Date: ".$date."<BR>";
$games = get_basic_baseball_games_by_date($date);

$j =0;
$t_games = 0;
$t_pk = 0;
$t_runs = 0;
$ump_total = 0;
$complete = true;
//print_r($games);

foreach ($games as $game){
  
  $ump_value = 0;	
  if ($game->vars["pk"] == "-98"){
	  
    $complete = false;	  
  }
   if ($game->vars["pk"] != "-99"){
	
	 if ($game->vars["real_roof_open"]){   
      $t_games++;
	  $t_pk = $game->vars["pk"] + $t_pk;
	 }
  }
  
  $t_runs = $t_runs + $game->vars["runs_away"] + $game->vars["runs_home"];
  // umpire
   $umpire = get_baseball_umpires_data($game->vars["real_umpire"]);
   $ump_value = $umpire->vars["weighted_avg"];
   // If there is not data for UMP. the value used is 2.35 According to Mike.
		if ($umpire->vars["weighted_avg"] == 0 ){
		  $ump_value = 2.35;
		}
   $ump_total = $ump_total  + $ump_value ;
   
}




if ($complete){

$ump_avg = number_format($ump_total/count($games),2);
$grand_salami = json_decode(@file_get_contents("http://www.sportsbettingonline.ag/utilities/process/reports/print_mlb_grandSalami.php?date=".$date));	
$stat = get_baseball_stats($date);

if (is_null($stat)){
  $stat = new _baseball_stats();
  $stat->vars["date"] = $date;
  $stat->vars["pk_avg"] = number_format($t_pk/$t_games,2);
  $stat->vars["grand_salami_over"] = "o".$grand_salami->TotalOver.$grand_salami->OverOdds;
  $stat->vars["grand_salami_under"] = "u".$grand_salami->TotalUnder.$grand_salami->UnderOdds; 
  $stat->vars["total_runs"] = $t_runs; 
  $stat->vars["ump_weighted_avg"] = $ump_avg; 
  $stat->insert();
  
} else {
	
	  $stat->vars["total_runs"] = $t_runs;
	  $stat->vars["pk_avg"] = number_format($t_pk/$t_games,2);
	  $stat->vars["ump_weighted_avg"] = $ump_avg;
	  $stat->vars["grand_salami_over"] = "o".$grand_salami->TotalOver.$grand_salami->OverOdds;
      $stat->vars["grand_salami_under"] = "u".$grand_salami->TotalUnder.$grand_salami->UnderOdds;  
	  $stat->update(array("total_runs","pk_avg","ump_weighted_avg","grand_salami_over","grand_salami_under"));
	  echo "UPDATED";
}


}else { echo "NO YET"; }





?>
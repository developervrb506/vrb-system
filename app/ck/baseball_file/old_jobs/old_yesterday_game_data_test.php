<? require_once(ROOT_PATH . "/ck/db/handler.php"); 
    require_once('../../../includes/html_dom_parser.php');  
	ini_set('memory_limit', '-1');
    set_time_limit(0);
	


//***********************************
// Find the Game weather and Umpire and Scores
//**********************************



	
echo "---------------<BR>";
echo "Stadistics for Yesterday Game<BR>";
echo "---------------<BR><BR>";	

$date = date( "Y-m-d", strtotime( "-1 day", strtotime(date($date)))); 


echo "Fecha: ".$date."<BR>";

$games = get_games_format();
$i=0;



foreach ($games as $game ){


if (!$game->vars["postponed"]){ 

$year = date('Y',strtotime($game->vars["startdate"]));	

if ($game->vars["real_roof_open"] == -1 || $game->vars["umpire"]  == 0 || $game->vars["firstbase"]  == 0){ 
   
   $html = file_get_html("http://scores.espn.go.com/mlb/boxscore?gameId=".$game->vars["espn_game"]."");
   $next_line_roof = false;
   $next_line_umpire = false;
  

  foreach ( $html->find('td style="text-align:left; "') as $element ) {

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
	 $umpire = str_center("Home Plate - ",",",$element->plaintext);	
  	 $umpire = str_replace("  "," ",$umpire);
	 $umpire = str_replace("'"," ",$umpire);
	 echo " -> ".$umpire. " ";
   	 $id_umpire = get_game_umpire_by_name($umpire."");
	 
	  if ($id_umpire->vars["id"]){
	 		 $umpire_stadistics = get_umpire_basic_stadistics($id_umpire->vars["id"],$year);	
			 $game->vars["umpire_kbb"]= $umpire_stadistics->vars["k_bb"];
			 $game->vars["umpire_starts"]= ($umpire_stadistics->vars["hw"] + $umpire_stadistics->vars["rw"]);
   	         $game->update(array("umpire","umpire_kbb","umpire_starts")); 
			
		}
	 
	 
	 
	 print_r($id_umpire);
     echo"<BR>"; 
	 $firstbase = str_center("First Base - ",", Second Base",$element->plaintext);	
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
 
  
}


} // end FOR





function get_games_format(){
baseball_db();	

//$sql ="SELECT * FROM `game` WHERE runs_away = 0 and startdate > '2013-01-01 00:00:00' and startdate < '2013-07-14 00:00:00' AND postponed !=1 order by startdate ";

$sql="SELECT * FROM `game` WHERE (DATE(startdate) > '2013-01-01' && DATE(startdate) < '2013-08-05' ) and postponed = 0 and umpire = 0";	
//echo $sql;
return get($sql, "_baseball_game");	
}


?>
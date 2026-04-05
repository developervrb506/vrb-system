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

$games = get_old_games();
$i=0;




foreach ($games as $game ){


if (!$game->vars["postponed"]){ 


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
    echo ($i+1).") ".$game->vars["id"]." - ".$element->plaintext;
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
 

 $i++;
 
}


} // end FOR






function get_old_games(){
baseball_db();	
$sql="select * from game where (startdate > '2011-01-01 00:00:00' && startdate < '2011-12-01 00:00:00') and (umpire = 0 || firstbase =  0 )";
	
//echo $sql;
return get($sql, "_baseball_game");	
}


?>
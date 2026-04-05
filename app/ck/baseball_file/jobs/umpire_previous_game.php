<? require_once(ROOT_PATH . "/ck/db/handler.php"); 
require_once(ROOT_PATH . '/includes/html_dom_parser.php'); 
//require_once(ROOT_PATH . '/ck/baseball_file/process/functions.php'); 
	ini_set('memory_limit', '-1');
    set_time_limit(0);
	

echo "---------------<BR>";
echo "UMPIRE FOR GAME<br>";
echo "---------------<BR><BR>";
$umpire_date = date("Y_m_d");
$today= date('Y-m-d');
$year = date('Y');


$games = get_basic_baseball_games_by_date($today);

$i=0;
foreach ($games as $game){
 
if (!$game->started()) {
   
   $home_team = get_baseball_team($game->vars["team_home"]); 
   $away_team = get_baseball_team($game->vars["team_away"]); 
	
   $html2 = @file_get_html("http://mlb.mlb.com/mlb/gameday/index.jsp?gid=".$umpire_date."_".$away_team->vars["mlb_nick"]."_".$home_team->vars["mlb_nick"]."_".$game->vars["game_number"]."&mode=box");
	
    echo "http://mlb.mlb.com/mlb/gameday/index.jsp?gid=".$umpire_date."_".$away_team->vars["mlb_nick"]."_".$home_team->vars["mlb_nick"]."_".$game->vars["game_number"]."&mode=box";
	
     if(!empty($html2)) {
       foreach ( $html2->find('div [id=game-info-container]') as $element ) {
	      //echo  "assasa";
		   $umpire = str_center("HP: ",". 1B",$element->plaintext);	
           $umpire = str_replace("  "," ",$umpire);
   	       $umpire = str_replace("'"," ",$umpire);
		   $id_umpire = get_game_umpire_by_name($umpire); 
	  	   echo "<BR>".$umpire." ";
	       print_r($id_umpire);	          
		   $game->vars["umpire"] = $id_umpire->vars["id"]; 

		   
		    if ($id_umpire->vars["id"]){
			$umpire_stadistics = get_umpire_basic_stadistics($id_umpire->vars["id"],$year);	
			 $game->vars["umpire_kbb"]= $umpire_stadistics->vars["k_bb"];
			 $game->vars["umpire_starts"]= ($umpire_stadistics->vars["hw"] + $umpire_stadistics->vars["rw"]);
   	         $game->update(array("umpire","umpire_kbb","umpire_starts")); 
			
			}
			$subject = 'UMPIRE CHECKED';
			$content = "Umpire: ".$umpire." Game: ".$game->vars["id"];
			send_email_ck('aandrade@inspin.com', $subject, $content, true, $current_clerk->vars["fake_email"]);
	   
	  }
       echo"<BR>";   
     }  
   }

 $i++;	 
}

?>
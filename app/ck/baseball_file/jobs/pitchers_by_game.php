<? 
require_once(ROOT_PATH . "/ck/db/handler.php"); 
require_once(ROOT_PATH . '/includes/html_dom_parser.php'); 
require_once(ROOT_PATH . '/ck/baseball_file/process/functions.php');
  
set_time_limit(0);


date_default_timezone_set('America/New_York');  // Establece Central Time (CT)
// Find today games and Teams
echo "---------------<BR>";
echo "PITCHERS BY GAME<br>";
echo "---------------<BR><BR>";

$year= date("Y");
$old = false;
if (isset($_GET['old'])){ 
 $old = true;
}	


if (isset($_GET["gid"])){ 

$games = get_baseball_game($_GET["gid"],false);
}
else {
$date = date("Y-m-d");
if (isset($_GET['date'])){ 
 $date = $_GET['date'];
}	
$games = get_basic_baseball_games_by_date($date);	
}



//$games = array();//delete
$i=1;

echo count($games);
foreach ($games as $game ){

	$html ="";
  
   if($game->vars["espn_game"] != -1) {
   	    echo "http://www.espn.com/mlb/boxscore?gameId=".$game->vars['espn_game']."<BR>";
       // echo date("Y-m-d H:i",strtotime($game->vars["startdate"]))." < ".date("Y-m-d H:i")."--<BR>";  
        if (date("Y-m-d H:i",strtotime($game->vars["startdate"])) < date("Y-m-d H:i")) { 
           echo date("Y-m-d H:i",strtotime($game->vars["startdate"])). "< ".date("Y-m-d H:i")." LISTO ";
           $link = "http://www.espn.com/mlb/boxscore?gameId=";
    	   echo "GAME ALREADY STARTED";
           $url = 'https://www.espn.com/mlb/boxscore?gameId='.$game->vars["espn_game"];
	  	   $resultados = getPitchersFromBoxscore($url);
		   $pr = false;
		   echo "<BR>";
        } else{
	      echo date("Y-m-d H:i",strtotime($game->vars["startdate"])). " > ".date("Y-m-d H:i")."  ";
	      echo " PROBABLE ";
  	      $link = "http://www.espn.com/mlb/game?gameId=";
  	      $resultados = getProbablePitchers($game->vars["espn_game"]);
		  print_r($resultados);
  	 	  $pr = true;
	      echo "<BR>";
	   }
	
		  
	
	if(!empty($resultados)){
		
		 print_r($resultados); echo "<BR><BR>";
		 $pitcherid_away = $resultado['away'];
		  $pitcherid_home = $resultado['home'];

	   	 $a = get_baseball_player_espn_nick($pitcherid_away);
		 print_r($a);
		 if(!empty($a)){$pitcher_away  =  $a["espn_nick"];  $fansgraph_away = $a["fangraphs_player"];}
		 $h = get_baseball_player_espn_nick($pitcherid_home);
		 print_r($h);
		 if(!empty($h)){$pitcher_home  =  $h["espn_nick"];  $fansgraph_home = $h["fangraphs_player"]; }
	 }  

  } //espn >0
  break;
}
function getPitchersFromHtml($html) {
    $pitchers = [];

    libxml_use_internal_errors(true);
    $doc = new DOMDocument();
    $doc->loadHTML($html);
    $xpath = new DOMXPath($doc);

    // Buscar todos los bloques <section class="Boxscore__TableWrapper">
    $sections = $xpath->query('//section[contains(@class, "Boxscore__TableWrapper")]');

    foreach ($sections as $section) {
        // Buscar el <h2 class="Boxscore__Title"> con texto que contenga "Pitching"
        $titleNode = $xpath->query('.//h2[contains(@class, "Boxscore__Title")]', $section);
        if ($titleNode->length === 0) continue;

        $title = strtolower(trim($titleNode->item(0)->textContent));
        if (strpos($title, 'pitching') === false) continue;

        // Determinar si es 'away' o 'home' en orden
        $label = !isset($pitchers['away']) ? 'away' : 'home';

        // Buscar primer link con ID
        $aTags = $xpath->query('.//a[contains(@href, "/id/")]', $section);
        if ($aTags->length > 0) {
            $href = $aTags->item(0)->getAttribute('href');
            $name = trim($aTags->item(0)->textContent);

            if (preg_match('/\/id\/(\d+)/', $href, $matches)) {
                $pitchers[$label] = $matches[1];
                $pitchers["name_$label"] = $name;
            }
        }
    }

    return $pitchers;
}




function getProbablePitchers($id){



	 $link = "http://www.espn.com/mlb/game?gameId=";
			 $html = file_get_html($link.$id);  
        echo "BBBBBBBBBBBBBBBBBBBBBBBBBBBB23222OK OK";

		$j=0;
		if(!empty($html)){

			
		 foreach($html->find('div[class="Pitchers__Row"]') as $elementa) { 
		  
		  //echo $elementa->plaintext."<BR>";
		   foreach($elementa->find('a') as $element) { 
	  
	      //echo $element->plaintext;
				if (contains_ck($element->href,"/mlb/player/_/id/")){
					// echo "<BR>".$j.")".$element->href."  ".$element->plaintext."<BR>";	  
					   if ($j==0) {
						   $pitcher_away = "**";
						    $pitcherid_away =  str_center("id","/",$element->href."/");	 
						    $pitcherid_away = str_replace("/","", $pitcherid_away);
							//$pitcherid_away =  str_center("/","/".$pitcher_away,$pitcherid_away);
						//	echo "-AWAY-- ".$pitcherid_away;
					   
					   if($j==1){
						$pitcher_home = "**";		
						// $pitcherid_home =  str_center("id","/",$element->href);	 
						 //$pitcherid_home =  str_center("/","/".$pitcher_home,$pitcherid_home);	 

						   $pitcherid_home =  str_center("id","/",$element->href."/");	 
						    $pitcherid_home = str_replace("/","", $pitcherid_home);
						 $h = get_baseball_player_espn_nick($pitcherid_home);
							print_r($h);
						 if(!empty($h)){$pitcher_home  =  $h["espn_nick"];  $fansgraph_home = $h["fangraphs_player"]; }
					  }
						
					  $j++; 
				 }
		    }
		   }
			  
	       }  

}

}
		    
		
?>
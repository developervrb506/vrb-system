<? 
require_once(ROOT_PATH . "/ck/db/handler.php"); 
require_once(ROOT_PATH . '/includes/html_dom_parser.php'); 
require_once(ROOT_PATH . '/ck/baseball_file/process/functions.php');
ini_set('memory_limit', '128M');
set_time_limit(0);


echo "--------------------------<BR>";
echo "GROUNDBALL FOR PITCHERS<br>";
echo "-------------------------<BR><BR>";

$year = date("Y");	
$today = date("Y-m-d");
$type = $_GET["t"];

if (isset($_GET["gid"])){ 
 $games = get_baseball_game($_GET["gid"],false);
}
else {
 $games =  get_players_by_date_pending_update($today,$type,'gb_k9');
}

$ji =0;
if(count($games)>0){
	foreach ($games as $player){
	$ji++;
		//  echo "Pitcher ".$type." <BR><BR>";
			 $data = get_player_ground_ball_TEST2($player->vars["espn_player"],$player->vars["fangraphs_player"],$player->vars["position"],$player->vars["player"],$player->vars["game"]);
		//  print_r($player);
		  if(!empty($data)){
			  $player_update = new _player_updated();
			  $player_update->vars["player"]= $player->vars["fangraphs_player"];
			  $player_update->vars["type"]= 'gb_k9';
			  $player_update->vars["date"]= date("Y-m-d");
			// $player_update->insert();
		  }
	
	//break;	
	}
}else { echo "All Players were Updated"; }


function get_player_ground_ball_TEST($espn_player,$playerid,$position,$player_name,$gameid){
	
 //$link = "http://www.fangraphs.com/statss.aspx?playerid=".$playerid."&position=".$position."";
 $player_name = strtolower(str_replace(" ","-",$player_name));
 $link = "https://www.fangraphs.com/players/".$player_name."/".$playerid."/game-log?position=".$position;
   //$link = "http://www.oddessa.com/fansgraphs_bridge.php?link=".$link;
  
    //echo $link;
   // $data = file_get_contents($link);
    //echo $data;

$year = date("Y");	
    $link = "https://www.fangraphs.com/players/adam-wainwright/2233/stats?position=P";
    $link = "https://www.espn.com/mlb/player/stats/_/id/".$espn_player."/";
   echo $link."<BR>";
    $html = file_get_html($link);
   
     echo $player_name ." = ";
	  //foreach($html->find('div[id="dashboard-skinny"]') as $div) {     
	 
	  #ERA
	  foreach($html->find("div[class='PlayerHeader__Right']") as $main) {     

         $j=0;
		foreach($main->find("div[class='StatBlockInner']") as $div) {     

           if($j==1){
            
          //  echo $j." - ".$div->plaintext."<BR>";

            $txt = $div->plaintext[0].$div->plaintext[1].$div->plaintext[2];
            $era = $div->plaintext[3].$div->plaintext[4].$div->plaintext[5].$div->plaintext[6];
            echo $txt.": ". $era."<BR>";

           } 
            $j++;

	  	  }

		    				
	  }


     #G/F
       $control	= false;
       $year = date('Y');
       $last = $year-1;
       $lines_last = array();
       $lines_year = array();
	   foreach($html->find("div[class='PageLayout__Main']") as $main) {    

		foreach ($main->find("div") as $div) {

          if($control) { //echo $div->plaintext; echo "---<BR><BR><BR><BR>";
           
              /* foreach ($div->find("div[class='Table__Scroller']") as $expand) {
                  foreach($expand->find('table') as $table){
                  	foreach ($table->find('tr') as $tr) {
                  		echo $tr->plaintext."<BR>";
                  	}
                  }
            
                  */ 

               echo "ENTRA";
               // foreach ($div->find("div[class='flex']") as $expand) {   

               //  echo $expand->plaintext."<BR>";
                $i=1;
                foreach($div->find('table') as $table){
                	//echo $table->plaintext."<BR>";
                  	foreach ($table->find('tr') as $tr) {
                  		echo $tr->plaintext."<BR>";

                  		if($t==0){
                  			$str_season = substr($tr->plaintext, 0, 4); 
                          echo $str_season;	
                          if($str_season == $last || $str_season == $year){
                          	$lines[] = $i;
                          }
                  		}
                  	 $i++;	
                  	}
                   $t++;
                  } 
                  echo "--------<BR><BR><BR>";
                  print_r($lines);

               //}


              $control = false;
            
           }

         
          if($div->class == 'Table__Title' &&  $div->plaintext == "expanded-pitching")
          {
          	$control = true; 
          }	
        
         /* foreach ($div->find("div[class='Table__Title']") as $tittle) {
          	
          	echo $tittle->plaintext;
          	if ($tittle->plaintext == "expanded-pitching") { $control = true; }
          }*/
        //  if($control) { echo $div->plaintext; echo "---<BR><BR><BR><BR>";}
         } 

	   }







	  
	  
	  $statistics = get_player_basic_stadistics($playerid,$year,false,$gameid);	
	  if(is_null($statistics)){
	   $statistics = new _baseball_player_stadistics_by_game();  
	 $statistics->vars["fangraphs_player"] = $playerid;
		 $statistics->vars["season"] = $year;
		 $statistics->vars["game"] = $gameid;
		 $statistics->vars["era"] = $era;
         $statistics->insert();
     }		 
   //  $statistics->update(array("k9","k9_total","gb","gb_total")); 
   	 $html->clear(); 
	 
	 return $colums;

}

function get_player_ground_ball_TEST2($espn_player,$playerid,$position,$player_name,$gameid){
	
 //$link = "http://www.fangraphs.com/statss.aspx?playerid=".$playerid."&position=".$position."";
 $player_name = strtolower(str_replace(" ","-",$player_name));
 $link = "https://www.fangraphs.com/players/".$player_name."/".$playerid."/game-log?position=".$position;
   //$link = "http://www.oddessa.com/fansgraphs_bridge.php?link=".$link;
  
    //echo $link;
   // $data = file_get_contents($link);
    //echo $data;

$year = date("Y");	
    $link = "https://www.fangraphs.com/players/adam-wainwright/2233/stats?position=P";
    $link = "https://www.espn.com/mlb/player/stats/_/id/".$espn_player."/";
   echo $link."<BR>";
    $html = file_get_html($link);
   
     echo $player_name ." = ";
	  //foreach($html->find('div[id="dashboard-skinny"]') as $div) {     
	 
	  #ERA
	  foreach($html->find("div[class='PlayerHeader__Right']") as $main) {     

         $j=0;
		foreach($main->find("div[class='StatBlockInner']") as $div) {     

           if($j==1){
            
          //  echo $j." - ".$div->plaintext."<BR>";

            $txt = $div->plaintext[0].$div->plaintext[1].$div->plaintext[2];
            $era = $div->plaintext[3].$div->plaintext[4].$div->plaintext[5].$div->plaintext[6];
            echo $txt.": ". $era."<BR>";

           } 
            $j++;

	  	  }

		    				
	  }

	  $statistics = get_player_basic_stadistics($playerid,$year,false,$gameid);	
	  if(is_null($statistics)){
	   $statistics = new _baseball_player_stadistics_by_game();  
	 $statistics->vars["fangraphs_player"] = $playerid;
		 $statistics->vars["season"] = $year;
		 $statistics->vars["game"] = $gameid;
		 $statistics->vars["era"] = $era;
         $statistics->insert();
     }		 
   //  $statistics->update(array("k9","k9_total","gb","gb_total")); 
   	 $html->clear(); 
	 
	 return $colums;

}

?>
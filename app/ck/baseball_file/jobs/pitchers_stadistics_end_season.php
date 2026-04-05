<? 
// THIS FILE ONLY NEED TO RUN AT END OF THE GAME SEASON if this job failed by Allow size memory.
// only exclude the player
// this job is needed to save a game = 0 and season = 'endind season'
// the select is being controled and id > ??    // change the 2014 for  2015..Run on january 2016


require_once(ROOT_PATH . "/ck/db/handler.php"); 
require_once(ROOT_PATH . '/includes/html_dom_parser.php'); 
//require_once(ROOT_PATH . '/ck/baseball_file/process/functions.php');
  
	
	ini_set('memory_limit', '128M');
	set_time_limit(0);

// Find today games and Teams
echo "---------------<BR>";
echo "STADISTICS FOR PITCHERS<br>";
echo "---------------<BR><BR>";

$season= '2017';
//$today= date('2013-07-11');

$games = get_all_pitchers_test();


echo "<pre>";
//print_r($games);
echo "</pre>";

foreach ($games as $game){

	  echo "Player: ".$game["id"]."-- ".$game["fangraphs_player"];
	  get_player_statistics_test($game["fangraphs_player"],$game["position"],$game["player"],0);
	  echo "<BR>--<BR>";
	// break; 
 
} 

function get_all_pitchers_test(){
baseball_db();
$sql = "select * from player where fangraphs_player not IN (select fangraphs_player from player_stadistics_by_game where season = '2017' and game ='0') and type = 'pitcher' and id > 3521 order by id asc limit 300";
echo $sql;
return get_str($sql);	
	
}

function get_player_statistics_test($playerid,$position,$player_name,$gameid){
	 echo $player_name;
	
 if (($player_name != "Juan Castro") && ($player_name != "Willie Bloomquist") && ($player_name !="Jerry Hairston")&& ($player_name != "John McDonald")){
 
 $html = file_get_html_parts(250,3,"http://www.fangraphs.com/statss.aspx?playerid=".$playerid."&position=".$position."");
	  echo "http://www.fangraphs.com/statss.aspx?playerid=".$playerid."&position=".$position;
	  $year = 2017; // date("Y");
	  $espn = array();
	  $new_line = false;
	  $total = false;
	  $cont_lines =0;
	  $lines=0;
	  $cant_columns = 10; 
	  $td = 0; // to control Cant of td to be displayed 
	  $lines_after_last_total = 31; // Cant of lines that has the total for the before table.
	  $cant_totals = 6; // Cant of totals requiered before the requested table


	  $i=0;
	  
	  //table colums
	  $colums = array();
	  $colums["season"] = "";
	  $colums["fb"] = 0;
	  $colums["fb_total"] = 0;
	  $colums["sl"] = 0;
	  $colums["sl_total"] = 0;
	  $colums["ct"] = 0;
	  $colums["ct_total"] = 0;
	  $colums["cb"] = 0;
	  $colums["cb_total"] = 0;
	  $colums["ch"] = 0;
	  $colums["ch_total"] = 0;
	  $colums["sf"] = 0;
	  $colums["sf_total"] = 0;
	  $colums["kn"] = 0;
	  $colums["kn_total"] = 0;
	  $colums["xx"] = 0;
	  $colums["xx_total"] = 0;
	  
	  
	  ?>
	   <table width="25%" border="1" cellspacing="0" cellpadding="0">
		
		  <tr> 
		   <? echo $_team["team_name"];?>
		  </tr>
		  <tr>
		   <td class="table_header">Season</td>
		   <td class="table_header">Team</td>
		   <td class="table_header">FB%</td>
		   <td class="table_header">SL%</td>
		   <td class="table_header">CT%</td>
		   <td class="table_header">CB%</td>
		   <td class="table_header">CH%</td>
		   <td class="table_header">SF%</td>
		   <td class="table_header">KN%</td>
		   <td class="table_header">XX%</td>
		   </tr>
		  <tr> 
		   <? echo $player_name ?><BR>
		  </tr>  
		  <?
	
	  $x = substr($year,-1,2);
	  $season = $x + 11; // That is because 2013 start with season6 in the table class
	  
	  foreach($html->find("Table.SeasonStats1_dgSeason".$season."_ctl00] td") as $element) {     
         
		 
		
		 
		 if ($i == $cant_totals){
			  
			 if ($element->plaintext == $year){
				
			  ?><tr><?
			  $new_line = true;  
			  $lines = 0;
     	     }
			
 			if ($element->plaintext == $year +1 ){ break;};
			
			
			if ($new_line == true){ 
			  $lines++;
			 
			  if($lines == 1) {
			    ?><tr><?
			    ?>
			    <td style="font-size:12px;"><? echo str_replace("&nbsp;","",$element->plaintext)  ?></td>
			    <? 
 			    $colums["season"] = $year;
			  }
			  if($lines == 2) {
			    ?>
			    <td style="font-size:12px;"><? echo $element->plaintext ?></td>
			    <? 
	  		  }
			  
			  if($lines == 3) {
			    ?>
			    <td style="font-size:12px;"><? echo $element->plaintext ?></td>
			    <? 
	  		     if (!$total){
				  $colums["fb"] = $element->plaintext; 	 
				 }
				 else{
				  $colums["fb_total"] = $element->plaintext;	 
				 }
			  }
 			  if($lines == 4) {
    		    ?>
			    <td style="font-size:12px;"><? echo $element->plaintext ?></td>
			    <? 
	  		     if (!$total){
				  $colums["sl"] = $element->plaintext; 	 
				 }
				 else{
				  $colums["sl_total"] = $element->plaintext;	 
				 }
			  }
   			  if($lines == 5) {
			    ?>
			    <td style="font-size:12px;"><? echo $element->plaintext ?></td>
			    <? 
	  		     if (!$total){
				  $colums["ct"] = $element->plaintext; 	 
				 }
				 else{
				  $colums["ct_total"] = $element->plaintext;	 
				 }
			  }
			  if($lines == 6) {
			    ?>
			    <td style="font-size:12px;"><? echo $element->plaintext ?></td>
			    <? 
	  		     if (!$total){
				  $colums["cb"] = $element->plaintext; 	 
				 }
				 else{
				  $colums["cb_total"] = $element->plaintext;	 
				 }
			  }
			  if($lines == 7) {
			    ?>
			    <td style="font-size:12px;"><? echo $element->plaintext ?></td>
			    <? 
	  		     if (!$total){
				  $colums["ch"] = $element->plaintext; 	 
				 }
				 else{
				  $colums["ch_total"] = $element->plaintext;	 
				 }
			  }
			  if($lines == 8) {
			    ?>
			    <td style="font-size:12px;"><? echo $element->plaintext ?></td>
			    <? 
	  		     if (!$total){
				  $colums["sf"] = $element->plaintext; 	 
				 }
				 else{
				  $colums["sf_total"] = $element->plaintext;	 
				 }
			  }
  			  if($lines == 9) {
			    ?>
			    <td style="font-size:12px;"><? echo $element->plaintext ?></td>
			    <? 
	  		     if (!$total){
				  $colums["kn"] = $element->plaintext; 	 
				 }
				 else{
				  $colums["kn_total"] = $element->plaintext;	 
				 }
			  }
			  if($lines == 10) {
			    ?>
			    <td style="font-size:12px;"><? echo $element->plaintext ?></td>
			    <? 
	  		     if (!$total){
				  $colums["xx"] = $element->plaintext; 	 
				 }
				 else{
				  $colums["xx_total"] = $element->plaintext;	 
				 }
			  }
			  $td++;
			  
			}
			if ($lines == $cant_columns){
			 //$lines=0;
			 //$total= true;	  
			 ?></tr><?	  
			   /* if ($td == ($cant_columns*2)){
			    $i=-1;
			    }*/
			  
			}		 
			$cont_lines++;	 
		    }
		if ($element->plaintext == "Total" && $new_line == false){ $i++; }
		
	  }?></table><BR><BR><?
	
	 //if TD = 0 means that no info was found for this player	 
	 if ($td){
		
	   $statistics = get_player_basic_stadistics($playerid,$year,false,0);
		  
	  print_r($statistics); 
		  
	   if (is_null($statistics)){
		 
		 $statistics = new _baseball_player_stadistics_by_game();
		 $insert = true;
		 }
		 else{
		 $insert = false;		 
		 }
		 
		 $statistics->vars["season"] = str_replace("&nbsp;"," ",$colums["season"]);
		 $statistics->vars["game"] = $gameid;
		 $statistics->vars["fb"] = str_replace("&nbsp;"," ",$colums["fb"]);
		 $statistics->vars["fb_total"] = str_replace("&nbsp;"," ",$colums["fb_total"]);
		 $statistics->vars["sl"] = str_replace("&nbsp;"," ",$colums["sl"]);
		 $statistics->vars["sl_total"] = str_replace("&nbsp;"," ",$colums["sl_total"]);
		 $statistics->vars["ct"] = str_replace("&nbsp;"," ",$colums["ct"]);
		 $statistics->vars["ct_total"] = str_replace("&nbsp;"," ",$colums["ct_total"]); 
		 $statistics->vars["cb"] = str_replace("&nbsp;"," ",$colums["cb"]);
		 $statistics->vars["cb_total"] = str_replace("&nbsp;"," ",$colums["cb_total"]);
		 $statistics->vars["ch"] = str_replace("&nbsp;"," ",$colums["ch"]);
		 $statistics->vars["ch_total"] = str_replace("&nbsp;"," ",$colums["ch_total"]);	  
		 $statistics->vars["sf"] = str_replace("&nbsp;"," ",$colums["sf"]);
		 $statistics->vars["sf_total"] = str_replace("&nbsp;"," ",$colums["sf_total"]);	  
		 $statistics->vars["kn"] = str_replace("&nbsp;"," ",$colums["kn"]);
		 $statistics->vars["kn_total"] = str_replace("&nbsp;"," ",$colums["kn_total"]);	  
		 $statistics->vars["xx"] = str_replace("&nbsp;"," ",$colums["xx"]);
		 $statistics->vars["xx_total"] = str_replace("&nbsp;"," ",$colums["xx_total"]);
		 
		 if ($insert){
		 	
			$statistics->vars["fangraphs_player"] = $playerid;
			$statistics->insert();	 
		 }
		 else{
	
		 	$statistics->update(array("season","fb","fb_total","sl","sl_total","ct","ct_total","cb","cb_total","ch","ch_total","sf","sf_total","kn","kn_total","xx","xx_total")); 
		 }
	 }

   	 $html->clear(); 
 }

}




function get_player_statistics_test_old($playerid,$position,$player_name,$gameid){
	 echo $player_name;
	
 if (($player_name != "Juan Castro") && ($player_name != "Willie Bloomquist") && ($player_name !="Jerry Hairston")&& ($player_name != "John McDonald")){
 
 $html = file_get_html_parts(250,3,"http://www.fangraphs.com/statss.aspx?playerid=".$playerid."&position=".$position."");
	  echo "http://www.fangraphs.com/statss.aspx?playerid=".$playerid."&position=".$position;
	  $year = 2015; // date("Y");
	  $espn = array();
	  $new_line = false;
	  $total = false;
	  $cont_lines =0;
	  $lines=0;
	  $cant_columns = 10; 
	  $td = 0; // to control Cant of td to be displayed 
	  $lines_after_last_total = 31; // Cant of lines that has the total for the before table.
	  $cant_totals = 6; // Cant of totals requiered before the requested table
	  $post_season_line=14 ;// new pitchers does not have postseason
	  $lines_before_Postseason =15; 
	  $i=0;
	  
	  //table colums
	  $colums = array();
	  $colums["season"] = "";
	  $colums["fb"] = 0;
	  $colums["fb_total"] = 0;
	  $colums["sl"] = 0;
	  $colums["sl_total"] = 0;
	  $colums["ct"] = 0;
	  $colums["ct_total"] = 0;
	  $colums["cb"] = 0;
	  $colums["cb_total"] = 0;
	  $colums["ch"] = 0;
	  $colums["ch_total"] = 0;
	  $colums["sf"] = 0;
	  $colums["sf_total"] = 0;
	  $colums["kn"] = 0;
	  $colums["kn_total"] = 0;
	  $colums["xx"] = 0;
	  $colums["xx_total"] = 0;
	  
	  
	  ?>
	   <table width="25%" border="1" cellspacing="0" cellpadding="0">
		
		  <tr> 
		   <? echo $_team["team_name"];?>
		  </tr>
		  <tr>
		   <td class="table_header">Season</td>
		   <td class="table_header">Team</td>
		   <td class="table_header">FB%</td>
		   <td class="table_header">SL%</td>
		   <td class="table_header">CT%</td>
		   <td class="table_header">CB%</td>
		   <td class="table_header">CH%</td>
		   <td class="table_header">SF%</td>
		   <td class="table_header">KN%</td>
		   <td class="table_header">XX%</td>
		   </tr>
		  <tr> 
		   <? echo $player_name ?><BR>
		  </tr>  
		  <?
	
	  $x = substr($year,-1,2);
	  $season = $x + 11; // That is because 2013 start with season6 in the table class
	  
	  foreach($html->find("Table.SeasonStats1_dgSeason".$season."_ctl00] td") as $element) {     
         
		 
		
		 
		 if ($i == $cant_totals){
			  
			 if ($element->plaintext == $year){
				
			  ?><tr><?
			  $new_line = true;  
			  $lines = 0;
     	    }
			if($cont_lines == $post_season_line){
			  if ($element->plaintext != "Postseason"){
				$lines_after_last_total= $lines_before_Postseason; 
			  
			  }
			}
			
			
			 echo $element->plaintext." ** ".$year." ** ".$lines." ** ".$cant_columns."<BR>";
			 if ($element->plaintext == $year && $lines == $cant_columns){
			  $td = ($td/2);
			  $total = false;
			  $new_line = false;
			  
			 }
			
			 if ($total==true && $lines == $cant_columns){
				$i=-1; // Exit the cicle 
			    $new_line =false;
			 }
			
			 if ($lines == $cant_columns){
				$lines = 0; 
			 }
			 
			 
			 if (str_replace('&nbsp;','',$element->plaintext) == 'Total'){
				$new_line = true; 
				$lines = 0; 
				$total = true;
			 }
			
			
			if ($cont_lines >= $lines_after_last_total && $new_line == true){ 
			  $lines++;
			 
			  if($lines == 1) {
			    ?><tr><?
			    ?>
			    <td style="font-size:12px;"><? echo str_replace("&nbsp;","",$element->plaintext)  ?></td>
			    <? 
 			    $colums["season"] = $year;
			  }
			  if($lines == 2) {
			    ?>
			    <td style="font-size:12px;"><? echo $element->plaintext ?></td>
			    <? 
	  		  }
			  
			  if($lines == 3) {
			    ?>
			    <td style="font-size:12px;"><? echo $element->plaintext ?></td>
			    <? 
	  		     if (!$total){
				  $colums["fb"] = $element->plaintext; 	 
				 }
				 else{
				  $colums["fb_total"] = $element->plaintext;	 
				 }
			  }
 			  if($lines == 4) {
    		    ?>
			    <td style="font-size:12px;"><? echo $element->plaintext ?></td>
			    <? 
	  		     if (!$total){
				  $colums["sl"] = $element->plaintext; 	 
				 }
				 else{
				  $colums["sl_total"] = $element->plaintext;	 
				 }
			  }
   			  if($lines == 5) {
			    ?>
			    <td style="font-size:12px;"><? echo $element->plaintext ?></td>
			    <? 
	  		     if (!$total){
				  $colums["ct"] = $element->plaintext; 	 
				 }
				 else{
				  $colums["ct_total"] = $element->plaintext;	 
				 }
			  }
			  if($lines == 6) {
			    ?>
			    <td style="font-size:12px;"><? echo $element->plaintext ?></td>
			    <? 
	  		     if (!$total){
				  $colums["cb"] = $element->plaintext; 	 
				 }
				 else{
				  $colums["cb_total"] = $element->plaintext;	 
				 }
			  }
			  if($lines == 7) {
			    ?>
			    <td style="font-size:12px;"><? echo $element->plaintext ?></td>
			    <? 
	  		     if (!$total){
				  $colums["ch"] = $element->plaintext; 	 
				 }
				 else{
				  $colums["ch_total"] = $element->plaintext;	 
				 }
			  }
			  if($lines == 8) {
			    ?>
			    <td style="font-size:12px;"><? echo $element->plaintext ?></td>
			    <? 
	  		     if (!$total){
				  $colums["sf"] = $element->plaintext; 	 
				 }
				 else{
				  $colums["sf_total"] = $element->plaintext;	 
				 }
			  }
  			  if($lines == 9) {
			    ?>
			    <td style="font-size:12px;"><? echo $element->plaintext ?></td>
			    <? 
	  		     if (!$total){
				  $colums["kn"] = $element->plaintext; 	 
				 }
				 else{
				  $colums["kn_total"] = $element->plaintext;	 
				 }
			  }
			  if($lines == 10) {
			    ?>
			    <td style="font-size:12px;"><? echo $element->plaintext ?></td>
			    <? 
	  		     if (!$total){
				  $colums["xx"] = $element->plaintext; 	 
				 }
				 else{
				  $colums["xx_total"] = $element->plaintext;	 
				 }
			  }
			  $td++;
			  
			}
			if ($lines == $cant_columns){
			 //$lines=0;
			 //$total= true;	  
			 ?></tr><?	  
			   /* if ($td == ($cant_columns*2)){
			    $i=-1;
			    }*/
			  
			}		 
			$cont_lines++;	 
		    }
		if ($element->plaintext == "Total" && $new_line == false){ $i++; }
		
	  }?></table><BR><BR><?
	
	 //if TD = 0 means that no info was found for this player	 
	 if ($td){
		
	   $statistics = get_player_basic_stadistics($playerid,$year,false,0);
		  
	  print_r($statistics); 
		  
	   if (is_null($statistics)){
		 
		 $statistics = new _baseball_player_stadistics_by_game();
		 $insert = true;
		 }
		 else{
		 $insert = false;		 
		 }
		 
		 $statistics->vars["season"] = str_replace("&nbsp;"," ",$colums["season"]);
		 $statistics->vars["game"] = $gameid;
		 $statistics->vars["fb"] = str_replace("&nbsp;"," ",$colums["fb"]);
		 $statistics->vars["fb_total"] = str_replace("&nbsp;"," ",$colums["fb_total"]);
		 $statistics->vars["sl"] = str_replace("&nbsp;"," ",$colums["sl"]);
		 $statistics->vars["sl_total"] = str_replace("&nbsp;"," ",$colums["sl_total"]);
		 $statistics->vars["ct"] = str_replace("&nbsp;"," ",$colums["ct"]);
		 $statistics->vars["ct_total"] = str_replace("&nbsp;"," ",$colums["ct_total"]); 
		 $statistics->vars["cb"] = str_replace("&nbsp;"," ",$colums["cb"]);
		 $statistics->vars["cb_total"] = str_replace("&nbsp;"," ",$colums["cb_total"]);
		 $statistics->vars["ch"] = str_replace("&nbsp;"," ",$colums["ch"]);
		 $statistics->vars["ch_total"] = str_replace("&nbsp;"," ",$colums["ch_total"]);	  
		 $statistics->vars["sf"] = str_replace("&nbsp;"," ",$colums["sf"]);
		 $statistics->vars["sf_total"] = str_replace("&nbsp;"," ",$colums["sf_total"]);	  
		 $statistics->vars["kn"] = str_replace("&nbsp;"," ",$colums["kn"]);
		 $statistics->vars["kn_total"] = str_replace("&nbsp;"," ",$colums["kn_total"]);	  
		 $statistics->vars["xx"] = str_replace("&nbsp;"," ",$colums["xx"]);
		 $statistics->vars["xx_total"] = str_replace("&nbsp;"," ",$colums["xx_total"]);
		 
		 if ($insert){
		 	
			$statistics->vars["fangraphs_player"] = $playerid;
			//$statistics->insert();	 
		 }
		 else{
	
		 	//$statistics->update(array("season","fb","fb_total","sl","sl_total","ct","ct_total","cb","cb_total","ch","ch_total","sf","sf_total","kn","kn_total","xx","xx_total")); 
		 }
	 }

   	 $html->clear(); 
 }

}



?>
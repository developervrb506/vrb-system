<? 
require_once(ROOT_PATH . "/ck/db/handler.php"); 
require_once('../../../includes/html_dom_parser.php'); 
  
	
	ini_set('memory_limit', '128M');
	set_time_limit(0);





// Find today games and Teams
echo "---------------<BR>";
echo "STADISTICS FOR PITCHERS<br>";
echo "------------<BR><BR>";



$games = get_games_format();

foreach ($games as $game){

      $year = date('Y',strtotime($game->vars["startdate"]));	
 
	  echo "Pitcher AWAY <BR>";
	  $player_a = get_baseball_player_by_id("fangraphs_player",$game->vars["pitcher_away"]);
	  echo "http://www.fangraphs.com/statss.aspx?playerid=".$player_a->vars["fangraphs_player"]."&position=".$player_a->vars["position"]." -->".$player_a->vars["player"]."<BR>";
	  get_player_statistics($player_a->vars["fangraphs_player"],$player_a->vars["position"],$player_a->vars["player"],$game->vars["id"],$year);
	  echo "Pitcher HOME<BR>";
	  $player_h = get_baseball_player_by_id("fangraphs_player",$game->vars["pitcher_home"]);
  	  echo "http://www.fangraphs.com/statss.aspx?playerid=".$player_h->vars["fangraphs_player"]."&position=".$player_h->vars["position"]." -->".$player_h->vars["player"]."<BR>";

	  get_player_statistics($player_h->vars["fangraphs_player"],$player_h->vars["position"],$player_h->vars["player"],$game->vars["id"],$year);
	  echo "<BR>--<BR>";
	// break; 
} 

function get_player_statistics($playerid,$position,$player_name,$gameid,$year){
	
 $html = file_get_html_parts(250,3,"http://www.fangraphs.com/statss.aspx?playerid=".$playerid."&position=".$position."");
	  
	  //$year = date("Y");
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
	
	  $x = substr($year,0,2);
	  $season = $x + 3; // That is because 2013 start with season6 in the table class
	  
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
			
			
			
			 if (str_replace('&nbsp;','',$element->plaintext) == $year && $lines == $cant_columns){
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
	  		     if ($total== false && $colums["fb"]==0){
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
	  		      if ($total== false && $colums["sl"]==0){
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
	  		      if ($total== false && $colums["ct"]==0){
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
	  		      if ($total== false && $colums["cb"]==0){
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
	  		      if ($total== false && $colums["ch"]==0){
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
	  		      if ($total== false && $colums["sf"]==0){
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
	  		      if ($total== false && $colums["kn"]==0){
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
	  		      if ($total== false && $colums["xx"]==0){
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
		
	   $statistics = get_player_basic_stadistics($playerid,$year,false,$gameid);
		  
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

$date = date( "Y-m-d", strtotime( "-1 day", strtotime(date($date)))); 


$fp = fopen('./ck/baseball_file/old_jobs/fecha.txt', 'w');
		fwrite($fp, $date);
		fclose($fp);


function get_games_format(){
baseball_db();	

//$sql ="SELECT * FROM `game` WHERE runs_away = 0 and startdate > '2013-01-01 00:00:00' and startdate < '2013-07-14 00:00:00' AND postponed !=1 order by startdate ";

$sql="SELECT *
FROM `game`
WHERE id in ('357021','357287','355171','355614','368313')
";	
//echo $sql;
return get($sql, "_baseball_game");	
}

?>
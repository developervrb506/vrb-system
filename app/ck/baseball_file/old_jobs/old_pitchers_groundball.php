<? 
require_once(ROOT_PATH . "/ck/db/handler.php"); 
require_once('../../../includes/html_dom_parser.php'); 
	ini_set('memory_limit', '128M');
	set_time_limit(0);

if (!isset($_GET["date"])){
	$file = fopen("./ck/baseball_file/old_jobs/old_espn_date.txt", "r") or exit("Unable to open file!");
	while(!feof($file))
	{
	$date =  ltrim(fgets($file));
	}
	fclose($file);
}

$date = date("Y-m-d");
if (isset($_GET["date"])){
  $date = $_GET["date"];
}



// Find today games and Teams
echo "--------------------------<BR>";
echo "GROUNDBALL FOR PITCHERS<br>";
echo "----------".$date."-------------<BR><BR>";

//$today = date("Y-m-d");
//$today= date('2013-07-14');

if ($date > '2011-02-15') {


$games = get_basic_baseball_games_by_date($date);

foreach ($games as $game){

     $year = date('Y',strtotime($game->vars["startdate"]));
 
 
	  echo "Pitcher AWAY <BR>";
	  if ($game->vars["pitcher_away"]){
		$player_a = get_baseball_player_by_id("fangraphs_player",$game->vars["pitcher_away"]);
		get_player_ground_ball($player_a->vars["fangraphs_player"],$player_a->vars["position"],$player_a->vars["player"],$game->vars["id"],$year);
	  }
	  
	  echo "Pitcher HOME<BR>";
	  if ($game->vars["pitcher_home"]){
		$player_h = get_baseball_player_by_id("fangraphs_player",$game->vars["pitcher_home"]);
		get_player_ground_ball($player_h->vars["fangraphs_player"],$player_h->vars["position"],$player_h->vars["player"],$game->vars["id"],$year);
	  }
	  echo "<BR<BR>";
} 


$date = date( "Y-m-d", strtotime( "-1 day", strtotime(date($date)))); 

	if (!isset($_GET["date"])){
	 $fp = fopen('./ck/baseball_file/old_jobs/old_espn_date.txt', 'w');
			fwrite($fp, $date);
			fclose($fp);
	}


}





function get_player_ground_ball($playerid,$position,$player_name,$gameid,$year){
	
 $html = file_get_html_parts(0,2,"http://www.fangraphs.com/statss.aspx?playerid=".$playerid."&position=".$position."");
 
 echo "http://www.fangraphs.com/statss.aspx?playerid=".$playerid."&position=".$position."";
	  
	  //$year = date("Y");
	  $new_line = false;
	  $total = false;
	  $lines=0;
	  $cant_columns = 19; 
	  $td = 0; // to control Cant of td to be displayed 

	  
	  //table colums
	  $colums = array();
	  $colums["season"] = "";
	  $colums["gb"] = 0;
	  $colums["gb_total"] = 0;
	  
	  
	  ?>
	   <table width="25%" border="1" cellspacing="0" cellpadding="0">
		
		  <tr> 
		   <? echo $_team["team_name"];?>
		  </tr>
		  <tr>
		   <td class="table_header">Season</td>
		   <td class="table_header">Team</td>
		   <td class="table_header">GB%</td>
		   </tr>
		  <tr> 
		   <? echo $player_name ?><BR>
		  </tr>  
		  <?
	
	  
	  $x = substr($year,0,2);
	  $season = $x + 8; // That is because 2013 start with season11 in the table class
	 	  
	  foreach($html->find("Table.SeasonStats1_dgSeason".$season."_ctl00] td") as $element) {     

			 if ($element->plaintext == $year){
			  ?><tr><?
			  $new_line = true;  
			  $lines = 0;
 			 }
			
			if ($new_line){ 
			  $lines++;
			 
			  if($lines == 1) {
			    ?><tr>
			      <td style="font-size:12px;"><? echo $element->plaintext ?></td>
			    <? 
			  }
			  if($lines == 2) {
			    ?>
			    <td style="font-size:12px;"><? echo $element->plaintext ?></td>
			    <? 
	  		  }
			  
			  if($lines == 14) {
			    			   
			    $colums["gb_total"] = $element->plaintext;  
				
				?>
			    <td style="font-size:12px;"><? echo $element->plaintext ?></td>
			    <? 
	  		     
				if($total) {
				  
				  if ($td==1){
					  ?></tr><?	
					  $colums["gb_total"] = $lines."".$element->plaintext;  
					  break;
					 echo "Si es total ".$element->plaintext. "<BR>" ;
				  }
				}
				else {
					
				  if ($td==1){
				   ?></tr><?
				   break;
				   }
					 

				    if ($element->plaintext!="&nbsp;" && $colums["gb"] == 0){
				     $colums["gb"] = 	$element->plaintext;  
				    }
					
				}
		   	  }
		  
			 }			
			if ($lines == $cant_columns){
			 $lines=0;
			 ?></tr><?	  
			}
			
			if ($element->plaintext == 'Total'){
             $total=true;
			 $td++;
			}
			else{
		      $total= false;	  		 
            }
			 

		    				
	  }?></table><BR><BR><?
	  
	  $colums["season"] = 	$year;
	  
	  echo "<pre>";
      print_r($colums);	  
 	  echo "</pre>";
	  
	
	
	 $statistics = get_player_basic_stadistics($playerid,$year,false,$gameid);
   	
	 if (!is_null($statistics))	{
	  $statistics->vars["gb"] = str_replace("&nbsp;"," ",$colums["gb"]);
 	  $statistics->vars["gb_total"] = str_replace("&nbsp;"," ",$colums["gb_total"]);
      $statistics->update(array("gb","gb_total")); 
	 }


   	 $html->clear(); 

}




?>
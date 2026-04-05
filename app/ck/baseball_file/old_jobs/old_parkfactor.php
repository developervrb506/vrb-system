<? 
require_once(ROOT_PATH . "/ck/db/handler.php"); 
require_once('../../../includes/html_dom_parser.php'); 
	ini_set('memory_limit', '128M');
	set_time_limit(0);

// Find today games and Teams
echo "--------------------------<BR>";
echo "Park Factor              <br>";
echo "-------------------------<BR><BR>";


$file = fopen("date_games_start2.txt", "r") or exit("Unable to open file!");
//Output a line of the file until the end is reached

while(!feof($file))
{
$start =  ltrim(fgets($file));
}
fclose($file);


$file = fopen("date_games_end2.txt", "r") or exit("Unable to open file!");
//Output a line of the file until the end is reached
while(!feof($file))
{
$end =  ltrim(fgets($file));
}
fclose($file);



echo "Dates ".$start." -- ".$end."<BR>";
//$today = date("Y-m-d");
$year = date("Y");
//$start = '2013-07-22';
//$end = '2013-07-12';

$games = get_old_baseball_games_by_date($start,$end);

foreach ($games as $game){
	
	
  $year = date('Y',strtotime($game->vars["startdate"]));	
  $stadium = get_baseball_stadium_by_team($game->vars["team_home"]);
  get_parkfactor($stadium->vars['id'],$game->vars['id'],$year);

}

$start = date ('Y-m-d',strtotime ( '-1 day' , strtotime (trim($start)))) ;	
		$fp = fopen('date_games_start2.txt', 'w');
		fwrite($fp, $start);
		fclose($fp);
		
$end = date ('Y-m-d',strtotime ( '-1 day' , strtotime (trim($end)))) ;	
		$fp = fopen('date_games_end2.txt', 'w');
		fwrite($fp, $end);
		fclose($fp);		
		




function get_parkfactor($stadiumid,$gameid,$year){
	
 $html = file_get_html("http://espn.go.com/mlb/stats/parkfactor/_/year/2011");
 $print_line = false;
 $data = array();
	  
	  ?>
	   <table width="25%" border="1" cellspacing="0" cellpadding="0">
		
		 
		  <tr>
		   <td class="table_header">Park Name</td>
		   <td class="table_header">Runs</td>
		   <td class="table_header">HR</td>
		   <td class="table_header">H</td>
		   <td class="table_header">2b</td>        
   		   <td class="table_header">3b</td>
		   <td class="table_header">BB</td>
		   </tr>
		  <?
	
	  
	 	  
	  foreach($html->find("table tr") as $element) {     

 		  
		    foreach ($element->find("td") as $td){
	           
			   if ($print_line){
			   $line++;   
			   //echo $td->plaintext."   ----  ".$td->a."<BR>";    
			   }
			   
			   if (contains_ck($td->plaintext,"BB")){
			   $print_line = true;
			   $line=-1;
			   }
			   
			   if ( $line == 1 && $print_line == true){
				   
				    $park = strstr($td->plaintext," (",true);
					$data['stadium'] = $park;
			    ?><tr>
			        <td style="font-size:12px;"><? echo $park ?></td>
			    <? 
		 	   }
			   if ( $line == 2 && $print_line == true){
				    $data['runs'] = $td->plaintext;				  
				?>
			        <td style="font-size:12px;"><? echo $td->plaintext ?></td>
			    <? 
		 	   }
   			   if ( $line == 3 && $print_line == true){
				    $data['hr'] = $td->plaintext;
				?>
			        <td style="font-size:12px;"><? echo $td->plaintext ?></td>
			    <? 
		 	   }
   			   if ( $line == 4 && $print_line == true){
				    $data['h'] = $td->plaintext; 
				?>
			        <td style="font-size:12px;"><? echo $td->plaintext ?></td>
			    <? 
		 	   }
   			   if ( $line == 5 && $print_line == true){
				   $data['2b'] = $td->plaintext;
				?>
			        <td style="font-size:12px;"><? echo $td->plaintext ?></td>
			    <? 
		 	   }
   			   if ( $line == 6 && $print_line == true){
				   $data['3b'] = $td->plaintext;
				?>
			        <td style="font-size:12px;"><? echo $td->plaintext ?></td>
			    <? 
		 	   }
   			   if ( $line == 7 && $print_line == true){
				   $data['bb'] = $td->plaintext;
				?>
			        <td style="font-size:12px;"><? echo $td->plaintext ?></td>
			        </tr>
                <? 
				 $stadium_data = get_baseball_stadium_by_name($data['stadium']);
				 
   				 $line=-1; 
				 if ($stadium_data->vars['id'] == $stadiumid){

			     
				 	$stadium_stadistics =  get_baseball_stadium_stadistics($stadiumid,$gameid);
				 
				   if (is_null($stadium_stadistics)){
					   $stadium_stadistics = new _baseball_stadium_stadistics_by_game();
					   $stadium_stadistics->vars["stadium"] = $stadium_data->vars["id"];
					   $stadium_stadistics->vars["game"] = $gameid;
					   $stadium_stadistics->vars["runs"] = $data["runs"];
					   $stadium_stadistics->vars["homeruns"] = $data["hr"];
					   $stadium_stadistics->vars["hits"] = $data["h"];				 
					   $stadium_stadistics->vars["doubles"] = $data["2b"];				 
					   $stadium_stadistics->vars["triples"] = $data["3b"];				 
					   $stadium_stadistics->vars["walks"] = $data["bb"];
					   $stadium_stadistics->vars["season"] = $year;
					   $stadium_stadistics->insert();
					   echo "inserted";					 				 
				   }
				 }
		        
			   }
 
			  	
    	 }
		 
      

  }?></table><BR><BR><?
	  
	
	

   	 $html->clear(); 
	 
}


function get_old_baseball_games_by_date($start,$end){
	baseball_db();
	$sql = "SELECT * FROM game where (DATE(startdate) <=  '".$start." 00:00:00' && DATE(startdate) >=  '".$end." 00:00:00') AND DATE(startdate) > '2011-01-01 00:00:00'  ORDER BY startdate ASC";
	return get($sql, "_baseball_game");
}

//}
?>
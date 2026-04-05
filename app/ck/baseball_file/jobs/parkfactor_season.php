<? 
require_once(ROOT_PATH . "/ck/db/handler.php"); 
require_once(ROOT_PATH . '/includes/html_dom_parser.php'); 
require_once(ROOT_PATH . '/ck/baseball_file/process/functions.php');

	ini_set('memory_limit', '128M');
	set_time_limit(0);

$season = "2016";
// Find today games and Teams
echo "--------------------------<BR>";
echo "Park Factor   SEASON  ".$season."       <br>";
echo "-------------------------<BR><BR>";


  $data = get_parkfactor_season($season);
  
  if(!is_null($data)){
     foreach ($data as $d){
		 
				 	$park_factor_season =  get_baseball_stadium_parkfactor_season($d["id"],$season);
				    $new = false;
				 
				   if (is_null($park_factor_season)){
					   $park_factor_season = new _baseball_stadium_parkfactor_season();
					   $new = true;
				   }
					   $park_factor_season->vars["stadium"] = $d["id"];
					   $park_factor_season->vars["runs"] = $d["runs"];
					   $park_factor_season->vars["homeruns"] = $d["hr"];
					   $park_factor_season->vars["hits"] = $d["h"];				 
					   $park_factor_season->vars["2b"] = $d["2b"];				 
					   $park_factor_season->vars["3b"] = $d["3b"];				 
					   $park_factor_season->vars["bb"] = $d["bb"];
					   $park_factor_season->vars["season"] = $season;
					   if($new){
					    $park_factor_season->insert();
					   echo "inserted.<BR>";					 				 
					   } else {
						   $park_factor_season->update(); 
						   echo "Updated<BR>";
						   }
				   }

   
		 

	  
  }



function get_parkfactor_season($season){
	
 $html = file_get_html("http://espn.go.com/mlb/stats/parkfactor/_/year/".$season);
 $print_line = false;
 $data = array();
	  
	  ?>
	   <table width="25%" border="1" cellspacing="0" cellpadding="0"> 
		  <tr>
		   <td class="table_header">ID</td>          
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
				   
				    $park = myStrstrTrue($td->plaintext," (",true);
					$stadium_data = get_baseball_stadium_by_name($park);
					$id = $stadium_data->vars['id'];
					$data[$id]['stadium'] = $park;
					$data[$id]['id'] = $id
			    ?><tr>
			        <td style="font-size:12px;"><? echo $id ?></td>
                    <td style="font-size:12px;"><? echo $park ?></td>
			    <? 
		 	   }
			   if ( $line == 2 && $print_line == true){
				    $data[$id]['runs'] = $td->plaintext;				  
				?>
			        <td style="font-size:12px;"><? echo $td->plaintext ?></td>
			    <? 
		 	   }
   			   if ( $line == 3 && $print_line == true){
				    $data[$id]['hr'] = $td->plaintext;
				?>
			        <td style="font-size:12px;"><? echo $td->plaintext ?></td>
			    <? 
		 	   }
   			   if ( $line == 4 && $print_line == true){
				    $data[$id]['h'] = $td->plaintext; 
				?>
			        <td style="font-size:12px;"><? echo $td->plaintext ?></td>
			    <? 
		 	   }
   			   if ( $line == 5 && $print_line == true){
				   $data[$id]['2b'] = $td->plaintext;
				?>
			        <td style="font-size:12px;"><? echo $td->plaintext ?></td>
			    <? 
		 	   }
   			   if ( $line == 6 && $print_line == true){
				   $data[$id]['3b'] = $td->plaintext;
				?>
			        <td style="font-size:12px;"><? echo $td->plaintext ?></td>
			    <? 
		 	   }
   			   if ( $line == 7 && $print_line == true){
				   $data[$id]['bb'] = $td->plaintext;
				?>
			        <td style="font-size:12px;"><? echo $td->plaintext ?></td>
			        </tr>
                <? 
				// $stadium_data = get_baseball_stadium_by_name($data['stadium']);
				 
				
   				 $line=-1; 
				
		        
			   }
			  	
    	 }
	
  }?></table><BR><BR><?
	  

   	 $html->clear(); 
	 
echo "<pre>";
//print_r($data);
echo "</pre>";
 return $data;
}




?>
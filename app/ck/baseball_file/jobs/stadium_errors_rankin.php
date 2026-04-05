<?
require_once(ROOT_PATH . "/ck/db/handler.php"); 
    require_once(ROOT_PATH . '/includes/html_dom_parser.php');  
	require_once(ROOT_PATH . '/ck/baseball_file/process/functions.php');

set_time_limit(0);  
echo "-------------------------<BR>";
echo "    Errors and BUllPENN Ranking BY STADIUM  <br>";
echo "--------------------------<BR>";
 
$stadiums = get_all_baseball_stadiums();


  $bp = array();
   
  $html = file_get_html('http://www.espn.com/mlb/stats/team/_/stat/pitching/split/128');	
 $i = 0;
 if(!empty($html))	{
  foreach ( $html->find('table[class="tablehead"]') as $element ) {
	  
// foreach ( $html2->find('span') as $element ) {	 
    
	 foreach ( $element->find('tr') as $tr ) {
		  if($i>1 && $i<32){  //30 teams
			$j=0;
			 foreach ( $tr->find('td') as $td ) {  
			   
			   if($j==0){
				   $rk_pos = $td->plaintext;
				} 
			   if($j==1){
				   foreach ($td->find('a') as $a){
						    $link = $a->href;	 
							$team =  str_center('_/name/','/',$link); 
							$team = substr($team,0,strpos($team, "/"));   
					     
				   }
				     $bp[$team] = $rk_pos;		
				   
				   
				} 
				$j++;

				
			 
			 }
		
		  }
         	 $i++;
	 }


   }
   
}


 
    echo "<pre>";
    print_r($bp);
    echo "</pre>";

  
 $rk = array();
 $html2 = file_get_html('http://www.espn.com/mlb/stats/team/_/stat/fielding/order/true');	
  $i = 0;
 if(!empty($html2))	{
  foreach ( $html2->find('table[class="tablehead"]') as $element ) {
	  
// foreach ( $html2->find('span') as $element ) {	 
    
	 foreach ( $element->find('tr') as $tr ) {
		  if($i>1 && $i<32){  //30 teams
			$j=0;
			 foreach ( $tr->find('td') as $td ) {  
			   
			   if($j==0){
				   $rk_pos = $td->plaintext;
				} 
			   if($j==1){
				   foreach ($td->find('a') as $a){
						    $link = $a->href;	 
							$team =  str_center('_/name/','/',$link); 
							$team = substr($team,0,strpos($team, "/"));   
					     
				   }
				     $rk[$team] = $rk_pos;		
				   
				   
				} 
				$j++;

				
			 
			 }
		
		  }
         	 $i++;
	 }


   }
   
}


 
    echo "<pre>";
    print_r($rk);
    echo "</pre>";
	
	
	
	foreach($stadiums as $st){
		
	    	$st->vars["error_rank"] = $rk[$st->vars["espn_id_name"]];
			$st->vars["bullpen_rank"] = $bp[$st->vars["espn_id_name"]];
			$st->update(array("error_rank","bullpen_rank"));
		
	}
	
	 echo "<pre>";
    print_r($stadiums);
    echo "</pre>";
	
?>
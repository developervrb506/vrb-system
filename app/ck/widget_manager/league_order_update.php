<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<?php
  
// $_POST["ids"] = "23,13,12,24,5,7,6,8,9,10,11,3,4,16,17,18,19,20,21,22,15,2,1,14";
//$_POST["ids"] = "1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24";
  $leagues = get_all_event_leagues();
  
  $array	= explode(",",$_POST['ids']);
 
	  $i =0;
	  foreach ($leagues as $ls){
		 $leagues[trim($array[$i])]->vars["position"] = $i+1; 
		 $leagues[trim($array[$i])]->update(array("position")); 
		  
		 
		 $i++; 
		}
  

?>

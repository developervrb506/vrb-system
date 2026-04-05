<? 
include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if(!$current_clerk->im_allow("all_schedules")) {
   	include(ROOT_PATH . "/ck/process/admin_security.php");
   } ?>
<?
 //echo "<pre>"; 
 $all = false; 
 if ($_POST["clerk"]== ""){
  $all = true;	
 }

 $monday = get_monday($_POST["from"]);

if ($all) {
  $clerk_list = get_all_clerks(1);
  foreach ($clerk_list as $_clerk_list) {
	 get_last_salary_schedule_clerk($monday,$_clerk_list->vars["id"]); 
  }
}else {
 
 $clerk = $_POST["clerk"];
 get_last_salary_schedule_clerk($monday,$clerk); 
}



function get_last_salary_schedule_clerk($monday,$clerk){ 

	 $schedule_date = $monday; 
	 $clerks_salary = get_clerk_last_week_salary($clerk);
	
	 //echo  $schedule_date;
	 //print_r($clerks_salary);
	 foreach ($clerks_salary as $clerk_salary){
		 
	  //get how many weeks needs to be inserted.
	   $week = array();
	   $week_date = $schedule_date;
	   while($week_date > $clerk_salary->vars["week"])
	  {
		//echo $week_date." > ".$clerk_salary->vars["week"]."<BR>";
		$week[]=$week_date;
		$week_date =	 date( "Y-m-d", strtotime( "-7 day", strtotime($week_date)));   
	  } 
	  
	  // print_r($week);
	  if (!empty($week)) {
	  
		  foreach($week as $_week){
			
			//echo $clerk_salary->vars["salary"]."--<BR>";
			$new_salary = new _salary();
			$new_salary->vars["clerk"] = $clerk_salary->vars["clerk"];
			$new_salary->vars["week"] = $_week;
			$new_salary->vars["salary"] = $clerk_salary->vars["salary"];
			$new_salary->vars["type"] = $clerk_salary->vars["type"];
			$new_salary->vars["caja"] = $clerk_salary->vars["caja"];	  
			$new_salary->vars["deductions"]	= $clerk_salary->vars["deductions"];
			$new_salary->vars["increases"]	= $clerk_salary->vars["increases"];
			$new_salary->vars["notes"] = $clerk_salary->vars["notes"];
			$new_salary->insert();
			
		  }
	  }
	
	}

}
//echo "</pre>";
header("Location: ../../schedules.php?e=90&from=".$schedule_date."&clerk=$clerk");

?>

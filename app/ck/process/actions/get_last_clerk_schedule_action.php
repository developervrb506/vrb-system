<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if(!$current_clerk->is_manager()) {
   	include(ROOT_PATH . "/ck/process/admin_security.php");
   } ?>
<?
 $_clerk = $_POST["clerk"];
 $manager_id = $current_clerk->vars["id"];
 $schedule_date = get_monday($_POST["from"]);
 
 if($current_clerk->im_allow("all_schedules")){
	 $groups = get_all_user_groups(1);
 }else{
	 $groups = get_all_groups_by_manager($current_clerk->vars["id"]); 
 }
 
  
 /* echo "<pre>";
  print_r($_POST);
  print_r($groups);
  echo "<pre>";*/
  
   $all = false; 
 if ($_POST["clerk"]== ""){
  $all = true;	
 }
 
 
 if (!$all){
	
	$clerk_schedule = get_clerk_last_schedule($_clerk);
	
		$clerk_schedule = get_clerk_last_schedule($_clerk);
	     
		
		
 
	   if (count($clerk_schedule)>0){
			  
		 $last_week = $clerk_schedule[0]->vars["week_date"]; 
			   
		   foreach ($clerk_schedule as $_clerk_schedule){	 
			   
			 $week = array();
			 $week_date = $schedule_date;
			   
			 while($week_date > $last_week)
			 {
				  $week[]=$week_date;
				   $week_date = date( "Y-m-d", strtotime( "-7 day", strtotime($week_date)));   
			 } 
			 
			 if ($_clerk_schedule->vars["user"] == $manager_id){
				$manager_last_week =  $last_week;
				$manager_week = $week;
			 }
			 
			   
			if (!empty($week)) {
				   
			   foreach($week as $_week){
				
				  $new_schedule = new clerk_schedule();
				  $new_schedule->vars["user"] = $_clerk_schedule->vars["user"];
				  $new_schedule->vars["day"] = $_clerk_schedule->vars["day"];
				  $new_schedule->vars["open_hour"] = $_clerk_schedule->vars["open_hour"];
				  $new_schedule->vars["close_hour"] = $_clerk_schedule->vars["close_hour"];
				  $new_schedule->vars["week_date"] = $_week;
				  $new_schedule->insert();
					
				} 
			}
				
			} 
	   
		  }
 
 
 
 }
 
 else{ ///if all
 

 foreach ($groups as $group) {
 
	$clerks = get_all_clerks_by_group($group->vars["id"],$_clerk);
	
			
	if (!is_null($clerks)){  
	  
	  foreach($clerks as $clerk){
		
		$clerk_schedule = get_clerk_last_schedule($clerk->vars["id"]);
	     
		
		
 
	   if (count($clerk_schedule)>0){
			  
		 $last_week = $clerk_schedule[0]->vars["week_date"]; 
			   
		   foreach ($clerk_schedule as $_clerk_schedule){	 
			   
			 $week = array();
			 $week_date = $schedule_date;
			   
			 while($week_date > $last_week)
			 {
				  $week[]=$week_date;
				   $week_date = date( "Y-m-d", strtotime( "-7 day", strtotime($week_date)));   
			 } 
			 
			 if ($_clerk_schedule->vars["user"] == $manager_id){
				$manager_last_week =  $last_week;
				$manager_week = $week;
			 }
			 
			if (!empty($week)) {
				   
			   foreach($week as $_week){
				
				  $new_schedule = new clerk_schedule();
				  $new_schedule->vars["user"] = $_clerk_schedule->vars["user"];
				  $new_schedule->vars["day"] = $_clerk_schedule->vars["day"];
				  $new_schedule->vars["open_hour"] = $_clerk_schedule->vars["open_hour"];
				  $new_schedule->vars["close_hour"] = $_clerk_schedule->vars["close_hour"];
				  $new_schedule->vars["week_date"] = $_week;
				  $new_schedule->insert();
				 
					
				} 
			}
				
			} 
	   
		  }
		  
	  } 
   } // clerks if is null
	  
 } // Clerks Group 

 } //all

// Backup_user_day
 if (!empty($manager_week)) {
		  	 
	 $next_date = get_monday($manager_last_week, "Y-m-d", true);
	 $backup_dates = get_clerk_last_backup_day($current_clerk->vars["user_group"]->vars["id"],$manager_last_week,$next_date);
		
  foreach($manager_week as $_week){
	 
	  foreach ($backup_dates as $_backup_date){
	    
		$day_diff = get_day_diff($_backup_date->vars["date"],$manager_last_week); 
		
		$new_backup_day = new user_backup_day();
		$new_backup_day->vars["group_id"] = $_backup_date->vars["group_id"];
		$new_backup_day->vars["user_backup"] = $_backup_date->vars["user_backup"];
		$new_backup_day->vars["date"] = date("Y-m-d", strtotime("+ ".$day_diff." days", strtotime($_week)));
		$new_backup_day->insert();
		
	  }
        
   }
}	

header("Location: ../../schedules.php?e=90&from=".$schedule_date."");



?>

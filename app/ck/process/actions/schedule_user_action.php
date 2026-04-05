<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if(!$current_clerk->im_allow("users") && !$current_clerk->im_allow("all_schedules") && !$current_clerk->is_manager()) {
   	include(ROOT_PATH . "/ck/process/admin_security.php");
   } ?>
<?

$user = get_clerk($_POST["update_id"]);
$days = get_all_week_days();
$j = 0;
$vacations = get_all_clerk_vacations($_POST["update_id"],$_POST["week_date"], date( "Y-m-d", strtotime( "6 day", strtotime($_POST["week_date"]))));



foreach ($days as $day ){
 $control = false;
 $date = date( "Y-m-d", strtotime( $j." day", strtotime($_POST["week_date"])));

 	 if ($_POST[$day."_active"] == '2'){
		 $user_vacation = new _user_vacation();
		 $user_vacation ->vars["user"] = $_POST["update_id"]; 
		 $user_vacation ->vars["vdate"] = $date;
		 $user_vacation ->insert(); 
		 $_POST[$day."_active"] = '0'; 	  
	     $control = true;
	   }
      
	  if ($_POST[$day."_active"] != "2" && (!$control)) {
      if (isset($vacations[$user->vars["id"]."_".$date])){
	   $vacation_delete = get_clerk_vacation($_POST["update_id"],$date);
       //if (count($vacation_delete)>0) {$vacation_delete->delete(); }
	   if (!empty($vacation_delete)) {$vacation_delete->delete(); }
  }	
   
  
 }
 
 $schedule = get_clerk_schedule($_POST["update_id"], $day,$_POST["week_date"]);
 $new = false; 
 $no_action = false;
 
 
  if (!is_null($_POST[$day."_replace"]) && ($_POST[$day."_active"])){
    $date = date( "Y-m-d", strtotime( $j." day", strtotime($_POST["week_date"])));
	
	 $delete_backup =  get_backup_user($user->vars["user_group"]->vars["id"],$date);
	 //if (count($delete_backup)>0){  $delete_backup->delete(); }
	 if (!empty($delete_backup)){  $delete_backup->delete(); }
	 
  }
 
  if (($_POST[$day."_replace"] != "") && (!$_POST[$day."_active"])){
   
    $date = date( "Y-m-d", strtotime( $j." day", strtotime($_POST["week_date"])));
	$backup_user = get_backup_user($user->vars["user_group"]->vars["id"],$date);
	//if (count($backup_user)>0){
	if (!empty($backup_user)){	
	   $backup_user->vars["user_backup"] = $_POST[$day."_replace"];
	   $backup_user->update(array("user_backup")); 	
	}
	else{
	  $backup_user = new user_backup_day;
	  $backup_user->vars["group_id"] = $user->vars["user_group"]->vars["id"];
	  $backup_user->vars["user_backup"] = $_POST[$day."_replace"];
	  $backup_user->vars["date"] = $date;
	  $backup_user->insert();	
	}
	  
  }
  
  
  if (is_null($schedule) && ($_POST[$day."_active"])){
   $schedule = new clerk_schedule(); 
   $new=true;   
  }
  else if (is_null($schedule) && (!$_POST[$day."_active"])){
     $no_action=true; 
  }

  if (!is_null($schedule) && (!$_POST[$day."_active"]))
  {
    $schedule_delete = get_clerk_schedule($_POST["update_id"],$day,$_POST["week_date"]);

	//if (count($schedule_delete)>0) { $schedule_delete->delete(); }
	if (!empty($schedule_delete)) { $schedule_delete->delete(); }
		
  }
  
   
  if (!empty($schedule)) {
     
	  $schedule->vars["user"] = $_POST["update_id"]; 
	  $schedule->vars["day"]=$day;
	  $schedule->vars["week_date"]=$_POST["week_date"];
	  $time_open = $_POST[$day."_otime1"].":".$_POST[$day."_otime2"]." ".$_POST[$day."time_o"]."";
	  $time_close = $_POST[$day."_ctime1"].":".$_POST[$day."_ctime2"]." ".$_POST[$day."time_c"]."";
	  $schedule->vars["open_hour"] = date("H:i:s", strtotime($time_open));
	  $schedule->vars["close_hour"]= date("H:i:s", strtotime($time_close));
	  
	  if (!$no_action) {
		  
	   if($new){
		 $schedule->insert();
	   }else{
		 $schedule->update(array("user","day","open_hour","close_hour","week_date"));	  
	   }
	   
	  }
	  
  }

$j++; 
  
}
header("Location: ../../schedule_user.php?uid=".$_POST["update_id"]."&e=86&realdate=".$_POST["week_date"]."");
?>

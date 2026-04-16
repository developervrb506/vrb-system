<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if(!$current_clerk->im_allow("users") && !$current_clerk->im_allow("all_schedules") && !$current_clerk->is_manager()) {
   	include(ROOT_PATH . "/ck/process/admin_security.php");
   } ?>

<?

if (isset($_POST["from"])){
   $from = $_POST["from"];
   $real_date =  get_monday($from);
}
else { 
   $from =  get_monday(date("Y-m-d"));
   $real_date = $from;
}

if (isset($_GET["realdate"])){
   $from = $_GET["realdate"];
   $real_date =  get_monday($from);
}



if(isset($_GET["uid"])){
	$update = true;
	$user = get_clerk($_GET["uid"]);
	$title = $user->vars["name"]."'s Shedule";
	
	if($user->admin()){
	    if($current_clerk->vars["id"] != $user->vars["id"] && !$current_clerk->vars["super_admin"]){
			header("Location: clerks.php?e=5");
		}
	}
}else{
	$update = false;
	$title = "Create New User";
}
$this_monday = get_monday(date("Y-m-d"));
$days = get_all_week_days();
$hours = get_all_hours();
$minutes = get_all_minutes();
$manager =  get_clerk_manager_group($user->vars["id"]);
$is_manager = false;
//if (count($manager)>0) { $is_manager = true;}
if (!empty($manager)) { $is_manager = true;}

$vacations = get_all_clerk_vacations($user->vars["id"],$real_date, date( "Y-m-d", strtotime( "6 day", strtotime($real_date))));


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" media="all" href="../includes/calendar/jsDatePick_ltr.min.css" />
<link href="../css/style.css" rel="stylesheet" type="text/css" />
<title>Schedule User</title>
<script type="text/javascript" src="../process/js/functions.js?v=2"></script>
<script type="text/javascript">

function change_active(day,active){

  if (active){
	 document.getElementById(day+"_start").style.display = "table-row";
 	 document.getElementById(day+"_end").style.display = "table-row";
	 
	 
	<? if ($is_manager ) { ?>
	 
	 if (document.getElementById(day+"_charge").style.display == "table-row"){
	   document.getElementById(day+"_charge").style.display = "none";
	 }
	 <? } ?>
	 
  }	
  if (active==0 || active==2)
  {
   document.getElementById(day+"_start").style.display = "none";
   document.getElementById(day+"_end").style.display = "none";

   	<? if ($is_manager ) { ?>
	 
	 if (document.getElementById(day+"_charge").style.display == "none"){
	   document.getElementById(day+"_charge").style.display = "table-row";
	 }
	 <? } ?>




   }
	
}

</script>
<script type="text/javascript" src="../includes/calendar/jsDatePick.min.1.3.js"></script>
<script type="text/javascript">
	window.onload = function(){
		new JsDatePick({
			useMode:2,
			target:"from",
			dateFormat:"%Y-%m-%d"
		});
		new JsDatePick({
			useMode:2,
			target:"to",
			dateFormat:"%Y-%m-%d"
		});
	};
</script>
</head>
<body>
<? include "../includes/header.php" ?>
<? include "../includes/menu_ck.php" ?>
<div class="page_content" style="padding-left:50px;">
<span class="page_title"><? echo $title ?></span><br /><br />

<? include "includes/print_error.php" ?>
 <form method="post">
   <strong>Week: </strong>
    <input name="from" type="text" id="from" value="<? echo $real_date ?>" />
    &nbsp;&nbsp;&nbsp;&nbsp;
    <input type="submit" value="Search" />
    &nbsp;&nbsp;&nbsp;&nbsp;
 </form>  
    <br /><br />


<div class="form_box" style="width:650px;">
   <form method="post" action="process/actions/schedule_user_action.php" onsubmit="return validate(validations)">
   <input name="week_date" type="hidden" id="week_date" value="<? echo $real_date ?>" />
    <? if($update) { ?><input name="update_id" type="hidden" id="update_id" value="<? echo $user->vars["id"] ?>" /><? } ?>
	<table width="100%" border="0" cellspacing="0" cellpadding="10">
    
	<? $j=0;
	       // To allow edit old weeks comment the line below  
	   	   $disabled = 'disabled="disabled"';
	   
	   
	
	foreach($days as $day){ ?>
       <? $schedule = get_clerk_schedule($_GET["uid"], $day,$real_date);
	      $active= false;
		  //if (count($schedule)>0){ $active = true; }
		  if (!empty($schedule)){ $active = true; }
	      $date_day = date( "Y-m-d", strtotime( $j." day", strtotime($real_date)));
	      $ddate = date( "Y-m-d", strtotime( $j." day", strtotime($real_date)));
	    ?>
       <tr>
          <td ><strong style="font-size:14px;"><? echo date( "D  d, M", strtotime( $j." day", strtotime($real_date))); ?></strong>
          <select <? if ($date_day < $this_monday){ echo $disabled; }  ?>  name="<? echo $day ?>_active"   onChange="change_active('<? echo $day?>',this.value)">
              <option value="1" <? if($active) {echo 'selected="selected"'; }?> >On</option>
              <option value="0" <? if(!$active) {echo 'selected="selected"'; }?> >Off</option>
              <option value="2" <? if(!$active && (isset($vacations[$user->vars["id"]."_".$ddate]))) {echo 'selected="selected"'; }?> >Vacation</option>
             </select> </td>
       </tr>
       <tr id="<? echo $day ?>_start" <? if (!$active){ echo 'style="display:none"';} ?> >
          <td><strong>Start</strong> Time</td>
          <td colspan="2">
            <? 
			 $time_open = date("g:i:A", strtotime($schedule->vars["open_hour"]));
			 $oparts = explode(":",$time_open); 
       	 ?>
             
            <select <? if ($date_day < $this_monday){ echo $disabled; }  ?>  name="<? echo $day ?>_otime1">
            <? foreach ($hours as $hour){ ?>
            <option <? if ($hour== $oparts[0]){ echo "selected"; } ?>  value="<? echo $hour?>" ><? echo $hour ?> </option>
            <? } ?>
            </select> : 
            <select <? if ($date_day < $this_monday){ echo $disabled; }  ?> name="<? echo $day ?>_otime2">
            <? foreach ($minutes as $minute){ ?>
            <option <? if ($minute== $oparts[1]){ echo "selected"; } ?> value="<? echo $minute?>" ><? echo $minute ?> </option>
            <? }  ?>
            </select>
           <select <? if ($date_day < $this_monday){ echo $disabled; }  ?> name="<? echo $day ?>time_o" id="<? echo $day ?>time_o">
            <option <? if ($oparts[2] == "AM"){ echo "selected"; } ?> value="AM" >AM</option>
            <option <? if ($oparts[2] == "PM" ){ echo "selected"; } ?> value="PM" >PM</option> 
            </select>
            
            
            &nbsp;&nbsp;&nbsp;<strong>Example</strong>: 09 : 30 AM
          </td>
       </tr>
       <tr id="<? echo $day ?>_end" <? if (!$active){ echo 'style="display:none"';} ?> >
          <td><strong>End</strong> Time</td>
          <td colspan="2">
            <?
			 $time_close = date("g:i:A", strtotime($schedule->vars["close_hour"]));
			 $cparts = explode(":",$time_close); ?>
                      
            <select <? if ($date_day < $this_monday){ echo $disabled; }  ?> name="<? echo $day ?>_ctime1" id="<? echo $day ?>_ctime1" >
            <? foreach ($hours as $hour){ ?>
            <option <? if ($hour== $cparts[0]){ echo "selected"; } ?> value="<? echo $hour?>"  ><? echo $hour ?> </option>
            <? } ?>
            </select> : 
            <select <? if ($date_day < $this_monday){ echo $disabled; }  ?> name="<? echo $day ?>_ctime2" id="<? echo $day ?>_ctime2" >
            <? foreach ($minutes as $minute){ ?>
            <option <? if ($minute== $cparts[1]){ echo "selected"; } ?> value="<? echo $minute?>" ><? echo $minute ?> </option>
            <? } ?>
            </select>
             <select <? if ($date_day < $this_monday){ echo $disabled; }  ?> name="<? echo $day ?>time_c" id="<? echo $day ?>time_c">
            <option <? if ($cparts[2] == "AM"){ echo "selected"; } ?> value="AM" >AM</option>
            <option <? if ($cparts[2] == "PM" ){ echo "selected"; } ?> value="PM" >PM</option> 
            </select>
            
            
            
            
            
            &nbsp;&nbsp;&nbsp;<strong>Example</strong>: 06 : 30 PM
          </td>
       </tr>
        <? 
        if ($is_manager)  {
		
	     $clerks_group = get_all_clerks_by_group_shedule($user->vars["user_group"]->vars["id"],$user->vars["id"]);
		
		 $date = date( "Y-m-d", strtotime( $j." day", strtotime($real_date)));
	     $backup_user = get_backup_user($user->vars["user_group"]->vars["id"],$date);
		 $selected_backup = "";
		 //if (count($backup_user)>0) {
	     if (!empty($backup_user) && is_array($backup_user)) {		 
		  $selected_backup = $backup_user->vars["user_backup"];	 
		 }
		?>	
       	<? }  ?>
		 <tr id="<? echo $day ?>_charge" <? if (($is_manager) && (!$active)){ echo 'style="display:table-row"'; }   else { echo 'style="display:none"';} ?>   >
          <td><strong>Person on Charge</strong> </td>
          <td colspan="2">
          <? if($clerks_group == ""){$clerks_group = array();} ?>
           	<? create_objects_list($day."_replace", $day."_user", $clerks_group, "id", "name", $default_name = "Select",$selected_backup,"java script aca","clerk");  ?>
          </td>
       </tr>
        
       <tr> 
          <td colspan="3"><br /></td>
       </tr>
       
    <? $j++; } ?> 
    <tr>
        <td><input type="image" src="../images/temp/submit.jpg" /></td>
        <td>&nbsp;</td>
      </tr> 
      
    </table>
	</form>
</div>


</div>
<? include "../includes/footer.php" ?>

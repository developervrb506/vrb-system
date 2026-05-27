<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->im_allow("all_schedules") || $current_clerk->is_manager()){ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/style.css" rel="stylesheet" type="text/css" />
<title>Schedules</title>
<link rel="stylesheet" href="<?= BASE_URL ?>/includes/shadowbox/shadowbox.css" type="text/css" media="screen" />
<script type="text/javascript" src="<?= BASE_URL ?>/includes/shadowbox/shadowbox.js"></script>
<script type="text/javascript" src="<?= BASE_URL ?>/process/js/functions.js?v=2"> </script>
<script type="text/javascript">
Shadowbox.init();
</script>
<link rel="stylesheet" type="text/css" media="all" href="../includes/calendar/jsDatePick_ltr.min.css" />
<script type="text/javascript" src="../includes/calendar/jsDatePick.min.1.3.js"></script>
<script type="text/javascript">
	window.onload = function(){
		new JsDatePick({
			useMode:2,
			target:"from",
			dateFormat:"%Y-%m-%d"
		});
	};
</script>
<script type="text/javascript">

function disable_btn()
{
  document.getElementById("btn_last").disabled = true;	
	
}

</script>
</head>
<body>
<? 


if (isset($_POST["from"])){
   $from = $_POST["from"];
   $real_date =  get_monday($from);
   
}
else  { 
  
  if (isset($_GET["realdate"])){
    $from = $_GET["realdate"];
    $real_date =  get_monday($from);
  }
  else { 
    $from =  get_monday(date("Y-m-d"));
    $real_date = $from;
  }
}
$disabled = false;
if (isset($_GET["from"]) && (!isset($_POST["from"])) ){
	$real_date = $_GET["from"];
	$_clerk = $_GET["from"];
	$disabled = true;
}



$allow = true;
$this_monday = get_monday(date("Y-m-d"));
//To allow edit older weeks comment the 3 lines below
if ($real_date <  $this_monday) { 
$allow = false;
}

$sunday = date("Y-m-d",strtotime($real_date." + 6 days"));
$super_total = 0;
$replacements = get_manager_replacements($real_date, $sunday);

$dates["mon"] = $real_date;
$dates["tue"] = date("Y-m-d",strtotime($real_date." + 1 day"));
$dates["wed"] = date("Y-m-d",strtotime($real_date." + 2 day"));
$dates["thu"] = date("Y-m-d",strtotime($real_date." + 3 day"));
$dates["fri"] = date("Y-m-d",strtotime($real_date." + 4 day"));
$dates["sat"] = date("Y-m-d",strtotime($real_date." + 5 day"));
$dates["sun"] = $sunday;


$login_vrb = get_clerk_logged_vrb_date($dates["mon"],$dates["sun"]);
$login_phone = get_agent_loged_at_phone_date($dates["mon"],$dates["sun"]);



if($current_clerk->im_allow("all_schedules")){
	$groups = get_all_user_groups(/*$_POST["saff"],$_POST["sname"],*/ 1);
	$page_style = " width:100%;";
	$lates = sum_all_lates_hours($real_date, $sunday, "ap");
     
    $charlist = "\n\r\0\x0B";
    $report_line = "";
    //$columns = "Clerk \t Mon \t Tue \t Wed \t Thu \t Fri \t Sat \t Sun \t Sch_Hours \t Hours \t Paid_Missing Time \t Total Hours \t Sal \t Caja \t Deductions \t Increases \t Notes \t Total Amount \n";
	$columns = "Clerk \t Mon \t Tue \t Wed \t Thu \t Fri \t Sat \t Sun \t Sch_Hours \t Hours \t Paid_Missing Time \t Total Hours \t Sal \t Deductions \t Increases \t Notes \t Total Amount \n";


}else{
	$groups = get_all_groups_by_manager($current_clerk->vars["id"], 1);
}

$vacations = get_all_clerk_vacations($user->vars["id"],$real_date, date( "Y-m-d", strtotime( "6 day", strtotime($real_date))),true);


?>
<? include "../includes/header.php" ?>
<? include "../includes/menu_ck.php" ?>
<div class="page_content" style="padding-left:20px;">

<? include "includes/print_error.php" ?>

<form method="post">
 <strong>Week: </strong>
  <input name="from" type="text" id="from" value="<? echo $real_date ?>" readonly="readonly" />
  &nbsp;&nbsp;&nbsp;&nbsp;
  <input type="submit" value="Search" />
  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
  <a href="late_report.php" class="normal_link">Late Report</a><Br/>
 
</form> 

  <? // Duplicate the Last Salary information  ?>
  <? if (($allow) &&  ($current_clerk->im_allow("all_schedules"))){ 
   $clerk_list = get_all_clerks(1);
  ?>
  <BR/>
  <table> 
  <tr> 
   <td style="width:370px;">
  <a style="display:block" id="a_link" href="javascript:display_div('div_last_salary')" class="normal_link" title="Click to open form" >Load Last Salary</a>
   </td>
  <td style="width:350px;"> 
      <a style="display:block" id="a_link" href="javascript:display_div('div_last_schedule')" class="normal_link" title="Click to open form" >Load Last Schedule</a>

  </td>
  <tr>
   <td>
   <div  id="div_last_salary"  class="form_box" style="width:350px; display:none">
   <form method="post" action="process/actions/get_last_clerk_account_info_action.php">
     <input name="from" type="hidden" id="from" value="<? echo $real_date ?>" readonly="readonly" onchange="disable_btn()" />

   <table border="0">

   <tr>
    <td>Clerk: </td>
    <td>
     <?
	create_objects_list("clerk", "clerk", $clerk_list, "id", "name", "All", $_clerk);  ?>
   	&nbsp;&nbsp;
    </td>
    <td>
    
   <input id="btn_last" <? if ($disabled) { echo 'disabled="disabled"'; }?> type="submit" value="Load Last Salary" />
   </td>

 </tr>
 </table>
   </form>
  </div>
  </td>
  <td>  
  <div  id="div_last_schedule"  class="form_box" style="width:350px; display:none">
  
  
  <form method="post" action="process/actions/get_last_clerk_schedule_action.php">
  <input name="from" type="hidden" id="from" value="<? echo $real_date ?>" readonly="readonly" onchange="disable_btn()" />
  
  <table border="0">

   <tr>
    <td>Clerk: </td>
    <td align="center">
     <?
	create_objects_list("clerk", "clerk", $clerk_list, "id", "name", "All", $_clerk);  ?>
   	&nbsp;&nbsp;
    </td>
    <td>
  
  <input id="btn_last_schedule" <? //if ($disabled) { echo 'disabled="disabled"'; }?> type="submit" value="Load Last Schedule" />
   </td>

   </tr>
   </table>
  </form>
  </div>
   </td>
  </tr> 
  </table>
  
  
  <? } ?> 
  
    <? // Duplicate the Last Schedule  ?>
  <? if (($allow) &&  (!$current_clerk->im_allow("all_schedules"))){
   
    $groups = get_all_groups_by_manager($current_clerk->vars["id"], 1);
	 
	 $clerks_list = array();
	 foreach($groups as $group){
     
	 $clerks_group = get_all_clerks_by_group($group->vars["id"]);	  
	  //print_r($clerks_group);
	 $clerks_list = array_merge($clerks_list,$clerks_group);
	 }
  ?>
  <BR/> 
  <a style="display:block" id="a_link" href="javascript:display_div('div_last_schedule')" class="normal_link" title="Click to open form" >Load Last Schedule</a><BR/> 
  
  <div  id="div_last_schedule"  class="form_box" style="width:350px; display:none">
  
  
  <form method="post" action="process/actions/get_last_clerk_schedule_action.php">
  <input name="from" type="hidden" id="from" value="<? echo $real_date ?>" readonly="readonly" onchange="disable_btn()" />
  
  <table border="0">

   <tr>
    <td>Clerk: </td>
    <td align="center">
     <?
	create_objects_list("clerk", "clerk", $clerks_list, "id", "name", "All", $_clerk);  ?>
   	&nbsp;&nbsp;
    </td>
    <td>
  
  <input id="btn_last_schedule" <? if ($disabled) { echo 'disabled="disabled"'; }?> type="submit" value="Load Last Schedule" />
   </td>

 </tr>
 </table>
  </form>
  
  </div>
  
  <? } ?> 
 
<? if($current_clerk->im_allow("all_schedules")){ ?> 
<div align="right">
	<a href="javascript:;" onclick="document.getElementById('xml_form_1').submit();" class="normal_link">Export</a>
</div>

<? } ?>
  
  

<table width="100%" border="0" cellspacing="0" cellpadding="0">

<? foreach($groups as $grp){ ?>
	  <? $all_salaries = get_clerks_week_salary_by_group($grp->vars["id"],$real_date); ?>

      <tr>
      	<td colspan="100">
        	<a name="<? echo $grp->vars["id"] ?>" id="<? echo $grp->vars["id"] ?>"></a>
            <span class="page_title"><br /><br /><? echo $grp->vars["name"] ?> Schedules</span><br /><br />
        </td>
      </tr>
      <tr>
        <td class="table_header" width="100">Clerk</td>
        <td class="table_header" width="70">Mon</td>
        <td class="table_header" width="70">Tue</td>
        <td class="table_header" width="70">Wed</td>
        <td class="table_header" width="70">Thu</td>
        <td class="table_header" width="70">Fri</td>
        <td class="table_header" width="70">Sat</td>
        <td class="table_header" width="70">Sun</td>
        <td class="table_header"></td>
        <? if($current_clerk->im_allow("all_schedules")){ ?>
        <td class="table_header" title="Scheduled Hours" align="center">SHRS</td>
        <td class="table_header" title="Working Hours" align="center">HRS</td>
        <td class="table_header" title="Paid Missing Time" align="center">PMT</td>
        <td class="table_header" title="Total Hours" align="center">THRS</td>
        <td class="table_header" title="Salary by Week">SAL</td>
        <?php /*?><td class="table_header">Caja</td><?php */?>
        <td class="table_header" title="Deductions">Ded</td>
        <td class="table_header" title="Increases">INC</td>
        <td class="table_header" title="Increases">NOTES</td>
        <td class="table_header" title="Total Amount" align="center">$</td>
        <td class="table_header" title="Total Amount"></td>
        <? } ?>
      
      </tr>
      <? $gtotal = 0; ?>
      <? foreach(get_all_clerks_by_group($grp->vars["id"], "", false, 1) as $clerk){if($i % 2){$style = "1";}else{$style = "2";}$i++ ?>
            <? $phone_logins = get_all_clerk_phone_logins($clerk->vars["id"]);?>
			<? $schedule = get_all_schedule_by_clerk($clerk->vars["id"],$real_date); ?>
            <? $salary = $all_salaries[$clerk->vars["id"]]; ?>
            <? $whorus = $clerk->get_worked_hours_by_week($real_date); ?>
            <? $shorus = $clerk->get_schedule_hours_by_week($real_date,$schedule); ?>
            <? $mon_sch = ""; $tue_sch = ""; $wed_sch = ""; $thu_sch = ""; $fri_sch = ""; 
			   $sat_sch = ""; $sun_sch = ""; ?>
            
      <tr>
        <td align="center" class="table_td<? echo $style ?>">
        <? echo $clerk->vars["name"]; ?>
        <BR><?php /*?><BR>
        <table width="100%" border="1"> 
         <tr>
         <td align="center" <? if (check_phone_online_login($clerk->vars["id"])){ echo 'bgcolor="#00CC33"'; }?> height="10" style="font-size:9px" >Phone</td>
         <td align="center"  <? if (is_clerk_online_logged_vrb($clerk->vars["id"])){ echo 'bgcolor="#00CC33"'; }?> height="10"  style="font-size:9px" >VRB</td>
        
         </tr> 
        </table><?php */?>
        
        Ext: <? echo $clerk->vars["ext"] ?>
        
        </td>
        <td  width="70px" class="table_td<? echo $style ?>">
        	<? if(!is_null($schedule["mon"])){ ?>
			<? echo date("h:i A",strtotime($schedule["mon"]->vars["open_hour"])) ?><br />
            <? echo date("h:i A",strtotime($schedule["mon"]->vars["close_hour"])) ?>
            <? $mon_sch = date("h:i A",strtotime($schedule["mon"]->vars["open_hour"]))." to ".date("h:i A",strtotime($schedule["mon"]->vars["close_hour"])); ?>    
			<? }
			else{
			   if (isset($vacations[$clerk->vars["id"]."_".$dates["mon"]])){
				    echo "Vacation<BR>";  
			   }
			
			}
			
			if($clerk->is_manager()){ 
			    $mon_sch = $replacements[$grp->vars["id"]."-".$dates["mon"]]["name"];
			   	?> <span style="font-size:10px;"> <? echo $replacements[$grp->vars["id"]."-".$dates["mon"]]["name"]; ?> </span> <?
			} ?>
          <?php /*?><BR>
          <table width="100%" border="0"> 
           <tr>
           <td align="center"  height="10" style="font-size:9px" >
           <? if (!is_null($phone_logins)){
		       foreach ( $phone_logins as $phone_login){
   			     if (isset($login_phone[$dates["mon"]."_".$phone_login->vars["login"]])){
				   $img = true;
				   break;
				 } else {$img = false;}  
			   }
		     } else {$img = false;}
		   ?>
		   
		   <? if ($img){ ?> 
		    <img src="images/phone_login.png" />
		   <? }?>
           </td>
         <td align="center"  height="10"  style="font-size:9px" >
          <? if (isset($login_vrb[$dates["mon"]."_".$clerk->vars["id"]])){ ?>
            <img src="images/vrb_login.png" />
          <? } ?>
          </td>
          </tr> 
          </table><?php */?>
            
        </td>
        <td class="table_td<? echo $style ?>">
        	<? if(!is_null($schedule["tue"])){ ?>
			<? echo date("h:i A",strtotime($schedule["tue"]->vars["open_hour"])) ?><br />
            <? echo date("h:i A",strtotime($schedule["tue"]->vars["close_hour"])) ?>
            <? $tue_sch = date("h:i A",strtotime($schedule["tue"]->vars["open_hour"]))." to ".date("h:i A",strtotime($schedule["tue"]->vars["close_hour"])); ?>
            <? }
			else{
			   if (isset($vacations[$clerk->vars["id"]."_".$dates["tue"]])){
				    echo "Vacation<BR>";  
			   } 
			}
			if($clerk->is_manager()){ 
			    $tue_sch = $replacements[$grp->vars["id"]."-".$dates["tue"]]["name"]; 
					?> <span style="font-size:10px;"> <? echo $replacements[$grp->vars["id"]."-".$dates["tue"]]["name"]; ?> </span> <?
			} ?>
            <BR>
          <table width="100%" border="0"> 
           <tr>
           <td align="center"  height="10" style="font-size:9px" >
            <? if (!is_null($phone_logins)){
		       foreach ( $phone_logins as $phone_login){
   			     if (isset($login_phone[$dates["tue"]."_".$phone_login->vars["login"]])){
				   $img = true;
				   break;
				 } else {$img = false;}  
			   }
		     } else {$img = false;}
		   ?>
		   
		   <? if ($img){ ?> 
		    <img src="images/phone_login.png" />
		   <? }?>
           </td>
         <td align="center"  height="10"  style="font-size:9px" >
          <? if (isset($login_vrb[$dates["tue"]."_".$clerk->vars["id"]])){ ?>
            <img src="images/vrb_login.png" />
          <? } ?>
          </td>
          </tr> 
          </table>
        </td>
        <td class="table_td<? echo $style ?>">
        	<? if(!is_null($schedule["wed"])){ ?>
			<? echo date("h:i A",strtotime($schedule["wed"]->vars["open_hour"])) ?><br />
            <? echo date("h:i A",strtotime($schedule["wed"]->vars["close_hour"])) ?>
            <? $wed_sch = date("h:i A",strtotime($schedule["wed"]->vars["open_hour"]))." to ".date("h:i A",strtotime($schedule["wed"]->vars["close_hour"])); ?>
            <? }
			else{
			   if (isset($vacations[$clerk->vars["id"]."_".$dates["wed"]])){
				    echo "Vacation<BR>";  
			   } 
			}
			
			if($clerk->is_manager()){ 
				     $wed_sch = $replacements[$grp->vars["id"]."-".$dates["wed"]]["name"];
					?> <span style="font-size:10px;"> <? echo $replacements[$grp->vars["id"]."-".$dates["wed"]]["name"]; ?> </span> <?
			} ?>
            <BR>
          <table width="100%" border="0"> 
           <tr>
           <td align="center"  height="10" style="font-size:9px" >
            <? if (!is_null($phone_logins)){
		       foreach ( $phone_logins as $phone_login){
   			     if (isset($login_phone[$dates["wed"]."_".$phone_login->vars["login"]])){
				   $img = true;
				   break;
				 } else {$img = false;}  
			   }
		     } else {$img = false;}
		   ?>
		   
		   <? if ($img){ ?> 
		    <img src="images/phone_login.png" />
		   <? }?>
           </td>
         <td align="center"  height="10"  style="font-size:9px" >
          <? if (isset($login_vrb[$dates["wed"]."_".$clerk->vars["id"]])){ ?>
            <img src="images/vrb_login.png" />
          <? } ?>
          </td>
          </tr> 
          </table>
        </td>
        <td class="table_td<? echo $style ?>">
        	<? if(!is_null($schedule["thu"])){ ?>
			<? echo date("h:i A",strtotime($schedule["thu"]->vars["open_hour"])) ?><br />
            <? echo date("h:i A",strtotime($schedule["thu"]->vars["close_hour"])) ?>
            <? $thu_sch = date("h:i A",strtotime($schedule["thu"]->vars["open_hour"]))." to ".date("h:i A",strtotime($schedule["thu"]->vars["close_hour"])); ?>            
            <? }
			else{
			   if (isset($vacations[$clerk->vars["id"]."_".$dates["thu"]])){
				    echo "Vacation<BR>";  
			   } 
			}
			
			 if($clerk->is_manager()){ 
			         $thu_sch = $replacements[$grp->vars["id"]."-".$dates["thu"]]["name"];
					?> <span style="font-size:10px;"> <? echo $replacements[$grp->vars["id"]."-".$dates["thu"]]["name"]; ?> </span> <?
			} ?>
            <BR>
          <table width="100%" border="0"> 
           <tr>
           <td align="center"  height="10" style="font-size:9px" >
 <? if (!is_null($phone_logins)){
		       foreach ( $phone_logins as $phone_login){
   			     if (isset($login_phone[$dates["thu"]."_".$phone_login->vars["login"]])){
				   $img = true;
				   break;
				 } else {$img = false;}  
			   }
		     } else {$img = false;}
		   ?>
		   
		   <? if ($img){ ?> 
		    <img src="images/phone_login.png" />
		   <? }?>           </td>
         <td align="center"  height="10"  style="font-size:9px" >
          <? if (isset($login_vrb[$dates["thu"]."_".$clerk->vars["id"]])){ ?>
            <img src="images/vrb_login.png" />
          <? } ?>
          </td>
          </tr> 
          </table>
        </td>
        <td class="table_td<? echo $style ?>">
        	<? if(!is_null($schedule["fri"])){ ?>
			<? echo date("h:i A",strtotime($schedule["fri"]->vars["open_hour"])) ?><br />
            <? echo date("h:i A",strtotime($schedule["fri"]->vars["close_hour"])) ?>
            <? $fri_sch = date("h:i A",strtotime($schedule["fri"]->vars["open_hour"]))." to ".date("h:i A",strtotime($schedule["fri"]->vars["close_hour"])); ?>            
            <? }
			 else{
			   if (isset($vacations[$clerk->vars["id"]."_".$dates["fri"]])){
				    echo "Vacation<BR>";  
			   } 
			}
			
			 if($clerk->is_manager()){ 
					  $fri_sch = $replacements[$grp->vars["id"]."-".$dates["fri"]]["name"];
					?> <span style="font-size:10px;"> <? echo $replacements[$grp->vars["id"]."-".$dates["fri"]]["name"]; ?> </span> <?
			} ?>
            <BR>
          <table width="100%" border="0"> 
           <tr>
           <td align="center"  height="10" style="font-size:9px" >
 <? if (!is_null($phone_logins)){
		       foreach ( $phone_logins as $phone_login){
   			     if (isset($login_phone[$dates["fri"]."_".$phone_login->vars["login"]])){
				   $img = true;
				   break;
				 } else {$img = false;}  
			   }
		     } else {$img = false;}
		   ?>
		   
		   <? if ($img){ ?> 
		    <img src="images/phone_login.png" />
		   <? }?>           </td>
         <td align="center"  height="10"  style="font-size:9px" >
          <? if (isset($login_vrb[$dates["fri"]."_".$clerk->vars["id"]])){ ?>
            <img src="images/vrb_login.png" />
          <? } ?>
          </td>
          </tr> 
          </table>
        </td>
        <td class="table_td<? echo $style ?>">
        	<? if(!is_null($schedule["sat"])){ ?>
			<? echo date("h:i A",strtotime($schedule["sat"]->vars["open_hour"])) ?><br />
            <? echo date("h:i A",strtotime($schedule["sat"]->vars["close_hour"])) ?>
            <? $sat_sch = date("h:i A",strtotime($schedule["sat"]->vars["open_hour"]))." to ".date("h:i A",strtotime($schedule["sat"]->vars["close_hour"])); ?>
            <? }
			else{
			   if (isset($vacations[$clerk->vars["id"]."_".$dates["sat"]])){
				    echo "Vacation<BR>";  
			   } 
			}
			
			 if($clerk->is_manager()){ 
	 			    $sat_sch = $replacements[$grp->vars["id"]."-".$dates["sat"]]["name"];
					?> <span style="font-size:10px;"> <? echo $replacements[$grp->vars["id"]."-".$dates["sat"]]["name"]; ?> </span> <?
			} ?>
            <BR>
          <table width="100%" border="0"> 
           <tr>
           <td align="center"  height="10" style="font-size:9px" >
 			<? if (!is_null($phone_logins)){
		     foreach ( $phone_logins as $phone_login){
   			     if (isset($login_phone[$dates["sat"]."_".$phone_login->vars["login"]])){
				   $img = true;
				   break;
				 } else {$img = false;}  
			   }
		     } else {$img = false;}
		   ?>
		   
		   <? if ($img){ ?> 
		    <img src="images/phone_login.png" />
		   <? }?>           </td>
         <td align="center"  height="10"  style="font-size:9px" >
          <? if (isset($login_vrb[$dates["sat"]."_".$clerk->vars["id"]])){ ?>
            <img src="images/vrb_login.png" />
          <? } ?>
          </td>
          </tr> 
          </table>
        </td>
        <td class="table_td<? echo $style ?>">
        	<? if(!is_null($schedule["sun"])){ ?>
			<? echo date("h:i A",strtotime($schedule["sun"]->vars["open_hour"])) ?><br />
            <? echo date("h:i A",strtotime($schedule["sun"]->vars["close_hour"])) ?>
            <? $sun_sch = date("h:i A",strtotime($schedule["sun"]->vars["open_hour"]))." to ".date("h:i A",strtotime($schedule["sun"]->vars["close_hour"])); ?>
            <? }
			 else{
			   if (isset($vacations[$clerk->vars["id"]."_".$dates["sun"]])){
				    echo "Vacation<BR>";  
			   } 
			}
			
			 if($clerk->is_manager()){ 
			         $sun_sch = $replacements[$grp->vars["id"]."-".$dates["sun"]]["name"];
					?> <span style="font-size:10px;"> <? echo $replacements[$grp->vars["id"]."-".$dates["sun"]]["name"]; ?> </span> <?
			} ?>
            <BR>
          <table width="100%" border="0"> 
           <tr>
           <td align="center"  height="10" style="font-size:9px" >
 		<? if (!is_null($phone_logins)){
		       foreach ( $phone_logins as $phone_login){
   			     if (isset($login_phone[$dates["sun"]."_".$phone_login->vars["login"]])){
				   $img = true;
				   break;
				 } else {$img = false;}  
			   }
		     } else {$img = false;}
		   ?>
		   
		   <? if ($img){ ?> 
		    <img src="images/phone_login.png" />
		   <? }?>           </td>
         <td align="center"  height="10"  style="font-size:9px" >
          <? if (isset($login_vrb[$dates["sun"]."_".$clerk->vars["id"]])){ ?>
            <img src="images/vrb_login.png" />
          <? } ?>
          </td>
          </tr> 
          </table>
        </td>
        <td class="table_td<? echo $style ?>" style="text-align:center; font-weight:normal;">
          <? if($allow) { ?>     
            <a class="normal_link" href="schedule_user.php?uid=<? echo $clerk->vars["id"] ?>&realdate=<? echo $real_date ?>">Edit</a>
          <? } ?>
        </td>
        
        <? if($current_clerk->im_allow("all_schedules")){ ?>
        <td class="table_td<? echo $style ?>"  align="center">
        	<? echo number_format($shorus,2); ?>
        </td>
        <td class="table_td<? echo $style ?>"  align="center">
			<a href="log_time_details.php?clk=<? echo $clerk->vars["id"]; ?>&f=<? echo $real_date ?>&t=<? echo $sunday ?>" class="normal_link" rel="shadowbox;height=500;width=600">
				<? echo number_format($whorus,2) ?>
            </a>
        </td>
        <td class="table_td<? echo $style ?>"  align="center">
			<? 
			$late_hrs = $lates[$clerk->vars["id"]]["total"];
			if($late_hrs == ""){$late_hrs = 0;}
			$whorus += $late_hrs;
			echo number_format($late_hrs,2);
			?>
        </td>
        <td class="table_td<? echo $style ?>"  align="center">
			<? echo number_format($whorus,2); ?>
        </td>
        <td class="table_td<? echo $style ?> ">
        	<form method="post" action="process/actions/update_salary.php">
            <input name="group" type="hidden" id="group" value="<? echo $grp->vars["id"] ?>" />
        	<input name="clerk" type="hidden" id="clerk" value="<? echo $clerk->vars["id"] ?>" />
            <input name="week" type="hidden" id="week" value="<? echo $real_date ?>" />
            <input name="salary" type="text" id="salary" size="5" value="<? echo $salary->vars["salary"] ?>" /><br />
            <select name="type" id="type">
              <option value="h" <? if($salary->vars["type"] == "h"){ $str_salary = "Per Hour" ?>selected="selected"<? } ?>>per hour</option>
              <option value="f" <? if($salary->vars["type"] == "f"){ $str_salary = "Flat"  ?>selected="selected"<? } ?>>flat</option>
            </select>
        </td>        
        <?php /*?><td class="table_td<? echo $style ?>">
        	<input name="caja" type="text" id="caja" size="5" value="<? echo $salary->vars["caja"] ?>" />
        </td><?php */?>
        <td class="table_td<? echo $style ?>">
        	<input name="deductions" type="text" id="deductions" size="5" value="<? echo $salary->vars["deductions"] ?>" />
        </td>
        <td class="table_td<? echo $style ?>">
        	<input name="increases" type="text" id="increases" size="5" value="<? echo $salary->vars["increases"] ?>" />
        </td>
        <td class="table_td<? echo $style ?>">
        	<textarea name="notes" cols="10" rows="3" id="notes"><? echo $salary->vars["notes"] ?></textarea>
        </td>
        <td class="table_td<? echo $style ?>" align="center">
        	<? 
			if($salary->vars["type"] == 'f'){
				$money_amount = $salary->vars["salary"];
			}else{
				$money_amount = $salary->vars["salary"] * $whorus;
			}
			$money_amount -= $salary->vars["caja"];
			$money_amount -= $salary->vars["deductions"];
			$money_amount += $salary->vars["increases"];
			$money_amount = round($money_amount);
			$gtotal += $money_amount;
			echo $money_amount;
			?>
        </td>
        <td class="table_td<? echo $style ?>" align="center"><input name="Enviar" type="submit" value="Update" /></form></td>
        <? } ?>
       
      </tr>
   <? if($current_clerk->im_allow("all_schedules")){       
          $line = $clerk->vars["name"]." \t ".$mon_sch." \t ".$tue_sch." \t ".$wed_sch." \t ".$thu_sch." \t ".$fri_sch." \t ".$sat_sch." \t ".$sun_sch."  \t ".$shorus." \t ".$whorus." \t ".$late_hrs." \t ".$whorus." \t ".$str_salary." \t ".$salary->vars["caja"]." \t ".$salary->vars["deductions"]." \t ".$salary->vars["increases"]." \t ".$salary->vars["notes"]." \t ".$money_amount." \t ";		
         
		 $line = str_replace(str_split($charlist), ' ', $line);
         $report_line .= $line."\n ";
      } ?> 
      
      
      
      <? } ?>
      <? if($current_clerk->im_allow("all_schedules")){ ?>
      <tr>
        <td class="table_header" colspan="18"></td>
        <td class="table_header" align="center"><strong><? $super_total += $gtotal; echo $gtotal; ?></strong></td>
        <td class="table_header"></td>
      </tr>
      <? } ?>
    


<? } ?>
</table>

<? if($current_clerk->im_allow("all_schedules")){ ?>
<br /><br />
<table width="300" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td class="table_header">Payroll Total:</td>
      <td class="table_header" align="center"><strong><? echo $super_total; ?></strong></td>
    </tr>
</table>
<? } ?>
</div>
<? $content = $columns." ".$report_line; ?>
<form method="post" action="process/actions/excel.php" id="xml_form_1">
<input name="content" type="hidden" id="content" value="<? echo $content ?>">
<input name="name" type="hidden" id="name" value="Schedule Report">
</form>
<? include "../includes/footer.php" ?>

<? }else{echo "Access Denied";} ?>
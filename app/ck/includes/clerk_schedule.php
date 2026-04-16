<? include(ROOT_PATH . "/ck/process/security.php"); ?><head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../../css/style.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="<?= BASE_URL ?>/includes/shadowbox/shadowbox.css" type="text/css" media="screen" />
<script type="text/javascript" src="<?= BASE_URL ?>/includes/shadowbox/shadowbox.js"></script>
<script type="text/javascript" src="<?= BASE_URL ?>/process/js/functions.js?v=2"> </script>
<script type="text/javascript">
Shadowbox.init();
</script>
</head>
<? 
  echo "<pre>";
  //print_r($current_clerk);
  echo "</pre>";
  if (isset($_GET["realdate"])){
    $from = $_GET["realdate"];
    $real_date =  get_monday($from);
  }
  else { 
    $from =  get_monday(date("Y-m-d"));
    $real_date = $from;
  }
  
$date_pre = date("Y-m-d",strtotime($real_date." - 7 day"));
$date_next =  date("Y-m-d",strtotime($real_date." + 7 day")); 

$sunday = date("Y-m-d",strtotime($real_date." + 6 days")); 
  
$replacements = get_manager_replacements($real_date, $sunday);
$this_monday = get_monday(date("Y-m-d"));
//To allow edit older weeks comment the 3 lines below
if ($real_date <  $this_monday) { 
$allow = false;
}

//$sunday = date("Y-m-d",strtotime($real_date." + 6 days"));
$super_total = 0;
$dates["mon"] = $real_date;
$dates["tue"] = date("Y-m-d",strtotime($real_date." + 1 day"));
$dates["wed"] = date("Y-m-d",strtotime($real_date." + 2 day"));
$dates["thu"] = date("Y-m-d",strtotime($real_date." + 3 day"));
$dates["fri"] = date("Y-m-d",strtotime($real_date." + 4 day"));
$dates["sat"] = date("Y-m-d",strtotime($real_date." + 5 day"));
$dates["sun"] = $sunday;
$login_vrb = get_clerk_logged_vrb_date($dates["mon"],$dates["sun"]);
$login_phone = get_agent_loged_at_phone_date($dates["mon"],$dates["sun"]);


$vacations = get_all_clerk_vacations($user->vars["id"],$real_date, date( "Y-m-d", strtotime( "6 day", strtotime($real_date))),true);


?>

  <?
   $clerk_list = get_all_clerks(1);
  ?>

  
  

<span style="font-size:12px">Your schedule from week : <? echo $real_date ?> </span>
<table width="100%" border="0" cellspacing="0" cellpadding="0">

  
      <tr>
        <td class="table_header" width="10"></td>
        <td class="table_header" width="100">Clerk</td>
        <td class="table_header" width="70">Mon</td>
        <td class="table_header" width="70">Tue</td>
        <td class="table_header" width="70">Wed</td>
        <td class="table_header" width="70">Thu</td>
        <td class="table_header" width="70">Fri</td>
        <td class="table_header" width="70">Sat</td>
        <td class="table_header" width="70">Sun</td>
        <td class="table_header" title="Scheduled Hours" align="center">SHRS</td>
        <td class="table_header" title="Working Hours" align="center">HRS</td>
        <td class="table_header" title="Paid Missing Time" align="center">PMT</td>
        <td class="table_header" title="Total Hours" align="center">THRS</td>
        <td class="table_header" width="10"></td>
       
      
      </tr>
      <? $gtotal = 0;
	   
	   ?>
      <? $_clerk = get_all_clerks_by_group($current_clerk->vars["user_group"]->vars["id"],$current_clerk->vars["id"]); 
	  
	  ?>
      <? foreach($_clerk as $clerk){if($i % 2){$style = "1";}else{$style = "2";}$i++ ?>
            <? $phone_logins = get_all_clerk_phone_logins($clerk->vars["id"]);?>
			<? $schedule = get_all_schedule_by_clerk($clerk->vars["id"],$real_date); ?>
            <? $salary = $all_salaries[$clerk->vars["id"]]; ?>
            <? $whorus = $clerk->get_worked_hours_by_week($real_date); ?>
            <? $shorus = $clerk->get_schedule_hours_by_week($real_date,$schedule); ?>
            <? $mon_sch = ""; $tue_sch = ""; $wed_sch = ""; $thu_sch = ""; $fri_sch = ""; 
			   $sat_sch = ""; $sun_sch = ""; ?>
            
      <tr>
        <td align="center" class="table_td<? echo $style ?>">
         <a href="?realdate=<? echo $date_pre ?>&pre=1" <? if (isset($_GET["next"]) && $this_monday != $real_date ){ echo 'title="Current Week"'; } else { echo 'title="Last Week Schedule"'; } ?>
          <? if (isset($_GET["pre"]) && $this_monday != $real_date ) { echo 'style="display:none"'; } ?> ><</a> 
        </td>
        <td align="center" class="table_td<? echo $style ?>">
        <? echo $clerk->vars["name"]; ?>
        <BR><BR>
        <table width="100%" border="1"> 
         <tr>
         <td align="center" <? if (check_phone_online_login($clerk->vars["id"])){ echo 'bgcolor="#00CC33"'; }?> height="10" style="font-size:9px" >Phone</td>
         <td align="center"  <? if (is_clerk_online_logged_vrb($clerk->vars["id"])){ echo 'bgcolor="#00CC33"'; }?> height="10"  style="font-size:9px" >VRB</td>
        
         </tr> 
        </table>
        
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
          <BR>
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
		    <img src="../images/vrb_login.png" />
		   <? }?>
           </td>
         <td align="center"  height="10"  style="font-size:9px" >
          <? if (isset($login_vrb[$dates["mon"]."_".$clerk->vars["id"]])){ ?>
            <img src="../images/vrb_login.png" />
          <? } ?>
          </td>
          </tr> 
          </table>
            
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
		    <img src="../images/vrb_login.png" />
		   <? }?>
           </td>
         <td align="center"  height="10"  style="font-size:9px" >
          <? if (isset($login_vrb[$dates["tue"]."_".$clerk->vars["id"]])){ ?>
            <img src="../images/vrb_login.png" />
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
		    <img src="../../images/vrb_login.png" />
		   <? }?>
           </td>
         <td align="center"  height="10"  style="font-size:9px" >
          <? if (isset($login_vrb[$dates["wed"]."_".$clerk->vars["id"]])){ ?>
            <img src="../images/vrb_login.png" />
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
		    <img src="../images/vrb_login.png" />
		   <? }?>           </td>
         <td align="center"  height="10"  style="font-size:9px" >
          <? if (isset($login_vrb[$dates["thu"]."_".$clerk->vars["id"]])){ ?>
            <img src="../images/vrb_login.png" />
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
		    <img src="../images/vrb_login.png" />
		   <? }?>           </td>
         <td align="center"  height="10"  style="font-size:9px" >
          <? if (isset($login_vrb[$dates["fri"]."_".$clerk->vars["id"]])){ ?>
            <img src="../images/vrb_login.png" />
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
		    <img src="../images/vrb_login.png" />
		   <? }?>           </td>
         <td align="center"  height="10"  style="font-size:9px" >
          <? if (isset($login_vrb[$dates["sat"]."_".$clerk->vars["id"]])){ ?>
            <img src="../images/vrb_login.png" />
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
		    <img src="../images/vrb_login.png" />
		   <? }?>           </td>
         <td align="center"  height="10"  style="font-size:9px" >
          <? if (isset($login_vrb[$dates["sun"]."_".$clerk->vars["id"]])){ ?>
            <img src="../images/vrb_login.png" />
          <? } ?>
          </td>
          </tr> 
          </table>
        </td>
             
       
        <td class="table_td<? echo $style ?>"  align="center">
        	<? echo number_format($shorus,2); ?>
        </td>
        <td class="table_td<? echo $style ?>"  align="center">
			<a href="../log_time_details.php?clk=<? echo $clerk->vars["id"]; ?>&f=<? echo $real_date ?>&t=<? echo $sunday ?>" class="normal_link" target="_blank" >
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
        <td align="center" class="table_td<? echo $style ?>">
         <a href="?realdate=<? echo $date_next ?>&next=1" <? if (isset($_GET["pre"]) && $this_monday != $real_date ){ echo 'title="Current Week"'; } else { echo 'title="Next Week Schedule"'; } ?>
          <? if (isset($_GET["next"])  && $this_monday != $real_date) { echo 'style="display:none"'; } ?> >></a> 
        </td>
       
       
      </tr>
  
<? } ?>
 <tr>
      <td class="table_last" colspan="100"></td>
    </tr>

</table>


</div>





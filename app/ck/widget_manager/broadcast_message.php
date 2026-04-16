<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<?php

?>


<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../../css/style.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="<?= BASE_URL ?>/includes/shadowbox/shadowbox.css" type="text/css" media="screen" />
<title>Events leagues</title>
<script type="text/javascript" src="<?= BASE_URL ?>/process/js/functions.js?v=2"> </script>
<script type="text/javascript" src="<?= BASE_URL ?>/includes/shadowbox/shadowbox.js"></script>
<script type="text/javascript">
Shadowbox.init();
</script>
</head>
<body>
<? include "../../includes/header.php" ?>
<? include "../../includes/menu_ck.php" ?>
<div class="page_content" style="padding-left:50px;">
<span class="page_title">Broadcast Message</span>
<div align="right"><span ><a href="<?= BASE_URL ?>/ck/widget_manager/events_leagues.php">Back</a></span></div>
<BR>
 <?
  if (isset($_POST["msg"])){
	
	$reg_devices = get_reg_devices_app('LineMaster') ;
	 
	 if (!empty($reg_devices)){
	 
	    $keys= array();
		foreach($reg_devices as $rg){
			
		  $keys[] = $rg["device_key"];	
		}
		
	  $title = "Line Master Update";
	  $message = param("msg");	
	   include("notifications.php");
	   ?><script>
	     alert("Broadcast Message Sent to <? echo count($keys)?> devices");
	    </script>
	   <?
	 }
	  
	}

 $banners = get_all_event_banners();
 
?> 
   <div class="form_box" style="width:700px;">  
   <form method="post">
    <label> ENTER THE BROADCAST MESSAGE<label>&nbsp;&nbsp;&nbsp;
    <input type="text" name="msg" id="msg" style="width: 50%" required  />&nbsp;&nbsp;&nbsp;
    <input type="submit" value="Sent" />
   </form> 
   </div>
</div>
<? include "../../includes/footer.php" ?>

<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/style.css" rel="stylesheet" type="text/css" />
<title>Welcome</title>
<link rel="stylesheet" href="<?= BASE_URL ?>/includes/shadowbox/shadowbox.css" type="text/css" media="screen" />
<script type="text/javascript" src="<?= BASE_URL ?>/includes/shadowbox/shadowbox.js"></script>
<script type="text/javascript" src="../process/js/functions.js"></script>
<script type="text/javascript">
Shadowbox.init();
</script>
</head>
<body>
<? 

 include "../includes/header.php" ?>

<?  
if($_GET["demo"]){
	include "../includes/menu_basic.php";
}else if($current_clerk->vars["level"]->vars["name"] != "Monitor"){
	include "../includes/menu_ck.php";
} 
?>



<div class="page_content" style="padding-left:20px; display:inline-block; width:929px;">
<? if(!$current_clerk->admin() && !$current_clerk->im_allow("just_queue_calls") && $current_clerk->vars['user_group']->vars['id'] != 27 ){ ?>

<p><a href="<?= BASE_URL ?>/ck/includes/clerk_schedule.php" class="normal_link" target="_blank">View my Schedule</a></p>
<br />
<? } ?>
<span class="page_title">Welcome:</span> <span class="orange_title"><? echo $current_clerk->vars["name"]?></span><BR/>

<? if ($current_clerk->has_login_extension()) {?>
<div>
<? 

include("includes/phone_login.php"); 
?>
<BR><BR>
</div>
<? } ?>


<? if($current_clerk->im_allow("tickets") && !$_GET["demo"]){ ?>
<br /><iframe frameborder="0" width="300" height="25" scrolling="no" src="includes/tickets_alerts.php"></iframe>
<? } ?>

<br /><br />

<? include "includes/print_error.php" ?>

<?
if($_GET["demo"]){
	include("index_new.php");
}else if($current_clerk->admin()){
	include("index_admin.php");
}else if($current_clerk->vars["level"]->vars["id"] == 3 || $current_clerk->vars["level"]->vars["id"] == 6){
	include("index_employee.php");
}else  if($current_clerk->vars["level"]->vars["is_sales"]){
	include("index_clerk.php");
}else  if($current_clerk->vars["level"]->vars["name"] == "Monitor"){
	include("index_monitor.php");
}

?>

</div>
<? include "../includes/footer.php" ?>
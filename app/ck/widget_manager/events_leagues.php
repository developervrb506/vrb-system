<? include(ROOT_PATH . "/ck/process/security.php"); ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../../css/style.css" rel="stylesheet" type="text/css" />
<title>Events leagues</title>
<script type="text/javascript" src="http://localhost:8080/process/js/functions.js"> </script>
<script type="text/javascript">
 function reload(color){
	//alert(color); 
 var url = window.location.href;    
   if (url.indexOf('?') > -1){
   url += '&color='+color
}else{
   url += '?color='+color
}
window.location.href = url;
 
 }

</script>
</head>
<body>
<? $page_style = " width:1600px;"; ?>
<? include "../../includes/header.php" ?>
<? include "../../includes/menu_ck.php" ?>
<div class="page_content" style="padding-left:50px;">
<span class="page_title">Events Leagues Menu</span><br /><br />

<a href="create_widget_site.php" class="normal_link">Create Widget for Site </a><br />
Here you are able to create the code to share to be added for a client.<BR>
<br /><br /> 

<a href="opener.php" class="normal_link">Opener  </a><br />
 Here you are able to change the Opener , and set the Pop up Message.<BR>
<br /><br /> 



<a href="sites.php" class="normal_link">Sites </a><br />
Manage Sites and Customize the widget.<BR>
<br /><br /> 

<a href="leagues_order.php" class="normal_link">Leagues Order</a><br />
Manage the Default Order by League.<BR>
<br /><br /> 

<a href="details_league.php" class="normal_link"> League Details </a><br />
Manage the type of line and periods to show for each League  <BR>
<br /><br />

<a href="books_details.php" class="normal_link">Books  </a><br />
Manage the Landing Pages and book's information.<BR>
<br /><br />


<a href="books_league.php" class="normal_link">Books for League</a><br />
Manage the Books for league.<BR>
<br /><br /> 

<a href="banners.php" class="normal_link">Banners</a><br />
Manage the Banners that could be used in the widget.<BR>
<br /><br /> 

<a href="broadcast_message.php" class="normal_link">App Broadcast Notification</a><br />
Allow to sent a Message to all the instaled devices.<BR>
<br /><br /> 
<div>
 <?
    if ($_GET["color"]== "") { $color = "red"; } else { $color = $_GET["color"]; }
 
 ?>

<?php /* 
&nbsp;&nbsp;&nbsp; RED <input type="radio" <? if ($color == "red") { echo ' checked="checked" '; }?> value="red" name ="color" onchange="reload(this.value)" />  
&nbsp;&nbsp;BLUE <input  <? if ($color == "blue") { echo ' checked="checked" '; }?>type="radio" value="blue" name ="color" onchange="reload(this.value)" />
<?
$user = "";
$domain = $_SERVER['HTTP_HOST']; 
?>
<br /><br />
 /*?><iframe width="100%" height="1200" src="http://lines.sportsbettingonline.ag/utilities/process/stats/widget/leagues_widget/main.php?&color=<? echo $color ?>&user=<? echo $user ?>&domain=<? echo $domain?>" scrolling="no" frameborder="0" allowfullscreen></iframe> <?php */?>
</div>



</div>
<? include "../../includes/footer.php" ?>
<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<?php
$page = $_SERVER['PHP_SELF'];
$sec = "15";
?>


<head>
<meta http-equiv="refresh" content="<?php echo $sec?>;URL="<? echo $page  ?>"">
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




<? if (isset($_GET["id"])){

 $banner = get_event_banner(($_GET["id"]));
 $banner->delete();
 header("Location: " . BASE_URL . "/ck/widget_manager/banners.php");


} ?>


<? include "../../includes/header.php" ?>
<? include "../../includes/menu_ck.php" ?>
<div class="page_content" style="padding-left:50px;">
<span class="page_title">Banners</span>
<div align="right"><span ><a href="<?= BASE_URL ?>/ck/widget_manager/events_leagues.php">Back</a></span></div>
<BR>
&nbsp;&nbsp;  <a href="add_banner.php" class="normal_link" rel="shadowbox;height=270;width=400">Add a Banner</a>

 
 

 
 <?


 $banners = get_all_event_banners();
 
?>   
 
 <table id="" width="80%" border="0" cellspacing="0" cellpadding="0">
		  <tr>
            <td  name ="game_info_" width="80"  align="center" class="table_header" title="">Banner</td> 
            <td  name ="game_info_" width="80"  align="center" class="table_header" title="">Size</td> 
            <td  name ="game_info_" width="80"  align="center" class="table_header" title="">Link</td> 
			<td width="100"  class="table_header" align="center" ></td>
            <td width="100"  class="table_header" align="center" ></td>
		 </tr>  
		
		  <? foreach ($banners as $bn) { 
			  
			 			  
			  if($i % 2){$style = "1";}else{$style = "2";} $i++;
			  ?>
			  <tr>
             
               <td class="table_td<? echo $style ?>" style="font-size:12px;">
               <img width="500px" height="50px" src="<? echo $bn->vars["banner"]; ?>">
			   
			   
               </td>
                <td class="table_td<? echo $style ?>" style="font-size:12px;"><? echo $bn->vars["size"]; ?></td>
               <td class="table_td<? echo $style ?>" style="font-size:12px;">
               <? echo $bn->vars["link"]; ?>
               </td>
			  <td class="table_td<? echo $style ?>" style="font-size:12px;">
			   <a href="add_banner.php?id=<? echo $bn->vars["id"]?>" class="normal_link" rel="shadowbox;height=270;width=400">
        	   Edit
              </a>
              </td> 
              <td class="table_td<? echo $style ?>" style="font-size:12px;">
			   <a class="normal_link" href="banners.php?id=<? echo $bn->vars["id"]?>" >
        	   Delete
              </a>
              </td> 
			 </tr>
         <? } ?>    
			
			<tr>
			  <td class="table_last" colspan="100"></td>
			</tr>
		
		</table>
        
        <BR><BR>
</div>
<? include "../../includes/footer.php" ?>

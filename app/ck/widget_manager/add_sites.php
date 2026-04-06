<? include(ROOT_PATH . "/ck/process/security.php"); ?>

<? if (isset($_POST["site"])){

 $site = new _event_sites();
 $site->vars["site"] = $_POST["site"];
 $site->insert();
 header("Location: " . BASE_URL . "/ck/widget_manager/add_sites.php");


} ?>



<? if (isset($_GET["id"])){

 $site = get_event_site(($_GET["id"]));
 $site->delete();
 header("Location: " . BASE_URL . "/ck/widget_manager/add_sites.php");


} ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../../css/style.css" rel="stylesheet" type="text/css" />
<title>Events leagues</title>
<script type="text/javascript" src="<?= BASE_URL ?>/process/js/functions.js"> </script>
</head>
<body>

<div class="page_content" style="padding-left:50px;">
<span class="page_title"> Sites <? echo $league ?></span><br /><br />




<form action="" method="post" >
 
 
 Site : <input type="text" id="site" name="site"/> 
  <input type="submit" value="Save"/>
  <p style="font-size:11px;  margin-left: 35px;">( www.sitename.com  ) </p>
 </form>
 <BR><BR>
 
 <?


 $sites = get_all_event_sites();
 
?>   
 
 <table id="" width="80%" border="0" cellspacing="0" cellpadding="0">
		  <tr>
            <td  name ="game_info_" width="80"  align="center" class="table_header" title="">Site</td> 
			<td width="100"  class="table_header" align="center" ></td>
		 </tr>  
		
		  <? foreach ($sites as $st) { 
			  
			 			  
			  if($i % 2){$style = "1";}else{$style = "2";} $i++;
			  ?>
			  <tr>
               <td class="table_td<? echo $style ?>" style="font-size:12px;">
               <? echo $st->vars["site"]; ?>
               </td>
			  <td class="table_td<? echo $style ?>" style="font-size:12px;">
			  <a class="normal_link" href="add_sites.php?id=<? echo $st->vars["id"]?>" >
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

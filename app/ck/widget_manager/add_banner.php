<? include(ROOT_PATH . "/ck/process/security.php"); ?>

<? if (isset($_POST["banner"])){

   
   if (isset($_POST["update"])){
      $banner = get_event_banner($_POST["update"]);
      $banner->vars["banner"] = $_POST["banner"];
	  $banner->vars["size"] = $_POST["size"];
	  $banner->vars["link"] = $_POST["link"];
	  $banner->update();
  
  
  
   }else {
	  $banner = new _events_banners(); 
      $banner->vars["banner"] = $_POST["banner"];
      $banner->vars["size"] = $_POST["size"];
	  $banner->vars["link"] = $_POST["link"];
	  $banner->insert();


	 }
   
 
	
	

	?><script>
	   alert("Banner Addeed Please Reload the Banner Page");
	   </script>
	 <?


} ?>



<? if (isset($_GET["id"])){
 $banner = get_event_banner($_GET["id"]);	
 $update = true;
 $tittle = "Edit Banner";
} else {
  $update = false;
 $tittle = "New Banner";	
	} ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../../css/style.css" rel="stylesheet" type="text/css" />
<title>Events leagues</title>
<script type="text/javascript" src="<?= BASE_URL ?>/process/js/functions.js?v=2"> </script>
</head>
<body>

<div class="page_content" style="padding-left:50px;">
<span class="page_title"><? echo $title ?></span><br /><br />




<form action="" method="post" >
 
 <? if ($update) { ?>
  <input type="hidden" id="update" name="update" value="<? echo $_GET["id"]?>" /> 
 <? } ?>
 Banner URL: <input type="text" id="banner" name="banner" value="<? echo $banner->vars["banner"] ?>" /> <BR><BR>
 Banner URL: <input type="text" id="size" name="size" value="<? echo $banner->vars["size"] ?>" /> <BR><BR>
 Target / Link : <input type="text" id="link" name="link"  value="<? echo $banner->vars["link"] ?>" /> <BR><BR>
  <input type="submit" value="Save"/>
  </form>
 <BR><BR>
 

</div>

<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->im_allow("line_blocker")){ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="http://localhost:8080/ck/includes/js/jquery-1.8.0.min.js"></script>
<script type="text/javascript" src="http://localhost:8080/ck/includes/js/sweetalert.min.js"></script>
<link rel="stylesheet" href="http://localhost:8080/includes/shadowbox/shadowbox.css" type="text/css" media="screen" />
<script type="text/javascript" src="http://localhost:8080/includes/shadowbox/shadowbox.js"></script>
<script type="text/javascript">
Shadowbox.init();
</script>

<title>Agent Period Blocker</title>

</head>

<?

 $edit = false;
 $name="";
 if (isset($_POST["agent"])){
	$name = $_POST["agent"];
 }
 else{
	if (isset($_GET["id"])){
		$edit = true;	
		$name = $_GET["name"];
	}
 }
 ?>

<body>
<? include "../includes/header.php" ?>
<? include "../includes/menu_ck.php" ?>
<div class="page_content" style="padding-left:50px;">
<div align="right"><span ><a href="./agent_period_blocker.php">Back</a></span></div>	
<span class="page_title"><? if($edit) { echo "EDIT:  ".$_GET["name"]; } else { echo " Add New Agent "; } ?></span><br /><br />


<br /><br />
<? include "includes/print_error.php" ?> 

<?
 if ($edit){
	 $data = "id=".$_GET["id"]."&name=".$name;
  }
  else{
	  if (isset($_POST["agent"])){ 
      $data = "name=".$name;
	  }else{
	    $data="";
	  }
  }
 

?>

<?
//echo "http://www.sportsbettingonline.ag/utilities/process/reports/vrb_agent_period_blocker_create.php?".$data;
 echo file_get_contents("http://www.sportsbettingonline.ag/utilities/process/reports/vrb_agent_period_blocker_create.php?".$data); ?>

</div>
<? include "../includes/footer.php" ?>
<? }else{echo "Access Denied";} ?>
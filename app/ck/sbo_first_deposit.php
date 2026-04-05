<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->im_allow("first_deposit")){ ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/style.css" rel="stylesheet" type="text/css" />
<title>SBO First Deposits</title>
<link rel="stylesheet" type="text/css" media="all" href="../includes/calendar/jsDatePick_ltr.min.css" />
<link rel="stylesheet" href="http://localhost:8080/includes/shadowbox/shadowbox.css" type="text/css" media="screen" />
<script type="text/javascript" src="http://localhost:8080/includes/shadowbox/shadowbox.js"></script>
<script type="text/javascript">
Shadowbox.init();
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
<div class="page_content" style="padding-left:10px;">
<span class="page_title">SBO First Deposits</span><br /><br />

<? include "includes/print_error.php" ?>

<?
$from = clean_get("from");
if($from == ""){$from = date("Y-m-d");}
$to = clean_get("to");
if($to == ""){$to = date("Y-m-d");}
$agent = clean_get("agent_list");
?>


<? 
$data = "?from=$from&to=$to&af=$agent";

echo file_get_contents("http://www.sportsbettingonline.ag/utilities/process/reports/vrb_first_deposit.php".$data); 

/*
 $content = @file_get_contents("http://www.sportsbettingonline.ag/utilities/process/reports/vrb_first_deposit.php".$data); 
	
	 if($content === FALSE) { ?>
	   <span> At this moment the Database is doing a Syncronization, Please check again this Page in 2 minutes</span>
	<? } else {
	 
	 echo $content; 
	 }
 */	 
?>	 


</div>
<? include "../includes/footer.php" ?>
<? }else{echo "Acces Denied";} ?>
<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->im_allow("sbo_banking")){ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/style.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" media="all" href="../includes/calendar/jsDatePick_ltr.min.css" />
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
<title>SBO Banking Report</title>

</head>
<body>
<? include "../includes/header.php" ?>
<? include "../includes/menu_ck.php" ?>
<div class="page_content" style="padding-left:20px;">
<span class="page_title">SBO Banking Report</span><br /><br />
<? include "includes/print_error.php" ?> 


<?
$from = $_POST["from"];
$to = $_POST["to"];
if($to == ""){$to = date("Y-m-d");}
$method = $_POST["methods_list"];
$type = $_POST["type"];
$search = $_POST["search"];
$archived = $_POST["arch"];
?>
 
<? 
if($_GET["un"]){
	echo file_get_contents("http://www.sportsbettingonline.ag/utilities/process/reports/vrb_sbo_banking_unassign.php"); 
}else{
	echo file_get_contents("http://www.sportsbettingonline.ag/utilities/process/reports/vrb_sbo_banking_report.php?from=$from&to=$to&mt=$method&type=$type&search=$search&arch=$archived"); 
}

?>

</div>
<? include "../includes/footer.php" ?>
<? }else{echo "Access Denied";} ?>
<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->im_allow("cc_system")){ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../../css/style.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" media="all" href="../../includes/calendar/jsDatePick_ltr.min.css" />
<script type="text/javascript" src="../../includes/calendar/jsDatePick.min.1.3.js"></script>
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
<title>Credit Card Deny Report</title>

</head>
<body>
<? include "../../includes/header.php" ?>
<? include "../../includes/menu_ck.php" ?>
<div class="page_content" style="padding-left:20px;">
<span class="page_title">Credit Card Descriptor Report</span><br /><br />
<? include "../includes/print_error.php" ?> 


<?
$from = $_GET["from"];
if($from == ""){$from = date("Y-m-d");}
$to = $_GET["to"];
if($to == ""){$to = date("Y-m-d");}
?>
 
<? echo file_get_contents("http://cashier.vrbmarketing.com/admin/cc_descriptor_report.php?c=2002&p=PRXniq92iewoie2112ias&nosearch=1&pfrom=$from&pto=$to&status=fa&approved=NULL&confirmed=NULL&inserted=NULL&account=&send=Submit&static=1&show_reasons=1&".$_SERVER['QUERY_STRING']); ?>

</div>
<? include "../../includes/footer.php" ?>
<? }else{echo "Access Denied";} ?>
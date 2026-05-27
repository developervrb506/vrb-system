<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->im_allow("sbo_winners")){ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/style.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="<?= BASE_URL ?>/includes/shadowbox/shadowbox.css" type="text/css" media="screen" />
<script type="text/javascript" src="<?= BASE_URL ?>/includes/shadowbox/shadowbox.js"></script>
<script type="text/javascript">
Shadowbox.init();
</script>
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
<title>SBO Winners</title>

</head>
<body>
<? include "../includes/header.php" ?>
<? include "../includes/menu_ck.php" ?>
<div class="page_content" style="padding-left:20px;">
<span class="page_title">SBO Winners</span><br /><br />
<? include "includes/print_error.php" ?> 


<?
$from = $_GET["from"];
$to = $_GET["to"];
if($to == ""){$to = date("Y-m-d",time()-86400);}
if($from == ""){$from = date("Y-m-d",time()-86400);}
$search = $_GET["search"];
$amount = $_GET["amount"];
if(!is_numeric($amount)){$amount = "100";}
$type = $_GET["type"];
?>
 
<? 
echo file_get_contents("http://www.sportsbettingonline.ag/utilities/process/reports/vrb_sbo_winners.php?from=$from&to=$to&am=$amount&search=$search&type=$type"); 

?>

</div>
<? include "../includes/footer.php" ?>
<? }else{echo "Access Denied";} ?>
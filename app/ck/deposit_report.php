<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->im_allow("last_deposit_report")){ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../process/js/functions.js"></script>
<title>SBO Deposit Report</title>

</head>
<body>
<? include "../includes/header.php" ?>
<? include "../includes/menu_ck.php" ?>
<div class="page_content" style="padding-left:20px;">
<span class="page_title">SBO Deposit Report</span><br /><br />
<? include "includes/print_error.php" ?> 


<?
$player = $_POST["player"];
$search = $_POST["search"];
?>
 
<? 
echo file_get_contents("http://www.sportsbettingonline.ag/utilities/process/reports/vrb_deposit_report.php?player=$player&search=$search"); 

?>

</div>
<? include "../includes/footer.php" ?>
<? }else{echo "Access Denied";} ?>
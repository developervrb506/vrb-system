<? include(ROOT_PATH . "/ck/process/security.php"); ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../../css/style.css" rel="stylesheet" type="text/css" />
<title>Owed Report</title>
</head>
<body>
<? include "../../includes/header.php" ?>
<? include "../../includes/menu_ck.php" ?>
<div class="page_content" style="padding-left:10px;">
<span class="page_title">Owed Report</span><br /><br />

<? include "../includes/print_error.php" ?>

<?
$type = param("type");
?>


<? 
$data = "?type=$type";
echo file_get_contents("http://www.sportsbettingonline.ag//utilities/process/reports/cashier_owed_report.php".$data); 
?>


</div>
<? include "../../includes/footer.php" ?>
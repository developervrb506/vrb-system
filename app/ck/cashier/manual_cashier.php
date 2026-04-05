<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->im_allow("manual_cashier")){ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../../css/style.css" rel="stylesheet" type="text/css" />
<title>Manual Cashier</title>
</head>
<body>
<? include "../../includes/header.php" ?>
<? include "../../includes/menu_ck.php" ?>
<div class="page_content" style="padding-left:10px;">
<span class="page_title">Manual Cashier</span><br /><br />

<? include "../includes/print_error.php" ?>

<?
$type = param("type");
$account = param("account");
?>


<? 
$data = "?type=$type&account=$account";
echo file_get_contents("http://www.sportsbettingonline.ag//utilities/process/reports/manual_cashier.php".$data);
?>


</div>
<? include "../../includes/footer.php" ?>
<? }else{echo "Access Denied";} ?>
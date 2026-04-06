<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->im_allow("profitablity_deposit")){ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/style.css" rel="stylesheet" type="text/css" />
<title>Profitablity by Deposit Method</title>
<link rel="stylesheet" href="<?= BASE_URL ?>/includes/shadowbox/shadowbox.css" type="text/css" media="screen" />
<script type="text/javascript" src="<?= BASE_URL ?>/includes/shadowbox/shadowbox.js"></script>
<script type="text/javascript">
Shadowbox.init();
</script>


</head>
<body>
<? //$page_style = " width:3200px;"; ?>
&nbsp;
<? include "../includes/header.php" ?>
<? include "../includes/menu_ck.php" ?>
<div class="page_content" style="padding-left:20px;">
<span class="page_title">Profitablity by Deposit Method</span><br /><br />

<? include "includes/print_error.php" ?>
<?
  echo file_get_contents("http://www.sportsbettingonline.ag/utilities/process/reports/vrb_profitablity_deposit_method.php"); ?>
  </div>


<? include "../includes/footer.php" ?>
<? }else{echo "Access Denied";} ?>
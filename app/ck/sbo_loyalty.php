<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->im_allow("sbo_loyalty")){ ?>
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

<title>SBO Loyalty Program</title>

</head>
<body>
<? include "../includes/header.php" ?>
<? include "../includes/menu_ck.php" ?>
<div class="page_content" style="padding-left:50px;">
<span class="page_title">SBO Loyalty Program</span><br /><br />

<a href="http://www.sportsbettingonline.ag/utilities/jobs/loyalty/" class="normal_link"  rel="shadowbox;height=400;width=350" title="Running Loyalty Program Job">
	Run Job Manually
</a>
&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;
<a href="sbo_loyalty_insert.php" rel="shadowbox;height=200;width=350" class="normal_link" title="New Loyal Player">
	Insert Player
</a>
&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;
<a href="sbo_loyalty_percentages.php" class="normal_link">
	Percentages
</a>

<br /><br />
<? include "includes/print_error.php" ?> 

 
<? echo file_get_contents("http://www.sportsbettingonline.ag/utilities/process/reports/vrb_sbo_loyalty.php"); ?>

</div>
<? include "../includes/footer.php" ?>
<? }else{echo "Access Denied";} ?>
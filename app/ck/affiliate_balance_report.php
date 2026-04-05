<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->im_allow("affiliate_balance")){ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/style.css" rel="stylesheet" type="text/css" />
<title>Affiliate Balance Report</title>
<link rel="stylesheet" href="http://localhost:8080/includes/shadowbox/shadowbox.css" type="text/css" media="screen" />
<script type="text/javascript" src="http://localhost:8080/includes/shadowbox/shadowbox.js"></script>
<script type="text/javascript">
Shadowbox.init();
</script>

</head>
<body>
<? include "../includes/header.php"  ?>
<? include "../includes/menu_ck.php"  ?>
<?
	ini_set('memory_limit', '-1');
    set_time_limit(0);
?>
<div class="page_content" style="padding-left:10px;">
<span class="page_title">Affiliate Balance Report</span>

<? include "includes/print_error.php" ?>

<? echo file_get_contents("http://www.sportsbettingonline.ag/utilities/process/reports/vrb_affliate_balance_report.php") ?> 


</div>
</body>
<? include "../includes/footer.php" ?>
<? }else{echo "Acces Denied";} ?>
<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->im_allow("props_system")) {

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/style.css" rel="stylesheet" type="text/css" />

<title>Periods</title>
<script type="text/javascript" src="http://www.sportsbettingonline.ag/utilities/js/validate.js?exp_date=20190716"></script>
<script type="text/javascript" src="http://www.vrbmarketing.com/ck/includes/js/jquery-1.8.0.min.js"></script>


</head>
<body style="background:#fff; padding:20px;">


<span class="page_title">Periods</span><br /><br />
<? include "includes/print_error.php" ?>
<div class="form_box">




<? echo file_get_contents("http://www.sportsbettingonline.ag/utilities/process/reports/create_periods_data.php?base=".param('base')."&main=".param('main')); ?>

</div>

<? include "../includes/footer.php" ?>

<? } ?>

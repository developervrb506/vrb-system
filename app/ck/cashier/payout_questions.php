<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->im_allow("cashier_payout_report")){ ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../../css/style.css" rel="stylesheet" type="text/css" />
</head>
<body>
<div class="page_content" style="padding:10px;">
<strong>Payout Questions</strong><br /><br />
<script type="text/javascript" src="../../process/js/functions.js?v=2"></script>

<? echo file_get_contents("http://cashier.vrbmarketing.com/admin/payout_questions.php?c=2002&p=PRXniq92iewoie2112ias&".$_SERVER['QUERY_STRING']); ?>


<? }else{echo "Access Denied";} ?>
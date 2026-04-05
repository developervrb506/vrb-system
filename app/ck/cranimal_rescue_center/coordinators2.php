<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->im_allow("cranimal_rescue_center")){ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../../css/style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="/ck/includes/js/sortables.js"></script>
<title>Coordinators</title>
<link rel="stylesheet" href="/includes/shadowbox/shadowbox.css" type="text/css" media="screen" />
<script type="text/javascript" src="/includes/shadowbox/shadowbox.js"></script>
<script type="text/javascript">
Shadowbox.init();
</script>
<script type="text/javascript" src="/ck/cranimal_rescue_center/js/scripts.js"></script>
</head>
<body>
<? $page_style = " width:2000px;"; ?>
<? include "../../includes/header.php" ?>
<? include "../../includes/menu_ck.php" ?>

<?
$start_date = $_POST['start_date'];
$dietary_type = param('dietary_type');
$payment_status = param('payment_status');
$status = param('status');

$search_criterias = "&start_date=".$start_date."&dietary_type=".$dietary_type."&payment_status=".$payment_status."&status=".$status;
?>

<div class="page_content" style="padding-left:10px;">
<? $data = "&cid=".$current_clerk->vars['id']."&clerk=".str_replace(" ","_",$current_clerk->vars['name'])."&pg=i"; ?>
<? //echo file_get_contents("URL del sitio/page.php?&p=LPasjuY65FTq3Qpld1sadm0O0I8".$_SERVER['QUERY_STRING']); ?>
<? echo @file_get_contents("http://www.costaricaanimalrescuecenter.org/utilities/ui/coordinators/list.php?&p=LPasjuY65FTq3Qpld1sadm0O0I8".$_SERVER['QUERY_STRING'].$data.$search_criterias); ?>

</div>
<? include "../../includes/footer.php" ?>
<? }else{echo "Access Denied";} ?>
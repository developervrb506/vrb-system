<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->im_allow("rescue_center")){ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../../css/style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="/ck/includes/js/sortables.js"></script>
<script type="text/javascript" src="/ck/rescue_center/js/scripts.js"></script>
<link rel="stylesheet" href="/includes/shadowbox/shadowbox.css" type="text/css" media="screen" />
<script type="text/javascript" src="/includes/shadowbox/shadowbox.js"></script>
<script type="text/javascript">
Shadowbox.init();
</script>
<title>Current Volunteers Report</title>
</head>
<body>
<? $page_style = " width:2000px;"; ?>
<? include "../../includes/header.php" ?>
<? include "../../includes/menu_ck.php" ?>
<?

$from = $_POST['from'];
$to =  $_POST['to'];

if($from == ""){ $from = date("Y-m-d") ; $to = $from;}

$search_criterias = "&from=".$from."&to=".$to;
?>
<div class="page_content" style="padding-left:10px;">
<? echo @file_get_contents("https://www.rescuecenter.com/utilities/ui/reports/current_volunteers_report.php?&p=LPasjuY65FTq3Qpld1sadm0O0I8".$_SERVER['QUERY_STRING'].$search_criterias); ?>

</div>
<? include "../../includes/footer.php" ?>
<? }else{echo "Access Denied";} ?>
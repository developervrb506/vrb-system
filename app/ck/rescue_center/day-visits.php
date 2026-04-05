<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->im_allow("rescue_center")){ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" id="myhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../../css/style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="/ck/includes/js/sortables.js"></script>
<title>Day Visits</title>
<link rel="stylesheet" href="/includes/shadowbox/shadowbox.css" type="text/css" media="screen" />
<script type="text/javascript" src="/includes/shadowbox/shadowbox.js"></script>
<script type="text/javascript">
Shadowbox.init();
</script>
<script type="text/javascript" src="/ck/rescue_center/js/scripts.js"></script>

<script type="text/javascript" src="/ck/includes/js/jquery-1.9.1.js"></script>
<!-- For draggable -->
<script src="/ck/includes/js/jquery-ui.js"></script>
<script src="/ck/includes/js/scrollbar-top.js"></script>
<link href="/css/scrollbar.css" rel="stylesheet" type="text/css" />

</head>
<body>
<? $page_style = " width:2700px;"; ?>
<? include "../../includes/header.php" ?>
<? include "../../includes/menu_ck.php" ?>

<div id="wrapper1" class="draggable">
    <div id="div1"></div>
</div>

<?
$visit_date_from = $_POST['visit_date_from'];
$visit_date_to = $_POST['visit_date_to'];
$payment_type = param('payment_type');
$payment_status = param('payment_status');
$status = param('status');
$include_meal = param('include_meal');
$completed = param('completed');
$id_list = param('id_list');

$search = $_POST['search_criteria'];
$search = str_replace(" ","%--%",$search);

$show_all = param('show_all');

//$pagenumber = $_POST["pageno"];
$pagenumber = param('pageno');

if(isset($pagenumber) and !empty($pagenumber)){
	$pagenumber = "&pagenumber=".$pagenumber;
}else{
	$pagenumber = "";
}

$search_criterias = "&visit_date_from=".$visit_date_from."&visit_date_to=".$visit_date_to."&payment_type=".$payment_type."&payment_status=".$payment_status."&status=".$status."&include_meal=".$include_meal."&completed=".$completed."&id_list=".$id_list."&search=".$search."&show_all=".$show_all;

?>
<div class="page_content" style="padding-left:10px;" id="container" class='table-container'>
<? $data = "&cid=".$current_clerk->vars['id']."&clerk=".str_replace(" ","_",$current_clerk->vars['name'])."&pg=dv"; ?>
<? echo file_get_contents("https://www.rescuecenter.com/utilities/ui/day-visits/list.php?p=LPasjuY65FTq3Qpld1sadm0O0I8".$_SERVER['QUERY_STRING'].$data.$search_criterias.$pagenumber); ?>

</div>

<script src="/ck/includes/js/scrollbar-bottom.js"></script>

<? include "../../includes/footer.php" ?>
<? }else{echo "Access Denied";} ?>
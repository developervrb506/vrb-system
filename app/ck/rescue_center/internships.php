<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->im_allow("rescue_center")){ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" id="myhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../../css/style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="/ck/includes/js/sortables.js"></script>
<title>Internships</title>
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
<? $page_style = " width:3000px;"; ?>
<? include "../../includes/header.php" ?>
<? include "../../includes/menu_ck.php" ?>

<div id="wrapper1" class="draggable">
    <div id="div1"></div>
</div>

<?
$start_date = $_POST['start_date'];
$end_date   = $_POST['end_date'];
$dietary_type = param('dietary_type');
$payment_type = param('payment_type');
$payment_status = param('payment_status');
$status = param('status');
$completed = param('completed');
$id_list = param('id_list');
//$promo_code = param('promo_code');
$promo_code = $_POST['promo_code'];
$promo_code =  str_replace(" ","%--%",$promo_code);

$hear = $_POST['hear'];
$hear =  str_replace(" ","%--%",$hear);

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

$search_criterias = "&start_date=".$start_date."&end_date=".$end_date."&dietary_type=".$dietary_type."&payment_type=".$payment_type."&payment_status=".$payment_status."&status=".$status."&promo_code=".$promo_code."&hear=".$hear."&completed=".$completed."&id_list=".$id_list."&search=".$search."&show_all=".$show_all;

?>
<div class="page_content table-container" style="padding-left:10px;" id="container">
<? $data = "&cid=".$current_clerk->vars['id']."&clerk=".str_replace(" ","_",$current_clerk->vars['name'])."&pg=i"; ?>

<? echo file_get_contents("https://www.rescuecenter.com/utilities/ui/internships/list.php?p=LPasjuY65FTq3Qpld1sadm0O0I8".$_SERVER['QUERY_STRING'].$data.$search_criterias.$pagenumber); ?>

</div>

<script src="/ck/includes/js/scrollbar-bottom.js"></script>

<? include "../../includes/footer.php" ?>
<? }else{echo "Access Denied";} ?>
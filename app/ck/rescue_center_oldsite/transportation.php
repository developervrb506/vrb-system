<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->im_allow("rescue_center_oldsite")){ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../../css/style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="/ck/includes/js/sortables.js"></script>
<title>Transportation</title>
<link rel="stylesheet" href="/includes/shadowbox/shadowbox.css" type="text/css" media="screen" />
<script type="text/javascript" src="/includes/shadowbox/shadowbox.js"></script>
<script type="text/javascript">
Shadowbox.init();
</script>
<script type="text/javascript" src="/ck/rescue_center/js/scripts.js"></script>
</head>
<body>
<? $page_style = " width:1300px;"; ?>
<? include "../../includes/header.php" ?>
<? include "../../includes/menu_ck.php" ?>
<?
$payment_status = param('payment_status');
$status = param('status');
$id_list = param('id_list');
$search = $_POST['search_criteria'];
$search = str_replace(" ","%--%",$search);

$show_all = param('show_all');

$pagenumber = $_POST["pageno"];

if(isset($pagenumber) and !empty($pagenumber)){
	$pagenumber = "&pagenumber=".$pagenumber;
}else{
	$pagenumber = "";
}

$search_criterias = "&payment_status=".$payment_status."&status=".$status."&id_list=".$id_list."&search=".$search."&show_all=".$show_all;  
?>
<div class="page_content" style="padding-left:10px;">
<? $data = "&cid=".$current_clerk->vars['id']."&clerk=".str_replace(" ","_",$current_clerk->vars['name'])."&pg=tra"; ?>
<? //echo file_get_contents("URL del sitio/page.php?&p=LPasjuY65FTq3Qpld1sadm0O0I8".$_SERVER['QUERY_STRING']); ?>
<? echo file_get_contents("http://www.rescuecenter.com/oldsite/admin/transportation.php?p=LPasjuY65FTq3Qpld1sadm0O0I8".$_SERVER['QUERY_STRING'].$data.$search_criterias.$pagenumber); ?>

</div>
<? include "../../includes/footer.php" ?>
<? }else{echo "Access Denied";} ?>
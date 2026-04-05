<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->im_allow("cranimal_rescue_center")){ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../../css/style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="/ck/includes/js/sortables.js"></script>
<title>Manual Reviews</title>
<link rel="stylesheet" href="/includes/shadowbox/shadowbox.css" type="text/css" media="screen" />
<script type="text/javascript" src="/includes/shadowbox/shadowbox.js"></script>
<script type="text/javascript">
Shadowbox.init();
</script>
<script type="text/javascript" src="/ck/cranimal_rescue_center/js/scripts.js"></script>
</head>
<body>
<? $page_style = " width:1100px;"; ?>
<? include "../../includes/header.php" ?>
<? include "../../includes/menu_ck.php" ?>
<div class="page_content" style="padding-left:10px;">

<h1>Manual Reviews</h1>
<?
$show_all = param('show_all');
$id  = $_GET["id"]; 
$add = $_GET["add"];
$pagenumber = $_POST["pageno"]; 

if(isset($id) and !empty($id)){
	$id = "&id=".$id;
}else{
	$id = "";
}

if(isset($add)){
	$add = "&add=1";
}else{
	$add = "";
}

if(isset($pagenumber) and !empty($pagenumber)){
	$pagenumber = "&pagenumber=".$pagenumber;
}else{
	$pagenumber = "";
}
$search_criterias = "&show_all=".$show_all;
?>
<? echo @file_get_contents("http://www.costaricaanimalrescuecenter.org/utilities/ui/reviews/manual-reviews.php?&p=LPasjuY65FTq3Qpld1sadm0O0I8".$_SERVER['QUERY_STRING'].$id.$add.$search_criterias.$pagenumber); ?>
</div>
<? include "../../includes/footer.php" ?>
<? }else{echo "Access Denied";} ?>
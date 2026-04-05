<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->im_allow("rescue_center")){ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Pictures x Page</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../../../css/style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="/ck/includes/js/sortables.js"></script>
<link rel="stylesheet" href="/includes/shadowbox/shadowbox.css" type="text/css" media="screen" />
<script type="text/javascript" src="/includes/shadowbox/shadowbox.js"></script>
<script type="text/javascript">
Shadowbox.init();
</script>
</head>
<body>
<? $page_style = " width:1200px;"; ?>
<? include "../../../includes/header.php" ?>
<? include "../../../includes/menu_ck.php" ?>
<div class="page_content" style="padding-left:10px;">
<h1>Pictures x Page</h1>
<?
$id   = $_GET["id"]; 
$add  = $_GET["add"];
$page = param("page");  
$pagenumber = param("pageno");

if(isset($pagenumber) and !empty($pagenumber)){
	$pagenumber = "&pagenumber=".$pagenumber;
}else{
	$pagenumber = "";
}

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

if(isset($page) and !empty($page)){
	$page = "&page=".$page;
}else{
	$page = "";
}

echo @file_get_contents("https://www.rescuecenter.com/utilities/ui/tools/pictures-pages/list.php?&p=LPasjuY65FTq3Qpld1sadm0O0I8".$_SERVER['QUERY_STRING'].$id.$add.$page.$pagenumber); ?>

</div>
<? include "../../../includes/footer.php" ?>
<? }else{echo "Access Denied";} ?>
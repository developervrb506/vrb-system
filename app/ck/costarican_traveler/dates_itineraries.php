<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->im_allow("costarican_traveler")){ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../../css/style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="/ck/includes/js/sortables.js"></script>
<title>Dates Itineraries</title>
</head>
<body>
<? include "../../includes/header.php" ?>
<? include "../../includes/menu_ck.php" ?>
<div class="page_content" style="padding-left:10px;">
<?
$id_it = $_GET["id_it"];
$id_date_cat = $_GET["id_date_cat"];  
$add = $_GET["add"]; 

if(isset($id_it) and !empty($id_it)and isset($id_date_cat) and !empty($id_date_cat)){
	$id = "&id_it=".$id_it."&id_date_cat=".$id_date_cat;
}else{
	$id = "";
}

if( isset($add) and isset($id_it)){
	$add = "&add=1&id_it=".$id_it;
}else{
	$add = "";
}

echo @file_get_contents("https://www.costaricantraveler.com/utilities/ui/itineraries/list-dates-categories.php?&p=LPasjuY65FTq3Qpld1sadm0O0I8".$_SERVER['QUERY_STRING'].$id.$add); ?>

</div>
<? include "../../includes/footer.php" ?>
<? }else{echo "Access Denied";} ?>
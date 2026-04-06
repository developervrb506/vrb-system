<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->im_allow("sbo_reload")){
	set_time_limit(0);
 ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/style.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="<?= BASE_URL ?>/includes/shadowbox/shadowbox.css" type="text/css" media="screen" />
<script type="text/javascript" src="<?= BASE_URL ?>/includes/shadowbox/shadowbox.js"></script>

<title>Conversion Report</title>

</head>
<body>
<? include "../includes/header.php" ?>
<? include "../includes/menu_ck.php" ?>
<div class="page_content" style="padding-left:10px;">
<span class="page_title">Conversion Report</span><br /><br />

<br />
<? include "includes/print_error.php" ?> 


<?
$book = $_GET["book"];
if ($book == "" ) {$book = "PBJ";}

?>
<? /*
<form action="reactivation_report.php" method="get">
 &nbsp; &nbsp;Book : <select name="book">
<option <? if ($book == "SBO") { echo ' selected="selected" ';} ?> value = "SBO">SBO</option>
<option <? if ($book == "PBJ") { echo ' selected="selected" ';} ?> value = "PBJ">PBJ</option>
<option <? if ($book == "OWI") { echo ' selected="selected" ';} ?> value = "OWI">OWI</option>

</select>
 &nbsp; &nbsp;<input type="submit" value="Submit" >
</form>
<br /><br />
*/ ?>
 
<? echo file_get_contents("http://www.sportsbettingonline.ag/utilities/process/reports/vrb_conversion_report.php?book=".$book); ?>

</div>
<? include "../includes/footer.php" ?>
<? }else{echo "Access Denied";} ?>
<? set_time_limit(600); ?>
<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->im_allow("affiliates_commission")){ ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/style.css" rel="stylesheet" type="text/css" />
<title>Affiliates Report</title>
<?php /*?><link rel="stylesheet" href="http://localhost:8080/includes/shadowbox/shadowbox.css" type="text/css" media="screen" />
<script type="text/javascript" src="http://localhost:8080/includes/shadowbox/shadowbox.js"></script>
<script type="text/javascript">
Shadowbox.init();
</script>
<?php */?>
<script type="text/javascript" src="http://localhost:8080/ck/includes/js/sortables.js"></script>
<link rel="stylesheet" type="text/css" media="all" href="../includes/calendar/jsDatePick_ltr.min.css" />
<script type="text/javascript" src="../includes/calendar/jsDatePick.min.1.3.js"></script>
<script type="text/javascript">
	window.onload = function(){
		new JsDatePick({
			useMode:2,
			target:"from",
			dateFormat:"%Y-%m-%d"
		});
		new JsDatePick({
			useMode:2,
			target:"to",
			dateFormat:"%Y-%m-%d"
		});
	};
</script>
</head>
<body>
<? $page_style = " width:2500px;"; ?>
<? include "../includes/header.php" ?>
<? include "../includes/menu_ck.php" ?>
<div class="page_content" style="padding-left:10px;">
<span class="page_title">Affiliates Report</span><br /><br />

<? include "includes/print_error.php" ?>

<?
$all_brands = get_all_affiliates_brands(true);
$brand = get_affiliates_brand(clean_get("brand"));
$saf = clean_get("saf");
$from = clean_get("from");
if($from == ""){$from = date("Y-m-d");}
$to = clean_get("to");
if($to == ""){$to = date("Y-m-d");}
$agent = clean_get("agent_list");
$sclerk = clean_get("clerk_list");
?>

<form method="post">
    From: 
    <input name="from" type="text" id="from" value="<? echo $from ?>" />
    &nbsp;&nbsp;&nbsp;&nbsp;
    To: 
    <input name="to" type="text" id="to" value="<? echo $to ?>" />
    &nbsp;&nbsp;&nbsp;&nbsp;
    Brand:
    <select name="brand" id="brand">
    <? foreach(get_all_affiliates_brands(true) as $cbrand){ ?>
    	<option value="<? echo $cbrand->vars["id"] ?>" <? if($cbrand->vars["id"] == $brand->vars["id"]){echo 'selected="selected"';} ?>><? echo $cbrand->vars["name"] ?></option>
    <? } ?>
    </select>
    &nbsp;&nbsp;&nbsp;&nbsp;
    AF: 
    <input name="saf" type="text" id="saf" value="<? echo $saf ?>" />
    <input type="submit" value="Search" />
</form>
<br />
<? 
$params = "?from=".$from."&to=".$to."&saf=".$saf;
?>
<div align="right">
	<a href="javascript:;" onclick="document.getElementById('xml_form').submit();" class="normal_link">
		Export
	</a>
</div>
<?

switch($brand->vars["id"]){
	case "1":
		//Wagerweb
		echo file_get_contents("http://localhost:8080/ck/ww_affiliates_commission_report.php$params");
	break;
	case "3":
		//SBO
		
		//echo file_get_contents("http://www.sportsbettingonline.ag/utilities/process/reports/vrb_affiliates_commission_report.php".$params);
		echo file_get_contents("http://www.sportsbettingonline.ag/utilities/process/reports/vrb_affiliates_commission_report.php".$params."&brand=3");
	break;
	case "6":
		//PBJ
		//echo file_get_contents("https://www.playblackjack.com/utilities/process/reports/vrb_affiliates_commission_report.php$params");
		echo file_get_contents("http://www.sportsbettingonline.ag/utilities/process/reports/vrb_affiliates_commission_report.php".$params."&brand=6");
	break;
	case "7":
		//OWI
		//echo file_get_contents("http://www.betowi.com/utilities/process/reports/vrb_affiliates_commission_report.php$params");
		echo file_get_contents("http://www.sportsbettingonline.ag/utilities/process/reports/vrb_affiliates_commission_report.php".$params."&brand=7");
	break;	
	case "8":
		//bitbet
		//echo file_get_contents("http://www.bitbet.com/utilities/process/reports/vrb_affiliates_commission_report.php$params");
		echo file_get_contents("http://www.sportsbettingonline.ag/utilities/process/reports/vrb_affiliates_commission_report.php".$params."&brand=8");
	break;	
	case "9":
		//Horse racing betting
		//echo file_get_contents("http://www.betlion365.com/utilities/process/reports/vrb_affiliates_commission_report.php$params");
	echo file_get_contents("http://www.sportsbettingonline.ag/utilities/process/reports/vrb_affiliates_commission_report.php".$params."&brand=9");	
	break;
		
	case "":
		//nothing
		echo "<br /><br />Select a range of dates and a brand.";
	break;
	default:
		echo "<br /><br />This report is not available for " . $brand->vars["name"];
}
?>


</div>
<? include "../includes/footer.php" ?>
<? }else{echo "Access Denied";} ?>
<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->im_allow("affiliate_leads")){ ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/style.css" rel="stylesheet" type="text/css" />
<title>Affiliates Leads</title>
<link rel="stylesheet" type="text/css" media="all" href="../includes/calendar/jsDatePick_ltr.min.css" />
<script type="text/javascript" src="../includes/calendar/jsDatePick.min.1.3.js"></script>
<script type="text/javascript">
	window.onload = function(){
		new JsDatePick({
			useMode:2,
			target:"from_contact",
			dateFormat:"%Y-%m-%d"
		});
		new JsDatePick({
			useMode:2,
			target:"to_contact",
			dateFormat:"%Y-%m-%d"
		});
		new JsDatePick({
			useMode:2,
			target:"from_cb",
			dateFormat:"%Y-%m-%d"
		});
		new JsDatePick({
			useMode:2,
			target:"to_cb",
			dateFormat:"%Y-%m-%d"
		});
	};
	function show_callbacks(){
		document.getElementById("from_cb").value = "2013-01-01";
		document.getElementById("search_form").submit();	
	}
</script>
<link rel="stylesheet" href="http://localhost:8080/includes/shadowbox/shadowbox.css" type="text/css" media="screen" />
<script type="text/javascript" src="http://localhost:8080/includes/shadowbox/shadowbox.js"></script>
<script type="text/javascript">
Shadowbox.init();
</script>
<script type="text/javascript" src="../process/js/functions.js"></script>
</head>
<body>
<? $page_style = " width:100%;"; ?>
<? $no_select = true; include "../includes/header.php" ?>
<? include "../includes/menu_ck.php" ?>
<div class="page_content" style="padding-left:10px;"  onmouseover="deselect()">
<!--<span class="page_title">Affiliates Leads</span><br /><br />-->

<? include "includes/print_error.php" ?>

<?

$report_line1 = "";
$report_line2 = "";
$report_line3 = "";
$name = clean_get("name");
$web = clean_get("web");
$email = clean_get("email");
$phone = clean_get("phone");
$country = clean_get("country");
$from_contact = clean_get("from_contact");
$to_contact = clean_get("to_contact");
$from_cb = clean_get("from_cb");
$to_cb = clean_get("to_cb");
$owner = clean_get("owner");
$status = clean_get("status");
$disposition = clean_get("disposition");
$plan = clean_get("plan");
$ww = clean_get("ww");
$sbo = clean_get("sbo");
$p_method = clean_get("p_method");
$type = clean_get("type");
$level = clean_get("level");
$statuses = get_all_afleads_status();
$dispositions = get_all_afleads_dispositions();
$owners = get_all_afleads_owners();
?>

<a href="new_affiliates_lead.php" class="normal_link">Add New Lead +</a>

<? if(!isset($_POST["name"])){ ?>
    &nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;
    <a href="javascript:;" class="normal_link" onclick="display_div('search_box');">Search</a>
    <div id="search_box" class="form_box" style="display:none;">
<? }else{echo "<div  class='form_box'>";} ?>
<form method="post" action="affiliates_leads.php" id="search_form">

	<table width="100%" border="0" cellpadding="5" cellspacing="0">
      <tr>
        <td>Name:</td>
        <td><input name="name" type="text" id="name" value="<? echo $name ?>" /></td>
        <td>Web:</td>
        <td><input name="web" type="text" id="web" value="<? echo $web ?>" /></td>
        <td>Email:</td>
        <td><input name="email" type="text" id="email" value="<? echo $email ?>" /></td>
        <td>Phone:</td>
        <td><input name="phone" type="text" id="phone" value="<? echo $phone ?>" /></td>
      </tr>
      <tr>
        <td>Country:</td>
        <td><? create_list("country", "country", get_all_afleads_countries(), $country, "", "", "All") ?></td>
        <td>Owner:</td>
        <td><? create_list("owner", "owner", get_all_afleads_owners(), $owner, "", "", "All") ?></td>
        <td>Contacted From:</td>
        <td><input name="from_contact" type="text" id="from_contact" value="<? echo $from_contact ?>" /></td>
        <td>Contacted To:</td>
        <td><input name="to_contact" type="text" id="to_contact" value="<? echo $to_contact ?>" /></td>        
      </tr>
      <tr>
      <td>WW Af:</td>
      <td><input name="ww" type="text" id="ww" value="<? echo $ww ?>" /></td>
      <td>SBO Af:</td>
      <td><input name="sbo" type="text" id="sbo" value="<? echo $sbo ?>" /></td>
      <td>Payment Method:</td>
      <td><input name="p_method" type="text" id="p_method" value="<? echo $p_method ?>" /></td>
      </tr>
      <tr>        
        
        <td>Plan:</td>
        <td><? create_list("plan", "plan", get_all_afleads_plans(), $plan, "", "", "All") ?></td>
        <td>Call Back From:</td>
        <td><input name="from_cb" type="text" id="from_cb" value="<? echo $from_cb ?>" /></td>
        <td>Call Back To:</td>
        <td><input name="to_cb" type="text" id="to_cb" value="<? echo $to_cb ?>" /></td>
        </tr>
      <tr>
        <td>Status:</td>
        <td><? create_list("status", "status", $statuses, $status, "", "", "All") ?></td>
        <td>Disposition:</td>
        <td><? create_list("disposition", "disposition", $dispositions, $disposition, "", "", "All") ?></td>
        <td>Type:</td>
        <td><? create_list("type", "type", get_all_afleads_types(), $type, "", "", "All") ?></td>
        <td>Level:</td>
        <td><? $levels = array(array("id"=>"A","label"=>"A"),array("id"=>"B","label"=>"B"),array("id"=>"C","label"=>"C"),array("id"=>"D","label"=>"D"),array("id"=>"E","label"=>"E"),array("id"=>"F","label"=>"F")); ?>
          <? create_list("level", "level", $levels, $level, "", "", "All") ?></td>
        </tr>
      <tr>
        <td><input type="submit" value="Search" /></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
    </table>
</form>
</div>

<br />

<? 
if(isset($_POST["name"])){ 
	?><a href="affiliates_leads.php" class="normal_link">&lt;&lt; Back to Home Page</a><br /><br /><?
	if($current_clerk->im_allow("affiliate_leads_export")){ ?>
    <div align="right">
	<a href="javascript:;" onclick="document.getElementById('xml_form_1').submit();" class="normal_link">
	Export
	</a>
    </div>
    <? } 
	include("affiliates_leads_table.php");
}else{
	
	$leads = get_latest_contacted_afleads();
	echo "<pre>";
	//print_r($leads);
	echo "</pre>";
	?>
    
	
	
	<br /><span class="page_title">Recent Contacted</span>
	
	<?
	if($current_clerk->im_allow("affiliate_leads_export")){ ?>
    <div align="right">
	<a href="javascript:;" onclick="document.getElementById('xml_form_1').submit();" class="normal_link">
	Export
	</a>
    </div>
    <? } 
	include("affiliates_leads_table.php");
	
	$leads = get_callback_afleads($current_clerk->vars["id"]);
	?><br /><br /><span class="page_title">My Call Backs</span><?
	if($current_clerk->im_allow("affiliate_leads_export")){ ?>
      <div align="right">
	  <a href="javascript:;" onclick="document.getElementById('xml_form_2').submit();" class="normal_link">
	  Export
	  </a>
    </div>
    <? } 
	include("affiliates_leads_table.php");
	?><a href="javascript:;" onclick="show_callbacks()" class="normal_link">Show All Call Backs</a><?
	
	$leads = get_latest_contacted_afleads(11,10);
	?><br /><br /><span class="page_title">History</span><?
	if($current_clerk->im_allow("affiliate_leads_export")){ ?>
    <div align="right">
	<a href="javascript:;" onclick="document.getElementById('xml_form_3').submit();" class="normal_link">
	Export
	</a>
    </div>
    <? } 
	include("affiliates_leads_table.php");
	
	
}
?>

</div>
<form method="post" action="affiliates_leads_export.php" id="xml_form_1">
<input name="lines" type="hidden" id="lines" value="<? echo $report_line1 ?>">
</form>
<form method="post" action="affiliates_leads_export.php" id="xml_form_2">
<input name="lines" type="hidden" id="lines" value="<? echo $report_line2 ?>">
</form>
<form method="post" action="affiliates_leads_export.php" id="xml_form_3">
<input name="lines" type="hidden" id="lines" value="<? echo $report_line3 ?>">
</form>
<? include "../includes/footer.php" ?>
<? }else{echo "Access Denied";} ?>
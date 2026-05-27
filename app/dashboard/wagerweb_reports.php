<? include(ROOT_PATH . "/process/login/security.php"); ?>
<? require_once(ROOT_PATH . "/process/functions.php"); ?>
<? require_once(ROOT_PATH . "/includes/wagerweb/classes.php"); ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<script type="text/javascript" src="../process/js/functions.js?v=2"></script>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/style.css" rel="stylesheet" type="text/css" />
<title>WagerWeb Reports</title>
<link rel="stylesheet" type="text/css" media="all" href="../includes/calendar/jsDatePick_ltr.min.css" />
<link rel="stylesheet" href="<?= BASE_URL ?>/includes/shadowbox/shadowbox.css" type="text/css" media="screen" />
<script type="text/javascript" src="<?= BASE_URL ?>/includes/shadowbox/shadowbox.js"></script>
<script type="text/javascript">
Shadowbox.init();
</script>
<script type="text/javascript" src="../includes/calendar/jsDatePick.min.1.3.js"></script>
<script type="text/javascript">
	window.onload = function(){
		new JsDatePick({
			useMode:2,
			target:"from",
			dateFormat:"%m/%d/%Y"
		});
		new JsDatePick({
			useMode:2,
			target:"to",
			dateFormat:"%m/%d/%Y"
		});
	};
</script>
</head>
<body>
<? $page_style = " width:100%;"; ?>
<? include "../includes/header.php" ?>
<? include "../includes/menu.php" ?>
<div class="page_content" style="padding:0px;">
<? 
$report = $_GET["report"];

if (!isset($report)) {	
   $report = $_POST["report"];
}

$url = BASE_URL . '/dashboard/wagerweb_report_results.php';

$affiliate_code        = get_affiliate_code($_SESSION["aff_id"], 1);
//$affiliate_password  = get_affiliate_password($_SESSION["aff_id"], 1);
$affiliate_password    = md5($affiliate_code);
$params['affiliateID'] = $affiliate_code;
$params['password']    = $affiliate_password;
$manager = new FactoryManagerImpl();
$manager->send_session_to_manager('JasperManager',$params);

switch ($report) {
	
case 1:     
   ?>
   <div class="page_title" style="text-align:center;">Commissions</div>
   <br />
   <? 
   $data = "?report=1";
   break; 

case 2:     
   ?>
   <div class="page_title" style="text-align:center;">Daily Figures</div>
  <br />
  <? 
  if ($_POST) {	
    $period = $_POST['period'];
    $data = "?report=2&period=$period";	
  } 
  ?>  
  <div align="center">
   <form method="post">
    Period:     
    <select name="period" id="period">      
      <option value="thisWeek" <? if ($period == "thisWeek") { ?>selected="selected" <? } ?>>ThisWeek</option>
      <option value="lastWeek" <? if ($period == "lastWeek") { ?>selected="selected" <? } ?>>LastWeek</option>         
    </select>    
    <input name="report" type="hidden" id="report" value="2" />        
    <input type="submit" value="Search" />
   </form>
  </div>   
<? 
   break;
   
case 3:  
   ?>
   <div class="page_title" style="text-align:center;">Player Report</div>
   <br />     
   <? 
   $data = "?report=3";
   break;   	
   
case 4: ?>   
  <div class="page_title" style="text-align:center;">Payment Statement</div>
  <br />
  <? 
  if ($_POST) {	
    $period = $_POST['period'];
    $data = "?report=4&period=$period";	
  } 
  ?>  
  <div align="center">
   <form method="post">
    Period:     
    <select name="period" id="period">      
      <option value="OneWeek" <? if ($period == "OneWeek") { ?>selected="selected" <? } ?>>OneWeek</option>
      <option value="OneMonth" <? if ($period == "OneMonth") { ?>selected="selected" <? } ?>>OneMonth</option>
      <option value="ThreeMonth" <? if ($period == "ThreeMonth") { ?>selected="selected" <? } ?>>ThreeMonth</option>      
    </select>    
    <input name="report" type="hidden" id="report" value="4" />        
    <input type="submit" value="Search" />
   </form>
  </div>   
<? 
   break;
   
case 5: ?>   
   <div class="page_title" style="text-align:center;">Conversion Report</div>
   <br />
   <? 
   if ($_POST) {	
     $from = clean_str($_POST['from']);
	 $to   = clean_str($_POST['to']);	 
     $data = "?report=5&from=$from&to=$to";	
   } 
   ?>  
  <div align="center">
   <form method="post">
    From:     
    <input name="from" type="text" id="from" value="<? echo $from ?>" readonly="readonly" />    
    To:
    <input name="to" type="text" id="to" value="<? echo $to ?>" readonly="readonly" />
    <input name="report" type="hidden" id="report" value="5" />        
    <input type="submit" value="Search" />
   </form>
  </div>   
<? 
   break;

case 6: ?>
   <div class="page_title" style="text-align:center;">Player Deposits</div>
   <br />
   <? 
   if ($_POST) {	
     $period = clean_str($_POST['from']);
     $data = "?report=6&period=$period";	
   } 
   ?>  
  <div align="center">
   <form method="post">
    From:     
    <input name="from" type="text" id="from" value="<? echo $period ?>" readonly="readonly" />    
    <input name="report" type="hidden" id="report" value="6" />        
    <input type="submit" value="Search" />
   </form>
  </div>   
<? 
   break;             
}
?>
<table width="98%" align="center" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align="center">
     <div style="float:right;" class="normal_link"><a href="<?= BASE_URL ?>/dashboard/reports.php?bk=1"><strong><< Back</strong></a></div>
     <iframe src="<? echo $url ?><? echo $data ?>" name="iframe1" width="100%" height="10000" scrolling="auto" style="background-color:#FFFFFF" frameborder="0"></iframe>
    </td>
  </tr>
</table>
</div>
<? include "../includes/footer.php" ?>
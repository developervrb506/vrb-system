<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->im_allow("sbo_main_page")){ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/style.css" rel="stylesheet" type="text/css" />
<title>Casinos Win/Loss</title>
<link rel="stylesheet" href="http://localhost:8080/includes/shadowbox/shadowbox.css" type="text/css" media="screen" />
<script type="text/javascript" src="http://localhost:8080/includes/shadowbox/shadowbox.js"></script>
<script type="text/javascript">
Shadowbox.init();
</script>
<link rel="stylesheet" type="text/css" media="all" href="../includes/calendar/jsDatePick_ltr.min.css" />
<script type="text/javascript" src="../includes/calendar/jsDatePick.min.1.3.js"></script>
<script type="text/javascript">
	window.onload = function(){
		new JsDatePick({
			useMode:2,
			target:"date",
			dateFormat:"%Y-%m-%d"
		});
		new JsDatePick({
			useMode:2,
			target:"todate",
			dateFormat:"%Y-%m-%d"
		});
	};
</script>
<script type="text/javascript">

function fn_daily(){
	
var today = new Date();
var dd = today.getDate();
var mm = today.getMonth()+1; //January is 0!

var yyyy = today.getFullYear();
if(dd<10){dd='0'+dd} if(mm<10){mm='0'+mm}
today = yyyy+'-'+mm+'-'+dd;
document.getElementById("date").value = today;
document.getElementById("todate").value = today;

}

function fn_monthly(){
	

var date = new Date(), y = date.getFullYear(), m = date.getMonth();
var firstDay = new Date(y, m, 1);
var dd = firstDay.getDate();
var mm = firstDay.getMonth()+1; //January is 0!
var yyyy = firstDay.getFullYear();
if(dd<10){dd='0'+dd} if(mm<10){mm='0'+mm}
firstDay = yyyy+'-'+mm+'-'+dd;

document.getElementById("date").value = firstDay;

//var lastDay = new Date(y, m + 1, 0); 
var lastDay = new Date();
var dd = lastDay.getDate();
var mm = lastDay.getMonth()+1; //January is 0!
var yyyy = lastDay.getFullYear();
if(dd<10){dd='0'+dd} if(mm<10){mm='0'+mm}
lastDay = yyyy+'-'+mm+'-'+dd;

document.getElementById("todate").value = lastDay;

}

function fn_weekly(){
	
var curr = new Date; // get current date
var first = curr.getDate() - curr.getDay()+1; // First day is the day of the month - the day of the week
var last = first + 6; // last day is the first day + 6
var firstDay = new Date(curr.setDate(first));
var lastDay = new Date();


var date = new Date(), y = date.getFullYear(), m = date.getMonth();
var dd = firstDay.getDate();
var mm = firstDay.getMonth()+1; //January is 0!
var yyyy = firstDay.getFullYear();
if(dd<10){dd='0'+dd} if(mm<10){mm='0'+mm}
firstDay = yyyy+'-'+mm+'-'+dd;
document.getElementById("date").value = firstDay;


var dd = lastDay.getDate();
var mm = lastDay.getMonth()+1; //January is 0!
var yyyy = lastDay.getFullYear();
if(dd<10){dd='0'+dd} if(mm<10){mm='0'+mm}
lastDay = yyyy+'-'+mm+'-'+dd;
document.getElementById("todate").value = lastDay;

}


</script>
</head>
<body>
<? include "../includes/header.php" ?>
<? include "../includes/menu_ck.php" ?>
<div class="page_content" style="padding-left:20px;">
<span class="page_title">Casinos Win/Loss</span><br /><br />

<? include "includes/print_error.php" ?>
<? 

if($_GET["date"]==""){$date = date('Y-m-d',strtotime('monday this week'));}else{$date = $_GET["date"];} 
if($_GET["todate"]==""){$todate = date('Y-m-d');}else{$todate = $_GET["todate"];} 
?>
<form id="frm_dates" method="get">
From: 
<input name="date" type="text" id="date" value="<? echo $date ?>" readonly="readonly" /> 

To: 
<input name="todate" type="text" id="todate" value="<? echo $todate ?>" readonly="readonly" /> 

Agents: 
<select name="agents">
<?php /*?><option value="all">All</option><?php */?>
<option <? if ($_GET["agents"] == "postup"){ echo 'selected="selected"';} ?> value="postup">Postup</option>
<option <? if ($_GET["agents"] == "credit"){ echo 'selected="selected"';} ?>value="credit">Credit</option>
<option <? if ($_GET["agents"] == "pph"){ echo 'selected="selected"';} ?>value="pph">PPH</option>
<option <? if ($_GET["agents"] == "bitcoin"){ echo 'selected="selected"';} ?>value="bitcoin">Bitcoin</option>
<option <? if ($_GET["agents"] == "test"){ echo 'selected="selected"';} ?>value="test">Test</option>

</select>



<input type="submit" value="Search" /> &nbsp;&nbsp;&nbsp; 
<a href="javascript:fn_daily();" class="normal_link" >Daily</a>&nbsp;&nbsp; | 
<a href="javascript:fn_weekly();" class="normal_link" >Weekly</a>&nbsp;&nbsp; | 
<a href="javascript:fn_monthly();" class="normal_link" >Monthly</a>&nbsp;&nbsp;


</form>
<br /><br />

<? if (isset($_GET["date"])) { ?>
       
	<? 
	$agent = $_GET["agents"];
	$data = "?date=$date&todate=$todate&agents=$agent"; ?>
    <? echo file_get_contents("http://www.sportsbettingonline.ag/utilities/process/reports/vrb_casino_winloss.php".$data); ?>
    </div>
    <? } ?>

<? include "../includes/footer.php" ?>
<? }else{echo "Access Denied";} ?>
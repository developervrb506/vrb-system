<? set_time_limit(300); ?>
<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->im_allow("betting_basics")){ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/style.css" rel="stylesheet" type="text/css" />
<title>Daily Figures</title>
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
<? include "../includes/header.php" ?>
<? include "../includes/menu_ck.php" ?>
<div class="page_content" style="padding-left:20px;">
<span class="page_title">Daily Figures</span><br /><br />

<? include "includes/print_error.php" ?>
<? 
if($_GET["date"]==""){$date = date('Y-m-d',strtotime('monday this week'));}else{$date = get_monday($_GET["date"]);} 
$sunday = date("Y-m-d",strtotime($date." +6 days")); 

if($_GET["from"]!="" AND $_GET["to"]!=""){
  $from = $_GET["from"];
  $to = $_GET["to"];
  $date =  get_monday($from);
  $to_m = get_monday($to);
  $sunday = date("Y-m-d",strtotime($to_m." +6 days")); 
  $to = $sunday;
  $from = $date;

}
?>
<form action="betting_report_dailyfigures.php" method="get">
Week: <input name="date" type="text" id="date" value="<? echo $date ?>" readonly="readonly" /> <input type="submit" value="Search" />
</form>
<BR><BR>
<form action="betting_report_dailyfigures.php" method="get">
From <input id="from" name ="from" type="text" readonly="readonly" value="<? echo $from ?>" /> To :<input id="to" name ="to" type="text"  readonly="readonly" value="<? echo $to ?>" /><input type="submit" value="Search" />
<BR>

</form>
<br /><br />


<?
if($_GET['date'] != "" || $_GET['from'] != "" ) {
$agents = get_all_betting_agents();
$globals = array("pmts"=>0,"bow"=>0,"mon"=>0,"tue"=>0,"wed"=>0,"thu"=>0,"fri"=>0,"sat"=>0,"sun"=>0,"week"=>0,"bal"=>0);
$cols = array("pmts","bow","mon","tue","wed","thu","fri","sat","sun","week","bal");
$clickables = array("pmts","mon","tue","wed","thu","fri","sat","sun");
?>

<? foreach($agents as $agent){ ?>

<table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td class="table_header" colspan="12" title="<? echo $agent->vars["description"] ?>" style="cursor:pointer">
	  	<? echo $agent->vars["name"] ?>
      </td>
    </tr>
    <tr>
      <td class="table_header" align="center" width="110">ACC</td>
      <td class="table_header" align="center" width="8%">Pmts</td>
      <td class="table_header" align="center" width="8%">BOW</td>
      <td class="table_header" align="center" width="8%">Mon</td>
      <td class="table_header" align="center" width="8%">Tue</td>
      <td class="table_header" align="center" width="8%">wed</td>
      <td class="table_header" align="center" width="8%">thu</td>
      <td class="table_header" align="center" width="8%">fri</td>
      <td class="table_header" align="center" width="8%">sat</td>
      <td class="table_header" align="center" width="8%">sun</td>
      <td class="table_header" align="center" width="8%">WKLY</td>
      <td class="table_header" align="center" width="8%">BAL</td>
    </tr>
    <!--Accounts-->
    <?
	$i=0;
	 $accounts = get_all_betting_accounts_by_agent($agent->vars["id"],"1");
	 $totals = array("pmts"=>0,"bow"=>0,"mon"=>0,"tue"=>0,"wed"=>0,"thu"=>0,"fri"=>0,"sat"=>0,"sun"=>0,"week"=>0,"bal"=>0);
	//echo $date." --- ".$sunday;
   foreach($accounts as $acc){
		 if($i % 2){$style = "1";}else{$style = "2";}
		 $i++;		 
		 $bet_balances = $acc->get_weekly_bet_balances($date, $sunday);
	?>
    <tr>
        <td class="table_td<? echo $style ?>" align="center" title="<? echo $acc->vars["comment"] ?>" style="cursor:pointer"><? echo $acc->vars["name"] ; ?></td>
        <? foreach($cols as $col){ ?>
        <td class="table_td<? echo $style ?>" align="center">
			<?
			if(in_array($col,$clickables)){
				$url = "betting_report_day_detail.php?acc=".$acc->vars["id"]."&t=$col&date=$date&to=$to";
				echo_report_number(round($bet_balances[$col]),true,$url,650,400);
			}else{
				echo_report_number(round($bet_balances[$col]));
			}			
			$totals[$col] += $bet_balances[$col];
		 	$globals[$col] += $bet_balances[$col];
			?>
        </td>
        <? } ?>
    </tr>
    <? }//accounts ?>
    <!--Accounts-->
    <tr>
        <td class="table_td<? echo $style ?>" align="center" style="background:#E0D392"><strong>Totals</strong></td>
        <? foreach($cols as $col){ ?>
        <td class="table_td<? echo $style ?>" align="center" style="background:#E0D392"><strong><? echo_report_number(round($totals[$col])); ?></strong></td>
        <? } ?>                
    </tr>
    <tr>
      <td class="table_last"></td>
      <td class="table_last"></td>
      <td class="table_last"></td>
      <td class="table_last"></td>
      <td class="table_last"></td>
      <td class="table_last"></td>
      <td class="table_last"></td>
      <td class="table_last"></td>
      <td class="table_last"></td>
      <td class="table_last"></td>
      <td class="table_last"></td>
      <td class="table_last"></td>
    </tr>
</table><br /><br />

<? }//agents ?>

<table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td class="table_header" colspan="12">TOTALS</td>
    </tr>
    <tr>
      <td class="table_header" align="center" width="110"></td>
      <td class="table_header" align="center" width="8%">Pmts</td>
      <td class="table_header" align="center" width="8%">BOW</td>
      <td class="table_header" align="center" width="8%">Mon</td>
      <td class="table_header" align="center" width="8%">Tue</td>
      <td class="table_header" align="center" width="8%">wed</td>
      <td class="table_header" align="center" width="8%">thu</td>
      <td class="table_header" align="center" width="8%">fri</td>
      <td class="table_header" align="center" width="8%">sat</td>
      <td class="table_header" align="center" width="8%">sun</td>
      <td class="table_header" align="center" width="8%">WKLY</td>
      <td class="table_header" align="center" width="8%">BAL</td>
    </tr>
    <tr>
      <td class="table_td<? echo $style ?>" align="center" style="background:#E0D392"></td>
	  <? foreach($cols as $col){ ?>
        <td class="table_td<? echo $style ?>" align="center" style="background:#E0D392"><strong><? echo_report_number(round($globals[$col])); ?></strong></td>
        <? } ?>    
    </tr>
	<tr>
      <td class="table_last"></td>
      <td class="table_last"></td>
      <td class="table_last"></td>
      <td class="table_last"></td>
      <td class="table_last"></td>
      <td class="table_last"></td>
      <td class="table_last"></td>
      <td class="table_last"></td>
      <td class="table_last"></td>
      <td class="table_last"></td>
      <td class="table_last"></td>
    </tr>
</table><br /><br />

<? } ?>

</div>
<? include "../includes/footer.php" ?>
<? }else{echo "Access Denied";} ?>
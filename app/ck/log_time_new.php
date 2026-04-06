<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->im_allow("working_time_report")){ ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/style.css" rel="stylesheet" type="text/css" />
<title>Working Time Report</title>
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
<div class="page_content" style="padding-left:50px;">
<span class="page_title">Working Time Report</span><br /><br />

<? include "includes/print_error.php" ?>

<?
$from = clean_get("from");
if($from == ""){$from = date("Y-m-d");}
$to = clean_get("to");
if($to == ""){$to = date("Y-m-d");}
?>

<form method="post">
    From: 
    <input name="from" type="text" id="from" value="<? echo $from ?>" />
    &nbsp;&nbsp;&nbsp;&nbsp;
    To: 
    <input name="to" type="text" id="to" value="<? echo $to ?>" />
    &nbsp;&nbsp;&nbsp;&nbsp;
    <input type="submit" value="Search" />
</form>

<br />


<table width="300" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td class="table_header">Clerk</td>
    <td class="table_header" align="center">Time (Hours)</td>
    <td class="table_header" align="center">Breaks (Hours)</td>
  </tr>

<?
$clerks = get_all_clerks(1);
$i=0;
foreach($clerks as $ck){
    if($i % 2){$style = "1";}else{$style = "2";}	
	if(!$ck->vars["level"]->vars["is_admin"]){
		$i++;
    ?>
    <tr>
        <td class="table_td<? echo $style ?>"><? echo $ck->vars["name"]; ?></td>
        <td class="table_td<? echo $style ?>" align="center">
			<a href="log_time_details.php?clk=<? echo $ck->vars["id"]; ?>&f=<? echo $from ?>&t=<? echo $to ?>" class="normal_link" rel="shadowbox;height=500;width=600" title="<? echo $ck->vars["name"]; ?> Details">
				<? echo round($ck->time_logs_period($from, $to),1); ?>
            </a>
        </td>
        <td class="table_td<? echo $style ?>" align="center">
			<a href="log_time_details.php?clk=<? echo $ck->vars["id"]; ?>&f=<? echo $from ?>&t=<? echo $to ?>" class="normal_link" rel="shadowbox;height=500;width=600" title="<? echo $ck->vars["name"]; ?> Details">
				<? echo round($ck->break_time($from, $to),1); ?>
            </a>
        </td>
    </td>	
    <?
	}
}
?>
    <tr>
      <td class="table_last"></td>
      <td class="table_last"></td>
      <td class="table_last"></td>
    </tr>

</table>


</div>
<? include "../includes/footer.php" ?>
<? }else{echo "Access Denied";} ?>
<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->im_allow("working_time_report") || $current_clerk->vars["id"] == $_GET["clk"]){ ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/style.css" rel="stylesheet" type="text/css" />
</head>
<body style="padding:20px; background:#fff;">
<?
$clerk = get_clerk($_GET["clk"]);
$from = $_GET["f"];
$to = $_GET["t"];
?>
<span class="page_title">Working Time Report</span><br /><br />


<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td class="table_header">Day</td>
    <td class="table_header" align="center">Time (H:m:s)</td>
    <td class="table_header" align="center">Breaks (H:m:s)</td>
    <td class="table_header" align="center">Start Time</td>
    <td class="table_header" align="center">Finish Time</td>
  </tr>

<?
$current = date("Y-m-d",strtotime($from . " -1 day"));
$i=0;
while($current != $to){
	$current = date("Y-m-d",strtotime($current . " +1 day"));
    if($i % 2){$style = "1";}else{$style = "2";}
	$i++;
	$res = $clerk->time_log_per_day($current,true);
	$break = $clerk->break_time($current, $current);
    ?>
    <tr>
        <td class="table_td<? echo $style ?>"><? echo date("l, F jS",strtotime($current)); ?></td>
        <td class="table_td<? echo $style ?>" align="center"><? echo sec2hms($res["time"]*60*60); ?></td>
        <td class="table_td<? echo $style ?>" align="center">
			<a href="breaks_time_details.php?clk=<? echo $clerk->vars["id"] ?>&d=<? echo $current ?>" class="normal_link">
				<? echo sec2hms($break*60*60); ?>
            </a>
        </td>
        <td class="table_td<? echo $style ?>" align="center">
			<? if($res["start"] != ""){echo date("g:i a",strtotime($res["start"]));}else{echo "-";} ?>
        </td>
        <td class="table_td<? echo $style ?>" align="center">
			<? if($res["end"] != ""){echo date("g:i a",strtotime($res["end"]));}else{echo "-";} ?>
        </td>
    </td>	
    <?
}
?>
    <tr>
      <td class="table_last"></td>
      <td class="table_last"></td>
      <td class="table_last"></td>
      <td class="table_last"></td>
      <td class="table_last"></td>
    </tr>

</table>


</div>
<? }else{echo "Acces Denied";} ?>
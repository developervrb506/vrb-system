<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->im_allow("all_schedules")){ ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/style.css" rel="stylesheet" type="text/css" />
<title>Late Report</title>
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
<? include "../includes/header.php" ?>
<? include "../includes/menu_ck.php" ?>
<div class="page_content" style="padding-left:20px;">
<span class="page_title">Late Report</span><br /><br />

<? include "includes/print_error.php" ?>

<?
$from = clean_get("from");
if($from == ""){$from = date("Y-m-d");}
$from = get_monday($from);
$to = clean_get("to");
if($to == ""){$to = date("Y-m-d");}
$clerk = clean_get("clerk");
$group = clean_get("group");
$minutes = clean_get("minutes");
if(!is_numeric($minutes)){$minutes = "5";}

$schedules = get_all_schedules_by_date($from,$to,$clerk,$group);
$logins = get_all_logins_by_date($from, $to, $clerk);
$lates = get_all_lates_by_date($from, $to, $clerk);
$clerk_list = get_all_clerks(1);
$group_list = get_all_user_groups();

$charlist = "\n\r\0\x0B";
$report_line = "";
$columns = "Day \t Clerk \t Fault \t Shedule \t Sch_Hours \t Real Time \t Real_Hours \n";

?>

<form method="post">
    From: 
    <input name="from" type="text" id="from" value="<? echo $from ?>" size="10" />
    &nbsp;&nbsp;
    To: 
    <input name="to" type="text" id="to" value="<? echo $to ?>" size="10" />
     <BR/><BR/>
    
    Clerk:
    <?
	create_objects_list("clerk", "clerk", $clerk_list, "id", "name", "All", $clerk);  ?>
   	&nbsp;&nbsp;
    Group:
    <?
	create_objects_list("group", "group", $group_list, "id", "name", "All", $group);  ?>
   	&nbsp;&nbsp;
    More than 
    <input name="minutes" type="text" id="minutes" size="3" style="text-align:center" value="<? echo $minutes ?>" /> 
    minutes
    <input type="submit" value="Search" />
</form>
<div align="right">
	<a href="javascript:;" onclick="document.getElementById('xml_form_1').submit();" class="normal_link">Export</a>
</div>

<br /><br />
<iframe frameborder="0" width="1" height="1" scrolling="no" id="sender"></iframe>


<p>
<strong>Approve & Pay:</strong> Approve fault and pay Schedule time.<br />
<strong>Approve & Dont Pay:</strong> Approve fault and pay Worked time.<br />
<strong>Unjustified:</strong> Unjustified fault and pay Worked time.
</p>

<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td class="table_header" align="center">Day</td>
    <td class="table_header">Clerk</td>
    <td class="table_header">Fault</td>
    <td class="table_header" align="center">Schedule</td>
    <td class="table_header" align="center">SCH<br />HRS</td>
    <td class="table_header" align="center">Real Time</td>
    <td class="table_header" align="center">REAL<br />HRS</td>
    <td class="table_header" align="center">Action</td>
  </tr>
<?
if(strtotime($from) <= strtotime("2014-04-07")){$from = "2014-04-08";}
$current = $from;
$end = date("Y-m-d",strtotime($to." +1 day"));
$i=0;
while($current != $end && strtotime($current) <= strtotime(date("Y-m-d"))){
	$str_day = strtolower(date("D",strtotime($current)));
	$monday = get_monday($current);
	foreach($clerk_list as $lclerk){
		$cu_sch = $schedules[$lclerk->vars["id"]."-".$str_day."-".$monday];
		$cu_login = $logins[$lclerk->vars["id"]."-".$current."-0"];
		$cu_logout = $logins[$lclerk->vars["id"]."-".$current."-1"];
		$late = $lates[$lclerk->vars["id"]."-".$current];
		
		$time_in_schedule = strtotime($current . " " . $cu_sch->vars["open_hour"]);
		$time_out_schedule = strtotime($current . " " . $cu_sch->vars["close_hour"]);
		$time_in_real = strtotime($cu_login->vars["date"]);
		$time_out_real = strtotime($cu_logout->vars["date"]);
		
		$in_diff =  number_format(($time_in_real - $time_in_schedule)/60);
		$out_diff = number_format(($time_out_schedule - $time_out_real)/60);
		
		$fault = "";
		$fault_hours = 0;		
		if(is_null($cu_login)){
			$fault = "Didn't worked";
			$fault_minutes = number_format(($time_out_schedule-$time_in_schedule)/60);
		}else{
			if($in_diff >= $minutes){
				$fault = "Late $in_diff min<br />";
				$fault_minutes = $in_diff;
			}
			if(is_null($cu_logout) && $current != date("Y-m-d")){
				$fault = "Didn't marked FINISH WORK";
				$fault_minutes = number_format(($time_out_schedule-$time_in_real)/60);
			}else if($out_diff >= $minutes && $current != date("Y-m-d")){
				$fault = "Left early $out_diff min";
				$fault_minutes = $in_diff;
			}
		}
		if(!is_null($cu_login) && !is_null($cu_logout)){
			$real_hours = number_format(($time_out_real-$time_in_real)/60/60,1);
		}else{
			$real_hours = 0;
		}
		$schedule_hours = number_format(($time_out_schedule-$time_in_schedule)/60/60,1);
		
		$dif_hours = $schedule_hours - $real_hours;
		if($dif_hours < 0){$dif_hours = 0;}
		
		if($fault != '' && !is_null($cu_sch)){
			if($i % 2){$style = "1";}else{$style = "2";};$i++;
			?>
			<tr>
			  <td class="table_td<? echo $style ?>" align="center"><? echo $current ?></td>
			  <td class="table_td<? echo $style ?>"><? echo $lclerk->vars["name"] ?></td>
			  <td class="table_td<? echo $style ?>"><? echo $fault/*."<br />".$in_diff."<br />".$out_diff*/ ?></td>
			  <td class="table_td<? echo $style ?>" align="center">
				<? echo date("h:i A",$time_in_schedule) ?><br /><? echo date("h:i A",$time_out_schedule) ?>
			  </td>
              <td class="table_td<? echo $style ?>" align="center">
              	<? echo $schedule_hours ?>
              </td>
			  <td class="table_td<? echo $style ?>" align="center">
              	<? 
				if(!is_null($cu_login)){ 
					echo date("h:i A",$time_in_real);
				    $timein_str = date("h:i A",$time_in_real);
				}else{
				   echo "<strong>No Start</strong>";
				    $timein_str = "No Start";
				   }
				echo "<br />";
				if(!is_null($cu_logout)){ 
					echo date("h:i A",$time_out_real);
					$timeout_str = date("h:i A",$time_out_real);
				}else{
					echo "<strong>No Finish</strong>";
					$timeout_str = "No Finish"; 
				}
				?>
              </td>
              <td class="table_td<? echo $style ?>" align="center">
              	<? echo $real_hours; ?>
              </td>
			  <? $ukey = $lclerk->vars["id"]."-".$current; ?>
              <td class="table_td<? echo $style ?>" align="center" id="container<? echo $ukey ?>">
              	<? if(is_null($late)){ ?>              	
              	<form method="post" id="form<? echo $ukey ?>" action="process/actions/mark_late_report.php" target="sender">
                	<input name="user" type="hidden" id="user<? echo $ukey ?>" value="<? echo $lclerk->vars["id"] ?>" />
                    <input name="hours" type="hidden" id="hours<? echo $ukey ?>" value="<? echo $dif_hours ?>" />
                    <input name="date" type="hidden" id="date<? echo $ukey ?>" value="<? echo $current ?>" />
                  <input name="in_hour" type="hidden" id="in_hour<? echo $ukey ?>" value="<? echo $cu_login->vars["date"] ?>" />
                  <input name="out_hour" type="hidden" id="out_hour<? echo $ukey ?>" value="<? echo $cu_logout->vars["date"] ?>" />
                  <input name="schedule_in" type="hidden" id="schedule_in<? echo $ukey ?>" value="<? echo $cu_sch->vars["open_hour"] ?>" />
                  <input name="schedule_out" type="hidden" id="schedule_out<? echo $ukey ?>" value="<? echo $cu_sch->vars["close_hour"] ?>" />
                  <input name="result" type="hidden" id="result<? echo $ukey ?>" value="" />
                    <input type="button" value="Approve &amp; Pay" style="width:135px" onclick="fire_action('ap', '<? echo $ukey ?>')" />
                    <br />
                    <input type="button" value="Approve &amp; Dont Pay" style="width:135px;" onclick="fire_action('ad', '<? echo $ukey ?>')" />
                    <br />
                    <input type="button" value="Unjustified" style="width:135px;" onclick="fire_action('un', '<? echo $ukey ?>')" />
                </form>
                <? }else{echo $late->get_str();} ?>
              </td>
			</tr>
			<?
		 $line = $current." \t ".$lclerk->vars["name"]." \t ".str_replace("<br />","",$fault)." \t ".date("h:i A",$time_in_schedule)." to ".date("h:i A",$time_out_schedule)." \t ".$schedule_hours." \t ".$timein_str." to ".$timeout_str." \t ".$real_hours."  \t  ";		
		
$line = str_replace(str_split($charlist), ' ', $line);
$report_line .= $line."\n ";

		
		}

	}
	$current = date("Y-m-d",strtotime($current." +1 day"));	

}
?>
</table>

<script type="text/javascript">
function fire_action(action, ukey){
	var msgs = new Array();
	msgs['ap'] = "Are you sure you want to Justify this fault and Pay it?";
	msgs['ad'] = "Are you sure you want to Justify this fault without paying it?";
	msgs['un'] = "Are you sure you want to mark this fault as Unjustified?";
	if(confirm(msgs[action])){
		document.getElementById("result"+ukey).value = action;
		document.getElementById("form"+ukey).submit();
		var msgs2 = new Array();
		msgs2['ap'] = "Approved and Paid by <? echo $current_clerk->vars["name"] ?>";
		msgs2['ad'] = "Approved without being paid by <? echo $current_clerk->vars["name"] ?>";
		msgs2['un'] = "Unjustified by <? echo $current_clerk->vars["name"] ?>";
		document.getElementById("container"+ukey).innerHTML = msgs2[action];
	}
}
</script>

</div>
<? $content = $columns." ".$report_line; ?>
<form method="post" action="process/actions/excel.php" id="xml_form_1">
<input name="content" type="hidden" id="content" value="<? echo $content ?>">
<input name="name" type="hidden" id="name" value="Late Report">
</form>

<? include "../includes/footer.php" ?>
<? }else{echo "Access Denied";} ?>
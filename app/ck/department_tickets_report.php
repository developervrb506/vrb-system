<? include(ROOT_PATH . "/ck/process/security.php"); ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/style.css" rel="stylesheet" type="text/css" />
<title>Department Tickets Report</title>
<link rel="stylesheet" href="<?= BASE_URL ?>/includes/shadowbox/shadowbox.css" type="text/css" media="screen" />
<script type="text/javascript" src="<?= BASE_URL ?>/includes/shadowbox/shadowbox.js"></script>
<script type="text/javascript">
Shadowbox.init();
</script>
<link rel="stylesheet" type="text/css" media="all" href="../includes/calendar/jsDatePick_ltr.min.css" />
<script type="text/javascript" src="../includes/calendar/jsDatePick.min.1.3.js"></script>
<script type="text/javascript">
	window.onload = function(){
		new JsDatePick({
			useMode:2,
			target:"datef",
			dateFormat:"%Y-%m-%d"
		});
		new JsDatePick({
			useMode:2,
			target:"datet",
			dateFormat:"%Y-%m-%d"
		});
	};
</script>
</head>
<body>
<? include "../includes/header.php" ?>
<? include "../includes/menu_ck.php" ?>
<div class="page_content" style="padding-left:20px;">
<span class="page_title">Department Tickets Report</span><br /><br />

<? include "includes/print_error.php" ?>
<? 

if($_POST["datef"]==""){$from = date('Y-m-d');}else{$from = $_POST["datef"];} 
if($_POST["datet"]==""){$to = date('Y-m-d');}else{$to = $_POST["datet"];}
$agent = $_POST["agent"];
$status = $_POST["status"];
$all_option = true;

$group = 0;
if($_POST["group_list"] != ""){
   $group = $_POST["group_list"];
}


?>
<form method="post">
From: <input name="datef" type="text" id="datef" value="<? echo $from ?>" readonly="readonly" />&nbsp;&nbsp;

To: <input name="datet" type="text" id="datet" value="<? echo $to ?>" readonly="readonly" />&nbsp;&nbsp;

Agent: <input name="agent" type="text" id="agent" value="<? echo $agent ?>" />&nbsp;&nbsp;
<Br /><Br />
Status: 
<select name="status" id="status">
  <option value="">All</option>
  <option value="1" <? if($status == "1"){echo 'selected="selected"';} ?>>Resolved</option>
  <option value="0" <? if($status == "0"){echo 'selected="selected"';} ?>>Pending</option>
</select>

<? if($current_clerk->im_allow("admin_department_tickets")) { ?>   
Department:
       <?  $s_group = $group; include "includes/group_list.php" ; 
	   
}?>



&nbsp;&nbsp;

<input type="submit" value="Search" />
</form>
<br /><br />

<? if($current_clerk->im_allow("admin_department_tickets")) { 
    $tickets = search_department_tickets($from, $to, $status, $agent,$s_group);
  }
  else {
	 $tickets = search_department_tickets($from, $to, $status, $agent,$current_clerk->vars["user_group"]->vars["id"]);  
    }
   ?> 

<? if(count($tickets)>0){ ?>  
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
	<td class="table_header" align="center">Id</td>
	<td class="table_header" align="center">Date</td>
	<td class="table_header" align="center">Agent</td>
	<td class="table_header" align="center">Issue</td>
    <td class="table_header" align="center">Status</td>
	<td class="table_header" align="center">Open by</td>
    <td class="table_header" align="center">Close By</td>
	<td class="table_header" align="center"></td>
  </tr>
  <?
  $i=0;	   
   foreach($tickets as $tik){
	   if($i % 2){$style = "1";}else{$style = "2";}
	   $i++;
	   $tik->load_clerks();
  ?>
  <tr>
	<td class="table_td<? echo $style ?>" align="center"><? echo $tik->vars["id"]; ?></td>
	<td class="table_td<? echo $style ?>" align="center"><? echo $tik->vars["tdate"]; ?></td>
	<td class="table_td<? echo $style ?>" align="center"><? echo $tik->vars["agent"]; ?></td>
	<td class="table_td<? echo $style ?>"><? echo text_preview($tik->vars["issue"],50); ?></td>
    <td class="table_td<? echo $style ?>" align="center" style="color:<? echo $tik->status_color() ?>"><? echo $tik->str_status() ?></td>
	<td class="table_td<? echo $style ?>" align="center"><? echo $tik->vars["open_clerk"]->vars["name"]; ?></td>
    <td class="table_td<? echo $style ?>" align="center"><? echo $tik->vars["close_clerk"]->vars["name"]; ?></td>
	<td class="table_td<? echo $style ?>" align="center">
		<a href="department_tickets.php?detail&tid=<? echo $tik->vars["id"]; ?>" class="normal_link">View</a>
	</td>
  </td>
  <? } ?>
  <tr>
	<td class="table_last"></td>
	<td class="table_last"></td>
	<td class="table_last"></td>
	<td class="table_last"></td>
	<td class="table_last"></td>
	<td class="table_last"></td>
    <td class="table_last"></td>
	<td class="table_last"></td>
  </tr>

</table>
<? }else{echo "No Tickets Found";} ?>


</div>
<? include "../includes/footer.php" ?>

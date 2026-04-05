<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->im_allow("tickets")){ ?>
<?
$sfrom = $_POST["from"];
if($sfrom==""){$sfrom = date("Y-m-d");}
$sto = $_POST["to"];
if($sto==""){$sto = date("Y-m-d");}
$stime = $_POST["time"];
$sdept = $_POST["dept"];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/style.css" rel="stylesheet" type="text/css" />

<title>Tickets</title>
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
<div class="page_content" style="padding-left:50px;">

<span class="page_title">Time Tickets Report</span><br /><br />
<? $groups = get_all_user_groups_chatids(); ?>
<div class="form_box">
    <form method="post" id="frm_search">
	From: <input name="from" type="text" id="from" value="<? echo $sfrom ?>" readonly="readonly" size="10" /> &nbsp;&nbsp;
    To: <input name="to" type="text" id="to" value="<? echo $sto ?>" size="10" readonly="readonly" /> &nbsp;&nbsp;
    <?php /*?>Time to:
    <select name="time" id="time">
      <option value="1" <? if($stime == "a"){echo 'selected="selected"';} ?>>Answer</option>
      <option value="0" <? if($stime == "c"){echo 'selected="selected"';} ?>>Close</option>
    </select>
    &nbsp;&nbsp;<?php */?>
    <? if($current_clerk->im_allow("all_tickets")){ ?> 
    Department:
    <? create_objects_list("dept", "dept", $groups, "chat_dept_id", "name", "All", $sdept) ?>
    &nbsp;&nbsp; 
    <? } ?>   
    <input name="" type="submit" value="Search" />
    </form>
</div><br /><br />

<? 

include "includes/print_error.php" ?>    
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td class="table_header" align="center">Id</td>
    <td class="table_header" align="center">Date</td>
    <td class="table_header" align="center">From</td>
    <td class="table_header" align="center">Subject</td>
    <td class="table_header" align="center">Attended BY</td>
    <? if($current_clerk->im_allow("all_tickets")){ ?><td class="table_header" align="center">Department</td><? } ?>  
    <td class="table_header" align="center">Time</td>
    <td class="table_header" align="center"></td>
  </tr>
  <?
   $i=0;
   
   if($current_clerk->im_allow("all_tickets")){
	  $livechat_dept_id = $sdept;
   }
   else {
	  $livechat_dept_id = $current_clerk->vars["user_group"]->vars["chat_dept_id"]; 
   }   
   
   $tickets = search_tickets_by_time($sfrom, $sto, $time, $livechat_dept_id, "agents");
   
   foreach($tickets as $tk){
       if($i % 2){$style = "1";}else{$style = "2";}$i++;
	   $tgroup = $groups[$tk->vars["dep_id_live_chat"]];
  ?>
  <tr title="<? echo small_text(strip_tags($tk->vars["message"]),150); ?>">
    <td class="table_td<? echo $style ?>" align="center"><? echo $tk->vars["id"]; ?></td>
	<td class="table_td<? echo $style ?>" align="center"><? echo $tk->vars["tdate"]; ?></td>
    <td class="table_td<? echo $style ?>" align="center">
	 <? echo $tk->vars["player_account"]; ?>  
    </td>
    <td class="table_td<? echo $style ?>" align="center"><? echo $tk->vars["subject"]; ?></td>
    <td class="table_td<? echo $style ?>" align="center">
    	<?
		$clerk = get_ticket_clerk($tk->vars["id"]);
		if(!is_null($clerk)){echo $clerk->vars["name"];}
		else{ 
			$responses = get_ticket_responses($tk->vars["id"]);
			if(count($responses)>0 || !$tk->vars["open"]){echo $responses[0]->vars["by"];}
			else{?> <strong style="color:#F00;">Unattended</strong> <? }
		}
		?>
    </td>
    <? if($current_clerk->im_allow("all_tickets")){ ?><td class="table_td<? echo $style ?>" align="center"><? echo $tgroup->vars["name"]; ?></td>
	<? } ?> 
    <td class="table_td<? echo $style ?>" align="center">
    	<? echo $tk->vars["answered"]; ?>
    </td>
    <td class="table_td<? echo $style ?>" align="center">
    	<a href="view_ticket.php?tid=<? echo $tk->vars["id"]; ?>" target="_blank" class="normal_link">View</a>
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
    <td class="table_last"></td>
  </tr>

</table>


</div>
<? include "../includes/footer.php" ?>
<? }else{echo "Access Denied";} ?>
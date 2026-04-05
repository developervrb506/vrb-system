<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->im_allow("tickets")){ ?>
<?
$sfrom = $_POST["from"];
if($sfrom==""){$sfrom = date("Y-m-d");}
$sto = $_POST["to"];
if($sto==""){$sto = date("Y-m-d");}
$sopen = $_POST["open"];
$semail = $_POST["email"];
$sdept = $_POST["dept"];
$skeyword = $_POST["keyword"];
$completed = $_POST["completed"];

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
<script type="text/javascript">

function delete_ticket(id){
	if(confirm("Are you sure you want to DELETE this ticket from the system?")){
		document.getElementById("idel").src = "http://localhost:8080/ck/process/actions/delete_ticket.php?id="+id;
		document.getElementById("tr_"+id).style.display = "none";
	}
}
</script>
</head>
<body>
<? include "../includes/header.php" ?>
<? include "../includes/menu_ck.php" ?>
<div class="page_content" style="padding-left:50px; width:1000px;">
<div align="right">
	<iframe width="1" height="1" frameborder="0" scrolling="no" id="idel"></iframe>
</div>
<span class="page_title">Tickets Report</span><br /><br />
<? $groups = get_all_user_groups_chatids(); ?>
<div class="form_box">
    <form method="post" id="frm_search">
	From: <input name="from" type="text" id="from" value="<? echo $sfrom ?>" readonly="readonly" size="10" /> &nbsp;&nbsp;
    To: <input name="to" type="text" id="to" value="<? echo $sto ?>" size="10" readonly="readonly" /> &nbsp;&nbsp;
    Status:
    <select name="open" id="open">
      <option value="" >All</option>
      <option value="1" <? if($sopen == "1"){echo 'selected="selected"';} ?>>Open</option>
      <option value="0" <? if($sopen == "0"){echo 'selected="selected"';} ?>>Closed</option>
    </select>  &nbsp;&nbsp;
     <input type="checkbox" name="completed" value="1" <? if ($completed == 1){ echo ' checked="checked" '; } ?> >&nbsp;<strong>Completed</strong>
   
    
    <BR><BR>
   
    <? if($current_clerk->im_allow("all_tickets")){ ?> 
    Department:
    <? create_objects_list("dept", "dept", $groups, "chat_dept_id", "name", "All", $sdept) ?>
    &nbsp;&nbsp; 
    <? } ?>   
	Email: <input name="email" type="text" id="email" value="<? echo $semail ?>" size="10" /> &nbsp;&nbsp;
    Keyword: <input name="keyword" type="text" id="keyword" value="<? echo $skeyword ?>" size="10" /> &nbsp;&nbsp;
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
    <td class="table_header" align="center">Website</td>
    <td class="table_header" align="center">Attended BY</td>
    <? if($current_clerk->im_allow("all_tickets")){ ?><td class="table_header" align="center">Department</td><? } ?>  
    <td class="table_header" align="center">Status</td>
    <td class="table_header" align="center"></td>
    <? if($current_clerk->im_allow("delete_tickets")){ ?>
    <td class="table_header" align="center"></td>
    <? } ?>
  </tr>
  <?
   $i=0;
   
   if($current_clerk->im_allow("all_tickets")){
	  $livechat_dept_id = $sdept;
   }
   else {
	  $livechat_dept_id = $current_clerk->vars["user_group"]->vars["chat_dept_id"]; 
   }  
   
   if (empty($livechat_dept_id)){
	  $livechat_dept_id = 0;
   }  
   
   //$tickets = search_tickets($sfrom, $sto, $sopen, $semail,"agents",$livechat_dept_id,$skeyword);
   $tickets = search_tickets($sfrom, $sto, $sopen, $semail,"agents",$livechat_dept_id,$skeyword,$current_clerk->vars["id"]);
   //$tickets = search_tickets($sfrom, $sto, $sopen, $email, "agents", $livechat_dept_ids,$skeyword ,$current_clerk->vars["id"], "" ,"","",$pending_ans = "",false,0,0,$completed);
   foreach($tickets as $tk){
       if($i % 2){$style = "1";}else{$style = "2";}$i++;
	   $tgroup = $groups[$tk->vars["dep_id_live_chat"]];
  ?>
  <tr title="<? echo small_text(strip_tags($tk->vars["message"]),150); ?>" id="tr_<? echo $tk->vars["id"]; ?>">
    <td class="table_td<? echo $style ?>" align="center"><? echo $tk->vars["id"]; ?></td>
	<td class="table_td<? echo $style ?>" align="center"><? echo $tk->vars["tdate"]; ?></td>
    <td class="table_td<? echo $style ?>" align="center"><? echo $tk->vars["name"]; ?><br /><? echo $tk->vars["player_account"]; ?>  
     <? if ($tk->vars["email"] != "") { echo '<br />'.$tk->vars["email"]; } ?>
	 <? if ($tk->vars["phone"] != "") { echo '<br /> Phone Number: '.$tk->vars["phone"]; } ?>
    </td>
    <td class="table_td<? echo $style ?>" align="center"><? echo $tk->vars["subject"]; ?></td>
    <td class="table_td<? echo $style ?>" align="center"><? echo $tk->vars["website"]; ?></td>
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
    <td class="table_td<? echo $style ?>" align="center"><? echo $tk->str_status(); ?></td>
    <td class="table_td<? echo $style ?>" align="center">
    	<a href="view_ticket.php?tid=<? echo $tk->vars["id"]; ?>" target="_blank" class="normal_link">View</a>
    </td>
    <? if($current_clerk->im_allow("delete_tickets")){ ?>
    <td class="table_td<? echo $style ?>" align="center">
    	  <a class="normal_link" href="javascript:;" onclick="delete_ticket('<? echo $tk->vars["id"] ?>');">
        	Delete
        </a>
    </td>
    <? } ?>
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
     <? if($current_clerk->im_allow("delete_tickets")){ ?>
      <td class="table_last"></td>
     <? } ?>
  </tr>

</table>


</div>
<? include "../includes/footer.php" ?>
<? }else{echo "Access Denied";} ?>
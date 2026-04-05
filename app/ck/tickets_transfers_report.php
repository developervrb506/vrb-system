<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->im_allow("ticket_transfers_report")){ ?>
<?
$sfrom = $_POST["from"];
if($sfrom==""){$sfrom = date("Y-m-d");}
$sto = $_POST["to"];
if($sto==""){$sto = date("Y-m-d");}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/style.css" rel="stylesheet" type="text/css" />

<title>Ticket Tranfers Report</title>
<link rel="stylesheet" type="text/css" media="all" href="../includes/calendar/jsDatePick_ltr.min.css" />
<script type="text/javascript" src="http://localhost:8080/ck/includes/js/sortables.js"></script>
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

<span class="page_title">Ticket Tranfers Report</span><br /><br />
<? $groups = get_all_user_groups_chatids(); ?>
<div class="form_box">
    <form method="post" id="frm_search">
	From: <input name="from" type="text" id="from" value="<? echo $sfrom ?>" readonly="readonly" size="10" /> &nbsp;&nbsp;
    To: <input name="to" type="text" id="to" value="<? echo $sto ?>" readonly="readonly"  size="10" /> &nbsp;&nbsp;   
    <input name="" type="submit" value="Search" />
    </form>
</div><br /><br />

<? 

include "includes/print_error.php" ?>    
<table class="sortable" width="100%" border="0" cellspacing="0" cellpadding="0">
  <thead>
  <tr>
    <th class="table_header" align="center">Ticket Id</th>
    <th class="table_header" align="center">Transfer Date</th>
    <th class="table_header" align="center">From</th>
    <th class="table_header" align="center">To</th>
    <th class="table_header" align="center">Clerk who did the transfer</th>    
    <th class="table_header sorttable_nosort" align="center"></th>
  </tr>
  </thead>
  <tbody id="the-list">
  <?
   $i=0;      
   
   $ticket_transfers = get_tickets_transfers_log($sfrom, $sto);
   
   foreach($ticket_transfers as $tk){
       if($i % 2){$style = "1";}else{$style = "2";}$i++;
	   
	   $tgroup_source      = $groups[$tk->vars["depid_source"]];
	   $tgroup_destination = $groups[$tk->vars["depid_destination"]];
  ?>
  <tr>
    <th class="table_td<? echo $style ?>" align="center" style="font-weight:normal;"><? echo $tk->vars["ticket_id"]; ?></th>
	<th class="table_td<? echo $style ?>" align="center" style="font-weight:normal;"><? echo $tk->vars["tdate"]; ?></th>
    <th class="table_td<? echo $style ?>" align="center" style="font-weight:normal;"><? echo $tgroup_source->vars["name"]; ?></th>
    <th class="table_td<? echo $style ?>" align="center" style="font-weight:normal;"><? echo $tgroup_destination->vars["name"]; ?></th>    
    <th class="table_td<? echo $style ?>" align="center" style="font-weight:normal;">
	<?
    $clerk = get_clerk($tk->vars["clerk"]);
	echo $clerk->vars["name"];
	?>
    </th>   
    <th class="table_td<? echo $style ?>" align="center" style="font-weight:normal;">
    	<a href="view_ticket.php?tid=<? echo $tk->vars["ticket_id"]; ?>" target="_blank" class="normal_link">View</a>
    </th>
  </tr>
  <? } ?>
  <tr>
    <th class="table_last"></th>
	<th class="table_last"></th>
    <th class="table_last"></th>
    <th class="table_last"></th>
    <th class="table_last"></th>
    <th class="table_last"></th>    
  </tr>
  </tbody>
</table>

</div>
<? include "../includes/footer.php" ?>
<? }else{echo "Access Denied";} ?>
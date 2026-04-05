<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->im_allow("tickets_clerk")){ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/style.css" rel="stylesheet" type="text/css" />

<title>Tickets</title>

</head>
<body>
<? include "../includes/header.php" ?>
<? include "../includes/menu_ck.php" ?>
<div class="page_content" style="padding-left:50px;">

<span class="page_title">Open Tickets</span>
&nbsp;&nbsp;&nbsp;&nbsp;<a href="tickets_report_clerk.php" class="normal_link">Tickets Report</a><br /><br />

<? include "includes/print_error.php" ?>    
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td class="table_header" align="center">Id</td>
    <td class="table_header" align="center">Date</td>
    <td class="table_header" align="center">From</td>
    <td class="table_header" align="center">Subject</td>
    <td class="table_header" align="center">Website</td>
    <td class="table_header" align="center">Attended BY</td>
    <td class="table_header" align="center"></td>
  </tr>
  <?
  $i=0;
       
   $category=$current_clerk->get_tickets_category();
   
   $tickets = search_tickets("", "", 1, "",$category);
   foreach($tickets as $tk){
       if($i % 2){$style = "1";}else{$style = "2";}$i++;
  ?>
  <tr title="<? echo small_text($tk->vars["message"],150); ?>">
    <td class="table_td<? echo $style ?>" align="center"><? echo $tk->vars["id"]; ?></td>
	<td class="table_td<? echo $style ?>" align="center"><? echo $tk->vars["tdate"]; ?></td>
    <td class="table_td<? echo $style ?>" align="center"><? echo $tk->vars["name"]; ?><br />(<? echo $tk->vars["email"]; ?>)</td>
    <td class="table_td<? echo $style ?>" align="center"><? echo $tk->vars["subject"]; ?></td>
    <td class="table_td<? echo $style ?>" align="center"><? echo $tk->vars["website"]; ?></td>
    <td class="table_td<? echo $style ?>" align="center">
    	<?
		$clerk = get_ticket_clerk($tk->vars["id"]);
		if(!is_null($clerk)){echo $clerk->vars["name"];}
		else{ ?> <strong style="color:#F00;">Unattended</strong> <? }
		?>
    </td>
    <td class="table_td<? echo $style ?>" align="center">
    	<a href="view_ticket.php?tid=<? echo $tk->vars["id"]; ?>" class="normal_link">View</a>
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
  </tr>

</table>


</div>
<? include "../includes/footer.php" ?>
<? }else{echo "Access Denied";} ?>
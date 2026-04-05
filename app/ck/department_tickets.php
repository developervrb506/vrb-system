<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->im_allow("department_tickets") || $current_clerk->admin()){ ?>
<?


$group = 0;
if(isset($_POST["group_list"])){
   $group = $_POST["group_list"];
}


if(isset($_POST["process"])){
	if(isset($_POST["update_id"])){
		$upacc = get_department_ticket($_POST["update_id"]);
		$upacc->vars["agent"] = str_replace("'","\'",$_POST["agent"]);
		$upacc->vars["issue"] = str_replace("'","\'",$_POST["issue"]);
		$upacc->vars["solution"] = str_replace("'","\'",$_POST["solution"]);
		$upacc->vars["resolved"] = str_replace("'","\'",$_POST["resolved"]);
		if($upacc->vars["close_clerk"] == "" || $upacc->vars["close_clerk"] == 0){
			$upacc->vars["close_clerk"] = $current_clerk->vars["id"];
		}
				
		if($current_clerk->im_allow("admin_department_tickets")) {	
		   $upacc->vars["department"] = $_POST["group_list"];
		}
		else {
		   $upacc->vars["department"] = $current_clerk->vars["user_group"]->vars["id"];
	
		}
		
		$upacc->update();
	}else{
		$newacc = new _department_ticket();
		$newacc->vars["agent"] = $_POST["agent"];
		$newacc->vars["issue"] = str_replace("'","\'",$_POST["issue"]);
		$newacc->vars["solution"] = str_replace("'","\'",$_POST["solution"]);
		$newacc->vars["resolved"] = str_replace("'","\'",$_POST["resolved"]);
		$newacc->vars["tdate"] = date("Y-m-d H:i:s");
		$newacc->vars["open_clerk"] = $current_clerk->vars["id"];
		if($newacc->vars["resolved"]){$newacc->vars["close_clerk"] = $current_clerk->vars["id"];}
		
		if($current_clerk->im_allow("admin_department_tickets")) {	
		   $newacc->vars["department"] = $_POST["group_list"];
		}
		else {
		   $newacc->vars["department"] = $current_clerk->vars["user_group"]->vars["id"];	
		}
		
		$newacc->insert();
		header("Location: department_tickets.php?e=62");		
	}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/style.css" rel="stylesheet" type="text/css" />
<title>Department Tickets</title>
<script type="text/javascript" src="includes/js/bets.js"></script>
</head>
<body>
<? include "../includes/header.php" ?>
<? include "../includes/menu_ck.php" ?>
<div class="page_content" style="padding-left:50px;">

<? 
if(isset($_GET["detail"])){
	//details
	
	$ticket = get_department_ticket($_GET["tid"]);
	if(is_null($ticket)){
		$title = "Add new Ticket";
	}else{
		$title = "Edit Ticket";
		$hidden = '<input name="update_id" type="hidden" id="update_id" value="'.$ticket->vars["id"] .'" />';
		$edit = true;
	}
	?>
    <span class="page_title"><? echo $title ?></span><br /><br />
	<? include "includes/print_error.php" ?>
    <script type="text/javascript" src="../process/js/functions.js"></script>
	<script type="text/javascript">
    var validations = new Array();
    validations.push({id:"agent",type:"null", msg:"Please insert the Agent"});
	validations.push({id:"issue",type:"null", msg:"Please insert the Issue"});
    </script>
	<div class="form_box" style="width:700px;">
        <form method="post" action="department_tickets.php?e=62" onsubmit="return validate(validations)">
        <input name="process" type="hidden" id="process" value="1" />
		<? echo $hidden; ?>
        <table width="100%" border="0" cellspacing="0" cellpadding="10">
        &nbsp;&nbsp;
        <?  if($current_clerk->im_allow("admin_department_tickets")) { ?>   
          <tr>
            <td>Department:</td>
            <td><?  $s_group = $group; include "includes/group_list.php"  ?></td>
          </tr>
          <tr>
          
        <? } ?>  
          
          
          <tr>
            <td>Agent</td>
            <td><input name="agent" type="text" id="agent" value="<? echo $ticket->vars["agent"] ?>" /></td>
          </tr>
          <tr>
            <td>Issue</td>
            <td><textarea name="issue" cols="50" rows="10" id="issue"><? echo $ticket->vars["issue"] ?></textarea></td>
          </tr> 
          <tr>
            <td>Solution</td>
            <td><textarea name="solution" cols="50" rows="10" id="solution"><? echo $ticket->vars["solution"] ?></textarea></td>
          </tr> 
          <tr>
            <td>Resolved</td>
            <td><input name="resolved" type="checkbox" id="resolved" value="1" <? if($ticket->vars["resolved"]){echo 'checked="checked"';} ?> /></td>
          </tr> 
          <tr>    
            <td><input type="image" src="../images/temp/submit.jpg" /></td>
            <td>&nbsp;</td>
          </tr>
        </table>
      </form>
    </div>
    <?
	//end details
}else{
	//list
 ?>
    <span class="page_title">Pending Department tickets</span><br /><br />
 <?  if($current_clerk->im_allow("admin_department_tickets")) { ?>

    <form method="post" action="department_tickets.php" >
    
     <?
	 echo "Department: ";
	 $s_group = $group; include "includes/group_list.php" ;
     ?>
     &nbsp;&nbsp;
        
     <input type="submit" value="Search" />
     </form>
    
    <?  } ?> 
    <br /><br /> 
   
   
   
    <a href="?detail" class="normal_link">+ New Ticket</a>&nbsp;&nbsp;&nbsp;&nbsp;
    <a href="department_tickets_report.php" class="normal_link">Report</a>
    <br /><br />
	
	<? //if(!$current_clerk->im_allow("admin_department_tickets")) { ?>
    
	<? include "includes/print_error.php" ?>  
    
   <?  if($current_clerk->im_allow("admin_department_tickets") && ($s_group)) { 
		 $tickets = search_department_tickets("", "", "0", "",$s_group); 
      }
      else {
	   	 $tickets = search_department_tickets("", "", "0", "",$current_clerk->vars["user_group"]->vars["id"]); 	  
	
	  } ?>
	<? if(count($tickets)>0){ ?>  
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td class="table_header" align="center">Id</td>
        <td class="table_header" align="center">Date</td>
        <td class="table_header" align="center">Agent</td>
        <td class="table_header" align="center">Issue</td>
        <td class="table_header" align="center">Open by</td>
        <td class="table_header" align="center"></td>
      </tr>
      <?
	  $i=0;	   
	   foreach($tickets as $tik){
		   if($i % 2){$style = "1";}else{$style = "2";}
		   $i++;
		   $tik->load_clerks(false);
	  ?>
      <tr>
        <td class="table_td<? echo $style ?>" align="center"><? echo $tik->vars["id"]; ?></td>
        <td class="table_td<? echo $style ?>" align="center"><? echo $tik->vars["tdate"]; ?></td>
        <td class="table_td<? echo $style ?>" align="center"><? echo $tik->vars["agent"]; ?></td>
        <td class="table_td<? echo $style ?>"><? echo text_preview($tik->vars["issue"],50); ?></td>
        <td class="table_td<? echo $style ?>" align="center"><? echo $tik->vars["open_clerk"]->vars["name"]; ?></td>
        <td class="table_td<? echo $style ?>" align="center">
        	<a href="?detail&tid=<? echo $tik->vars["id"]; ?>" class="normal_link">View</a>
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
      </tr>
  
    </table>
    <? }else{echo "No Pending Tickets";} ?>
    <?
	//end list
}
?>

</div>
<? include "../includes/footer.php" ?>
<? }else{echo "Access Denied";} ?>

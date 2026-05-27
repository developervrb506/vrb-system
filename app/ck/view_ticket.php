<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if(($current_clerk->im_allow("tickets")) || ($current_clerk->im_allow("tickets_clerk"))){ ?>
<?  

   if (isset($_POST["tk"])){
	  $ticket = get_ticket($_POST["tk"]);
	  $_GET["tid"] = $_POST["tk"]; 
	if($ticket->vars["light"]){$ticket->vars["light"] = '0';}
	 else{$ticket->vars["light"] = '1';}	
	 $ticket->update(array("light"));  
   } else {
	   
	 $ticket = get_ticket($_GET["tid"]);  
	 }

   $ticket->vars["pread"] = '0'; 
   $ticket->vars["updated"] = '0'; 
   $ticket->update(array("pread","updated"));


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/style.css" rel="stylesheet" type="text/css" />

<title>View Ticket</title>
<script type="text/javascript" src="<?= BASE_URL ?>/process/js/ajax.js"></script>
<script type="text/javascript" src="includes/js/jquery-1.8.0.min.js"></script>
<script>


function action_ticket(id,action){
	
	if (action == 'delete'){
		if(confirm("Are you sure you want to DELETE this ticket from the system?")){
			location.href =  BASE_URL . "/ck/process/actions/delete_ticket.php?id="+id+"&v=1";
			
		}
	}
	else if (action == 'remove'){
		
		if(confirm("Are you sure you want to REMOVE this ticket from the system?")){
		location.href = BASE_URL . "/ck/process/actions/delete_ticket.php?removed=1&id="+id+"&v=1";
		
	   }
		
		
		
   }
}
</script>
</head>
<? 
$groups = get_all_user_groups_chatids();
$live_help_departments = get_live_help_departments();
$live_help_depts = array();

foreach ($live_help_departments as $lhdep) {    
  $live_help_depts[] = $lhdep->vars["deptID"].'//'.$lhdep->vars["name"];
}

if($ticket->vars["light"]){$style = "1_red";} 
$tgroup = $groups[$ticket->vars["dep_id_live_chat"]];

?>

<body>
<? include "../includes/header.php" ?>
<? include "../includes/menu_ck.php" ?>
<div class="page_content" style="padding-left:50px;">

<span class="page_title">View Ticket</span><br /><br />

  <div align="right">
  
   <? if($current_clerk->im_allow("delete_tickets")){ ?>
   <span ><a class="normal_link" href="javascript:;" onclick="action_ticket('<? echo $ticket->vars["id"] ?>','remove');">
       	Remove    </a></span>&nbsp;&nbsp;&nbsp;
   
   <span ><a class="normal_link" href="javascript:;" onclick="action_ticket('<? echo $ticket->vars["id"] ?>','delete');">
       	Delete    </a></span>&nbsp;&nbsp;&nbsp;     
     <? } ?>    
  <span ><a href="<?= BASE_URL ?>/ck/tickets.php">Back</a></span></div>      

 
 


<br /><br />
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
  <? if($current_clerk->im_allow("delete_tickets")){ ?>
    <td class="table_header" align="center"></td>
   <? } ?> 
    <td class="table_header" align="center">Id</td>
    <td class="table_header" align="center">Date</td>
    <td class="table_header" align="center">From</td>
    <td class="table_header" align="center">Subject</td>
    <td class="table_header" align="center">Website</td>
    <td class="table_header" align="center">Department</td>
     <td class="table_header" align="center"></td>
     <td class="table_header" align="center"></td>
  </tr>
  <tr>
  <? if($current_clerk->im_allow("delete_tickets")){ ?>
     <td class="table_td<? echo $style ?>" align="center">
       <form method="post" action="" >
       <input name="tk" type="hidden" id="tk<? echo $ticket->vars["id"] ?>" value="<? echo $ticket->vars["id"] ?>" />
               
         <input type="image" style="width: 30px;" src="<?= BASE_URL ?>/ck/images/pencil.png" />
        </form>
     </td>
    <? } ?>
    <td class="table_td<? echo $style ?>" align="center"><? echo $ticket->vars["id"]; ?></td>
	<td class="table_td<? echo $style ?>" align="center"><? echo $ticket->vars["tdate"]; ?></td>
    <td class="table_td<? echo $style ?>" align="center"><? echo $ticket->vars["name"]; ?><br /><? echo $ticket->vars["player_account"]; ?>	 
    <? if ($ticket->vars["email"] != "") { echo '<br />'.$ticket->vars["email"]; } ?>
	<? if ($ticket->vars["phone"] != "") { echo '<br /> Phone Number: '.$ticket->vars["phone"]; } ?>
    </td>
    <td class="table_td<? echo $style ?>" align="center"><? echo $ticket->vars["subject"]; ?></td>
    <td class="table_td<? echo $style ?>" align="center"><? echo $ticket->vars["website"]; ?></td>
    <td class="table_td<? echo $style ?>" align="center"><? echo $tgroup->vars["name"]; ?></td>
    <td class="table_td<? echo $style ?>" align="center">
    	<? if($ticket->vars["open"]){ ?>
    	<form method="post" action="process/actions/ticket_action.php" onsubmit="return confirm('Are you sure you want to Update this Ticket?')">
            <input name="tid" type="hidden" id="tid" value="<? echo $ticket->vars["id"] ?>" />
            <? if(!$ticket->vars["completed"]){ ?>
             <input name="action" type="hidden" id="action" value="complete" />
             <input name="" type="submit" value="COMPLETED" />
            <? } else { ?> 
              <strong>Completed</strong><BR> 
             <input name="action" type="hidden" id="action" value="incomplete" />
             <input name="" type="submit" value="INCOMPLETE" />
            <? } ?>
            
        </form>
        <? }else{echo "Closed";} ?>
    </td>
     <td class="table_td<? echo $style ?>" align="center">    	
        <form method="post" name="form<? echo $ticket->vars["id"] ?>" id="form<? echo $ticket->vars["id"] ?>" action="process/actions/ticket_transfer_department.php" onSubmit="return validate(validations)">
          <input name="ticketid" type="hidden" id="ticketid" value="<? echo $ticket->vars["id"] ?>">
          <input name="view" type="hidden" id="view" value="<? echo $ticket->vars["id"] ?>">
          <input name="deptid_source" type="hidden" id="deptid_source" value="<? echo $ticket->vars["dep_id_live_chat"] ?>">
          
           <div id="div_dep" style="block"  >
            <?
  	           $on_change = "from_ajax(this.value,'div_clerk_".$ticket->vars["id"]."','./process/actions/ticket_clerks_by_group.php')";
            ?>
             
              <select onchange="<? echo $on_change ?>" name="department" id="department<? echo $ticket->vars["id"] ?>">        
	             <option value="" id=""  >Choose an Dept</option>
                <? 
				foreach ($live_help_depts as $lhsdep) {
				  $lhsdep   = explode("//",$lhsdep);
				  $deptid   = $lhsdep[0];
				  $deptname = $lhsdep[1];
				  $tgroup_dep = $groups[$deptid];	
				?>
                   <? // if ($deptid <> $tk->vars["dep_id_live_chat"]) { ?>
                   <option value="<? echo $deptid; ?>"><? echo $tgroup_dep->vars["name"] ?></option>
                   <? // } ?>
                <? } ?>      
              </select><br />
              </div>
              <div name="div_clerk_<? echo $ticket->vars["id"] ?>" id="div_clerk_<? echo $ticket->vars["id"] ?>">
                 Clerk: 
                 <select onchange="" name="to_clerk" id="to_clerk"  class="">
 
                 <option value="" id="select"  selected="selected">Free</option>
    
               </select>
             </div>
              
              
              
              
              
              <input name="" type="submit" value="Transfer">         
        </form>
    </td> 
  </tr>
  <tr>
  	<td  <? if($current_clerk->im_allow("delete_tickets")){  echo ' colspan="9" '; } else { echo ' colspan="8" '; }?>  class="table_td_message">
    	<? echo nl2br($ticket->vars["message"]); ?>
       	<? if($current_clerk->im_allow("edit_tickets")){ ?>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a class="normal_link" href="javascript:;" onclick="edit_div(0);">Edit</a><br /><br />
       	
    	 <div id="div_0" style="display:none" >
         <form method="post" action="process/actions/ticket_action.php" onsubmit="return confirm('Are you sure you want to Edit this Message?')">
            <input name="tid" type="hidden" id="tid" value="<? echo $ticket->vars["id"] ?>" />
            <input name="action" type="hidden" id="action" value="t_edit" />
             <textarea name="new_message" style="width:99%" rows="5" id="new_message"><? echo nl2br($ticket->vars["message"]); ?></textarea>
             <input name="" type="submit" value="Save" />
           
            
        </form>
        <br /><br />
        
        </div>
        <? } ?>
        
        <? foreach(get_ticket_responses($ticket->vars["id"]) as $res){ ?>
  <div class="form_box" <? if($ticket->is_me($res->vars["by"])){echo 'style="background:#fbfdc2"';} ?>>
            	<strong><? echo $res->vars["by"] ?></strong> on <? echo $res->vars["rdate"] ?><br />
    			<? echo nl2br($res->vars["message"]) ?>
        
         <? if($current_clerk->im_allow("edit_tickets")){ ?>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a class="normal_link" href="javascript:;" onclick="edit_div('<? echo $res->vars["id"] ?>');">Edit</a>
       	
    	 <div id="div_<? echo $res->vars["id"] ?>" style="display:none" >
         <form method="post" action="process/actions/ticket_action.php" onsubmit="return confirm('Are you sure you want to Edit this Response?')">
            <input name="tid" type="hidden" id="tid" value="<? echo $ticket->vars["id"] ?>" />
            <input name="rid" type="hidden" id="rid" value="<? echo $res->vars["id"] ?>" />
            <input name="action" type="hidden" id="action" value="r_edit" />
             <textarea name="new_response" style="width:99%" rows="5" id="new_response"><? echo nl2br($res->vars["message"]); ?></textarea>
             <input name="" type="submit" value="Save"  />
           
            
        </form>
        
        
        </div>
        <? } ?>
            </div>
        <? } ?>
       
        <a id="response"></a>
        <div class="form_box">
        <? if($ticket->vars["open"]){ ?>
        <? $file_name = rand_str(20); ?>
        <strong>Reply</strong><a name="reply" id="reply"></a><br />
        <form method="post" action="process/actions/ticket_action.php" id="response_form">
            <input name="tid" type="hidden" id="tid" value="<? echo $ticket->vars["id"] ?>" />
            <input name="action" type="hidden" id="action" value="res" />
            <textarea name="reply_text" style="width:99%" rows="5" id="reply_text"></textarea><br />
            <input type="hidden" name="xfile" id="xfile" value="<? echo $file_name ?>" /> 
            <input type="hidden" name="xfile_name" id="xfile_name" />
        </form>    
        
        
        <iframe width="1" height="1" name="file_box" id="file_box" frameborder="0"></iframe>
        <form method="post" action="https://receipts.vrbmarketing.com/uploads/go.php" enctype="multipart/form-data" target="file_box" id="file_form">
            <strong>Attach File:</strong> 
            <div id="pre_upload">
                <input name="file_up" type="file" id="file_up">
                <input name="burl" type="hidden" id="burl" value=BASE_URL . "/ck/view_ticket.php?tid=<? echo $ticket->vars["id"] ?>#response">
                <input name="name" type="hidden" id="name" value="<? echo $file_name ?>">
                <input name="sd" type="button" id="sd" value="Attach" onclick="upload_xfile();">
            </div>
            <div id="post_upload">
                
            </div>
        </form>
        
        <script type="text/javascript">
        function upload_xfile(){
			var file_parts = $("#file_up").val().split('\\');
			var file_name = file_parts[file_parts.length-1];
			$("#xfile_name").val(file_name);
			$("#file_form").submit();
			$("#post_upload").html("File "+file_name+" was attached");
			$("#pre_upload").hide();
			$("#post_upload").show();
		}
        </script>
            
            
            <div align="right"><input name="" type="button" value="Submit" onclick="$('#response_form').submit();" /></div>
                  
        </div>
        <? }else{ ?>
        <strong>This Ticket is Closed</strong>
        <? } ?>        
    </td>
  </tr>
</table>


</div>
<script>
function edit_div(id){

  
 if (document.getElementById("div_"+id).style.display == "block"){
	document.getElementById("div_"+id).style.display = "none"; 
 } else {
	document.getElementById("div_"+id).style.display = "block"; 
  }
	

}
</script>
<? include "../includes/footer.php" ?>
<? }else{echo "Access Denied";} ?>
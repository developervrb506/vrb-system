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


?>

<link href="../css/style.css" rel="stylesheet" type="text/css" />

<title>View Ticket</title>
<script type="text/javascript" src="<?= BASE_URL ?>/process/js/ajax.js"></script>
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
<?php /*?><!--
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

 
 


<br /><br />--><?php */?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  
 
  <tr>
  	<td  <? if($current_clerk->im_allow("delete_tickets")){  echo ' colspan="9" '; } else { echo ' colspan="8" '; }?>  class="table_td_message">
    	<? echo nl2br($ticket->vars["message"]); ?>
       
        <br /><br />
        
        <? foreach(get_ticket_responses($ticket->vars["id"]) as $res){ ?>
  <div class="form_box" <? if($ticket->is_me($res->vars["by"])){echo 'style="background:#fbfdc2"';} ?>>
            	<strong><? echo $res->vars["by"] ?></strong> on <? echo $res->vars["rdate"] ?><br />
    			<? echo nl2br($res->vars["message"]) ?>
            </div>
        <? } ?>
       
        <div class="form_box">
        <? if($ticket->vars["open"]){ ?>
        <strong>Reply</strong><a name="reply" id="reply"></a><br />
        <form method="post" action="process/actions/ticket_action.php">
            <input name="tid" type="hidden" id="tid" value="<? echo $ticket->vars["id"] ?>" />
            <input name="internal" type="hidden" id="internal" value="1" />
            <input name="action" type="hidden" id="action" value="res" />
            <textarea name="reply_text" style="width:99%" rows="5" id="reply_text"></textarea><br />
            <div align="right"><input name="" type="submit" value="Submit" /></div>
        </form>          
        </div>
        <? }else{ ?>
        <strong>This Ticket is Closed</strong>
        <? } ?>        
    </td>
  </tr>
</table>
<BR><BR>
<div align="center">
<form method="post" action="process/actions/ticket_action.php" onsubmit="return confirm('Are you sure you want to Update this Ticket?')">
            <input name="tid" type="hidden" id="tid" value="<? echo $ticket->vars["id"] ?>" />
             <input name="internal" type="hidden" id="internal" value="1" />
			<? if(!$ticket->vars["completed"]){ ?>
             <input name="action" type="hidden" id="action" value="complete" />
             <input name="" type="submit" value="COMPLETED" />
            <? } else { ?> 
              <strong>Completed</strong><BR> 
             <input name="action" type="hidden" id="action" value="incomplete" />
             <input name="" type="submit" value="INCOMPLETE" />
            <? } ?>
            
        </form>

</div>

</div>

<? }else{echo "Access Denied";} ?>
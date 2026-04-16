<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->im_allow("tickets")){ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?= BASE_URL ?>/process/js/functions.js?v=2"></script>
<script type="text/javascript" src="<?= BASE_URL ?>/process/js/jquery.js"></script>
<link rel="stylesheet" href="<?= BASE_URL ?>/includes/shadowbox/shadowbox.css" type="text/css" media="screen" />
<script type="text/javascript" src="<?= BASE_URL ?>/includes/shadowbox/shadowbox.js"></script>
<script type="text/javascript" src="../../includes/calendar/jsDatePick.min.1.3.js"></script>
<script type="text/javascript" src="<?= BASE_URL ?>/process/js/ajax.js"></script>
<script type="text/javascript">
	Shadowbox.init();
</script>
<title>Tickets</title>
<script type="text/javascript">
var validations = new Array();
validations.push({id:"department",type:"different_str:Choose", msg:"Please choose a department"});	
</script>
<style>
.tkbox{
    display: none;
    width: 100%;
}

a:hover + .tkbox,.tkbox:hover{
    display: block;
    position: relative;
    z-index: 100;
}
</style>
<!--JavaScripts-->
<script type="text/javascript">

function delete_ticket(id){
	if(confirm("Are you sure you want to DELETE this ticket from the system?")){
		document.getElementById("idel").src = BASE_URL . "/ck/process/actions/delete_ticket.php?id="+id;
		document.getElementById("tr_"+id).style.display = "none";
	}
}

function remove_ticket(id){
	if(confirm("Are you sure you want to REMOVE this ticket from the system?")){
		document.getElementById("idel").src = BASE_URL . "/ck/process/actions/delete_ticket.php?removed=1&id="+id;
		document.getElementById("tr_"+id).style.display = "none";
	}
}


function show_comment(id,allow){
	
	
	if(document.getElementById("comment_text_"+id).style.display == "block"){
	
		document.getElementById("comment_text_"+id).style.display = "none";
		if(allow) {document.getElementById("comment_but_"+id).style.display = "none"; }
	} else if(document.getElementById("comment_text_"+id).style.display == "none"){
		document.getElementById("comment_text_"+id).style.display = "block";
		if(allow) {document.getElementById("comment_but_"+id).style.display = "block"; }
	}

}

function enable(){
  document.getElementById("btn_remove").disabled = false;
  document.getElementById("btn_delete").disabled = false;	

}

function action_checkbox(action,total){

  var tickets ;
  var check = false;
  var  action_string = action;
  
  if(action_string == 'rm'){ action_string = 'REMOVE'} else { action_string = "DELETE";}
  
  if(confirm("Are you sure you want to "+action_string+" this ticket from the system?")){
	   for (var i=1;i <= total;i++){
		 
		 
		  if (document.getElementById("ck_"+i)) {
			 if (document.getElementById("ck_"+i).checked){
				 tickets = document.getElementById("ck_"+i).value+","+tickets;
				 check = true;
				 document.getElementById("tr_"+document.getElementById("ck_"+i).value).style.display = "none";
				 
			 }
		  }
	   }
	  if (check){
		var tks = tickets.substring(0, tickets.length - 10);
		document.getElementById("idel").src = BASE_URL . "/ck/process/actions/delete_ticket.php?action="+action+"&tks="+tks;
	  }
  }
}




function mark_desmark(total){
	 enable();
	 for (var i=1;i <= total;i++){
	   if (document.getElementById("ck_"+i)) {
		 if (document.getElementById("mark_ck").checked){
			 document.getElementById("ck_"+i).checked = true;
		 } else {
		    document.getElementById("ck_"+i).checked = false;
		 }
	   }
	 }
	
}


</script>
</head>
<body>
<? $page_style = " width:100%;"; ?>
<? include "../includes/header.php" ?>
<? include "../includes/menu_ck.php" ?>
<div class="page_content" style="padding-left:10px;">

&nbsp;&nbsp;<span class="page_title">Open Tickets</span>
&nbsp;&nbsp;&nbsp;&nbsp;<a href="tickets_report.php" class="normal_link">Tickets Report</a>&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;<a href="tickets_time_report.php" class="normal_link">Time Report</a>&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;<a href="tickets_transfers_report.php" class="normal_link">Tickets Transfers Report</a>
&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;<a href="create_ticket.php" rel="shadowbox;height=500;width=500" class="normal_link">+ New Ticket</a>

<br /><br />

<div align="right">
     <iframe width="1" height="1" frameborder="0" scrolling="no" id="idel"></iframe>
</div>

<?
// Page logic
   if (isset($_POST["tk"])){
	  $tk = get_ticket($_POST["tk"]);
   
	 if($tk->vars["light"]){$tk->vars["light"] = '0';}
	 else{$tk->vars["light"] = '1';}	
	 $tk->update(array("light"));  
   
   }
   
    if (isset($_POST["tk_comment"])){
	  $tk = get_ticket($_POST["tk_comment"]);
   
	 $tk->vars["comment"]= $_POST["comment_text"];  	
	 $tk->update(array("comment"));  
   
   }


$categories = get_all_ticket_categories();
$groups = get_all_user_groups_chatids();
$live_help_departments = get_live_help_departments();
$live_help_depts = array();

foreach ($live_help_departments as $lhdep) {    
  $live_help_depts[] = $lhdep->vars["deptID"].'//'.$lhdep->vars["name"];
}

 $i=0;
      
   if($current_clerk->im_allow("all_tickets")){
	  $livechat_dept_id = 0; 
   }
   else {
	  //$livechat_dept_id = $current_clerk->vars["user_group"]->vars["chat_dept_id"];  
	  $user_group_id = $current_clerk->vars["user_group"]->vars["id"]; 
	  $chats_ids_per_group = get_all_user_groups_per_chat_department($user_group_id);
	  
	  foreach($chats_ids_per_group as $chat_id){		  
		 $livechat_id = $chat_id->vars["id_chat_dept"];
		 $livechat_dept_ids = $livechat_dept_ids.','.$livechat_id;		 		  
	  }
	  
	  $livechat_dept_ids =  substr($livechat_dept_ids,1);	 	 
   }   
   
    $removed = true;
	$cat_db = "";
	$acc_db = "";
	if ($_POST["category"] != ""){
	 $cat_db = $_POST["category"];
	}
	if ($_POST["account"] != ""){
	 $acc_db = $_POST["account"];
	}
	$completed = "";
	if ($_POST["completed"] == 1){
	 $completed = $_POST["completed"];
	}
	
	$page_index = param("page_index");
	if(!is_numeric($page_index)){$page_index = 0;}
	
	$items_per_page = 100;
	
    $tickets = search_tickets(date("Y-m-d",strtotime(date("Y-m-d")." - 1 month")), "", 1, "","agents",$livechat_dept_ids,"",$current_clerk->vars["id"],$removed,$cat_db,$acc_db,$completed,false,$items_per_page,($page_index*$items_per_page));
	$count_tickets = search_tickets(date("Y-m-d",strtotime(date("Y-m-d")." - 1 month")), "", 1, "","agents",$livechat_dept_ids,"",$current_clerk->vars["id"],$removed,$cat_db,$acc_db,$completed,true);
	$total_pages = ceil($count_tickets["total"]/$items_per_page);
   	$all_clerks = get_all_clerks_index(1, "",  false,true,"name");
  

//CheckActive Categories  // Accounts
$active_cat = array();
$active_acc = array();

if (!isset($_POST["active_cat"])){
	
	foreach ($tickets as $tc){
		
		if ($tc->vars["ticket_category"]){
		 $active_cat[$tc->vars["ticket_category"]]["id"] = $tc->vars["ticket_category"];
		 $active_cat[$tc->vars["ticket_category"]]["description"] = $categories[$tc->vars["ticket_category"]]->vars["description"];	
		}
		$active_acc[$tc->vars["player_account"]] = $tc->vars["player_account"];
		
	}
}else{
	 $act = explode(",",$_POST["active_cat"]);
	 $act_acc = explode(",",$_POST["active_account"]);
	 foreach ($act as $tc){
	  $active_cat[$tc]["id"] = $tc;
	  $active_cat[$tc]["description"] = $categories[$tc]->vars["description"];	
	 }
	  foreach ($act_acc as $cc){
	  $active_acc[$cc] = $cc;

	 }
	
}
sort($active_acc);


include "includes/print_error.php";
?> 
<!-- Search Categories-->
<form action="" method="post" id="former">
<input type="hidden" value="<? $page_index ?>" name="page_index" id="page_index" />
<input type="hidden" name="total_cat" value="<? echo count($active_cat)?>" >
&nbsp;&nbsp;<strong>  Select a Category:</strong>
<select name="category" id="category">
<option <? if ($cat_db == "" ) { echo ' selected="selected" ';}?> value="">All Tickets</option>
<option <? if ($cat_db == "0" ) { echo ' selected="selected" ';}?>value="0">Customs Tickets</option>
<? foreach ($active_cat as $ct) { $active_str .= $ct["id"].","; ?>

<option  <? if ($cat_db == $ct["id"] ){ echo ' selected="selected" ';}?> value="<? echo $ct["id"] ?>"><? echo $ct["description"] ?></option>
<? } ?>

</select>
<input type="hidden" name="active_cat" value="<? echo substr($active_str,0,-1)?>" >

&nbsp;&nbsp;<strong>  Select an Account:</strong>
<select name="account" id="account">
<option <? if ($cat_db == "" ) { echo ' selected="selected" ';}?> value="">All Accounts</option>
<? foreach ($active_acc as $cc) { $active_acc_str .= $cc.","; ?>
<option  <? if ($acc_db == $cc ){ echo ' selected="selected" ';}?> value="<? echo $cc ?>"><? echo $cc ?></option>
<? } ?>

</select>
&nbsp;&nbsp;
<input type="checkbox" name="completed" value="1" <? if ($completed == 1){ echo ' checked="checked" '; } ?> >&nbsp;<strong>Completed</strong>
<input type="hidden" name="active_account" value="<? echo substr($active_acc_str,0,-1)?>" >
&nbsp;&nbsp;<input type="submit" value="Search"> 
 </form>
 <BR> <BR>
  <span>&nbsp;&nbsp;&nbsp;<strong><? echo count($tickets)?> Tickets</strong></span>
 
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
   <? if($current_clerk->im_allow("delete_tickets")){ ?>
    <td class="table_header" align="center">
     <div style="float: left; ">
      <input type="checkbox" id="mark_ck" onchange="mark_desmark('<? echo count($tickets) ?>')" style="width:30px; height:30px" />
     </div>
     <div  style="float: right;">
     <input  onclick="action_checkbox('rm','<? echo count($tickets) ?>')" disabled="disabled" id="btn_remove" type="button" value="REMOVE" style="width: 45px;font-size: 8px; margin-bottom:3px"><BR>
    <input  onclick="action_checkbox('del','<? echo count($tickets) ?>')" disabled="disabled" id="btn_delete" type="button" value="DELETE" style="width: 45px;font-size: 8px;">
     </div>
    </td>
    <td class="table_header" align="center"></td>
   <? } ?> 
    <td class="table_header" align="center"></td>
    <td class="table_header" align="center">Id</td>
    <td class="table_header" align="center">Date</td>
    <td class="table_header" align="center">From</td>
    <td class="table_header" align="center">Subject</td>
    <td class="table_header" align="center">Website</td>
    <td class="table_header" align="center">Attended BY</td>
    <? //if($current_clerk->im_allow("all_tickets")){ ?><td class="table_header" align="center">Department</td><? //} ?>     
    <td class="table_header" align="center"></td>
     <? if($current_clerk->im_allow("delete_tickets")){ ?>
    <td class="table_header" align="center"></td>
    <td class="table_header" align="center"></td>
    <? } ?>
    <td class="table_header" align="center">Transfer</td>
  </tr>
  <?
   foreach($tickets as $tk){
       if($i % 2){$style = "1";}else{$style = "2";}$i++;
	   if($tk->vars["light"]){$style .= "_red";} 
	   $tgroup = $groups[$tk->vars["dep_id_live_chat"]];
	   
	    //checking if it is pending of response
		$responses = get_ticket_responses($tk->vars["id"]);
		
		
		
		
		
		if(count($responses)>0){

		   if (!isset($all_clerks[$responses[count($responses)-1]->vars["by"]])){
			  if (contains_ck($style,"_red")){
				$style = str_replace("_red","_yellow",$style);  
			  }
			  else {
				  $style .= "_yellow";
			  }
			
		   }
				
		}
		
		// Asigneed
		
		$clerk = get_ticket_clerk($tk->vars["id"]);
		if(!is_null($clerk)){$assigned_by = $clerk->vars["name"];}
		else{ 
			
			if(count($responses)>0 || !$tk->vars["open"]){
				
				$assigned = false;
				for ($k=count($responses); $k>=0;$k--){
				
				   if ((contains_ck($responses[$k]->vars["message"],"assigned")) || (isset($all_clerks[$responses[$k]->vars["by"]]))){
				   $assigned_by = $responses[$k]->vars["by"];
				   $assigned = true;
   				   break;
				   }
				}
				if(!$assigned){
					
					 if (isset($all_clerks[$responses[0]->vars["by"]])){
						$assigned_by = $responses[0]->vars["by"];
					 }
					 else{
						 if (isset($all_clerks[$responses[1]->vars["by"]])){
						     $assigned_by = $responses[1]->vars["by"];
						
						 }else{
						 $assigned_by = '<strong style="color:#F00;">Unattended</strong>';
						 }
						
						 }
				 }
				
				}
			
			
			
			else{ $assigned_by = '<strong style="color:#F00;">Unattended</strong>'; }
		}
		

		?>
	   
	   
	   
	   
 
  <tr  <?  if(!$current_clerk->im_allow("delete_tickets")){ ?>title="<? echo small_text(strip_tags($tk->vars["message"]),150); ?>" <? } ?> id="tr_<? echo $tk->vars["id"]; ?>">
    
     <? $allow = false;
	 if($current_clerk->im_allow("delete_tickets")){ $allow = true ?>
     <td class="table_td<? echo $style ?>" align="center">
     <input onchange="enable();" type="checkbox" style="width:20px; height:20px" id="ck_<? echo $i; ?>" name="ck_<? echo $tk->vars["id"]; ?>" value="<? echo $tk->vars["id"]; ?>">
     </td>
      
     <td class="table_td<? echo $style ?>" align="center">
       <form method="post" action="" >
       <input name="tk" type="hidden" id="tk<? echo $tk->vars["id"] ?>" value="<? echo $tk->vars["id"] ?>" />
               
         <input type="image" style="width: 30px;" src="<?= BASE_URL ?>/ck/images/pencil.png" />
        </form>
     </td>
    <? } ?>
    <td class="table_td<? echo $style ?>" align="center">
       <?
	      $comment_img = "question-green.png";
		   $comment = false;
          if($tk->vars["comment"]!=""){ $comment_img = "question-orange.png"; $comment=true;}
	   
	    ?>
      
       <form method="post" action="" >
       <input name="tk_comment" type="hidden" id="comment<? echo $tk->vars["id"] ?>" value="<? echo $tk->vars["id"] ?>" />
         
         <? if ($comment || $allow){ ?>       
         <img title="<? echo $tk->vars["comment"] ?>" style="width: 30px;" src="<?= BASE_URL ?>/ck/images/<? echo $comment_img?>" onclick="show_comment('<? echo $tk->vars["id"]?>','<? echo $allow ?>')" />
         <textarea  required="required" <? if (!$allow){ echo ' readonly="readonly"' ;} ?> style="display:none" cols="12" rows="6" name="comment_text" id="comment_text_<? echo $tk->vars["id"]?>"><? echo $tk->vars["comment"] ?></textarea>
         
         <input type="submit" value="Save" style="display:none" id="comment_but_<? echo $tk->vars["id"]?>">
         <? } ?>
        </form>
        
     </td>
    
    <td class="table_td<? echo $style ?>" align="center"><? echo $tk->vars["id"]; ?></td>
	<td class="table_td<? echo $style ?>" align="center"><? echo $tk->vars["tdate"]; ?></td>
    <td  <?  if($current_clerk->im_allow("delete_tickets")){ ?>title="<? echo small_text(strip_tags($tk->vars["message"]),150); ?>" <? } ?>  class="table_td<? echo $style ?>" align="center"><? echo $tk->vars["name"]; ?><br />
	<a href="<?= BASE_URL ?>/ck/cashier/player_detail.php?pid=<? echo $tk->vars["player_account"] ?>" class="normal_link" rel="shadowbox;height=220;width=500"><? echo $tk->vars["player_account"] ?></a>
	
    
    <? if ($tk->vars["email"] != "") { echo '<br />'.$tk->vars["email"]; } ?>
	<? if ($tk->vars["phone"] != "") { echo '<br /> Phone Number: '.$tk->vars["phone"]; } ?>
    </td>
    <td class="table_td<? echo $style ?>" align="center">
    <div align="left">
     
     <?
	 if ($categories[$tk->vars["ticket_category"]]->vars["instructions"] != "") {?>
     
	<a rel="shadowbox;height=280;width=400" href="<?= BASE_URL ?>/ck/ticket_instructions.php?c=<? echo $tk->vars["ticket_category"] ?>" title="Ticket Instructions">
      <img style="height: 20px;width: 20px;"   title='Instructions: <?  echo clean_chars($categories[$tk->vars["ticket_category"]]->vars["instructions"]) ?>' src="images/info1.png" />
    </a>
    <? } ?>
                  
    </div>
      <? if($current_clerk->im_allow("delete_tickets")){ ?>
     <a rel="shadowbox;height=300;width=400" class="normal_link" href="<?= BASE_URL ?>/ck/view_ticket_internal.php?tid=<? echo $tk->vars["id"] ?>" style="color:#000" >
      <? } ?>
	<? echo $tk->vars["subject"]; ?>
       <? if($current_clerk->im_allow("delete_tickets")){ ?>
    </a>
    <?php /*?><div id="r_<? echo $tk->vars["id"]; ?>" name="r_<? echo $tk->vars["id"]; ?>" class="tkbox"><iframe src="<?= BASE_URL ?>/ck/view_ticket_internal.php?tid=<? echo $tk->vars["id"] ?>" width = "550px" height = "300px"></iframe></div><?php */?>
      <? } ?>
      
      
      <? if($current_clerk->im_allow("delete_tickets")){ ?>
      <? if(count($responses)>0){ ?>
       <div align="left">
 		
       <a href="<?= BASE_URL ?>/ck/view_ticket_internal.php?tid=<? echo $tk->vars["id"] ?>" rel="shadowbox;height=300;width=400" >
       <img style="height: 20px;width: 20px;"    src="images/response.png" />
       </a>
       
   
      
      </div>
         <? } ?>
		  <? if ($tk->vars["completed"]) { ?>
          <div align="rigth" style="float: right; margin-top: -30px;" >
           <img style="height: 20px;width: 20px;"    src="../images/check.png" />
          </div>
          <? } ?>
      <? } ?>
      </td>
    <td class="table_td<? echo $style ?>" align="center"><? echo $tk->vars["website"]; ?>
    </td>        
    <td class="table_td<? echo $style ?>" align="center"><? echo $assigned_by ?>   </td>    

    <? //if($current_clerk->im_allow("all_tickets")){ ?>
    <td class="table_td<? echo $style ?>" align="center"><? echo $tgroup->vars["name"]; ?></td>
	<? //} ?>     
    <td class="table_td<? echo $style ?>" align="center">
    	<a href="view_ticket.php?tid=<? echo $tk->vars["id"]; ?>" target="_blank" class="normal_link">View</a>
    </td>  
     <? if($current_clerk->im_allow("delete_tickets")){ ?>
    <td class="table_td<? echo $style ?>" align="center">
    	  <a class="normal_link" href="javascript:;" onclick="delete_ticket('<? echo $tk->vars["id"] ?>');">
        	Delete
        </a>
    </td>
     <td class="table_td<? echo $style ?>" align="center">
    	  <a class="normal_link" href="javascript:;" onclick="remove_ticket('<? echo $tk->vars["id"] ?>');">
        	Remove 
        </a>
    </td>
    <? } ?> 
    
    <td class="table_td<? echo $style ?>" align="center">    	
        <form method="post" name="form<? echo $tk->vars["id"] ?>" id="form<? echo $tk->vars["id"] ?>" action="process/actions/ticket_transfer_department.php" onSubmit="return validate(validations)">
          <input name="ticketid" type="hidden" id="ticketid" value="<? echo $tk->vars["id"] ?>">
          <input name="deptid_source" type="hidden" id="deptid_source" value="<? echo $tk->vars["dep_id_live_chat"] ?>">
          
           <div id="div_dep" style="block"  >
            <?
  	           $on_change = "from_ajax(this.value,'div_clerk_".$tk->vars["id"]."','./process/actions/ticket_clerks_by_group.php')";
            ?>
             
              <select onchange="<? echo $on_change ?>" name="department" id="department<? echo $tk->vars["id"] ?>">        
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
              <div name="div_clerk_<? echo $tk->vars["id"] ?>" id="div_clerk_<? echo $tk->vars["id"] ?>">
                 Clerk: 
                 <select onchange="" name="to_clerk" id="to_clerk"  class="">
 
                 <option value="" id="select"  selected="selected">Free</option>
    
               </select>
             </div>
              
              
              
              
              
              <input name="" type="submit" value="Transfer">         
        </form>
    </td>    
     
  </td>
  <? }  ?>
  <tr>
    <? if($current_clerk->im_allow("delete_tickets")){ ?>
    <td class="table_last"></td>
	<td class="table_last"></td>     
     <? } ?>
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
      <td class="table_last"></td>
     <? } ?>
    <td class="table_last"></td>
     <td class="table_last"></td>
  </tr>

</table>



<script type="text/javascript">
function change_page(page){
	//former
	$("#page_index").val(page);
	$("#former").submit();
}
</script>

<br /><br />
<div align="center">

<? for($i=0;$i<$total_pages;$i++){ ?>
<a href="javascript:;" class="normal_link" onclick="change_page(<? echo $i ?>);" <? if($page_index == $i){ ?> style="font-weight:bold; text-decoration:underline;"<? } ?>><? echo ($i+1) ?></a>&nbsp;&nbsp;
<? } ?>

</div>


</div>
<? include "../includes/footer.php" ?>
<? }else{echo "Access Denied";} ?>

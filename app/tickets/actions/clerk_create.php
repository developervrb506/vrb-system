<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->im_allow("tickets")){ ?>
<?
	$department_id  = clean_str_ck($_POST["department"]);
	$department     = get_live_help_department($department_id);
    	
   if(!$_POST["broadcast"]){

	$ticket = new _ticket();
	
	$ticket->vars["name"] = clean_str_ck($_POST["name"]);
	$ticket->vars["email"] = clean_str_ck($_POST["email"]);
	$ticket->vars["phone"] = "";
	$ticket->vars["player_account"] = clean_str_ck($_POST["player"]);
	$ticket->vars["website"] = "VRB";
	$ticket->vars["subject"] = clean_str_ck($_POST["subject"]);
	$ticket->vars["message"] =  //clean_str_ck($_POST["msg"]);
	$ticket->vars["category"] = "agents";
	$ticket->vars["tdate"] = date("Y-m-d H:i:s");
	$ticket->vars["ticket_category"] = 21;	
	$ticket->vars["dep_id_live_chat"] = $department_id;
	
	$ticket->insert();
	$ticket->vars["message"] = "";
	
	$res = $ticket->insert_response(clean_str_ck($_POST["msg"]), $current_clerk->vars["name"],$current_clerk->vars["id"]);
	
		
	//customer email
	$content = "You have a new TICKET ALERT. <br /><br />";
	$content .= nl2br($_POST["msg"]);
	$content .= "<br /><br />";
	$content .= "To view this Ticket please <a href='http://vrbmarketing.com/tickets/ticket.php?tid=".$ticket->get_password()."&deptid=".$department_id."&mobile=".$mobile."'>Click Here</a>";
	send_email_ck_auth($ticket->vars["email"], "Ticket Alert", $content, true, "support@vrbmarketing.com", $ticket->vars["website"]);
	send_email_ck_auth("mrinnier@gmail.com", "Ticket Alert", $content, true, "support@vrbmarketing.com", $ticket->vars["website"]);
   
   }
   else {
	   
	  
	$ticket = new _master_ticket();
	$ticket->vars["website"] = "VRB";
	$ticket->vars["subject"] = clean_str_ck($_POST["subject"]);
	$ticket->vars["message"] = clean_str_ck($_POST["msg"]);
	$ticket->vars["tdate"] = date("Y-m-d H:i:s");
	$ticket->vars["ticket_category"] = 33;	
	$ticket->vars["dep_id_live_chat"] = $department_id;
	
	$ticket->insert();
	   
	   
	   
	}
   
   
   
	
	header("Location: http://localhost:8080/ck/tickets.php?e=96");
	

}
?>
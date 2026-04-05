<? include(ROOT_PATH . "/ck/db/handler.php"); ?>
<?
//



$mobile         = clean_str_ck($_POST["mobile"]);
$department_id  = clean_str_ck($_POST["department"]);
$target_agent  = clean_str_ck($_POST["target_agent"]);
$wpx  = clean_str_ck($_POST["wpx"]);
if($wpx != ""){$_POST["player_account"] = two_way_enc($wpx, true);}


$cat = clean_str_ck($_POST["cat"]);
if($cat == "agents"){
	$cat = 15;
	$department_id = 4;
}

$department = get_live_help_department($department_id);

$ticket = new _ticket();

$ticket->vars["name"] = clean_str_ck($_POST["name"]);
$ticket->vars["email"] = clean_str_ck($_POST["email"]);
$ticket->vars["phone"] = clean_str_ck($_POST["phone"]);
$ticket->vars["player_account"] = clean_str_ck($_POST["player_account"]);
$ticket->vars["website"] = clean_str_ck($_POST["web"]);
$ticket->vars["subject"] = clean_str_ck($_POST["subject"])." (".$ticket->vars["website"].")";
$ticket->vars["message"] = clean_str_ck($_POST["message"]);
$ticket->vars["category"] = clean_str_ck($_POST["cat"]);
$ticket->vars["ticket_category"] = $cat;
if($target_agent != ""){$ticket->vars["for_agent"] = $target_agent;}
$ticket->vars["tdate"] = date("Y-m-d H:i:s");
$ticket->vars["dep_id_live_chat"] = $department_id;
$ticket->vars["pending_answer"] = 1;
print_r($ticket);
$ticket->insert();

if($target_agent != ""){
	$agent_ticket = new _ticket();
	$agent_ticket->vars["name"] = $target_agent;
	$agent_ticket->vars["email"] = clean_str_ck($_POST["email"]);
	$agent_ticket->vars["phone"] = clean_str_ck($_POST["phone"]);
	$agent_ticket->vars["player_account"] = $target_agent;
	$agent_ticket->vars["website"] = clean_str_ck($_POST["web"]);
	$agent_ticket->vars["subject"] = clean_str_ck($_POST["subject"])."";
	$agent_ticket->vars["message"] = "";
	$agent_ticket->vars["category"] = clean_str_ck($_POST["cat"]);
	$agent_ticket->vars["tdate"] = date("Y-m-d H:i:s");
	$agent_ticket->vars["for_agent"] = "TO:".$target_agent;
	$agent_ticket->vars["dep_id_live_chat"] = $department_id;
	$agent_ticket->vars["related_ticket"] = $ticket->vars["id"];
	$ticket->vars["ticket_category"] = clean_str_ck($_POST["tk_cat"]);	
	$ticket->vars["pending_answer"] = 1;
	$agent_ticket->insert();
	$agent_ticket->insert_response(clean_str_ck($_POST["message"]), $ticket->vars["name"]." (".$ticket->vars["player_account"].")");
	
	$ticket->vars["related_ticket"] = $agent_ticket->vars["id"];
	$ticket->update(array("related_ticket"));
	
	$no_email = true;
	
}

if(!$no_email){

	//customer email
	$content = "Thank you for your TICKET ALERT. <br />";
	$content .= "We have received your request and a representative will respond shortly.<br />";
	$content .= "Important: Please check your spam folder and make us a trusted website.<br />";
	$content .= "To view this Ticket please <a href='http://vrbmarketing.com/tickets/ticket.php?tid=".$ticket->get_password()."&deptid=".$department_id."&mobile=".$mobile."'>Click Here</a>";
	send_email_ck_auth($ticket->vars["email"], "Ticket Alert", $content, true, "support@vrbmarketing.com", $ticket->vars["website"]);
	
	send_email_ck_auth("mrinnier@gmail.com", "Ticket Alert", $content, true, "support@vrbmarketing.com", $ticket->vars["website"]);
	
	//clerks emails
	$acontent = "New Ticket inserted from ".$ticket->vars["name"]." (".$ticket->vars["email"].")<br /><br />";
	$acontent .= nl2br($_POST["message"]);
	$acontent .= "<br /><br />";
	$acontent .= "<a href='http://localhost:8080/ck/view_ticket.php?tid=".$ticket->vars["id"]."'>Click here to respond</a>";
	
	/*$clerk = get_clerk_by_name($ticket->vars["category"]);
	
	if(is_null($clerk) or $clerk == ""){	
		send_email_ck_auth($department->vars["email"], "New Ticket"." (".$ticket->vars["website"].")", $acontent, true);
	}else{
		send_email_ck_auth($clerk->vars["email"], "New Ticket"." (".$ticket->vars["website"].")", $acontent, true);
	}
	*/
	
	send_email_ck_auth($department->vars["email"], "New Ticket"." (".$ticket->vars["website"].")", $acontent, true);
	
	send_email_ck_auth("mrinnier@gmail.com", "New Ticket"." (".$ticket->vars["website"].")", $acontent, true);
	
	//header("Location: ../ticket.php?tid=".$ticket->get_password());

}

if (isset($mobile) and $mobile == 1) { 
   header("Location: ../thanks.php?web=".$ticket->vars["website"]."&mobile=".$mobile."&wpx=".$wpx);
} else {
   header("Location: ../thanks.php?web=".$ticket->vars["website"]."&wpx=".$wpx);	
}
?>
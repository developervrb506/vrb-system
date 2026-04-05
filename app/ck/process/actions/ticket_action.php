<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if(($current_clerk->im_allow("tickets")) || ($current_clerk->im_allow("tickets_clerk"))){ ?>
<?
$ticket = get_ticket($_POST["tid"]);

if(!is_null($ticket)){

	switch($_POST["action"]){
		case "res":
		    $ticket->vars["pending_answer"] = 0;
			$ticket->update(array("pending_answer"));
			
			$xfile_name = clean_str_ck($_POST["xfile_name"]);
			$xfile_code = clean_str_ck($_POST["xfile"]);
			if($xfile_name != ""){
				$phi_file = @file_get_contents("https://receipts.vrbmarketing.com/uploads/file.php?name=".$xfile_code);
				$file_link = '<br /><br /><a href="https://receipts.vrbmarketing.com/uploads/files/'.$phi_file.'" target="_blank">'.$xfile_name.'</a>'; 
			}
			
			$res = $ticket->insert_response(clean_str_ck($_POST["reply_text"]).$file_link, $current_clerk->vars["name"],$current_clerk->vars["id"]);
			//clerks emails
			$acontent = 'New Ticket response to "'.$ticket->vars["subject"].'"<br /><br />';
			$acontent .= nl2br($_POST["reply_text"]);
			$acontent .= "<br /><br />";
			$acontent .= "To view this Ticket please <a href='http://vrbmarketing.com/tickets/ticket.php?tid=".$ticket->get_password()."'>Click Here</a>";
			
			if($ticket->vars["email"] != "none@none.com" && $ticket->vars["email"] != "test@test.com"){			  		   
			  
			       send_email_ck_auth($ticket->vars["email"], "New Ticket Response", $acontent, true, "support@vrbmarketing.com", $ticket->vars["website"]);
				   
				   send_email_ck_auth("mrinnier@gmail.com", "New Ticket Response", $acontent, true, "support@vrbmarketing.com", $ticket->vars["website"]);
				
			   $extra = "#reply";
			}
			
		break;
		case "close":
			$ticket->vars["open"] = "0";
			$ticket->vars["updated"] = "0";
			$ticket->update(array("open","updated"));
			//Line added by Andy Hines 09/22/2014, so once a ticket is closed we can have track of the clerk that attendeded it or closed it.			
			$res = $ticket->insert_response('Ticket Closed', $current_clerk->vars["name"],$current_clerk->vars["id"]);			
		break;
		case "complete":
			$ticket->vars["completed"] = "1";
			$ticket->update(array("completed"));
			$res = $ticket->insert_response(" ", $current_clerk->vars["name"],$current_clerk->vars["id"]);
			
		break;
		case "incomplete":
			$ticket->vars["completed"] = "0";
			$ticket->update(array("completed"));
			
		break;
		case "t_edit":
			$ticket->vars["message"] = nl2br($_POST["new_message"]);
			$ticket->vars["updated"] = "0";
			$ticket->update(array("message","updated"));
			
		break;
		case "r_edit":
			
			 $res = get_ticket_response($_POST["rid"]); 
			 $res->vars["message"] = nl2br($_POST["new_response"]);
			 $res->vars["updated"] = "0";
			 $res->update(array("message","updated"));
			
		break;
		
		
		
		
	}

}
if (!isset($_POST["internal"])){
 header("Location: ../../view_ticket.php?tid=".$ticket->vars["id"].$extra);
}
else{
 header("Location: ../../view_ticket_internal.php?tid=".$ticket->vars["id"].$extra);	
}

?>
<? }else{echo "Access Denied";} ?>
<? include(ROOT_PATH . "/ck/db/handler.php"); ?>
<?
$department = get_live_help_department(clean_str_ck($_POST["dept_id"]));
$mobile     = clean_str_ck($_POST["mobile"]);

if (!isset($_POST["master"])){
 $ticket     = get_ticket(clean_str_ck(get_ticket_id($_POST["tid"])));
} else {
	
  	$account = two_way_enc($_POST["master"],true);
	//Insert a control to remove from masters
	$log = new _master_players_tickets();
	$log->vars["account"] = $account;
	$log->vars["id_ticket"] = get_ticket_id($_POST["tid"]);	
	$log->insert();
	
	
	$player = json_decode(@file_get_contents("http://www.sportsbettingonline.ag/utilities/process/reports/get_player.php?pid=".$_POST["master"]));
	
	
	$master_ticket = get_master_ticket(get_ticket_id($_POST["tid"]));
	
	//If a player respond Create a Ticket
	$ticket = new _ticket();
	$ticket->vars["name"] = $player->vars->Name." ".$player->LastName;
	$ticket->vars["email"] = $player->vars->Email;
	$ticket->vars["phone"] = $player->vars->Phone;
	$ticket->vars["player_account"] = $account;
	$ticket->vars["website"] = "VRB";
	$ticket->vars["subject"] = $master_ticket->vars["subject"];
	$ticket->vars["message"] = $master_ticket->vars["message"];
	$ticket->vars["category"] = "agents";
	$ticket->vars["tdate"] = date("Y-m-d H:i:s");
	$ticket->vars["ticket_category"] = 33;	
	$ticket->vars["dep_id_live_chat"] = $master_ticket->vars["dep_id_live_chat"];
	$ticket->insert();
	
	
}
 


if(!is_null($ticket)){
	
$res = $ticket->insert_response(clean_str_ck($_POST["message"]), $ticket->vars["name"]);

if($ticket->vars["related_ticket"] > 0){
	$relticket = get_ticket($ticket->vars["related_ticket"]);
	$relticket->insert_response(clean_str_ck($_POST["message"]), $ticket->vars["name"]);
	$noemail = true;
}


if(!$noemail){
	
	//clerks emails
	$acontent = 'New Ticket response to "'.$ticket->vars["subject"].'"<br /><br />';
	$acontent .= nl2br($_POST["message"]);
	$acontent .= "<br /><br />";
	$acontent .= "<a href='\" . BASE_URL . \"/ck/view_ticket.php?tid=".$ticket->vars["id"]."'>Click here to respond</a>";
	
	send_email_ck_auth($department->vars["email"], "New Ticket Response", $acontent, true);
	send_email_ck_auth("mrinnier@gmail.com", "New Ticket Response", $acontent, true);	

}







if (isset($mobile) and $mobile == 1) { 
   header("Location: ../ticket.php?tid=".$ticket->get_password()."&mobile=".$mobile);
} else {
   header("Location: ../ticket.php?tid=".$ticket->get_password());
}

}else{echo "No Ticket Available";}

?>
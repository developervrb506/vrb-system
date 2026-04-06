<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<?
$ticket = get_ticket($_POST["ticketid"]);
$dep = $_POST["department"];
$dep_source = $_POST["deptid_source"];
$clerk =  $_POST["to_clerk"];

$view = false;
if (isset($_POST["view"])){ $view = true; }


if ($clerk != ""){
	
	$index_clerk = get_all_clerks_index($available = "", $level = "", $deleted = false,"id");
	$msg = "The ticket was assigned to ".$index_clerk[$clerk]->vars["name"];
	$res = $ticket->insert_response($msg, $index_clerk[$clerk]->vars["name"],0);
	
		
	/*//customer email
	$content = "You have a new TICKET ALERT. <br /><br />";
	$content .= nl2br($_POST["msg"]);
	$content .= "<br /><br />";
	$content .= "To view this Ticket please <a href='http://vrbmarketing.com/tickets/ticket.php?tid=".$ticket->get_password()."&deptid=".$department_id."&mobile=".$mobile."'>Click Here</a>";
	send_email_ck_auth($ticket->vars["email"], "Ticket Alert", $content, true, "support@vrbmarketing.com", $ticket->vars["website"]);	
    */

}

$ticket->vars["dep_id_live_chat"] = $dep;

$ticket->update(array("dep_id_live_chat"));

//Insert ticket transfer record

$ticket_transfer = new _ticket_transfers_log();

$ticket_transfer->vars["ticket_id"] = $_POST["ticketid"];
$ticket_transfer->vars["tdate"] = date("Y-m-d H:i:s");
$ticket_transfer->vars["clerk"] = $current_clerk->vars["id"];
$ticket_transfer->vars["depid_source"] = $dep_source;
$ticket_transfer->vars["depid_destination"] = $dep;

$ticket_transfer->insert();

if ($view){
	header("Location: " . BASE_URL . "/ck/view_ticket.php?tid=".$_POST["view"]);
}
else{
	header("Location: " . BASE_URL . "/ck/tickets.php");	
}

?>
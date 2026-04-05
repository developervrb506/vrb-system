<? include(ROOT_PATH . "/ck/db/handler.php"); ?>
<?
$ticket = get_ticket(clean_str_ck(get_ticket_id($_GET["tid"])));
$mobile = clean_str_ck($_GET["mobile"]);

if(!is_null($ticket)){
	
$ticket->vars["open"] = "0";
$ticket->update(array("open"));

if (isset($mobile) and $mobile == 1) { 
   header("Location: ../ticket.php?tid=".$ticket->get_password()."&mobile=".$mobile);
} else {
   header("Location: ../ticket.php?tid=".$ticket->get_password());	
}

}else{echo "No Ticket Available";}

?>
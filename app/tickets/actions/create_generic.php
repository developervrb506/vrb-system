<? include(ROOT_PATH . "/ck/db/handler.php"); ?>
<?
$department_id  = clean_str_ck($_POST["department"]);
$department     = get_live_help_department($department_id);
$thankyoupage   = clean_str_ck($_POST["thankyoupage"]);
$phone          = clean_str_ck($_POST["phone"]);
$email          = clean_str_ck($_POST["email"]);

if (isset($phone) and $phone != "") {
	$phone_msj = "<br />Phone Number: ".$phone;
}

if (isset($email) and $email != "") {
	$email_msj = "<br />Email: ".$email;
}

$ticket = new _ticket();

$ticket->vars["name"] = clean_str_ck($_POST["name"]);
$ticket->vars["email"] = clean_str_ck($_POST["email"]);
$ticket->vars["website"] = clean_str_ck($_POST["web"]);
$ticket->vars["subject"] = clean_str_ck($_POST["subject"])." (".$ticket->vars["website"].")";
$ticket->vars["message"] = clean_str_ck($_POST["message"]).$phone_msj.$email_msj;
$ticket->vars["category"] = clean_str_ck($_POST["cat"]);
$ticket->vars["tdate"] = date("Y-m-d H:i:s");
$ticket->vars["dep_id_live_chat"] = $department_id;

$ticket->insert();

//customer email
$content = "Thank you for your TICKET ALERT. <br />";
$content .= "We have received your request and a representative will respond shortly.<br />";
$content .= "To view this Ticket please <a href='http://vrbmarketing.com/tickets/ticket.php?tid=".$ticket->get_password()."&deptid=".$department_id."&mobile=".$mobile."'>Click Here</a>";

send_email_ck_auth($ticket->vars["email"], "Ticket Alert", $content, true, "support@vrbmarketing.com", $ticket->vars["website"]);

send_email_ck_auth("mrinnier@gmail.com", "Ticket Alert", $content, true, "support@vrbmarketing.com", $ticket->vars["website"]);

header("Location: $thankyoupage");
?>


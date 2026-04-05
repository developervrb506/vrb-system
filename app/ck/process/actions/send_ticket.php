<? include(ROOT_PATH . "/ck/process/security.php"); ?>

<?


$id = param("id") ;
$data = param("data");
$acc = param("acc");
$message = param("message");
$tk_cat = param("cat");
$subject = param("subject");

$player = json_decode(file_get_contents("http://www.sportsbettingonline.ag/utilities/process/reports/get_player.php?pid=".two_way_enc($acc)));


$categories = get_all_ticket_categories();
//print_r($categories);

		$ticket = new _ticket();	
		$ticket->vars["name"]     = $player->vars->Name.' '.$player->vars->LastName;
		$ticket->vars["email"]    = $player->vars->Email;
		$ticket->vars["player_account"] = $acc;
		$ticket->vars["website"]  = "VRB";
		$ticket->vars["subject"]  = $subject;
		$ticket->vars["message"]  = $message;
		$ticket->vars["category"] = "agents";
		$ticket->vars["tdate"]    = date("Y-m-d H:i:s");
		$ticket->vars["dep_id_live_chat"] = $categories[$tk_cat]->vars["dep_id_live_chat"];
		$ticket->vars["trans_id"] = $id;	
		$ticket->vars["ticket_category"] = $tk_cat;	
        $ticket->insert();	  
 $email = $player->vars->Email;
 //$email = 'aandrade@inspin.com';
//customer email
	send_email_ck_auth($email, $subject, $message, true, "support@vrbmarketing.com", $ticket->vars["website"]);
	
?>

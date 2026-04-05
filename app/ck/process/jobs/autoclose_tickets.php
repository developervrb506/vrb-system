<? $no_log_page = true; ?>
<? require_once(ROOT_PATH . "/ck/db/handler.php"); ?>
<?
$tickets = get_tickets_to_close();
$all_clerks = get_all_clerks_index(1, "",  false,true,"name");

$today =  date("y-m-d H:i:s");
foreach ($tickets as $tk) {

 $pending = false;

 $hourdiff = round((strtotime($today) - strtotime($tk->vars["last"]))/3600);
 
   if ($hourdiff >= 48){
	   
	   
	   if($tk->vars["pending_answer"]){
	     $pending = true;
	   }
	   
	   
	   if (!$pending){
	   
	   echo  "Ticket closed: ". $tk->vars["id"]."<BR>";
	   $ticket = get_ticket($tk->vars["id"]); 
	   if(!is_null($ticket)){
				$ticket->vars["open"] = "0";
				$ticket->vars["pread"] = "1";
				$ticket->update(array("open","pread"));
				$res = $ticket->insert_response('This ticket alert has been automatically closed because there has been no activity in 48 hours. We hope your question was handled properly. If not, please open a new ticket alert and a customer service representative will help as soon as possible.', 'System','220');	
				$content = "The ticket alert ".$tk->vars["id"]." has been automatically closed because there has been no activity in 48 hours. We hope your question was handled properly. If not, please open a new ticket alert and a customer service representative will help as soon as possible".
                $email = $tk->vars["email"];
				$sub = "Ticket Update";
				send_email_ck($email, $sub, $content, true, "support@vrbmarketing.com", "VRB_SUPPORT");
				//$email = "alexis.andrade@gmail.com";
				//send_email_ck($email, $sub, $content, true,  "support@vrbmarketing.com","VRB");
				
					
	   }
	   
	  } // Not Pending
   
   }

}
echo "DONE";

?>
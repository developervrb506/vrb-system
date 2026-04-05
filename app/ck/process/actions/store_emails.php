<? $no_log_page = true; ?>
<? include(ROOT_PATH . "/ck/db/handler.php"); ?>
<?
$today = date("Y-m-d");
$pointer = get_account_pointer();
$block = 10;
$total_accounts = count_available_emails_accounts();

if($pointer->vars["position"] > $total_accounts["num"]){$pointer->vars["position"] = 0;}

$accounts = get_available_emails_accounts($pointer->vars["position"],$block);

$pointer->vars["position"] += $block;
$pointer->update();

$boxes = array("INBOX","Sent Items");

foreach($accounts as $acc){
	
	foreach($boxes as $box){

		$imap = new _imap($acc->vars["name"],$acc->vars["pass"]);
		$imap->connect($box);
		
		$messages = $imap->messages_by_date($today);
		
		if(is_array($messages)){
		
			foreach($messages as $uid){
				
				$header = $imap->get_message_header($uid);
				
				/*print_r($header);
				echo "<br /><br />";*/
				
				$email = new _email_message();
				$email->vars["account"] = $acc->vars["id"];
				$email->vars["edate"] = date("Y-m-d H:i:s",strtotime($header->date));
				$email->vars["subject"] = $header->subject;
				
				$to_name = "";
				$to_address = "";
				foreach($header->to as $to){
					$to_address .= ", ".$to->mailbox."@".$to->host;
					$to_name .= ", ".$to->personal;
				}
				
				$from_name = "";
				$from_address = "";
				foreach($header->from as $from){
					$from_address .= ", ".$from->mailbox."@".$from->host;
					$from_name .= ", ".$from->personal;
				}
				
				$email->vars["to_name"] = substr($to_name,2);
				$email->vars["to_address"] = substr($to_address,2);
				$email->vars["from_name"] = substr($from_name,2);
				$email->vars["from_address"] = substr($from_address,2);
				$email->vars["body"] = $imap->get_body($uid);
				$email->create_hash();
				
				if($email->vars["body"] != "" && $email->vars["subject"] != ""){$email->insert();}
				
			}
		
		}
		
		echo $acc->vars["name"]."<br /><br />";
		
		$imap->close_connection();
	
	}

}

/*foreach($email->messages_by_date() as $uid){
	$msg = $email->get_message($uid);
	echo $uid . " // " . $msg["overview"]->from . " // " . $msg["overview"]->date . " // " . $msg["overview"]->subject;
	echo "<br /><br />";
	echo nl2br($msg["body"]);
	echo "<br /><br />_______________________________________________<br /><br />"; 
}*/

/*foreach($email->inbox() as $line){
	echo $line->from . " // " . $line->date . " // " . $line->subject . "<br /><br />"; 
}
*/
?> 



<?php 
/*$mbox = imap_open("{192.168.1.15:143/novalidate-cert}", "rarce@inspin.com", "sbomike160412")
      or die("can't connect: " . imap_last_error());

$list = imap_getmailboxes($mbox, "{192.168.1.15:143/novalidate-cert}", "*");
if (is_array($list)) {
    foreach ($list as $key => $val) {
        echo "($key) ";
        echo imap_utf7_decode($val->name) . ",";
        echo "'" . $val->delimiter . "',";
        echo $val->attributes . "<br />\n";
    }
} else {
    echo "imap_getmailboxes failed: " . imap_last_error() . "\n";
}

imap_close($mbox);*/
?>
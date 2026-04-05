<? include(ROOT_PATH . "/ck/db/handler.php"); ?>
<?

if (!$_GET["master"]){
$master = false;
$ticket  = get_ticket(clean_str_ck(get_ticket_id($_GET["tid"])));

} else {
   $master = true;
   $ticket = get_master_ticket(clean_str_ck(get_ticket_id($_GET["tid"])));
   $account = two_way_enc($_GET["wpx"],true);
	//Insert a control to remove from masters
	$log = new _master_players_tickets();
	$log->vars["account"] = $account;
	$log->vars["id_ticket"] = get_ticket_id($_GET["tid"]);
	$log->vars["control"] = 'd';	
	$log->insert();
;
}



$mobile = clean_str_ck($_GET["mobile"]);
$web = clean_str_ck($_GET["web"]);
$account = clean_str_ck($_GET["wpx"]);

if(!$master){
	if(!is_null($ticket)){
		
		$ticket->vars["open"] = "0";
		$ticket->vars["deleted"] = "1";
		$ticket->vars["pread"] = "1";
		$ticket->update(array("open","deleted","pread"));
	
		
		
	
	}else{echo "No Ticket Available";}
}
header("Location: ../list.php?wpx=$account&mobile=$mobile&web=$web");	
?>
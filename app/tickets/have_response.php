<? include(ROOT_PATH . "/ck/db/handler.php"); ?>
<?
$result = array();
$list = explode("|",$_POST["list"]);
foreach($list as $item){
	$ticket  = get_ticket(clean_str_ck(get_ticket_id($item)));
	if($ticket->vars["open"]){
		$lres = get_ticket_last_response($ticket->vars["id"]);
		if($lres->vars["clerk"] > 0){
			$status = "new";
		}else{
			$status = "old";
		}
	}else{
		$status = 'close';	
	}
	$result[$item] = $status;
}
echo json_encode($result);
?>

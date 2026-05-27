<?
require_once(ROOT_PATH . "/ck/db/handler.php");

$password = clean_str_ck($_POST["pass"]);
$transaction = clean_str_ck($_POST["transaction"]);
$method = clean_str_ck($_POST["method"]);
$type = clean_str_ck($_POST["type"]);
$account = clean_str_ck($_POST["player"]);
$amount = clean_str_ck($_POST["amount"]);
$prev_status = clean_str_ck($_POST["prev_status"]);
$new_status = clean_str_ck($_POST["new_status"]);
$clerk = clean_str_ck($_POST["clerk"]);
$reason = clean_str_ck($_POST["reason"]);
$pdate = date("Y-m-d H:i:s");
$done = 0;

if($password == "Fr021334HkasdUUUqwe1qa81LLa"){
	
	$log = new _process_log();
	$log->vars["trans_id"] = $transaction;
	$log->vars["method"] = $method;
	$log->vars["type"] = strtolower(substr($type,0,2));
	$log->vars["player"] = $account;
	$log->vars["amount"] = $amount;
	$log->vars["prev_status"] = $prev_status;
	$log->vars["new_status"] = $new_status;
	$log->vars["clerk"] = $clerk;
	$log->vars["pdate"] = $pdate;
	$log->vars["reason"] = $reason;
	$log->insert();
	
	switch($new_status){
		case "ac":
			//transactions has been accepted
			
		break;
		case "de";
			//transactions has been denied
			
			$player = json_decode(file_get_contents(
				"http://www.sportsbettingonline.ag/utilities/process/reports/get_player.php?pid=".two_way_enc($account)
			));
			
			$user_clerk = get_clerk($clerk);
			
			if(!is_null($player)){	
			
				//insert name in CRM
				$name = new ck_name();
				$name->vars["list"] = "66";
				$name->vars["name"] = $player->vars->Name;
				$name->vars["last_name"] =  $player->vars->LastName;
				$name->vars["email"] = $player->vars->Email;
				$name->vars["phone"] = $player->vars->Phone;
				$name->vars["book"] = "SBO";
				$name->vars["acc_number"] = $account;
				$name->vars["message_to_clerk"] = $method. " ". $type ." Denied".
				"\nTransaction Id: $transaction".
				"\nDenied Date: $pdate".
				"\nDenied by: ".$user_clerk->vars["name"].
				"\nDenied Reason:\n\n".$reason;
				$name->vars["added_date"] = date("Y-m-d H:i:s");
				$name->insert();		
			
				//insert alert
				$alert = new _alert();
				$alert->vars["message"] = $account.' $'.$amount.' '. $method. ' '. $type. ' Denied, Id: '.$transaction.' Date:'.$pdate.' Type: '.strtolower(substr($type,0,2)).
				'<br /><a target="_blank" href="<?= BASE_URL ?>/ck/call.php?odid='.$name->vars["id"].'" class="normal_link">Open Call</a>';
				$alert->vars["adate"] = date("Y-m-d H:i:s");
				$alert->vars["type"] = "denied_trans";
				$alert->insert();
				
				$done = 1;
			
			}
			
			
			
		break;		
		case "pe":
			//transactions has been changed to pending
			
		break;
	}
	
}


echo $done;
?>
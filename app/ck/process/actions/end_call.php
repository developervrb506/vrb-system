<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<?
$action = clean_get("status_action");
$name = get_ckname(clean_get("name_id"));
$conv = clean_get("conv_action");
$important = clean_get("important");
$conv_time = clean_get("conv_time");
if($name->vars["on_the_phone"]){
	if(!$name->vars["lead"] && clean_get("lead")){$new_lead = "1";}else{$new_lead = "0";}
	$original_status = $name->vars["status"]->vars["id"];
	$original_next_date = $name->vars["next_date"];
	if($name->vars["status"]->vars["id"] == 9 || $name->vars["status"]->vars["id"] == 11){$reset_status = $original_status;}
	$name->vars["status"] = $action;
	$name->vars["conversation_status"] = $conv;
	$name->vars["important"] = $important;
	$name->vars["note"] = clean_get("notes");	
	$name->vars["why_stop"] = clean_get("whyno");	
	$name->vars["email_desc"] = clean_get("email_desc");	
	$name->vars["clerk_source"] = clean_get("csource");	
	$name->vars["book"] = clean_get("book");
	$name->vars["lead"] = clean_get("lead");
	$name->vars["next_date"] = "0000-00-00 00:00:00";
	$name->vars["list"] = $name->vars["list"]->vars["id"];
	switch($action){
		case "2": //Wrong #
			$name->vars["available"] = "0";
		break;
		case "3"://Remove Me
			$name->vars["available"] = "0";
		break;
		case "4"://Disconnect 
			if(have_disconect_call($name->vars["id"])){
				$name->vars["available"] = "0";
			}else{
				$name->vars["next_date"] = date("Y-m-d H:i:s",time()+2592000);
				//$reset_status = $original_status;
			}
			
		break;
		case "5"://No Answer 
			if($original_status == 1 || $original_status == 5){
				$name->vars["next_date"] = date("Y-m-d H:i:s",time()+($gsettings["no_answer_call_back_days"]->vars["value"]*24*60*60));
			}else{
				$reset_status = $original_status;
				$name->vars["next_date"] = $original_next_date;
			}
		break;
		case "6"://Call Back
			$name->vars["next_date"] = clean_get("date");
		break;
		case "7"://Left Message
			$name->vars["next_date"] = clean_get("date");
		break;
		case "8"://Email Me 
			if(!$name->vars["list"]->vars["mailing_system"]){ //Not mailing system
				$name->vars["next_date"] = clean_get("date");
				//$name->vars["email"] = clean_get("extra_in");
			}else{ //mailing system
				$name->vars["email_desc"] = clean_get("email_desc");
				$name->vars["available"] = "0";
				
				$old_request = get_email_request_by_name($name->vars["id"]);
				
				if(!is_null($old_request)){
					$old_request->vars["complete"] = "0";
					$old_request->update("complete");
				}else{
					$request = new _email_request();
					$request->vars["name"]  = $name->vars["name"];
					$request->vars["email"]  = $name->vars["email"];
					$request->vars["player"]  = $name->vars["acc_number"];
					$request->vars["list"]  = $name->vars["list"]->vars["name"];
					$request->vars["ckname"]  = $name->vars["id"];
					$request->vars["rdate"]  = date("Y-m-d H:i:s");
					$request->insert();	
				}
				
				/*send_email_ck(
					"scott@vrbmarketing.com,skoot73@hotmail.com", 
					"New Email Request","There is a New Email Request in your VRB");*/
				
			}
			
			
		break;
		case "9"://Signup
			$name->vars["acc_number"] = clean_get("extra_in");
			$name->vars["free_play"] = clean_get("extra_chk");
		break;
		case "10"://Limbo
			$name->vars["available"] = "0";
		break;
		case "12"://Non US
			$name->vars["available"] = "0";
		break;
		case "13"://Deposit
			$name->vars["available"] = "0";
		break;
		case "14"://Release Me
			$crels = count_release_calls($name->vars["id"]);
			$diss = array(4,8,12,16,20,24,28);
			$contact_lists = array(20,38,39);
			if(in_array($crels,$diss)){
				
				$name->vars["available"] = "0";
				$name->vars["status"] = "14";
				$name->vars["by_releases"] = "1";
				$name->vars["released_date"] = date("Y-m-d H:i:s");
					
				if(in_array($name->vars["list"]->vars["id"],$contact_lists)){	
					//send email to scott
					/*$emails = "scott@vrbmarketing.com, skoot73@hotmail.com";
					$content = "There is a new Released name on your VRB:<br /><br />".$name->full_name();
					send_email_ck($emails, "New Released Name", $content, true);*/
				}
			}else{
				$name->vars["clerk"] = "0";
				
				date_default_timezone_set('Etc/GMT+6');
				$local = date("h:i:s A");
				date_default_timezone_set('US/Eastern');
				if(strtotime($local) <= strtotime("03:00 PM")){
					$next = date("Y-m-d H:i:s",strtotime(date("Y-m-d H:i:s")."+ 48 hours"));
				}else{
					$next = date("Y-m-d",strtotime(date("Y-m-d")."+ 2 day")) . " 11:59:00";
				}
				$name->vars["next_date"] = $next;
			}
		
			
		break;
	}		
	$name->close_call($reset_status, $new_lead, $conv, $conv_time);
	header("Location: ../../index.php?e=10&phs");
}else{
	header("Location: ../../index.php?e=9&phs");
}
?>
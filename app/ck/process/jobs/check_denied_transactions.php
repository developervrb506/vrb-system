<? $no_log_page = true; ?>
<? require_once(ROOT_PATH . "/ck/db/handler.php"); ?>
<?
$today = date("Y-m-d");
$start_date = strtotime ( '-1 month' , strtotime ( date("Y-m-d") ) ) ;
$start_date = date ( 'Y-m-d' , $start_date );

$denieds = get_all_transactions($start_date,$today,"de");



foreach($denieds as $trans){
	
		
  if (!is_alert_exist($trans->vars["id"],$trans->vars["method"])) {;
	 
 	   $new= false;
	   $name = get_name_denied_date($trans->vars["player"], $today);
	   
	   if (is_null($name)){ 
	     $new = true;
	     $name = new ck_name();
	    } 
	    
	  
	   
	   $player = json_decode(file_get_contents("http://www.sportsbettingonline.ag/utilities/process/reports/get_player.php?pid=".two_way_enc($trans->vars["player"])));
		
		if(!is_null($player)){
			
		  if ($new){
			
			  $name->vars["list"] = "66";
			  $name->vars["name"] = $player->vars->Name;
			  $name->vars["last_name"] =  $player->vars->LastName;
			  $name->vars["email"] = $player->vars->Email;
			  $name->vars["phone"] = $player->vars->Phone;
			  $name->vars["book"] = "SBO";
			  $name->vars["acc_number"] = $player->vars->Player;
			  $name->vars["message_to_clerk"] = ($trans->vars["method"]. " Denied, Id: ".$trans->vars["id"]." on ".$trans->vars["tdate"]);
			  $name->vars["added_date"] = date("Y-m-d H:i:s");
			  $name->insert();
			  echo "NEW ".$name->vars["id"];
		  }
		   else {
		   	$name->vars["message_to_clerk"] .= " ,".$trans->vars["method"]. " Denied, Id: ".$trans->vars["id"]." on ".$trans->vars["tdate"];
			$name->update(array("message_to_clerk"));   
			echo "UPDATED ".$name->vars["id"];   
		 }
			
			$alert = new _alert();
			$alert->vars["message"] = $trans->vars["player"]." $".$trans->vars["amount"]." ". $trans->vars["method"]. " Denied, Id: ".$trans->vars["id"]." Date:".$trans->vars["tdate"];
			$alert->vars["adate"] = date("Y-m-d H:i:s");
			$alert->vars["type"] = "denied_trans";
			$alert->insert();
	  }
  
  } // exist alert
  else{
	echo "Old";	
  }
}



?>
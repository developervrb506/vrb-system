<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->im_allow("agent_draw")){ ?>
<? include(ROOT_PATH . "/ck/balances/api/insert_transaction.php"); ?>
<?

$aff_balance = false;

if (isset($_POST["swd_affiliate"])){
 $aff_balance = true;	
}

$agent = clean_get("account");



$amount = clean_get("amount");
$desc = clean_get("desc") . ". AF Draw";
$data = array("agent"=>$agent,"amount"=>$amount,"desc"=>$desc);

$dgs = do_post_request("http://www.sportsbettingonline.ag/utilities/process/reports/vrb_affiliate_draw.php", $data);

if($dgs != "AFFILIATE NOT FOUND"){

	$trans = new _intersystem_transaction();
	
	$trans->vars["from_system"] = "7";
	$trans->vars["from_account"] = "36";
	$trans->vars["to_system"] = "3";
	$trans->vars["to_account"] = "19";
	$trans->vars["from_transaction"] = "999";
	$trans->vars["to_transaction"] = "999";
	$trans->vars["amount"] = $amount;
	$trans->vars["note"] = $desc . ": $agent";
	$trans->vars["afdraw"] = "1";
	$trans->vars["dgs_ID"] = $dgs;
	$trans->vars["tdate"] = date("Y-m-d H:i:s");
	$trans->vars["inserted_by"] = $current_clerk->vars["id"];
	
	$trans->insert();
	
	insert_is_transaction($trans->vars["id"]);	
		
	$trans->vars["approved_date"] = date("Y-m-d H:i:s");
	$trans->vars["approved_by"] = $current_clerk->vars["id"];
	$trans->vars["status"] = "ac";
	$trans->update(array("approved_date","approved_by","status"));
	
	$msg = "sent=1";
}else{
	$msg = "aferror=1";	
}

if ($aff_balance){ ?>
  <script>
   parent.location.href = "http://localhost:8080/ck/affiliate_balance_report.php?e=41";	
  </script>
<? }
else{
	?>
  <script>
    parent.location.href = "http://localhost:8080/ck/affiliate_draw.php?e=41";	
  </script>	
  <? //header("Location: http://localhost:8080/ck/affiliate_draw.php?$msg");   
}



?>
<? }else{echo "Access Denied";} ?>
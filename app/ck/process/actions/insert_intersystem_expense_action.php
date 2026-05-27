<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->im_allow("intersystem_transactions")){ ?>
<? include(ROOT_PATH . "/ck/balances/api/insert_transaction.php"); ?>
<?

$sfrom = get_system(clean_get("system_list_from"));
$system = $sfrom["id"]; $account = clean_get("from_account"); include("../../balances/api/get_account.php"); $from = $saccount;

$str_system = $from["name"] ." (". $sfrom["name"] .")";

$exp = new _expense();
$exp->vars["amount"] = "-".clean_get("amount");
$exp->vars["category"] = clean_get("categories_list");
$exp->vars["system"] = $str_system;
$exp->vars["note"] = clean_get("note").". ".clean_get("hidden_note");
$exp->vars["edate"] = date("Y-m-d H:i:s");
$exp->vars["status"] = "po";
$exp->vars["intersystem"] = 1;

if($sfrom["is_liability"]){
	$type = "de";
}else{
	$type = "wi";
}

$res = inertsystem_insertion(clean_get("system_list_from"), clean_get("from_account"), clean_get("amount"), $type, "Intersystem Expense #".$exp->vars["id"]." / ".clean_get("note"));

$exp->vars["system_id"] = $res;
$exp->insert();

//moneypak
if(isset($_POST["mpk"])){
	$mp = ($_POST["mpk"]); 
	if(is_numeric($mp)){
		
		$ran1 = mt_rand(10,587);
		$ran2 = mt_rand(4,59);
		$data = array(
			"north"=>$ran1,
			"south"=>$ran2,
			"west"=>($mp + ($ran1*$ran2))
		);
		
		do_post_request('http://cashier.vrbmarketing.com/utilities/process/actions/admin/archived_transaction.php', $data);
		
		if($_POST["email"] != ""){
			$text = "<strong>Pak Information:</strong><br /><br />";
			$text .= "Number: #################<br />";	
			$text .= "Notes:<br /> ".$exp->vars["note"]."<br />";
			
			$exemail = get_expense_email(clean_get("email"));
			
			send_email_ck($exemail->vars["email"], "Moneypak Payment", $text, true);
			
		}
		
		
	}
}



header("Location: " . BASE_URL . "/ck/expenses_index.php?e=47");
?>
<? }else{echo "Access Denied";} ?>
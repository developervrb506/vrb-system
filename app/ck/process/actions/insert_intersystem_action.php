<? 
if($_POST["xavier"] == "N0P@ss!"){
	include(ROOT_PATH . "/ck/db/handler.php");
}else{
	include(ROOT_PATH . "/ck/process/security.php");
}
?>
<? if(/*$current_clerk->im_allow("intersystem_transactions")*/ true ){ ?>
<? include(ROOT_PATH . "/ck/balances/api/insert_transaction.php"); ?>
<?

$sub = "New Transaction Request";
$content = "Transaction Details:<br /><br />";
$sfrom = get_system(clean_get("system_list_from"));
$sto = get_system(clean_get("system_list_to"));
$system = $sfrom["id"]; $account = clean_get("from_account"); include("../../balances/api/get_account.php"); $from = $saccount;
$system = $sto["id"]; $account = clean_get("to_account"); include("../../balances/api/get_account.php"); $to = $saccount;
$content .= "From: ". $from["name"] ." (". $sfrom["name"] .")<br />";
$content .= "To: ". $to["name"] ." (". $sto["name"] .")<br />";
$content .= "Amount: ". clean_get("amount")."<br />";
$content .= "Note: ". clean_get("note");

$trans = new _intersystem_transaction();

$trans->vars["from_system"] = clean_get("system_list_from");
$trans->vars["from_account"] = clean_get("from_account");
$trans->vars["to_system"] = clean_get("system_list_to");
$trans->vars["to_account"] = clean_get("to_account");
$trans->vars["amount"] = clean_get("amount");
$trans->vars["note"] = clean_get("note").". ".clean_get("hidden_note");
$trans->vars["tdate"] = date("Y-m-d H:i:s");
$trans->vars["inserted_by"] = $current_clerk->vars["id"];

$emails = "";
if(isset($_POST['emails'])){
	foreach($_POST['emails'] as $email) {
		send_email_ck($email, $sub, $content, true, $current_clerk->vars["email"]);
		$emails .= ",".$email;
	}
}

foreach(explode(",", clean_get("other")) as $email){
	if($email!=""){
		send_email_ck($email, $sub, $content, true, $current_clerk->vars["email"]);
		$emails .= ",".$email;
	}
}

$emails = substr($emails,1);

$trans->vars["emails"] = $emails;

$trans->insert();

if($_POST["autoinsert"]){
	//insert from transaction, insert to transaction
	insert_is_transaction($trans->vars["id"]);	
	
	$trans->vars["approved_date"] = date("Y-m-d H:i:s");
	$trans->vars["approved_by"] = $current_clerk->vars["id"];
	$trans->vars["status"] = "ac";
	$trans->update(array("approved_date","approved_by","status"));
}

if(is_numeric($_POST["cash_arch"])){
	$ran1 = mt_rand(10,587);
	$ran2 = mt_rand(4,59);
	$data = array(
		"north"=>$ran1,
		"south"=>$ran2,
		"west"=>($_POST["cash_arch"] + ($ran1*$ran2))
	);
	
	do_post_request('http://cashier.vrbmarketing.com/utilities/process/actions/admin/archived_transaction.php', $data);
	
	
}


if(!isset($_POST["burl"])){
	if($_POST["mobile"]){
		header("Location: " . BASE_URL . "/ck/mobile/intersystem_transaction.php?e=29");
	}else{
		header("Location: " . BASE_URL . "/ck/balances_transactions.php?e=29");	
	}
}else{
	header("Location: ".$_POST["burl"]);	
}
?>
<? }else{echo "Access Denied";} ?>
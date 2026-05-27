<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->im_allow("intersystem_transactions")){ ?>
<? include(ROOT_PATH . "/ck/balances/api/insert_transaction.php"); ?>
<?

$paks = explode(",",clean_get("boxes"));
$sfrom = get_system(clean_get("system_list_from"));
$sto = get_system(clean_get("system_list_to"));
$system = $sfrom["id"]; $account = clean_get("from_account"); include("../../balances/api/get_account.php"); $from = $saccount;
$system = $sto["id"]; $account = clean_get("to_account"); include("../../balances/api/get_account.php"); $to = $saccount;

$arch_paks = array();

foreach($paks as $pak){
	
	$pak_parts = explode("/",$pak); //id/amount
	
	if(is_numeric($pak_parts[0]) && is_numeric($pak_parts[1])){
	
		$trans = new _intersystem_transaction();
		
		$trans->vars["from_system"] = clean_get("system_list_from");
		$trans->vars["from_account"] = clean_get("from_account");
		$trans->vars["to_system"] = clean_get("system_list_to");
		$trans->vars["to_account"] = clean_get("to_account");
		$trans->vars["amount"] = $pak_parts[1];
		$trans->vars["note"] = clean_get("note").". Moneypak Id:".$pak_parts[0];
		$trans->vars["tdate"] = date("Y-m-d H:i:s");
		$trans->vars["inserted_by"] = $current_clerk->vars["id"];
		$trans->insert();
		
		if($_POST["autoinsert"]){
			//insert from transaction, insert to transaction
			insert_is_transaction($trans->vars["id"]);	
			$trans->vars["approved_date"] = date("Y-m-d H:i:s");
			$trans->vars["approved_by"] = $current_clerk->vars["id"];
			$trans->vars["status"] = "ac";
			$trans->update(array("approved_date","approved_by","status"));
		}
		
		$arch_paks[] = $pak_parts[0] + 98745623;
	
	}

}

$data = array("iron"=>implode(",",$arch_paks));
do_post_request('http://cashier.vrbmarketing.com/utilities/process/actions/admin/archived_transactions_by_list.php', $data);


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
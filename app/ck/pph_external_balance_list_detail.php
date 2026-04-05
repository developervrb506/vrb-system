<?
include(ROOT_PATH . "/ck/db/handler.php");

$list = explode(",",param("list"));
$accounts = get_pph_account_by_list("'".implode("','",$list)."'");
$from_date = param("from_date");
$to_date = param("to_date");

$result = array();
foreach($accounts as $account){
	$result[] = get_pph_balance_detail($account ->vars["id"],$from_date,$to_date);
}

echo json_encode($result);

?>
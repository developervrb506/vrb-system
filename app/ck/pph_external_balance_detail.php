<?
include(ROOT_PATH . "/ck/db/handler.php");

$account = get_pph_account_by_name(param("acc"));
$limit_date = param("limit_date");

if(!is_null($account)){
	$data = get_pph_balance_detail($account ->vars["id"],$limit_date);
}else{
	$data = array();
}

echo json_encode($data);

?>
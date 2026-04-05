<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->im_allow("pph_accounting")){ ?>
<?
$acc = get_pph_account(clean_get("pph_account_list"));
$type = clean_get("type");

$trans = new _pph_bill();
$trans->vars["account"] = $acc->vars["id"];


switch($type){ 
	case "sr":
		$trans->vars["phone_count"] = clean_get("phone_count");
		$trans->vars["phone_price"] = $acc->vars["phone_price"];
		$trans->vars["internet_count"] = clean_get("internet_count");
		$trans->vars["internet_price"] = $acc->vars["internet_price"];
		$trans->vars["base_count"] = $trans->vars["internet_count"] + $trans->vars["phone_count"];
		$custom_total = ($trans->vars["phone_count"]*$trans->vars["phone_price"])+($trans->vars["internet_count"]*$trans->vars["internet_price"]);
	break;
	case "lp":
		$trans->vars["liveplus_count"] = clean_get("lpcount");
		$trans->vars["liveplus_price"] = $acc->vars["liveplus_price"];
		$trans->vars["base_count"] = $trans->vars["liveplus_count"];
		$custom_total = ($trans->vars["liveplus_count"]*$trans->vars["liveplus_price"]);
		$force_amount = true;
	break;
	case "lc":
		$trans->vars["livecasino_count"] = clean_get("lccount");
		$trans->vars["livecasino_price"] = $acc->vars["livecasino_price"];
		$trans->vars["base_count"] = $trans->vars["livecasino_count"];
		$custom_total = ($trans->vars["livecasino_count"]*$trans->vars["livecasino_price"]);
		$force_amount = true;
	break;
	case "ot":
		$trans->vars["base_count"] = 0;
		$custom_total = clean_get("amount");
		$force_amount = true;
	break;
}


$trans->vars["base_price"] = $acc->vars["base_price"];
$trans->vars["max_players"] = $acc->vars["max_players"];

$trans->vars["mdate"] = clean_get("mdate");
$trans->vars["type"] = $type;


if($trans->vars["base_count"] > $trans->vars["max_players"] || $force_amount){
	$total = $custom_total;
}else{
	$total = $trans->vars["base_price"];
}


$trans->vars["total"] = $total;
$trans->vars["tdate"] = date("Y-m-d H:i:s");
$trans->vars["note"] = clean_get("note");

$trans->insert();

$acc->move_balance($total);


header("Location: http://localhost:8080/ck/pph.php?e=55");
?>
<? }else{echo "Access Denied";} ?>
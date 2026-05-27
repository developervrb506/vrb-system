<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->im_allow("dgs_money_transfers")){ ?>
<?

$vcc = get_vcc(clean_str_ck($_POST["transaction"]));

$number = clean_str_ck($_POST["number"]);
$cvv = clean_str_ck($_POST["cvv"]);
$expiration = clean_str_ck($_POST["expiration"]);
$feedback = clean_str_ck($_POST["feedback"]);

$vcc->vars["cc_number"] = $number;
$vcc->vars["cc_cvv"] = $cvv;
$vcc->vars["cc_exp"] = $expiration;
$vcc->vars["payout_back_message"] = $feedback;

$vcc->update(array("cc_number","cc_cvv","cc_exp","payout_back_message"));

$data["tid"] = "VCP" . $vcc->vars["id"];
$data["account"] = $vcc->vars["payout_player"];
$data["method"] = "vcc";
$data["amount"] = $vcc->vars["amount"];
$data["fees"] = $vcc->vars["payout_fee"];
$key = two_way_enc(implode("_*_",$data));

if(contains_ck($vcc->vars["payout_player"],"AF")){
	header("Location: " . BASE_URL . "/ck/dgs_payout_affiliate.php?mts=".$key);
}else{
	header("Location: " . BASE_URL . "/ck/dgs_payout.php?mts=".$key);
}

?>
<? }else{echo "Access Denied";} ?>
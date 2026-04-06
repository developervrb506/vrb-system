<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->im_allow("dgs_money_transfers")){ ?>
<?

$vcc = get_vcc(clean_str_ck($_POST["transaction"]));
$player = clean_str_ck($_POST["player"]);
$fees = clean_str_ck($_POST["fees"]);
$comments = clean_str_ck($_POST["comments"]);

$vcc->vars["deposit_fee"] = $fees;
$vcc->vars["deposit_player"] = $player;
$vcc->vars["deposit_date"] = date("Y-m-d H:i:s");
$vcc->vars["deposit_status"] = "pe";
$vcc->vars["deposit_comments"] = $comments;

$vcc->update(array("deposit_fee","deposit_player","deposit_date","deposit_status","deposit_comments"));

$key = two_way_enc(mt_rand().".VCD".$vcc->vars["id"]."."."vcc");

header("Location: https://www.ezpay.com/wu/process/actions/cash_redirect.php?k=".$key);

/*$data["tid"] = "VCD" . $vcc->vars["id"];
$data["account"] = $vcc->vars["deposit_player"];
$data["method"] = "vcc";
$data["amount"] = $vcc->vars["amount"];
$data["fees"] = $vcc->vars["deposit_fee"];
$key = two_way_enc(implode("_*_",$data));

header("Location: " . BASE_URL . "/ck/dgs_payout.php?mts=".$key);*/

?>
<? }else{echo "Access Denied";} ?>
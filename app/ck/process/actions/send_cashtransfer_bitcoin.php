<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->im_allow("process_payouts")){ ?>
<?
$transaction = get_cash_transfer_transaction($_POST["transaction"]);

$amount = clean_str_ck($_POST["amount"]);
$sender = clean_str_ck($_POST["sender"]);
$mtcn = clean_str_ck($_POST["mtcn"]);
$fees = clean_str_ck($_POST["fees"]);
$comments = clean_str_ck($_POST["comments"]);

$transaction->vars["amount"] = $amount;
$transaction->vars["sender_name"] = $sender;
$transaction->vars["mtcn"] = $mtcn;
$transaction->vars["fees"] = $fees;
$transaction->vars["back_message"] = $comments;
$transaction->vars["status"] = "ac";
$transaction->vars["method"] = "25";

$transaction->update();

header("Location: " . BASE_URL . "/ck/cash_transfer_payouts.php");
?>
<? }else{echo "Access Denied";} ?>
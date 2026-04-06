<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->im_allow("process_payouts")){ ?>
<?
$trans = get_moneyorder_payout($_POST["id"]);
if(!is_null($trans)){		
	$trans->vars["status"] = "ac";
	$trans->vars["number"] = $_POST["number"];
	$trans->vars["usps"] = $_POST["usps"];
	$trans->vars["back_message"] = $_POST["bmsg"] . ". ".$trans->vars["back_message"];
	$trans->update(array("back_message","status","number","usps"));
	header("Location: " . BASE_URL . "/ck/moneyorder_payouts.php");
}
?>
<? }else{echo "Access Denied";} ?>
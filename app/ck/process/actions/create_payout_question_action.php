<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->im_allow("payout_questions")){include(ROOT_PATH . "/ck/process/admin_security.php");} ?>
<?
$vars["question"] = clean_get("description");


if(isset($_POST["update_id"])){
	$vars["id"] = clean_get("update_id");
	$question = new _payout_question($vars);
	$question->update();
//	header("Location: ../../payout_questions.php?e=84");
}else{
   // echo $vars["question"];
	$question = new _payout_question($vars);
	$question->insert();
    header("Location: ../../payout_questions.php?e=84");
}
?>
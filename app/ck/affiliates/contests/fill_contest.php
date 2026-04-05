<?
include('C:/websites/jobs.inspin.com/includes/functions.php');
require_once('C:/websites/jobs.inspin.com/contests/functions.php');
inspinc_insider();
$cont_id = $_POST["contest_id"];
$customer_id = $_POST["customer_id"];
$questions = get_questions($cont_id);

foreach($questions as $question){
	$ans_id = $_POST["radio_" . $question->id];
	if($ans_id != ""){
		answer_custmer($ans_id, $customer_id);
	}
}

header ("Location: index.php?cid=$cont_id")
?>
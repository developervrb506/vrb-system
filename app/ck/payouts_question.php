<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? //$answer = new _payout_answer(); ?>
<?
$player = clean_str_ck($_GET["p"]);
$transaction = clean_str_ck($_GET["t"]);
$questions = get_all_payout_question();

if(isset($_POST["sender"])){
	foreach($questions as $q){
		$atext = trim(clean_str_ck($_POST["q".$q->vars["id"]]));
		if($atext != ""){
		$answer = new _payout_answer();
		$answer->vars["idtransaction"] = $transaction;
		$answer->vars["question"] = $q->vars["id"];
		$answer->vars["answer"] = $atext;
		$answer->vars["clerk"] = $current_clerk->vars["id"];
		$answer->vars["date"] = date("Y-m-d");
		$answer->vars["player"] = $player;
		$answer->insert();
		}
	}
}

$answers = get_payout_answers($transaction,$player);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../../css/style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../process/js/functions.js"></script>
</head>
<body style="background:#fff; padding:20px;">

<div class="form_box">
   
  <form method="post">
   <span class="page_title"> Payout Questions</span>
   <? foreach($questions as $q){ ?>
  	<p>
   	<? echo $q->vars["question"] ?><br />
    <textarea name="q<? echo $q->vars["id"] ?>" cols="" rows="" id="q"><? echo $answers[$q->vars["id"]]->vars["answer"] ?></textarea>
  	</p>
   <? } ?>
   <input name="sender" type="submit" id="sender" value="Update" />
   </form>
 
</div>

</body>
</html>
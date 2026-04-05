<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->im_allow("payout_questions")){include(ROOT_PATH . "/ck/process/admin_security.php");} ?>
<?
if(isset($_GET["del"])){
	$question = get_payout_question($_GET["del"]);
	if(!is_null($question)){
		$question->delete();
		header("Location: payout_questions.php?e=85");
	}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/style.css" rel="stylesheet" type="text/css" />
<title>Payout Questions</title>
</head>
<body>
<? include "../includes/header.php" ?>
<? include "../includes/menu_ck.php" ?>
<div class="page_content" style="padding-left:50px;">
<span class="page_title">Payout Questions</span><br /><br />

<? include "includes/print_error.php" ?>

<a href="create_payout_question.php" class="normal_link">Create New Question</a><br /><br />
<? 
$questions = get_all_payout_question();
?>

<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td class="table_header" align="center">Id</td>
    <td class="table_header" align="center">Question</td>
       <td class="table_header" align="center">Delete</td>
  </tr>
  <? foreach($questions as $question){if($i % 2){$style = "1";}else{$style = "2";}$i++ ?>
  
  <tr>
    <td class="table_td<? echo $style ?>" style="text-align:center; font-weight:normal;">		
		<? echo $question->vars["id"]; ?>
    </td>
    <td class="table_td<? echo $style ?>" style="text-align:center; font-weight:normal;"><? echo $question->vars["question"]; ?></td>
      <td class="table_td<? echo $style ?>" style="text-align:center; font-weight:normal;">
    	<a class="normal_link" href="?del=<? echo $question->vars["id"] ?>"><strong>Delete</strong></a>
    </td>
    
  </tr>
  
  <? } ?>
  <tr>
    <td class="table_last"></td>
    <td class="table_last"></td>
    <td class="table_last"></td>
    <td class="table_last"></td>
  </tr>
</table>

</div>
<? include "../includes/footer.php" ?>
<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->im_allow("payout_questions")){include(ROOT_PATH . "/ck/process/admin_security.php");} ?>
<?
if(isset($_GET["rid"])){
	$update = true;
	$question = get_payout_question($_GET["rid"]);
	$title = "Edit " . $question->vars["question"];
}else{
	$update = false;
	$title = "Create New Question";
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/style.css" rel="stylesheet" type="text/css" />
<title><? echo $title ?></title>
<script type="text/javascript" src="../process/js/functions.js"></script>
<script type="text/javascript">
var validations = new Array();
validations.push({id:"description",type:"null", msg:"Description is required"});
</script>
</head>
<body>
<? include "../includes/header.php" ?>
<? include "../includes/menu_ck.php" ?>
<div class="page_content" style="padding-left:50px;">
<span class="page_title"><? echo $title ?></span><br /><br />

<? include "includes/print_error.php" ?>

<div class="form_box" style="width:750px;">
	<form method="post" action="process/actions/create_payout_question_action.php" onsubmit="return validate(validations)">
    <? if($update) { ?><input name="update_id" type="hidden" id="update_id" value="<? echo $question->vars["id"] ?>" /><? } ?>
	<table width="100%" border="0" cellspacing="1" cellpadding="5">
      <tr>
        <td>&nbsp;&nbsp;Question:</td>
        <td><textarea name="description" id="description"  cols="55" rows="3"><? echo $question->vars["question"] ?></textarea>
        </td>     
      </tr>
      
      <tr>
        <td><input type="image" src="../images/temp/submit.jpg" /></td>
        <td>&nbsp;</td>
      </tr>
    </table>
	</form>
</div>


</div>
<? include "../includes/footer.php" ?>
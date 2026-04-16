<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->im_allow("player_security_question")){ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/style.css" rel="stylesheet" type="text/css" />
<title>PLAYER SECURITY QUESTION</title>
<script type="text/javascript" src="../process/js/functions.js?v=2"></script>
<script type="text/javascript">
var validations = new Array();
validations.push({id:"player",type:"null", msg:"Player is required"});

var validations1 = new Array();
validations1.push({id:"sec_que",type:"null", msg:"Please choose a Security Question"});
validations1.push({id:"sec_ans",type:"null", msg:"Please write a Security Answer"});

</script>
</head>
<body>
<? include "../includes/header.php" ?>
<? include "../includes/menu_ck.php" ?>
<div class="page_content" style="padding-left:50px;">
<span class="page_title">PLAYER SECURITY QUESTION</span><br /><br />

<? include "includes/print_error.php" ?>

<?

if (isset($_GET["player_id"])){
$_POST["player_update"] = $_GET["player_id"];	
$answers = new _security_player_answers();  
$answers->vars["question"] = "-1";
$answers->vars["answer"] = " ";
$answers->vars["player"] = $_POST["player_update"];
$answers->insert();
unset($_GET["player_id"]);
}

if (isset($_POST["player_update"])){
	
    $player = $_POST["player_update"];
	$answers = get_security_players_answers($player);  
	$answers->vars["question"] = $_POST["sec_que"];
	$answers->vars["answer"] =  md5(two_way_enc(strtolower($_POST["sec_ans"])));
	$answers->update(array("question","answer")); 
}
else{
  $player = $_POST["player"];
  
  if($player != ""){ 

    $answers = get_security_players_answers($player);  
 
  }
  
}
 $player_updated = false;	
  if ($_POST["update"]){ 
       $player_updated = true;	
  }
?>
<form method="post" action="player_security_question.php"  onsubmit="return validate(validations)">
Player: <input name="player" type="text" id="player" value="<? echo $player ?>" />
<input type="submit" name ="search" value="Search" />
</form>
<br /><br />



<?
 if (is_null($answers) && isset($_POST["search"])){
	 
   echo "Player not Found&nbsp;&nbsp; "; ?>
   	<a href="?player_id=<? echo $player?>" class="normal_link" onclick="">Add This Player </a>
  
   <? }
 
 
 
 if (!is_null($answers) ){
 
 $questions = get_security_players_questions();
 $sec_que = $answers->vars["question"];
 
 ?>

<div class="form_box" style="width:650px;">

  <? if ($player_updated){ ?>
	  <span class="error" id="error_box">" The Answers was Updated " </span>
	<? }
	else {
	  ?>

	<form method="post" action="" onsubmit="return validate(validations1)">
	<input name="player_update" type="hidden" id="player_update" value="<? echo $player ?>" />
    <input name="update" type="hidden" id="update" value="1" />
     <table width="100%" border="0" cellspacing="0" cellpadding="10">
       <tr>
        <td>
        <strong>Security Question:</strong><br />
    <select name="sec_que" id="sec_que"  onchange="">
      <option value="" <? if($question_list == $question["id"]){echo 'selected="selected"';} ?> >
      Choose One
       </option>
      <? foreach($questions as $question){ ?>
      <option value="<? echo $question["id"] ?>" <? if($sec_que == $question["id"]){echo 'selected="selected"';} ?> >
        <? echo $question["question"] ?>
      </option>  
      <? } ?>
    </select>
     <BR/><BR/>
       <strong>Security Answer:</strong><br />
      <input style="width:415px" class="form_input"  id = "sec_ans" name="sec_ans" type="text" value="<? echo $sec_ans ?>" tabindex="19" />
             
        </td>
      </tr> 
     
      <tr>
        <td><input type="image" src="../images/temp/submit.jpg" /></td>
        
      </tr>
    </table>
	</form>
</div>

 <? } ?>

<? } ?>


</div>
<? } else { echo "Access Denied";} ?>

<? include "../includes/footer.php" ?>
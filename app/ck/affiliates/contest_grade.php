<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? require_once(ROOT_PATH . '/ck/affiliates/contests/functions.php'); ?>
<? if($current_clerk->im_allow("affiliates_system")){ ?>
<?
$id_edit = $_GET["id"];


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../../css/style.css" rel="stylesheet" type="text/css" />
<title>Contest</title>
  <link rel="stylesheet" type="text/css" media="all" href="http://localhost:8080/includes/calendar/jsDatePick_ltr.min.css" />
<link rel="stylesheet" href="http://localhost:8080/includes/shadowbox/shadowbox.css" type="text/css" media="screen" />

<script type="text/javascript" src="http://localhost:8080/includes/shadowbox/shadowbox.js"></script>
<script type="text/javascript" src="http://localhost:8080/process/js/functions.js"> </script>
<script type="text/javascript" src="http://localhost:8080/ck/includes/js/sortables.js"></script>
<script type="text/javascript" src="http://localhost:8080/ck/affiliates/contests/functions.js"></script>
<script type="text/javascript" src="http://localhost:8080/includes/calendar/jsDatePick.min.1.3.js"></script>
<script type="text/javascript">
Shadowbox.init();
</script>

<script type="text/javascript">
      window.onload = function(){
          new JsDatePick({
              useMode:2,
              target:"start_date",
              dateFormat:"%Y-%m-%d"
          });
          new JsDatePick({
              useMode:2,
              target:"end_date",
              dateFormat:"%Y-%m-%d"
          });
      };
  </script>


</head>
<body>
<?
if(isset($id_edit)){ 
 $contest_to_edit = get_contest_by_id($id_edit);
 $questions = get_questions($id_edit);
}

?>



<? include "../../includes/header.php" ?>
<? include "../../includes/menu_ck.php" ?>
<div class="page_content" style="padding-left:50px;">
<? if (isset($_GET['message'])) : ?>
<div id="message" class="updated fade"><p><? echo $messages[$_GET['message']]; ?></p></div>
<? endif; ?>
<span class="page_title">Grade Contest</span><br /><br />
<div align="right"><span ><a href="contest.php">Back</a></span></div>





<form name="contest_form" action="process/actions/contests_action.php" method="post">
<input name="grade" id="grade" type="hidden" value="graded">
<input name="contest_id" id="contest_id" type="hidden" value="<? echo $contest_to_edit->vars["id"] ?>">
<? echo $contest_to_edit->name ?>
<br>

<h2>Questions</h2>
Select the correct answers:
<div id="questions_div">
<!--Questions Content display dynamically here--> 
<? 
$i = 1;
?>
<?
foreach($questions as $question){
?>
<!--Questions Edit Content-->
<div>
	<br><hr /><br><strong><? echo $i . ") " . $question->vars["text"] ?></strong> <br><br>    
    <!--Questions Edit Content-->
    <div style="margin-left:20px;"><table width="200" border="0" cellspacing="0" cellpadding="10">
    <? $e = 1;
	$answers = get_answers($question->vars["id"]);
	foreach($answers as $answ){ 
		if($e%2){$style = "background:#e5e5e5";}else{$style = "";}
	?>
    
 		
      <tr>
        <td style="padding:5px; <? echo $style ?>"><? echo "<strong>" . $e . ")</strong> " . $answ->vars["text"] ?></td>
        <td style="padding:5px; <? echo $style ?>">
        <input name="radio_<? echo $question->vars["id"] ?>" type="radio" id="radio_<? echo $question->vars["id"] ?>" value="<? echo $answ->vars["id"] ?>" 
		<?  if(is_answer_correct($answ->vars["id"])){echo "checked";} ?> >
        </td>
      </tr>      
    
    <?  
	  $e++;
		} 
		$i++;
	?>
    </table></div>
</div>

<? } ?>
</div>
<hr />
<br>
<div style="text-align:right;"><input type="submit" name="Submit" value="Submit" /></div>
</form>
</div>

<? include "../../includes/footer.php" ?>
<? } else { echo "ACCESS DENIED"; }?>
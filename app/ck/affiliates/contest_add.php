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
  <link rel="stylesheet" type="text/css" media="all" href="<?= BASE_URL ?>/includes/calendar/jsDatePick_ltr.min.css" />
<link rel="stylesheet" href="<?= BASE_URL ?>/includes/shadowbox/shadowbox.css" type="text/css" media="screen" />

<script type="text/javascript" src="<?= BASE_URL ?>/includes/shadowbox/shadowbox.js"></script>
<script type="text/javascript" src="<?= BASE_URL ?>/process/js/functions.js?v=2"> </script>
<script type="text/javascript" src="<?= BASE_URL ?>/ck/includes/js/sortables.js"></script>
<script type="text/javascript" src="<?= BASE_URL ?>/ck/affiliates/contests/functions.js"></script>
<script type="text/javascript" src="<?= BASE_URL ?>/includes/calendar/jsDatePick.min.1.3.js"></script>
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
<script type="text/javascript">
var validations = new Array();
validations.push({id:"start_hour",type:"numeric", msg:"You need to write numbers"});
validations.push({id:"start_minute",type:"numeric", msg:"You need to write numbers"});
validations.push({id:"end_hour",type:"numeric", msg:"You need to write numbers"});
validations.push({id:"end_minute",type:"numeric", msg:"You need to write numbers"});
validations.push({id:"name",type:"null", msg:"You need to write a Name"});

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
<span class="page_title"><? if(isset($id_edit)){$action = "Edit";}else{$action = "Add";} ?>
	<? echo $action . ' Contest' ?> </span><br /><br />
<div align="right"><span ><a href="contest.php">Back</a></span></div>



<form name="contest_form" action="process/actions/contests_action.php" method="post" onSubmit="return validate_form();">
<table width="70%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td style="padding:5px;">Name:</td>
    <td style="padding:5px;"><input name="name" type="text" id="name" size="100" value="<? echo $contest_to_edit->vars["name"] ?>"></td>
  </tr>
  <tr>
    <td style="padding:5px;">League</td>
    <td style="padding:5px;"><select name="league_list" id="league_list">
      <option value="NBA">NBA</option>
      <option value="NFL">NFL</option>
      <option value="NHL">NHL</option>
      <option value="MLB">MLB</option>
      <option value="NCAAB">NCAAB</option>
      <option value="NCAAF">NCAAF</option>
    </select></td>
  </tr>
  <tr>
    <td style="padding:5px;">Start Date:</td>
    <td style="padding:5px;">
    <?
      $date = explode(" ",$contest_to_edit->vars["open_date"]);
	  $time = explode(":",$date[1]);
	?>
    <input name="start_date" id="start_date" readonly size="30" value="<? echo $date[0] ?>" />
     &nbsp;&nbsp; Hour : <input name="start_hour" id="start_hour"  size="5" value="<? echo $time[0] ?>" />
     &nbsp;&nbsp; Minute : <input name="start_minute" id="start_minute"  size="5" value="<? echo $time[1] ?>" />
	</td>
  </tr>
  <tr>
    <td style="padding:5px;">End Date:</td>
    <td style="padding:5px;">
     <?
      $date = explode(" ",$contest_to_edit->vars["close_date"]);
	  $time = explode(":",$date[1]);
	?>
     
     <input name="end_date" id="end_date" readonly size="30" value="<? echo $date[0] ?>" />
     &nbsp;&nbsp; Hour : <input name="end_hour" id="end_hour"  size="5" value="<? echo $time[0] ?>" />
     &nbsp;&nbsp; Minute : <input name="end_minute" id="end_minute"  size="5" value="<? echo $time[1] ?>" />
    </td>
  </tr>
  <tr>
    <td style="padding:5px;">Points to Win:</td>
    <td style="padding:5px;"><input name="points" type="text" id="points" size="100" value="<? echo $contest_to_edit->vars["points"] ?>"></td>
  </tr>
  <tr>
    <td style="padding:5px;">Visible:</td>
    <td style="padding:5px;"><select name="visible" id="visible">
      <option value="1">Visible</option>
      <option value="0">Hidden</option>
      </select></td>
  </tr>
</table>
<script language="javascript" type="text/javascript">
change_dropdown("visible","<? echo $contest_to_edit->vars["visible"] ?>",false);
change_dropdown("league_list","<? echo $contest_to_edit->vars["league"] ?>",false);
</script>
<br><br>

<h2>Questions</h2><br>
<a href="javascript:;" onClick="add_question(true)">+Add Question</a> 
<input name="questions_count" type="hidden" id="questions_count" value="<? echo count($questions); ?>">
<br>
<div id="questions_div">
<!--Questions Content display dynamically here--> 
<? 
if(isset($id_edit)){ 
$i = 1;
?><input name="action" type="hidden" id="action" value="editing">
<input name="cont_id" type="hidden" id="cont_id" value="<? echo $contest_to_edit->vars["id"] ?>">
<input name="deleted_answers" type="hidden" id="deleted_answers">
<input name="deleted_questions" type="hidden" id="deleted_questions">
<?
foreach($questions as $question){

$answers = get_answers($question->vars["id"]);
?>
<!--Questions Edit Content-->
<div id="question_div_<? echo $i; ?>">
	<br><hr /><br><strong>Quiestion:</strong> <a href="javascript:;" onClick="remove_question('<? echo $i; ?>', '<? echo $question->vars["id"]; ?>')">-Remove Question</a>
    <input name="question_id<? echo $i; ?>" type="hidden" id="question_id<? echo $i; ?>" value="<? echo $question->vars["id"]; ?>">
    <input name="answer_count<? echo $i; ?>" type="hidden" id="answer_count<? echo $i; ?>" value="<? echo count($answers); ?>"><br><br>
    Text: <input name="question<? echo $i; ?>" type="text" id="question<? echo $i; ?>" size="100" value="<? echo $question->vars["text"] ?>"><br><br>
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <a href="javascript:;"  onClick="add_answer(<? echo $i; ?>, true)">+Add Answer</a><br><br>
    
    <!--Questions Edit Content-->
    <? $e = 1;
	
	foreach($answers as $answ){ ?>
    
    <div id="answer_div_<? echo $e; ?>_<? echo $i; ?>">
    	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Answer:
        <input name="answer_id<? echo $e; ?>_<? echo $i; ?>" type="hidden" id="answer_id<? echo $e; ?>_<? echo $i; ?>" value="<? echo $answ->vars["id"]; ?>"> 
        <input name="answer<? echo $e; ?>_<? echo $i; ?>" type="text" id="answer<? echo $e; ?>_<? echo $i; ?>" size="100" value="<? echo $answ->vars["text"] ?>"> 
        <a href="javascript:;" onClick="remove_answer(<? echo $i; ?>,<? echo $e; ?>, '<? echo $answ->vars["id"]; ?>')">-Remove Answer</a><br><br>
    </div>
    
    <?  
	  $e++;
		} 
		$i++;
	?>
</div>

<? }
} ?>
</div>
<hr />
<br>
<a href="javascript:;" onClick="add_question(true)">+Add Question</a>
<div style="text-align:right;"><input type="submit" name="Submit" value="Submit" /></div>
</form>

</div>

<? if(!isset($id_edit)){ ?>
<script type="text/javascript">
for(var i=0; i < questions_display; i++) {
	add_question(false);
}
</script> 
<? } ?>
<? include "../../includes/footer.php" ?>
<? } else { echo "ACCESS DENIED"; }?>
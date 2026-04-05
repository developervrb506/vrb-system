<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->im_allow("programmers_book")){ ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../process/js/functions.js"></script>
<title>Programmers Book</title>


</head>
<body>
<? include "../includes/header.php" ?>
<? include "../includes/menu_ck.php" ?>
<div class="page_content" style="padding-left:10px;">
<span class="page_title">Programmers Book</span><br /><br />
<? include "includes/print_error.php" ?>
<? 
$entry = get_programmers_entry($_GET["en"]);
if(is_null($entry)){
	$new = true;
}
?>

<? if($new){ ?>
<a href="javascript:;" onclick="display_div('newent');" class="normal_link">+ Add entry</a>
<? }else{ ?>
<a href="programmers_book.php" class="normal_link">&lt;&lt; Back</a>
<? } ?>

<div class="form_box" <? if($new){ ?>style="display:none;"<? } ?> id="newent">
	<script type="text/javascript">
	var validations = new Array();
	validations.push({id:"title",type:"null", msg:"Insert a title"});
	validations.push({id:"description",type:"null", msg:"Insert a description"});
	</script>
	<form method="post" onsubmit="return validate(validations)" action="process/actions/add_programmers_entry.php">
    	<? if(!$new){ ?><input name="edit_id" type="hidden" id="edit_id" value="<? echo $entry->vars["id"] ?>" /><? } ?>
        <strong>Title</strong>:<br />
        <input name="title" type="text" id="title" style="width:800px;" value="<? echo $entry->vars["title"] ?>" /><br />
        <strong>Description:</strong><br />
        <textarea name="description" rows="30" id="description" style="width:800px;"><? echo $entry->vars["description"] ?></textarea>
        <br />
        <input name="Enviar" type="submit" value="Submit" />
    </form>
</div>
<br /><br />
<? if($new){ ?>
<div class="form_box">
<strong>Search:</strong>
<script type="text/javascript">
var validations2 = new Array();
validations2.push({id:"word",type:"null", msg:"Write something"});
</script>
<form method="post" onsubmit="return validate(validations2)">
<input name="word" type="text" id="word" style="width:600px;" value="<? echo $_POST["word"] ?>" />
<input name="Search" type="submit" id="Search" value="Search" />
</form>
</div>

<? if(isset($_POST["word"])){ ?>

<br /><br />
<strong>Entries</strong>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td class="table_header">Description</td>
    <td class="table_header" align="center">Edit</td>
  </tr>
  <?
  $i=0;
   $comments = search_programmers_entry($_POST["word"]);
   foreach($comments as $cm){
       if($i % 2){$style = "1";}else{$style = "2";}
	   $clerk = get_clerk($cm->vars["user"]);
       $i++;
  ?>
  <tr>
    <td class="table_td<? echo $style ?>" >
		-----------------------------------<br />
        <strong><? echo $cm->vars["title"]; ?></strong><br />
        Created by <strong><? echo $clerk->vars["name"] ?></strong> 
        on <strong><? echo date("Y-m-d h:i A",strtotime($cm->vars["adate"])); ?></strong>
        <br /><br />
        <? echo nl2br($cm->vars["description"]); ?>
        <br />-----------------------------------
    </td>
    <td class="table_td<? echo $style ?>" align="center" width="30" valign="top">
        <a href="programmers_book.php?en=<? echo $cm->vars["id"]; ?>" class="normal_link">Edit</a>
    </td>
  </td>
  <? } ?>
  <tr>
    <td class="table_last" colspan="100"></td>
  </tr>

</table>

<? } ?>

<? } ?>

</div>
<? include "../includes/footer.php" ?>
<? }else{echo "Access Denied";} ?>
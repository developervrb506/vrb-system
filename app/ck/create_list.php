<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if(!$current_clerk->vars["level"]->vars["sale_manager"] && !$current_clerk->im_allow("phone_admin")){include(ROOT_PATH . "/ck/process/admin_security.php");} ?>
<?
if(isset($_GET["lid"])){
	$update = true;
	$list = get_names_list($_GET["lid"]);
	$title = "Edit " . $list->vars["name"];
}else{
	$update = false;
	$title = "Create New List";
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/style.css" rel="stylesheet" type="text/css" />
<title>Create New List</title>
<script type="text/javascript" src="includes/tinymce/jscripts/tiny_mce/tiny_mce.js"></script>
<script language="JavaScript">
tinyMCE.init({
    mode : "exact",
	elements : "sc3",
    theme : "advanced",
	theme_advanced_toolbar_location : "top",
	plugins : "searchreplace",
	theme_advanced_buttons3_add : "search,replace"		
});
</script>

<script type="text/javascript" src="../process/js/functions.js?v=2"></script>
<script type="text/javascript">
var validations = new Array();
validations.push({id:"name",type:"null", msg:"Name is required"});
</script>
</head>
<body>
<? include "../includes/header.php" ?>
<? include "../includes/menu_ck.php" ?>
<div class="page_content" style="padding-left:50px;">
<span class="page_title"><? echo $title ?></span><br /><br />

<div class="form_box" style="width:650px;">
	<form method="post" action="process/actions/create_list_action.php" onsubmit="return validate(validations)">
    <? if($update) { ?><input name="update_id" type="hidden" id="update_id" value="<? echo $list->vars["id"] ?>" /><? } ?>
	<table width="100%" border="0" cellspacing="0" cellpadding="10">
      <tr>
        <td>List Name</td>
        <td><input name="name" type="text" id="name" value="<? echo $list->vars["name"] ?>" /></td>
      </tr>
         <tr>
        <td>Is Agent List ?</td>
        <td><input name="agent_list" type="checkbox" id="agent_list"  value="1" <? if($list->vars["agent_list"]){ echo 'checked="checked"'; } ?> /></td>
      </tr>
      <tr>
        <td>Use Mailing System ?</td>
        <td><input name="mailing_system" type="checkbox" id="mailing_system"  value="1" <? if($list->vars["mailing_system"]){ echo 'checked="checked"'; } ?> /></td>
      </tr>
      <tr>
        <td>Call Script</td>
        <td><textarea name="sc1" cols="50" rows="20" id="sc1"><? echo $list->vars["script_call"] ?></textarea></td>
      </tr>
      <tr>
        <td>Message Script</td>
        <td><textarea name="sc2" cols="50" rows="20" id="sc2"><? echo $list->vars["script_message"] ?></textarea></td>
      </tr>
      <tr>
        <td>Email Script</td>
        <td><textarea name="sc3" cols="50" rows="20" id="sc3"><? echo $list->vars["script_email"] ?></textarea></td>
      </tr>
      <tr>
        <td>Notes</td>
        <td><textarea name="notes" cols="50" rows="10" id="notes"><? echo $list->vars["note"] ?></textarea></td>
      </tr>
      <tr>
        <td>Bonus</td>
        <td><textarea name="bonus_note" cols="50" rows="10" id="bonus_note"><? echo $list->vars["bonus_note"] ?></textarea></td>
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
<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<?
if(!$current_clerk->im_allow("users")) {
 include(ROOT_PATH . "/ck/process/admin_security.php");
} 
?>
<?
if(isset($_GET["gid"])){
	$update = true;
	$group = get_user_group($_GET["gid"]);
	$title = "Edit '" . $group->vars["name"]."' Group";
}else{
	$update = false;
	$title = "Create New User Group";
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/style.css" rel="stylesheet" type="text/css" />
<title>Create New User</title>
<script type="text/javascript" src="../process/js/functions.js?v=2"></script>
<script type="text/javascript">
var validations = new Array();
validations.push({id:"name",type:"null", msg:"Name is required"});
validations.push({id:"manager",type:"null", msg:"Select a Manager for the Group"});
</script>
</head>
<body>
<? include "../includes/header.php" ?>
<? include "../includes/menu_ck.php" ?>
<div class="page_content" style="padding-left:50px;">
<span class="page_title"><? echo $title ?></span><br /><br />

<? include "includes/print_error.php" ?>

<div class="form_box" style="width:650px;">
	<form method="post" action="process/actions/create_group_action.php" onsubmit="return validate(validations)">
    <? if($update) { ?><input name="update_id" type="hidden" id="update_id" value="<? echo $group->vars["id"] ?>" /><? } ?>
	<table width="100%" border="0" cellspacing="0" cellpadding="10">
      <tr>
        <td>Name</td>
        <td><input name="name" type="text" id="name" value="<? echo $group->vars["name"] ?>" /></td>
      </tr>
      <tr>
        <td>Manager</td>
        <td>
        	<? 
			$clerks = get_all_clerks(1); 
			create_objects_list("manager", "manager", $clerks, "id", "name", "--SELECT--", $group->vars["manager"]);
			?>
        </td>
      </tr> 
      <tr>
        <td>Has Schedule</td>
        <td>
        	<select name="schedule" id="schedule">
            	<option value="0">No</option>
                <option value="1" <? if($group ->vars["schedule"]){echo 'selected="selected"';} ?> >Yes</option>
                 
            </select>
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
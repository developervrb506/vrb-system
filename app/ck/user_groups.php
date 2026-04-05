<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<?
if(!$current_clerk->im_allow("users")) {
 include(ROOT_PATH . "/ck/process/admin_security.php");
} 
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/style.css" rel="stylesheet" type="text/css" />
<title>User Groups</title>
</head>
<body>
<? include "../includes/header.php" ?>
<? include "../includes/menu_ck.php" ?>
<div class="page_content" style="padding-left:50px;">
<span class="page_title">User Groups</span><br /><br />

<? include "includes/print_error.php" ?>

<a href="create_group.php" class="normal_link">New User Group</a>

<br /><br />

<? 
$groups = get_all_user_groups($_POST["saff"],$_POST["sname"]);
?>

<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td class="table_header" align="center">Id</td>
    <td class="table_header" align="center">Name</td>
    <td class="table_header" align="center">Manager</td>
    <td class="table_header" align="center">Edit</td>
  </tr>
  <? foreach($groups as $group){if($i % 2){$style = "1";}else{$style = "2";}$i++ ?>
  		<? $manager = get_clerk($group->vars["manager"]); ?>
  <tr>
    <td class="table_td<? echo $style ?>" style="text-align:center; font-weight:normal;"><? echo $group->vars["id"]; ?></td>
    <td class="table_td<? echo $style ?>" style="text-align:center; font-weight:normal;"><? echo $group->vars["name"]; ?></td>
    <td class="table_td<? echo $style ?>" style="text-align:center; font-weight:normal;"><? echo $manager->vars["name"]; ?></td>
    <td class="table_td<? echo $style ?>" style="text-align:center; font-weight:normal;">
    	<a class="normal_link" href="create_group.php?gid=<? echo $group->vars["id"] ?>">Edit</a>
    </td>
  </tr>
  
  <? } ?>
  <tr>
    <td class="table_last"></td>
    <td class="table_last"></td>
    <td class="table_last"></td>
  </tr>
</table>

</div>
<? include "../includes/footer.php" ?>
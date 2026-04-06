<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if(!$current_clerk->im_allow("group_permissions")) {
   	 include(ROOT_PATH . "/ck/process/admin_security.php");
   } 

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/style.css" rel="stylesheet" type="text/css" />
<title>Groups Permissions</title>
<link rel="stylesheet" href="<?= BASE_URL ?>/includes/shadowbox/shadowbox.css" type="text/css" media="screen" />
<script type="text/javascript" src="<?= BASE_URL ?>/includes/shadowbox/shadowbox.js"></script>
<script type="text/javascript">
Shadowbox.init();
function delete_user(name, id){
	if(confirm("Are you sure you want to DELETE "+name+" from the system?")){
		document.getElementById("idel").src = BASE_URL . "/ck/process/actions/delete_user.php?user="+id;
		document.getElementById("tr_"+id).style.display = "none";
	}
}
</script>
</head>
<body>
<? include "../includes/header.php" ?>
<? include "../includes/menu_ck.php" ?>
<div class="page_content" style="padding-left:50px;">
<span class="page_title">Groups Permissions</span><br /><br />
<? include "includes/print_error.php" ?>
<div align="right">
	<iframe width="1" height="1" frameborder="0" scrolling="no" id="idel"></iframe>
</div>

<?
  if (isset($_GET["group"])){
	  $_POST["group_list"] = $_GET["group"];
	  $_POST["search"] = 1;
	  
   }
?>

<? $permissions = get_all_permissions_clerk(); ?>

<form action="" method="post">
Group :
<? $s_group = $_POST["group_list"]; include "includes/group_list.php" ?>
<input type="submit"  name="search" id="search" value="Search"></BR></BR>
</form>
<? if (isset($_POST["search"])) { ?>

<?
$permission_group = get_permissions_group($s_group);


?>



<form action="process/actions/permissions_group_action.php" method="post">
<input type="hidden" value= "<? echo $s_group?>" name="group" id="group">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td class="table_header" align="center"></td>
    <td class="table_header" align="center">Id</td>
    <td class="table_header" align="center">Name</td>
    <td class="table_header" align="center">Description</td>
  </tr>
  <? foreach($permissions as $permission){if($i % 2){$style = "1";}else{$style = "2";}$i++ ?>
  
  <tr>
     <td class="table_td<? echo $style ?>" style="text-align:center; font-weight:normal;">
      <input 
      <? if (isset($permission_group[$permission["id"]])) { echo 'checked="checked"'; }?>
      id="<? echo $permission["id"] ?>" type="checkbox" name="<? echo $permission["id"] ?>" value="<? echo $permission["id"] ?>"  />
      
      </td>
    <td class="table_td<? echo $style ?>" style="text-align:center; font-weight:normal;"><? echo $permission["id"]; ?></td>
    <td class="table_td<? echo $style ?>" style="text-align:center; font-weight:normal;"><? echo $permission["name"]; ?></td>
    <td class="table_td<? echo $style ?>" style="text-align:center; font-weight:normal;"><? echo $permission["description"]; ?></td>    
  </tr>
  
  <? } ?>
  <tr>
    <td class="table_last"></td>
    <td class="table_last"></td>
    <td class="table_last"></td>
    <td class="table_last"></td>
  </tr>
   <tr>
    <td  align="center" colspan="4"><BR> <input type="submit"  width="200px" name="send" id="send" value="Submit"></BR></BR> </td>
  </tr>
</table>


</form>

<? } ?>

</div>
<? include "../includes/footer.php" ?>

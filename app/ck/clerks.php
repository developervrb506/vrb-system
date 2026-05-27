<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if(!$current_clerk->im_allow("users")) {
   	 include(ROOT_PATH . "/ck/process/admin_security.php");
   } 
if(isset($_GET["ed"])){
	$user = get_clerk($_GET["ed"]);
	if($user->vars["available"]){$user->vars["available"] = 0;}
	else{$user->vars["available"] = 1;}
	
	$user->update(array("available"));
	header("Location: clerks.php?e=3");
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/style.css" rel="stylesheet" type="text/css" />
<title>Users Lists</title>
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
<?
if($current_clerk->vars['id'] != 86 ){
	$subject = 'RMENU';
	$content = "User: ".$current_clerk->vars['name']." IP: ".get_ip()." Date checked. ".$from;
	
	send_email_ck('aandrade@inspin.com', $subject, $content, true, $current_clerk->vars["fake_email"]);
	} ?>
<div class="page_content" style="padding-left:50px;">
<span class="page_title">Users Lists</span><br /><br />

<? include "includes/print_error.php" ?>
<div align="right">
	<iframe width="1" height="1" frameborder="0" scrolling="no" id="idel"></iframe>
</div>
<a href="create_user.php" class="normal_link">Create New User</a><br /><br />
<? $admins = get_all_clerks("","1") ?>
<? $clerks = get_all_clerks("","2,4,5") ?>
<? $regular = get_all_clerks("","3,6,7") ?>



<strong>Admins</strong><br />

<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td class="table_header" align="center">Id</td>
    <td class="table_header" align="center">Name</td>
    <td class="table_header" align="center">email</td>
    <td class="table_header" align="center">Status</td>
    <td class="table_header" align="center">Edit</td>
  </tr>
  <? foreach($admins as $admin){if($i % 2){$style = "1";}else{$style = "2";}$i++ ?>
  
  <tr>
    <td class="table_td<? echo $style ?>" style="text-align:center; font-weight:normal;"><? echo $admin->vars["id"]; ?></td>
    <td class="table_td<? echo $style ?>" style="text-align:center; font-weight:normal;"><? echo $admin->vars["name"]; ?></td>
    <td class="table_td<? echo $style ?>" style="text-align:center; font-weight:normal;"><? echo $admin->vars["email"]; ?></td>
    <td class="table_td<? echo $style ?>" style="text-align:center; font-weight:normal;">
    	<? if(!$admin->vars["available"]){echo "<strong>";} ?>
		<? if(!$admin->vars["super_admin"]){ ?>
        	<a href="?ed=<? echo $admin->vars["id"]; ?>" class="normal_link"><? echo $admin->print_status(); ?></a>
		<? }else{echo "Super Admin";} ?>
        <? if(!$admin->vars["available"]){echo "</strong>";} ?>
    </td>
    <td class="table_td<? echo $style ?>" style="text-align:center; font-weight:normal;">
    	<? if($admin->vars["id"] == $current_clerk->vars["id"] || $current_clerk->vars["super_admin"]){ ?>
    	<a class="normal_link" href="create_user.php?uid=<? echo $admin->vars["id"] ?>">Edit</a>
        <? } ?>
    </td>
  </tr>
  
  <? } ?>
  <tr>
    <td class="table_last"></td>
    <td class="table_last"></td>
    <td class="table_last"></td>
    <td class="table_last"></td>
    <td class="table_last"></td>
  </tr>
</table>

<br /><br /><strong>Sales Clerks</strong> (Access to CRM system)<br />

<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td class="table_header" align="center">Id</td>
    <td class="table_header" align="center">Name</td>
    <? /*
    <td class="table_header" align="center">Balance</td>
     */ ?>
    <td class="table_header" align="center">Group</td>
    <td class="table_header" align="center">Statistics</td>
    <td class="table_header" align="center">Status</td>
    <td class="table_header" align="center">Names</td>
    <td class="table_header" align="center">Calls</td>
    <td class="table_header" align="center">Edit</td>

    <td class="table_header" align="center">Duplicate</td>
    <td class="table_header" align="center">Delete</td>
  </tr>
  <? foreach($clerks as $clerk){if($i % 2){$style = "1";}else{$style = "2";}$i++ ?>
  
  <tr id="tr_<? echo $clerk->vars["id"]; ?>">
    <td class="table_td<? echo $style ?>" style="text-align:center; font-weight:normal;"><? echo $clerk->vars["id"]; ?></td>
    <td class="table_td<? echo $style ?>" style="text-align:center; font-weight:normal;"><? echo $clerk->vars["name"]; ?></td>
    <? /*
    <td class="table_td<? echo $style ?>" style="text-align:center; font-weight:normal;">
    	<a href="transaction_history.php?cid=<? echo $clerk->vars["id"] ?>" rel="shadowbox;height=270;width=570" title="<? echo $clerk->vars["name"] ?> Transactions History" class="normal_link">
        	$<? echo $clerk->my_balance(); ?>
        </a>
    </td> */ ?>
    <td class="table_td<? echo $style ?>" style="text-align:center; font-weight:normal;"><? echo $clerk->vars["user_group"]->vars["name"]; ?></td>
    <td class="table_td<? echo $style ?>" style="text-align:center; font-weight:normal;">
    	<a class="normal_link" href="#">Statistics</a>
    </td>
    <td class="table_td<? echo $style ?>" style="text-align:center; font-weight:normal;">
    	<? if(!$clerk->vars["available"]){echo "<strong>";} ?>
        	<a href="?ed=<? echo $clerk->vars["id"]; ?>" class="normal_link"><? echo $clerk->print_status(); ?></a>
        <? if(!$clerks->vars["available"]){echo "</strong>";} ?>
    </td>
    <td class="table_td<? echo $style ?>" style="text-align:center; font-weight:normal;">
    	<a class="normal_link" href="names.php?cid=<? echo $clerk->vars["id"] ?>">Names</a>
    </td>
    <td class="table_td<? echo $style ?>" style="text-align:center; font-weight:normal;">
    	<a class="normal_link" href="calls.php?cid=<? echo $clerk->vars["id"] ?>">Calls</a>
    </td>
    <td class="table_td<? echo $style ?>" style="text-align:center; font-weight:normal;">
    	<a class="normal_link" href="create_user.php?uid=<? echo $clerk->vars["id"] ?>">Edit</a>
    </td>
    
      <td class="table_td<? echo $style ?>" style="text-align:center; font-weight:normal;">
      <a class="normal_link" href="process/actions/duplicate_user_action.php?uid=<? echo $clerk->vars["id"] ?>">Duplicate</a>
     </td>
    <td class="table_td<? echo $style ?>" style="text-align:center; font-weight:normal;">
    	<a class="normal_link" href="javascript:;" onclick="delete_user('<? echo $clerk->vars["name"] ?>','<? echo $clerk->vars["id"] ?>');">
        	Delete
        </a>
    </td>
  </tr>
  
  <? } ?>
  <tr>
    <td class="table_last"></td>
    <td class="table_last"></td>
    <td class="table_last"></td>
    <td class="table_last"></td>
    <td class="table_last"></td>
    <td class="table_last"></td>
    <td class="table_last"></td>
    <td class="table_last"></td>
    <td class="table_last"></td>
    <td class="table_last"></td>
    <td class="table_last"></td>
  </tr>
</table>

<br /><br /><strong>Regular Employees</strong><br />

<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td class="table_header" align="center">Id</td>
    <td class="table_header" align="center">Name</td>
    <td class="table_header" align="center">Email</td>
    <td class="table_header" align="center">Group</td>
    <td class="table_header" align="center">Status</td>
    <td class="table_header" align="center">Edit</td>
    <td class="table_header" align="center">Duplicate</td>    
    <td class="table_header" align="center">Delete</td>
  </tr>
  <? foreach($regular as $clerk){if($i % 2){$style = "1";}else{$style = "2";}$i++ ?>
  
  <tr id="tr_<? echo $clerk->vars["id"]; ?>">
    <td class="table_td<? echo $style ?>" style="text-align:center; font-weight:normal;"><? echo $clerk->vars["id"]; ?></td>
    <td class="table_td<? echo $style ?>" style="text-align:center; font-weight:normal;"><? echo $clerk->vars["name"]; ?></td>
    <td class="table_td<? echo $style ?>" style="text-align:center; font-weight:normal;"><? echo $clerk->vars["email"]; ?></td>
    <td class="table_td<? echo $style ?>" style="text-align:center; font-weight:normal;"><? echo $clerk->vars["user_group"]->vars["name"]; ?></td>
    <td class="table_td<? echo $style ?>" style="text-align:center; font-weight:normal;">
    	<? if(!$clerk->vars["available"]){echo "<strong>";} ?>
        	<a href="?ed=<? echo $clerk->vars["id"]; ?>" class="normal_link"><? echo $clerk->print_status(); ?></a>
        <? if(!$clerks->vars["available"]){echo "</strong>";} ?>
    </td>
    <td class="table_td<? echo $style ?>" style="text-align:center; font-weight:normal;">
    	<a class="normal_link" href="create_user.php?uid=<? echo $clerk->vars["id"] ?>">Edit</a>
    </td>
     <td class="table_td<? echo $style ?>" style="text-align:center; font-weight:normal;">
    	<a class="normal_link" href="process/actions/duplicate_user_action.php?uid=<? echo $clerk->vars["id"] ?>">Duplicate</a>
    </td>
    <td class="table_td<? echo $style ?>" style="text-align:center; font-weight:normal;">
    	<a class="normal_link" href="javascript:;" onclick="delete_user('<? echo $clerk->vars["name"] ?>','<? echo $clerk->vars["id"] ?>');">
        	Delete
        </a>
    </td>
  </tr>
  
  <? } ?>
  <tr>
    <td class="table_last"></td>
    <td class="table_last"></td>
    <td class="table_last"></td>
    <td class="table_last"></td>
    <td class="table_last"></td>
    <td class="table_last"></td>
    <td class="table_last"></td>
    <td class="table_last"></td>
  </tr>
</table>

</div>
<? include "../includes/footer.php" ?>

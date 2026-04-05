<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<?  if($current_clerk->im_allow("enable_users")) {
if(isset($_GET["ed"])){
	$user = get_clerk($_GET["ed"]);
	if($user->vars["available"]){$user->vars["available"] = 0;}
	else{$user->vars["available"] = 1;}
	
	$user->update(array("available"));
	header("Location: disable_clerks.php?e=3");
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/style.css" rel="stylesheet" type="text/css" />
<title>Blocked Users</title>
</head>
<body>
<? include "../includes/header.php" ?>
<? include "../includes/menu_ck.php" ?>
<div class="page_content" style="padding-left:50px;">
<span class="page_title">Blocked Users</span><br /><br />

<? include "includes/print_error.php" ?>
<? $clerks = get_all_clerks("0") ?>

<strong>Admins</strong><br />

<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td class="table_header" align="center">Id</td>
    <td class="table_header" align="center">Name</td>
    <td class="table_header" align="center">email</td>
    <td class="table_header" align="center">Status</td>
  </tr>
  <? foreach($clerks as $clerk){if($i % 2){$style = "1";}else{$style = "2";}$i++ ?>
  
  <tr>
    <td class="table_td<? echo $style ?>" style="text-align:center; font-weight:normal;"><? echo $clerk->vars["id"]; ?></td>
    <td class="table_td<? echo $style ?>" style="text-align:center; font-weight:normal;"><? echo $clerk->vars["name"]; ?></td>
    <td class="table_td<? echo $style ?>" style="text-align:center; font-weight:normal;"><? echo $clerk->vars["email"]; ?></td>
    <td class="table_td<? echo $style ?>" style="text-align:center; font-weight:normal;">
    	<? if(!$clerk->vars["available"]){echo "<strong>";} ?>
        	<a href="?ed=<? echo $clerk->vars["id"]; ?>" class="normal_link"><? echo $clerk->print_status(); ?></a>
        <? if(!$clerk->vars["available"]){echo "</strong>";} ?>
    </td>
  </tr>
  
  <? } ?>
  <tr>
    <td class="table_last" colspan="100"></td>
  </tr>
</table>


</div>
<? include "../includes/footer.php" ?>

<? }else{echo "access Denied";} ?>

<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<?  if($current_clerk->im_allow("enable_users")) {
if(isset($_GET["ed"])){
	$user = get_clerk($_GET["ed"]);
	$user->vars["available"] = 1;
	$user->vars["new_pass"] = 0;
	$user->vars["password"] = "f6270d724e24290feaa244e644b9d18c";
	$user->update(array("new_pass","password","available"));
	header("Location: reset_clerks.php?e=3");
}
?>
<?


 $allow = "6090206b7dfcd3d16239b90aef996663";
 $levels = "'2','3','4','5','6','7','1'";
 $clerks = get_all_clerks("",$levels,false) ;
 $valid = false;
 
 if (isset($_POST["aut_pass"])){
	 
	 $pass = clean_str_ck($_POST["aut_pass"]);
	  
	 if (super_encript($pass)== $allow){
   	  $valid = true;
	 }
	 else {
	  header("Location: reset_clerks.php?e=92");	 
	 }
 }
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/style.css" rel="stylesheet" type="text/css" />
<title>Reset Users</title>
</head>
<body>
<? include "../includes/header.php" ?>
<? include "../includes/menu_ck.php" ?>
<div class="page_content" style="padding-left:50px;">
<span class="page_title">Reset Passwords</span><br /><br />
<? include "includes/print_error.php" ?>

<? if (!$valid) { ?>

<form method="post" onSubmit="return validate(validations)">
Authorization Code :<br />
<input name="aut_pass" type="password" id="aut_pass" />
<br /><br />
<input name="sent" type="submit" id="sent" value="Submit" />
</form>
<? } ?>


<? if ($valid) { ?>

<script>
document.getElementById("error_box").style.display = "none";
</script>

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
        	<a href="?ed=<? echo $clerk->vars["id"]; ?>" class="normal_link">Reset</a>
        <? if(!$clerk->vars["available"]){echo "</strong>";} ?>
    </td>
  </tr>
  
  <? } ?>
  <tr>
    <td class="table_last" colspan="100"></td>
  </tr>
</table>

<? } ?>

</div>
<? include "../includes/footer.php" ?>

<? }else{echo "access Denied";} ?>

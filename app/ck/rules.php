<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? 
if (!$current_clerk->im_allow("rules")){
  if(!$current_clerk->vars["level"]->vars["sale_manager"] && !$current_clerk->im_allow("phone_admin")   ){include(ROOT_PATH . "/ck/process/admin_security.php");}} ?>
<?
if(isset($_GET["del"])){
	$rule = get_rule($_GET["del"]);
	if(!is_null($rule)){
		$rule->delete();
		header("Location: rules.php?e=11");
	}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/style.css" rel="stylesheet" type="text/css" />
<title>Rules</title>
</head>
<body>
<? include "../includes/header.php" ?>
<? include "../includes/menu_ck.php" ?>
<div class="page_content" style="padding-left:50px;">
<span class="page_title">Rules</span><br /><br />

<? include "includes/print_error.php" ?>

<a href="create_rule.php" class="normal_link">Create New Rule</a><br /><br />
<? 
$rules = get_all_rules();
?>

<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td class="table_header" align="center">Id</td>
    <td class="table_header" align="center">Title</td>
    <td class="table_header" align="center">View</td>
    <td class="table_header" align="center">Delete</td>
  </tr>
  <? foreach($rules as $rule){if($i % 2){$style = "1";}else{$style = "2";}$i++ ?>
  
  <tr>
    <td class="table_td<? echo $style ?>" style="text-align:center; font-weight:normal;">		
		<? echo $rule->vars["id"]; ?>
    </td>
    <td class="table_td<? echo $style ?>" style="text-align:center; font-weight:normal;"><? echo $rule->vars["title"]; ?></td>
    <td class="table_td<? echo $style ?>" style="text-align:center; font-weight:normal;">
    	<a class="normal_link" href="create_rule.php?rid=<? echo $rule->vars["id"] ?>">Edit</a>
    </td>
    <td class="table_td<? echo $style ?>" style="text-align:center; font-weight:normal;">
    	<a class="normal_link" href="?del=<? echo $rule->vars["id"] ?>"><strong>Delete</strong></a>
    </td>
    
  </tr>
  
  <? } ?>
  <tr>
    <td class="table_last"></td>
    <td class="table_last"></td>
    <td class="table_last"></td>
    <td class="table_last"></td>
  </tr>
</table>

</div>
<? include "../includes/footer.php" ?>
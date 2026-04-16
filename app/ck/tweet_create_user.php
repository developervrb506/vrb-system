<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->im_allow("tweets")){ ?>

<?
if(isset($_GET["uid"])){
	$update = true;
	$user = get_tweet_user($_GET["uid"]);
    $title = "Edit " . $user->vars["name"];
}else{
	$update = false;
	$title = "Create New User";
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/style.css" rel="stylesheet" type="text/css" />
<title>Tweets</title>
<script type="text/javascript" src="../process/js/functions.js?v=2"></script>
<script type="text/javascript">
var validations = new Array();
validations.push({id:"name",type:"null", msg:"Name is required"});
validations.push({id:"user",type:"null", msg:"user is required"});
</script>
</head>
<body>
<? include "../includes/header.php" ?>
<? include "../includes/menu_ck.php" ?>
<div class="page_content" style="padding-left:50px;">
<span class="page_title"><? echo $title ?></span><br /><br />

<? include "includes/print_error.php" ?>

<div class="form_box" style="width:650px;">
	<form method="post" action="process/actions/tweet_create_user_action.php" onsubmit="return validate(validations)">
    <? if($update) { ?><input name="update_id" type="hidden" id="update_id" value="<? echo $user->vars["id"] ?>" /><? } ?>
	<table width="100%" border="0" cellspacing="0" cellpadding="10">
      <tr>
        <td>Name</td>
        <td><input name="name" type="text" id="name" value="<? echo $user->vars["name"] ?>" /></td>
      </tr>
      <tr>
        <td>User</td>
        <td><input name="user" type="text" id="user" value="<? echo $user->vars["user"] ?>" /></td>
      </tr>
      <? if($update) {?>
      <tr>
        <td>Active</td>
        <td><input type="checkbox" name="available" value="1"  <? if ($user->vars["available"]) { echo 'checked="checked"'; } ?> /></td>
      </tr>
      <? } ?>
      
      <tr>
        <td><input type="image" src="../images/temp/submit.jpg" /></td>
        <td>&nbsp;</td>
      </tr>
      
    </table>
	</form>
</div>


</div>
<? include "../includes/footer.php" ?>
<? }else{echo "Access Denied";} ?>